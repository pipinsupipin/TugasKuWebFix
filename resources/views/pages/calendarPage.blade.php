@extends('layouts.app')

@section('title', 'Kalender Tugas - TugasKu')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
@endpush

@section('content')
    <div class="calendar-wrapper">
        <div class="calendar-container">
            <div class="calendar-header">
                <div class="calendar-title" id="calendar-title"></div>
                <div class="calendar-nav">
                    <button id="prev-month">&lt;</button>
                    <button id="today">Bulan ini</button>
                    <button id="next-month">&gt;</button>
                </div>
            </div>

            <div class="calendar-grid" id="calendar-grid">
                <div class="calendar-day-header">Min</div>
                <div class="calendar-day-header">Sen</div>
                <div class="calendar-day-header">Sel</div>
                <div class="calendar-day-header">Rab</div>
                <div class="calendar-day-header">Kam</div>
                <div class="calendar-day-header">Jum</div>
                <div class="calendar-day-header">Sab</div>
            </div>
        </div>

        <div class="tasks-container">
            <div class="tasks-header">
                <div class="tasks-title">Tugas pada</div>
                <div id="selected-date" class="selected-date">-</div>
            </div>
            <div id="tasks-list"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module" src="{{ asset('js/calendar.js') }}"></script>
@endpush
