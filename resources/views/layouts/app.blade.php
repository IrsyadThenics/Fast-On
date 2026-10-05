<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'FAST ON')</title>
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
    .halaman{color:#91a2bd}
    .menu-toggle{background:#17243c;color:#71d2e4}
    .notif-badge{background:#e05b61}
    .stat-card strong,.metric-card strong{font-variant-numeric:tabular-nums;letter-spacing:-.035em}
    @media(max-width:650px){aside{box-shadow:9px 0 28px rgba(0,0,0,.45)}body.menu-open::after{background:rgba(0,0,0,.58)}}
</style>
<script>document.getElementById('menuToggle')?.addEventListener('click',()=>document.body.classList.toggle('menu-open'));document.getElementById('mainSidebar')?.addEventListener('click',e=>{if(e.target.closest('a'))document.body.classList.remove('menu-open')});</script>
</body>
</html>
