<?php


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatutController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\SinistreController;
use App\Http\Controllers\ResponsableController;

Route::get('/', function () {
    return view('welcome');
});

//Route pour l'interface gestionnaire
Route::get('/home',[SinistreController::class,'home'])->name('gestionnaire.home');
Route::get('/formSinistre',[SinistreController::class,'index'])->name('gestionnaire.index');
Route::get('/listeSinistre',[SinistreController::class,'listeSinistre'])->name('gestionnaire.listeSinistre');
Route::get('/declarerSinistre',[SinistreController::class,'declarerSinistre'])->name('gestionnaire.declarerSinistre');
Route::get('/sinistres/{id}',[SinistreController::class,'show'])->name('gestionnaire.showSinistre');
Route::post('/declarerSinistre', [SinistreController::class, 'store'])->name('gestionnaire.store');

//route pour l'envoie de document
Route::post('/storeFile',[DocumentController::class,'store'])->name('document.store');


//Route pour l'interface administrateur
Route::get('/indexAdmin',[StatutController::class,'index'])->name('admin.formStatut');
Route::post('/storeStatut',[StatutController::class,'store'])->name('admin.store');


//Route pour l'interface responsable
Route::get('/indexResponsable',[ResponsableController::class,'index'])->name('responsable.index');