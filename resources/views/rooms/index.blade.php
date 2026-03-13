@extends('layouts.app')
@section('title', 'Status Kamar')
@section('page-title', 'Status Kamar')

@section('content')
<!-- Status Summary -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:#F0FDF4;border:1.5px solid #86EFAC;">
            <div style="width:12px;height:12px;border-radius:50%;background:#22C55E;flex-shrink:0;"></div>
            <div>
                <div style="font-size:1.5rem;font-weight:700;font-family:'Playfair Display',serif;color:#15803D;">{{ $statusCounts['available'] ?? 0 }}</div>
                <div style="font-size:.72rem;color:#16A34A;text-transform:uppercase;letter-spacing:1px;">Tersedia</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:#FEF2F2;border:1.5px solid #FCA5A5;">
            <div style="width:12px;height:12px;border-radius:50%;background:#EF4444;flex-shrink:0;"></div>
            <div>
                <div style="font-size:1.5rem;font-weight:700;font-family:'Playfair Display',serif;color:#DC2626;">{{ $statusCounts['occupied'] ?? 0 }}</div>
                <div style="font-size:.72rem;color:#DC2626;text-transform:uppercase;letter-spacing:1px;">Terisi</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:#FFFBEB;border:1.5px solid #FCD34D;">
            <div style="width:12px;height:12px;border-radius:50%;background:#F59E0B;flex-shrink:0;"></div>
            <div>
                <div style="font-size:1.5rem;font-weight:700;font-family:'Playfair Display',serif;color:#D97706;">{{ $statusCounts['cleaning'] ?? 0 }}</div>
                <div style="font-size:.72rem;color:#D97706;text-transform:uppercase;letter-spacing:1px;">Dibersihkan</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:#F3F4F6;border:1.5px solid #D1D5DB;">
            <div style="width:12px;height:12px;border-radius:50%;background:#9CA3AF;flex-shrink:0;"></div>
            <div>
                <div style="font-size:1.5rem;font-weight:700;font-family:'Playfair Display',serif;color:#4B5563;">{{ $statusCounts['maintenance'] ?? 0 }}</div>
                <div style="font-size:.72rem;color:#6B7280;text-transform:uppercase;letter-spacing:1px;">Maintenance</div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="d-flex gap-2 mb-4 flex-wrap align-items-center justify-content-between">
    <form method="GET" class="d-flex gap-2">
        <select name="status" class="form-select" style="max-width:180px;" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
            <option value="occupied" {{ request('status') == 'occupied' ? 'selected' : '' }}>Terisi</option>
            <option value="cleaning" {{ request('status') == 'cleaning' ? 'selected' : '' }}>Dibersihkan</option>
            <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
        </select>
        <select name="floor" class="form-select" style="max-width:140px;" onchange="this.form.submit()">
            <option value="">Semua Lantai</option>
            @foreach($floors as $f)
                <option value="{{ $f }}" {{ request('floor') == $f ? 'selected' : '' }}>Lantai {{ $f }}</option>
            @endforeach
        </select>
    </form>
    @if(auth()->user()->isAdmin())
    <a href="{{ route('rooms.create') }}" class="btn btn-gold">
        <i class="fas fa-plus me-1"></i> Tambah Kamar
    </a>
    @endif
</div>

