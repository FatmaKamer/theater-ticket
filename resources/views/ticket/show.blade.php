@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">🎫 Sipariş Detayı</h4>
                        <span class="badge bg-light text-primary fs-6">{{ $tickets->count() }} Bilet</span>
                    </div>

                    <div class="card-body">
                        <!-- Genel Bilgiler (Tüm Biletler İçin Ortak) -->
                        <div class="order-summary mb-4 border-bottom pb-3">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>🎬 Oyun:</strong>
                                    <p class="mb-0 fs-5">{{ $play->name }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>📍 Salon:</strong>
                                    <p class="mb-0">{{ $venue->name ?? 'Belirtilmemiş' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>📅 Satın Alma Tarihi:</strong>
                                    <p class="mb-0">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>🔢 Sipariş No:</strong>
                                    <p class="mb-0">#{{ $order->id }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Satın Alınan Koltuklar (Döngü ile basılıyor) -->
                        <h5 class="mb-3 text-secondary">Koltuklarınız</h5>
                        <div class="row">
                            @foreach($tickets as $item)
                                <div class="col-md-6 mb-3">
                                    <div class="card border-primary h-100">
                                        <div class="card-body d-flex justify-content-between align-items-center p-3">
                                            <div>
                                                <small class="text-muted d-block">Koltuk</small>
                                                <strong class="text-primary" style="font-size: 1.25rem;">
                                                    {{ $item->seat->code ?? 'Belirtilmemiş' }}
                                                </strong>
                                            </div>
                                            <div class="text-end">
                                                <small class="text-muted d-block">Fiyat</small>
                                                <strong>{{ number_format($item->price, 2) }} ₺</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Toplam Tutar -->
                        <div class="text-end mt-3 mb-4">
                            <h5 class="mb-0">Genel Toplam: <span class="text-primary">{{ number_format($order->total_price, 2) }} ₺</span></h5>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('home') }}" class="btn btn-secondary">
                                <i class="fas fa-home"></i> Ana Sayfaya Dön
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
