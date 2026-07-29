@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3">Bilet Detayı #{{ $ticket->id }}</h1>
            <a href="{{ route('admin.tickets.index') }}" class="btn-theater-outline">
                <i class="fas fa-arrow-left"></i> Listeye Dön
            </a>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Bilet Bilgileri</h5>
                        <hr>
                        <table class="table table-borderless">
                            <tr>
                                <th>Bilet ID</th>
                                <td>#{{ $ticket->id }}</td>
                            </tr>
                            <tr>
                                <th>Oyun</th>
                                <td>{{ $ticket->play->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Salon</th>
                                <td>{{ $ticket->play->venue->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Koltuk</th>
                                <td>{{ $ticket->seat->code ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Fiyat</th>
                                <td>{{ number_format($ticket->price, 2) }} ₺</td>
                            </tr>
                            <tr>
                                <th>Durum</th>
                                <td>
                                <span class="badge bg-{{ $ticket->status === 'active' ? 'success' : 'danger' }}">
                                    {{ $ticket->status === 'active' ? 'Aktif' : 'İptal' }}
                                </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Satın Alma Tarihi</th>
                                <td>{{ $ticket->created_at->format('d.m.Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Kullanıcı Bilgileri</h5>
                        <hr>
                        <table class="table table-borderless">
                            <tr>
                                <th>Ad Soyad</th>
                                <td>{{ $ticket->user->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $ticket->user->email ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($ticket->order)
                    <div class="card mt-3">
                        <div class="card-body">
                            <h5 class="card-title">Sipariş Bilgileri</h5>
                            <hr>
                            <table class="table table-borderless">
                                <tr>
                                    <th>Sipariş ID</th>
                                    <td>#{{ $ticket->order->id }}</td>
                                </tr>
                                <tr>
                                    <th>Toplam Fiyat</th>
                                    <td>{{ number_format($ticket->order->total_price, 2) }} ₺</td>
                                </tr>
                                <tr>
                                    <th>Durum</th>
                                    <td>
                                <span class="badge bg-{{ $ticket->order->status === 'completed' ? 'success' : 'warning' }}">
                                    {{ $ticket->order->status === 'completed' ? 'Tamamlandı' : 'Beklemede' }}
                                </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
