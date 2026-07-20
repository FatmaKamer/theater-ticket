<!-- resources/views/auth/register.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container theater-bg d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="row justify-content-center w-100">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-0 text-center pt-4">
                    <!-- 🎭 Tiyatro İkonu -->
                    <i class="fas fa-ticket-alt theater-icon"></i>
                    <h1 class="theater-title" style="font-size: 2.2rem;">
                        <span>Kayıt</span> Ol
                    </h1>
                    <p class="text-muted">Yeni bir hesap oluşturun</p>
                </div>

                <div class="card-body p-4">
                    <!-- ⚠️ Hata Mesajları -->
                    @if ($errors->any())
                        <div class="alert alert-danger text-start">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <!-- 📝 Kayıt Formu - FORTIFY UYUMLU -->
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Ad Soyad -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Ad Soyad</label>
                            <input id="name" type="text" 
                                   class="login-input form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name') }}" 
                                   required autocomplete="name" autofocus
                                   placeholder="Ahmet Yılmaz">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email Adresi</label>
                            <input id="email" type="email" 
                                   class="login-input form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" 
                                   required autocomplete="email"
                                   placeholder="ornek@email.com">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Şifre -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Şifre</label>
                            <input id="password" type="password" 
                                   class="login-input form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="new-password"
                                   placeholder="•••••••• (min 8 karakter)">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Şifre Tekrar -->
                        <div class="mb-3">
                            <label for="password-confirm" class="form-label fw-bold">Şifre Tekrar</label>
                            <input id="password-confirm" type="password" 
                                   class="login-input form-control" 
                                   name="password_confirmation" required autocomplete="new-password"
                                   placeholder="••••••••">
                        </div>

                        <!-- Kayıt Ol Butonu -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn-theater w-100">
                                <i class="fas fa-user-plus"></i> Kayıt Ol
                            </button>
                        </div>

                        <!-- Zaten hesabın var mı? -->
                        <div class="text-center mt-3">
                            <span class="text-muted">Zaten hesabın var mı?</span>
                            <a class="login-link" href="{{ route('login') }}">
                                Giriş Yap
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection