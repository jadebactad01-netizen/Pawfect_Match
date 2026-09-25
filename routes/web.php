<?php

use App\Http\Controllers\AdminPetController;
use App\Http\Controllers\AdopterProfileController;
use App\Http\Controllers\AdminAdoptionApplicationController;
use App\Http\Controllers\AdoptionApplicationController;
use App\Http\Controllers\CompatibilityAssessmentController;
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
| ADOPTER PROFILE ROUTES
|--------------------------------------------------------------------------
|
| Logged-in users can view and update their own adopter profile.
|
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [AdopterProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile', [AdopterProfileController::class, 'update'])
        ->name('profile.update');

    Route::get(
        '/my-applications',
        [AdoptionApplicationController::class, 'index']
    )->name('adoption-applications.index');

    Route::get(
        '/pets/{pet}/apply',
        [AdoptionApplicationController::class, 'create']
    )->name('adoption-applications.create');

    Route::post(
        '/pets/{pet}/apply',
        [AdoptionApplicationController::class, 'store']
    )->name('adoption-applications.store');

    Route::get(
        '/applications/{application}/compatibility-assessment',
        [CompatibilityAssessmentController::class, 'create']
    )->name('compatibility-assessments.create');

    Route::post(
        '/applications/{application}/compatibility-assessment',
        [CompatibilityAssessmentController::class, 'store']
    )->name('compatibility-assessments.store');

    Route::post(
        '/applications/{application}/compatibility-explanation/retry',
        [CompatibilityAssessmentController::class, 'retryExplanation']
    )->name('compatibility-assessments.retry-explanation');

});

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

    Route::get(
        '/admin/applications',
        [AdminAdoptionApplicationController::class, 'index']
    )->name('admin.applications.index');

    Route::get(
        '/admin/applications/{application}',
        [AdminAdoptionApplicationController::class, 'show']
    )->name('admin.applications.show');

    Route::put(
        '/admin/applications/{application}',
        [AdminAdoptionApplicationController::class, 'update']
    )->name('admin.applications.update');

});