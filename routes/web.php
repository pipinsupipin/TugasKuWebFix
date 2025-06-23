<?php

use App\Http\Controllers\Api\KategoriTugasController;
use App\Http\Controllers\Api\TugasController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.landingPage');
});
Route::get('/loginpage', function () {
    return view('pages.loginPage');
});
Route::get('/homepage', function () {
    return view('pages.homePage');
});
Route::get('/calendarpage', function () {
    return view('pages.calendarPage');
});
Route::get('/kategoripage', function () {
    return view('pages.kategoriPage');
});
Route::get('/tugaspage', function () {
    return view('pages.tugasPage');
});
Route::get('/settingspage', function () {
    return view('pages.settings');
});
Route::get('/aboutuspage', function () {
    return view('pages.aboutUsPage');
});
Route::get('/about', function () {
    return view('pages.aboutPage');
});
Route::get('/feedbackPage', function () {
    return view('pages.feedbackPage');
});
Route::get('/admindashboard', function () {
    return view('pages.adminDashboard');
});

Route::get('/ubah-profil', [UserController::class, 'edit'])->name('profile.edit');
Route::get('/ubah-password', [UserController::class, 'edit'])->name('password.edit');
Route::get('/keamanan-privasi', [UserController::class, 'edit'])->name('privacy.edit');

// Route::resource('kategori', KategoriTugasController::class);
// Route::resource('tugas', TugasController::class)->parameters([
//     'tugas' => 'tugas'
// ]);

use Illuminate\Http\Request;

Route::get('/tugas-view', function () {
    $client = new \GuzzleHttp\Client();
    $response = $client->request('GET', 'http://localhost:8000/api/tugas');

    $data = json_decode($response->getBody(), true);

    $tugas = $data['data'];

    return view('tugas.index', compact('tugas'));
});



use App\Http\Controllers\FeedbackController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/feedbackPage', [FeedbackController::class, 'index'])->name('feedback.index');
Route::post('/feedbackPage', [FeedbackController::class, 'store'])->name('feedback.store');

// Route tambahan
Route::get('/feedback/statistics', [FeedbackController::class, 'statistics'])->name('feedback.statistics');
Route::get('/feedback/{feedback}/download', [FeedbackController::class, 'downloadFile'])->name('feedback.download');
