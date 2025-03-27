<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('homePage');
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