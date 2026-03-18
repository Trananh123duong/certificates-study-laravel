<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TagController;

Route::get('/tags', [TagController::class, 'index']);
Route::post('/posts/{post}/tags/attach', [TagController::class, 'attachToPost']);
Route::post('/posts/{post}/tags/sync', [TagController::class, 'syncPost']);