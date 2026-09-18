<?php

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
| AVAILABLE PETS PAGE
|--------------------------------------------------------------------------
|
| For now, we are using sample data.
|
| Later, these pets will come from our MySQL database.
|
*/

Route::get('/pets', function () {

    $pets = [

        [
            'id' => 1,
            'name' => 'Buddy',
            'type' => 'Dog',
            'sex' => 'Male',
            'age' => '2 years old',
            'status' => 'Available',
            'description' => 'Friendly, playful, and loves spending time with people.',
            'emoji' => '🐶',
        ],

        [
            'id' => 2,
            'name' => 'Luna',
            'type' => 'Cat',
            'sex' => 'Female',
            'age' => '1 year old',
            'status' => 'Available',
            'description' => 'Calm, affectionate, and curious about her surroundings.',
            'emoji' => '🐱',
        ],

        [
            'id' => 3,
            'name' => 'Max',
            'type' => 'Dog',
            'sex' => 'Male',
            'age' => '3 years old',
            'status' => 'Available',
            'description' => 'Gentle, loyal, and enjoys daily walks and outdoor activities.',
            'emoji' => '🐕',
        ],

        [
            'id' => 4,
            'name' => 'Milo',
            'type' => 'Cat',
            'sex' => 'Male',
            'age' => '2 years old',
            'status' => 'Available',
            'description' => 'A quiet and friendly cat who enjoys relaxing indoors.',
            'emoji' => '🐈',
        ],

        [
            'id' => 5,
            'name' => 'Bella',
            'type' => 'Dog',
            'sex' => 'Female',
            'age' => '1 year old',
            'status' => 'Available',
            'description' => 'Energetic, sweet, and enjoys playing with people.',
            'emoji' => '🐶',
        ],

        [
            'id' => 6,
            'name' => 'Coco',
            'type' => 'Cat',
            'sex' => 'Female',
            'age' => '3 years old',
            'status' => 'Available',
            'description' => 'Independent but affectionate once she gets comfortable.',
            'emoji' => '🐱',
        ],

    ];


    /*
     * Send the $pets variable to:
     *
     * resources/views/pets/index.blade.php
     */
    return view('pets.index', compact('pets'));

})->name('pets.index');

/*
|--------------------------------------------------------------------------
| PET DETAILS PAGE
|--------------------------------------------------------------------------
|
| {id} is the ID of the pet that the user wants to view.
|
| Examples:
|
| /pets/1
| /pets/2
| /pets/3
|
*/

Route::get('/pets/{id}', function ($id) {

    /*
     * Temporary sample pet data.
     *
     * Later, this will come from our MySQL database.
     */
    $pets = [

        [
            'id' => 1,
            'name' => 'Buddy',
            'type' => 'Dog',
            'sex' => 'Male',
            'age' => '2 years old',
            'status' => 'Available',
            'description' => 'Friendly, playful, and loves spending time with people.',
            'emoji' => '🐶',
        ],

        [
            'id' => 2,
            'name' => 'Luna',
            'type' => 'Cat',
            'sex' => 'Female',
            'age' => '1 year old',
            'status' => 'Available',
            'description' => 'Calm, affectionate, and curious about her surroundings.',
            'emoji' => '🐱',
        ],

        [
            'id' => 3,
            'name' => 'Max',
            'type' => 'Dog',
            'sex' => 'Male',
            'age' => '3 years old',
            'status' => 'Available',
            'description' => 'Gentle, loyal, and enjoys daily walks and outdoor activities.',
            'emoji' => '🐕',
        ],

        [
            'id' => 4,
            'name' => 'Milo',
            'type' => 'Cat',
            'sex' => 'Male',
            'age' => '2 years old',
            'status' => 'Available',
            'description' => 'A quiet and friendly cat who enjoys relaxing indoors.',
            'emoji' => '🐈',
        ],

        [
            'id' => 5,
            'name' => 'Bella',
            'type' => 'Dog',
            'sex' => 'Female',
            'age' => '1 year old',
            'status' => 'Available',
            'description' => 'Energetic, sweet, and enjoys playing with people.',
            'emoji' => '🐶',
        ],

        [
            'id' => 6,
            'name' => 'Coco',
            'type' => 'Cat',
            'sex' => 'Female',
            'age' => '3 years old',
            'status' => 'Available',
            'description' => 'Independent but affectionate once she gets comfortable.',
            'emoji' => '🐱',
        ],

    ];


    /*
     * Find the pet whose ID matches the ID in the URL.
     */
    $pet = collect($pets)->firstWhere('id', (int) $id);


    /*
     * If no pet was found, show Laravel's 404 page.
     *
     * Example:
     * /pets/999
     */
    if (!$pet) {
        abort(404);
    }


    /*
     * Send the selected pet to show.blade.php
     */
    return view('pets.show', compact('pet'));

})->name('pets.show');