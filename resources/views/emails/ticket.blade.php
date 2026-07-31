<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biletleriniz</title>
    <style>
        body {
            font-family: 'Nunito', Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 40px 0;
            margin: 0;
        }
        .container {
            max-width: 650px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #800020;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #800020;
            font-size: 28px;
            margin: 0;
        }
        .order-info {
            background: #f9f9f9;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .order-info p {
            margin: 5px 0;
            font-size: 14px;
        }
        .ticket-list {
            margin: 20px 0;
        }
        .ticket-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 16px;
            border-bottom: 1px solid #eee;
            font-size: 15px;
        }
        .ticket-item:last-child {
            border-bottom: none;
        }
        .ticket-item .seat-code {
            font-weight: 700;
            color: #800020;
        }
        .ticket-item .price {
            font-weight: 600;
        }
        .total {
            text-align: right;
            font-size: 18px;
            font-weight: 700;
            padding: 15px 0;
            border-top: 2px solid #800020;
            margin-top: 10px;
        }
        .btn {
            display: inline-block;
            background: #800020;
            color: white !important;
            padding: 14px 35px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 20px;
        }
        .btn:hover {
            background: #C04060;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #999;
            font-size: 13px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Header -->
    <div class="header">
        <h1>🎭 Biletleriniz Hazır!</h1>
    </div>

    <!-- Merhaba -->
    <p>Merhaba <strong>{{ auth()->user()->name ?? 'Değerli Müşterimiz' }}</strong>,</p>
    <p><strong>{{ $play->name }}</strong> oyunu için biletleriniz başarıyla oluşturuldu. Detaylar aşağıda:</p>

    <!-- Sipariş Bilgisi -->
    <div class="order-info">
        <p><strong>📅 Satın Alma Tarihi:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
        <p><strong>🔢 Sipariş No:</strong> #{{ $order->id }}</p>
        <p><strong>📍 Salon:</strong> {{ $play->venue->name ?? 'Belirtilmemiş' }}</p>
    </div>

    <!-- Bilet Listesi -->
    <div class="ticket-list">
        <div style="font-weight: 700; padding: 8px 16px; background: #f0f0f0; border-radius: 6px; display: flex; justify-content: space-between;">
            <span>💺 Koltuk</span>
            <span>💰 Fiyat</span>
        </div>
        @foreach($tickets as $ticket)
            <div class="ticket-item">
                <span class="seat-code">{{ $ticket->seat->code ?? 'Belirtilmemiş' }}</span>
                <span class="price">{{ number_format($ticket->price, 2) }} ₺</span>
            </div>
        @endforeach
    </div>

    <!-- Toplam -->
    <div class="total">
        Toplam: {{ number_format($totalPrice, 2) }} ₺
    </div>

    <!-- Biletleri Görüntüle Butonu -->
    <div style="text-align: center;">
        <a href="{{ route('ticket.show', $tickets->first()->id) }}" class="btn">
            🎫 Biletlerimi Görüntüle
        </a>
    </div>

    <p style="margin-top: 20px; font-size: 14px; color: #666; text-align: center;">
        Bu linke tıklayarak tüm biletlerinizi detaylı olarak görüntüleyebilirsiniz.
    </p>

    <!-- Footer -->
    <div class="footer">
        &copy; {{ date('Y') }} Theater Ticket. Tüm hakları saklıdır.
        <br>Bu e-posta otomatik olarak gönderilmiştir.
    </div>
</div>
</body>
</html>
