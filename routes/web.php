<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/get-message', [App\Http\Controllers\HomeController::class, 'getMessage'])->name('getMessage');
Route::post('/send-message', [App\Http\Controllers\HomeController::class, 'store'])->name('chat.send');
