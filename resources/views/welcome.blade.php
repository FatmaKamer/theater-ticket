<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Hoşgeldiniz - {{ config('app.name', 'Theater Ticket') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- ⭐ ÖZEL CSS -->
    <link rel="stylesheet" href="{{ asset('css/theater.css') }}">
    
</head>
<body class="theater-bg d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    
    <div class="welcome-card">
        <!-- 🎭 Tiyatro İkonu -->
        <i class="fas fa-theater-masks theater-icon"></i>

        <!-- 🎬 Başlık -->
        <h1 class="theater-title">
            <span>Theater</span> Ticket
        </h1>

        <!-- 📝 Alt Başlık -->
        <p class="theater-subtitle">
            Tiyatro ve etkinlik biletlerini kolayca bulun,<br>
            rezerve edin ve satın alın.
        </p>

        <!-- ⭐ Özellikler -->
         <!--
        <div class="row g-3 mb-4">
            <div class="col-4">
                <i class="fas fa-ticket-alt" style="color: #C04060; font-size: 28px;"></i>
                <p class="small text-muted mt-2 mb-0">Kolay Bilet</p>
            </div>
            <div class="col-4">
                <i class="fas fa-calendar-check" style="color: #C04060; font-size: 28px;"></i>
                <p class="small text-muted mt-2 mb-0">Etkinlik Takvimi</p>
            </div>
            <div class="col-4">
                <i class="fas fa-star" style="color: #C04060; font-size: 28px;"></i>
                <p class="small text-muted mt-2 mb-0">Değerlendirmeler</p>
            </div>
        </div>
        -->
        <!-- 🔘 Butonlar -->
        <div class="d-flex flex-wrap justify-content-center gap-3">
            @auth
                <a href="{{ route('home') }}" class="btn-theater">
                    <i class="fas fa-ticket-alt"></i> Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-theater">
                    <i class="fas fa-sign-in-alt"></i> Giriş Yap
                </a>
                <a href="{{ route('register') }}" class="btn-theater-outline">
                    <i class="fas fa-user-plus"></i> Kayıt Ol
                </a>
            @endauth
        </div>

        <!-- 🏷️ Alt Bilgi -->
        <p class="text-muted small mt-4 mb-0">
            <i class="fas fa-shield-alt"></i> Güvenli & Hızlı
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>