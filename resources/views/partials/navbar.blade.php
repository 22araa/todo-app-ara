<!-- Navbar Utama -->
<nav class="navbar navbar-expand-lg bg-primary">
    <div class="container-fluid">
        <!-- Profil Pengguna dengan Dropdown -->
        <div class="dropdown">
            <!-- Link untuk membuka dropdown dengan gambar profil pengguna -->
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <!-- Gambar Profil Pengguna -->
                <img src="{{ asset('img/zahraa.jpeg') }}" alt="Profil" class="rounded-circle me-1 avatar-image" width="50" height="40">
                <!-- Nama Pengguna -->
                <span class="fw-semibold">azzahra salsabila</span>
            </a>
            <!-- Menu dropdown untuk profil pengguna -->
            <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="#">Profile</a></li> <!-- Menu untuk melihat profil -->
                <li><a class="dropdown-item" href="#">Logout</a></li> <!-- Menu untuk keluar (logout) -->
            </ul>
        </div>

        <!-- Nama Aplikasi (Brand) -->
        <div class="d-flex align-items-center justify-content-center">
            <a class="navbar-brand fw-bolder text-white" href="#">{{ config('app.name') }}</a> <!-- Nama aplikasi dari config -->
        </div>

        <!-- Form Pencarian -->
        <form action="{{ route('home') }}" method="GET" class="d-flex gap-3 align-items-center">
            <!-- Input untuk kata kunci pencarian -->
            <input type="text" class="form-control" name="query" id="searchQuery" placeholder="🔍 Cari tugas atau list..." value="{{ request()->query('query') }}">
            <!-- Tombol pencarian -->
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
    </div>
</nav>

<!-- Custom CSS untuk Gambar dan Animasi -->
<style>
    /* Gaya untuk gambar profil pengguna (avatar) */
    .avatar-image {
        transition: transform 0.3s ease, opacity 0.3s ease-in-out; /* Efek transisi untuk memperbesar dan mengubah opacity */
        width: 60px; /* Ukuran gambar avatar */
        height: 60px; /* Ukuran gambar avatar */
    }

    /* Efek Hover saat cursor berada di atas gambar profil */
    .avatar-image:hover {
        transform: scale(1.5); /* Memperbesar gambar menjadi 1.5x ukuran aslinya */
        opacity: 0.8; /* Mengurangi opacity saat hover */
    }

    /* Animasi fade-in untuk gambar */
    .avatar-image {
        animation: fadeIn 1s ease-in-out; /* Animasi untuk membuat gambar muncul secara perlahan */
    }

    /* Keyframes untuk animasi fade-in */
    @keyframes fadeIn {
        0% {
            opacity: 0; /* Mulai dengan opacity 0 (gambarnya tidak terlihat) */
        }
        100% {
            opacity: 1; /* Akhirnya gambar menjadi sepenuhnya terlihat */
        }
    }
</style>
