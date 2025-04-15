@include("layout.sidebarT")
<div class="main">
    <form action="{{ route('tugas.update', $tugas->id) }}" method="POST">
        @csrf
        @method("PUT")
        <div class="form-wrapper-isian">
            <div class="form-isian">
                <label for="status_tugas">Status</label>
                <select name="status_tugas" id="status_tugas" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="0" {{ $tugas->status_tugas == 0 ? 'selected' : '' }}>Belum Selesai</option>
                    <option value="1" {{ $tugas->status_tugas == 1 ? 'selected' : '' }}>Selesai</option>
                </select>

                <label for="">Nama tugas</label>
                <input type="text" name="judul_tugas" id="" value="{{ $tugas->judul_tugas }}">
                <label for="">Waktu mulai:</label>
                <input type="datetime-local" name="waktu_mulai" id="waktu_mulai" value="{{ $tugas->waktu_mulai }}">
                <label for="">Waktu Selesai:</label>
                <input type="datetime-local" name="waktu_selesai" id="waktu_selesai"
                    value="{{ $tugas->waktu_selesai }}">
                <label for="">kategori</label>
                <select name="id_kategori" id="">
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id }}" {{ $tugas->id_kategori == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kategori }}
                        </option>


                    @endforeach
                </select>
                <label for="">Catatan</label>
                <input type="text" name="catatan" id="" value="{{ $tugas->catatan }}">
                <div class="button-sub-isian">
                    <button type="submit" class="submit">Submit</button>
                </div>
            </div>
        </div>
    </form>