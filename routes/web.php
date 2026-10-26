<?php

use App\Http\Controllers\AdminPetController;
use App\Http\Controllers\AdminAdoptionApplicationController;
use App\Http\Controllers\AdoptionApplicationController;
use App\Http\Controllers\CompatibilityAssessmentController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminAdopterController;
use App\Http\Controllers\AdminAdoptionRecordController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdopterController;
use App\Http\Controllers\AdminAccountApprovalController;
use App\Models\Pet;
use App\Models\User;
use App\Models\AdoptionApplication;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', function () {

    if (Auth::check()) {

        if (Auth::user()->role === 'super_admin') {
            return redirect()->route('super-admin.dashboard');
        }

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if (
            Auth::user()->role === 'adopter'
            && request()->routeIs('home')
            && request()->query('public') !== '1'
        ) {
            return redirect()->route('adopter.dashboard');
        }
    }

    $featuredPets = Pet::where('status', 'Available')
        ->latest()
        ->take(3)
        ->get();

    return view('home', compact('featuredPets'));

})->name('home');


/*
|--------------------------------------------------------------------------
| PUBLIC PET ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/pets', [PetController::class, 'index'])
    ->name('pets.index');

Route::get('/pets/{pet}', [PetController::class, 'show'])
    ->name('pets.show');


/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/account-pending', function () {

        $user = Auth::user();

        if (! $user || $user->role !== 'adopter') {
            abort(403);
        }

        if ($user->approval_status === 'Approved') {
            return redirect()->route('adopter.dashboard');
        }

        return view('auth.account-pending');

    })->middleware('auth')->name('account.pending');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::post(
        '/profile/request-assessment-edit',
        [ProfileController::class, 'requestEdit']
    )->name('profile.request-edit');

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

    Route::post(
        '/applications/{application}/recommendation-explanations/retry',
        [
            CompatibilityAssessmentController::class,
            'retryRecommendationExplanations'
        ]
    )->name('compatibility-assessments.retry-recommendations');

    Route::get(
        '/adopter/dashboard',
        [AdopterController::class, 'dashboard']
    )->name('adopter.dashboard');
});


/*
|--------------------------------------------------------------------------
| ADMIN AND SUPER ADMIN ROUTES
|--------------------------------------------------------------------------
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

    Route::get(
        '/admin/adopters',
        [AdminAdopterController::class, 'index']
    )->name('admin.adopters.index');

    Route::get(
        '/admin/adopters/{adopter}',
        [AdminAdopterController::class, 'show']
    )->name('admin.adopters.show');

    Route::post(
        '/admin/adopters/{adopter}/assessment-edit-request',
        [AdminAdopterController::class, 'reviewEditRequest']
    )->name('admin.adopters.review-edit-request');

    /*
    |--------------------------------------------------------------------------
    | ADOPTER ACCOUNT APPROVALS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/adopter-approvals',
        [AdminAccountApprovalController::class, 'index']
    )->name('admin.account-approvals.index');

    Route::get(
        '/admin/adopter-approvals/{user}/id',
        [AdminAccountApprovalController::class, 'showId']
    )->name('admin.account-approvals.id');

    Route::post(
        '/admin/adopter-approvals/{user}',
        [AdminAccountApprovalController::class, 'review']
    )->name('admin.account-approvals.review');

    /*
    |--------------------------------------------------------------------------
    | ADOPTION RECORDS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/adoption-records',
        [AdminAdoptionRecordController::class, 'index']
    )->name('admin.adoption-records.index');

    Route::get(
        '/admin/adoption-records/{application}',
        [AdminAdoptionRecordController::class, 'show']
    )->name('admin.adoption-records.show');

    Route::get(
        '/admin/dashboard',
        [AdminController::class, 'dashboard']
    )->name('admin.dashboard');

    /*
    |--------------------------------------------------------------------------
    | PRINTABLE REPORTS
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/reports', function (Request $request) {

        $validated = $request->validate([
            'type' => [
                'nullable',
                'in:pets,adopters,applications,records',
            ],
            'status' => [
                'nullable',
                'in:Available,Unavailable,Adopted,Pending,Approved,Rejected',
            ],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        $type = $validated['type'] ?? 'pets';
        $status = $validated['status'] ?? '';
        $dateFrom = $validated['date_from'] ?? '';
        $dateTo = $validated['date_to'] ?? '';

        $query = match ($type) {
            'pets' => Pet::query(),

            'adopters' => User::where('role', 'adopter')
                ->withCount('adoptionApplications'),

            'applications' => AdoptionApplication::with([
                'user',
                'pet',
                'compatibilityAssessment',
            ]),

            'records' => AdoptionApplication::with([
                'user',
                'pet',
                'compatibilityAssessment',
            ])->whereIn('status', ['Approved', 'Rejected']),
        };

        if (
            $status
            && $type === 'pets'
            && in_array($status, ['Available', 'Unavailable', 'Adopted'])
        ) {
            $query->where('status', $status);
        }

        if (
            $status
            && in_array($type, ['applications', 'records'])
            && in_array($status, ['Pending', 'Approved', 'Rejected'])
        ) {
            $query->where('status', $status);
        }

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $rows = $query->latest()->get();

        return view('admin.reports.index', compact(
            'rows',
            'type',
            'status',
            'dateFrom',
            'dateTo'
        ));

    })->name('admin.reports.index');
});


/*
|--------------------------------------------------------------------------
| SUPER ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('super_admin')->group(function () {

    Route::get(
        '/super-admin/administrators',
        [SuperAdminController::class, 'index']
    )->name('super-admin.administrators.index');

    Route::get(
        '/super-admin/administrators/create',
        [SuperAdminController::class, 'create']
    )->name('super-admin.administrators.create');

    Route::post(
        '/super-admin/administrators',
        [SuperAdminController::class, 'store']
    )->name('super-admin.administrators.store');

    Route::get(
        '/super-admin/administrators/{administrator}/edit',
        [SuperAdminController::class, 'edit']
    )->name('super-admin.administrators.edit');

    Route::put(
        '/super-admin/administrators/{administrator}',
        [SuperAdminController::class, 'update']
    )->name('super-admin.administrators.update');

    Route::delete(
        '/super-admin/administrators/{administrator}',
        [SuperAdminController::class, 'destroy']
    )->name('super-admin.administrators.destroy');

    Route::get(
        '/super-admin/dashboard',
        [SuperAdminController::class, 'dashboard']
    )->name('super-admin.dashboard');
});