# 📧 Email Verification & Password Reset Setup

## ✅ Konfigurasi yang Sudah Dilakukan

### 1. **Gmail SMTP Configuration** (.env)
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=pilopaokta@gmail.com
MAIL_PASSWORD="zest wsck dklm yniq"
MAIL_FROM_ADDRESS="pilopaokta@gmail.com"
MAIL_FROM_NAME="Finance App"
```

### 2. **User Model**
- ✅ Implement `MustVerifyEmail` interface
- ✅ Email verification wajib untuk akses fitur

### 3. **Middleware Protection**
- ✅ Dashboard & semua fitur memerlukan `verified` middleware
- ✅ Belum verified → redirect ke email verification page

---

## 🚀 Fitur Email

### **1. Email Verification Saat Register**
**Alur:**
1. User baru register
2. Event `Registered` triggered
3. Email verifikasi otomatis terkirim
4. User harus klik link di email untuk verify
5. Baru bisa akses dashboard

**Test:**
```
1. Buka: http://localhost:8000/register
2. Daftar dengan email baru
3. Cek email yang terdaftar
4. Klik link verifikasi di email
5. Redirect ke dashboard (atau verification notice jika masih belum verified)
```

### **2. Password Reset (Forgot Password)**
**Alur:**
1. User click "Forgot Password" di login page
2. Masukkan email
3. Email reset link terkirim ke inbox
4. Klik link di email
5. Set password baru
6. Login dengan password baru

**Test:**
```
1. Buka: http://localhost:8000/forgot-password
2. Masukkan email yang terdaftar (contoh: user@finance.test)
3. Klik "Email Password Reset Link"
4. Cek email
5. Klik link reset password
6. Set password baru
7. Login dengan password baru
```

---

## 🔧 Test Accounts

### Admin (Email Verified - Bisa Login Langsung)
```
Email: admin@finance.test
Password: password
Role: Admin
Status: ✅ Verified
```

### User (Email Verified - Bisa Login Langsung)
```
Email: user@finance.test
Password: password
Role: User
Status: ✅ Verified
```

---

## 📝 Untuk Production

### ⚠️ Penting! Jika ingin Email Verification Beneran:

Edit `database/seeders/DatabaseSeeder.php`, ubah:

```php
// Dari:
'email_verified_at' => now(),

// Ke:
'email_verified_at' => null,
```

Sehingga test user harus verify email untuk login. Kemudian:

```bash
php artisan migrate:refresh --seed
```

---

## 🌐 Email Templates

Laravel Breeze menyediakan template default untuk:
- ✅ Email Verification Notification
- ✅ Password Reset Link

Lokasi: `resources/views/mail/`

### Customize Email Templates (Optional)

Untuk custom, publish views:
```bash
php artisan vendor:publish --tag=laravel-notifications
```

Akan generate di: `resources/views/vendor/notifications/`

---

## 🐛 Troubleshooting

### Email tidak terkirim?

**1. Cek .env sudah benar**
```bash
cat .env | grep MAIL_
```

Harus sama seperti yang di atas.

**2. Cek Laravel log**
```bash
tail -f storage/logs/laravel.log
```

**3. Test email manually (Laravel Tinker)**
```bash
php artisan tinker
```

Kemudian:
```php
Mail::raw('Test email', function ($message) {
    $message->to('pilopaokta@gmail.com');
});
```

### Gmail App Password not working?

1. Pastikan Gmail 2FA sudah enabled
2. Generate App Password di: https://myaccount.google.com/apppasswords
3. Gunakan app password yang baru, bukan password Gmail biasa
4. Format di .env: `MAIL_PASSWORD="zest wsck dklm yniq"` (dengan quotes)

### Verifikasi email link expired?

Default lifetime: 60 menit. Kalau expired, user bisa:
1. Click "Resend Verification Email" di verification notice page
2. Atau direct ke: `/email/verification-notification` (POST)

---

## 📨 Routes Email

```
GET  /forgot-password        → Forgot Password Page
POST /forgot-password        → Send Reset Email
GET  /reset-password/{token} → Reset Password Page
POST /reset-password         → Update Password

GET  /verify-email           → Email Verification Prompt
GET  /verify-email/{id}/{hash} → Verify Email (dari link di email)
POST /email/verification-notification → Resend Verification Email
```

---

## ✨ Fitur Sekarang

### User Flow:
1. **Register** → Email verification terkirim
2. **Click link di email** → Email verified
3. **Login** → Masuk ke dashboard
4. **Lupa password** → Click "Forgot Password" → Email reset terkirim
5. **Click link di email** → Set password baru
6. **Login dengan password baru** ✅

### Admin Flow:
1. **Login langsung** (sudah verified di seeder)
2. **Dashboard Admin** → Lihat semua data
3. **Manage users** → Lihat user list & transactions

---

## 🔐 Security Notes

✅ **Implemented:**
- HTTPS recommended untuk production
- CSRF protection
- Email verification required
- Password reset tokens expire
- Throttling di verify/reset routes
- Signed URLs di verify link

---

**Setup Email Verification Lengkap! 📬✅**

Coba daftar dengan email baru dan lihat verification email terkirim! 🎉
