<?php

use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| HOME PAGE
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');


/*
|--------------------------------------------------------------------------
| PET ROUTES
|--------------------------------------------------------------------------
|
| /pets       = show all available pets
| /pets/{pet} = show one pet
|
*/

Route::get('/pets', [PetController::class, 'index'])
    ->name('pets.index');


Route::get('/pets/{pet}', [PetController::class, 'show'])
    ->name('pets.show');