@extends('layouts.app')

@section('title', 'Daftar Tugas | TugasKu')
 <link rel="stylesheet" href="css/tugasPage.css" />

@section('content')
<div class="container">
    <div class="header">
        <h1>Daftar Tugas</h1>
        <div class="filter-container">
            <div class="filter-options">
                <button class="filter-btn active" data-filter="all">Semua</button>
                <button class="filter-btn" data-filter="completed">Sudah Selesai</button>
                <button class="filter-btn" data-filter="incomplete">Belum Selesai</button>
            </div>
            <button class="add-task-btn" id="addTaskBtn">
                <i class="fas fa-plus"></i> Tambah Tugas
            </button>
        </div>
    </div>

    <div class="tasks-container">
        <div class="tasks-header">
            <div class="task-check">Status</div>
            <div class="task-title">Judul</div>
            <div class="task-desc">Deskripsi</div>
            <div class="task-date">Waktu Mulai</div>
            <div class="task-date">Waktu Selesai</div>
            <div class="task-actions">Aksi</div>
        </div>
        
        <div class="tasks-list" id="tasksList">
            <!-- Tasks will be populated here by JavaScript -->
            <div class="no-tasks" id="noTasks">
                <p>Belum ada tugas yang tersedia.</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add/Edit Task -->
<div class="modal" id="taskModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle">Tambah Tugas Baru</h2>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
            <form id="taskForm">
                <input type="hidden" id="taskId">
                
                <div class="form-group">
                    <label for="kategoriSelect">Kategori</label>
                    <select id="kategoriSelect" name="kategori_id" required>
                        <!-- Kategori akan diisi dengan JavaScript -->
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="taskTitle">Judul Tugas</label>
                    <input type="text" id="taskTitle" name="judul" required>
                </div>
                
                <div class="form-group">
                    <label for="taskDescription">Deskripsi</label>
                    <textarea id="taskDescription" name="deskripsi" rows="3"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="startDate">Waktu Mulai</label>
                    <input type="datetime-local" id="startDate" name="waktu_mulai">
                </div>
                
                <div class="form-group">
                    <label for="endDate">Waktu Selesai</label>
                    <input type="datetime-local" id="endDate" name="waktu_selesai">
                </div>
                
                <div class="form-actions">
                    <button type="button" class="cancel-btn">Batal</button>
                    <button type="submit" class="submit-btn">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal" id="deleteModal">
    <div class="modal-content delete-modal">
        <div class="modal-header">
            <h2>Hapus Tugas</h2>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus tugas ini?</p>
            <div class="form-actions">
                <button type="button" class="cancel-btn">Batal</button>
                <button type="button" class="delete-btn" id="confirmDelete">Hapus</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/tugasPage.js') }}"></script>
@endpush