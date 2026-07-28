@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Sol: Afiş -->
            <div class="col-md-5 mb-4">
                @if($play->image)
                    <img src="{{ asset('storage/' . $play->image) }}"
                         alt="{{ $play->name }}"
                         class="img-fluid rounded"
                         style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); width: 100%;">
                @else
                    <div class="theater-bg-light"
                         style="height: 450px; display: flex; align-items: center; justify-content: center; border-radius: 20px;">
                        <i class="fas fa-theater-masks" style="font-size: 80px; color: rgba(255,255,255,0.6);"></i>
                    </div>
                @endif
            </div>

            <!-- Sağ: Oyun Bilgileri (Kartlı) -->
            <div class="col-md-7">
                <!-- Başlık Kartı -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h1 class="play-title">
                            <span>{{ $play->name }}</span>
                        </h1>
                        @if($play->venue)
                            <p class="play-meta mb-0">
                                <i class="fas fa-map-pin"></i>
                                <strong>{{ $play->venue->name }}</strong>
                                @if($play->venue->address)
                                    <br><span style="font-size: 0.9rem;">{{ $play->venue->address }}</span>
                                @endif
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Fiyat ve Süre Kartı -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            <!-- Sol: Süre ve Fiyat -->
                            <div class="d-flex gap-2">
                                <span class="badge" style="background: #800020; color: white; padding: 6px 14px; border-radius: 50px;">
                                    <i class="fas fa-clock"></i> {{ $play->duration ?? '?' }} dk
                                </span>
                                <span class="badge" style="background: #28a745; color: white; padding: 6px 14px; border-radius: 50px;">
                                    <i class="fas fa-ticket-alt"></i> {{ number_format($play->ticket_price, 2) }} ₺
                                </span>
                            </div>

                            <!-- Sağ: Butonlar -->
                            <div class="d-flex gap-2">
                                <a href="{{ route('play.seats', $play) }}" class="btn-theater" style="padding: 12px 40px; font-size: 1.1rem;">
                                    <i class="fas fa-ticket-alt"></i> Bilet Al
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Açıklama Kartı -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="play-detail-label">Oyun Hakkında</h5>
                        <p class="card-text text-muted" style="line-height: 1.8;">
                            {{ $play->description ?? 'Açıklama eklenmemiş.' }}
                        </p>
                    </div>
                </div>

                <!-- Yazar ve Yönetmen Kartı -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            @if($play->author)
                                <div class="col-6">
                                    <strong class="play-detail-label" style="margin-top: 0;">Yazar</strong>
                                    <p class="text-muted mb-0">{{ $play->author }}</p>
                                </div>
                            @endif
                            @if($play->director)
                                <div class="col-6">
                                    <strong class="play-detail-label" style="margin-top: 0;">Yönetmen</strong>
                                    <p class="text-muted mb-0">{{ $play->director }}</p>
                                </div>
                            @endif
                        </div>
                        @if($play->cast)
                            <div class="row mt-2">
                                <div class="col-12">
                                    <strong class="play-detail-label" style="margin-top: 0;">Oyuncular</strong>
                                    <p class="text-muted mb-0">{{ $play->cast }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Butonlar Kartı -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('home') }}" class="btn-theater-outline">
                                <i class="fas fa-arrow-left"></i> Oyunlara Dön
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
