<?php

use App\Http\Controllers\AdminPetController;
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

/*
|--------------------------------------------------------------------------
| ADMIN PET ROUTES
|--------------------------------------------------------------------------
|
| These routes are for shelter pet management.
| Only Admin/Super Administrators can access
*/
Route::middleware('admin')->group(function () {

    Route::get('/admin/pets', [AdminPetController::class, 'manage'])
        ->name('admin.pets.manage');

    Route::get('/admin/pets/add', [AdminPetController::class, 'add'])
        ->name('admin.pets.add');

    Route::post('/admin/pets', [AdminPetController::class, 'store'])
        ->name('admin.pets.store');

    Route::get('/admin/pets/{pet}/edit', [AdminPetController::class, 'edit'])
        ->name('admin.pets.edit');

    Route::put('/admin/pets/{pet}', [AdminPetController::class, 'update'])
        ->name('admin.pets.update');

    Route::delete('/admin/pets/{pet}', [AdminPetController::class, 'destroy'])
        ->name('admin.pets.destroy');

});