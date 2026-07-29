@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4">Bilet Yönetimi</h1>

        <!-- İstatistikler -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="text-muted">Toplam Bilet</h5>
                        <h3 class="text-primary">{{ \App\Models\TicketSale::count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="text-muted">Aktif Bilet</h5>
                        <h3 class="text-success">{{ \App\Models\TicketSale::where('status', 'active')->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="text-muted">İptal Edilen</h5>
                        <h3 class="text-danger">{{ \App\Models\TicketSale::where('status', 'cancelled')->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="text-muted">Bugün Satılan</h5>
                        <h3 class="text-warning">{{ \App\Models\TicketSale::whereDate('created_at', today())->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtreler -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Oyun</label>
                        <select name="play_id" class="form-control">
                            <option value="">Tümü</option>
                            @foreach($plays as $play)
                                <option value="{{ $play->id }}" {{ request('play_id') == $play->id ? 'selected' : '' }}>
                                    {{ $play->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Kullanıcı</label>
                        <select name="user_id" class="form-control">
                            <option value="">Tümü</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Durum</label>
                        <select name="status" class="form-control">
                            <option value="">Tümü</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>İptal</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Başlangıç</label>
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Bitiş</label>
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn-theater">Filtrele</button>
                        <a href="{{ route('admin.tickets.index') }}" class="btn-theater-outline">Temizle</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tablo -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Oyun</th>
                            <th>Koltuk</th>
                            <th>Kullanıcı</th>
                            <th>Fiyat</th>
                            <th>Durum</th>
                            <th>Tarih</th>
                            <th>İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->id }}</td>
                                <td>{{ $ticket->play->name ?? '-' }}</td>
                                <td>{{ $ticket->seat->code ?? '-' }}</td>
                                <td>{{ $ticket->user->name ?? '-' }}</td>
                                <td>{{ number_format($ticket->price, 2) }} ₺</td>
                                <td>
                                <span class="badge bg-{{ $ticket->status === 'active' ? 'success' : 'danger' }}">
                                    {{ $ticket->status === 'active' ? 'Aktif' : 'İptal' }}
                                </span>
                                </td>
                                <td>{{ $ticket->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.tickets.show', $ticket) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($ticket->status === 'active')
                                        <form action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bu bileti iptal etmek istediğinize emin misiniz?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Bilet bulunamadı.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $tickets->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
