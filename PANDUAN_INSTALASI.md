# 🏨 Hotel Grande Management System
## Panduan Instalasi Lengkap Step-by-Step

---

## DAFTAR ISI
1. Persyaratan Sistem
2. Struktur Proyek
3. Instalasi Step-by-Step
4. Konfigurasi Database
5. Menjalankan Aplikasi
6. Akun Default & Hak Akses
7. Fitur Sistem
8. Tipe Kamar
9. Troubleshooting

---

## 1. PERSYARATAN SISTEM

Sebelum memulai, pastikan komputer Anda sudah terinstal:

| Software     | Versi Minimum | Cara Cek              |
|-------------|---------------|-----------------------|
| PHP         | 8.1+          | `php -v`              |
| Composer    | 2.x           | `composer --version`  |
| MySQL       | 8.0+          | `mysql --version`     |
| Node.js     | 16+           | `node -v`             |
| Git         | Any           | `git --version`       |

**Cara Install PHP 8.1 (Ubuntu/Debian):**
```bash
sudo apt update
sudo apt install php8.1 php8.1-cli php8.1-mbstring php8.1-xml php8.1-mysql php8.1-curl php8.1-zip unzip
```

**Cara Install Composer:**
```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
sudo mv composer.phar /usr/local/bin/composer
```

---

## 2. STRUKTUR PROYEK

```
hotel-grande/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/LoginController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── RegistrationController.php
│   │   │   ├── RoomController.php
│   │   │   └── UserController.php
│   │   ├── Middleware/
│   │   │   └── CheckRole.php          ← Custom role middleware
│   │   └── Kernel.php
│   └── Models/
│       ├── User.php
│       ├── Room.php
│       ├── RoomType.php
│       ├── Guest.php
│       ├── Registration.php
│       └── RoomCleaningLog.php
├── database/
│   ├── migrations/                    ← Struktur tabel database
│   └── seeders/DatabaseSeeder.php     ← Data awal (kamar, user, tipe kamar)
├── resources/views/
│   ├── auth/login.blade.php
│   ├── layouts/app.blade.php
│   ├── dashboard.blade.php
│   ├── registrations/
│   │   ├── create.blade.php           ← Form registrasi utama
│   │   ├── index.blade.php
│   │   ├── show.blade.php
│   │   └── print.blade.php            ← Kartu registrasi untuk cetak
│   ├── rooms/
│   │   ├── index.blade.php            ← Grid status kamar
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   └── users/
│       ├── index.blade.php
│       ├── create.blade.php
│       └── edit.blade.php
└── routes/web.php
```

---

## 3. INSTALASI STEP-BY-STEP

### LANGKAH 1 — Buat Proyek Laravel Baru

```bash
# Cara 1: via Composer (DIREKOMENDASIKAN)
composer create-project laravel/laravel hotel-grande "10.*"
cd hotel-grande

# Cara 2: via Laravel Installer
composer global require laravel/installer
laravel new hotel-grande
cd hotel-grande
```

---

### LANGKAH 2 — Salin File Proyek

Salin semua file dari folder yang sudah dibuat ke dalam proyek Laravel:

```bash
# Salin semua file (dari folder hasil download ke folder proyek)
cp -r hotel-project/app/Models/* hotel-grande/app/Models/
cp -r hotel-project/app/Http/Controllers/* hotel-grande/app/Http/Controllers/
cp    hotel-project/app/Http/Middleware/CheckRole.php hotel-grande/app/Http/Middleware/
cp    hotel-project/app/Http/Kernel.php hotel-grande/app/Http/Kernel.php
cp -r hotel-project/database/migrations/* hotel-grande/database/migrations/
cp    hotel-project/database/seeders/DatabaseSeeder.php hotel-grande/database/seeders/
cp -r hotel-project/resources/views/* hotel-grande/resources/views/
cp    hotel-project/routes/web.php hotel-grande/routes/web.php
```

> **Catatan:** Jika menggunakan Windows, gunakan File Explorer untuk menyalin file secara manual ke folder yang sesuai.

---

### LANGKAH 3 — Konfigurasi File .env

```bash
# Salin file .env
cp .env.example .env

# Buka file .env dan edit bagian database:
nano .env
# atau gunakan editor favorit Anda (VS Code, Notepad++, dll)
```

