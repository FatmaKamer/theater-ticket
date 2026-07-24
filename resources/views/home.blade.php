@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="theater-title" style="font-size: 2.5rem; text-align: center;">
                    <span>Sahnedeki</span> Oyunlar
                </h1>
                <p class="theater-subtitle text-center" style="margin-bottom: 40px;">
                    Bugün sahnelenen en güncel oyunları keşfedin.
                </p>
            </div>
        </div>

        <div class="row">
            @forelse($plays as $play)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 play-card">
                        <div class="play-image">
                            @if($play->image)
                                <img src="{{ asset('storage/' . $play->image) }}"
                                     alt="{{ $play->name }}"
                                     class="card-img-top"
                                     style="height: 250px; object-fit: cover; border-radius: 20px 20px 0 0;">
                            @else
                                <div class="card-img-top"
                                     style="height: 250px; background: linear-gradient(135deg, #C04060, #800020);
                                        display: flex; align-items: center; justify-content: center; border-radius: 20px 20px 0 0;">
                                    <i class="fas fa-theater-masks" style="font-size: 60px; color: rgba(255,255,255,0.5);"></i>
                                </div>
                            @endif
                        </div>

                        <div class="card-body" style="padding: 20px;">
                            <h5 class="card-title">{{ $play->name }}</h5>

                            @if($play->venue)
                                <p class="card-text text-muted" style="font-size: 0.9rem;">
                                    <i class="fas fa-map-pin" style="color: #800020;"></i>
                                    {{ $play->venue->name }}
                                </p>
                            @endif

                            <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge" style="background: #800020; color: white; padding: 5px 12px;">
                                <i class="fas fa-clock"></i> {{ $play->duration ?? '?' }} dk
                            </span>
                                <span class="badge" style="background: #28a745; color: white; padding: 5px 12px;">
                                <i class="fas fa-ticket-alt"></i> {{ number_format($play->ticket_price, 2) }} ₺
                            </span>
                            </div>

                            <p class="card-text" style="font-size: 0.9rem; color: #666;">
                                {{ Str::limit($play->description ?? 'Açıklama eklenmemiş.', 80) }}
                            </p>
                        </div>

                        <div class="card-footer" style="background: transparent; border-top: none; padding: 0 20px 20px 20px;">
                            <a href="{{ route('play.show', $play) }}" class="btn-theater w-100" style="display: block; text-align: center;">
                                <i class="fas fa-ticket-alt"></i> Bilet Al
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center" style="padding: 60px 0;">
                        <i class="fas fa-theater-masks" style="font-size: 80px; color: #ccc;"></i>
                        <h3 class="mt-4">Henüz oyun bulunmuyor</h3>
                        <p class="text-muted">Yeni oyunlar yakında sahnelenecek.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $plays->links() }}
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .play-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none !important;
            border-radius: 20px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            overflow: hidden;
        }

        .play-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(128, 0, 32, 0.2) !important;
        }

        .play-card .card-title {
            font-weight: 700;
            font-size: 1.2rem;
            color: #800020;
            margin-bottom: 5px;
        }
    </style>
@endpush
