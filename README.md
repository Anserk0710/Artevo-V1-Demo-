# Proyek Market Test

## Deskripsi Singkat
Proyek ini adalah aplikasi web berbasis Laravel dengan frontend menggunakan Inertia.js dan Vue.js. Aplikasi ini menyediakan fitur autentikasi pengguna dan panel admin untuk manajemen produk, termasuk penambahan, pengeditan, penghapusan, dan daftar produk.

## Fitur Utama
- Autentikasi pengguna lengkap (login, registrasi, verifikasi email)
- Dashboard pengguna dan admin yang responsif
- Manajemen produk oleh admin:
  - Melihat daftar produk dengan pagination (10 produk per halaman)
  - Menambah produk baru dengan validasi input yang ketat
  - Mengedit dan menghapus produk yang sudah ada
  - Menampilkan detail produk meliputi nama, harga, deskripsi, gambar, ukuran, bahan, dan kode produk unik
- Fitur QR Code untuk setiap produk yang dapat dicetak langsung dari panel admin
- Popup untuk melihat gambar produk dengan tampilan yang menarik
- Pencatatan aktivitas (activity logging) untuk setiap aksi CRUD produk oleh admin, termasuk detail perubahan dan nama admin yang melakukan aksi
- Frontend menggunakan Vue.js dan Inertia.js untuk pengalaman pengguna yang dinamis dan cepat
- UI yang menggunakan Tailwind CSS dengan desain modern dan responsif

## Persyaratan Sistem
- PHP 8.x
- Composer
- Node.js dan npm
- Database (MySQL, PostgreSQL, atau lainnya yang didukung Laravel)

## Instalasi dan Setup
1. Clone repository ini ke komputer Anda.
2. Jalankan `composer install` untuk menginstal dependensi PHP.
3. Jalankan `npm install` untuk menginstal dependensi frontend.
4. Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database.
5. Jalankan migrasi database dengan perintah:
   ```
   php artisan migrate
   ```
6. Jalankan build frontend dengan perintah:
   ```
   npm run dev
   ```

## Cara Menjalankan Aplikasi
Jalankan server Laravel dengan perintah:
```
php artisan serve
```
Akses aplikasi melalui browser di alamat `http://localhost:8000`.

## Cara Menggunakan
- Registrasi dan login sebagai pengguna biasa.
- Setelah login, akses dashboard pengguna.
- Jika Anda adalah admin, akses panel admin di `/admin/dashboard`.
- Di panel admin, Anda dapat mengelola produk melalui menu produk.
- Tambah produk baru dengan mengisi form yang disediakan.
- Cetak QR Code produk langsung dari daftar produk.
- Lihat detail produk lengkap dengan gambar dan informasi lainnya.

## Pengujian
Terdapat beberapa pengujian fitur autentikasi yang dapat dijalankan dengan perintah:
```
php artisan test
```

## Lisensi
Proyek ini menggunakan lisensi MIT.
