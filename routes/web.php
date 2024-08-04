<?php

use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// --> Rota criada em / apenas para facilitar o uso
Route::get('/', [DocumentController::class, 'show'])->name('document.show');

Route::prefix('document')->name('document.')->group(function () {
    Route::get('/', [DocumentController::class, 'show'])->name('show');
    Route::post('/', [DocumentController::class, 'upload'])->name('upload');
    Route::get('/process', [DocumentController::class, 'process'])->name('process');
});