<!-- Room Grid -->
<div class="row g-3">
    @foreach($rooms as $room)
    <div class="col-6 col-md-4 col-lg-3">
        <div class="room-card {{ $room->status }}" data-bs-toggle="modal" data-bs-target="#roomModal{{ $room->id }}">
            <div class="d-flex justify-content-between align-items-start">
                <div class="room-number">{{ $room->room_number }}</div>
                <span class="badge" style="font-size:.65rem;padding:4px 8px;border-radius:20px;
                    @if($room->status === 'available') background:#D1FAE5;color:#065F46;
                    @elseif($room->status === 'occupied') background:#FEE2E2;color:#991B1B;
                    @elseif($room->status === 'cleaning') background:#FEF3C7;color:#92400E;
                    @else background:#E5E7EB;color:#374151; @endif">
                    {{ $room->status_label }}
                </span>
            </div>
            <div style="font-size:.78rem;color:#666;margin-top:4px;">{{ $room->roomType->name }}</div>
            <div style="font-size:.72rem;color:#999;">Lantai {{ $room->floor }}</div>
            @if($room->status === 'occupied' && $room->activeRegistration)
                <div style="margin-top:8px;padding-top:8px;border-top:1px solid rgba(0,0,0,.06);">
                    <div style="font-size:.72rem;font-weight:500;color:#DC2626;">{{ $room->activeRegistration->guest->full_name }}</div>
                    <div style="font-size:.68rem;color:#999;">CO: {{ $room->activeRegistration->check_out_date->format('d M') }}</div>
                </div>
            @endif
            <div style="font-size:.72rem;color:#C9A84C;margin-top:6px;font-weight:500;">
                Rp {{ number_format($room->roomType->price_per_night, 0, ',', '.') }}/malam
            </div>
        </div>
    </div>

    <!-- Modal for each room -->
    <div class="modal fade" id="roomModal{{ $room->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius:14px;border:none;overflow:hidden;">
                <div class="modal-header" style="background:#1A1A2E;border:none;padding:18px 22px;">
                    <h5 class="modal-title" style="color:#C9A84C;font-family:'Playfair Display',serif;">
                        Kamar {{ $room->room_number }} — {{ $room->roomType->name }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-2 mb-3" style="font-size:.875rem;">
                        <div class="col-6"><span style="color:#999;">Lantai:</span> {{ $room->floor }}</div>
                        <div class="col-6"><span style="color:#999;">Kapasitas:</span> {{ $room->roomType->max_occupancy }} tamu</div>
                        <div class="col-6"><span style="color:#999;">Bed:</span> {{ $room->roomType->bed_type }}</div>
                        <div class="col-6"><span style="color:#999;">Harga:</span> <strong style="color:#C9A84C;">Rp {{ number_format($room->roomType->price_per_night, 0, ',', '.') }}</strong></div>
                    </div>

                    @if($room->roomType->facilities)
                    <div class="mb-3">
                        <div style="font-size:.72rem;color:#999;text-transform:uppercase;letter-spacing:1px;margin-bottom:6px;">Fasilitas</div>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($room->roomType->facilities as $f)
                                <span style="background:#F0EBE0;color:#8B6914;padding:3px 8px;border-radius:20px;font-size:.72rem;">{{ $f }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($room->status === 'occupied' && $room->activeRegistration)
                    <div class="p-3 rounded-3 mb-3" style="background:#FEF2F2;">
                        <div style="font-size:.75rem;color:#991B1B;font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-bottom:5px;">Tamu Saat Ini</div>
                        <div style="font-weight:500;">{{ $room->activeRegistration->guest->full_name }}</div>
                        <div style="font-size:.8rem;color:#666;">Check-out: {{ $room->activeRegistration->check_out_date->format('d M Y') }}</div>
                    </div>
                    @endif

                    <!-- Update Status Form -->
                    <form action="{{ route('rooms.update-status', $room) }}" method="POST">
                        @csrf @method('PATCH')
                        <div class="mb-3">
                            <label class="form-label">Update Status</label>
                            <select name="status" class="form-select">
                                <option value="available" {{ $room->status === 'available' ? 'selected' : '' }}>✅ Tersedia</option>
                                <option value="cleaning" {{ $room->status === 'cleaning' ? 'selected' : '' }}>🧹 Sedang Dibersihkan</option>
                                <option value="maintenance" {{ $room->status === 'maintenance' ? 'selected' : '' }}>🔧 Maintenance</option>
                                <option value="out_of_order" {{ $room->status === 'out_of_order' ? 'selected' : '' }}>❌ Tidak Tersedia</option>
                                @if($room->status === 'occupied')<option value="occupied" selected>🔴 Terisi</option>@endif
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catatan (opsional)</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="Keterangan perubahan status...">{{ $room->notes }}</textarea>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-gold flex-fill">
                                <i class="fas fa-save me-1"></i> Simpan Status
                            </button>
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('rooms.edit', $room) }}" class="btn btn-outline-secondary" style="border-radius:8px;">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($rooms->isEmpty())
<div class="text-center py-5 card" style="color:#CCC;">
    <i class="fas fa-door-open fa-3x mb-3"></i>
    <p>Tidak ada kamar ditemukan</p>
</div>
@endif
@endsection
