<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LayerController;
use App\Http\Controllers\LayupController;
use App\Http\Controllers\PendingImportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::post('/logout', function () {

    Auth::logout();

    request()->session()->invalidate();

    request()->session()->regenerateToken();

    return redirect('/login');

})->name('logout');



Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'verified'])->group(function (){

Route::get('/supplier/export', [SupplierController::class, 'export'])
    ->name('supplier.export');

    Route::post('/supplier/import', [SupplierController::class, 'import'])
    ->name('supplier.import');

Route::get('/layup/export', [LayupController::class, 'export'])
    ->name('layup.export');

Route::post('/layup/import', [LayupController::class, 'import'])
    ->name('layup.import');

Route::post('/supplier/import/check', [PendingImportController::class, 'check'])
    ->name('supplier.import.check');

Route::post('/supplier/import/commit', [PendingImportController::class, 'commit'])
    ->name('supplier.import.commit');

    
Route::post('/supplier/update/{supplier}', [SupplierController::class, 'update'])
    ->name('supplier.update');

    Route::post('/layup/update/{layup}', [LayupController::class, 'update'])
    ->name('layup.update');

Route::resource('supplier', SupplierController::class)->middleware([HandlePrecognitiveRequests::class]);
Route::resource('layup', LayupController::class)->middleware([HandlePrecognitiveRequests::class]);
Route::resource('layer', LayerController::class)->middleware([HandlePrecognitiveRequests::class]);




 Route::post('/supplier/store', [SupplierController::class, 'store'])->name('supplier.store')->middleware([HandlePrecognitiveRequests::class]);

});




require __DIR__.'/auth.php';
