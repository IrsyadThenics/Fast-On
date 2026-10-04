<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'FAST ON')</title>
    <style>
        * { box-sizing: border-box; }
        body { margin:0; font-family: system-ui, Arial, sans-serif; background:#eef3f8; color:#223; }
        .layout { display:flex; min-height:100vh; }
        aside { width:230px; background:#0b3d6b; color:#fff; padding:20px 0; flex-shrink:0; }
        aside h2 { margin:0 20px 4px; font-size:20px; }
        aside .role { margin:0 20px 20px; font-size:13px; color:#b9d3ea; }
        aside a { display:block; padding:10px 20px; color:#dbe8f5; text-decoration:none; font-size:14px; }
        aside a:hover { background:#0f4d87; }
        aside a.active { background:#0b5ea8; color:#fff; font-weight:600; }
        .content { flex:1; display:flex; flex-direction:column; }
        header { background:#fff; padding:14px 24px; display:flex; justify-content:space-between;
                 align-items:center; box-shadow:0 1px 4px rgba(0,0,0,.06); }
        main { padding:24px; }
        .box { background:#fff; padding:20px; border-radius:10px; margin-bottom:16px; }
        .grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(200px,1fr)); gap:14px; }
        .card { background:#fff; padding:18px; border-radius:10px; text-decoration:none; color:#0b3d6b;
                border:1px solid #d6e2ee; font-weight:600; }
        .card:hover { border-color:#0b5ea8; }
        button { padding:8px 14px; border:0; border-radius:6px; background:#c0392b; color:#fff; cursor:pointer; }
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
                    {{ $m['label'] }}
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
</body>
</html>