# SMILJAN SOUTHSPARE

Website resmi **Smiljan Southspare** -- coffee house & library di Cilandak Barat, Jakarta Selatan.

## Tech Stack

- **Backend:** Laravel 13 (PHP 8.3+)
- **Frontend:** Tailwind CSS v4 + Vanilla JavaScript
- **Build:** Vite 8
- **Database:** MySQL (dev) / SQLite (prod)
- **Template:** Blade

## Fitur

### Public Website
- Landing page dengan parallax, scroll reveal, dan custom cursor
- **Loading screen** premium dengan animasi brand reveal + counter
- **Film grain overlay** untuk aesthetic sinematik
- **3D tilt effect** pada semua gambar (perspective 800px)
- **Back-to-top button** yang muncul setelah scroll
- Halaman Jurnal/Artikel dengan rich content (paragraphs, blockquotes)
- Halaman Menu (kopi & non-kopi)
- Halaman Tentang
- Halaman Kontak dengan form validasi
- SEO: Open Graph, Twitter Cards, JSON-LD structured data
- XML Sitemap (`/sitemap.xml`)
- Responsive design (mobile + desktop)
- Animasi: scroll reveal, parallax, marquee, magnetic links
- Accessibility: skip link, ARIA attributes, reduced-motion support
- **Map panel** dengan pin pulse animation

### Admin Panel (`/admin`)
- Login/Logout autentikasi dengan **verifikasi dua langkah (2FA) wajib**
- **Responsive mobile sidebar** (slide-out on mobile, fixed on desktop)
- Dashboard dengan statistik (artikel, menu, events, pesan)
- **Search & filter** pada semua index (artikel, menu, events, pesan)
- **Pagination** (15 items per halaman)
- CRUD Artikel Jurnal (konten JSON blocks: paragraf + blockquote)
- CRUD Menu Items (kopi/non-kopi, harga, kategori)
- CRUD Events/Komunitas (dropdown status: Segera/Berlangsung/Selesai/Dibatalkan)
- Inbox Pesan Kontak (read/unread filter, delete)
- Badge notifikasi pesan belum dibaca
- **Flash message** dengan auto-dismiss (5 detik) + tombol close
- **Form responsive** (grid 1 kolom di mobile, 2-3 kolom di desktop)

### Security
- **Verifikasi dua langkah (2FA) wajib** untuk semua login admin (TOTP + recovery codes)
- **Rate limiting** pada login (5 attempts/menit), 2FA (5/menit), dan kontak form (10/menit)
- **Security headers**: X-Content-Type-Options, X-Frame-Options, X-XSS-Protection, Referrer-Policy, Permissions-Policy
- **No-cache headers** pada halaman admin
- **Alert email** untuk login dari perangkat/IP baru dan aktivitas keamanan
- CSRF protection pada semua form
- Session regeneration saat login (anti session fixation)
- Blade auto-escaping (XSS prevention)
- Model mass assignment protection (`#[Fillable]`)
- Input validation di semua controller

### Verifikasi Dua Langkah (2FA Wajib)

Alur login admin setelah perubahan keamanan:

1. Masukkan email & password.
2. Jika 2FA belum diaktifkan → **dipaksa setup**: pindai QR dengan aplikasi autentikator
   (Google Authenticator, Authy, dll.), masukkan kode 6 digit, lalu simpan **kode pemulihan**.
3. Jika 2FA sudah aktif → masukkan kode 6 digit dari aplikasi autentikator, atau salah satu
   **kode pemulihan** jika aplikasi tidak tersedia (sekali pakai).
4. Semua halaman admin diblokir sampai verifikasi 2FA selesai (`EnsureTwoFactorVerified`).

Catatan:
- Kode pemulihan (8 buah) dihasilkan saat setup dan **hanya ditampilkan sekali** — simpan di tempat aman.
- Login dari IP/perangkat baru akan memicu email peringatan keamanan.
- 2FA bisa dinonaktifkan dari halaman Profil (wajib konfirmasi password); login berikutnya
  akan memaksa setup ulang.
