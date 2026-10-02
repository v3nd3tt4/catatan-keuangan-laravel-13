# 🚀 Panduan Menjalankan Aplikasi Finance

## Langkah-Langkah Setup

### Step 1: Install Composer Dependencies
```bash
cd c:\laragon\www\finance-app2
composer install
```

### Step 2: Install NPM Dependencies
```bash
npm install
```

### Step 3: Copy Environment File
```bash
copy .env.example .env
```

atau jika sudah ada .env file, lanjut ke step 4.

### Step 4: Generate Application Key
```bash
php artisan key:generate
```

### Step 5: Jalankan Migration & Seeder
```bash
php artisan migrate
php artisan db:seed
```

Perintah ini akan membuat:
- Tabel `users` (sudah ada, hanya tambah kolom `role`)
- Tabel `categories`
- Tabel `transactions`
- User Admin: admin@finance.test (password: password)
- User Biasa: user@finance.test (password: password)
- 10 kategori default untuk user biasa (5 income, 5 expense)

### Step 6: Build CSS & JS dengan Vite
```bash
npm run build
```

Atau jika ingin development mode dengan live reload:
```bash
npm run dev
```

### Step 7: Jalankan Laravel Development Server

Di terminal baru, jalankan:
```bash
php artisan serve
```

Aplikasi akan berjalan di: **http://localhost:8000**

## 🎯 Akses Aplikasi

### Dashboard User Biasa
1. Buka: http://localhost:8000
2. Login dengan:
   - Email: `user@finance.test`
   - Password: `password`
3. Anda akan masuk ke `/dashboard`

### Dashboard Admin
1. Buka: http://localhost:8000
2. Login dengan:
   - Email: `admin@finance.test`
   - Password: `password`
3. Anda akan otomatis redirect ke `/admin/dashboard`

## 📝 Fitur yang Bisa Dicoba

### Untuk User Biasa:
1. **Dashboard** - Lihat ringkasan pemasukan, pengeluaran, saldo bulan ini
2. **Tambah Transaksi** - Klik "Tambah Transaksi" atau pergi ke `/transactions`
   - Pilih tipe (Pemasukan/Pengeluaran)
   - Pilih kategori
   - Masukkan jumlah
   - Pilih tanggal
   - Tambahkan keterangan (opsional)
   - Simpan

3. **Kelola Kategori** - Pergi ke `/categories`
   - Lihat kategori pemasukan & pengeluaran
   - Tambah kategori baru
   - Edit warna kategori
   - Hapus kategori

4. **Lihat Laporan** - Pergi ke `/reports`
   - Filter berdasarkan tanggal
   - Lihat total pemasukan, pengeluaran, saldo
   - Lihat breakdown per kategori
   - Statistik persentase & rata-rata

5. **Laporan per Kategori** - Pergi ke `/reports/by-category`
   - Lihat semua kategori dalam card view
   - Lihat top transaksi per kategori

### Untuk Admin:
1. **Admin Dashboard** - Pergi ke `/admin/dashboard`
   - Lihat total pengguna, transaksi, pemasukan, pengeluaran semua user
   - Lihat 10 transaksi terbaru dari semua user

2. **Kelola Pengguna** - Pergi ke `/admin/users`
   - Lihat daftar semua user
   - Klik "Lihat Transaksi" untuk melihat transaksi user tertentu

3. **Transaksi Pengguna** - Dari halaman users, klik user tertentu
   - Lihat semua transaksi user
   - Lihat total pemasukan, pengeluaran, saldo user

4. **Semua Transaksi** - Pergi ke `/admin/transactions`
   - Filter transaksi semua user berdasarkan tanggal
   - Lihat total pemasukan, pengeluaran semua user
   - Lihat daftar lengkap semua transaksi

5. **Kategori** - Pergi ke `/admin/categories`
   - Lihat semua kategori dari semua user
   - Lihat pengguna yang membuat kategori
   - Lihat jumlah transaksi per kategori
   - Lihat warna kategori

## 🔧 Troubleshooting

### Error: SQLSTATE[HY000]: General error: 1030
Solusi: Hapus file database jika menggunakan SQLite
```bash
rm database/database.sqlite
php artisan migrate
php artisan db:seed
```

### Error: npm command not found
Solusi: Install Node.js dari https://nodejs.org/

### Error: composer command not found
Solusi: Install Composer dari https://getcomposer.org/

### Halaman blank/tidak ada CSS
Solusi: Build assets dengan:
```bash
npm run build
```

### Database error setelah migrate
Solusi: Clear cache
```bash
php artisan cache:clear
php artisan config:clear
```

## 📂 File Penting

- **Models**: `app/Models/User.php`, `Category.php`, `Transaction.php`
- **Controllers**: `app/Http/Controllers/`
- **Routes**: `routes/web.php`
- **Views**: `resources/views/`
- **Database Config**: `.env`

## 🎨 Tema dan Styling

- **Color Scheme**: Putih Pucat dengan aksen Indigo
- **Income**: Hijau (#10b981)
- **Expense**: Merah (#ef4444)
- **Framework CSS**: Tailwind CSS
- **Icons**: Built-in SVG icons

## 🔐 Keamanan Notes

✅ **Sudah Diterapkan:**
- Authentication dengan Laravel Breeze
- CSRF protection
- Input validation
- User data isolation (hanya lihat data sendiri)
- Admin authorization check
- Role-based access control

## 📊 Database Relationships

```
User (1) ──> (Many) Category
User (1) ──> (Many) Transaction
Category (1) ──> (Many) Transaction
```

User hanya bisa melihat dan memodifikasi kategori dan transaksi miliknya sendiri. Admin dapat melihat semua.

---

**Selamat menikmati aplikasi Finance! 💰**

Jika ada pertanyaan atau error, cek log di `storage/logs/laravel.log`
