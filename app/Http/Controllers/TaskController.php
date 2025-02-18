<?php

namespace App\Http\Controllers;

use App\Models\Task; // Mengimpor model Task untuk berinteraksi dengan tabel tugas
use App\Models\TaskList; // Mengimpor model TaskList untuk berinteraksi dengan tabel daftar tugas
use Illuminate\Http\Request; // Mengimpor class Request untuk menangani input dari pengguna

class TaskController extends Controller
{
    /**
     * Menampilkan daftar tugas dan daftar tugas yang sesuai dengan query pencarian
     * 
     * Jika query pencarian ada, akan melakukan pencarian pada tugas dan daftar tugas.
     * Jika tidak ada query, maka semua tugas dan daftar tugas akan ditampilkan.
     */
    public function index(Request $request)
    {
        $query = $request->input('query'); // Mengambil input pencarian dari pengguna

        // Jika ada query pencarian, lakukan pencarian pada tugas dan task lists
        if ($query) {
            // Pencarian tugas berdasarkan nama atau deskripsi
            $tasks = Task::where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->latest() // Mengambil hasil pencarian terbaru
                ->get();

            // Pencarian task lists berdasarkan nama atau tugas terkait dengan query
            $lists = TaskList::where('name', 'like', "%{$query}%")
                ->orWhereHas('tasks', function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                })
                ->with('tasks') // Memuat tugas terkait dalam task list
                ->get();

            // Jika hasil pencarian tugas kosong, tetap memuat tasks dalam task lists
            if ($tasks->isEmpty()) {
                $lists->load('tasks');
            } else {
                // Jika ada tugas yang ditemukan, filter tugas terkait dengan query pencarian
                $lists->load(['tasks' => function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                }]);
            }
        } else {
            // Jika tidak ada query pencarian, tampilkan semua tugas dan task lists
            $tasks = Task::latest()->get(); // Mengambil semua tugas terbaru
            $lists = TaskList::with('tasks')->get(); // Mengambil semua task lists dengan tugas terkait
        }

        // Menyusun data untuk ditampilkan pada view home
        $data = [
            'title' => 'Home',
            'lists' => $lists,
            'tasks' => $tasks,
            'priorities' => Task::PRIORITIES // Mendapatkan daftar prioritas tugas
        ];

        // Mengembalikan view 'home' dengan data yang telah disiapkan
        return view('pages.home', $data);
    }

    /**
     * Menyimpan tugas baru ke dalam database
     */
    public function store(Request $request)
    {
        // Validasi input tugas yang diterima
        $request->validate([
            'name' => 'required|max:100', // Nama tugas wajib diisi dan maksimal 100 karakter
            'description' => 'max:255', // Deskripsi tugas maksimal 255 karakter
            'list_id' => 'required' // ID list tugas wajib diisi
        ]);

        // Membuat tugas baru di database
        Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'list_id' => $request->list_id
        ]);

        // Mengembalikan pengguna ke halaman sebelumnya
        return redirect()->back();
    }

    /**
     * Menandai tugas sebagai selesai
     */
    public function complete($id)
    {
        // Menandai tugas dengan ID tertentu sebagai selesai
        Task::findOrFail($id)->update([
            'is_completed' => true // Mengubah status tugas menjadi selesai
        ]);

        // Kembali ke halaman sebelumnya
        return redirect()->back();
    }

    /**
     * Menghapus tugas berdasarkan ID
     */
    public function destroy($id)
    {
        // Mencari dan menghapus tugas dengan ID tertentu
        Task::findOrFail($id)->delete();

        // Mengarahkan pengguna ke halaman utama setelah menghapus tugas
        return redirect()->route('home');
    }

    /**
     * Menampilkan detail tugas berdasarkan ID
     */
    public function show($id)
    {
        // Menyusun data untuk menampilkan detail tugas
        $data = [
            'title' => 'Task', // Judul halaman
            'lists' => TaskList::all(), // Menampilkan semua daftar tugas
            'task' => Task::findOrFail($id), // Menampilkan detail tugas berdasarkan ID
        ];

        // Mengembalikan view dengan data tugas yang ditemukan
        return view('pages.details', $data);
    }

    /**
     * Mengubah daftar tugas untuk tugas tertentu
     */
    public function changeList(Request $request, Task $task)
    {
        // Validasi input untuk memastikan ID list yang baru valid
        $request->validate([
            'list_id' => 'required|exists:task_lists,id', // Memastikan ID list valid
        ]);

        // Memperbarui ID daftar tugas untuk tugas tertentu
        Task::findOrFail($task->id)->update([
            'list_id' => $request->list_id
        ]);

        // Mengembalikan halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'List berhasil diperbarui!');
    }

    /**
     * Memperbarui tugas berdasarkan ID
     */
    public function update(Request $request, Task $task)
    {
        // Validasi input untuk memperbarui tugas
        $request->validate([
            'list_id' => 'required', // ID daftar tugas wajib diisi
            'name' => 'required|max:100', // Nama tugas wajib diisi dan maksimal 100 karakter
            'description' => 'max:255', // Deskripsi tugas maksimal 255 karakter
            'priority' => 'required|in:low,medium,high' // Prioritas tugas wajib diisi dan salah satu dari 'low', 'medium', atau 'high'
        ]);

        // Memperbarui data tugas di database
        Task::findOrFail($task->id)->update([
            'list_id' => $request->list_id,
            'name' => $request->name,
            'description' => $request->description,
            'priority' => $request->priority
        ]);

        // Mengarahkan kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Task berhasil diperbarui!');
    }
}
