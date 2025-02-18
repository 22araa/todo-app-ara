<?php

use Illuminate\Foundation\Application; // Mengimpor class Application dari Laravel untuk konfigurasi aplikasi
use Illuminate\Foundation\Configuration\Exceptions; // Mengimpor class Exceptions untuk konfigurasi penanganan exception
use Illuminate\Foundation\Configuration\Middleware; // Mengimpor class Middleware untuk mengonfigurasi middleware aplikasi

return Application::configure(basePath: dirname(__DIR__)) // Mengonfigurasi aplikasi dengan base path yang ditentukan, di sini adalah direktori induk aplikasi
    ->withRouting( // Mengonfigurasi routing aplikasi
        web: __DIR__.'/../routes/web.php', // Menentukan lokasi file route web untuk aplikasi
        commands: __DIR__.'/../routes/console.php', // Menentukan lokasi file route console (untuk perintah artisan atau CLI)
        health: '/up', // Menentukan route untuk health check aplikasi, biasanya digunakan untuk memeriksa status aplikasi
    )
    ->withMiddleware(function (Middleware $middleware) { // Mengonfigurasi middleware aplikasi
        // Di sini Anda bisa menambahkan middleware tambahan jika diperlukan
    })
    ->withExceptions(function (Exceptions $exceptions) { // Mengonfigurasi penanganan exception aplikasi
        // Di sini Anda bisa menambahkan penanganan atau konfigurasi custom untuk exception
    })
    ->create(); // Membuat dan mengonfigurasi aplikasi sesuai dengan konfigurasi di atas
