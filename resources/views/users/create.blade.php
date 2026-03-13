@extends('layouts.app')
@section('title', 'Tambah Karyawan')
@section('page-title', 'Tambah Karyawan Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header"><h5><i class="fas fa-user-plus me-2" style="color:#C9A84C"></i>Form Karyawan Baru</h5></div>
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger mb-3">
                        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                    </div>
                @endif
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role <span class="text-danger">*</span></label>
                        <select name="role" class="form-select" required>
                            <option value="receptionist" {{ old('role') == 'receptionist' ? 'selected' : '' }}>Resepsionis</option>
                            <option value="administrator" {{ old('role') == 'administrator' ? 'selected' : '' }}>Administrator</option>
                        </select>
                        <div style="font-size:.75rem;color:#999;margin-top:4px;">Administrator memiliki akses penuh ke semua fitur.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required minlength="6">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;">Batal</a>
                        <button type="submit" class="btn btn-gold"><i class="fas fa-save me-1"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
