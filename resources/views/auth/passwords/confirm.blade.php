@extends('layouts.app')

@section('content')
<div class="theater-bg d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="welcome-card" style="max-width: 440px;">
        <i class="fas fa-shield-alt theater-icon"></i>
        <h1 class="theater-title" style="font-size: 2.2rem;">
            <span>Şifrenizi</span> Onaylayın
        </h1>
        <p class="theater-subtitle" style="font-size: 1rem;">
            Güvenlik nedeniyle şifrenizi tekrar girin.
        </p>

        @if ($errors->any())
            <div class="alert alert-danger text-start">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.confirm') }}" class="text-start">
            @csrf

            <div class="mb-3">
                <input type="password"
                       name="password"
                       class="form-control login-input"
                       placeholder="Şifre"
                       required>
            </div>

            <button type="submit" class="btn-theater w-100">
                <i class="fas fa-check-circle"></i> Onayla
            </button>
        </form>

        <p class="text-muted small mt-4 mb-0">
            <a href="{{ route('login') }}" class="login-link">Giriş yap</a> sayfasına dön.
        </p>
    </div>
</div>
@endsection