<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\PublicationController;
use Illuminate\Support\Facades\Route;




Route::get('api/',[PublicationController::class, 'index']);

Route::get('api/publications/{id}',[PublicationController::class, 'show']);

Route::post('api/publications',[PublicationController::class, 'store']);



Route::get('/',[PageController::class, 'index']);


Route::get('/create',[PageController::class, 'create']);
