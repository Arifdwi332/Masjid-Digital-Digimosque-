<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\zakatController;
use App\Http\Controllers\infaqController;
use App\Http\Controllers\pengeluaraninfaqController;
use App\Http\Controllers\reportInfaqController;
use App\Http\Controllers\perkakasController;
use App\Http\Controllers\PengeluaranZakatController;
use App\Http\Controllers\ReportZakatController;


Route::get('/', function () {
    return view('home', ['name' => 'Arif']);
});

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


Route::get('/pengeluaranzakat', function () {
    return view('zakat.pengeluaran', ['name' => 'Arif']);
});

Route::get('/pengeluaran-zakat', [PengeluaranZakatController::class, 'index'])->name('pengeluaranZakatAjax.index');
Route::post('pengeluaran-zakat/store', [PengeluaranZakatController::class, 'store'])->name('pengeluaranZakatAjax.store');
Route::get('pengeluaran-zakat/{id}/edit', [PengeluaranZakatController::class, 'edit'])->name('pengeluaranZakatAjax.edit');
Route::put('pengeluaran-zakat/{id}', [PengeluaranZakatController::class, 'update'])->name('pengeluaranZakatAjax.update');
Route::delete('pengeluaran-zakat/{id}', [PengeluaranZakatController::class, 'destroy'])->name('pengeluaranZakatAjax.delete');


Route::get('/reportzakat', function () {
    return view('zakat.report', ['name' => 'Arif']);
});

Route::get('report-zakat/data', [ReportZakatController::class, 'getData'])->name('report.datazakat');
