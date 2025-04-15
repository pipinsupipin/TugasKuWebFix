<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TugasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landingPage');
});

Route::get('/loginpage', function () {
    return view('loginPage');
});

Route::get('/registerpage', function () {
    return view('registerPage');
});

Route::get('/homepage', function () {
    return view('homePage');
});
Route::get('/calendarpage', function () {
    return view('calendarPage');
});
Route::get('/settingspage', function () {
    return view('settings');
});
Route::get('/aboutuspage', function () {
    return view('aboutUsPage');
});
Route::get('/about', function () {
    return view('aboutPage');
});
Route::get('/feedback', function () {
    return view('feedbackPage');
});

Route::get('/admindashboard', function () {
    return view('adminDashboard');
});

Route::resource('kategori', KategoriController::class);
Route::resource('tugas', TugasController::class)->parameters([
    'tugas' => 'tugas'
]);

use Illuminate\Http\Request;

Route::post('/login-check', function (Request $request) {
    $email = $request->email;
    $password = $request->password;

    // Simulasi login hardcoded
    if ($email === 'admin@example.com' && $password === 'admin123') {
        // Simulasi akun admin
        return redirect('/admindashboard');
    } else {
        return redirect('/homepage');
    }
});

Route::post('/register-check', function (Request $request) {
    $nama = $request->nama;
    $email = $request->email;
    $password = $request->password;

    // Simulasi validasi
    if ($email === 'admin@example.com') {
        // Simulasi kalau email admin
        return redirect('/admindashboard');
    } else {
        // Simulasi user biasa
        return redirect('/homepage');
    }
});
