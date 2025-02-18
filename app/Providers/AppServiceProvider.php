<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider; // Mengimpor class ServiceProvider dari Laravel untuk membuat provider aplikasi

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * 
     * Method ini digunakan untuk mendaftarkan layanan atau binding yang dibutuhkan oleh aplikasi.
     * Biasanya digunakan untuk mengikat class ke dalam service container atau mendaftarkan service.
     */
    public function register(): void
    {
        // Di sini Anda bisa mendaftarkan berbagai layanan atau binding
        // Contoh: $this->app->bind('SomeClass', SomeClassImplementation::class);
    }

    /**
     * Bootstrap any application services.
     * 
     * Method ini digunakan untuk bootstrapping layanan setelah aplikasi siap.
     * Biasanya digunakan untuk konfigurasi atau set up tambahan yang perlu dijalankan pada aplikasi.
     */
    public function boot(): void
    {
        // Di sini Anda bisa menginisialisasi atau menyiapkan layanan
        // Contoh: Blade::directive('customDirective', function() { return 'example'; });
    }
}