Edit bagian ini sesuai konfigurasi MySQL Anda:
```env
APP_NAME="Hotel Grande"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotel_grande        ← Nama database yang akan dibuat
DB_USERNAME=root                 ← Username MySQL Anda
DB_PASSWORD=                     ← Password MySQL Anda (kosongkan jika tidak ada)
```

---

### LANGKAH 4 — Buat Database MySQL

```bash
# Login ke MySQL
mysql -u root -p

# Di dalam MySQL console, jalankan:
CREATE DATABASE hotel_grande CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

Atau gunakan phpMyAdmin:
1. Buka `http://localhost/phpmyadmin`
2. Klik "New" di sidebar kiri
3. Nama database: `hotel_grande`
4. Collation: `utf8mb4_unicode_ci`
5. Klik "Create"

---

### LANGKAH 5 — Install Dependencies

```bash
# Install PHP dependencies
composer install

# Generate application key
php artisan key:generate
```

---

### LANGKAH 6 — Jalankan Migrasi Database

```bash
# Buat semua tabel di database
php artisan migrate

# Isi data awal (tipe kamar, kamar, user admin & resepsionis)
php artisan db:seed
```

Jika ingin reset dan mulai ulang:
```bash
php artisan migrate:fresh --seed
```

---

### LANGKAH 7 — Set Permission (Linux/Mac saja)

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## 4. MENJALANKAN APLIKASI

### Development (Lokal)
```bash
php artisan serve
```
Buka browser: **http://localhost:8000**

### Dengan XAMPP / Laragon
1. Letakkan folder proyek di:
   - XAMPP: `C:\xampp\htdocs\hotel-grande`
   - Laragon: `C:\laragon\www\hotel-grande`
2. Akses via: `http://localhost/hotel-grande/public`

> **Tips:** Untuk kemudahan development, gunakan `php artisan serve` atau Laragon yang otomatis mendeteksi proyek Laravel.

---

## 5. AKUN DEFAULT

Setelah seeder berhasil dijalankan, tersedia akun berikut:

| Nama          | Email                        | Password  | Role          | Akses                    |
|---------------|------------------------------|-----------|---------------|--------------------------|
| Administrator | admin@hotelgrande.com        | admin123  | Administrator | Semua fitur              |
| Budi Santoso  | budi@hotelgrande.com         | budi123   | Receptionist  | Input & cetak saja       |
| Sari Dewi     | sari@hotelgrande.com         | sari123   | Receptionist  | Input & cetak saja       |

### ⚠️ PENTING: Ganti password setelah pertama kali login!

---

## 6. HAK AKSES PER ROLE

| Fitur                         | Administrator | Resepsionis |
|-------------------------------|:-------------:|:-----------:|
| Login                         | ✅            | ✅          |
| Dashboard                     | ✅            | ✅          |
| Buat Registrasi Baru          | ✅            | ✅          |
| Lihat Daftar Registrasi       | ✅            | ✅          |
| Cetak Kartu Registrasi        | ✅            | ✅          |
| Check-out Tamu                | ✅            | ✅          |
| Lihat Status Kamar            | ✅            | ✅          |
| Update Status Kamar           | ✅            | ✅          |
| Tambah/Edit/Hapus Kamar       | ✅            | ❌          |
| Kelola Karyawan (CRUD Users)  | ✅            | ❌          |
| Nonaktifkan Karyawan          | ✅            | ❌          |

---

## 7. FITUR SISTEM

### 🏠 Dashboard
- Ringkasan statistik: total kamar, tersedia, terisi, dibersihkan
- Jumlah check-in & check-out hari ini
- Daftar registrasi aktif terbaru
- Daftar tamu yang due checkout hari ini + tombol checkout langsung

### 📋 Form Registrasi Tamu
Form lengkap meliputi:
- **Informasi Kamar:** Tipe kamar, nomor kamar, jumlah tamu, jumlah kamar
- **Informasi Menginap:** Check-in, waktu kedatangan, check-out, keberangkatan, resepsionis, deposit box, issued by
- **Data Tamu:** Nama, pekerjaan, perusahaan, kebangsaan, KTP, passport, telepon, no. member, alamat
- **Kalkulasi Otomatis:** Harga total dihitung otomatis berdasarkan tipe kamar & lama menginap

