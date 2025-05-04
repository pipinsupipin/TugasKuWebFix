<?php

use App\Http\Controllers\Api\KategoriTugasController;
use App\Http\Controllers\Api\TugasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landingPage.landingPage');
});

Route::get('/loginpage', function () {
    return view('auth.loginPage');
});

Route::get('/registerpage', function () {
    return view('auth.registerPage');
});

Route::get('/homepage', function () {
    return view('mainPage.homePage');
});
Route::get('/calendarpage', function () {
    return view('mainPage.calendarPage');
});
Route::get('/settingspage', function () {
    return view('mainPage.settings');
});
Route::get('/aboutuspage', function () {
    return view('mainPage.aboutUsPage');
});
Route::get('/about', function () {
    return view('landingPage.aboutPage');
});
Route::get('/feedback', function () {
    return view('landingPage.feedbackPage');
});

Route::get('/admindashboard', function () {
    return view('mainPage.adminDashboard');
});

Route::resource('kategori', KategoriTugasController::class);
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
