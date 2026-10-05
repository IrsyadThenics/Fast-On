<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - FAST ON</title>
    <style>
        * { box-sizing: border-box; }
        body { margin:0; min-height:100vh; display:flex; align-items:center; justify-content:center; position:relative; overflow:hidden;
               background:radial-gradient(circle at 50% 0%,#182746 0,#0d1629 42%,#080e1b 100%);
               font-family:Inter,"Plus Jakarta Sans","Segoe UI",system-ui,Arial,sans-serif; color:#dbe7f6; }
        body::before { content:""; position:fixed; inset:0; z-index:0; pointer-events:none;
                       background-image:linear-gradient(rgba(8,14,27,.82),rgba(8,14,27,.82)),url('{{ asset('images/faston.png') }}');
                       background-position:center; background-repeat:no-repeat; background-size:cover; opacity:.48; filter:saturate(1); }
        body::after { content:""; position:fixed; width:480px; height:480px; right:-180px; bottom:-220px; border-radius:50%;
                      background:radial-gradient(circle,rgba(32,184,207,.2),transparent 68%); pointer-events:none; }
        .card { width:100%; max-width:410px; background:linear-gradient(145deg,#172742,#111c31); padding:34px;
                border:1px solid #2c4568; border-radius:16px; box-shadow:0 22px 55px rgba(0,0,0,.38); position:relative; z-index:1; }
        h1 { margin:0 0 5px; font-size:25px; letter-spacing:.04em; text-align:center; color:#eef7ff; }
        p.sub { margin:0 0 25px; text-align:center; color:#8fa3bf; font-size:13px; }
        label { display:block; margin:15px 0 7px; font-size:12px; font-weight:650; color:#b8cbe0; }
        input { width:100%; padding:11px 12px; border:1px solid #385170; border-radius:8px; background:#0d192c;
                color:#eef7ff; font-size:14px; transition:border-color .2s,box-shadow .2s; }
        input:focus { outline:0; border-color:#20b8cf; box-shadow:0 0 0 3px rgba(32,184,207,.14); }
        button { width:100%; margin-top:22px; padding:11px; border:0; border-radius:8px;
                 background:linear-gradient(135deg,#20aeca,#178cae); color:#061522; font-size:14px; font-weight:700; cursor:pointer;
                 box-shadow:0 7px 16px rgba(32,174,202,.2); transition:all .2s; }
        button:hover { background:linear-gradient(135deg,#47c7df,#20aeca); transform:translateY(-1px); box-shadow:0 10px 20px rgba(32,174,202,.28); }
        .error { margin-top:6px; color:#ff8590; font-size:12px; }
        @media (max-width:600px) { body::before { background-size:cover; opacity:.38; } }
    </style>
</head>
<body>
    <form class="card" method="POST" action="{{ route('login.attempt') }}">
        @csrf
        <h1>FAST ON</h1>
        <p class="sub">Silakan masuk dengan akun yang diberikan</p>

        <label for="user_id">ID Pengguna</label>
        <input id="user_id" name="user_id" value="{{ old('user_id') }}" autofocus required>
        @error('user_id') <div class="error">{{ $message }}</div> @enderror

        <label for="password">Kata sandi</label>
        <input id="password" type="password" name="password" required>
        @error('password') <div class="error">{{ $message }}</div> @enderror

        <button type="submit">Masuk</button>
    </form>
</body>
</html>