### 🖨️ Cetak Kartu Registrasi
- Layout profesional siap cetak (format A4)
- Berisi semua data tamu & menginap
- Box informasi kamar dengan harga
- Estimasi total biaya
- Area tanda tangan (Tamu, Resepsionis, Manager)
- Header & footer hotel

### 🚪 Status Kamar (Room Board)
- Grid visual semua kamar dengan kode warna:
  - 🟢 **Hijau:** Tersedia
  - 🔴 **Merah:** Terisi
  - 🟡 **Kuning:** Sedang dibersihkan
  - ⚫ **Abu-abu:** Maintenance
- Klik kamar → modal detail + form update status
- Filter per lantai & per status
- Tampilkan nama tamu & tanggal check-out untuk kamar terisi

### 🔄 Alur Check-out & Pembersihan
1. Resepsionis klik tombol "Check-out" pada registrasi aktif
2. Status registrasi → `checked_out`
3. Status kamar otomatis berubah → `cleaning`
4. Staff housekeeping update status kamar → `available` saat sudah bersih
5. Kamar siap untuk registrasi baru

### 👥 Manajemen Karyawan (Admin only)
- Tambah karyawan baru dengan role
- Edit data & password karyawan
- Aktifkan/nonaktifkan akun
- Hapus karyawan (kecuali diri sendiri)

---

## 8. TIPE KAMAR (Data Bawaan)

| Kode | Tipe              | Harga/Malam        | Kapasitas | Bed Type           |
|------|-------------------|--------------------|-----------|--------------------|
| STD  | Standard Room     | Rp 350.000         | 2 orang   | Single/Twin        |
| SUP  | Superior Room     | Rp 550.000         | 2 orang   | Double/Queen       |
| DLX  | Deluxe Room       | Rp 850.000         | 3 orang   | Queen/King         |
| JST  | Junior Suite      | Rp 1.500.000       | 3 orang   | King               |
| STE  | Suite Room        | Rp 2.500.000       | 4 orang   | King               |
| PST  | Presidential Suite| Rp 5.000.000       | 6 orang   | King + Extra Beds  |

**Distribusi Kamar Bawaan:**
- Lantai 1: Kamar 101–106 (Standard)
- Lantai 2: Kamar 201–206 (Superior)
- Lantai 3: Kamar 301–305 (Deluxe)
- Lantai 4: Kamar 401–404 (Junior Suite)
- Lantai 5: Kamar 501–503 (Suite)
- Lantai 6: Kamar 601 (Presidential Suite)

---

## 9. TROUBLESHOOTING

### Error: `SQLSTATE[HY000] [1045] Access denied for user`
→ Periksa DB_USERNAME dan DB_PASSWORD di file `.env`

### Error: `No application encryption key has been specified`
```bash
php artisan key:generate
```

### Error: `Class 'App\Http\Middleware\CheckRole' not found`
```bash
composer dump-autoload
```

### Error: View not found / 404 pada route
```bash
php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan config:clear
```

### Halaman Login tidak bisa diakses
```bash
php artisan config:clear
php artisan cache:clear
```

### Migration error: `Table already exists`
```bash
php artisan migrate:fresh --seed
# PERHATIAN: Ini akan menghapus semua data!
```

### Permission denied pada storage (Linux)
```bash
sudo chmod -R 777 storage bootstrap/cache
```

---

## 10. PERINTAH ARTISAN BERGUNA

```bash
# Jalankan server development
php artisan serve

# Reset database + isi ulang data awal
php artisan migrate:fresh --seed

# Clear semua cache
php artisan optimize:clear

# Lihat semua route
php artisan route:list

# Masuk ke tinker (console interaktif)
php artisan tinker

# Buat model baru
php artisan make:model NamaModel -m
```

---

## CATATAN KEAMANAN

1. **Ganti semua password default** setelah instalasi
2. Set `APP_DEBUG=false` di `.env` sebelum deployment ke production
3. Set `APP_ENV=production` di production
4. Gunakan HTTPS di production
5. Backup database secara rutin

---

*Hotel Grande Management System — Dikembangkan dengan Laravel 10*
