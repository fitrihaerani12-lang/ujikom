# Dokumentasi Sistem Manajemen Buku & Kategori (SIMBS)

Proyek ini adalah aplikasi web sederhana berbasis PHP Native untuk mengelola data buku dan kategori buku. Aplikasi ini mencakup fitur autentikasi (Login/Register) dan CRUD (Create, Read, Update, Delete).

## 📂 Struktur File

Berikut adalah penjelasan fungsi dari setiap file dalam proyek ini:

### 1. Halaman Utama & Dashboard
- **`index.php`**: Halaman dashboard utama yang menampilkan **Data Buku**.
  - Menampilkan tabel daftar buku.
  - Fitur pencarian buku (berdasarkan judul, penulis, penerbit).
  - Tombol aksi untuk Edit dan Hapus buku.
  - Sidebar navigasi ke Data Kategori dan Logout.

- **`index2.php`**: Halaman untuk mengelola **Data Kategori**.
  - Menampilkan tabel daftar kategori.
  - Fitur pencarian kategori.
  - Tombol navigasi "Kembali ke Data Buku".
  - Tombol aksi untuk Edit dan Hapus kategori.

### 2. Autentikasi
- **`login.php`**: Halaman login untuk pengguna.
  - Memvalidasi username dan password.
  - Menampilkan pesan error jika login gagal.
  - Menampilkan pesan sukses (alert hijau) setelah registrasi berhasil.

- **`register.php`**: Halaman pendaftaran pengguna baru.
  - Form input username, email, dan password.
  - Validasi password minimal 8 karakter.
  - Jika sukses, data disimpan ke database dan redirect ke halaman login.

- **`logout.php`**: Skrip untuk menangani proses keluar (logout).
  - Menghapus semua session pengguna.
  - Redirect kembali ke halaman login.

### 3. Manajemen Data Buku (CRUD)
- **`tambah_data.php`**: Halaman form untuk menambah data buku baru.
- **`ubah_dataB.php`**: Halaman form untuk mengedit data buku yang sudah ada.
- **`hapus_dataB.php`**: Skrip untuk memproses penghapusan data buku berdasarkan ID.

### 4. Manajemen Data Kategori (CRUD)
- **`tambah_kategori.php`**: Halaman form untuk menambah kategori baru.
- **`ubah_data.php`**: Halaman form untuk mengedit nama kategori.
- **`hapus_data.php`**: Skrip untuk memproses penghapusan kategori berdasarkan ID.

### 5. Konfigurasi & Fungsi
- **`function.php`**: File inti yang berisi koneksi database dan semua fungsi logika aplikasi.
- **`db.sql`**: File dump database MySQL yang berisi struktur tabel (`user`, `buku`, `kategori`) dan data dummy.

---

## 🛠️ Dokumentasi Fungsi (`function.php`)

File `function.php` adalah otak dari aplikasi ini. Berikut adalah daftar fungsi dan kegunaannya:

### Koneksi Database
```php
$conn = mysqli_connect("localhost", "root", "", "simbs");
```
Membuka koneksi ke database MySQL bernama `simbs`.

### Helper Functions
1. **`query($query)`**
   - Menerima string query SQL.
   - Menjalankan query dan mengembalikan hasilnya dalam bentuk array associative.
   - Digunakan untuk mengambil data (SELECT).

2. **`getKategori()`**
   - Mengambil semua data dari tabel `kategori`.
   - Digunakan untuk mengisi dropdown kategori di form tambah/edit buku.

### Fungsi Autentikasi
3. **`register($data)`**
   - Menerima input form registrasi.
   - **Validasi:** Cek username duplikat & panjang password (min 8 karakter).
   - **Enkripsi:** Menggunakan `password_hash()` untuk mengamankan password.
   - Menyimpan user baru ke tabel `user`.

4. **`login($data)`**
   - Menerima input username dan password.
   - **Validasi:** Cek panjang password (min 8 karakter).
   - Mencari user berdasarkan username.
   - **Verifikasi:** Menggunakan `password_verify()` untuk mencocokkan password.
   - Jika berhasil, membuat session login.

