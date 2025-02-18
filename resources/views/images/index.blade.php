{{-- 
<h1>Daftar Gambar</h1>

@if ($images->isEmpty()) 
    <p>Tidak ada gambar yang diupload.</p>
@else 
    <ul>
        @foreach ($images as $image) 
            <li>
                <img src="{{ asset('storage/' . $image->path) }}" alt="Image" style="width: 200px; height: auto;">
                <form action="{{ route('image.delete', $image->id) }}" method="POST" style="display:inline;">
                    @csrf 
                    @method('DELETE') 
                    <button type="submit">Hapus</button> 
                </form>
            </li>
        @endforeach 
    </ul>
    s
@endif 
--}}
{{-- 
<h1>Daftar Gambar</h1>

@if ($images->isEmpty()) 
    <p>Tidak ada gambar yang diupload.</p>
@else 
    <ul>
        @foreach ($images as $image) 
            <li>
                <img src="{{ asset('storage/' . $image->path) }}" alt="Image" style="width: 200px; height: auto;">
                <form action="{{ route('image.delete', $image->id) }}" method="POST" style="display:inline;">
                    @csrf 
                    @method('DELETE') 
                    <button type="submit">Hapus</button> 
                </form>
            </li>
        @endforeach 
    </ul>
    s
@endif 
--}}