- Kode verifikasi punya toleransi window (±3 step, ±90 detik) untuk mengantisipasi selisih jam perangkat — bisa diatur lewat `ADMIN_2FA_WINDOW`.

## Routes

| Route | Method | Deskripsi |
|---|---|---|
| `/` | GET | Landing page |
| `/jurnal` | GET | Daftar artikel |
| `/jurnal/{slug}` | GET | Detail artikel |
| `/menu` | GET | Halaman menu |
| `/tentang` | GET | Halaman tentang |
| `/kontak` | GET/POST | Form kontak |
| `/sitemap.xml` | GET | XML Sitemap |
| `/admin` | GET | Dashboard admin |
| `/admin/login` | GET/POST | Login admin |
| `/admin/articles` | CRUD | Kelola artikel |
| `/admin/menu` | CRUD | Kelola menu |
| `/admin/events` | CRUD | Kelola events |
| `/admin/messages` | GET/POST/DELETE | Inbox pesan |

## Setup

```bash
# Clone repository
git clone https://github.com/username/Smiljan-Southspare.git
cd Smiljan-Southspare

# Install dependencies
composer install
npm install

# Environment
cp .env.example .env
php artisan key:generate

# Database (SQLite)
touch database/database.sqlite
php artisan migrate

# Seed data
php artisan db:seed

# Build frontend
npm run dev

# Jalankan server
php artisan serve
```

### Admin Login

| Field | Value |
|---|---|
| Email | `admin@smiljan.southspare` |
| Password | `smiljan123` |

Password admin hanya dibuat saat akun belum ada. Menjalankan `php artisan db:seed`
lagi tidak akan menimpa password admin yang sudah diubah.

> **Login pertama:** karena 2FA wajib, setelah login pertama Anda akan langsung
> diminta mengatur verifikasi dua langkah sebelum masuk ke dashboard.

Untuk membuat password baru dari terminal:

```bash
php artisan admin:reset-password
```

Salin persis nilai **Password Baru** yang tampil. Untuk menentukan password
sendiri (minimal 8 karakter), gunakan:

```bash
php artisan admin:reset-password --password="PasswordBaru-2026"
```

Jika admin **lupa password sekaligus kehilangan aplikasi autentikator / kode
pemulihan** (terkunci total karena 2FA wajib), nonaktifkan 2FA sekalian:

```bash
php artisan admin:reset-password --reset-2fa
```

2FA akan dinonaktifkan & secret/kode pemulihan dihapus — login berikutnya
memaksa setup ulang 2FA.

## Arsitektur

### Content-in-Config
Semua konten statis (brand, copy, social links, jam buka) disimpan di `config/site.php` sebagai single source of truth. Template Blade hanya merender dari config tanpa hardcode konten.

### JSON Content Blocks
Artikel disimpan sebagai JSON array `{type: "paragraph"|"blockquote", text: "..."}`. Di admin, gunakan prefix `> ` untuk blockquote.

## Struktur Project

```
app/
  Http/Controllers/
    Admin/              -- Admin CRUD controllers
    AuthController.php  -- Login/Logout
    HomeController.php  -- Landing page
    JournalController.php
    MenuController.php
    ContactController.php
  Http/Middleware/
    SecurityHeaders.php -- Security headers middleware
  Models/
    Article.php, MenuItem.php, Event.php, Message.php
config/
  site.php              -- Semua konten statis site
database/
  migrations/           -- 4 custom migrations
  seeders/              -- Seeder dengan sample data
resources/
  css/app.css           -- Tailwind v4 + custom components + loading screen + grain
  js/app.js             -- Vanilla JS (loading, cursor, nav, reveals, parallax, 3D tilt, back-to-top)
  views/
    layouts/            -- landing.blade.php, page.blade.php
    partials/           -- nav, hero, footer, space, coffee, dll.
    journal/            -- index, show
    admin/              -- dashboard, articles, menu, events, messages
    vendor/pagination/  -- Custom pagination view
    contact.blade.php, about.blade.php, menu.blade.php
```

## Color Palette

