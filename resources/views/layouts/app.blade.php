<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Mendefinisikan charset untuk encoding karakter -->
    <meta charset="UTF-8">
    <!-- Menyediakan meta tag untuk responsif, agar tampilan sesuai dengan perangkat (mobile/desktop) -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Menyediakan kompatibilitas dengan Internet Explorer -->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Menampilkan title halaman dengan nama aplikasi dinamis berdasarkan 'app.name' dari konfigurasi Laravel -->
    <title>{{ $title }} - {{ config('app.name') }}</title>

    <!-- Mengimpor file CSS untuk Bootstrap -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <!-- Mengimpor ikon Bootstrap -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/font/bootstrap-icons.min.css') }}">
</head>

<body>
    <!-- Memanggil komponen navbar (partial view) untuk menampilkan navbar aplikasi
    Menggunakan directive untuk menyertakan partial views seperti navbar dan modal, yang menghemat penulisan kode dan meningkatkan modularitas. -->
    @include('partials.navbar')

    <!-- Bagian ini akan menampilkan konten halaman yang spesifik, 
         menggunakan direktif untuk menempatkan konten dari view tertentu -->
    @yield('content')

    <!-- Memanggil komponen modal (partial view) untuk menampilkan modal jika diperlukan -->
    @include('partials.modal')

    <!-- Menambahkan script JS tambahan untuk interaksi halaman -->
    <script src="{{ asset('js/script.js') }}"></script>
    <!-- Menambahkan file JavaScript untuk Bootstrap -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
</body>

</html>
