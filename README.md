# 🎭 Theater Ticket System

**Kapsamlı Tiyatro Biletleme Otomasyonu**

Laravel 13 ile geliştirilmiş, tiyatro salonları ve etkinlikler için tam kapsamlı bir bilet satış ve yönetim platformu.

---

## 📌 Proje Hakkında

**Theater Ticket**, tiyatro salonlarının oyunlarını yönetebileceği, kullanıcıların ise kolayca bilet satın alabileceği modern bir web uygulamasıdır. Admin paneli sayesinde salon, oyun, kullanıcı ve bilet yönetimi tek bir yerden yapılabilir.

---

## ✨ Özellikler

### 👤 Kullanıcı Tarafı
| Özellik | Açıklama |
|---------|----------|
| **Kayıt & Giriş** | Laravel Fortify ile güvenli kimlik doğrulama |
| **Oyun Listesi** | Aktif oyunları kartlar halinde görüntüleme |
| **Oyun Detayı** | Oyun bilgileri, salon, afiş, yazar ve oyuncular |
| **Koltuk Seçimi** | 10x10 matris görünümünde interaktif koltuk seçimi |
| **Rezervasyon** | Seçilen koltuklar için 1 dakikalık rezervasyon süresi |
| **Bilet Satın Alma** | Kullanıcı dostu ödeme adımları |
| **Breadcrumb Navigasyon** | Sayfa hiyerarşisini gösteren gezinme çubuğu |

### 🛡️ Admin Paneli
| Modül | Açıklama |
|-------|----------|
| **Dashboard** | Genel istatistikler ve hızlı erişim kartları |
| **Kullanıcı Yönetimi** | Kullanıcı ekleme, düzenleme, silme ve arama |
| **Salon Yönetimi** | Salon CRUD, kapasite, konum ve resim yükleme |
| **Oyun Yönetimi** | Oyun CRUD, afiş, yazar, yönetmen ve oyuncu bilgileri |
| **Bilet Yönetimi** | Tüm satışları listeleme, filtreleme ve iptal işlemleri |
| **Rol & Yetki** | Spatie Permission ile rol tabanlı erişim kontrolü |

### 🔐 Güvenlik
- **Laravel Fortify** ile kimlik doğrulama
- **Spatie Permission** ile rol tabanlı yetkilendirme (admin/editor/user)
- **Middleware** ile route koruması
- **CSRF** ve **XSS** önlemleri
- **Bcrypt** ile şifre hashleme

### 📱 Tasarım
- **Bootstrap 5** ile responsive (mobil uyumlu) arayüz
- **Özel CSS** ile markaya özgü bordo tema
- **Font Awesome** ikon desteği
- **Kart tabanlı** modern UI
- **Kullanıcı dostu** formlar ve butonlar

---

## 🛠️ Teknolojiler

| Kategori | Teknolojiler |
|----------|--------------|
| **Backend** | Laravel 13, PHP 8.5, MySQL 8.0 |
| **Frontend** | Blade, Bootstrap 5, CSS3, JavaScript |
| **Kimlik Doğrulama** | Laravel Fortify, Spatie Permission |
| **Sunucu** | Nginx, Vagrant (yerel geliştirme) |
| **Araçlar** | Composer, Git, Artisan CLI |

---

## 📁 Proje Yapısı

```text
theater-ticket/
├── app/
│   ├── Actions/Fortify/   # Kimlik doğrulama işlemleri
│   ├── Http/
│   │   ├── Controllers/   # Admin & Kullanıcı controller'ları
│   │   ├── Middleware/    # Admin kontrolü
│   │   └── Requests/      # Form validasyonları
│   ├── Models/            # Eloquent modeller
│   ├── Policies/          # Yetkilendirme politikaları
│   └── Providers/         # Servis sağlayıcıları
├── database/
│   ├── migrations/        # Veritabanı tabloları
├── resources/
│   └── views/             # Blade şablonları
│       ├── admin/         # Admin paneli view'ları
│       ├── auth/          # Kimlik doğrulama view'ları
│       ├── layouts/       # Ana layout
│       └── play/          # Kullanıcı oyun view'ları
├── routes/
│   └── web.php            # Tüm route tanımları
└── public/
    ├── css/               # Özel stiller
    └── storage/           # Yüklenen dosyalar
```

---

## 🚀 Kurulum

### 1️⃣ Projeyi Klonla

```bash
git clone https://github.com/FatmaKamer/theater-ticket.git
cd theater-ticket
```

### 2️⃣ Bağımlılıkları Yükle

```bash
composer install
```

### 3️⃣ Ortam Dosyasını Yapılandır

```bash
cp .env.example .env
php artisan key:generate
```

### 4️⃣ Veritabanı Ayarları

`.env` dosyasını düzenle:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=theater_ticket
DB_USERNAME=root
DB_PASSWORD=secret
```

### 5️⃣ Migration ve Seed

```bash
php artisan migrate
```

### 6️⃣ Storage Link (Resimler için)

```bash
php artisan storage:link
```

### 7️⃣ Geliştirme Sunucusunu Başlat

```bash
php artisan serve
```

### 8️⃣ Projeyi Çalıştırma (Vagrant & Nginx)

Proje yerel geliştirme ortamında **Vagrant** ve **Nginx** ile yapılandırılmıştır. Geliştirme ortamınız çalışırken uygulamaya aşağıdaki adres üzerinden erişebilirsiniz:

🌍 **http://theater-ticket.127.0.0.1.xip.io**

---

👩‍💻 **Geliştirici**
**Fatma Kamer Durusoy**

**GitHub:** [@FatmaKamer](https://github.com/FatmaKamer)
**LinkedIn:** [Fatma Kamer Durusoy](https://www.linkedin.com/in/fatmakamerdurusoy)
