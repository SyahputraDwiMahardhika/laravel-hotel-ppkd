<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Hotel Grande</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --gold: #C9A84C; --dark: #1A1A2E; }
        * { box-sizing: border-box; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--dark);
            min-height: 100vh;
            display: flex;
            align-items: stretch;
            overflow: hidden;
        }
        .login-left {
             flex: 1;
    background: linear-gradient(rgba(0,0,0,.65), rgba(0,0,0,.65));
    background-size: cover;
    background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px;
            position: relative;
            overflow: hidden;
        }
        .login-left::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            border-radius: 50%;
            border: 1px solid rgba(201,168,76,.1);
            top: 50%; left: 50%;
            transform: translate(-50%,-50%);
        }
        .login-left::after {
            content: '';
            position: absolute;
            width: 700px; height: 700px;
            border-radius: 50%;
            border: 1px solid rgba(201,168,76,.06);
            top: 50%; left: 50%;
            transform: translate(-50%,-50%);
        }
        .brand-logo {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            color: var(--gold);
            text-align: center;
            position: relative;
            z-index: 1;
        }
        .brand-subtitle {
            color: rgba(255,255,255,.5);
            font-size: .85rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-top: 8px;
            text-align: center;
            position: relative;
            z-index: 1;
        }
        .brand-divider {
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            margin: 20px auto;
            position: relative;
            z-index: 1;
        }
        .brand-quote {
            color: rgba(255,255,255,.35);
            font-size: .85rem;
            text-align: center;
            font-style: italic;
            max-width: 300px;
            position: relative;
            z-index: 1;
        }
        .login-right {
            width: 480px;
            background: #FAF7F2;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 48px;
        }
        .login-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--dark);
            margin-bottom: 6px;
        }
        .login-subtitle {
            color: #999;
            font-size: .875rem;
            margin-bottom: 36px;
        }
        .form-label {
            font-size: .75rem;
            font-weight: 600;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .form-control {
            border: 1.5px solid #DDD8CE;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: .9rem;
            background: #fff;
            transition: all .2s;
        }
        .form-control:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201,168,76,.12);
        }
        .input-icon {
            position: relative;
        }
        .input-icon i {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #CCC;
            font-size: .85rem;
        }
        .btn-login {
            background: linear-gradient(135deg, var(--gold), #B8903E);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 13px;
            font-size: .95rem;
            font-weight: 600;
            width: 100%;
            letter-spacing: .5px;
            transition: all .25s;
            margin-top: 8px;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(201,168,76,.4);
            background: linear-gradient(135deg, #E8C96B, var(--gold));
            color: #fff;
        }
        .alert-danger {
            border-radius: 10px;
            border: none;
            background: #FEF2F2;
            color: #991B1B;
            border-left: 4px solid #EF4444;
            font-size: .85rem;
        }
        .form-check-input:checked { background-color: var(--gold); border-color: var(--gold); }
        @media (max-width: 768px) {
            .login-left { display: none; }
            .login-right { width: 100%; padding: 40px 28px; }
        }
    </style>
</head>
<body>
    <div class="login-left">
        <div class="brand-logo">
            <i class="fas fa-crown d-block mb-3" style="font-size:2.5rem;"></i>
            PPKD Jakarta Pusat
        </div>
        <div class="brand-subtitle">Jurusan Perhotelan</div>
        <div class="brand-divider"></div>
        <p class="brand-quote">"Sistem pembelajaran dan simulasi manajemen hotel untuk peserta pelatihan PPKD Jakarta Pusat."</p>
    </div>

    <div class="login-right">
        <h2 class="login-title">Selamat Datang</h2>
        <p class="login-subtitle">Masuk untuk mengakses sistem manajemen hotel</p>

        @if($errors->any())
            <div class="alert alert-danger mb-3">
                <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <div class="input-icon">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" placeholder="email@hotelgrande.com" required autofocus>
                    <i class="fas fa-envelope"></i>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-icon">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="••••••••" required>
                    <i class="fas fa-lock"></i>
                </div>
            </div>
            <div class="mb-4 d-flex align-items-center justify-content-between">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember" style="font-size:.85rem;color:#666;">Ingat saya</label>
                </div>
            </div>
            <button type="submit" class="btn btn-login">
                <i class="fas fa-sign-in-alt me-2"></i> Masuk ke Sistem
            </button>
        </form>

        <div class="mt-5 pt-4" style="border-top:1px solid #EDE8DE;">
            <p style="font-size:.75rem;color:#BBB;text-align:center;">
                <i class="fas fa-shield-alt me-1"></i>Akses terbatas untuk karyawan yang berwenang
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
