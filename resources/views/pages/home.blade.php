<!-- {{-- Menggunakan layout app yang umum di seluruh halaman aplikasi. --}} -->
@extends('layouts.app')

<!-- {{-- Bagian utama content, dengan pengaturan overflow untuk menghindari scroll pada sumbu vertikal dan horizontal. --}} -->
@section('content')
    <div id="content" class="overflow-y-hidden ove rflow-x-hidden">
        <!-- {{-- Menampilkan pesan jika tidak ada daftar tugas yang ada, dan tombol untuk menambah daftar tugas baru. --}} -->
        @if ($lists->count() == 0)
            <div class="d-flex flex-column align-items-center">
                <p class="fw-bold text-center">Belum ada tugas yang ditambahkan</p>
                <button type="button" class="btn btn-sm d-flex align-items-center gap-2 btn-outline-primary"
                    style="width: fit-content;">
                    <i class="bi bi-plus-square fs-3"></i> Tambah
                </button>
        @endif
        <!-- {{-- Membuat container fleksibel dengan scroll horizontal, mengisi seluruh tinggi viewport. --}} -->
        <div class="d-flex gap-3 px-3 flex-nowrap overflow-x-scroll overflow-y-hidden" style="height: 100vh;">
            <!-- {{-- Mengiterasi setiap daftar tugas ($lists) dan membuat sebuah card untuk setiap daftar tugas. --}} -->
            @foreach ($lists as $list)
                <div class="card flex-shrink-0" style="width: 18rem; max-height: 80vh;">
                    <div class="card-header d-flex align-items-center justify-content-between bg-primary">
                        <h4 class="card-title">{{ $list->name }}</h4>
                        <!-- {{-- Form untuk menghapus daftar tugas, menggunakan metode DELETE. --}} -->
                        <form action="{{ route('lists.destroy', $list->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm p-0">
                                <i class="bi bi-trash fs-5 text-danger"></i>
                            </button>
                        </form>
                    </div>
                    <div class="card-body d-flex flex-column gap-2 overflow-x-hidden">
                        <!-- {{-- Mengiterasi tugas yang terkait dengan daftar tertentu dan menampilkannya dalam card. --}} -->
                        @foreach ($tasks as $task)
                            @if ($task->list_id == $list->id)
                            <!-- Tampilkan tugas untuk daftar tertentu -->
                                <div class="card">
                                    <div class="card-header">
                                          
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex flex-column justify-content-center gap-2">
                                                <!-- {{-- Tautan ke detail tugas, dengan teks yang dicoret jika tugas sudah selesai ($task->is_completed). --}} -->
                                                <a href="{{route('tasks.show', $task->id)}}"
                                                 class="fw-bold lh-1 m-0 {{ $task->is_completed ? 'text-decoration-line-through' : '' }}">
                                                    {{ $task->name }}
                                                </a>
                                                <span class="badge text-bg-{{ $task->priorityClass }} badge-pill"
                                                    style="width: fit-content">
                                                    {{ $task->priority }}
                                                </span>
                                            </div>
                                            <!-- {{-- Form untuk menghapus tugas, menggunakan metode DELETE. --}} -->
                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm p-0">
                                                    <i class="bi bi-x-circle text-danger fs-5"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text text-truncate">
                                            {{ $task->description }}
                                        </p>
                                    </div>
                                    @if (!$task->is_completed)
                                        <div class="card-footer">
                                            <!-- {{-- Form untuk menandai tugas sebagai selesai dengan metode PATCH. --}} -->
                                            <form action="{{ route('tasks.complete', $task->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-primary w-100">
                                                    <span class="d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-check fs-5"></i>
                                                        Selesai
                                                    </span>
                                                </button>
                                            </form>

                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                        <!-- {{-- Tombol untuk membuka modal penambahan tugas baru, yang terkait dengan daftar tugas tertentu. --}} -->
                        <button type="button" class="btn btn-sm btn-outline-dark " data-bs-toggle="modal"
                        data-bs-target="#addTaskModal" data-list="{{ $list->id }}">
                        <span class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-plus fs-5"></i>
                            Tambah
                        </span>
                    </button>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <p class="card-text">{{ $list->tasks->count() }} Tugas</p>
                </div>
            </div>
        @endforeach
       <button type="button" class="btn btn-outline-dark flex-shrink-0" style="width: 18rem; height: fit-content;"
       data-bs-toggle="modal" data-bs-target="#addListModal">
       <span class="d-flex align-items-center justify-content-center">
        <i class="bi bi-plus fs-5"></i>
        Tambah
       </span>
       </button>
    </div>
</div>

<!-- {{-- Mengambil input pencarian, dan jika panjangnya lebih dari 3 karakter, mengirim permintaan ke endpoint pencarian. --}} -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search-input'); // Pastikan ada input dengan ID ini
        searchInput = addEventListener('input', function () {
            const query = searchInput.value.trim();

            if (query.length >= 3){
                fetch(`/search?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    renderSearchResults(data);
                })
                .catch(error => console.error('Error fetching search results:', error));
            }
        });
        // Fungsi renderSearchResults akan memperbarui konten dengan hasil pencarian tugas dan daftar tugas.
        function renderSearchResults(data) {
            const container = document.getElementById('content'); // Pastikan ini ID kontainer tugas anda 
            container.innerHTML = ''; // Hapus semua isi lama

            if (data.task_lists.length === 0 && data.tasks.length === 0) {
                container.innerHTML = '<p class="fw-bold text-center">Tidak ada hasil ditemukan</p>';
            return;
            }

            let contentHTML = '<div class="d-flex gap-3 px3 flex-nowrap overflow-x-scroll overflow-y-hidden" style="height: 80vh;"></div>';

            data.task_lists.forEach(list => {
                contentHTML += `
                <div class="card flex-shrink-0 bg-info" style="width: 18rem; max-height: 80vh;">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h4 class="card-title">${list.name}</h4>
                    </div>
                    <div class="card-body d-flex flex-column gap-2 overflow-x-hidden">
                    </div>
                </div>`;

            const filteredTasks = data.tasks.filter(task => task.list_id === list.id);
            filteredTasks.forEach(task => {
                contentHTML += `
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="d-flex flex-column justify-content-center gap-2">
                            <a href="/tasks/${task.id}" class="fw-bold 1h-1 m-0 ${task.is_completed ? 'text-decoration-line-through' : ''}">
                                ${task.name}
                                </a>
                                <span class="badge text-bg-${task.priority}" 
                                style="width: fit-content">${task.priority}</span>
                                </div>
                                </div>
                                <div class="card-body">
                                    <p class="card-text text-truncate">${task.description ?? ''}</p>
                                    </div>
                                </div>
                                `;
            });

            contentHTML += '</div></div>'; // Tutu[ list div]
            });

            contentHTML += '</div>'; // Tutup container utama
            container.innerHTML = contentHTML;
        }
    });
</script>

<!-- {{-- Halaman ini memungkinkan pengguna untuk mengelola daftar tugas, menambah, menghapus, dan menandai tugas sebagai selesai. --}} -->
@endsection