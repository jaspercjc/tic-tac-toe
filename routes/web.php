<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\GameController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware([\App\Http\Middleware\RedirectIfPlaying::class])->get('/', function () {
    return inertia('Index');
});

Route::middleware([\App\Http\Middleware\RedirectIfNotPlaying::class])->group(function () {
    Route::get('/game', [GameController::class, 'index'])->name('game');
    Route::post('/move', [GameController::class, 'move'])->name('move');
    Route::post('/surrender', [GameController::class, 'surrender'])->name('surrender');
});

Route::post('/start', [GameController::class, 'start'])->name('start');
