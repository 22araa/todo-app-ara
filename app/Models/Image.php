<?php

// app/Models/Post.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

// class Post extends Model
// {
//     use HasFactory;

//     // Tambahkan kolom yang dapat diisi
//     protected $fillable = ['title', 'content', 'image'];

//     // Fungsi untuk menyimpan gambar
//     public function setImageAttribute($value)
//     {
//         if (is_file($value)) {
//             $this->attributes['image'] = $value->store('images', 'public');
//         }
//     }
// }
