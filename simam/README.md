# SIMAM — Sistem Informasi Manajemen Data Mahasiswa

## Deskripsi
SIMAM adalah aplikasi web sederhana untuk mengelola data mahasiswa menggunakan PHP dan MySQL. Proyek ini dibuat untuk menerapkan konsep dasar Sistem Informasi Manajemen berbasis web.

## Fitur
- Login dan logout pengguna.
- Proteksi halaman menggunakan session.
- Menampilkan daftar mahasiswa.
- Menambahkan data mahasiswa.
- Mengedit data mahasiswa.
- Menghapus data mahasiswa.
- Validasi dan sanitasi input.
- Koneksi database menggunakan PDO.
- Pilihan bahasa Indonesia dan Inggris.
- Tampilan antarmuka menggunakan CSS.

## Teknologi
- PHP
- MySQL/MariaDB
- PDO
- HTML
- CSS
- XAMPP

## Struktur Database
Database: `simam_db`

Tabel utama:
- `users` — menyimpan akun pengguna.
- `mahasiswa` — menyimpan data mahasiswa.

## Cara Menjalankan
1. Instal dan jalankan Apache serta MySQL melalui XAMPP.
2. Salin folder proyek ke direktori `htdocs`.
3. Buat database `simam_db` melalui phpMyAdmin.
4. Impor file `simam_db.sql`.
5. Periksa konfigurasi koneksi pada `koneksi.php`.
6. Buka `http://localhost/simam/` melalui browser.
7. Login menggunakan akun yang telah dibuat untuk aplikasi.

## Catatan Keamanan
- Password pengguna sebaiknya disimpan dalam bentuk hash.
- Jangan unggah password rahasia atau data pribadi ke repository publik.
- Gunakan data contoh, bukan data mahasiswa sungguhan.

## Pengembang
Nama: Andi Muhamad 
Kelas: IF-2
Mata Kuliah:  Penerapan Teknologi Internet
