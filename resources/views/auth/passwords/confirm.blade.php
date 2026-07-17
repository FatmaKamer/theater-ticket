<!-- resources/views/auth/confirm-password.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="row justify-content-center w-100">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-0 text-center pt-4">
                    <i class="fas fa-shield-alt" style="font-size: 3rem; color: #800020;"></i>
                    <h3 class="mb-0 mt-2">🔐 Şifre Onayı</h3>
                    <p class="text-muted">Güvenli alana girmeden önce şifrenizi doğrulayın</p>
                </div>

                <div class="card-body p-4">
                    <!-- Bilgi Mesajı -->
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle"></i>
                        Devam etmeden önce lütfen şifrenizi onaylayın.
                    </div>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <!-- Şifre -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Şifre</label>
                            <input id="password" type="password" 
                                   class="login-input form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="current-password"
                                   placeholder="••••••••">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Butonlar -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn-theater w-100">
                                <i class="fas fa-check-circle"></i> Şifreyi Onayla
                            </button>
                        </div>

                        <!-- Şifremi Unuttum -->
                        <div class="text-center mt-3">
                            @if (Route::has('password.request'))
                                <a class="login-link" href="{{ route('password.request') }}">
                                    <i class="fas fa-key"></i> Şifremi Unuttum
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection