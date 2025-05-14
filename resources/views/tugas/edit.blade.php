@include("layout.sidebarT")
<div class="main">
    <form id="formUpdateTugas">
        @csrf
        <div class="form-wrapper-isian">
            <div class="form-isian">
                <label for="status_tugas">Status</label>
                <select name="status_tugas" id="status_tugas" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="0" {{ $tugas->status_tugas == 0 ? 'selected' : '' }}>Belum Selesai</option>
                    <option value="1" {{ $tugas->status_tugas == 1 ? 'selected' : '' }}>Selesai</option>
                </select>

                <label for="judul_tugas">Nama tugas</label>
                <input type="text" name="judul_tugas" id="judul_tugas" value="{{ $tugas->judul_tugas }}">

                <label for="waktu_mulai">Waktu mulai:</label>
                <input type="datetime-local" name="waktu_mulai" id="waktu_mulai" value="{{ \Carbon\Carbon::parse($tugas->waktu_mulai)->format('Y-m-d\TH:i') }}">

                <label for="waktu_selesai">Waktu Selesai:</label>
                <input type="datetime-local" name="waktu_selesai" id="waktu_selesai" value="{{ \Carbon\Carbon::parse($tugas->waktu_selesai)->format('Y-m-d\TH:i') }}">

                <label for="id_kategori">Kategori</label>
                <select name="id_kategori" id="id_kategori">
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id }}" {{ $tugas->id_kategori == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>

                <label for="catatan">Catatan</label>
                <input type="text" name="catatan" id="catatan" value="{{ $tugas->catatan }}">

                <div class="button-sub-isian">
                    <button type="submit" class="submit">Submit</button>
                </div>
            </div>
        </div>
    </form>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();

        document.getElementById("formUpdateTugas").addEventListener("submit", async function(e) {
            e.preventDefault();

            const data = {
                status_tugas: document.getElementById("status_tugas").value,
                judul_tugas: document.getElementById("judul_tugas").value,
                waktu_mulai: document.getElementById("waktu_mulai").value,
                waktu_selesai: document.getElementById("waktu_selesai").value,
                id_kategori: document.getElementById("id_kategori").value,
                catatan: document.getElementById("catatan").value,
            };

            try {
                const response = await fetch("{{ url('/api/tugas/' . $tugas->id) }}", {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(data)
                });

                const res = await response.json();
                if (response.ok) {
                    alert("Tugas berhasil diperbarui!");
                    window.location.href = "{{ url('/tugas-view') }}";
                } else {
                    alert("Gagal mengupdate: " + (res.message || 'Periksa input!'));
                }
            } catch (error) {
                alert("Terjadi kesalahan: " + error.message);
            }
        });
    </script>
</div>