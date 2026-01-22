<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\KontrakanController;
use App\Http\Controllers\LaporanController;

// ADMIN CONTROLLER
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminLaporanController;

use App\Models\Kontrakan;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('homepage');
})->name('home');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    | DASHBOARD (MAP)
    */
    Route::get('/dashboard', function () {
        $kontrakans = Kontrakan::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->latest()
            ->get();

        return view('dashboard', compact('kontrakans'));
    })->name('dashboard');

    /*
    | PROFILE
    */
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    /*
    | KONTRAKAN - CRUD USER
    */
    Route::prefix('kontrakan')->group(function () {

        Route::get('/tambah', [KontrakanController::class, 'create'])->name('kontrakan.create');
        Route::post('/simpan', [KontrakanController::class, 'store'])->name('kontrakan.store');

        Route::get('/', [KontrakanController::class, 'index'])->name('kontrakan.index');
        Route::get('/{id}', [KontrakanController::class, 'show'])->name('kontrakan.show');

        Route::get('/{id}/edit', [KontrakanController::class, 'edit'])->name('kontrakan.edit');
        Route::put('/{id}', [KontrakanController::class, 'update'])->name('kontrakan.update');

        /*
        | LAPORAN KONTRAKAN
        */
        Route::get('/{id}/lapor', [LaporanController::class, 'create'])->name('laporan.create');
    });

    Route::post('/laporan/store', [LaporanController::class, 'store'])->name('laporan.store');

    /*
    | LOCATION (OPTIONAL)
    */
    Route::post('/locations/store', [LocationController::class, 'store'])->name('locations.store');
    Route::get('/locations/all', [LocationController::class, 'all'])->name('locations.all');

    /*
    | LOGOUT
    */
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::get('/laporan', [AdminLaporanController::class, 'index'])
            ->name('laporan');

        Route::delete('/kontrakan/{id}', [AdminController::class, 'hapusKontrakan'])
            ->name('kontrakan.hapus');

        Route::post('/user/{id}/block', [AdminController::class, 'blockUser'])
            ->name('user.block');
    });
