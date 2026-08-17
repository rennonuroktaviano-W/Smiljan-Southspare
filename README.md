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
- Login/Logout autentikasi dengan **remember me**
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
- **Rate limiting** pada login (5 attempts/menit) dan kontak form (10/menit)
- **Security headers**: X-Content-Type-Options, X-Frame-Options, X-XSS-Protection, Referrer-Policy, Permissions-Policy
- **No-cache headers** pada halaman admin
- CSRF protection pada semua form
- Session regeneration saat login (anti session fixation)
- Blade auto-escaping (XSS prevention)
- Model mass assignment protection (`#[Fillable]`)
- Input validation di semua controller

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

## License

Proprietary - SMILJAN SOUTHSPARE
