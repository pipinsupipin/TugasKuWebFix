@extends('layouts.app')

@section('title', 'Home - TugasKu')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/homePage.css') }}">
@endpush

@section('content')
    <!-- Left Column -->
    <section class="content-left">
        <div class="greeting">
            <h1></h1>
            <p>Semangat kerjain tugasnya ya!</p>
        </div>

        <div class="first-row">
            <!-- Streak Card -->
            <div class="card streak-card">
                <div class="streak-content">
                    <img id="streak-icon" src="{{ asset('img/flame-icon.png') }}" alt="Streak Icon" class="streak-icon">
                    <h2 id="streak-text">Kamu memiliki <span id="streak-count">0</span> Streaks!</h2>
                </div>
            </div>

            <!-- Add Task Card -->
            <div class="card task-card">
                <div class="task-form">
                    <h2>Catat Tugas Disini!</h2>
                    <input type="text" class="task-input" placeholder="Judul tugas...">
                    <div class="task-time">
                        <h3>Waktu</h3>
                        <div class="time-inputs">
                            <input type="datetime-local" id="start-time" class="time-input">
                            <span class="time-separator">hingga</span>
                            <input type="datetime-local" id="end-time" class="time-input">
                        </div>
                    </div>
                    <div class="task-category">
                        <div class="category-addtask">
                            <div class="category-buttons" id="category-buttons-container">
                                <!-- Tombol kategori akan diinject di sini -->
                            </div>
                            <select class="category-select" id="category-select">
                                <!-- Kategori yang banyak akan diinject di sini -->
                            </select>
                        </div>
                    </div>
                    <div class="notes-button">
                        <input type="text" class="task-desc-input" placeholder="Deskripsi tugas...">
                        <button class="add-category-btn" id="add-category-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14" />
                                <path d="M12 5v14" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="second-row">
            <div class="section-header">
                <h2>Kategori Tugas</h2>
            </div>

            <div class="category-cards" id="category-cards-container"></div>

            <div class="timer-panel">
                <div class="timer-controls">
                    <!-- Tombol Play/Pause -->
                    <button class="timer-btn" id="toggle-btn">
                        <!-- Awalnya tampil ikon Play -->
                        <svg id="icon-toggle" xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="5 3 19 12 5 21 5 3" />
                        </svg>
                    </button>
                
                    <!-- Tombol Restart -->
                    <button class="timer-btn" id="restart-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="1 4 1 10 7 10" />
                        <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10" />
                    </svg>
                    </button>
                </div>

                <div class="timer-display">
                    <span id="timer-display">25:00</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Right Column -->
    <section class="content-right">
        <div class="todo-header">
            <h2>Sisa Tugas</h2>
        </div>
        <div class="todo-list" id="todo-list"></div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/components/categoryCard.js') }}"></script>
    <script src="{{ asset('js/homePage.js') }}"></script>
@endpush

