@extends('layouts.app')
@section('title', 'Tambah Kamar')
@section('page-title', 'Tambah Kamar Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h5><i class="fas fa-bed me-2" style="color:#C9A84C"></i>Form Kamar Baru</h5></div>
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger mb-3">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
                @endif
                <form action="{{ route('rooms.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nomor Kamar <span class="text-danger">*</span></label>
                        <input type="text" name="room_number" class="form-control" value="{{ old('room_number') }}" placeholder="e.g. 101" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe Kamar <span class="text-danger">*</span></label>
                        <select name="room_type_id" class="form-select" required>
                            <option value="">-- Pilih Tipe --</option>
                            @foreach($roomTypes as $t)
                                <option value="{{ $t->id }}" {{ old('room_type_id') == $t->id ? 'selected' : '' }}>
                                    {{ $t->name }} — Rp {{ number_format($t->price_per_night, 0, ',', '.') }}/malam
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Lantai <span class="text-danger">*</span></label>
                        <input type="number" name="floor" class="form-control" min="1" max="99" value="{{ old('floor') }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Catatan</label>
                        <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                    </div>
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;">Batal</a>
                        <button type="submit" class="btn btn-gold"><i class="fas fa-save me-1"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
