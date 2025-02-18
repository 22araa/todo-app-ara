<?php

namespace App\Http\Controllers;

use App\Models\TaskList; // Mengimpor model TaskList untuk berinteraksi dengan tabel task_lists
use Illuminate\Http\Request; // Mengimpor class Request untuk menangani input dari pengguna

class TaskListController extends Controller
{
    /**
     * Method untuk menyimpan data TaskList baru ke dalam database
     */
    public function store(Request $request) 
    {
        // Validasi input dari pengguna
        // Memastikan nama task list diisi dan maksimal 100 karakter
        $request->validate([
            'name' => 'required|max:100' // Validasi nama harus diisi dan tidak lebih dari 100 karakter
        ]);

        // Menyimpan data TaskList baru ke dalam database
        // Nama task list diambil dari input form
        TaskList::create([
            'name' => $request->name // Nama task list yang diinput oleh pengguna
        ]);

        // Setelah data disimpan, kembali ke halaman sebelumnya
        // Biasanya untuk menampilkan konfirmasi atau form kosong kembali
        return redirect()->back(); 
    }

    /**
     * Method untuk menghapus TaskList berdasarkan ID
     */
    public function destroy($id) 
    {
        // Mencari TaskList berdasarkan ID dan menghapusnya
        // Jika task list dengan ID tersebut tidak ditemukan, maka akan memunculkan error 404
        TaskList::findOrFail($id)->delete(); 

        // Setelah task list dihapus, kembali ke halaman sebelumnya
        // Biasanya untuk menampilkan daftar yang diperbarui
        return redirect()->back();
    }
}
