# SISTEM KEUANGAN BIDANG USAHA
Sistem Keuangan Bidang Usaha adalah aplikasi berbasis web yang dirancang untuk mempermudah pencatatan transaksi keuangan dalam suatu usaha atau organisasi. Sistem ini memungkinkan pengguna untuk mencatat pemasukan dan pengeluaran dengan mudah, serta menyediakan fitur unggah struk/nota untuk meningkatkan transparansi dan akuntabilitas transaksi.

## Fitur-fitur utama:
- Pencatatan transaksi keuangan (pemasukan dan pengeluaran)
- Upload struk/nota sebagai bukti transaksi
- CRUD (Create, Read, Update, Delete) untuk transaksi keuangan
- Laporan dan pemantauan saldo keuangan secara real-time

## Petunjuk Instalasi
**Persyaratan Sistem :**
- Web server (Apache)
- PHP 7.4 atau lebih tinggi
- Database MySQL atau MariaDB

**Instalasi**
1. Unduh repositori ini ke direktori server Anda.
2. Buat database baru bernama *akuntansi*.
3. Buat tabel database secara manual sesuai dengan struktur yang dibutuhkan. Berikut adalah contoh tabel:
    ```Tabel transaksi:
    
    CREATE TABLE transaksi ( 
    id INT AUTO_INCREMENT PRIMARY KEY,  
    tanggal DATETIME NOT NULL,  
    keterangan TEXT NOT NULL,  
    debit INT DEFAULT 0,  
    kredit INT DEFAULT 0,  
    saldo INT DEFAULT 0
    );
4. Konfigurasikan koneksi database di file koneksi.php dengan detail seperti host, username, password, dan nama database.
5. Akses aplikasi melalui browser dengan URL server Anda.

## Pengoperasian

1. Login: Masuk dengan kredensial pengguna.
2. Transaksi: Tambahkan pemasukan/pengeluaran, pilih kategori, masukkan nilai transaksi, dan unggah struk/nota (opsional).
3. Laporan: Lihat ringkasan keuangan per periode melalui menu laporan.

## Pengembangan
**Pengaturan Database:**
Edit file config/database.php dengan detail koneksi:
```php
'host' => 'localhost',
'username' => 'root',
'password' => '',
'database' => 'akuntansi'
```
**Struktur File Utama:** 
- index.php: Halaman utama aplikasi.
- koneksi.php: Konfigurasi database.
- process.php: Logika untuk transaksi keuangan.
- dashboard.php: Tampilan dan pengelolaan transaksi keuangan.
