<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modul;
use App\Models\Submodul;
use App\Models\Quiz;
use App\Models\MiniProject;
use App\Models\Resource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ModulController extends Controller
{
    // =========================================================================
    // CRUD standar Modul
    // =========================================================================

    public function index()
    {
        $moduls = Modul::orderBy('sort_order')->paginate(10);
        return view('admin.moduls.index', compact('moduls'));
    }

    public function create()
    {
        return view('admin.moduls.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'      => 'required|string|max:255',
            'deskripsi'  => 'required|string',
            'gambar'     => 'nullable|image',
        ]);

        $maxOrder = Modul::max('sort_order') ?? 0;
        $data['sort_order'] = $maxOrder + 1;

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('moduls', 'public');
        }

        Modul::create($data);

        return redirect()->route('admin.moduls.index')->with('success', 'Modul berhasil dibuat.');
    }

    public function show(Modul $modul)
    {
        $submoduls = $modul->submoduls()->orderBy('sort_order')->get();
        return view('admin.submoduls.index', compact('modul', 'submoduls'));
    }

    public function edit(Modul $modul)
    {
        return view('admin.moduls.edit', compact('modul'));
    }

    public function update(Request $request, Modul $modul)
    {
        $request->validate([
            'judul'      => 'required|string|max:255',
            'deskripsi'  => 'required|string',
            'gambar'     => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['judul', 'deskripsi']);

        if ($request->hasFile('gambar')) {
            if ($modul->gambar) {
                Storage::disk('public')->delete($modul->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('moduls', 'public');
        }

        $modul->update($data);

        return redirect()->route('admin.moduls.index')
            ->with('success', 'Modul berhasil diperbarui!');
    }

    public function destroy(Request $request, Modul $modul)
    {
        if ($modul->gambar) {
            Storage::disk('public')->delete($modul->gambar);
        }
        $modul->delete();

        return redirect()->route('admin.moduls.index')->with('success', 'Modul berhasil dihapus.');
    }

    // =========================================================================
    // Course Builder — tampilan utama
    // =========================================================================

    public function builder()
    {
        $moduls = Modul::with([
            'submoduls',
            'submoduls.quizzes.questions',
            'submoduls.miniProjects',
        ])
            ->orderBy('sort_order')
            ->get();

        $modulesData = $moduls->map(function ($modul) {
            return [
                'id'         => $modul->id,
                'title'      => $modul->judul,
                'submodules' => $modul->submoduls->map(function ($sub) {
                    return [
                        'id'           => $sub->id,
                        'title'        => $sub->judul,
                        'quizzes'      => $sub->quizzes->map(function ($quiz) {
                            return [
                                'id'              => $quiz->id,
                                'title'           => $quiz->judul_quiz,
                                'questions_count' => $quiz->questions->count(),
                                'questions'       => $quiz->questions->map(fn($q) => [
                                    'id'      => $q->id,
                                    'text'    => $q->pertanyaan,
                                    'options' => $q->pilihan_jawaban,
                                    'correct' => $q->jawaban_benar,
                                    'poin'    => $q->poin,
                                ])->values(),
                            ];
                        })->values(),
                        'miniProjects' => $sub->miniProjects->map(fn($p) => [
                            'id'               => $p->id,
                            'title'            => $p->judul,
                            'description'      => $p->deskripsi,
                            'passing_criteria' => $p->passing_criteria,
                        ])->values(),
                    ];
                })->values(),
            ];
        });

        return view('admin.moduls.builder', compact('modulesData'));
    }

    // =========================================================================
    // Course Builder — AJAX: simpan urutan (reorder)
    // =========================================================================

    public function reorder(Request $request)
    {
        $request->validate([
            'modules'                  => 'required|array',
            'modules.*.id'             => 'required|integer|exists:moduls,id',
            'modules.*.order'          => 'required|integer|min:1',
            'modules.*.submodules'     => 'nullable|array',
            'modules.*.submodules.*.id'    => 'required|integer|exists:submoduls,id',
            'modules.*.submodules.*.order' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->modules as $modData) {
                Modul::where('id', $modData['id'])->update(['sort_order' => $modData['order']]);

                foreach ($modData['submodules'] ?? [] as $subData) {
                    Submodul::where('id', $subData['id'])->update(['sort_order' => $subData['order']]);
                }
            }
        });

        return response()->json(['success' => true]);
    }

    // =========================================================================
    // Course Builder — AJAX: hapus submodul
    // =========================================================================

    public function builderDestroySubmodul(Submodul $submodul)
    {
        $submodul->delete();
        return response()->json(['success' => true]);
    }

    // =========================================================================
    // Course Builder — AJAX: hapus quiz
    // =========================================================================

    public function builderDestroyQuiz(Quiz $quiz)
    {
        $quiz->delete();
        return response()->json(['success' => true]);
    }

    // =========================================================================
    // Course Builder — AJAX: simpan mini project baru
    // =========================================================================

    public function builderStoreMiniProject(Request $request)
    {
        $data = $request->validate([
            'submodul_id'      => 'required|integer|exists:submoduls,id',
            'judul'            => 'required|string|max:255',
            'deskripsi'        => 'nullable|string',
            'passing_criteria' => 'nullable|string',
        ]);

        // sort_order = max + 1 dalam submodul tersebut
        $maxOrder = MiniProject::where('submodul_id', $data['submodul_id'])->max('sort_order') ?? 0;
        $data['sort_order'] = $maxOrder + 1;

        $project = MiniProject::create($data);

        return response()->json([
            'success' => true,
            'project' => $project,
        ]);
    }

    // =========================================================================
    // Course Builder — AJAX: hapus mini project
    // =========================================================================

    public function builderDestroyMiniProject(MiniProject $miniProject)
    {
        $miniProject->delete();
        return response()->json(['success' => true]);
    }

    // =========================================================================
    // Course Builder — AJAX: simpan video YouTube/Vimeo ke tabel resources
    // =========================================================================

    public function storeSubmodulVideo(Request $request)
    {
        $request->validate([
            'submodul_id' => 'required|integer|exists:submoduls,id',
            'embed_url'   => 'required|url',
        ]);

        // Pastikan embed URL berasal dari YouTube atau Vimeo
        $url = $request->embed_url;
        $allowed = ['youtube.com/embed/', 'player.vimeo.com/video/'];
        $isAllowed = collect($allowed)->contains(fn($domain) => str_contains($url, $domain));

        if (!$isAllowed) {
            return response()->json(['success' => false, 'message' => 'URL tidak valid. Hanya YouTube dan Vimeo yang diizinkan.'], 422);
        }

        $resource = Resource::create([
            'resourceable_id'   => $request->submodul_id,
            'resourceable_type' => Submodul::class,
            'path'              => $url,
            'type'              => 'video_link',
        ]);

        return response()->json(['success' => true, 'resource' => $resource]);
    }

    // =========================================================================
    // Course Builder — AJAX: hapus resource (video / gambar)
    // =========================================================================

    public function deleteResource(Resource $resource)
    {
        $resource->delete(); // booted() di Resource model auto-delete file dari storage
        return response()->json(['success' => true]);
    }
}
