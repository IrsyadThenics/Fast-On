<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - FAST ON</title>
    <style>
        * { box-sizing: border-box; }
        body { margin:0; min-height:100vh; display:flex; align-items:center; justify-content:center;
               background:#eef3f8; font-family: system-ui, Arial, sans-serif; }
        .card { width:100%; max-width:380px; background:#fff; padding:32px; border-radius:12px;
                box-shadow:0 4px 20px rgba(0,0,0,.08); }
        h1 { margin:0 0 4px; font-size:24px; text-align:center; color:#0b5ea8; }
        p.sub { margin:0 0 24px; text-align:center; color:#667; font-size:14px; }
        label { display:block; margin:14px 0 6px; font-size:14px; color:#334; }
        input { width:100%; padding:10px 12px; border:1px solid #c8d1dc; border-radius:8px; font-size:15px; }
        input:focus { outline:2px solid #0b5ea8; border-color:transparent; }
        button { width:100%; margin-top:22px; padding:11px; border:0; border-radius:8px;
                 background:#0b5ea8; color:#fff; font-size:15px; cursor:pointer; }
        button:hover { background:#094c88; }
        .error { margin-top:6px; color:#c0392b; font-size:13px; }
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