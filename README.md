# 🎭 Theater Ticket

Tiyatro ve etkinlik biletleri için modern bir web uygulaması.

## ✨ Özellikler
- 👤 Kullanıcı kayıt ve giriş sistemi
- 🎨 Bordo tema ile şık tasarım
- 📱 Mobil uyumlu (Bootstrap 5)
- 🔒 Güvenli kimlik doğrulama (Laravel Auth)

## 🛠️ Kullanılan Teknolojiler
- Laravel 11
- Bootstrap 5
- MySQL
- Tailwind CSS (kaldırıldı, yerine özel CSS)

## 📦 Kurulum

```bash
# Projeyi klonla
git clone https://github.com/FatmaKamer/theater-ticket.git

# Bağımlılıkları yükle
composer install
npm install

# .env dosyasını oluştur
cp .env.example .env

# Uygulama anahtarını oluştur
php artisan key:generate

# Veritabanını migrate et
php artisan migrate

# Sunucuyu başlat
php artisan serve