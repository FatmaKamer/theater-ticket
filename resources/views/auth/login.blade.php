<!-- resources/views/auth/login.blade.php -->
@extends('layouts.app')

@section('content')
<body class="theater-bg d-flex align-items-center justify-content-center" style="min-height: 100vh;">
 
    <div class="welcome-card" style="max-width: 440px;">
        <!-- 🎭 Tiyatro İkonu -->
        <i class="fas fa-ticket-alt theater-icon"></i>
 
        <!-- 🎬 Başlık -->
        <h1 class="theater-title" style="font-size: 2.2rem;">
            <span>Giriş</span> Yap
        </h1>
 
        <!-- 📝 Alt Başlık -->
        <p class="theater-subtitle" style="font-size: 1rem;">
            Sahne senin, hesabına giriş yap.
        </p>
 
        <!-- ⚠️ Hata Mesajları -->
        @if ($errors->any())
            <div class="alert alert-danger text-start">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
 
        <!-- 📝 Giriş Formu -->
        <form method="POST" action="{{ route('login') }}" class="text-start">
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
 
            <div class="mb-2">
                <input type="password"
                       name="password"
                       class="form-control login-input"
                       placeholder="Şifre"
                       required>
            </div>
 
            <div class="text-end mb-4">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="login-link-muted">
                        Şifremi unuttum
                    </a>
                @endif
            </div>
 
            <button type="submit" class="btn-theater w-100">
                <i class="fas fa-sign-in-alt"></i> Giriş Yap
            </button>
        </form>
 
        <!-- 🔗 Kayıt Ol -->
        <p class="text-muted small mt-4 mb-0">
            Henüz kayıt olmadın mı?
            <a href="{{ route('register') }}" class="login-link">Kayıt ol</a>
        </p>
    </div>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
@endsection