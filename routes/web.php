<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\zakatAjaxController;

Route::get('/', function () {
    return view('home', ['name' => 'Arif']);
});

Route::get('/zakat', function () {
    return view('zakat.zakat', ['name' => 'Arif']);
});

Route::post('/zakat', [zakatAjaxController::class, 'store'])->name('zakat.store');
Route::resource('zakatAjax', zakatAjaxController::class);


Route::get('/pengeluaranzakat', function () {
    return view('zakat.pengeluaran', ['name' => 'Arif']);
});

Route::post('/pengeluaranzakat', [zakatAjaxController::class, 'store'])->name('zakat.store');
Route::resource('zakatAjax', zakatAjaxController::class);
