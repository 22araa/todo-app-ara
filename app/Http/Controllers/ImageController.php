<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Mengimpor class Request untuk menangani input HTTP dari pengguna
use App\Models\Image; // Mengimpor model Image yang digunakan untuk berinteraksi dengan tabel gambar di database
use Illuminate\Support\Facades\Storage; // Mengimpor facade Storage untuk menangani file storage (misalnya upload, delete)

class ImageController extends Controller
{
    // Menampilkan form upload gambar
    public function showForm()
    {
        return view('upload'); // Mengembalikan tampilan view 'upload' untuk form upload gambar
    }

    // Fungsi untuk meng-upload gambar
    public function uploadImage(Request $request)
    {
        // Validasi gambar yang diupload untuk memastikan file gambar sesuai dengan kriteria
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // File gambar harus berformat image dan maksimal 2MB
        ]);

        // Mengambil file gambar yang di-upload
        $image = $request->file('image');

        // Menyimpan gambar ke dalam folder 'images' di storage/public
        $path = $image->store('images', 'public');

        // Menyimpan path gambar ke database
        Image::create(['path' => $path]);

        // Mengembalikan response setelah gambar berhasil di-upload, dengan pesan sukses dan path gambar
        return back()->with('success', 'Gambar berhasil diupload!')->with('path', $path);
    }

    // Menampilkan semua gambar yang ada di database
    public function showImages()
    {
        $images = Image::all(); // Mengambil semua record gambar dari tabel 'images'
        return view('images.index', compact('images')); // Mengirim data gambar ke view 'images.index' untuk ditampilkan
    }

    // Menghapus gambar dari storage dan database
    public function deleteImage(Image $image)
    {
        // Menghapus file gambar yang ada di storage/public
        Storage::delete('public/' . $image->path);

        // Menghapus record gambar dari database
        $image->delete();

        // Mengembalikan response setelah gambar dihapus dengan pesan sukses
        return back()->with('success', 'Gambar berhasil dihapus!');
    }
}
