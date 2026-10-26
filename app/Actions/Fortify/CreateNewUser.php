<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],

            'password' => $this->passwordRules(),

            'valid_id' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ])->validate();

        $idPath = $input['valid_id']->store('valid-ids', 'local');

        try {
            return User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => $input['password'],
                'role' => 'adopter',
                'valid_id_path' => $idPath,
                'approval_status' => 'Pending',
            ]);
        } catch (\Throwable $exception) {
            \Illuminate\Support\Facades\Storage::disk('local')
                ->delete($idPath);

            throw $exception;
        }
    }
}