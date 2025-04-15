@include("layout.sidebarT")
<div class="main">
    <div class="create">
        <a href="{{ route('tugas.create') }}" class="tambah">
            <h1>Tambah tugas</h1>
        </a>
    </div>

    <table class="task-table">
        <thead>
            <tr>
                <th>Status</th>
                <th>Nama Tugas</th>
                <th>Waktu Mulai</th>
                <th>Waktu Selesai</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($allTugas as $key => $r)
                <tr>
                    <td>{{ $r->status_tugas == 1 ? 'Selesai' : 'Belum Selesai' }}</td>

                    <td>{{ $r->judul_tugas }}</td>
                    <td>{{ $r->waktu_mulai }}</td>
                    <td>{{ $r->waktu_selesai }}</td>
                    <td>{{ $r->kategori->nama_kategori }}</td>
                    <td>{{ $r->catatan }}</td>
                    <td>
                        <form action="{{ route('tugas.destroy', $r->id) }}" method="POST">
                            <div class="aksi">
                                <!-- <div class="detail"><a href="{{ route('tugas.show', $r->id) }}" class="tombol">
                                            <h3>Detail</h3>
                                        </a></div> -->
                                <div class="edit"><a href="{{ route('tugas.edit', $r->id) }}" class="tombol">
                                        <h3>Edit</h3>
                                    </a></div>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="but"
                                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    <h3>Hapus</h3>
                                </button>
                            </div>
                        </form>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>

</div>


</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
</body>

</html>