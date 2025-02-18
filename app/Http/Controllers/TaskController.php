<?php
// task controler digunakan untuk menampilkan isi daftar tugas,menambahkan tugas baru,mengedit tugas  dan menandai tugas selesai dan menghapus tugas //

 // mengelompokkan kelas-kelas controller yang ada di dalam folder app/Http/Controllers.//
namespace App\Http\Controllers;

// untuk memanggil //
use App\Models\Task;
use App\Models\TaskList;
use Illuminate\Http\Request; 
// untuk menangani permintaan data akses yg dikirim oleh penguna //

class TaskController extends Controller
{
    public function index() {
        // berfungsi untuk mengambil data dari databse //
        $data = [
            'title' => 'Home',
            'lists' => TaskList::all(), 
            // mengambil semua list yg ada di dalam database //
            'tasks' => Task::orderBy('created_at', 'desc')->get(),
            // descending dari besar ke kecil ascending:dari kecil ke besar //
            // get mendapatkan data task yang nantinya akan dibuat berurutan sesuai urutan descending //
            'priorities' => Task::PRIORITIES
            // priorities digunakan untuk mengambil data priority yg ada di database //
        ];

        return view('pages.home', $data);
        // setelah kita mengambil data akan diarahkan ke halaman home //
    }

    public function store(Request $request)
    // digunakan untuk menyimpan data baru ke dalam databases // 
     {
        $request->validate
        // digunakan untuk memvalidassi yg dikirim oleh pengguna //
        ([
            'name' => 'required|max:100',
            // required(wajib diisi)  max:100:tidak lebih dari 100 huruf//
            
            'description' => 'max:255' ,
            'priority' =>  'required | in:low,medium,high'  ,
            'list_id' => 'required'
            // list wajib diisi //
        ]);

        Task::create([
            'name' => $request->name,
            'description' => $request->description, 
            'priority' => $request->priority,
            'list_id' => $request->list_id
            // membuat tugas baru
        ]);


        return redirect()->back();
        // setelah menambhakan data task akan diarahkan kembali ke halaman home //
    }

    public function complete($id)
    // digunakan untuk membuat status tugas selesai //
     {
        Task::findOrFail($id)->update
        // digunakan untuk memastikan tugas selsai //
        ([
            'is_completed' => true
        ]);

        return redirect()->back();
    }

    public function destroy($id)
    // digunakan untuk menghapus tugas berdasarkan id //
     {
        Task::findOrFail($id)->delete();

        return redirect()->route('home');
    }
    public function show($id) {
        $task = Task::findOrfail($id);

        $data = [
            'title' => 'Task',
            'lists' => TaskList::all(),
            'task' => Task::findOrFail($id),
        ];

        return view('pages.details', $data);    
    }

    public function changeList(Request $request, Task $task)
    {
        $request->validate([
            'list_id' => 'required|exists:task_lists,id',
        ]);

        Task::findOrFail($task->id)->update([
            'list_id' => $request->list_id
        ]);

        return redirect()->back()->with('success', 'List berhasil diperbarui!');
    }
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'list_id' => 'required',
            'name' => 'required|max:100',
            'description' => 'max:255',
            'priority' => 'required|in:low,medium,high'
        ]);

        Task::findOrFail($task->id)->update([
            'list_id' => $request->list_id,
            'name' => $request->name,
            'description' => $request->description,
            'priority' => $request->priority
        ]);

        return redirect()->back()->with('success', 'Task berhasil diperbarui!');
    }

}