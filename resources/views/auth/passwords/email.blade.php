@extends('layouts.app')

@section('content')
<div class="theater-bg d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="welcome-card" style="max-width: 440px;">
        <i class="fas fa-key theater-icon"></i>
        <h1 class="theater-title" style="font-size: 2.2rem;">
            <span>Şifre</span> Sıfırla
        </h1>
        <p class="theater-subtitle" style="font-size: 1rem;">
            Email adresine şifre sıfırlama linki gönderelim.
        </p>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger text-start">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="text-start">
            @csrf

            <div class="mb-3">
                <input type="email"
                       name="email"
                       class="form-control login-input"
                       placeholder="E-posta"
                       value="{{ old('email') }}"
                       required
                       autofocus>
            </div>

            <button type="submit" class="btn-theater w-100">
                <i class="fas fa-paper-plane"></i> Şifre Sıfırlama Linki Gönder
            </button>
        </form>

        <p class="text-muted small mt-4 mb-0">
            <a href="{{ route('login') }}" class="login-link">Giriş yap</a> sayfasına dön.
        </p>
    </div>
</div>
@endsection