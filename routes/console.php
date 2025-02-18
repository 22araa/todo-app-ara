<?php

// Mengimpor kelas Inspiring dari Laravel untuk mendapatkan kutipan inspiratif
use Illuminate\Foundation\Inspiring;
// Mengimpor kelas Artisan untuk mendefinisikan perintah Artisan kustom
use Illuminate\Support\Facades\Artisan;

// Mendefinisikan perintah Artisan kustom dengan nama 'inspire'
Artisan::command('inspire', function () {
    // Menggunakan metode 'comment' untuk menampilkan kutipan inspiratif
    // Metode 'quote()' akan mengembalikan kutipan acak
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote') // Menambahkan deskripsi untuk perintah ini (tujuan)
  ->hourly(); // Menjadwalkan perintah untuk dijalankan setiap jam sekali
