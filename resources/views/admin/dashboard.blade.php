@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="theater-title" style="font-size: 2.5rem;">
                <span>Admin</span> Paneli
            </h1>
            <p class="theater-subtitle">Hoş geldiniz, {{ auth()->user()->name }}!</p>

            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="fas fa-users" style="font-size: 48px; color: #800020;"></i>
                            <h5 class="card-title mt-3">Kullanıcılar</h5>
                            <p class="card-text">Toplam {{ \App\Models\User::count() }} kullanıcı</p>
                            <a href="{{ route('admin.users.index') }}" class="btn-theater">
                                <i class="fas fa-arrow-right"></i> Yönet
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-ticket-alt" style="font-size: 48px; color: #800020;"></i>
                            <h5 class="card-title mt-3">Salonlar</h5>
                            <p class="card-text">Toplam {{ \App\Models\Venue::count() }} salon</p>
                            <a href="{{ route('admin.venues.index') }}" class="btn-theater">
                                <i class="fas fa-arrow-right"></i> Yönet
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-theater-masks" style="font-size: 48px; color: #800020;"></i>
                            <h5 class="card-title mt-3">Oyunlar</h5>
                            <p class="card-text">Toplam {{ \App\Models\Play::count() }} oyun</p>
                            <a href="{{ route('admin.plays.index') }}" class="btn-theater">
                                <i class="fas fa-arrow-right"></i> Yönet
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
