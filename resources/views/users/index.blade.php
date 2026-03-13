@extends('layouts.app')
@section('title', 'Kelola Karyawan')
@section('page-title', 'Manajemen Karyawan')

@section('content')
<div class="d-flex justify-content-end mb-4">
    <a href="{{ route('users.create') }}" class="btn btn-gold">
        <i class="fas fa-user-plus me-1"></i> Tambah Karyawan
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#C9A84C,#1A1A2E);display:flex;align-items:center;justify-content:center;color:#fff;font-size:.8rem;font-weight:600;flex-shrink:0;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <strong style="font-size:.875rem;">{{ $user->name }}</strong>
                                @if($user->id === auth()->id())
                                    <span style="font-size:.65rem;background:#E8F4FD;color:#1A6FA0;padding:2px 6px;border-radius:10px;">Anda</span>
                                @endif
                            </div>
                        </td>
                        <td style="font-size:.85rem;color:#555;">{{ $user->email }}</td>
                        <td>
                            @if($user->isAdmin())
                                <span class="badge" style="background:linear-gradient(135deg,#C9A84C,#B8903E);color:#fff;padding:4px 10px;border-radius:20px;font-size:.7rem;letter-spacing:.5px;">
                                    <i class="fas fa-shield-alt me-1"></i>Administrator
                                </span>
                            @else
                                <span class="badge" style="background:#E8F4FD;color:#1A6FA0;padding:4px 10px;border-radius:20px;font-size:.7rem;">
                                    <i class="fas fa-user me-1"></i>Resepsionis
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($user->is_active)
                                <span class="badge" style="background:#D1FAE5;color:#065F46;padding:4px 10px;border-radius:20px;font-size:.7rem;">● Aktif</span>
                            @else
                                <span class="badge" style="background:#FEE2E2;color:#991B1B;padding:4px 10px;border-radius:20px;font-size:.7rem;">Nonaktif</span>
                            @endif
                        </td>
                        <td style="font-size:.82rem;color:#999;">{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm" style="background:#F0EBE0;color:#8B6914;border-radius:6px;padding:4px 10px;font-size:.75rem;">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm" style="background:#FEF2F2;color:#991B1B;border-radius:6px;padding:4px 10px;font-size:.75rem;"
                                        onclick="return confirm('Hapus karyawan {{ $user->name }}?')">
                                        <i class="fas fa-trash"></i>
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
    </div>
</div>
@endsection
