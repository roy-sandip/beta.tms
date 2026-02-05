<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



// Admin panel
Route::prefix('admin')
    ->middleware(['auth', 'can:access-admin-panel'])
    ->name('admin.')
    ->group(base_path('routes/admin.php'));