<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DirectionController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RayController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ShelfController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ArchiveDemandController;
use App\Http\Controllers\BoxController;
use App\Http\Controllers\ArchiveDemandDetailsController;
use App\Http\Controllers\BoxArchivedController;
use App\Http\Controllers\LoanDemandController;
use App\Http\Controllers\LoanDetailsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\BoxMovementController;
use App\Http\Controllers\DestroyedBoxController;
use App\Http\Controllers\PendingDestructionController;
use App\Http\Controllers\BoxLoanedController;
use App\Http\Controllers\DownloadMediaController;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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

    Route::resource('archiveDemand', ArchiveDemandController::class);
    Route::get('archiveDemand/direction/{id}', [ArchiveDemandController::class, 'getDepartments']);
    Route::get('/edit_archive/{id}', [ArchiveDemandController::class, 'edit']);
    Route::patch('/archiveDemand/{id}', [ArchiveDemandController::class, 'update'])->name('archiveDemand.update');
    Route::post('/archiveDemand/{id}', [ArchiveDemandController::class, 'store'])->name('archiveDemand.store');

    Route::resource('boxes', BoxController::class);
    // Route::get('/edit_box/{id}', [BoxController::class, 'edit']);

    Route::get('/archiveDemandDetails/{id}', [ArchiveDemandDetailsController::class, 'edit']);

    Route::resource('loanDemand', LoanDemandController::class);
    Route::post('/loanDemand/{id}', [LoanDemandController::class, 'store'])->name('loanDemand.store');
    Route::get('/direction/{id}', [LoanDemandController::class, 'getDepartments']);
    Route::get('/loanDetails/{id}',  [LoanDetailsController::class, 'edit']);
    Route::get('/edit_loan/{id}', [LoanDemandController::class, 'edit']);
    Route::get('/loanDetails/{id}/edit', [LoanDetailsController::class, 'edit'])->name('loanDetails.edit');


    Route::resource('posts', PostController::class);
    Route::delete('posts/destroy', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::post('/files/download', [DownloadMediaController::class, 'download'])->name('download');
    Route::get('/media/download/{mediaId}', [DownloadMediaController::class, 'downloadSingle'])->name('media.download');
    
    Route::resource('boxArchived', BoxArchivedController::class);
    Route::get('/boxArchived_edit/{id}', [BoxArchivedController::class, 'edit']);
    Route::patch('/boxArchived/{id}', [BoxArchivedController::class, 'update'])->name('boxArchived.update');
    Route::get('boxArchived/site/{id}', [BoxArchivedController::class, 'getRays']);
    Route::get('boxArchived/col/{id}', [BoxArchivedController::class, 'getColumns']);
    Route::get('boxArchived/shelves/{id}', [BoxArchivedController::class, 'getShelves']);
    // pour modifer le status availaible
    Route::patch('/boxes/{id}/borrow', [BoxArchivedController::class, 'borrow'])->name('boxes.borrow');
    Route::resource('boxLoaned', BoxLoanedController::class);
    Route::patch('/boxes/{id}/return', [BoxLoanedController::class, 'returnBox'])->name('boxes.return');

    Route::resource('boxMovements', BoxMovementController::class);


    Route::patch('/boxes/{id}/destroy', [BoxArchivedController::class, 'destroy'])->name('boxes.mark_for_destruction');
    Route::get('/boxes/pending_destruction', [BoxArchivedController::class, 'pendingDestruction'])->name('boxes.pending_destruction');
    Route::resource('boxpendingDestruction', PendingDestructionController::class);
    Route::delete('/boxes/{id}/destroy', [PendingDestructionController::class, 'destroy'])->name('boxes.delete');
    Route::get('/boxes/destroyed', [PendingDestructionController::class, 'showDeleted'])->name('boxes.deleted');
    Route::resource('boxdestroyed', DestroyedBoxController::class);

    Route::get('/fetch-loan-demands', [LoanDemandController::class, 'fetchLoanDemandsForMay2024']);


    Route::get('notifications/redirectToNotification/{id}', [NotificationController::class, 'redirectToNotification'])->name('notifications.redirectToNotification');
    Route::get('notifications/get', [NotificationController::class, 'getNotificationsData'])->name('notifications.get');
    Route::get('notifications/markAsReadAll', [NotificationController::class, 'markAsReadAll'])->name('notifications.markAsReadAll');
    Route::get('notifications/markAsRead/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::get('notifications/unreadNotificationsCount', [NotificationController::class, 'unreadNotificationsCount'])->name('notifications.unreadNotificationsCount');
    Route::get('notifications/unreadNotifications', [NotificationController::class, 'unreadNotifications'])->name('notifications.unreadNotifications');
});