| Token | Hex | Kegunaan |
|---|---|---|
| `bg` | `#e9e4d8` | Background utama |
| `paper` | `#f4f0e7` | Card, container |
| `ink` | `#171714` | Teks utama |
| `coffee` | `#4b3326` | Accent coklat |
| `wood` | `#775841` | Brown tones |
| `olive` | `#626453` | Muted green |
| `concrete` | `#aaa69b` | Border, subtle |

## Premium Features

### Loading Screen
Brand reveal dengan animasi staggered: nama muncul, subtitle fade in, progress bar slide, counter animasi.

### Film Grain
SVG noise overlay dengan opacity rendah untuk aesthetic sinematik. Otomatis disembunyikan untuk users dengan `prefers-reduced-motion`.

### 3D Tilt
Setiap gambar dalam `data-tilt` wrapper menggunakan CSS perspective 800px. Mouse position menentukan rotateX/rotateY untuk efek 3D realistis.

### Map Pin Animation
Pin pada section kunjungi menggunakan pulse animation dengan concentric rings yang berdenyut.

## Catatan Perbaikan (Fixes)

Perbaikan yang pernah diterapkan agar proyek stabil & aman:

| # | Perbaikan | Detail |
|---|---|---|
| 1 | `htmlView:` → `view:` | Ketiga mailable (`ContactNotificationMail`, `PasswordResetMail`, `SecurityAlertMail`) error `HtmlView unavailable` karena pakai `htmlView:` dengan view tradisional |
| 2 | View email `$message` | `resources/views/emails/contact-notification.blade.php` memakai `$message` yang bentrok dengan objek `Message` bawaan Laravel Mail — diganti `$body` (properti mailable ikut diubah) |
| 3 | `is_read` di fillable | `Message` tidak bisa ditandai dibaca karena `is_read` tidak ada di `#[Fillable]` — ditambahkan |
| 4 | `ImageController` Intervention v4 | Controller memakai API v2 (`ImageManagerStatic`) yang sudah dihapus di v4 — migrasi ke `ImageManager` + `Drivers\Gd\Driver` |
| 5 | `config('MAIL_FROM_ADDRESS')` | Key salah (harus lowercase, domain `mail.*`), selalu `null` — diganti `config('mail.from.address')` |
| 6 | CSS/JS tidak termuat | File `public/hot` & `public/fonts-manifest.dev.json` (artefak dev, di-gitignore) membuat `@vite` menunjuk ke `:5173`. Hapus file tsb / jangan commit. Solusi: `npm run build` lalu hapus `public/hot` |
| 7 | Keamanan login admin | 2FA wajib, recovery codes, alert email login perangkat baru, perbaikan ganda-encrypt secret, input kode recovery di challenge, middleware blokir semua route admin sampai terverifikasi |
| 8 | Cast `encrypted:nullable` rusak | Laravel 13 tidak mengenali suffix `:nullable` pada cast `encrypted` → secret & recovery codes tersimpan **plaintext**. Diganti cast `'encrypted'` + migration re-encrypt data lama |
| 9 | Kode TOTP selalu ditolak | Window verifikasi dinaikkan ke 3 (±90 detik) untuk toleransi selisih jam ponsel; pesan error diperjelas ("kode salah/kedaluwarsa, gunakan kode terbaru") |
| 10 | Pemulihan admin terkunci | `admin:reset-password --reset-2fa` untuk nonaktifkan 2FA + hapus secret/recovery codes dari terminal |

### Keamanan (diterapkan)

- 2FA wajib: setiap login dipaksa verifikasi kedua (setup jika belum, challenge jika sudah).
- Kode pemulihan sekali pakai disimpan ter-hash (`two_factor_recovery_codes`).
- Secret TOTP disimpan terenkripsi via cast `encrypted` (bukan `encrypted:nullable` yang ternyata inert di Laravel 13).
- `EnsureTwoFactorVerified` mengunci seluruh area admin sampai `two_factor_verified`.
- Alert `SecurityAlertMail` saat login perangkat/IP baru, login pertama, dan 2FA dinonaktifkan.
- Checkbox "Ingat saya" dihapus dari form login.

## License

Proprietary - SMILJAN SOUTHSPARE
