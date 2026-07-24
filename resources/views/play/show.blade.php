@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row align-items-start">
            <!-- Sol: Afiş -->
            <div class="col-md-6 mb-4">
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

            <!-- Sağ: Oyun Bilgileri -->
            <div class="col-md-6">
                <h1 class="theater-title" style="font-size: 2.8rem; margin-bottom: 10px;">
                    <span>{{ $play->name }}</span>
                </h1>

                <!-- Salon bilgisi -->
                @if($play->venue)
                    <p class="theater-subtitle" style="font-size: 1rem; margin-bottom: 5px;">
                        <i class="fas fa-map-pin" style="color: #800020;"></i>
                        <strong>{{ $play->venue->name }}</strong>
                        @if($play->venue->address)
                            <br><span style="font-size: 0.9rem; color: #888;">{{ $play->venue->address }}</span>
                        @endif
                    </p>
                @endif

                <!-- Fiyat ve Süre -->
                <div class="d-flex gap-3 my-3 flex-wrap">
                <span class="badge" style="background: #800020; color: white; padding: 8px 18px; font-size: 1rem; border-radius: 50px;">
                    <i class="fas fa-clock"></i> {{ $play->duration ?? '?' }} dk
                </span>
                    <span class="badge" style="background: #28a745; color: white; padding: 8px 18px; font-size: 1rem; border-radius: 50px;">
                    <i class="fas fa-ticket-alt"></i> {{ number_format($play->ticket_price, 2) }} ₺
                </span>
                </div>

                <!-- Açıklama -->
                <h5 class="mt-4" style="color: #800020; font-weight: 700;">Oyun Hakkında</h5>
                <p class="text-muted" style="line-height: 1.8; font-size: 1rem;">
                    {{ $play->description ?? 'Açıklama eklenmemiş.' }}
                </p>

                <!-- Yazar ve Yönetmen -->
                <div class="row mt-3">
                    @if($play->author)
                        <div class="col-6">
                            <strong style="color: #800020;">Yazar</strong>
                            <p class="text-muted">{{ $play->author }}</p>
                        </div>
                    @endif
                    @if($play->director)
                        <div class="col-6">
                            <strong style="color: #800020;">Yönetmen</strong>
                            <p class="text-muted">{{ $play->director }}</p>
                        </div>
                    @endif
                </div>

                <!-- Oyuncular -->
                @if($play->cast)
                    <div class="mt-2">
                        <strong style="color: #800020;">Oyuncular</strong>
                        <p class="text-muted">{{ $play->cast }}</p>
                    </div>
                @endif

                <!-- Bilet Al Butonu -->
                <div class="mt-4 d-flex flex-wrap gap-2">
                    <a href="#" class="btn-theater" style="padding: 12px 40px; font-size: 1.1rem;">
                        <i class="fas fa-ticket-alt"></i> Bilet Al
                    </a>
                    <a href="{{ route('home') }}" class="btn-theater-outline" style="padding: 12px 30px; font-size: 1.1rem;">
                        <i class="fas fa-arrow-left"></i> Oyunlara Dön
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
