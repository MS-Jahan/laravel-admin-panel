<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntryController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::prefix('')->group(function () {
    Route::get('/', [EntryController::class, 'index'])->name('entries.index'); 
    Route::get('/create', [EntryController::class, 'create'])->name('entries.create');
    Route::post('/', [EntryController::class, 'store'])->name('entries.store');
    Route::get('/{entry}/edit', [EntryController::class, 'edit'])->name('entries.edit');
    Route::put('/{entry}', [EntryController::class, 'update'])->name('entries.update');
    Route::delete('/{entry}', [EntryController::class, 'destroy'])->name('entries.destroy');
});
