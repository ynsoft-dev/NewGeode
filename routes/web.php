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
    use App\Http\Controllers\LoanDemandController;
    use App\Http\Controllers\LoanDetailsController;
    use App\Http\Controllers\PostController;

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
        Route::get('/direction/{id}', [ArchiveDemandController::class, 'getDepartments']);
        Route::get('/edit_archive/{id}', [ArchiveDemandController::class, 'edit']);
        Route::patch('/archiveDemand/{id}', [ArchiveDemandController::class, 'update'])->name('archiveDemand.update');
        Route::post('/archiveDemand/{id}', [ArchiveDemandController::class, 'store'])->name('archiveDemand.store');
        Route::resource('boxes', BoxController::class);
        Route::get('/edit_box/{id}', [BoxController::class, 'edit']);
        Route::get('/archiveDemandDetails/{id}', [ArchiveDemandDetailsController::class, 'edit']);


        Route::resource('loanDemand', LoanDemandController::class);
        Route::get('/direction/{id}', [LoanDemandController::class, 'getDepartments']);
        Route::get('/loanDetails/{id}',  [LoanDetailsController::class, 'edit']);
        Route::get('/edit_loan/{id}', [LoanDemandController::class, 'edit']);
        Route::get('MarkAsRead_all', [LoanDemandController::class, 'MarkAsRead_all'])->name('MarkAsRead_all');
        Route::get('unreadNotifications_count', [LoanDemandController::class, 'unreadNotifications_count'])->name('unreadNotifications_count');
        Route::get('unreadNotifications', [LoanDemandController::class, 'unreadNotifications'])->name('unreadNotifications');
        Route::resource('posts', PostController::class);
        Route::get('/loanDetails/{id}/edit', [LoanDetailsController::class, 'edit'])->name('loanDetails.edit');
        Route::post('/process_loan', [LoanDetailsController::class, 'processLoan'])->name('process_loan');
    });
