    <?php

    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\DirectionController;
    use App\Http\Controllers\DepartmentController;
    use App\Http\Controllers\RayController;
    use App\Http\Controllers\ColumnController;
    use App\Http\Controllers\SiteController;
use App\Models\Column;

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
        Route::view('admin','Admin');
        Route::resource('directions',DirectionController::class);
        Route::resource('departments',DepartmentController::class);
        Route::resource('sites',SiteController::class);
        Route::resource('rays',RayController::class);
        Route::resource('columns',ColumnController::class);
        Route::get('/site/{id}','ColumnController@getrays');
       

    });


