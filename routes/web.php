<?php

// Mengimpor controller yang dibutuhkan
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskListController;
use Illuminate\Support\Facades\Route;

// Membuat route untuk halaman utama (home)
// Menampilkan halaman dengan menggunakan metode 'index' dari TaskController
Route::get('/', [TaskController::class, 'index'])->name('home');

// Membuat resource route untuk 'lists' yang mengarah ke TaskListController
// Route ini akan menangani operasi CRUD untuk TaskList
Route::resource('lists', TaskListController::class);

// Membuat resource route untuk 'tasks' yang mengarah ke TaskController
// Route ini akan menangani operasi CRUD untuk Task
Route::resource('tasks', TaskController::class);

// Membuat route untuk menandai tugas sebagai selesai
// Menggunakan metode 'patch' untuk memperbarui status tugas
Route::patch('/tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');

// Membuat route untuk mengubah list tempat tugas berada
// Menggunakan metode 'patch' untuk memperbarui list tugas
Route::patch('/tasks/{task}/change-list', [TaskController::class, 'changeList'])->name('tasks.changeList');
