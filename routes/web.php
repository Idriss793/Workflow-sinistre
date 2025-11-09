<?php


use Illuminate\Http\Request;
use App\Models\AssurePrincipal;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpertController;
use App\Http\Controllers\StatutController;
use App\Http\Controllers\PassageController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\SinistreController;
use App\Http\Controllers\assureTiersController;
use App\Http\Controllers\ResponsableController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\assurePrincipalController;

Route::get('/', function () {
    return redirect()->route('auth.connection');
});

// Routes publiques (connexion / inscription)
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('auth.connection');

// Déconnexion (protégée)
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->middleware('auth')->name('logout');

// Routes accessibles uniquement aux utilisateurs connectés
Route::middleware('auth')->group(function () {

    // Interface gestionnaire
    Route::middleware('role:gestionnaire')->group(function () {
        Route::get('/profileGestionnaire', [SinistreController::class, 'profileGestionnaire'])->name('gestionnaire.profile');
        Route::get('/home', [SinistreController::class, 'home'])->name('gestionnaire.home');
        Route::get('/formSinistre', [SinistreController::class, 'index'])->name('gestionnaire.index');
        Route::get('/declarerSinistre', [SinistreController::class, 'declarerSinistre'])->name('gestionnaire.declarerSinistre');
        Route::post('/declarerSinistre', [SinistreController::class, 'store'])->name('gestionnaire.store');
        Route::get('/gestionnaire/sinistres/{id}', [SinistreController::class, 'show'])->name('gestionnaire.showSinistre');
        Route::post('/storeFile',[DocumentController::class,'store'])->name('document.store');
        Route::get('/annulerExpert/{sinistre}/{expert}', [SinistreController::class, 'annulerExpert'])->name('expert.annulerExpert');
        Route::post('/attribuerExpert/{id}', [SinistreController::class, 'attribuerExpert'])->name('expert.attribuerExpert');
        Route::put('/updateAssurePrincipal/{id}', [assurePrincipalController::class, 'updateAssurePrincipal'])->name('assurePrincipal.update');
        Route::put('/updateAssureTiers/{id}', [assureTiersController::class, 'updateAssureTiers'])->name('assureTiers.update');
        Route::post('/storeAssureTiers', [assureTiersController::class, 'storeAssureTiers'])->name('assureTiers.ajouter');
        Route::put('/profileGestionnaire', [SinistreController::class, 'updateProfile'])->name('profileGestionnaire.update');




        // Passages
        Route::post('/storePassage', [PassageController::class, 'storePassage'])->name('passage.storePassage');
        Route::get('/listePassages', [PassageController::class, 'listePassage'])->name('passage.liste');
        Route::post('/joindreDocument', [PassageController::class, 'joindreDocument'])->name('passage.joindreDocument');
        Route::put('/passage/{id}', [PassageController::class, 'update'])->name('passager.update');
        Route::get('/passage/{id}', [PassageController::class, 'show'])->name('passage.show');
    });

    // Interface expert
    Route::middleware('role:expert')->group(function () {
        Route::get('/search', [ExpertController::class, 'search'])->name('expert.search');
        Route::get('/profileExpert', [ExpertController::class, 'profile'])->name('expert.profile');
        Route::get('/indexExpert', [ExpertController::class, 'index'])->name('expert.index');
        Route::get('/listeExpertises', [ExpertController::class, 'listeExpertises'])->name('expert.listeExpertises');
        Route::get('/expert/sinistres/{id}', [ExpertController::class, 'show'])->name('expert.show');
        Route::post('/storeExpertise', [ExpertController::class, 'storeExpertise'])->name('expert.storeExpertise');
        Route::get('/passageExpert/{id}', [PassageController::class, 'show'])->name('passages.show');
        Route::put('/profileExpert', [ExpertController::class, 'updateProfile'])->name('profileExpert.update');
        Route::get('/notification/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->name('notification.read');
        Route::get('/notifications', [NotificationController::class, 'showAll'])->name('notifications.showAll');
    });

    // Interface responsable
    Route::middleware('role:responsable')->group(function () {
        Route::get('/searchResponsable', [ResponsableController::class, 'search'])->name('responsable.search');
        Route::get('/indexResponsable', [ResponsableController::class, 'index'])->name('responsable.index');
        Route::get('/responsable/sinistres/{id}', [ResponsableController::class, 'show'])->name('responsable.show');
        Route::get('/listePersonnel', [ResponsableController::class, 'showPersonnel'])->name('responsable.showPersonnel');
        Route::get('/register', [UserController::class, 'showRegisterForm'])->name('auth.register');
        Route::get('/passages/{id}', [PassageController::class, 'show'])->name('passages.show');
        Route::get('/profileResponsable', [ResponsableController::class, 'profile'])->name('responsable.profile');
        Route::put('/profileResponsable', [ResponsableController::class, 'updateProfile'])->name('profileResponsable.update');
        Route::get('/sinistre/valider/{id}', [ResponsableController::class, 'validerSinistre'])->name('sinistres.valider');
        Route::get('/sinistre/rejeter/{id}', [ResponsableController::class, 'rejeterSinistre'])->name('sinistres.rejeter');
        Route::put('/expertises/{id}/valider', [ResponsableController::class, 'validerExpertise'])->name('expertises.valider');
        Route::put('/expertises/{id}/refuser', [ResponsableController::class, 'refuserExpertise'])->name('expertises.refuser');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::patch('/users/{id}/block', [UserController::class, 'block'])->name('users.block');
        Route::patch('/users/{id}/unblock', [UserController::class, 'unblock'])->name('users.unblock');


    });

    // Interface administrateur
    Route::middleware('role:administrateur')->group(function () {
        Route::get('/indexAdmin', [StatutController::class, 'index'])->name('admin.formStatut');
        Route::post('/storeStatut', [StatutController::class, 'store'])->name('admin.store');
    });

    
});