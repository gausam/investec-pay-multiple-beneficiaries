<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\HistoryController ;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [BeneficiaryController::class, 'index'])->name('dashboard');
    Route::post('/pay', [BeneficiaryController::class, 'pay'])->name('pay');
    Route::get('/history', [HistoryController ::class, 'index'])->name('history');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
