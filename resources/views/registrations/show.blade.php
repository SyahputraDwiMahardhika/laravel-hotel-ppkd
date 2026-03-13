@extends('layouts.app')
@section('title', 'Detail Registrasi')
@section('page-title', 'Detail Registrasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <span style="font-size:.8rem;color:#999;">No. Registrasi:</span>
        <code style="background:#F0EBE0;color:#8B6914;padding:3px 10px;border-radius:6px;font-size:.9rem;margin-left:6px;">{{ $registration->registration_number }}</code>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('registrations.print', $registration) }}" target="_blank" class="btn btn-outline-gold" onclick="window.open(this.href,'_blank'); return false;">
            <i class="fas fa-print me-1"></i> Cetak
        </a>
        @if($registration->status === 'active')
        <form action="{{ route('registrations.checkout', $registration) }}" method="POST">
            @csrf @method('PATCH')
            <button type="submit" class="btn" style="background:#FEF2F2;color:#991B1B;border:1.5px solid #FCA5A5;border-radius:8px;"
                onclick="return confirm('Konfirmasi check-out tamu ini?')">
                <i class="fas fa-sign-out-alt me-1"></i> Check-out
            </button>
        </form>
        @endif
        <a href="{{ route('registrations.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

@if($registration->status === 'checked_out')
    <div class="alert alert-warning mb-4">
        <i class="fas fa-info-circle me-2"></i>Tamu telah check-out pada {{ $registration->departure_date?->format('d M Y') ?? 'N/A' }}.
    </div>
@endif

<div class="row g-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header"><h5><i class="fas fa-user me-2" style="color:#C9A84C"></i>Data Tamu</h5></div>
            <div class="card-body">
                <table class="table table-borderless mb-0" style="font-size:.875rem;">
                    <tr><td style="color:#999;width:40%">Nama Lengkap</td><td><strong>{{ $registration->guest->full_name }}</strong></td></tr>
                    <tr><td style="color:#999">Pekerjaan</td><td>{{ $registration->guest->occupation ?: '—' }}</td></tr>
                    <tr><td style="color:#999">Perusahaan</td><td>{{ $registration->guest->company ?: '—' }}</td></tr>
                    <tr><td style="color:#999">Kebangsaan</td><td>{{ $registration->guest->nationality }}</td></tr>
                    <tr><td style="color:#999">No. KTP</td><td>{{ $registration->guest->id_card_number ?: '—' }}</td></tr>
                    <tr><td style="color:#999">No. Passport</td><td>{{ $registration->guest->passport_number ?: '—' }}</td></tr>
                    <tr><td style="color:#999">No. Telepon</td><td>{{ $registration->guest->phone_number ?: '—' }}</td></tr>
                    <tr><td style="color:#999">No. Member</td><td>{{ $registration->guest->member_number ?: '—' }}</td></tr>
                    <tr><td style="color:#999">Alamat</td><td>{{ $registration->guest->address ?: '—' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header"><h5><i class="fas fa-door-open me-2" style="color:#C9A84C"></i>Informasi Menginap</h5></div>
            <div class="card-body">
                <table class="table table-borderless mb-0" style="font-size:.875rem;">
                    <tr><td style="color:#999;width:40%">Kamar</td><td><strong>No. {{ $registration->room->room_number }}</strong> — {{ $registration->room->roomType->name }}</td></tr>
                    <tr><td style="color:#999">Tipe Kamar</td><td>{{ $registration->room->roomType->name }}</td></tr>
                    <tr><td style="color:#999">Jumlah Tamu</td><td>{{ $registration->num_guests }} orang</td></tr>
                    <tr><td style="color:#999">Jumlah Kamar</td><td>{{ $registration->num_rooms }} kamar</td></tr>
                    <tr><td style="color:#999">Check-in</td><td>{{ $registration->check_in_date->format('d M Y') }} pkl {{ $registration->arrival_time }}</td></tr>
                    <tr><td style="color:#999">Check-out</td><td>{{ $registration->check_out_date->format('d M Y') }}</td></tr>
                    <tr><td style="color:#999">Lama Menginap</td><td>{{ $registration->nights }} malam</td></tr>
                    <tr><td style="color:#999">Total Biaya</td><td><strong style="color:#065F46;font-size:1rem;">Rp {{ number_format($registration->total_price, 0, ',', '.') }}</strong></td></tr>
                    <tr><td style="color:#999">No. Deposit Box</td><td>{{ $registration->deposit_box_number ?: '—' }}</td></tr>
                    <tr><td style="color:#999">Resepsionis</td><td>{{ $registration->receptionist->name }}</td></tr>
                    <tr><td style="color:#999">Issued By</td><td>{{ $registration->issued_by ?: '—' }}</td></tr>
                    <tr><td style="color:#999">Status</td>
                        <td>
                            @if($registration->status === 'active')
                                <span class="badge" style="background:#D1FAE5;color:#065F46;padding:5px 10px;border-radius:20px;">● Aktif</span>
                            @elseif($registration->status === 'checked_out')
                                <span class="badge" style="background:#FEE2E2;color:#991B1B;padding:5px 10px;border-radius:20px;">Check-out</span>
                            @else
                                <span class="badge" style="background:#E5E7EB;color:#374151;padding:5px 10px;border-radius:20px;">Dibatalkan</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@if($registration->notes)
<div class="card mt-4">
    <div class="card-header"><h5><i class="fas fa-sticky-note me-2" style="color:#C9A84C"></i>Catatan</h5></div>
    <div class="card-body" style="font-size:.875rem;color:#555;">{{ $registration->notes }}</div>
</div>
@endif
@endsection
