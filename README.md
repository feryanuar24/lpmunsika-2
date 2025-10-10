# LPM UNSIKA - Portal Berita Resmi

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=flat-square&logo=php)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-3.x-38B2AC?style=flat-square&logo=tailwind-css)](https://tailwindcss.com)

## Tentang Proyek

**LPM UNSIKA** adalah web portal berita resmi milik **UKM Lembaga Pers Mahasiswa Universitas Singaperbangsa Karawang**. Portal ini dirancang sebagai platform informasi terpercaya untuk menyampaikan informasi terkini seputar kehidupan dunia jurnalistik oleh mahasiswa.

### 🎯 Tujuan Utama

- Menyediakan platform berita digital untuk LPM UNSIKA
- Meningkatkan literasi digital dan jurnalistik mahasiswa
- Menjadi sumber informasi terpercaya untuk civitas akademika UNSIKA
- Mengembangkan kemampuan menulis dan reporting mahasiswa

## ✨ Fitur Utama

### 📰 Manajemen Konten

- **Artikel**: Sistem publikasi artikel dengan data relasi lengkap
- **Kategori**: Organisasi konten berdasarkan topik (Berita, Buletin, Karya Mahasiswa, Gaya Mahasiswa, dsb.)
- **Tag System**: Pengelompokan artikel dengan tag untuk pengelompokan lebih terstruktur.
- **Komentar**: Sistem komentar untuk engagement pembaca

### 👥 Sistem User & Role

- **User Management**: Pengelolaan admin/penulis dan pengunjung
- **Permission System**: Kontrol akses berdasarkan role menggunakan Laratrust

### 🎨 Media & Embed

- **Embed System**: Integrasi konten multimedia (YouTube dan Spotify)
- **Media Management**: Upload dan pengelolaan gambar hingga embed pada artikel

### 🔍 Fitur Tambahan

- **Search Engine Friendly**: SEO optimized untuk visibility yang lebih baik
- **Responsive Design**: Tampilan yang optimal di semua perangkat

## 🛠️ Teknologi yang Digunakan

### Backend

- **Laravel 12.x** - PHP Framework
- **MySQL** - Database
- **Laratrust** - Role & Permission Management

### Frontend

- **Tailwind CSS** - CSS Framework
- **Vite** - Build Tool & Asset Bundling
- **Blade Templates** - Laravel Templating Engine
- **KTUI** - UI Component Library

### Development Tools

- **Composer** - PHP Dependency Manager
- **NPM** - JavaScript Package Manager

## 📋 Persyaratan Sistem

- PHP >= 8.3
- Composer
- Node.js & NPM
- MySQL
- Web Server (Apache/Nginx/PHP Built-in)

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/feryanuar24/lpmunsika-2.git
cd lpmunsika-2
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### 3. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup

#### Atur konfigurasi database di file `.env`:

```bash
# Run migrations
php artisan migrate

# (Optional) Run seeders
php artisan db:seed
```

### 5. Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### 6. Start Development Server

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## 📁 Struktur Database

### Tabel Utama

- **users** - Data Admin/Pengunjung
- **roles & permissions** - Sistem role dan izin
- **categories** - Kategori artikel
- **tags** - Tag artikel
- **articles** - Artikel utama
- **comments** - Komentar artikel
- **platforms** - Platform media sosial
- **embeds** - Konten embedded

### Relasi

- Article belongsToMany Tags (Many-to-Many)
- Article hasMany Comments (One-to-Many)
- Article belongsTo Category (Many-to-One)
- User hasMany Articles (One-to-Many)

## 📝 Kontribusi

Terbuka kontribusi untuk seluruh anggota LPM UNSIKA!

1. Fork repository ini
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

### 📋 Panduan Kontribusi

- Update dokumentasi jika diperlukan
- Gunakan commit message yang deskriptif

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

## 👨‍💻 Tim Pengembang

**LPM UNSIKA Development Team**

## 📞 Kontak & Support

- **Website**: [LPM UNSIKA Official](https://lpmunsika.com)
- **Email**: lpmunsika@gmail.com
- **Instagram**: [@lpmunsika](https://instagram.com/lpmunsika)
- **Issues**: [GitHub Issues](https://github.com/feryanuar24/lpmunsika-2/issues)
