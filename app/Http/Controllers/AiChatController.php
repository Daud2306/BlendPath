<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LucianoTonet\GroqLaravel\Facades\Groq;
use App\Models\Modul;
use App\Models\Progress; // sesuaikan jika nama modelnya beda

class AiChatController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'nullable|array',
        ]);

        $user = Auth::user();

        $modulContext    = $this->buildModulContext();
        $progressContext = $this->buildProgressContext($user);

        $systemPrompt = "Kamu adalah asisten AI untuk platform LMS BlendPath, platform belajar Blender 3D.
Tugasmu HANYA membantu pengguna seputar topik berikut:
- Software Blender (modeling, sculpting, rigging, animation, rendering, compositing, geometry nodes, dll)
- Konsep 3D secara umum (mesh, UV, material, lighting, dll)
- Tips & trik penggunaan Blender
- Troubleshooting masalah di Blender
- Materi pembelajaran yang ada di platform BlendPath

Nama pengguna yang sedang chat adalah: {$user->name}.
Jawab dalam Bahasa Indonesia yang ramah, jelas, dan mudah dipahami.

═══════════════════════════════
DATA KURIKULUM BLENDPATH:
═══════════════════════════════
{$modulContext}

═══════════════════════════════
PROGRESS BELAJAR {$user->name}:
═══════════════════════════════
{$progressContext}

CARA MENJAWAB:
- Jika pertanyaan tentang modul/materi BlendPath → gunakan DATA KURIKULUM sebagai referensi utama, lalu ELABORASI dengan pengetahuanmu
- Jika data kurikulum kurang lengkap → tetap jelaskan lebih rinci berdasarkan pengetahuanmu tentang Blender
- Jika pertanyaan umum tentang Blender → jawab bebas dari pengetahuanmu
- JANGAN tampilkan data mentah ke user, selalu jelaskan dengan bahasa yang mudah dipahami
- Tambahkan tips dan penjelasan tambahan yang relevan

ATURAN GAMBAR - WAJIB DIIKUTI:
Jika penjelasan membutuhkan gambar, gunakan format: [IMG:URL_GAMBAR_DISINI]
- Hanya dari docs.blender.org atau upload.wikimedia.org
- URL HARUS diakhiri .jpg, .png, atau .gif
- JANGAN mengarang URL, jika tidak yakin jangan sertakan gambar

PENTING: Jika pengguna bertanya di luar topik Blender dan 3D, tolak dengan sopan:
'Maaf {$user->name}, aku hanya bisa membantu seputar Blender dan 3D ya! 😊'";

        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
        ];

        if ($request->history) {
            foreach (array_slice($request->history, -10) as $h) {
                $messages[] = [
                    'role'    => $h['role'],
                    'content' => $h['content'],
                ];
            }
        }

        $messages[] = ['role' => 'user', 'content' => $request->message];

        try {
            $response = Groq::chat()->completions()->create([
                'model'       => env('GROQ_MODEL', 'llama-3.3-70b-versatile'),
                'messages'    => $messages,
                'max_tokens'  => 1024,
                'temperature' => 0.7,
            ]);

            return response()->json([
                'success' => true,
                'reply'   => $response['choices'][0]['message']['content'],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'reply'   => 'Maaf, terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function buildModulContext(): string
    {
        $moduls = Modul::with('submoduls')->orderBy('sort_order')->get();

        if ($moduls->isEmpty()) {
            return 'Belum ada modul tersedia.';
        }

        $context = '';
        foreach ($moduls as $modul) {
            $context .= "MODUL {$modul->sort_order}: {$modul->judul}\n";
            $context .= "Deskripsi: {$modul->deskripsi}\n";

            if ($modul->submoduls->isNotEmpty()) {
                $context .= "Sub-materi:\n";
                foreach ($modul->submoduls as $sub) {
                    $context .= "- [{$sub->sort_order}] {$sub->judul}\n";
                    if ($sub->konten) {
                        // Strip HTML tags dari konten, ambil 200 karakter pertama
                        $plain = strip_tags($sub->konten);
                        $short = mb_strlen($plain) > 200
                            ? mb_substr($plain, 0, 200) . '...'
                            : $plain;
                        $context .= "  Konten: {$short}\n";
                    }
                }
            }
            $context .= "\n";
        }

        return $context;
    }

    private function buildProgressContext($user): string
    {
        try {
            $progresses = \App\Models\Progress::with('submodul.modul')
                ->where('user_id', $user->id)
                ->where('is_completed', 1)
                ->get();

            if ($progresses->isEmpty()) {
                return "{$user->name} belum menyelesaikan materi apapun.";
            }

            // Group by modul
            $grouped = $progresses->groupBy(fn($p) => $p->submodul->modul->judul);

            $context  = "Total selesai: {$progresses->count()} submodul\n";
            $context .= "Rincian per modul:\n";

            foreach ($grouped as $modulJudul => $items) {
                $context .= "\n{$modulJudul} ({$items->count()} submodul selesai):\n";
                foreach ($items as $p) {
                    $context .= "  ✓ {$p->submodul->judul}\n";
                }
            }

            return $context;
        } catch (\Exception $e) {
            return 'Data progress tidak tersedia.';
        }
    }
}
