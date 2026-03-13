@extends('layouts.app')
@section('title', 'Edit Karyawan')
@section('page-title', 'Edit Data Karyawan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header"><h5><i class="fas fa-user-edit me-2" style="color:#C9A84C"></i>Edit: {{ $user->name }}</h5></div>
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger mb-3">
                        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                    </div>
                @endif
                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role <span class="text-danger">*</span></label>
                        <select name="role" class="form-select" required>
                            <option value="receptionist" {{ old('role', $user->role) == 'receptionist' ? 'selected' : '' }}>Resepsionis</option>
                            <option value="administrator" {{ old('role', $user->role) == 'administrator' ? 'selected' : '' }}>Administrator</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ $user->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active" style="font-size:.85rem;">Akun Aktif</label>
                        </div>
                    </div>
                    <hr style="border-color:#EDE8DE;">
                    <p style="font-size:.8rem;color:#999;margin-bottom:12px;">Kosongkan password jika tidak ingin mengubahnya.</p>
                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password" class="form-control" minlength="6">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;">Batal</a>
                        <button type="submit" class="btn btn-gold"><i class="fas fa-save me-1"></i>Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
