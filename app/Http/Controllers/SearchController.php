<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Mengimpor class Request untuk menangani input dari pengguna
use App\Models\Task; // Mengimpor model Task untuk berinteraksi dengan tabel tugas
use App\Models\TaskList; // Mengimpor model TaskList untuk berinteraksi dengan tabel daftar tugas

class SearchController extends Controller
{
    /**
     * Handle search requests
     * 
     * Method ini akan menangani permintaan pencarian untuk tugas dan daftar tugas
     * berdasarkan kata kunci yang diberikan oleh pengguna.
     */
    public function search(Request $request)
    {
        // Mengambil input pencarian yang dimasukkan oleh pengguna dalam form
        $query = $request->input('input');

        // Validasi input pencarian
        // Memastikan query yang dimasukkan adalah string dan minimal terdiri dari 3 karakter
        $request->validate([
            'query' => 'required|string|min:3' // Pencarian tidak boleh kosong, harus string, dan minimal 3 karakter
        ]);

        // Pencarian data di tabel 'tasks' berdasarkan kolom 'name' atau 'description'
        // Menggunakan operator LIKE untuk mencari kemiripan kata kunci dengan nama atau deskripsi tugas
        $taskResults = Task::where('name', 'LIKE', "%{$query}%") // Pencarian berdasarkan nama tugas
            ->orWhere('description', 'LIKE', "%{$query}%") // Pencarian juga berdasarkan deskripsi tugas
            ->get(); // Mengambil hasil pencarian dalam bentuk koleksi (collection)

        // Pencarian data di tabel 'task_lists' berdasarkan kolom 'name'
        $taskListResults = TaskList::where('name', 'LIKE', "%{$query}%")
            ->get(); // Mengambil hasil pencarian dalam bentuk koleksi (collection)

        // Mengembalikan hasil pencarian dalam format JSON
        // Hasil pencarian dibagi menjadi dua kategori: tasks dan task_lists
        return response()->json([
            'tasks' => $taskResults, // Menyertakan hasil pencarian tugas
            'task_lists' => $taskListResults // Menyertakan hasil pencarian task lists
        ]);
    }
}
