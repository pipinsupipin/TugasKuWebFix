@include("layout.sidebarT")
<div class="main">
    <form action="{{ route("tugas.store") }}" method="post">
        @csrf
        <div class="form-wrapper-isian">
            <div class="form-isian">
                <label for="status_tugas">Status</label>
                <select name="status_tugas" id="status_tugas" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="0">Belum Selesai</option>
                    <option value="1">Selesai</option>
                </select>
                <label for="">Nama tugas</label>
                <input type="text" name="judul_tugas" id="" placeholder="Masukkan nama tugas">
                <label for="">Waktu Mulai:</label>
                <input type="datetime-local" name="waktu_mulai" id="waktu_mulai">
                <label for="">Waktu Selesai:</label>
                <input type="datetime-local" name="waktu_selesai" id="waktu_selesai">
                <label for="">kategori</label>
                <select name="id_kategori" id="">
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id }}">
                            {{ $k->nama_kategori }}
                        </option>

                    @endforeach
                </select>
                <label for="">Catatan</label>
                <input type="text" name="catatan" id="" placeholder="Masukkan catatan">
                <div class="button-sub-isian">
                    <button type="submit" class="submit">Submit</button>
                </div>
            </div>
        </div>
    </form>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>