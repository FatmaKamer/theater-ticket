@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="theater-title" style="font-size: 2rem;">
                <span>Oyun</span> Yönetimi
            </h1>
            <a href="{{ route('admin.plays.create') }}" class="btn-theater">
                <i class="fas fa-plus"></i> Yeni Oyun
            </a>
        </div>

        <!-- Arama -->
        <form method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control login-input"
                       placeholder="Oyun ara..." value="{{ request('search') }}">
                <button class="btn-theater" type="submit">
                    <i class="fas fa-search"></i> Ara
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.plays.index') }}" class="btn-theater-outline" style="margin-left: 5px;">
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
                            <th>Afiş</th>
                            <th>Oyun Adı</th>
                            <th>Salon</th>
                            <th>Fiyat</th>
                            <th>Süre</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($plays as $play)
                            <tr>
                                <td>{{ $play->id }}</td>
                                <td>
                                    @if($play->image)
                                        <img src="{{ asset('storage/' . $play->image) }}"
                                             alt="{{ $play->name }}"
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                    @else
                                        <span class="text-muted">Resim yok</span>
                                    @endif
                                </td>
                                <td>{{ $play->name }}</td>
                                <td>{{ $play->venue->name ?? 'Salon silinmiş' }}</td>
                                <td>{{ number_format($play->ticket_price, 2) }} ₺</td>
                                <td>{{ $play->duration ?? '-' }} dk</td>
                                <td>
                                <span class="badge" style="background: {{ $play->is_active ? '#28a745' : '#dc3545' }}; color: white; padding: 5px 12px;">
                                    {{ $play->is_active ? 'Aktif' : 'Pasif' }}
                                </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.plays.edit', $play) }}"
                                       class="btn-theater-outline" style="padding: 5px 15px; font-size: 0.9rem;">
                                        <i class="fas fa-edit"></i> Düzenle
                                    </a>

                                    <form action="{{ route('admin.plays.destroy', $play) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-theater-outline"
                                                style="padding: 5px 15px; font-size: 0.9rem; border-color: #dc3545; color: #dc3545;"
                                                onclick="return confirm('Bu oyunu silmek istediğinize emin misiniz?')">
                                            <i class="fas fa-trash"></i> Sil
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    <i class="fas fa-theater-masks" style="font-size: 48px; color: #ccc;"></i>
                                    <p class="mt-2">Henüz oyun eklenmemiş.</p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Sayfalama -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $plays->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
