<?php


use App\Http\Controllers\SinistreController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home',[SinistreController::class,'home'])->name('gestionnaire.home');
Route::get('/liste_sinistre',[SinistreController::class,'listeSinistre'])->name('gestionnaire.listeSinistre');
Route::get('/declarerSinistre',[SinistreController::class,'declarerSinistre'])->name('gestionnaire.declarerSinistre');
Route::post('/declarerSinistre', [SinistreController::class, 'store'])->name('gestionnaire.store');