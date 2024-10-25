# Sistem Pencatatan UAT

## Deskripsi Proyek
Sistem Pencatatan UAT adalah aplikasi web yang digunakan untuk mengelola **Project**, **Test Suite**, **Test Case**, **Test Result**, dan **Komentar** dalam proses **User Acceptance Testing (UAT)**. Sistem ini juga menyediakan fitur untuk **Kelola User** dan **Profile Management**. Aplikasi ini dibangun menggunakan Laravel dan Livewire untuk mendukung interaksi yang dinamis tanpa harus memuat ulang halaman.

## Struktur dan Hierarki Folder

Struktur folder pada proyek ini mengikuti pola modular, dengan pembagian komponen dan halaman berdasarkan fungsionalitas utama. Berikut adalah penjelasan singkat mengenai struktur folder di dalam direktori `app/Livewire/` dan `resources/views/`:

### 1. `app/Livewire/`
   - **Pages/**  
     Mengandung file-file Livewire untuk berbagai halaman dalam aplikasi:
     - **Projects/**  
       Halaman terkait Project dan pengelolaannya.  
       - **TestSuites/**  
         Halaman pengelolaan Test Suites dalam setiap Project.  
         - **TestCases/**  
           Halaman untuk mengelola Test Cases dari Test Suite.  
           - **TestResults/**  
             Halaman untuk mencatat dan mengelola Test Results dari setiap Test Case.  
             - **Komentar/**  
               Halaman untuk menambah dan melihat Komentar terkait Test Results.  

   - **Components/**  
     Berisi komponen Livewire yang modular untuk mendukung berbagai interaksi:
     - **Projects/**  
       Komponen untuk menambah, mengedit, dan menghapus Project.  
       - **TestSuites/**  
         Komponen untuk menambah, mengedit, dan menghapus Test Suites.  
         - **TestCases/**  
           Komponen untuk menambah, mengedit, dan menghapus Test Cases.  
           - **TestResults/**  
             Komponen untuk menambah, mengedit, dan menghapus Test Results.  
             - **Komentar/**  
               Komponen untuk menambah, mengedit, dan menghapus Komentar.  

   - **KelolaUser/**  
     Komponen dan halaman untuk mengelola akun pengguna, seperti pembuatan, pengeditan, dan penghapusan pengguna, serta reset password.  
     
   - **Profile/**  
     Komponen untuk melihat dan mengedit detail profil pengguna serta mengubah password.  
     
   - **Navbar.php**  
     Komponen Global Livewire untuk menampilkan dan mengelola **Navbar** di aplikasi.

### 2. `resources/views/`
   Struktur dalam direktori ini mengikuti penyusunan yang sama seperti di `app/Livewire/`, dengan pembagian folder berdasarkan komponen dan halaman yang terkait.

## Instalasi Proyek

Untuk menginstal dan menjalankan proyek ini di lingkungan lokal, ikuti langkah-langkah berikut:

### Clone Repository
Clone repository dari GitLab atau GitHub menggunakan perintah:
- git clone https://github.com/username/repository.git
- Salin file .env.example menjadi .env dan sesuaikan pengaturan yang diperlukan, seperti koneksi database
- composer install
- composer require livewire/livewire
- composer require friendsofphp/php-cs-fixer --dev
- npm install && npm run build
- php artisan key:generate
- php artisan migrate
- php artisan db:seed
