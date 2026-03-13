@extends('layouts.app')
@section('title', 'Daftar Registrasi')
@section('page-title', 'Daftar Registrasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <form method="GET" class="d-flex gap-2 align-items-center flex-wrap" style="flex:1;">
        <input type="text" name="search" class="form-control" style="max-width:260px;"
            placeholder="Cari nama, no. reg, KTP..." value="{{ request('search') }}">
        <select name="status" class="form-select" style="max-width:160px;">
            <option value="">Semua Status</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="checked_out" {{ request('status') == 'checked_out' ? 'selected' : '' }}>Check-out</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
        <button type="submit" class="btn btn-gold"><i class="fas fa-search me-1"></i> Cari</button>
        @if(request()->hasAny(['search','status']))
            <a href="{{ route('registrations.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;">Reset</a>
        @endif
    </form>
    <a href="{{ route('registrations.create') }}" class="btn btn-gold ms-2">
        <i class="fas fa-plus me-1"></i> Registrasi Baru
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($registrations->isEmpty())
            <div class="text-center py-5" style="color:#CCC;">
                <i class="fas fa-inbox fa-3x mb-3"></i>
                <p>Tidak ada data registrasi</p>
            </div>
        @else
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>No. Registrasi</th>
                        <th>Tamu</th>
                        <th>Kamar</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th style="width:120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrations as $reg)
                    <tr>
                        <td><code style="font-size:.75rem;background:#F0EBE0;padding:2px 7px;border-radius:4px;color:#8B6914;">{{ $reg->registration_number }}</code></td>
                        <td>
                            <div style="font-weight:500;">{{ $reg->guest->full_name }}</div>
                            <div style="font-size:.75rem;color:#999;">{{ $reg->guest->nationality }} · {{ $reg->num_guests }} tamu</div>
                        </td>
                        <td>
                            <span style="font-weight:600;color:#0F3460;">{{ $reg->room->room_number }}</span>
                            <div style="font-size:.75rem;color:#999;">{{ $reg->room->roomType->name }}</div>
                        </td>
                        <td style="font-size:.85rem;">{{ $reg->check_in_date->format('d M Y') }}</td>
                        <td style="font-size:.85rem;">{{ $reg->check_out_date->format('d M Y') }}</td>
                        <td style="font-weight:600;color:#065F46;">Rp {{ number_format($reg->total_price, 0, ',', '.') }}</td>
                        <td>
                            @if($reg->status === 'active')
                                <span class="badge" style="background:#D1FAE5;color:#065F46;padding:4px 10px;border-radius:20px;font-size:.7rem;">● Aktif</span>
                            @elseif($reg->status === 'checked_out')
                                <span class="badge" style="background:#FEE2E2;color:#991B1B;padding:4px 10px;border-radius:20px;font-size:.7rem;">Check-out</span>
                            @else
                                <span class="badge" style="background:#E5E7EB;color:#374151;padding:4px 10px;border-radius:20px;font-size:.7rem;">Batal</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('registrations.show', $reg) }}" class="btn btn-sm" style="background:#F0EBE0;color:#8B6914;border-radius:6px;padding:4px 8px;font-size:.75rem;" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('registrations.print', $reg) }}" target="_blank" class="btn btn-sm" style="background:#EFF6FF;color:#1D4ED8;border-radius:6px;padding:4px 8px;font-size:.75rem;" title="Cetak">
                                    <i class="fas fa-print"></i>
                                </a>
                                @if($reg->status === 'active')
                                <form action="{{ route('registrations.checkout', $reg) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm" style="background:#FEF2F2;color:#991B1B;border-radius:6px;padding:4px 8px;font-size:.75rem;" title="Check-out"
                                        onclick="return confirm('Konfirmasi check-out?')">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $registrations->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
