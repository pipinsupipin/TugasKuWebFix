<?php

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