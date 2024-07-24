<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\zakatController;
use App\Http\Controllers\infaqController;
use App\Http\Controllers\pengeluaraninfaqController;
use App\Http\Controllers\reportInfaqController;
use App\Http\Controllers\perkakasController;
use App\Http\Controllers\UserController;

// Route untuk menampilkan view dengan data dari controller
Route::get('/', [ReportInfaqController::class, 'showHome']);


Route::get('/zakat', function () {
    return view('zakat.zakat', ['name' => 'Arif']);
});

Route::get('/zakatAjax', [zakatController::class, 'index'])->name('zakatAjax');
Route::post('/zakatAjax', [ZakatController::class, 'store'])->name('zakatAjax.store');
Route::get('/zakatAjax/{id}/edit', [ZakatController::class, 'edit'])->name('zakatAjax.edit');
Route::put('/zakatAjax/{id}', [ZakatController::class, 'update'])->name('zakatAjax.update');
Route::delete('/zakatAjax/{id}', [ZakatController::class, 'destroy'])->name('zakatAjax.delete');

Route::get('/pengeluaranzakat', function () {
    return view('zakat.pengeluaran', ['name' => 'Arif']);
});

Route::get('/infaq', function () {
    return view('infaq.infaq', ['name' => 'Arif']);
});
Route::get('infaqAjax', [InfaqController::class, 'index'])->name('infaqAjax.index');
Route::post('infaqAjax', [InfaqController::class, 'store'])->name('infaqAjax.store');
Route::get('infaqAjax/{id}/edit', [InfaqController::class, 'edit'])->name('infaqAjax.edit');
Route::put('infaqAjax/{id}', [InfaqController::class, 'update'])->name('infaqAjax.update');
Route::delete('infaqAjax/{id}', [InfaqController::class, 'destroy'])->name('infaqAjax.delete');


Route::get('/pengeluaraninfaq', function () {
    return view('infaq.pengeluaran', ['name' => 'Arif']);
});
Route::get('/pengeluaraninfaqAjax', [PengeluaranInfaqController::class, 'index'])->name('pengeluaranInfaqAjax.index');


Route::post('/pengeluaraninfaq/store', [PengeluaranInfaqController::class, 'store'])->name('pengeluaranInfaqAjax.store');
Route::get('/pengeluaran-infaq/{id}/edit', [PengeluaranInfaqController::class, 'edit'])->name('pengeluaranInfaqAjax.edit');
Route::put('/pengeluaraninfaq/{id}/update', [PengeluaranInfaqController::class, 'update'])->name('pengeluaranInfaqAjax.update');
Route::delete('/pengeluaraninfaq/{id}/delete', [PengeluaranInfaqController::class, 'destroy'])->name('pengeluaranInfaqAjax.delete');



Route::get('/reportinfaq', function () {
    return view('infaq.report', ['name' => 'Arif']);
});

Route::get('/report/data', [ReportInfaqController::class, 'getData'])->name('report.data');


Route::get('/perkakas', function () {
    return view('perkakas.perkakas', ['name' => 'Arif']);
});
Route::get('perkakasAjax', [PerkakasController::class, 'index'])->name('perkakas.index');
Route::post('perkakas', [PerkakasController::class, 'store'])->name('perkakas.store');
Route::get('perkakas/{id}/edit', [PerkakasController::class, 'edit'])->name('perkakas.edit');
Route::put('perkakas/{id}', [PerkakasController::class, 'update'])->name('perkakas.update');
Route::delete('perkakas/{id}', [PerkakasController::class, 'delete'])->name('perkakas.delete');


Route::get('/users', function () {
    return view('user.user', ['name' => 'Arif']);
});
Route::get('usersAjax', [UserController::class, 'index'])->name('userAjax.index');
// Route::get('users/get-users', [UserController::class, 'getUsers'])->name('userAjax.getUsers');
Route::post('users', [UserController::class, 'store'])->name('userAjax.store');
Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('userAjax.edit');
Route::put('users/{id}', [UserController::class, 'update'])->name('userAjax.update');
Route::delete('users/{id}', [UserController::class, 'destroy'])->name('userAjax.delete');

Route::get('/getUsersData', [UserController::class, 'getUsers'])->name('users.getdata');
