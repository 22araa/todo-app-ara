@extends('layouts.app')
<!-- {{-- Menggunakan layout 'app' sebagai template dasar halaman ini. Semua konten akan dimuat di dalam layout ini. --}} -->

@section('content')
<!-- {{-- Memulai bagian konten utama halaman. Semua konten di sini akan ditampilkan dalam section 'content' pada layout utama. --}} -->

    <div id="content" class="container">
        <!-- {{-- Kontainer utama untuk konten halaman ini --}} -->

        <div class="d-flex align-items-center">
            <!-- {{-- Menyusun elemen secara horizontal dengan class d-flex dan memastikan item sejajar di tengah secara vertikal. --}} -->
            <a href="{{ route('home') }}" class="btn btn-sm">
                <!-- {{-- Tombol kembali ke halaman utama (home) --}} -->
                <i class="bi bi-arrow-left-short fs-4"></i>
                <span class="fw-bold fs-5">Kembali</span>
            </a>
        </div>

        @session('success')
            <!-- {{-- Menampilkan pesan sukses jika ada session 'success' --}} -->
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <!-- {{-- Menampilkan pesan sukses yang diteruskan oleh controller --}} -->
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <!-- {{-- Tombol untuk menutup pesan alert --}} -->
            </div>
        @endsession

        <div class="row my-3">
            <!-- {{-- Membuat baris untuk menampilkan dua kolom: satu untuk detail task, satu lagi untuk form edit --}} -->
            <div class="col-8">
                <!-- {{-- Kolom utama yang lebih besar untuk menampilkan detail task --}} -->
                <div class="card" style="height: 80vh;">
                    <!-- {{-- Card untuk menampilkan detail task --}} -->
                    <div class="card-header d-flex align-items-center justify-content-between overflow-hidden">
                        <!-- {{-- Header card dengan informasi task --}} -->
                        <h3 class="fw-bold fs-4 text-truncate mb-0" style="width: 80%">
                            {{ $task->name }}
                            <!-- {{-- Menampilkan nama task --}} -->
                            <span class="fs-6 fw-medium">di {{ $task->list->name }}</span>
                            <!-- {{-- Menampilkan nama task list tempat task ini berada --}} -->
                        </h3>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#editTaskModal">
                            <!-- {{-- Tombol untuk membuka modal edit task --}} -->
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <!-- {{-- Bagian body dari card --}} -->
                        <p>
                            {{ $task->description }}
                            <!-- {{-- Menampilkan deskripsi dari task --}} -->
                        </p>
                    </div>
                    <div class="card-footer">
                        <!-- {{-- Footer card dengan tombol untuk menghapus task --}} -->
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: inline;">
                            <!-- {{-- Form untuk menghapus task --}} -->
                            @csrf
                            <!-- {{-- Menambahkan token CSRF untuk keamanan --}} -->
                            @method('DELETE')
                            <!-- {{-- Menggunakan method DELETE untuk permintaan penghapusan --}} -->
                            <button type="submit" type="button" class="btn btn-sm btn-outline-danger w-100">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <!-- {{-- Kolom lebih kecil untuk menampilkan detail lainnya seperti status dan prioritas task --}} -->
                <div class="card" style="height: 80vh;">
                    <div class="card-header d-flex align-items-center justify-content-between overflow-hidden">
                        <h3 class="fw-bold fs-4 text-truncate mb-0" style="width: 80%">Details</h3>
                        <!-- {{-- Header card dengan judul "Details" --}} -->
                    </div>
                    <div class="card-body d-flex flex-column gap-2">
                        <!-- {{-- Body card dengan form untuk mengganti task list --}} -->
                        <form action="{{ route('tasks.changeList', $task->id) }}" method="POST">
                            <!-- {{-- Form untuk mengganti task list --}} -->
                            @csrf
                            @method('PATCH')
                            <select class="form-select" name="list_id" onchange="this.form.submit()">
                                <!-- {{-- Dropdown untuk memilih task list baru --}} -->
                                @foreach ($lists as $list)
                                    <!-- {{-- Loop untuk menampilkan semua task list --}} -->
                                    <option value="{{ $list->id }}" {{ $list->id == $task->list_id ? 'selected' : '' }}>
                                        {{ $list->name }}
                                        <!-- {{-- Menampilkan nama task list dan memilih task list yang sesuai dengan task saat ini --}} -->
                                    </option>
                                @endforeach
                            </select>
                        </form>
                        <h6 class="fs-6">
                            Priotitas:
                            <!-- {{-- Menampilkan prioritas task --}} -->
                            <span class="badge text-bg-{{ $task->priorityClass }} badge-pill" style="width: fit-content">
                                {{ $task->priority }}
                            </span>
                            <!-- {{-- Menampilkan badge dengan warna yang sesuai dengan prioritas task --}} -->
                        </h6>
                    </div>
                    <div class="card-footer">
                        <!-- {{-- Footer card kosong --}} -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <!-- {{-- Modal untuk mengedit task --}} -->
        <div class="modal-dialog">
            <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="modal-content">
                @method('PUT')
                <!-- {{-- Menggunakan method PUT untuk pembaruan task --}} -->
                @csrf
                <!-- {{-- Menambahkan token CSRF untuk keamanan --}} -->
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editTaskModalLabel">Edit Task</h1>
                    <!-- {{-- Judul modal --}} -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <!-- {{-- Tombol untuk menutup modal --}} -->
                </div>
                <div class="modal-body">
                    <!-- {{-- Body modal untuk menampilkan form edit task --}} -->
                    <input type="text" value="{{ $task->list_id }}" name="list_id" hidden>
                    <!-- {{-- Menyembunyikan ID task list untuk dikirim bersama data form --}} -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $task->name }}" placeholder="Masukkan nama list">
                        <!-- {{-- Input untuk mengedit nama task --}} -->
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Masukkan deskripsi">{{ $task->description }}</textarea>
                        <!-- {{-- Input untuk mengedit deskripsi task --}} -->
                    </div>
                    <div class="mb-3">
                        <label for="priority" class="form-label">Priority</label>
                        <select class="form-control" name="priority" id="priority">
                            <option value="low" @selected($task->priority == 'low')>Low</option>
                            <option value="medium" @selected($task->priority == 'medium')>Medium</option>
                            <option value="high" @selected($task->priority == 'high')>High</option>
                        </select>
                        <!-- {{-- Dropdown untuk memilih prioritas task --}} -->
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- {{-- Footer modal --}} -->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <!-- {{-- Tombol untuk membatalkan perubahan --}} -->
                    <button type="submit" class="btn btn-primary">Edit</button>
                    <!-- {{-- Tombol untuk menyimpan perubahan task --}} -->
                </div>
            </form>
        </div>
    </div>
@endsection
<!-- {{-- Menandakan akhir dari section content --}} -->
