<?php

use App\Http\Controllers\CreditController;
use App\Http\Controllers\Feature1Controller;
use App\Http\Controllers\Feature2Controller;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');




Route::middleware('auth')->group(function () {

    // Features 1 & 2 route
    Route::get('/feature1', [Feature1Controller::class, 'index'])->name('feature1.index');
    Route::post('/feature1.calculate', [Feature1Controller::class, 'calculate'])->name('feature1.calculate');
    
    Route::get('/feature2', [Feature2Controller::class, 'index'])->name('feature2.index');
    Route::post('/feature2.calculate', [Feature2Controller::class, 'calculate'])->name('feature2.calculate');

    // All Credits route
    Route::get('/buy-credits', [CreditController::class, 'index'])->name('credit.index');
    Route::get('/buy-credits/success', [CreditController::class, 'success'])->name('credit.success');
    Route::get('/buy-credits/cancel', [CreditController::class, 'cancel'])->name('credit.cancel');
    Route::post('/buy-credits/{package}', [CreditController::class, 'buyCredits'])->name('credit.buy');




    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
