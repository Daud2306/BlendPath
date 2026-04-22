@props(['items' => []])

@php
    if (empty($items)) {
        $currentRoute = Route::currentRouteName();
        $params = Route::current()->parameters();

        $map = [
            'admin.dashboard' => ['Dashboard', null],
            'admin.moduls.index' => ['Modul', 'admin.dashboard'],
            'admin.moduls.create' => ['Tambah Modul', 'admin.moduls.index'],
            'admin.moduls.edit' => ['Edit Modul', 'admin.moduls.index'],
            'admin.course.builder' => ['Course Builder', 'admin.dashboard'],
            'admin.moduls.submoduls.create' => ['Tambah Submodul', 'admin.course.builder'],
            'admin.moduls.submoduls.edit' => ['Edit Submodul', 'admin.course.builder'],
            'admin.moduls.submoduls.show' => ['Detail Submodul', 'admin.course.builder'],
            'admin.moduls.submoduls.quiz.create' => ['Buat Quiz', 'admin.course.builder'],
            'admin.moduls.submoduls.quiz.edit' => ['Edit Quiz', 'admin.course.builder'],
            'admin.moduls.submoduls.quiz.show' => ['Detail Quiz', 'admin.course.builder'],
            'admin.diskusi.index' => ['Diskusi', 'admin.dashboard'],
            'admin.diskusi.show' => ['Detail Diskusi', 'admin.diskusi.index'],
            'admin.showcase.index' => ['Showcase', 'admin.dashboard'],
            'admin.showcase.show' => ['Detail Showcase', 'admin.showcase.index'],
            'admin.users.index' => ['Pengguna', 'admin.dashboard'],
            'admin.users.create' => ['Tambah Pengguna', 'admin.users.index'],
            'admin.users.edit' => ['Edit Pengguna', 'admin.users.index'],
            'admin.monitoring.index' => ['Monitoring', 'admin.dashboard'],
            'admin.tanyas.index' => ['Pertanyaan', 'admin.dashboard'],
            'admin.jawabs.index' => ['Jawaban', 'admin.dashboard'],
        ];

        $breadcrumbs = [];
        $route = $currentRoute;

        while ($route && isset($map[$route])) {
            [$label, $parent] = $map[$route];

            // Ubah label berdasarkan parameter
            if ($route === 'admin.moduls.edit' && isset($params['modul'])) {
                $label = 'Edit: ' . ($params['modul']->judul ?? 'Modul');
            }
            if ($route === 'admin.moduls.submoduls.edit' && isset($params['submodul'])) {
                $label = 'Edit: ' . ($params['submodul']->judul ?? 'Submodul');
            }
            if ($route === 'admin.moduls.submoduls.show' && isset($params['submodul'])) {
                $label = $params['submodul']->judul ?? 'Detail Submodul';
            }
            if ($route === 'admin.moduls.submoduls.quiz.edit' && isset($params['quiz'])) {
                $label = 'Edit Quiz: ' . ($params['quiz']->judul_quiz ?? '');
            }
            if ($route === 'admin.moduls.submoduls.quiz.show' && isset($params['quiz'])) {
                $label = $params['quiz']->judul_quiz ?? 'Detail Quiz';
            }
            if ($route === 'admin.diskusi.show' && isset($params['tanya'])) {
                $label = 'Detail Pertanyaan';
            }
            if ($route === 'admin.showcase.show' && isset($params['showcase'])) {
                $label = $params['showcase']->judul ?? 'Detail Showcase';
            }
            if ($route === 'admin.users.edit' && isset($params['user'])) {
                $label = 'Edit: ' . ($params['user']->name ?? 'Pengguna');
            }

            array_unshift($breadcrumbs, [
                'label' => $label,
                'url' => $route ? route($route, $params) : null,
                'active' => $route === $currentRoute,
            ]);

            $route = $parent;
        }

        $items = $breadcrumbs;
    }
@endphp

@if (count($items) > 0)
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            @foreach ($items as $crumb)
                @if ($crumb['active'])
                    <li class="breadcrumb-item active" aria-current="page">{{ $crumb['label'] }}</li>
                @else
                    <li class="breadcrumb-item"><a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a></li>
                @endif
            @endforeach
        </ol>
    </nav>
@endif