### Fungsi CRUD Buku
5. **`tambah_data($data)`**
   - Menerima input form tambah buku.
   - Melakukan sanitasi data (`mysqli_real_escape_string`).
   - Menyimpan data ke tabel `buku`.

6. **`ubah_dataB($data)`**
   - Menerima input form edit buku.
   - Mengupdate data di tabel `buku` berdasarkan `id_buku`.

7. **`hapus_dataB($id)`**
   - Menerima ID buku.
   - Menghapus data dari tabel `buku`.

8. **`search_data($keyword)`**
   - Mencari buku berdasarkan keyword.
   - Melakukan pencarian di kolom `judul`, `penulis`, atau `penerbit`.
   - Menggunakan `JOIN` untuk mengambil nama kategori.

### Fungsi CRUD Kategori
9. **`tambah_kategori($data)`**
   - Menyimpan kategori baru ke tabel `kategori`.

10. **`ubah_kategori($data)`**
    - Mengupdate nama kategori berdasarkan `id_kategori`.

11. **`hapus_kategori($id)`**
    - Menghapus kategori dari tabel `kategori`.

---

## 🚀 Cara Instalasi

1. Pastikan XAMPP sudah terinstal dan Apache serta MySQL berjalan.
2. Copy folder proyek ke dalam `htdocs` (misal: `C:\xampp\htdocs\template_tugas`).
3. Buka **phpMyAdmin** (`http://localhost/phpmyadmin`).
4. Buat database baru dengan nama `simbs`.
5. Import file `db.sql` ke dalam database `simbs`.
6. Buka aplikasi di browser: `http://localhost/template_tugas`.

---

## 📝 Catatan Pengembang
- Password user di database dienkripsi menggunakan algoritma default PHP (Bcrypt).
- Kolom `tanggal_input` pada kategori otomatis terisi tanggal hari ini (tipe `DATE`).
- Pastikan file `function.php` selalu di-include (`require`) di setiap halaman yang membutuhkan akses database.

---

## 📜 Riwayat Perubahan (Changelog)

Berikut adalah daftar perbaikan dan fitur baru yang telah diimplementasikan:

### 1. Perbaikan Fitur Utama
- **Fix Login & Logout**:
  - Membuat `login.php` dan `logout.php` berfungsi sepenuhnya.
  - Mengarahkan logout kembali ke halaman login (bukan index).
  - Menambahkan validasi session di setiap halaman.
- **Fix CRUD Buku**:
  - Memperbaiki query Edit dan Hapus yang sebelumnya salah referensi kolom (`id` vs `id_buku`).
  - Memperbaiki fitur Tambah Data yang sebelumnya tidak menyimpan tanggal input.
- **Fix Search**:
  - Memperbaiki form pencarian di `index.php` (menambahkan method POST).

### 2. Penambahan Fitur Baru
- **Manajemen Kategori (CRUD)**:
  - Membuat halaman `index2.php` untuk daftar kategori.
  - Menambahkan fitur Tambah, Edit, dan Hapus Kategori.
  - Menambahkan navigasi "Kembali ke Data Buku" di halaman kategori.
- **Validasi Password**:
  - Menambahkan validasi minimal 8 karakter pada Login dan Register.
  - Menambahkan teks petunjuk "Minimal 8 karakter" di bawah input password.
- **Notifikasi Registrasi**:
  - Menambahkan alert sukses berwarna hijau di halaman Login setelah user berhasil registrasi.

### 3. Perbaikan Database & UI
- **Database**:
  - Menambahkan kolom `tanggal_input` (tipe DATE) pada tabel `kategori`.
  - Menghapus jam dari tampilan tanggal input (hanya menampilkan tanggal).
- **UI/UX**:
  - Memperbaiki link navigasi sidebar.
  - Menambahkan tombol Back yang responsif.
  - Memperbaiki struktur tabel dengan `thead` dan `tbody`.

