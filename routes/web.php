<?php

use App\Http\Controllers\BudgetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DebitController;
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

Route::middleware(['auth'])->group(function () {
    Route::get("/", [DashboardController::class, 'index'])->name('dashboard');
    Route::get("/manage", [BudgetController::class, 'index'])->name('budget.index');
    Route::get("/manage/create", [BudgetController::class, 'create'])->name('budget.create');
    Route::post("/manage/create", [BudgetController::class, 'store'])->name('budget.store');
    Route::get("/manage/{id}", [BudgetController::class, 'edit'])->name('budget.edit');
    Route::put("/manage/{id}", [BudgetController::class, 'update'])->name('budget.update');

    Route::post("/debit", [DebitController::class, 'store'])->name('debit.store');

});

require __DIR__.'/auth.php';
