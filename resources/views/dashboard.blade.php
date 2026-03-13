@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#1A1A2E,#0F3460);color:#fff;">
            <i class="fas fa-door-open icon-bg"></i>
            <div class="stat-number">{{ $stats['total_rooms'] }}</div>
            <div class="stat-label">Total Kamar</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#065F46,#047857);color:#fff;">
            <i class="fas fa-check-circle icon-bg"></i>
            <div class="stat-number">{{ $stats['available'] }}</div>
            <div class="stat-label">Tersedia</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#991B1B,#B91C1C);color:#fff;">
            <i class="fas fa-user-check icon-bg"></i>
            <div class="stat-number">{{ $stats['occupied'] }}</div>
            <div class="stat-label">Terisi</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#C9A84C,#B8903E);color:#fff;">
            <i class="fas fa-broom icon-bg"></i>
            <div class="stat-number">{{ $stats['cleaning'] }}</div>
            <div class="stat-label">Sedang Dibersihkan</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body p-4 text-center">
                <div style="font-size:2.5rem;color:#0F3460;font-family:'Playfair Display',serif;font-weight:700;">{{ $stats['today_checkins'] }}</div>
                <div style="font-size:.75rem;color:#999;text-transform:uppercase;letter-spacing:1.5px;margin-top:4px;"><i class="fas fa-sign-in-alt me-1 text-success"></i>Check-in Hari Ini</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body p-4 text-center">
                <div style="font-size:2.5rem;color:#991B1B;font-family:'Playfair Display',serif;font-weight:700;">{{ $stats['today_checkouts'] }}</div>
                <div style="font-size:.75rem;color:#999;text-transform:uppercase;letter-spacing:1.5px;margin-top:4px;"><i class="fas fa-sign-out-alt me-1 text-danger"></i>Check-out Hari Ini</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body p-4 text-center">
                <div style="font-size:2.5rem;color:#C9A84C;font-family:'Playfair Display',serif;font-weight:700;">{{ $stats['total_guests'] }}</div>
                <div style="font-size:.75rem;color:#999;text-transform:uppercase;letter-spacing:1.5px;margin-top:4px;"><i class="fas fa-users me-1" style="color:#C9A84C"></i>Total Tamu Terdaftar</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Registrations -->
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5><i class="fas fa-clipboard-list me-2" style="color:#C9A84C"></i>Registrasi Aktif Terbaru</h5>
                <a href="{{ route('registrations.index') }}" class="btn btn-sm btn-outline-gold">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                @if($recentRegistrations->isEmpty())
                    <div class="text-center py-5" style="color:#CCC;">
                        <i class="fas fa-inbox fa-2x mb-2"></i>
                        <p class="mb-0">Belum ada registrasi aktif</p>
                    </div>
                @else
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>No. Reg</th>
                                <th>Tamu</th>
                                <th>Kamar</th>
                                <th>Check-out</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentRegistrations as $reg)
                            <tr>
                                <td><code style="font-size:.75rem;background:#F0EBE0;padding:2px 7px;border-radius:4px;">{{ $reg->registration_number }}</code></td>
                                <td>
                                    <div style="font-weight:500;font-size:.875rem;">{{ $reg->guest->full_name }}</div>
                                    <div style="font-size:.75rem;color:#999;">{{ $reg->guest->nationality }}</div>
                                </td>
                                <td>
                                    <span style="font-weight:600;color:#0F3460;">{{ $reg->room->room_number }}</span>
                                    <div style="font-size:.75rem;color:#999;">{{ $reg->room->roomType->name }}</div>
                                </td>
                                <td style="font-size:.85rem;">{{ $reg->check_out_date->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('registrations.show', $reg) }}" class="btn btn-sm" style="background:#F0EBE0;color:#8B6914;border-radius:6px;font-size:.75rem;padding:4px 10px;">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Today Checkouts -->
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header">
                <h5><i class="fas fa-calendar-check me-2" style="color:#EF4444"></i>Due Check-out Hari Ini</h5>
            </div>
            <div class="card-body p-0">
                @if($todayCheckouts->isEmpty())
                    <div class="text-center py-5" style="color:#CCC;">
                        <i class="fas fa-check-circle fa-2x mb-2 text-success"></i>
                        <p class="mb-0">Tidak ada check-out hari ini</p>
                    </div>
                @else
                    @foreach($todayCheckouts as $reg)
                    <div class="d-flex align-items-center justify-content-between p-3" style="border-bottom:1px solid #F0EBE0;">
                        <div>
                            <div style="font-weight:500;font-size:.875rem;">{{ $reg->guest->full_name }}</div>
                            <div style="font-size:.75rem;color:#999;">Kamar {{ $reg->room->room_number }}</div>
                        </div>
                        <form action="{{ route('registrations.checkout', $reg) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-sm" style="background:#FEF2F2;color:#991B1B;border:1px solid #FCA5A5;border-radius:7px;font-size:.75rem;"
                                onclick="return confirm('Konfirmasi check-out {{ $reg->guest->full_name }}?')">
                                <i class="fas fa-sign-out-alt me-1"></i>Check-out
                            </button>
                        </form>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
