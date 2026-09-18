<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This is the homepage route.
| When someone visits our website, Laravel will show home.blade.php.
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');