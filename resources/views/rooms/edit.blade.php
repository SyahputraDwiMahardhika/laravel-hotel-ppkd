@extends('layouts.app')
@section('title', 'Edit Kamar')
@section('page-title', 'Edit Kamar ' . $room->room_number)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h5><i class="fas fa-edit me-2" style="color:#C9A84C"></i>Edit Kamar: {{ $room->room_number }}</h5></div>
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger mb-3">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
                @endif
                <form action="{{ route('rooms.update', $room) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nomor Kamar <span class="text-danger">*</span></label>
                        <input type="text" name="room_number" class="form-control" value="{{ old('room_number', $room->room_number) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe Kamar <span class="text-danger">*</span></label>
                        <select name="room_type_id" class="form-select" required>
                            @foreach($roomTypes as $t)
                                <option value="{{ $t->id }}" {{ old('room_type_id', $room->room_type_id) == $t->id ? 'selected' : '' }}>
                                    {{ $t->name }} — Rp {{ number_format($t->price_per_night, 0, ',', '.') }}/malam
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lantai <span class="text-danger">*</span></label>
                        <input type="number" name="floor" class="form-control" value="{{ old('floor', $room->floor) }}" min="1" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Catatan</label>
                        <textarea name="notes" class="form-control" rows="2">{{ old('notes', $room->notes) }}</textarea>
                    </div>
                    <div class="d-flex gap-2 justify-content-between">
                        <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn" style="background:#FEF2F2;color:#991B1B;border:1.5px solid #FCA5A5;border-radius:8px;"
                                onclick="return confirm('Hapus kamar {{ $room->room_number }}?')">
                                <i class="fas fa-trash me-1"></i>Hapus Kamar
                            </button>
                        </form>
                        <div class="d-flex gap-2">
                            <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;">Batal</a>
                            <button type="submit" class="btn btn-gold"><i class="fas fa-save me-1"></i>Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
