<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'FAST ON')</title>
    <style>
        * { box-sizing: border-box; }
        html { overflow-x:hidden; }
        body { margin:0; font-family: system-ui, Arial, sans-serif; background:#eef3f8; color:#223; }
        .layout { display:flex; min-height:100vh; }
        aside { width:230px; background:#0b3d6b; color:#fff; padding:20px 0; flex-shrink:0; }
        aside h2 { margin:0 20px 4px; font-size:20px; }
        aside .role { margin:0 20px 20px; font-size:13px; color:#b9d3ea; }
        aside a { display:block; padding:10px 20px; color:#dbe8f5; text-decoration:none; font-size:14px; }
        aside a:hover { background:#0f4d87; }
        aside a.active { background:#0b5ea8; color:#fff; font-weight:600; }
        .content { flex:1; min-width:0; display:flex; flex-direction:column; }
        header { min-height:58px; background:#fff; padding:12px 24px; display:flex; justify-content:space-between;
                 align-items:center; gap:14px; box-shadow:0 1px 4px rgba(0,0,0,.06); }
        header strong { color:#123e65; font-size:15px; }
        main { width:100%; padding:22px 24px 30px; }
        .box { min-width:0; background:#fff; padding:20px; border:1px solid #e0e9f1; border-radius:10px; margin-bottom:16px; box-shadow:0 2px 8px rgba(18,62,101,.035); }
        .grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(200px,1fr)); gap:14px; }
        .card { background:#fff; padding:18px; border-radius:10px; text-decoration:none; color:#0b3d6b;
                border:1px solid #d6e2ee; font-weight:600; }
        .card:hover { border-color:#0b5ea8; }
        button { padding:8px 14px; border:0; border-radius:6px; background:#c0392b; color:#fff; cursor:pointer; }
        main { min-width:0; }
        .scroll { width:100%; max-width:100%; overflow-x:auto; overflow-y:visible; border:1px solid #d6e2ee; border-radius:9px; background:#fff; }
        .tabel { width:max-content; min-width:100%; border-collapse:separate; border-spacing:0; color:#223; font-size:13px; line-height:1.35; }
        .tabel th, .tabel td { padding:10px 12px; border-right:1px solid #e1e8ef; border-bottom:1px solid #e1e8ef; text-align:left; vertical-align:middle; white-space:nowrap; }
        .tabel th:last-child, .tabel td:last-child { border-right:0; }
        .tabel thead th { position:sticky; top:0; z-index:2; background:#0b3d6b; color:#fff; font-size:12px; font-weight:700; letter-spacing:.02em; text-transform:uppercase; }
        .tabel thead th.grup { background:#0b4d86; text-align:center; }
        .tabel thead th.sub { background:#0f5b99; text-align:center; font-size:11px; }
        .tabel tbody tr:nth-child(even) { background:#f7fbff; }
        .tabel tbody tr:hover { background:#eaf4fc; }
        .tabel tbody tr:last-child td { border-bottom:0; }
        .tabel td b { color:#0b3d6b; }
        .tabel .ikon-dtl, .tabel .detail-link { display:inline-flex; align-items:center; justify-content:center; min-width:34px; min-height:30px; padding:5px 9px; border-radius:5px; background:#c0392b; color:#fff; text-decoration:none; }
        .tabel .ikon-syarat { min-width:32px; min-height:28px; padding:4px 8px; border-radius:5px; background:#e8eef5; color:#0b3d6b; }
        .kartu-kaki { margin-top:12px; color:#637487; font-size:13px; }
        @media (max-width:800px) { main { padding:14px; } .box { padding:14px; } .tabel th, .tabel td { padding:8px 10px; } }
        .kartu-judul, .section-head { display:flex; align-items:center; justify-content:space-between; gap:12px; }
        .kartu-judul { margin-bottom:14px; color:#0b3d6b; font-weight:700; }
        .pill { display:inline-flex; align-items:center; min-height:24px; padding:3px 9px; border-radius:12px; background:#eaf4fc; color:#0b3d6b; font-size:12px; font-weight:600; }
        form.filter, form.saring { display:flex; align-items:center; flex-wrap:wrap; gap:8px; }
        form.filter input, form.filter select, form.saring input, form.saring select { min-height:34px; padding:7px 9px; border:1px solid #b9c7d5; border-radius:5px; background:#fff; }
        button, .btn { min-height:34px; font-size:13px; font-weight:600; }
        a { color:#0b5ea8; }
        @media (max-width:900px) { aside { width:190px; } main { padding:18px; } }
        @media (max-width:650px) {
            .layout { display:block; }
            aside { width:100%; padding:12px 0 8px; }
            aside h2 { display:inline-block; margin-right:10px; }
            aside .role { display:inline-block; margin:0 12px 0 0; }
            aside a { display:inline-block; padding:8px 10px; font-size:12px; }
            header { padding:10px 14px; }
            main { padding:12px; }
            .kartu-judul, .section-head { align-items:flex-start; flex-direction:column; }
            .filter { align-items:stretch; }
            .filter input, .filter select, .filter button, .filter a { width:100%; }
        }
    </style>
</head>
<body>
<div class="layout">
    <aside>
        <h2>FAST ON</h2>
        <div class="role">{{ auth()->user()->role?->name ?? auth()->user()->user_id }}</div>

        @foreach (config('menu') as $m)
            @can($m['permission'])
                <a href="{{ route($m['route']) }}"
                   class="{{ request()->routeIs($m['route']) ? 'active' : '' }}">
                    {{ $m['label'] }}@if ($m['route'] === 'notifikasi' && auth()->check()) <span class="notif-badge">{{ \App\Models\AppNotification::where('user_id', auth()->id())->whereNull('read_at')->count() }}</span>@endif
                </a>
            @endcan
        @endforeach
    </aside>

    <div class="content">
        <header>
            <strong>@yield('judul', 'FAST ON')</strong>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Keluar</button>
            </form>
        </header>
        <main>
            @yield('isi')
        </main>
    </div>
</div>
<style>.notif-badge{display:inline-block;min-width:18px;margin-left:6px;padding:2px 5px;border-radius:10px;background:#c0392b;color:#fff;font-size:11px;text-align:center}</style>
</body>
</html>
