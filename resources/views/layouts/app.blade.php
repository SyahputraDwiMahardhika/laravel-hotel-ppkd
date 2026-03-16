<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PPKD JP Perhotelan') — Sistem Pembelajaran Hotel</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --gold: #C9A84C;
            --gold-light: #E8C96B;
            --dark: #1A1A2E;
            --dark-2: #16213E;
            --dark-3: #0F3460;
            --sidebar-w: 260px;
            --cream: #FAF7F2;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: #2C2C2C;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: linear-gradient(180deg,
                    var(--dark),
                    var(--dark-2));
            z-index: 1000;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            transition: transform .3s ease;
        }

        .sidebar-brand {
            padding: 28px 24px 20px;
            border-bottom: 1px solid rgba(201, 168, 76, .2);
        }

        .sidebar-brand h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--gold);
            margin: 0;
            letter-spacing: 1px;
        }

        .sidebar-brand p {
            color: rgba(255, 255, 255, .45);
            font-size: .72rem;
            margin: 4px 0 0;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .sidebar-nav {
            padding: 16px 0;
            flex: 1;
        }

        .nav-section-label {
            color: rgba(255, 255, 255, .3);
            font-size: .65rem;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            padding: 12px 24px 6px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 24px;
            color: rgba(255, 255, 255, .7);
            text-decoration: none;
            font-size: .875rem;
            font-weight: 400;
            transition: all .2s;
            border-left: 3px solid transparent;
            position: relative;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            color: #fff;
            background: linear-gradient(90deg,
                    rgba(201, 168, 76, .18),
                    rgba(201, 168, 76, .05));
            border-left-color: var(--gold);
        }

        .sidebar-nav a i {
            width: 18px;
            text-align: center;
            font-size: .9rem;
        }

        .sidebar-footer {
            padding: 20px 24px;
            border-top: 1px solid rgba(255, 255, 255, .08);
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--gold), var(--dark-3));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: .85rem;
            font-weight: 600;
            flex-shrink: 0;
        }

        .user-info p {
            margin: 0;
        }

        .user-name {
            color: #fff;
            font-size: .82rem;
            font-weight: 500;
        }

        .user-role {
            font-size: .68rem;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: var(--sidebar-w);
            border-left: 1px solid #EDE8DE;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background: linear-gradient(180deg,
                    #ffffff,
                    #fbfaf7);
            padding: 16px 32px;
            border-bottom: 1px solid #EDE8DE;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 8px rgba(0, 0, 0, .04);
        }

        .topbar-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }

        .page-content {
            padding: 32px;
            flex: 1;
            background: #F8F9FB;
        }

        /* CARDS */
        .card {
            border: 1px solid #EDE8DE;
            background: #ffffff;
            backdrop-filter: blur(4px);
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .04);
            background: #fff;
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #EDE8DE;
            padding: 16px 20px;
            border-radius: 12px 12px 0 0 !important;
        }

        .card-header h5 {
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem;
            margin: 0;
            color: var(--dark);
        }

        /* STAT CARDS */
        .stat-card {
            border-radius: 14px;
            padding: 22px 24px;
            position: relative;
            overflow: hidden;
            border: 1px solid #EDE8DE;
            background: linear-gradient(135deg,
                    #ffffff,
                    #faf6ee);
            box-shadow: 0 6px 22px rgba(0, 0, 0, .06);
            transition: all .25s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 28px rgba(0, 0, 0, .08);
        }

        .stat-card .icon-bg {
            position: absolute;
            right: -10px;
            top: -10px;
            font-size: 5rem;
            opacity: .1;
        }

        .stat-card .stat-number {
            font-size: 2.2rem;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
            line-height: 1;
        }

        .stat-card .stat-label {
            font-size: .78rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-top: 4px;
            opacity: .8;
        }

        /* BADGE STATUS */
        .badge-available {
            background: #D1FAE5;
            color: #065F46;
        }

        .badge-occupied {
            background: #FEE2E2;
            color: #991B1B;
        }

        .badge-cleaning {
            background: #FEF3C7;
            color: #92400E;
        }

        .badge-maintenance {
            background: #E5E7EB;
            color: #374151;
        }

        .badge-out_of_order {
            background: #F3F4F6;
            color: #6B7280;
        }

        /* FORMS */
        .form-label {
            font-size: .8rem;
            font-weight: 600;
            color: #555;
            text-transform: uppercase;
            letter-spacing: .8px;
            margin-bottom: 5px;
        }

        .form-control,
        .form-select {
            border: 1.5px solid #DDD8CE;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: .88rem;
            background: #FAFAF9;
            transition: border .2s, box-shadow .2s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201, 168, 76, .12);
            background: #fff;
        }

        /* BUTTONS */
        .btn-gold {
            background: linear-gradient(135deg, var(--gold), #B8903E);
            color: #fff;
            border: none;
            font-weight: 500;
            letter-spacing: .5px;
            border-radius: 8px;
            padding: 10px 22px;
            transition: all .2s;
        }

        .btn-gold:hover {
            background: linear-gradient(135deg, var(--gold-light), var(--gold));
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(201, 168, 76, .35);
        }

        .btn-outline-gold {
            border: 1.5px solid var(--gold);
            color: var(--gold);
            background: transparent;
            border-radius: 8px;
            padding: 8px 18px;
            font-weight: 500;
            transition: all .2s;
        }

        .btn-outline-gold:hover {
            background: var(--gold);
            color: #fff;
        }

        /* TABLE */
        .table th {
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #888;
            font-weight: 600;
            border-bottom: 2px solid #EDE8DE;
            padding: 12px 16px;
            background: #FAFAF9;
        }

        .table td {
            padding: 12px 16px;
            vertical-align: middle;
            border-color: #F0EBE0;
            font-size: .875rem;
        }

        .table tbody tr:hover {
            background: #FDFAF5;
        }

        /* ROOM GRID */
        .room-card {
            border-radius: 12px;
            padding: 16px;
            border: 2px solid transparent;
            cursor: pointer;
            transition: all .25s;
        }

        .room-card.available {
            background: #F0FDF4;
            border-color: #86EFAC;
        }

        .room-card.occupied {
            background: #FEF2F2;
            border-color: #FCA5A5;
        }

        .room-card.cleaning {
            background: #FFFBEB;
            border-color: #FCD34D;
        }

        .room-card.maintenance {
            background: #F3F4F6;
            border-color: #D1D5DB;
        }

        .room-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, .08);
        }

        .room-number {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
        }

        /* ALERTS */
        .alert {
            border-radius: 10px;
            border: none;
            font-size: .875rem;
        }

        .alert-success {
            background: #ECFDF5;
            color: #065F46;
            border-left: 4px solid #10B981;
        }

        .alert-danger {
            background: #FEF2F2;
            color: #991B1B;
            border-left: 4px solid #EF4444;
        }

        .alert-warning {
            background: #FFFBEB;
            color: #92400E;
            border-left: 4px solid #F59E0B;
        }

        /* PRINT */
        @media print {

            .sidebar,
            .topbar,
            .no-print {
                display: none !important;
            }

            .main-content {
                margin-left: 0 !important;
            }

            .page-content {
                padding: 0 !important;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h1>
                <i class="fas fa-hotel me-2" style="font-size:1.1rem"></i>
                PPKD JP
            </h1>
            <p>Jurusan Perhotelan</p>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-section-label">Main</div>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i> Dashboard
            </a>

            <div class="nav-section-label">Operasional</div>
            <a href="{{ route('registrations.create') }}"
                class="{{ request()->routeIs('registrations.create') ? 'active' : '' }}">
                <i class="fas fa-plus-circle"></i> Registrasi Baru
            </a>
            <a href="{{ route('registrations.index') }}"
                class="{{ request()->routeIs('registrations.index') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list"></i> Daftar Registrasi
            </a>
            <a href="{{ route('rooms.index') }}" class="{{ request()->routeIs('rooms.*') ? 'active' : '' }}">
                <i class="fas fa-door-open"></i> Status Kamar
            </a>

            @if (auth()->user()->isAdmin())
                <div class="nav-section-label">Administrasi</div>
                <a href="{{ route('rooms.create') }}" class="{{ request()->routeIs('rooms.create') ? 'active' : '' }}">
                    <i class="fas fa-bed"></i> Kelola Kamar
                </a>
                <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="fas fa-users-cog"></i> Kelola Karyawan
                </a>
            @endif
        </nav>
        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                <div class="user-info">
                    <p class="user-name">{{ auth()->user()->name }}</p>
                    <p class="user-role">{{ auth()->user()->role }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="btn btn-sm w-100"
                    style="background:rgba(255,255,255,.08);color:rgba(255,255,255,.6);border:1px solid rgba(255,255,255,.1);border-radius:8px;font-size:.8rem;">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="main-content">
        <header class="topbar">
            <h2 class="topbar-title">@yield('page-title', 'Dashboard')</h2>
            <div class="d-flex align-items-center gap-3">
                <span style="font-size:.8rem;color:#999;">{{ now()->isoFormat('dddd, D MMMM YYYY') }}</span>
                @if (auth()->user()->isAdmin())
                    <span class="badge"
                        style="background:linear-gradient(135deg,var(--gold),#B8903E);color:#fff;font-size:.7rem;padding:5px 10px;border-radius:20px;letter-spacing:.5px;">
                        <i class="fas fa-shield-alt me-1"></i>ADMINISTRATOR
                    </span>
                @else
                    <span class="badge"
                        style="background:#E8F4FD;color:#1A6FA0;font-size:.7rem;padding:5px 10px;border-radius:20px;">
                        <i class="fas fa-user me-1"></i>RESEPSIONIS
                    </span>
                @endif
            </div>
        </header>

        <main class="page-content">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
