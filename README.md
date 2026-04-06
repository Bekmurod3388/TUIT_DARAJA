# TUIT Daraja — Malaka Oshirish Platformasi

<p align="center">
    <img src="https://tuit.uz/storage/media/tuit_logo.png" alt="TUIT Logo" width="150">
</p>

> TATU (Toshkent Axborot Texnologiyalari Universiteti) uchun malaka oshirish kurslariga elektron ariza topshirish va boshqarish platformasi.

---

## 📋 Loyiha haqida

TUIT Daraja — bu pedagog va mutaxassislar malaka oshirish kurslariga onlayn ariza topshirishlari, to'lov qilishlari va sertifikat olishlari uchun mo'ljallangan veb-platforma.

### Asosiy funksiyalar

- **Foydalanuvchi autentifikatsiyasi** — Telefon + parol va OneID (E-Gov) orqali tizimga kirish
- **Ariza topshirish** — Kursga ariza va zarur hujjatlarni yuborish
- **Payme to'lov** — Kurs narxini onlayn to'lash (Payme Merchant API)
- **Admin panel** — Arizalar, foydalanuvchilar, dasturlar, fanlar, komissiyalar boshqaruvi
- **Sertifikat generatsiyasi** — QR kodli PDF sertifikat chiqarish
- **Ko'p tilli** — O'zbek (uz), Rus (ru), Ingliz (en) tillarida ishlash

---

## 🛠 Texnologiyalar

| Texnologiya | Versiya | Maqsad |
|---|---|---|
| PHP | ^8.3 | Backend runtime |
| Laravel | ^12.0 | Web framework |
| Socialite | ^5.21 | OneID autentifikatsiya |
| Filament | ^3.2 | Admin panel (qisman) |
| DomPDF | ^3.1 | PDF sertifikat |
| QR Code | ^4.2 | Sertifikat QR kodi |
| Vite | — | Frontend bundler |
| SQLite/MySQL | — | Ma'lumotlar bazasi |

---

## 🚀 O'rnatish

### Talablar
- PHP 8.3+
- Composer 2+
- Node.js 18+
- SQLite yoki MySQL 8+

### Lokal O'rnatish

```bash
# Repozitoriyni klonlash
git clone <repo-url>
cd TUIT_DARAJA

# PHP dependencies
composer install

# .env sozlash
cp .env.example .env
php artisan key:generate

# Ma'lumotlar bazasi
touch database/database.sqlite
php artisan migrate

# Frontend
npm install
npm run build

# Serverni ishga tushirish
php artisan serve
```

### Docker bilan ishga tushirish

```bash
docker-compose up -d
```

Bu MySQL (8.4), PHP va Nginx konteynerlarini ishga tushiradi.  
Port: `http://localhost:8081`

---

## 📁 Loyiha tuzilmasi

```
TUIT_DARAJA/
├── app/
│   ├── Exceptions/         # PaymeException
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/      # Admin panel controllerlari
│   │   │   ├── Auth/       # Login, Register, OneID
│   │   │   ├── MyApplicationsController.php
│   │   │   ├── PaymeController.php
│   │   │   └── ProgramsController.php
│   │   ├── Middleware/      # AdminMiddleware, LocaleMiddleware
│   │   └── Requests/       # Form Request validatsiyasi
│   ├── Models/              # Eloquent modellari
│   ├── Policies/            # UserPolicy
│   ├── Providers/           # OneIdServiceProvider
│   └── Socialite/           # OneIdProvider (Socialite driver)
├── config/                  # Konfiguratsiya fayllari
├── database/migrations/     # DB migratsiyalari
├── lang/{uz,ru,en}/         # Tarjimalar
├── resources/views/         # Blade shablonlar
├── routes/web.php           # Barcha routlar
└── docker-compose.yml       # Docker sozlamalari
```

---

## 🔑 Muhit o'zgaruvchilari

| O'zgaruvchi | Tavsif |
|---|---|
| `ONEID_CLIENT_ID` | OneID OAuth client ID |
| `ONEID_CLIENT_SECRET` | OneID OAuth secret |
| `ONEID_REDIRECT_URI` | OneID callback URL |
| `PAYME_MERCHANT_ID` | Payme merchant identifikatori |
| `PAYME_KEY` | Payme merchant kaliti |
| `PAYME_LOGIN` | Payme login (default: Paycom) |

---

## 👤 Rollar

| Rol | Huquqlar |
|---|---|
| `user` | Ariza topshirish, to'lov, sertifikat yuklab olish |
| `admin` | Barcha CRUD operatsiyalari, oddiy foydalanuvchilar ustida boshqaruv |
| `superadmin` | To'liq huquq, adminlarni ham boshqarish |

---

## 📄 Litsenziya

MIT License
