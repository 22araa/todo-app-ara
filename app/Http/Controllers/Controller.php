<?php

namespace App\Http\Controllers;  // Menentukan namespace untuk controller, yang biasanya digunakan dalam framework seperti Laravel

// Mendefinisikan kelas Controller sebagai kelas abstrak
abstract class Controller
{
    // Kelas Controller ini akan menjadi kelas dasar untuk controller lainnya
    // Anda tidak bisa membuat instance langsung dari kelas ini karena ia bersifat abstrak
    // Kelas ini kemungkinan akan digunakan untuk menyimpan metode atau logika umum
    // yang akan digunakan oleh controller-controller lain yang mewarisi kelas ini.
    
    // Misalnya, Anda bisa menambahkan metode seperti __construct() untuk menangani middleware
    // atau metode lainnya yang ingin dibagikan oleh semua controller yang mewarisi kelas ini.
}
