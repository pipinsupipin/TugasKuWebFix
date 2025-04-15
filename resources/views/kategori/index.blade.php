@include("layout.sidebarK")
<div class="main">
    <div class="create">
        <button onclick="openModal()" class="tambah">
            <h1>Tambah Kategori</h1>
        </button>
    </div>
    <!-- Modal Tambah Kategori -->
    <div id="modalKategori" class="modal hidden">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>

            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="form-wrapper-isian">
                    <div class="form-isian">
                        <label for="nama_kategori">Nama Kategori</label>
                        <input type="text" name="nama_kategori" placeholder="Masukkan judul kategori" required>
                        <div class="button-sub-isian">
                            <button type="submit" class="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <!-- Modal Edit Kategori -->
    <div id="modalEditKategori" class="modal hidden">
        <div class="modal-content">
            <span class="close-btn" onclick="closeEditModal()">&times;</span>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="form-wrapper-isian">
                    <div class="form-isian">
                        <label for="edit_nama_kategori">Nama Kategori</label>

                        <input type="text" name="nama_kategori" id="edit_nama_kategori" required
                            placeholder="Masukkan judul kategori" required>

                        <div class="button-sub-isian">
                            <button type="submit" class="submit">Submit</button>
                        </div>
                    </div>
                </div>
        </div>
        </form>
    </div>
</div>


<div class="table-wrapper">
    <table class="task-table">
        <thead>
            <tr class="rounded-row">
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($allKategori as $key => $k)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $k->nama_kategori }}</td>

                    <td>
                        <form action="{{ route('kategori.destroy', $k->id) }}" method="POST">
                            <div class="aksi">
                                <button type="button" class="edit tombol"
                                    onclick="openEditModal('{{ $k->id }}', '{{ $k->nama_kategori }}')">
                                    <h3>Edit</h3>
                                </button>

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


</div>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
<script>
    function openModal() {
        document.getElementById("modalKategori").classList.remove("hidden");
    }

    function closeModal() {
        document.getElementById("modalKategori").classList.add("hidden");
    }
</script>
<script>
    function openEditModal(id, namaKategori) {
        const modal = document.getElementById("modalEditKategori");
        const form = document.getElementById("editForm");
        const input = document.getElementById("edit_nama_kategori");

        form.action = `/kategori/${id}`; // Ubah sesuai rute edit kategori kamu
        input.value = namaKategori;
        modal.classList.remove("hidden");
    }

    function closeEditModal() {
        document.getElementById("modalEditKategori").classList.add("hidden");
    }
</script>

</body>

</html>