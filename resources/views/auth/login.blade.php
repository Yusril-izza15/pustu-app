<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SIPUSTU</title>
    {{-- Path: resources/views/auth/login.blade.php --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Sora:wght@600;700&display=swap');

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --teal-600: #0d9488;
            --teal-500: #14b8a6;
            --teal-50:  #f0fdfa;
            --slate-800: #1e293b;
            --slate-600: #475569;
            --slate-400: #94a3b8;
            --slate-100: #f1f5f9;
            --red-500: #ef4444;
            --white: #ffffff;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: linear-gradient(135deg, #0d9488 0%, #0f766e 50%, #134e4a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        /* Card wrapper */
        .card-wrap {
            width: 100%;
            max-width: 420px;
            background: var(--white);
            border-radius: 1.5rem;
            box-shadow: 0 24px 60px rgba(0,0,0,.25);
            overflow: hidden;
        }

        /* Header strip */
        .card-header {
            background: linear-gradient(135deg, var(--teal-600), #0f766e);
            padding: 2rem 2rem 1.5rem;
            text-align: center;
        }
        .logo-icon {
            width: 56px; height: 56px;
            background: rgba(255,255,255,.15);
            border-radius: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: .75rem;
        }
        .logo-icon svg { width: 30px; height: 30px; fill: white; }
        .card-header h1 {
            font-family: 'Sora', sans-serif;
            font-size: 1.4rem;
            color: white;
            letter-spacing: .5px;
        }
        .card-header p { font-size: .85rem; color: rgba(255,255,255,.75); margin-top: .25rem; }

        /* Body */
        .card-body { padding: 2rem; }

        /* Alert error */
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: .75rem;
            padding: .85rem 1rem;
            margin-bottom: 1.25rem;
            font-size: .85rem;
            color: var(--red-500);
        }
        .alert-error ul { padding-left: 1.1rem; }

        /* Form group */
        .form-group { margin-bottom: 1.1rem; }
        .form-group label {
            display: block;
            font-size: .82rem;
            font-weight: 600;
            color: var(--slate-600);
            margin-bottom: .4rem;
            text-transform: uppercase;
            letter-spacing: .5px;
        }
        .form-group input {
            width: 100%;
            padding: .75rem 1rem;
            border: 1.5px solid #e2e8f0;
            border-radius: .75rem;
            font-family: 'DM Sans', sans-serif;
            font-size: .95rem;
            color: var(--slate-800);
            background: var(--slate-100);
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }
        .form-group input:focus {
            border-color: var(--teal-500);
            box-shadow: 0 0 0 3px rgba(20,184,166,.12);
            background: white;
        }
        .form-group input.is-invalid { border-color: var(--red-500); }

        /* Submit button */
        .btn-login {
            width: 100%;
            padding: .85rem;
            background: linear-gradient(135deg, var(--teal-600), #0f766e);
            color: white;
            border: none;
            border-radius: .75rem;
            font-family: 'Sora', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: .5rem;
            transition: transform .15s, box-shadow .15s;
            letter-spacing: .3px;
        }
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(13,148,136,.4);
        }
        .btn-login:active { transform: translateY(0); }

        /* Footer note */
        .card-footer {
            text-align: center;
            padding: 0 2rem 1.75rem;
            font-size: .8rem;
            color: var(--slate-400);
        }
    </style>
</head>
<body>

<div class="card-wrap">

    {{-- Header --}}
    <div class="card-header">
        <div class="logo-icon">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 2c2.76 0 5 2.24 5 5 0 3.42-4.15 8.56-5 9.65C11.15 17.56 7 12.42 7 9c0-2.76 2.24-5 5-5zm-1 3v2H9v2h2v2h2v-2h2V9h-2V7h-2z"/>
            </svg>
        </div>
        <h1>SIPUSTU</h1>
        <p>Sistem Informasi Puskesmas Pembantu</p>
    </div>

    {{-- Body --}}
    <div class="card-body">

        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="nama@email.com"
                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                    autofocus
                    autocomplete="email"
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="••••••••"
                    class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                    autocomplete="current-password"
                >
            </div>

            <button type="submit" class="btn-login">Masuk →</button>
        </form>

    </div>

    <div class="card-footer">
        Hubungi administrator jika lupa password.
    </div>

</div>

</body>
</html>
