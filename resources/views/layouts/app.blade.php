<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'FAST ON')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        html { overflow-x:hidden; }
        body { margin:0; font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif; background:#f6f8fb; color:#263746; }
        .layout { display:flex; min-height:100vh; }
        aside { width:230px; background:#fff; color:#16324b; padding:20px 0; flex-shrink:0; border-right:1px solid #e5ebf1; }
        aside h2 { margin:0 20px 4px; font-size:18px; letter-spacing:.02em; color:#005baa; }
        aside .role { margin:0 20px 20px; font-size:12px; color:#7890a4; }
        aside a { display:block; margin:2px 10px; padding:9px 10px; border-radius:6px; color:#587083; text-decoration:none; font-size:13px; }
        aside a:hover { background:#eef7fd; color:#005baa; }
        aside a.active { position:relative; background:#e7f3fb; color:#005baa; font-weight:700; }
        aside a.active::before { content:""; position:absolute; left:0; top:6px; bottom:6px; width:3px; border-radius:0 3px 3px 0; background:#f4c300; }
        .content { flex:1; min-width:0; display:flex; flex-direction:column; }
        header { min-height:58px; background:linear-gradient(90deg,#fff 0%,#fbfdff 100%); padding:12px 24px; display:flex; justify-content:space-between;
                 align-items:center; gap:14px; border-bottom:1px solid #e5ebf1; }
        .header-title { display:flex; align-items:center; gap:10px; }
        .menu-toggle { display:none; padding:6px 9px; background:#eaf3fa; color:#005baa; font-size:18px; line-height:1; }
        header strong { color:#005baa; font-size:15px; }
        main { width:100%; padding:22px 24px 30px; }
        .box { min-width:0; background:#fff; padding:20px; border:1px solid #e3eaf0; border-radius:10px; margin-bottom:16px; box-shadow:0 4px 16px rgba(0,91,170,.04); transition:box-shadow .2s ease, transform .2s ease; }
        .box:hover { box-shadow:0 7px 22px rgba(0,91,170,.08); }
        .grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(200px,1fr)); gap:14px; }
        .card { background:#fff; padding:18px; border-radius:10px; text-decoration:none; color:#0b3d6b;
                border:1px solid #d6e2ee; font-weight:600; }
        .card { transition:transform .2s ease, box-shadow .2s ease, border-color .2s ease; }
        .card:hover { border-color:#0b5ea8; transform:translateY(-2px); box-shadow:0 7px 18px rgba(0,91,170,.1); }
        button { padding:8px 14px; border:0; border-radius:5px; background:#005baa; color:#fff; cursor:pointer; transition:background .2s ease, transform .2s ease, box-shadow .2s ease; }
        button:hover, .btn:hover { background:#004985; box-shadow:0 3px 8px rgba(0,91,170,.18); transform:translateY(-1px); }
        main { min-width:0; }
        .scroll { width:100%; max-width:100%; overflow-x:auto; overflow-y:visible; border:1px solid #d6e2ee; border-radius:9px; background:#fff; }
        .tabel { width:max-content; min-width:100%; border-collapse:separate; border-spacing:0; color:#223; font-size:13px; line-height:1.35; }
        .tabel th, .tabel td { padding:10px 12px; border-right:1px solid #e1e8ef; border-bottom:1px solid #e1e8ef; text-align:left; vertical-align:middle; white-space:nowrap; }
        .tabel th:last-child, .tabel td:last-child { border-right:0; }
        .tabel thead th { position:sticky; top:0; z-index:2; background:#005baa; color:#fff; font-size:11px; font-weight:700; letter-spacing:.02em; text-transform:uppercase; }
        .tabel thead th.grup { background:#004985; text-align:center; }
        .tabel thead th.sub { background:#0872c9; text-align:center; font-size:10px; }
        .tabel tbody tr:nth-child(even) { background:#fbfcfd; }
        .tabel tbody tr { transition:background .15s ease; }
        .tabel tbody tr:hover { background:#eaf5fc; }
        .tabel tbody tr:last-child td { border-bottom:0; }
        .tabel td b { color:#234d6c; }
        .tabel .ikon-dtl, .tabel .detail-link { display:inline-flex; align-items:center; justify-content:center; min-width:34px; min-height:30px; padding:5px 9px; border-radius:5px; background:#c0392b; color:#fff; text-decoration:none; }
        .tabel .ikon-syarat { min-width:32px; min-height:28px; padding:4px 8px; border-radius:5px; background:#e8eef5; color:#0b3d6b; }
        .kartu-kaki { margin-top:12px; color:#637487; font-size:13px; }
        @media (max-width:800px) { main { padding:14px; } .box { padding:14px; } .tabel th, .tabel td { padding:8px 10px; } }
        .kartu-judul, .section-head { display:flex; align-items:center; justify-content:space-between; gap:12px; }
        .kartu-judul { margin-bottom:14px; color:#0b3d6b; font-weight:700; }
        .pill { display:inline-flex; align-items:center; min-height:24px; padding:3px 9px; border-radius:12px; background:#e7f3fb; color:#005baa; font-size:12px; font-weight:600; }
        form.filter, form.saring { display:flex; align-items:center; flex-wrap:wrap; gap:8px; }
        form.filter input, form.filter select, form.saring input, form.saring select { min-height:34px; padding:7px 9px; border:1px solid #b9c7d5; border-radius:5px; background:#fff; }
        button, .btn { min-height:34px; font-size:13px; font-weight:600; }
        a { color:#0b5ea8; }
        @media (max-width:900px) { aside { width:190px; } main { padding:18px; } }
        @media (max-width:650px) {
            .layout { display:block; }
            .menu-toggle { display:inline-block; }
            aside { position:fixed; inset:0 auto 0 0; z-index:50; width:250px; padding:18px 0; transform:translateX(-102%); transition:transform .22s ease; box-shadow:8px 0 24px rgba(16,50,75,.12); }
            body.menu-open aside { transform:translateX(0); }
            body.menu-open::after { content:""; position:fixed; inset:0; z-index:40; background:rgba(9,38,63,.28); }
            aside h2 { display:inline-block; margin-right:10px; }
            aside .role { display:block; margin:0 20px 20px; }
            aside a { display:block; padding:10px 20px; font-size:13px; }
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
    <aside id="mainSidebar">
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
            <div class="header-title"><button type="button" class="menu-toggle" id="menuToggle" aria-label="Buka menu">☰</button><strong>@yield('judul', 'FAST ON')</strong></div>
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
<style>
    :root { --pln-navy:#003b70; --pln-blue:#0072ce; --pln-light:#eef7fd; --pln-yellow:#ffc900; --ink:#183247; }
    aside { background:#fbfdff; color:#183247; border-right:1px solid #e4edf4; box-shadow:4px 0 18px rgba(0,45,85,.035); }
    aside h2 { color:var(--pln-navy); letter-spacing:.08em; }
    aside .role { color:#71879a; }
    aside a { color:#5b7285; margin:4px 12px; border:1px solid transparent; transition:all .2s ease; }
    aside a:hover { background:#f0f7fc; color:var(--pln-navy); border-color:#e0eef7; transform:translateX(2px); }
    aside a.active { background:#eaf5fc; color:var(--pln-navy); box-shadow:none; }
    aside a.active::before { background:var(--pln-blue); width:3px; top:7px; bottom:7px; }
    aside a.active::after { content:""; position:absolute; right:10px; top:50%; width:5px; height:5px; border-radius:50%; background:var(--pln-yellow); transform:translateY(-50%); }
    header { position:sticky; top:0; z-index:10; min-height:64px; background:rgba(255,255,255,.92); box-shadow:0 1px 12px rgba(20,62,95,.05); backdrop-filter:blur(10px); }
    header strong { color:var(--pln-navy); font-size:16px; letter-spacing:.01em; }
    main { background:linear-gradient(180deg,#f8fbfe 0%,#f5f8fb 240px); }
    .box { border-color:#e0eaf2; border-radius:12px; box-shadow:0 5px 18px rgba(0,65,115,.04); }
    .box:hover { box-shadow:0 8px 24px rgba(0,65,115,.07); }
    .card { border-color:#dceaf4; border-radius:12px; background:#fff; }
    .tabel { border-radius:8px; overflow:hidden; }
    .tabel thead th { background:#063f72; }
    .tabel thead th.grup { background:#004b87; }
    .tabel thead th.sub { background:#006bb8; }
    .tabel tbody tr:hover { background:#e7f4fc; }
    .btn, button { background:var(--pln-blue); border-radius:7px; }
    .btn:hover, button:hover { background:var(--pln-navy); }
    header form button { padding:7px 13px; background:#fff; color:var(--pln-navy); border:1px solid #cfe1ed; }
    header form button:hover { background:#eaf5fc; color:var(--pln-navy); }
    input:focus, select:focus, textarea:focus { outline:3px solid rgba(0,114,206,.12); border-color:var(--pln-blue)!important; }
    .menu-toggle { background:#e7f4fc; color:var(--pln-navy); }
    @media (max-width:650px) { aside { box-shadow:9px 0 28px rgba(0,45,85,.2); } }
    /* Reference theme: light canvas, white administrative cards and navy section headers. */
    :root{color-scheme:light;--ref-navy:#0D1B8C;--ref-blue:#2B73FE;--ref-cyan:#27A9D6;--ref-page:#F8FAFC;--ref-line:#E2E8F0;--ref-text:#334155;--ref-muted:#64748B}
    body{background:var(--ref-page);color:var(--ref-text);font-family:Inter,Arial,sans-serif}
    .content,main,body:has(.modern-dashboard) main{background:var(--ref-page)}
    aside{background:#091267;border-right-color:rgba(15,23,42,.12);box-shadow:2px 0 8px rgba(15,23,42,.08)}aside h2{color:#fff}aside .role{color:#bfdbfe}aside a{color:#dbeafe}aside a:hover{background:rgba(43,115,254,.22);color:#fff;border-color:transparent;transform:none}aside a.active{background:#1e40af;color:#fff;box-shadow:inset 3px 0 var(--ref-cyan)}aside a.active::after{background:#facc15}
    header{background:#fff;border-bottom-color:var(--ref-line);box-shadow:0 1px 5px rgba(15,23,42,.05)}header strong{color:#091267}header form button{background:#f1f5f9;color:#091267;border-color:var(--ref-line)}header form button:hover{background:#e2e8f0;color:#091267}
    .box,.card,.modern-panel,.metric-card,.vendor-card{background:#fff;border-color:var(--ref-line);border-radius:12px;color:var(--ref-text);box-shadow:0 2px 8px rgba(15,23,42,.08)}.box:hover,.card:hover,.modern-panel:hover{border-color:#cbd5e1;box-shadow:0 4px 12px rgba(15,23,42,.1)}
    .kartu-judul,.section-head,.panel-heading h2{color:#1e293b}.pill{background:#eff6ff;color:#1d4ed8;border:0}.scroll{background:#fff;border-color:var(--ref-line)}.tabel{background:#fff;color:var(--ref-text);border-radius:8px}.tabel th,.tabel td{border-color:var(--ref-line)}.tabel thead th{background:var(--ref-navy);color:#fff}.tabel thead th.grup{background:#183bb8;color:#fff}.tabel thead th.sub{background:#2452cf;color:#fff}.tabel tbody tr:nth-child(even){background:#f8fafc}.tabel tbody tr:hover{background:#eff6ff}.tabel td b{color:#1e3a5f}
    .tabel .ikon-dtl,.tabel .detail-link,.laporan-detail{background:var(--ref-blue)!important;border-color:var(--ref-blue)!important;color:#fff!important;box-shadow:0 2px 8px rgba(43,115,254,.2)}.tabel .ikon-dtl:hover,.tabel .detail-link:hover,.laporan-detail:hover{background:#1d4ed8!important;border-color:#1d4ed8!important;color:#fff!important;transform:none}.tabel .ikon-syarat{background:#eff6ff;color:#2563eb;border-color:#bfdbfe}
    input,select,textarea{background:#fff;color:var(--ref-text);border-color:#cbd5e1;font-family:Inter,Arial,sans-serif}input::placeholder,textarea::placeholder{color:#94a3b8}input:focus,select:focus,textarea:focus{outline:3px solid rgba(43,115,254,.14);border-color:var(--ref-blue)!important;box-shadow:0 0 0 1px var(--ref-blue)}button,.btn{background:var(--ref-blue);color:#fff;border-radius:8px;box-shadow:0 2px 8px rgba(15,23,42,.08)}button:hover,.btn:hover{background:#1d4ed8;color:#fff}a{color:#1e6fa8}
    a.btn,a.btn-excel{background:var(--ref-blue);border-color:var(--ref-blue);color:#fff!important;box-shadow:0 2px 8px rgba(15,23,42,.08)}a.btn:hover,a.btn-excel:hover{background:#1d4ed8;border-color:#1d4ed8;color:#fff!important;transform:none}a.btn.btn-abu{background:#f1f5f9!important;border-color:#cbd5e1!important;color:#334155!important}a.btn.btn-abu:hover{background:#e2e8f0!important;color:#0f172a!important}
    .stat-card{background:#fff;border-color:var(--ref-line)}.stat-card small,.kartu-kaki,.halaman{color:var(--ref-muted)}.stat-card strong{color:var(--ref-navy)}.ringkasan span{background:#eff6ff;color:#334155}.notif-item{background:#fff;color:var(--ref-text);border-color:var(--ref-line)}.notif-item.unread{background:#eff6ff;border-left-color:var(--ref-blue)}.notif-item strong{color:var(--ref-navy)}.notif-item small{color:var(--ref-muted)}
    .laporan-modal,.detail-modal{background:rgba(15,23,42,.45)}.laporan-modal-box,.detail-modal-box{background:#fff;color:var(--ref-text);border-color:var(--ref-line);box-shadow:0 12px 36px rgba(15,23,42,.2)}.laporan-modal-box h3,.laporan-modal-box h4,.detail-modal-box h3{color:var(--ref-navy)}.laporan-close,.detail-modal-close{background:#f1f5f9;color:#334155}.laporan-detail-grid>div,.laporan-material-grid>div,.detail-grid div{border-color:var(--ref-line);background:#fff}.laporan-detail-grid small,.laporan-material-grid small,.detail-grid small{color:var(--ref-muted)}.laporan-files{border-color:var(--ref-line);background:#f8fafc}.laporan-files a{color:#1e6fa8}
    .vendor-form{border-top-color:var(--ref-line)}.vendor-form h4,.planning-result-box h4,.construction-report-box h4,.proses-box h4{color:var(--ref-navy)}.vendor-form label,.vendor-kelayakan,.detail-edit-table label{color:var(--ref-muted)}.vendor-report-result,.planning-result-box,.construction-report-box,.proses-box{background:#f8fafc;border-color:var(--ref-line);color:var(--ref-text)}.proses-tabel{border-color:var(--ref-line);color:var(--ref-text)}.proses-tabel th,.proses-tabel td{border-bottom-color:var(--ref-line)}.proses-tabel th{background:#eff6ff;color:var(--ref-navy)}.proses-selesai{color:#2e9b68}.proses-belum{color:#d9534f}.result-waiting-message{background:#fff7ed;color:#9a651d}.result-delete{background:#d9534f;color:#fff}
    .kebutuhan-tabel{border-color:var(--ref-line);background:#fff;color:var(--ref-text)}.kebutuhan-tabel th,.kebutuhan-tabel td{border-bottom-color:var(--ref-line)}.kebutuhan-tabel thead th{background:var(--ref-navy);color:#fff}.kebutuhan-tabel select,.kebutuhan-tabel input,#tujuanKirim{background:#fff!important;color:var(--ref-text);border-color:#cbd5e1!important}.vendor-berkas,.vendor-report,.vendor-report-form,.history-edit-form{background:#fff;border-color:var(--ref-line);color:var(--ref-text)}.vendor-berkas a{background:#eff6ff;color:#1e6fa8}.vendor-berkas span,.vendor-card-head span,.history-item div span{color:var(--ref-muted)}.history-item{border-bottom-color:var(--ref-line)}.history-close{background:#f1f5f9;color:#334155}
    body:has(.modern-dashboard){background:var(--ref-page);color:var(--ref-text)}body:has(.modern-dashboard) aside{background:#091267}body:has(.modern-dashboard) header{background:#fff;border-bottom-color:var(--ref-line)}body:has(.modern-dashboard) .dashboard-topline h1{color:var(--ref-navy)}body:has(.modern-dashboard) .dashboard-topline p,body:has(.modern-dashboard) .panel-heading p{color:var(--ref-muted)}body:has(.modern-dashboard) .metric-card,body:has(.modern-dashboard) .modern-panel{background:#fff;border-color:var(--ref-line);box-shadow:0 2px 8px rgba(15,23,42,.08)}body:has(.modern-dashboard) .metric-card strong,body:has(.modern-dashboard) .panel-heading h2{color:#1e293b}body:has(.modern-dashboard) .metric-label,body:has(.modern-dashboard) .metric-card small{color:var(--ref-muted)}body:has(.modern-dashboard) .modern-table th{color:var(--ref-muted);border-bottom-color:var(--ref-line)}body:has(.modern-dashboard) .modern-table td{color:var(--ref-text);border-bottom-color:#edf1f5}body:has(.modern-dashboard) .modern-table td b{color:#1e293b}body:has(.modern-dashboard) .modern-table tbody tr:hover{background:#f0f7fb}body:has(.modern-dashboard) .status-tag.stage{background:#eff6ff;color:#1e6fa8}body:has(.modern-dashboard) .status-dot{background:#2e9b68}body:has(.modern-dashboard) .stage-track{background:#e2e8f0}body:has(.modern-dashboard) .stage-track i{background:linear-gradient(90deg,var(--ref-blue),var(--ref-cyan))}
    /* Reference-style outline icons. */
    .icon-inline,.metric-icon svg{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;display:block}.metric-icon svg{width:15px;height:15px}.file-icon{display:inline-flex;align-items:center;justify-content:center;margin-right:6px;color:#1e6fa8}.tabel .ikon-dtl,.tabel .detail-link,.laporan-detail{display:inline-grid;place-items:center}.tabel .ikon-syarat{display:inline-grid;place-items:center}
</style>
<style>
    /* FAST ON global dark theme: visual styling only. */
    :root{color-scheme:dark}
    body{background:#0a1020;color:#d8e2f0;font-family:Inter,"Plus Jakarta Sans","Segoe UI",system-ui,-apple-system,BlinkMacSystemFont,sans-serif;font-size:13px;letter-spacing:.005em;-webkit-font-smoothing:antialiased}
    h1,h2,h3,h4,h5,h6,button,.btn,aside a,header strong{font-family:Inter,"Plus Jakarta Sans","Segoe UI",system-ui,sans-serif;letter-spacing:-.01em}
    h1,h2,h3,h4,h5,h6{font-weight:700}
    button,.btn{font-weight:650;letter-spacing:.005em}
    aside{background:#101a2e;color:#c9d6e8;border-right-color:#202d45;box-shadow:8px 0 25px rgba(0,0,0,.15)}
    aside h2{color:#f4f8ff}
    aside .role{color:#8091ae}
    aside a{color:#91a2bd;border-color:transparent}
    aside a:hover{background:#17243c;color:#fff;border-color:#243858}
    aside a.active{background:#1b2b49;color:#fff;box-shadow:inset 3px 0 #20b8cf}
    aside a.active::before{display:none}
    aside a.active::after{background:#20b8cf}
    .content{background:#0a1020}
    header{background:rgba(11,18,34,.92);border-bottom-color:#202d45;box-shadow:0 1px 16px rgba(0,0,0,.18)}
    header strong{color:#f2f6fc}
    header form button{background:#17243c;color:#dbe7f6;border-color:#2b3c5b}
    header form button:hover{background:#213452;color:#fff}
    main{background:radial-gradient(circle at 80% 0%,#172445 0,#0d1629 38%,#0a1020 78%)}
    .box,.card{background:linear-gradient(145deg,#17233a,#131e33);border-color:#263753;color:#d8e2f0;box-shadow:0 10px 24px rgba(0,0,0,.16)}
    .box:hover,.card:hover{box-shadow:0 12px 28px rgba(0,0,0,.24);border-color:#385276}
    .kartu-judul,.section-head{color:#eef5ff}
    .pill{background:#193d5a;color:#71d2e4}
    .scroll{border-color:#263753;background:#131e33}
    .tabel{color:#d8e2f0;background:#131e33}
    .tabel th{font-size:10px;font-weight:700;letter-spacing:.045em}
    .tabel td{font-size:12px;letter-spacing:.005em}
    .tabel th,.tabel td{border-right-color:#263753;border-bottom-color:#263753}
    .tabel thead th{background:#142844;color:#d9e8f7;border-right-color:#263c5b}
    .tabel thead th.grup{background:#1b3b61;color:#eef7ff}
    .tabel thead th.sub{background:#193452;color:#c8dfef}
    .tabel tbody tr:nth-child(even){background:#162238}
    .tabel tbody tr:hover{background:#1d2c47}
    .tabel td b{color:#edf4ff}
    .tabel .ikon-dtl,.tabel .detail-link{min-width:32px;min-height:29px;padding:5px 8px;border:1px solid #36718e;border-radius:7px;background:linear-gradient(145deg,#1c526d,#17344f);color:#73d7e7;box-shadow:0 4px 10px rgba(0,0,0,.18);transition:all .2s ease}
    .tabel .ikon-dtl:hover,.tabel .detail-link:hover{background:linear-gradient(145deg,#267995,#1c4868);border-color:#58cfe1;color:#fff;transform:translateY(-1px);box-shadow:0 6px 14px rgba(18,154,181,.2)}
    .tabel .ikon-syarat{background:#1a304b;color:#a9d8e5;border:1px solid #304b6b}
    .tabel .ikon-syarat:hover{background:#244364;color:#d9f7ff}
    .laporan-detail{background:linear-gradient(145deg,#1c526d,#17344f)!important;color:#73d7e7!important;border:1px solid #36718e!important}
    .laporan-detail:hover{background:linear-gradient(145deg,#267995,#1c4868)!important;color:#fff!important;border-color:#58cfe1!important}
    .kartu-kaki{color:#8191aa}
    form.filter input,form.filter select,form.saring input,form.saring select,
    input,select,textarea{background:#111d32;color:#dbe7f6;border-color:#334865}
    input::placeholder,textarea::placeholder{color:#70839f}
    input:focus,select:focus,textarea:focus{outline:3px solid rgba(32,184,207,.15);border-color:#20b8cf!important}
    button,.btn{background:#20aeca;color:#061522}
    button:hover,.btn:hover{background:#47c7df;color:#061522}
    a{color:#60cce0}
    a.btn,a.btn-excel{display:inline-flex;align-items:center;justify-content:center;gap:6px;min-height:34px;padding:8px 13px;border:1px solid #3289a7;border-radius:7px;background:linear-gradient(135deg,#20aeca,#178cae);color:#061522!important;font-size:12px;font-weight:700;line-height:1.1;text-decoration:none!important;white-space:nowrap;box-shadow:0 4px 10px rgba(0,0,0,.16);transition:all .2s ease}
    a.btn:hover,a.btn-excel:hover{background:linear-gradient(135deg,#47c7df,#20aeca);border-color:#65d7e9;color:#04121d!important;transform:translateY(-1px);box-shadow:0 6px 14px rgba(32,174,202,.2)}
    a.btn.btn-abu{display:inline-flex!important;width:auto!important;height:auto!important;min-width:0!important;min-height:34px!important;padding:8px 13px!important;margin:0!important;background:#1b2b45!important;border:1px solid #385372!important;border-radius:7px!important;color:#bcd0e4!important;font-size:12px!important;font-weight:650!important;line-height:1.1!important;text-decoration:none!important;box-shadow:none!important}
    a.btn.btn-abu:hover{background:#294363!important;border-color:#4d7897!important;color:#eef8ff!important;transform:translateY(-1px);box-shadow:0 5px 12px rgba(0,0,0,.18)!important}
    .stat-card{background:linear-gradient(145deg,#172b49,#14233c);border-color:#263753}
    .stat-card small{color:#91a2bd}
    .stat-card strong{color:#eef5ff}
    .ringkasan span{background:#1d304c;color:#b7c9dd}
    .notif-item{background:#17233a;color:#d8e2f0;border-color:#2b3d5b}
    .notif-item.unread{background:#172e49;border-left-color:#20b8cf}
    .notif-item strong{color:#eef5ff}
    .notif-item small{color:#91a2bd}
    .laporan-modal,.detail-modal{background:rgba(1,6,16,.72)}
    .laporan-modal-box,.detail-modal-box{background:#131e33;color:#d8e2f0;border:1px solid #2c405e;box-shadow:0 18px 55px rgba(0,0,0,.5)}
    .laporan-modal-box h3,.laporan-modal-box h4,.detail-modal-box h3{color:#eef5ff}
    .laporan-close,.detail-modal-close{background:#263753;color:#dbe7f6}
    .laporan-detail-grid>div,.laporan-material-grid>div,.detail-grid div{border-color:#2b3d5b;background:#17243b}
    .laporan-detail-grid small,.laporan-material-grid small,.detail-grid small{color:#91a2bd}
    .laporan-files{border-color:#2b3d5b;background:#17243b}
    .laporan-files a{color:#60cce0}
    .detail-rab-input span{background:#263753;color:#b9cbe0}
    .detail-edit-table label{color:#b9cbe0}
    .detail-edit-table input,.detail-edit-table select{background:#111d32;color:#dbe7f6;border-color:#334865}
    .vendor-form{border-top-color:#2b3d5b}
    .vendor-form h4,.planning-result-box h4,.construction-report-box h4,.proses-box h4{color:#eef5ff}
    .vendor-form label,.vendor-kelayakan,.detail-edit-table label{color:#b9cbe0}
    .vendor-form select,.vendor-form input[type=file],.planning-result-box input[type=file]{background:#111d32;color:#dbe7f6;border-color:#334865}
    .vendor-report-result,.planning-result-box,.construction-report-box,.proses-box{background:#17243b;border-color:#2b3d5b;color:#d8e2f0}
    .vendor-report-result div,.vendor-report-result b{color:#c1d0e1}
    .planning-result-box a,.construction-report-box a{color:#60cce0}
    .proses-tabel{border-color:#2b3d5b;color:#c1d0e1}
    .proses-tabel th,.proses-tabel td{border-bottom-color:#2b3d5b}
    .proses-tabel th{background:#1f3553;color:#c5d8eb}
    .proses-tabel tr:last-child td{border-bottom-color:transparent}
    .proses-selesai{color:#55d4a0}
    .proses-belum{color:#ff7b86}
    .result-waiting-message{background:#3c351c;color:#f2d17a}
    .result-delete{background:#b84655;color:#fff}
    .kebutuhan-tabel{border-color:#2b3d5b;background:#17243b;color:#c9d8e8}
    .kebutuhan-tabel th,.kebutuhan-tabel td{border-bottom-color:#2b3d5b}
    .kebutuhan-tabel thead th{background:#1f3553;color:#c5d8eb}
    .kebutuhan-tabel select,.kebutuhan-tabel input{background:#0f1c30!important;color:#dbe7f6;border-color:#385170}
    .kebutuhan-tabel select:focus,.kebutuhan-tabel input:focus{border-color:#20b8cf;box-shadow:0 0 0 3px rgba(32,184,207,.12)}
    #tujuanKirim{background:#111d32!important;color:#e6f1fc;border-color:#20b8cf!important}
    .vendor-card{background:linear-gradient(145deg,#172742,#131f35);border-color:#2b4161}
    .vendor-card-head{border-bottom-color:#2b3d5b}
    .vendor-card-head strong,.history-item strong{color:#eef5ff}
    .vendor-card-head span,.history-item div span{color:#91a2bd}
    .vendor-berkas,.vendor-report,.vendor-report-form,.history-edit-form{background:#17243b;border-color:#2b3d5b;color:#d8e2f0}
    .vendor-berkas a{background:#1f3553;color:#60cce0}
    .vendor-berkas span{color:#91a2bd}
    .vendor-report label,.vendor-report-form label,.history-edit-form label{color:#b9cbe0}
    .vendor-report textarea,.vendor-report-form textarea,.history-edit-form textarea,
    .vendor-report input[type=file],.vendor-report-form input[type=file],.history-edit-form input[type=file]{background:#0f1c30;color:#dbe7f6;border-color:#385170}
    .history-item{border-bottom-color:#2b3d5b}
    .history-close{background:#263753;color:#dbe7f6}
    .empty{color:#91a2bd}
    .halaman{color:#91a2bd}
    .menu-toggle{background:#17243c;color:#71d2e4}
    .notif-badge{background:#e05b61}
    .stat-card strong,.metric-card strong{font-variant-numeric:tabular-nums;letter-spacing:-.035em}
    /* Final visual tokens: colors, typography, surfaces and states only. */
    :root{--ui-bg:#0b1220;--ui-surface:#131e33;--ui-surface-2:#17243b;--ui-border:#293d5c;--ui-text:#dbe7f6;--ui-muted:#91a2bd;--ui-accent:#20b8cf;--ui-accent-soft:#1b3d56}
    body{background:var(--ui-bg);color:var(--ui-text);font-family:Inter,"Plus Jakarta Sans","Segoe UI",system-ui,sans-serif;line-height:1.45}
    body,button,input,select,textarea{font-synthesis:none}
    aside{background:#101a2e;border-right-color:#22324d}
    aside h2,header strong{font-weight:750;letter-spacing:.015em}
    aside a{font-weight:550;letter-spacing:.01em}
    aside a.active{background:#1a2b47;border-left-color:var(--ui-accent)}
    header{background:rgba(13,21,38,.94);border-bottom-color:#22324d}
    main{background:radial-gradient(circle at 84% 0%,#182747 0,#0e172a 37%,var(--ui-bg) 78%)}
    .box,.card,.modern-panel,.metric-card,.vendor-card{border-radius:12px;border-color:var(--ui-border);box-shadow:0 8px 24px rgba(0,0,0,.16)}
    .box:hover,.card:hover,.modern-panel:hover{border-color:#385276;box-shadow:0 10px 28px rgba(0,0,0,.2)}
    button,.btn{border-radius:7px;font-weight:650}
    input,select,textarea{border-radius:7px}
    input:focus,select:focus,textarea:focus{outline:3px solid rgba(32,184,207,.14);border-color:var(--ui-accent)!important}
    .tabel{background:var(--ui-surface);border-color:var(--ui-border)}
    .tabel thead th{background:#142844;color:#e3effb}
    .tabel tbody tr:nth-child(even){background:#152238}
    .tabel tbody tr:hover{background:#1d2f4c}
    .tabel th,.tabel td{border-color:#293d5c}
    .tabel .ikon-dtl,.tabel .detail-link{background:linear-gradient(135deg,#1b526d,#17344f);border-color:#377d98;color:#83ddeb}
    .tabel .ikon-dtl:hover,.tabel .detail-link:hover{background:linear-gradient(135deg,#267995,#1c4868);color:#fff}
    a{transition:color .18s ease}
    .detail-modal-box,.laporan-modal-box{border-radius:12px;background:var(--ui-surface);border-color:#31496b}
    /* Requested light corporate visual system: styling only. */
    :root{color-scheme:light;--navy:#123B5D;--blue:#1E6FA8;--cyan:#27A9D6;--green:#2E9B68;--orange:#F2A541;--red:#D9534F;--page:#F5F7FA;--white:#FFFFFF;--border:#D9E2EC;--text:#243B53;--muted:#627D98}
    body{background:var(--page);color:var(--text);font-family:Inter,Arial,sans-serif;font-size:14px;line-height:1.5}
    h1,h2,h3,h4,h5,h6{font-family:Inter,Arial,sans-serif;line-height:1.3;color:var(--navy)}
    h1{font-size:24px;font-weight:700}h2,h3{font-weight:600}
    aside{background:var(--navy);color:#fff;border-right-color:#0d2e49;box-shadow:0 2px 8px rgba(18,59,93,.08)}
    aside h2{color:#fff;font-weight:700}aside .role{color:#d4e2ed}
    aside a{color:#e2edf5;font-family:Inter,Arial,sans-serif;font-size:13px}
    aside a:hover{background:#1a557f;color:#fff;border-color:transparent;transform:none}
    aside a.active{background:var(--blue);color:#fff;box-shadow:inset 3px 0 var(--cyan)}aside a.active::before{display:none}aside a.active::after{background:var(--cyan)}
    header{background:var(--white);border-bottom:1px solid var(--border);box-shadow:0 2px 8px rgba(18,59,93,.08)}
    header strong{color:var(--navy);font-family:Inter,Arial,sans-serif;font-size:16px;font-weight:700}
    header form button{background:var(--white);color:var(--navy);border-color:var(--border)}header form button:hover{background:#edf4f8;color:var(--navy)}
    main,body:has(.modern-dashboard) main{background:var(--page)}
    .box,.card,.modern-panel,.metric-card,.vendor-card{background:var(--white);border:1px solid var(--border);border-radius:8px;color:var(--text);box-shadow:0 2px 8px rgba(18,59,93,.08)}
    .box:hover,.card:hover,.modern-panel:hover{border-color:#c5d5e3;box-shadow:0 3px 10px rgba(18,59,93,.1)}
    .kartu-judul,.section-head,.panel-heading h2{color:var(--text)}.pill{background:#eaf3f8;color:var(--blue);border-radius:8px}
    .scroll{background:var(--white);border-color:var(--border);border-radius:8px}.tabel{background:var(--white);color:var(--text);border-radius:8px}
    .tabel th,.tabel td{border-color:var(--border);font-family:Inter,Arial,sans-serif}.tabel thead th{background:#eaf2f7;color:var(--navy);font-size:12px;font-weight:600}.tabel thead th.grup{background:#dcebf5;color:var(--navy)}.tabel thead th.sub{background:#e6f1f8;color:var(--navy)}
    .tabel tbody tr:nth-child(even){background:#fbfcfd}.tabel tbody tr:hover{background:#f0f7fb}.tabel td b{color:var(--text)}
    .tabel .ikon-dtl,.tabel .detail-link,.laporan-detail{background:var(--blue)!important;border-color:var(--blue)!important;color:#fff!important;border-radius:8px;box-shadow:0 2px 8px rgba(30,111,168,.18)}.tabel .ikon-dtl:hover,.tabel .detail-link:hover,.laporan-detail:hover{background:#185b8a!important;border-color:#185b8a!important;color:#fff!important;transform:none}
    .tabel .ikon-syarat{background:#edf4f8;color:var(--blue);border-color:var(--border)}
    input,select,textarea{background:var(--white);color:var(--text);border:1px solid var(--border);border-radius:8px;font-family:Inter,Arial,sans-serif;font-size:14px}
    input::placeholder,textarea::placeholder{color:var(--muted)}input:focus,select:focus,textarea:focus{outline:3px solid rgba(30,111,168,.14);border-color:var(--blue)!important;box-shadow:0 0 0 1px var(--blue)}
    button,.btn{background:var(--blue);color:#fff;border-radius:8px;font-family:Inter,Arial,sans-serif;font-size:14px;font-weight:600}button:hover,.btn:hover{background:#185b8a;color:#fff}
    a{color:var(--blue)}a.btn,a.btn-excel{background:var(--blue);border-color:var(--blue);color:#fff!important;border-radius:8px;font-size:14px;font-weight:600;box-shadow:0 2px 8px rgba(18,59,93,.08)}a.btn:hover,a.btn-excel:hover{background:#185b8a;border-color:#185b8a;color:#fff!important;transform:none}
    a.btn.btn-abu{background:#edf1f5!important;border-color:var(--border)!important;color:var(--text)!important;border-radius:8px!important;font-size:14px!important}a.btn.btn-abu:hover{background:#dfe8ef!important;color:var(--navy)!important}
    .stat-card{background:#fff;border-color:var(--border)}.stat-card small,.kartu-kaki,.halaman{color:var(--muted)}.stat-card strong{color:var(--navy)}.ringkasan span{background:#edf4f8;color:var(--text)}
    .notif-item{background:#fff;color:var(--text);border-color:var(--border)}.notif-item.unread{background:#eef7fc;border-left-color:var(--blue)}.notif-item strong{color:var(--navy)}.notif-item small{color:var(--muted)}
    .laporan-modal,.detail-modal{background:rgba(18,59,93,.35)}.laporan-modal-box,.detail-modal-box{background:#fff;color:var(--text);border-color:var(--border);box-shadow:0 12px 36px rgba(18,59,93,.18)}.laporan-modal-box h3,.laporan-modal-box h4,.detail-modal-box h3{color:var(--navy)}.laporan-close,.detail-modal-close{background:#edf1f5;color:var(--text)}
    .laporan-detail-grid>div,.laporan-material-grid>div,.detail-grid div{border-color:var(--border);background:#fff}.laporan-detail-grid small,.laporan-material-grid small,.detail-grid small{color:var(--muted)}.laporan-files{border-color:var(--border);background:#fbfcfd}.laporan-files a{color:var(--blue)}
    .vendor-form{border-top-color:var(--border)}.vendor-form h4,.planning-result-box h4,.construction-report-box h4,.proses-box h4{color:var(--navy)}.vendor-form label,.vendor-kelayakan,.detail-edit-table label{color:var(--muted)}.vendor-report-result,.planning-result-box,.construction-report-box,.proses-box{background:#f8fbfd;border-color:var(--border);color:var(--text)}
    .proses-tabel{border-color:var(--border);color:var(--text)}.proses-tabel th,.proses-tabel td{border-bottom-color:var(--border)}.proses-tabel th{background:#edf4f8;color:var(--navy)}.proses-selesai{color:var(--green)}.proses-belum{color:var(--red)}.result-waiting-message{background:#fff5e5;color:#9a651d}.result-delete{background:var(--red);color:#fff}
    .kebutuhan-tabel{border-color:var(--border);background:#fff;color:var(--text)}.kebutuhan-tabel th,.kebutuhan-tabel td{border-bottom-color:var(--border)}.kebutuhan-tabel thead th{background:#edf4f8;color:var(--navy)}.kebutuhan-tabel select,.kebutuhan-tabel input,#tujuanKirim{background:#fff!important;color:var(--text);border-color:var(--border)!important}
    .vendor-berkas,.vendor-report,.vendor-report-form,.history-edit-form{background:#fff;border-color:var(--border);color:var(--text)}.vendor-berkas a{background:#edf4f8;color:var(--blue)}.vendor-berkas span,.vendor-card-head span,.history-item div span{color:var(--muted)}.history-item{border-bottom-color:var(--border)}.history-close{background:#edf1f5;color:var(--text)}
    body:has(.modern-dashboard){background:var(--page);color:var(--text)}body:has(.modern-dashboard) aside{background:var(--navy)}body:has(.modern-dashboard) header{background:#fff;border-bottom-color:var(--border)}body:has(.modern-dashboard) .dashboard-topline h1{color:var(--navy)}body:has(.modern-dashboard) .dashboard-topline p,body:has(.modern-dashboard) .panel-heading p{color:var(--muted)}body:has(.modern-dashboard) .metric-card,body:has(.modern-dashboard) .modern-panel{background:#fff;border-color:var(--border);box-shadow:0 2px 8px rgba(18,59,93,.08)}body:has(.modern-dashboard) .metric-card strong,body:has(.modern-dashboard) .panel-heading h2{color:var(--text)}body:has(.modern-dashboard) .metric-label,body:has(.modern-dashboard) .metric-card small{color:var(--muted)}body:has(.modern-dashboard) .modern-table th{color:var(--muted);border-bottom-color:var(--border)}body:has(.modern-dashboard) .modern-table td{color:var(--text);border-bottom-color:#edf1f5}body:has(.modern-dashboard) .modern-table td b{color:var(--text)}body:has(.modern-dashboard) .modern-table tbody tr:hover{background:#f4f8fb}body:has(.modern-dashboard) .status-tag.stage{background:#e8f3fa;color:var(--blue)}body:has(.modern-dashboard) .status-dot{background:var(--green)}body:has(.modern-dashboard) .stage-track{background:#edf1f5}body:has(.modern-dashboard) .stage-track i{background:linear-gradient(90deg,var(--blue),var(--cyan))}
    /* Login-aligned blue visual theme for all authenticated pages. */
    :root{color-scheme:dark;--login-deep:#091267;--login-blue:#0d1b8c;--login-mid:#123fa8;--login-cyan:#27a9d6;--login-surface:rgba(255,255,255,.1);--login-border:rgba(255,255,255,.2);--login-text:#fff;--login-muted:rgba(255,255,255,.68)}
    body{background:linear-gradient(135deg,var(--login-deep) 0%,var(--login-blue) 55%,var(--login-mid) 100%);color:#eaf5ff;font-family:Inter,Arial,sans-serif}
    .content{background:transparent}aside{background:rgba(7,15,92,.72);border-right:1px solid rgba(255,255,255,.14);box-shadow:8px 0 28px rgba(0,0,0,.18);backdrop-filter:blur(14px)}aside h2{color:#fff}aside .role{color:rgba(255,255,255,.68)}aside a{color:rgba(255,255,255,.76)}aside a:hover{background:rgba(39,169,214,.16);border-color:rgba(39,169,214,.3);color:#fff;transform:none}aside a.active{background:rgba(39,169,214,.22);color:#fff;box-shadow:inset 3px 0 var(--login-cyan)}aside a.active::after{background:var(--login-cyan)}
    header{background:rgba(5,14,84,.42);border-bottom-color:rgba(255,255,255,.14);box-shadow:0 1px 16px rgba(0,0,0,.18);backdrop-filter:blur(14px)}header strong{color:#fff}header form button{background:rgba(255,255,255,.1);color:#fff;border-color:rgba(255,255,255,.22)}header form button:hover{background:rgba(255,255,255,.18);color:#fff}
    main,body:has(.modern-dashboard) main{background:transparent}.box,.card,.modern-panel,.metric-card,.vendor-card{background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.2);color:#eaf5ff;box-shadow:0 12px 30px rgba(0,0,0,.16),inset 0 1px rgba(255,255,255,.06);backdrop-filter:blur(12px)}.box:hover,.card:hover,.modern-panel:hover{border-color:rgba(39,169,214,.5);box-shadow:0 15px 34px rgba(0,0,0,.22)}
    .kartu-judul,.section-head,.panel-heading h2{color:#fff}.pill{background:rgba(39,169,214,.18);color:#9be7fa;border:1px solid rgba(39,169,214,.25)}.scroll{border-color:rgba(255,255,255,.2);background:rgba(255,255,255,.06)}.tabel{background:rgba(8,22,95,.62);color:#eaf5ff;border-radius:8px}.tabel th,.tabel td{border-color:rgba(255,255,255,.14)}.tabel thead th{background:rgba(7,27,111,.82);color:#dff6ff}.tabel thead th.grup{background:rgba(30,111,168,.6);color:#fff}.tabel thead th.sub{background:rgba(39,169,214,.28);color:#e8fbff}.tabel tbody tr:nth-child(even){background:rgba(255,255,255,.035)}.tabel tbody tr:hover{background:rgba(39,169,214,.12)}.tabel td b{color:#fff}
    .tabel .ikon-dtl,.tabel .detail-link,.laporan-detail{background:linear-gradient(135deg,var(--login-blue),#0093e9)!important;border-color:rgba(255,255,255,.22)!important;color:#fff!important;box-shadow:0 5px 14px rgba(0,115,204,.25)}.tabel .ikon-dtl:hover,.tabel .detail-link:hover,.laporan-detail:hover{background:linear-gradient(135deg,#091267,#27a9d6)!important;color:#fff!important;transform:translateY(-1px)}.tabel .ikon-syarat{background:rgba(255,255,255,.1);color:#b8effb;border-color:rgba(255,255,255,.2)}
    input,select,textarea{background:rgba(255,255,255,.1);color:#fff;border-color:rgba(255,255,255,.24);font-family:Inter,Arial,sans-serif}input::placeholder,textarea::placeholder{color:rgba(255,255,255,.55)}input:focus,select:focus,textarea:focus{outline:3px solid rgba(39,169,214,.22);border-color:var(--login-cyan)!important;box-shadow:0 0 0 1px var(--login-cyan)}button,.btn{background:linear-gradient(135deg,var(--login-blue),#0093e9);color:#fff;border-radius:8px;box-shadow:0 4px 14px rgba(0,115,204,.2)}button:hover,.btn:hover{background:linear-gradient(135deg,var(--login-deep),#0073cc);color:#fff}
    a{color:#8fe4f6}a.btn,a.btn-excel{background:linear-gradient(135deg,var(--login-blue),#0093e9);border-color:rgba(255,255,255,.2);color:#fff!important;box-shadow:0 4px 14px rgba(0,115,204,.2)}a.btn:hover,a.btn-excel:hover{background:linear-gradient(135deg,var(--login-deep),#0073cc);color:#fff!important;transform:translateY(-1px)}a.btn.btn-abu{background:rgba(255,255,255,.1)!important;border-color:rgba(255,255,255,.22)!important;color:#e5f6ff!important}a.btn.btn-abu:hover{background:rgba(39,169,214,.2)!important;color:#fff!important}
    .stat-card{background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.2)}.stat-card small,.kartu-kaki,.halaman{color:rgba(255,255,255,.62)}.stat-card strong{color:#fff}.ringkasan span{background:rgba(39,169,214,.16);color:#dff8ff}.notif-item{background:rgba(255,255,255,.1);color:#eaf5ff;border-color:rgba(255,255,255,.2)}.notif-item.unread{background:rgba(39,169,214,.16);border-left-color:var(--login-cyan)}.notif-item strong{color:#fff}.notif-item small{color:rgba(255,255,255,.65)}
    .laporan-modal,.detail-modal{background:rgba(2,7,55,.72)}.laporan-modal-box,.detail-modal-box{background:linear-gradient(145deg,#13247b,#0d1b63);color:#eaf5ff;border-color:rgba(255,255,255,.24);box-shadow:0 18px 55px rgba(0,0,0,.45)}.laporan-modal-box h3,.laporan-modal-box h4,.detail-modal-box h3{color:#fff}.laporan-close,.detail-modal-close{background:rgba(255,255,255,.12);color:#fff}.laporan-detail-grid>div,.laporan-material-grid>div,.detail-grid div{border-color:rgba(255,255,255,.18);background:rgba(255,255,255,.08)}.laporan-detail-grid small,.laporan-material-grid small,.detail-grid small{color:rgba(255,255,255,.65)}.laporan-files{border-color:rgba(255,255,255,.18);background:rgba(255,255,255,.06)}.laporan-files a{color:#8fe4f6}
    .vendor-form{border-top-color:rgba(255,255,255,.2)}.vendor-form h4,.planning-result-box h4,.construction-report-box h4,.proses-box h4{color:#fff}.vendor-form label,.vendor-kelayakan,.detail-edit-table label{color:rgba(255,255,255,.72)}.vendor-report-result,.planning-result-box,.construction-report-box,.proses-box{background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.2);color:#eaf5ff}.proses-tabel{border-color:rgba(255,255,255,.2);color:#eaf5ff}.proses-tabel th,.proses-tabel td{border-bottom-color:rgba(255,255,255,.14)}.proses-tabel th{background:rgba(39,169,214,.2);color:#e8fbff}.proses-selesai{color:#7ee4b2}.proses-belum{color:#ffaaa7}.result-waiting-message{background:rgba(242,165,65,.18);color:#ffd58c}.result-delete{background:#d9534f;color:#fff}
    .kebutuhan-tabel{border-color:rgba(255,255,255,.2);background:rgba(255,255,255,.06);color:#eaf5ff}.kebutuhan-tabel th,.kebutuhan-tabel td{border-bottom-color:rgba(255,255,255,.14)}.kebutuhan-tabel thead th{background:rgba(39,169,214,.2);color:#e8fbff}.kebutuhan-tabel select,.kebutuhan-tabel input,#tujuanKirim{background:rgba(255,255,255,.1)!important;color:#fff;border-color:rgba(255,255,255,.24)!important}.vendor-berkas,.vendor-report,.vendor-report-form,.history-edit-form{background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.2);color:#eaf5ff}.vendor-berkas a{background:rgba(39,169,214,.16);color:#8fe4f6}.vendor-berkas span,.vendor-card-head span,.history-item div span{color:rgba(255,255,255,.65)}.history-item{border-bottom-color:rgba(255,255,255,.14)}.history-close{background:rgba(255,255,255,.12);color:#fff}
    body:has(.modern-dashboard){background:linear-gradient(135deg,var(--login-deep),var(--login-blue) 55%,var(--login-mid));color:#eaf5ff}body:has(.modern-dashboard) aside{background:rgba(7,15,92,.72)}body:has(.modern-dashboard) header{background:rgba(5,14,84,.42);border-bottom-color:rgba(255,255,255,.14)}body:has(.modern-dashboard) .dashboard-topline h1{color:#fff}body:has(.modern-dashboard) .dashboard-topline p,body:has(.modern-dashboard) .panel-heading p{color:rgba(255,255,255,.68)}body:has(.modern-dashboard) .metric-card,body:has(.modern-dashboard) .modern-panel{background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.2);box-shadow:0 12px 30px rgba(0,0,0,.16)}body:has(.modern-dashboard) .metric-card strong,body:has(.modern-dashboard) .panel-heading h2{color:#fff}body:has(.modern-dashboard) .metric-label,body:has(.modern-dashboard) .metric-card small{color:rgba(255,255,255,.68)}body:has(.modern-dashboard) .modern-table th{color:rgba(255,255,255,.65);border-bottom-color:rgba(255,255,255,.14)}body:has(.modern-dashboard) .modern-table td{color:#eaf5ff;border-bottom-color:rgba(255,255,255,.14)}body:has(.modern-dashboard) .modern-table td b{color:#fff}body:has(.modern-dashboard) .modern-table tbody tr:hover{background:rgba(39,169,214,.12)}body:has(.modern-dashboard) .status-tag.stage{background:rgba(39,169,214,.2);color:#9be7fa}body:has(.modern-dashboard) .status-dot{background:#7ee4b2}body:has(.modern-dashboard) .stage-track{background:rgba(255,255,255,.14)}body:has(.modern-dashboard) .stage-track i{background:linear-gradient(90deg,var(--login-cyan),#7a86ff)}
    @media(max-width:650px){aside{box-shadow:9px 0 28px rgba(0,0,0,.45)}body.menu-open::after{background:rgba(0,0,0,.58)}}
    /* Final reference theme override. */
    :root{color-scheme:light;--ref-navy:#0D1B8C;--ref-blue:#2B73FE;--ref-cyan:#27A9D6;--ref-page:#F8FAFC;--ref-line:#E2E8F0;--ref-text:#334155;--ref-muted:#64748B}
    body{background:var(--ref-page);color:var(--ref-text);font-family:Inter,Arial,sans-serif}.content,main,body:has(.modern-dashboard) main{background:var(--ref-page)}
    aside{background:#091267;border-right-color:rgba(15,23,42,.12);box-shadow:2px 0 8px rgba(15,23,42,.08)}aside h2{color:#fff}aside .role{color:#bfdbfe}aside a{color:#dbeafe}aside a:hover{background:rgba(43,115,254,.22);color:#fff;border-color:transparent;transform:none}aside a.active{background:#1e40af;color:#fff;box-shadow:inset 3px 0 var(--ref-cyan)}aside a.active::after{background:#facc15}
    header{background:#fff;border-bottom-color:var(--ref-line);box-shadow:0 1px 5px rgba(15,23,42,.05)}header strong{color:#091267}header form button{background:#f1f5f9;color:#091267;border-color:var(--ref-line)}header form button:hover{background:#e2e8f0;color:#091267}
    .box,.card,.modern-panel,.metric-card,.vendor-card{background:#fff;border-color:var(--ref-line);border-radius:12px;color:var(--ref-text);box-shadow:0 2px 8px rgba(15,23,42,.08)}.box:hover,.card:hover,.modern-panel:hover{border-color:#cbd5e1;box-shadow:0 4px 12px rgba(15,23,42,.1)}.kartu-judul,.section-head,.panel-heading h2{color:#1e293b}.pill{background:#eff6ff;color:#1d4ed8;border:0}
    .scroll,.tabel{background:#fff;border-color:var(--ref-line)}.tabel{color:var(--ref-text);border-radius:8px}.tabel th,.tabel td{border-color:var(--ref-line)}.tabel thead th{background:var(--ref-navy);color:#fff}.tabel thead th.grup{background:#183bb8}.tabel thead th.sub{background:#2452cf}.tabel tbody tr:nth-child(even){background:#f8fafc}.tabel tbody tr:hover{background:#eff6ff}.tabel td b{color:#1e3a5f}.tabel .ikon-dtl,.tabel .detail-link,.laporan-detail{background:var(--ref-blue)!important;border-color:var(--ref-blue)!important;color:#fff!important}.tabel .ikon-dtl:hover,.tabel .detail-link:hover,.laporan-detail:hover{background:#1d4ed8!important;border-color:#1d4ed8!important;transform:none}.tabel .ikon-syarat{background:#eff6ff;color:#2563eb;border-color:#bfdbfe}
    input,select,textarea{background:#fff;color:var(--ref-text);border-color:#cbd5e1;font-family:Inter,Arial,sans-serif}input::placeholder,textarea::placeholder{color:#94a3b8}input:focus,select:focus,textarea:focus{outline:3px solid rgba(43,115,254,.14);border-color:var(--ref-blue)!important;box-shadow:0 0 0 1px var(--ref-blue)}button,.btn{background:var(--ref-blue);color:#fff;border-radius:8px}button:hover,.btn:hover{background:#1d4ed8;color:#fff}a{color:#1e6fa8}a.btn,a.btn-excel{background:var(--ref-blue);border-color:var(--ref-blue);color:#fff!important}a.btn:hover,a.btn-excel:hover{background:#1d4ed8;border-color:#1d4ed8;transform:none}a.btn.btn-abu{background:#f1f5f9!important;border-color:#cbd5e1!important;color:#334155!important}
    .stat-card,.notif-item,.vendor-berkas,.vendor-report,.vendor-report-form,.history-edit-form{background:#fff;border-color:var(--ref-line);color:var(--ref-text)}.stat-card small,.kartu-kaki,.halaman,.vendor-berkas span,.vendor-card-head span,.history-item div span{color:var(--ref-muted)}.stat-card strong,.notif-item strong{color:var(--ref-navy)}.notif-item.unread{background:#eff6ff;border-left-color:var(--ref-blue)}.ringkasan span{background:#eff6ff;color:#334155}
    .laporan-modal,.detail-modal{background:rgba(15,23,42,.45)}.laporan-modal-box,.detail-modal-box{background:#fff;color:var(--ref-text);border-color:var(--ref-line);box-shadow:0 12px 36px rgba(15,23,42,.2)}.laporan-modal-box h3,.laporan-modal-box h4,.detail-modal-box h3{color:var(--ref-navy)}.laporan-close,.detail-modal-close,.history-close{background:#f1f5f9;color:#334155}.laporan-detail-grid>div,.laporan-material-grid>div,.detail-grid div{border-color:var(--ref-line);background:#fff}.laporan-detail-grid small,.laporan-material-grid small,.detail-grid small{color:var(--ref-muted)}.laporan-files{border-color:var(--ref-line);background:#f8fafc}.laporan-files a,.vendor-berkas a{color:#1e6fa8}
    .vendor-form{border-top-color:var(--ref-line)}.vendor-form h4,.planning-result-box h4,.construction-report-box h4,.proses-box h4{color:var(--ref-navy)}.vendor-form label,.vendor-kelayakan,.detail-edit-table label{color:var(--ref-muted)}.vendor-report-result,.planning-result-box,.construction-report-box,.proses-box{background:#f8fafc;border-color:var(--ref-line);color:var(--ref-text)}.proses-tabel{border-color:var(--ref-line);color:var(--ref-text)}.proses-tabel th,.proses-tabel td{border-bottom-color:var(--ref-line)}.proses-tabel th,.kebutuhan-tabel thead th{background:#edf4ff;color:var(--ref-navy)}.proses-selesai{color:#2e9b68}.proses-belum{color:#d9534f}.result-waiting-message{background:#fff7ed;color:#9a651d}.result-delete{background:#d9534f;color:#fff}.kebutuhan-tabel{border-color:var(--ref-line);background:#fff;color:var(--ref-text)}.kebutuhan-tabel th,.kebutuhan-tabel td{border-bottom-color:var(--ref-line)}.kebutuhan-tabel select,.kebutuhan-tabel input,#tujuanKirim{background:#fff!important;color:var(--ref-text);border-color:#cbd5e1!important}
    body:has(.modern-dashboard){background:var(--ref-page);color:var(--ref-text)}body:has(.modern-dashboard) aside{background:#091267}body:has(.modern-dashboard) header{background:#fff;border-bottom-color:var(--ref-line)}body:has(.modern-dashboard) .dashboard-topline h1{color:var(--ref-navy)}body:has(.modern-dashboard) .dashboard-topline p,body:has(.modern-dashboard) .panel-heading p{color:var(--ref-muted)}body:has(.modern-dashboard) .metric-card,body:has(.modern-dashboard) .modern-panel{background:#fff;border-color:var(--ref-line);box-shadow:0 2px 8px rgba(15,23,42,.08)}body:has(.modern-dashboard) .metric-card strong,body:has(.modern-dashboard) .panel-heading h2{color:#1e293b}body:has(.modern-dashboard) .metric-label,body:has(.modern-dashboard) .metric-card small{color:var(--ref-muted)}body:has(.modern-dashboard) .modern-table th{color:var(--ref-muted);border-bottom-color:var(--ref-line)}body:has(.modern-dashboard) .modern-table td{color:var(--ref-text);border-bottom-color:#edf1f5}body:has(.modern-dashboard) .modern-table td b{color:#1e293b}body:has(.modern-dashboard) .modern-table tbody tr:hover{background:#f0f7fb}body:has(.modern-dashboard) .status-tag.stage{background:#eff6ff;color:#1e6fa8}body:has(.modern-dashboard) .status-dot{background:#2e9b68}body:has(.modern-dashboard) .stage-track{background:#e2e8f0}body:has(.modern-dashboard) .stage-track i{background:linear-gradient(90deg,var(--ref-blue),var(--ref-cyan))}
</style>
<style>
    .icon-inline,.metric-icon svg{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;display:block}.metric-icon svg{width:15px;height:15px}.file-icon{display:inline-flex;align-items:center;justify-content:center;margin-right:6px;color:#1e6fa8}.tabel .ikon-dtl,.tabel .detail-link,.laporan-detail{display:inline-grid;place-items:center}.tabel .ikon-syarat{display:inline-grid;place-items:center}
</style>
<style>
    /* Shared modern dashboard language across every role and page. */
    .content{background:#f5f8fc!important}
    .content>h1,.content>h2,.content>h3{color:#123b5d!important;font-weight:750;letter-spacing:-.025em}
    .box,.card,.kartu,.vendor-card,.notif-box,.upload-card,.history-card{border:1px solid #dbe5f0!important;border-radius:16px!important;background:#fff!important;box-shadow:0 8px 24px rgba(13,27,140,.06)!important}
    .box:not(.filter),.card,.vendor-card,.notif-box{padding:18px!important}
    .box:hover,.card:hover,.vendor-card:hover,.notif-box:hover{border-color:#c7d8ec!important;box-shadow:0 11px 28px rgba(13,27,140,.09)!important}
    .section-head,.kartu-judul,.card-header,.vendor-card-head,.notif-head{border-radius:12px!important;color:#fff!important;background:#0d1b8c!important}
    .section-head h2,.section-head h3,.card-header h2,.card-header h3,.vendor-card-head h3,.notif-head h2{color:#fff!important}
    .scroll{border:1px solid #dbe5f0!important;border-radius:11px!important;background:#fff!important}
    .tabel{border-collapse:separate!important;border-spacing:0!important;overflow:hidden;border:1px solid #dbe5f0!important;border-radius:11px!important;background:#fff!important;color:#334155!important}
    .tabel thead th{background:#0d1b8c!important;border-color:#3152bd!important;color:#fff!important;letter-spacing:.035em}
    .tabel thead th.grup{background:#1646b8!important}.tabel thead th.sub{background:#245ed1!important}
    .tabel tbody tr:nth-child(even){background:#f8fbff!important}.tabel tbody tr:hover{background:#eef6ff!important;box-shadow:inset 3px 0 #f4c300}
    .tabel td,.tabel th{border-color:#e2e8f0!important;vertical-align:middle}
    form.box input,form.box select,form.box textarea,.filter input,.filter select{border-radius:9px!important;background:#f8fafc!important;border-color:#d5e0ec!important;transition:border-color .18s,box-shadow .18s,background .18s}
    form.box input:focus,form.box select:focus,form.box textarea:focus,.filter input:focus,.filter select:focus{background:#fff!important;border-color:#2b73fe!important;box-shadow:0 0 0 3px rgba(43,115,254,.13)!important}
    button,.btn,a.btn,a.btn-excel{border-radius:9px!important;font-weight:650!important;box-shadow:0 4px 10px rgba(30,111,168,.13)}
    button:hover,.btn:hover,a.btn:hover,a.btn-excel:hover{box-shadow:0 7px 15px rgba(30,111,168,.2)}
    .pill{border-radius:999px!important;font-weight:650!important}
    .detail-modal-box,.laporan-modal-box{border-radius:16px!important;overflow:hidden!important}
    .detail-modal-box h3,.laporan-modal-box h3{padding:12px 14px!important;margin:-24px -24px 18px!important;color:#fff!important;background:#0d1b8c!important}
    .detail-grid div,.laporan-detail-grid>div,.laporan-material-grid>div{border-radius:10px!important;background:#f8fbff!important;border-color:#dbe5f0!important}
    .proses-tabel,.kebutuhan-tabel{border-radius:10px!important;overflow:hidden}.proses-tabel th,.kebutuhan-tabel th{background:#edf4ff!important;color:#123b5d!important}
    .vendor-form,.planning-result-box,.construction-report-box,.proses-box{border-radius:12px!important;border-color:#dbe5f0!important;box-shadow:0 3px 12px rgba(13,27,140,.05)}
    .notif-item{border-radius:11px!important}.notif-item.unread{border-left:4px solid #f4c300!important;background:#fffaf0!important}
    @media(max-width:700px){.box:not(.filter),.card,.vendor-card,.notif-box{padding:14px!important}.content>h1,.content>h2,.content>h3{font-size:20px!important}.tabel{font-size:11px!important}}
</style>
<style>
    /* PB/PD table shell: keep the record bar, action area and table as one visual panel. */
    .content .kartu{padding:0!important;background:#fff!important;border-color:#dbe5f0!important}
    .content .kartu .kartu-judul{min-height:45px!important;padding:12px 16px!important;background:#0d1b8c!important;margin:0!important;border-radius:12px 12px 0 0!important}
    .content .kartu>div:has(>#openSendModal){padding:12px 18px 10px!important;background:#0d1b8c!important}
    .content .kartu .scroll{margin:-12px 0 16px!important;background:#fff!important;border-top:0!important;border-radius:0 0 11px 11px!important}
    /* Report detail modal must remain usable when its content exceeds the viewport. */
    .laporan-modal{overflow-y:auto!important;overflow-x:hidden!important;align-items:start!important}
    .laporan-modal-box{max-height:calc(100vh - 40px)!important;overflow-y:auto!important;overflow-x:hidden!important;overscroll-behavior:contain;-webkit-overflow-scrolling:touch}
    body:has(#detailModalPerluasan) .detail-modal{overflow-y:auto!important;overflow-x:hidden!important;align-items:start!important}
    body:has(#detailModalPerluasan) .detail-modal-box{max-height:calc(100vh - 40px)!important;overflow-y:auto!important;overflow-x:hidden!important;overscroll-behavior:contain;-webkit-overflow-scrolling:touch}
    /* Consistent spacing for JTM, JTR and Tanpa Perluasan tables. */
    body:has(#detailModalPerluasan) .content .kartu{margin-top:8px!important;padding:0!important;border-radius:16px!important;overflow:hidden!important}
    body:has(#detailModalPerluasan) .content .kartu-judul{min-height:48px!important;margin:0!important;padding:14px 16px!important;border-radius:12px 12px 0 0!important}
    body:has(#detailModalPerluasan) .content .kartu .scroll{margin:0!important;border-radius:0!important;overflow-x:auto!important;overflow-y:visible!important}
    body:has(#detailModalPerluasan) .content .kartu .tabel{font-size:12px!important;line-height:1.45!important}
    body:has(#detailModalPerluasan) .content .kartu .tabel th,
    body:has(#detailModalPerluasan) .content .kartu .tabel td{padding:11px 12px!important;line-height:1.45!important}
    body:has(#detailModalPerluasan) .content .kartu .tabel th{font-size:11px!important;letter-spacing:.025em!important}
    body:has(#detailModalPerluasan) .content .kartu .kartu-kaki{margin:14px 16px 4px!important;line-height:1.5!important}
    body:has(#detailModalPerluasan) .content .kartu .halaman{margin:0 16px 16px!important}
    /* Apply the same readable spacing to the Data PB/PD table. */
    body:has(#sendModal) .content .kartu .scroll{margin:0!important;overflow-x:auto!important;overflow-y:visible!important;border-radius:0 0 11px 11px!important}
    body:has(#sendModal) .content .kartu .tabel{font-size:12px!important;line-height:1.45!important}
    body:has(#sendModal) .content .kartu .tabel th,
    body:has(#sendModal) .content .kartu .tabel td{padding:11px 12px!important;line-height:1.45!important}
    body:has(#sendModal) .content .kartu .tabel th{font-size:11px!important;letter-spacing:.025em!important}
    body:has(#sendModal) .content .filter input,
    body:has(#sendModal) .content .filter select{min-height:38px!important;padding-top:9px!important;padding-bottom:9px!important}
    body:has(#sendModal) .content .filter .btn{min-height:38px!important;padding-left:14px!important;padding-right:14px!important}
    body:has(#sendModal) .content .kartu .tabel tbody tr{min-height:46px!important}
    body:has(#sendModal) .content .kartu .tabel th,
    body:has(#sendModal) .content .kartu .tabel td{padding:12px 13px!important}
    body:has(#detailModalPerluasan) .content .perluasan-filter input,
    body:has(#detailModalPerluasan) .content .perluasan-filter select{background:#fff!important;border-color:#9fb4ca!important;color:#243b53!important}
    body:has(#detailModalPerluasan) .content .perluasan-filter input::placeholder{color:#627d98!important;opacity:1}
    body:has(#detailModalPerluasan) .content .perluasan-filter button[type="submit"]{background:#0d1b8c!important;color:#fff!important;border-color:#0d1b8c!important;box-shadow:0 4px 10px rgba(13,27,140,.22)!important}
    body:has(#detailModalPerluasan) .content .perluasan-filter button[type="submit"]:hover{background:#091267!important;border-color:#091267!important}
    /* Shared modal polish: consistent close action and spacing across the application. */
    .detail-modal,.laporan-modal{padding:24px!important;background:rgba(2,7,55,.58)!important;backdrop-filter:blur(3px)}
    .detail-modal-box,.laporan-modal-box{position:relative!important;border:1px solid #d9e2ec!important;border-radius:16px!important;background:#fff!important;color:#243b53!important;box-shadow:0 18px 48px rgba(13,27,140,.22)!important;overflow:auto!important}
    .detail-modal-box h3,.laporan-modal-box h3{padding:16px 54px 16px 20px!important;margin:0 0 18px!important;border-radius:15px 15px 0 0!important;background:#0d1b8c!important;color:#fff!important;font-size:16px!important;line-height:1.35!important}
    .detail-modal-close,.laporan-close,.history-close{position:absolute!important;top:12px!important;right:12px!important;z-index:20!important;display:grid!important;place-items:center!important;width:30px!important;height:30px!important;min-width:30px!important;min-height:30px!important;padding:0!important;border:1px solid #d9e2ec!important;border-radius:50%!important;background:#fff!important;color:#0d1b8c!important;font-size:21px!important;font-family:Arial,sans-serif!important;font-weight:700!important;line-height:30px!important;text-align:center!important;box-shadow:0 2px 7px rgba(0,0,0,.16)!important;cursor:pointer!important;opacity:1!important;visibility:visible!important;transition:background .18s,transform .18s,border-color .18s!important}
    .detail-modal-close:hover,.laporan-close:hover,.history-close:hover{background:#d9534f!important;border-color:#d9534f!important;color:#fff!important;transform:rotate(90deg)!important}
    .detail-modal-box form,.laporan-modal-box form{margin:0}.detail-modal-box h4,.laporan-modal-box h4{margin:18px 0 9px!important;color:#123b5d!important;font-size:14px!important}.detail-modal-box .detail-grid,.laporan-modal-box .laporan-detail-grid,.laporan-modal-box .laporan-material-grid{gap:10px!important}
    .detail-modal-box label,.laporan-modal-box label{color:#627d98!important;font-size:12px!important;font-weight:700!important;line-height:1.35!important}
    .detail-modal-box input:not([type="checkbox"]):not([type="radio"]),.detail-modal-box select,.detail-modal-box textarea,.laporan-modal-box input,.laporan-modal-box select,.laporan-modal-box textarea{border:1px solid #b8c9da!important;border-radius:8px!important;background:#fff!important;color:#243b53!important;font-family:Inter,Arial,sans-serif!important;font-size:13px!important;box-shadow:none!important}
    .detail-modal-box input:not([type="checkbox"]):not([type="radio"]):focus,.detail-modal-box select:focus,.detail-modal-box textarea:focus,.laporan-modal-box input:focus,.laporan-modal-box select:focus,.laporan-modal-box textarea:focus{outline:0!important;border-color:#1e6fa8!important;box-shadow:0 0 0 3px rgba(30,111,168,.13)!important}
    .detail-modal-box input[type="file"],.laporan-modal-box input[type="file"]{padding:7px!important;background:#f8fafc!important;color:#475569!important}
    .detail-modal-box button:not(.detail-modal-close),.laporan-modal-box button:not(.laporan-close){border-radius:8px!important;font-weight:700!important;box-shadow:0 3px 8px rgba(18,59,93,.12)!important}
    .detail-modal-box .kebutuhan-tabel,.detail-modal-box .proses-tabel,.laporan-modal-box .proses-tabel{border:1px solid #d9e2ec!important;border-radius:10px!important;background:#fff!important;overflow:hidden!important}
    .detail-modal-box .kebutuhan-tabel th,.detail-modal-box .proses-tabel th,.laporan-modal-box .proses-tabel th{background:#edf4ff!important;color:#123b5d!important;font-weight:700!important;border-color:#d9e2ec!important}
    .detail-modal-box .kebutuhan-tabel td,.detail-modal-box .kebutuhan-tabel th,.detail-modal-box .proses-tabel td,.detail-modal-box .proses-tabel th,.laporan-modal-box .proses-tabel td,.laporan-modal-box .proses-tabel th{padding:9px 10px!important;border-bottom:1px solid #e2e8f0!important}
    .detail-modal-box .detail-grid>div,.laporan-modal-box .laporan-detail-grid>div,.laporan-modal-box .laporan-material-grid>div{padding:11px!important;border:1px solid #d9e2ec!important;border-radius:9px!important;background:#f8fbff!important}
    .detail-modal-box .detail-grid small,.laporan-modal-box small{color:#627d98!important}.detail-modal-box .detail-grid b,.laporan-modal-box b{color:#243b53!important}
    .detail-modal-box .vendor-form,.detail-modal-box .planning-result-box,.detail-modal-box .construction-report-box,.detail-modal-box .proses-box,.laporan-modal-box .laporan-proses-box{padding:13px!important;border:1px solid #d9e2ec!important;border-radius:10px!important;background:#f8fbff!important;box-shadow:none!important}
    .detail-modal-box .syarat-files,.detail-modal-box .laporan-files,.laporan-modal-box .laporan-files{padding:10px!important;border:1px solid #d9e2ec!important;border-radius:9px!important;background:#f8fafc!important}
    .detail-modal-box a,.laporan-modal-box a{color:#1e6fa8!important}.detail-modal-box .proses-selesai,.laporan-modal-box .proses-selesai{color:#2e9b68!important}.detail-modal-box .proses-belum,.laporan-modal-box .proses-belum{color:#d9534f!important}
    @media(max-width:600px){.detail-modal,.laporan-modal{padding:12px!important}.detail-modal-box,.laporan-modal-box{width:100%!important;max-height:calc(100vh - 24px)!important}.detail-modal-box h3,.laporan-modal-box h3{padding-left:16px!important}}

    /* Sidebar visual refresh only: existing links, permissions and routes remain unchanged. */
    #mainSidebar{position:sticky!important;top:0!important;align-self:flex-start;width:230px!important;height:100vh!important;overflow-y:auto!important;overflow-x:hidden!important;padding:26px 14px 20px!important;background:#111c91!important;color:#fff!important;border-right:0!important;border-radius:0 0 18px 0;box-shadow:6px 0 20px rgba(17,28,145,.16)!important;scrollbar-width:thin;scrollbar-color:rgba(255,255,255,.3) transparent}
    #mainSidebar h2{margin:0 14px 3px!important;color:#fff!important;font-size:18px!important;font-weight:800!important;letter-spacing:.04em!important}
    #mainSidebar .role{margin:0 14px 24px!important;color:rgba(255,255,255,.68)!important;font-size:11px!important;letter-spacing:.02em}
    #mainSidebar a{position:relative;display:flex!important;align-items:center;gap:12px;margin:4px 0!important;padding:11px 12px!important;border:1px solid transparent!important;border-radius:11px!important;color:rgba(255,255,255,.78)!important;font-size:13px!important;font-weight:600!important;letter-spacing:.005em;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;transition:background .18s ease,color .18s ease,transform .18s ease,box-shadow .18s ease!important}
    #mainSidebar a::before{display:inline-flex!important;align-items:center;justify-content:center;width:20px;min-width:20px;flex:0 0 20px;text-align:center;color:rgba(255,255,255,.72);font-size:15px;line-height:1}
    #mainSidebar a[href$="/dashboard"]::before{content:'⌂'}
    #mainSidebar a[href$="/laporan"]::before{content:'▤'}
    #mainSidebar a[href$="/pbpd"]::before{content:'▣'}
    #mainSidebar a[href$="/perluasan/jtm"]::before,#mainSidebar a[href$="/perluasan/jtr"]::before{content:'↗';font-size:11px}
    #mainSidebar a[href$="/tanpa/perluasan"]::before{content:'○';font-size:11px}
    #mainSidebar a[href$="/pbpd-upload"]::before{content:'↑';font-size:13px}
    #mainSidebar a[href*="vendor"]::before{content:'▥'}
    #mainSidebar a[href$="/pengoperasian"]::before{content:'✓'}
    #mainSidebar a[href$="/pencarian"]::before{content:'⌕'}
    #mainSidebar a[href$="/notifikasi"]::before{content:'♧'}
    #mainSidebar a:hover{background:rgba(39,169,214,.2)!important;color:#fff!important;border-color:rgba(39,169,214,.24)!important;transform:translateX(2px)!important}
    #mainSidebar a.active{background:#fff!important;color:#111c91!important;box-shadow:0 5px 14px rgba(0,0,0,.12)!important;font-weight:750!important}
    #mainSidebar a.active::before{position:static!important;display:inline-flex!important;background:none!important;color:#111c91!important;width:20px!important;min-width:20px!important;height:20px!important;top:auto!important;right:auto!important;bottom:auto!important;left:auto!important;margin:0!important;transform:none!important}
    #mainSidebar a.active::after{right:12px!important;background:#facc15!important;width:6px!important;height:6px!important}
    #mainSidebar .notif-badge{margin-left:auto!important;background:#facc15!important;color:#172554!important;min-width:18px!important;border-radius:999px!important;font-size:10px!important;font-weight:800!important}
    @media(max-width:900px){#mainSidebar{width:210px!important}}
    @media(max-width:650px){#mainSidebar{position:fixed!important;top:0!important;left:0!important;width:250px!important;height:100vh!important;border-radius:0!important;padding:22px 14px!important}}
</style>
<script>document.getElementById('menuToggle')?.addEventListener('click',()=>document.body.classList.toggle('menu-open'));document.getElementById('mainSidebar')?.addEventListener('click',e=>{if(e.target.closest('a'))document.body.classList.remove('menu-open')});</script>
</body>
</html>
