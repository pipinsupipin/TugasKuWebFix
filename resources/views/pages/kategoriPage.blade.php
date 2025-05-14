@extends('layouts.app')

@section('title', 'Kategori Tugas - TugasKu')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/kategoriPage.css') }}">
@endpush

@section('content')
<div id="category-page">
    <!-- Row Atas: Slide Horizontal Kategori -->
    <div class="first-row">
        <div class="section-header">
            <h2>Kategori Tugas</h2>
        </div>
        <div class="category-cards" id="category-cards-container">
            <!-- Kategori akan di-inject melalui JavaScript -->
        </div>
    </div>

    <!-- Row Tengah: Tambah Kategori & Edit Kategori -->
    <div class="add-category">
        <button class="btn-add-category">Tambah Kategori Baru +</button>
        <button class="btn-edit-category hidden">Edit Kategori</button>
    </div>

    <!-- Modal Popup untuk Input Kategori -->
    <div class="modal-overlay hidden">
        <div class="modal-content">
            <h2>Tambah Kategori Baru</h2>
            <input type="text" id="input-category-name" placeholder="Masukkan nama kategori" />
            <div class="modal-actions">
                <button id="btn-save-category">Simpan</button>
                <button id="btn-cancel-category">Batal</button>
            </div>
        </div>
    </div>

    <!-- Modal Popup untuk Edit Kategori -->
    <div class="modal-overlay hidden" id="editCategoryModal">
        <div class="modal-content">
            <h2>Edit Kategori</h2>
            <input type="text" id="edit-category-name" placeholder="Masukkan nama kategori" />
            <div class="modal-actions">
                <button id="btn-save-edit-category">Simpan</button>
                <button id="btn-cancel-edit-category">Batal</button>
            </div>
        </div>
    </div>

    <!-- Row Bawah: Daftar Tugas -->
    <div class="task-list" id="task-list-container">
        <p>Pilih Kategori untuk Menampilkan Tugas!</p>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('/js/components/categoryCard.js') }}"></script>
    <script src="{{ asset('js/kategoriPage.js') }}"></script>
@endpush