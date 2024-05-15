<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DirectionController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RayController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ShelfController;
use App\Http\Controllers\DropdownController;
use App\Models\Column;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ArchiveRequestController;
use App\Http\Controllers\BoxController;
use App\Http\Controllers\ArchieveRequestDetailsController;
use App\Http\Controllers\LoanRequestController;
use App\Http\Controllers\LoanDetailsController;

// Définir la route d'accueil pour rediriger vers la page de connexion
Route::get('/', function () {
    return view('auth.login');
});

// Définir les routes d'authentification
Auth::routes();

// Groupe de routes protégées par authentification
Route::middleware('auth')->group(function () {
    // Définir les routes pour accéder uniquement après l'authentification
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::view('admin', 'Admin');

    Route::resource('directions', DirectionController::class)->middleware('can:directions');
    Route::resource('departments', DepartmentController::class)->middleware('can:departments');

    Route::resource('sites', SiteController::class)->middleware('can:sites');
    Route::resource('rays', RayController::class)->middleware('can:rays');

    Route::resource('columns', ColumnController::class)->middleware('can:columns');
    Route::get('/site/{id}', [ColumnController::class, 'getRays'])->middleware('can:columns');
    
    Route::resource('shelves', ShelfController::class)->middleware('can:shelves');
    Route::get('/site/{id}', [ShelfController::class, 'getRays'])->middleware('can:shelves');
    Route::get('/col/{id}', [ShelfController::class, 'getColumns'])->middleware('can:shelves');

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    Route::resource('archiveRequest', ArchiveRequestController::class);
    Route::get('/direction/{id}', [ArchiveRequestController::class, 'getDepartments']);

    Route::get('/edit_archive/{id}', [ArchiveRequestController::class, 'edit']);
    Route::patch('/archiveRequest/{id}', [ArchiveRequestController::class,'update'])->name('archiveRequest.update');
    Route::post('/archiveRequest/{id}', [ArchiveRequestController::class, 'store'])->name('archiveRequest.store');


    Route::resource('boxes', BoxController::class);
    Route::get('/edit_box/{id}', [BoxController::class, 'edit']);
   
    Route::get('/archieveRequestDetails/{id}', [ArchieveRequestDetailsController::class, 'edit']);

    Route::resource('loanRequest', LoanRequestController::class);
    Route::get('/direction/{id}', [LoanRequestController::class, 'getDepartments']);
    Route::get('/loanDetails/{id}',  [LoanDetailsController::class, 'edit']);
    
    Route::get('/edit_loan/{id}', [LoanRequestController::class, 'edit']);

    Route::get('MarkAsRead_all', [LoanRequestController::class, 'MarkAsRead_all'])->name('MarkAsRead_all');





});

