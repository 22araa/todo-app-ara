<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; // Mengimpor class Model untuk menggunakan fitur Eloquent ORM

class TaskList extends Model
{
    /**
     * Kolom yang dapat diisi secara mass-assignment.
     * Kolom-kolom ini dapat diisi oleh pengguna saat membuat atau memperbarui data task list.
     */
    protected $fillable = ['name']; // Hanya kolom 'name' yang dapat diisi oleh mass-assignment

    /**
     * Kolom yang tidak dapat diisi oleh pengguna secara mass-assignment.
     * Kolom ini hanya bisa diatur secara otomatis oleh sistem (misalnya, oleh Eloquent).
     */
    protected $guarded = [
        'id',           // ID task list (auto increment, tidak bisa diisi secara manual)
        'created_at',   // Timestamp otomatis untuk waktu pembuatan
        'updated_at'    // Timestamp otomatis untuk waktu pembaruan
    ];

    /**
     * Relasi One to Many dengan Task.
     * Setiap TaskList dapat memiliki banyak Task, dan ini mendefinisikan relasi tersebut.
     */
    public function tasks() {
        return $this->hasMany(Task::class, 'list_id'); // Task berhubungan dengan TaskList melalui 'list_id'
    }
}
