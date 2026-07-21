@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="theater-title" style="font-size: 2rem;">
            <span>Kullanıcı</span> Yönetimi
        </h1>
        <a href="{{ route('admin.users.create') }}" class="btn-theater">
            <i class="fas fa-user-plus"></i> Yeni Kullanıcı
        </a>
    </div>

    <!-- Arama -->
    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control login-input" 
                   placeholder="İsim veya email ile ara..." value="{{ request('search') }}">
            <button class="btn-theater" type="submit">
                <i class="fas fa-search"></i> Ara
            </button>
            @if(request('search'))
                <a href="{{ route('admin.users.index') }}" class="btn-theater-outline" style="margin-left: 5px;">
                    <i class="fas fa-times"></i> Temizle
                </a>
            @endif
        </div>
    </form>

    <!-- Mesajlar -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tablo -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>İsim</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Kayıt Tarihi</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge" style="background: {{ $user->role === 'admin' ? '#800020' : '#6c757d' }}; color: white; padding: 5px 12px;">
                                    {{ $user->role === 'admin' ? 'Admin' : 'Kullanıcı' }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   class="btn-theater-outline" style="padding: 5px 15px; font-size: 0.9rem;">
                                    <i class="fas fa-edit"></i> Düzenle
                                </a>
                                
                                @can('delete', $user)
                                <form action="{{ route('admin.users.destroy', $user) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-theater-outline" 
                                            style="padding: 5px 15px; font-size: 0.9rem; border-color: #dc3545; color: #dc3545;"
                                            onclick="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?')">
                                        <i class="fas fa-trash"></i> Sil
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                <i class="fas fa-users" style="font-size: 48px; color: #ccc;"></i>
                                <p class="mt-2">Kullanıcı bulunamadı.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Sayfalama -->
            <div class="d-flex justify-content-center mt-3">
                {{ $users->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection