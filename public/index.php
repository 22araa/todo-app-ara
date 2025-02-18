<?php

use Illuminate\Http\Request; // Mengimpor class Request dari Laravel yang digunakan untuk menangani request HTTP

// Mendefinisikan konstanta LARAVEL_START yang berisi waktu saat aplikasi dimulai
define('LARAVEL_START', microtime(true)); 

// Menentukan apakah aplikasi dalam mode pemeliharaan (maintenance mode)...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    // Jika file maintenance.php ada, artinya aplikasi sedang dalam mode pemeliharaan,
    // maka file tersebut akan dimuat dan aplikasi akan berhenti untuk memberikan informasi pemeliharaan
    require $maintenance;
}

// Mendaftarkan autoloader Composer...
require __DIR__.'/../vendor/autoload.php'; 
// Autoloader ini bertanggung jawab untuk memuat semua dependensi yang diperlukan oleh aplikasi
// sesuai dengan yang terdaftar di file composer.json

// Bootstrap Laravel dan menangani request...
(require_once __DIR__.'/../bootstrap/app.php') // Memuat file bootstrap/app.php untuk menginisialisasi aplikasi Laravel
    ->handleRequest(Request::capture()); // Menangani request yang ditangkap oleh Request::capture()
// Request::capture() digunakan untuk mengambil data request HTTP yang masuk dan memprosesnya lebih lanjut
