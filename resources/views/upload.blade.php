{{-- 
    <form action="{{ route('upload.image') }}" method="POST" enctype="multipart/form-data">
        <!-- CSRF Token untuk melindungi form dari serangan CSRF -->
        @csrf

        <!-- Input untuk memilih file gambar -->
        <input type="file" name="image" accept="image/*"> 
        <!-- Tombol untuk mengirimkan form dan meng-upload gambar -->
        <button type="submit">Upload</button>
    </form>

    <!-- Mengecek apakah ada session 'success' -->
    @if (session('success'))
        <!-- Menampilkan pesan sukses dari session -->
        <p>{{ session('success') }}</p>
        <!-- Menampilkan gambar yang telah di-upload -->
        <img src=". session('path')) }}" alt="Uploaded Image">
    @endif 
--}}

