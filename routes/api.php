<?php

use App\Http\Controllers\AnimeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MangaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/logout', [AuthController::class, 'logout']);
Route::post('auth/refresh', [AuthController::class, 'refresh']);
Route::post('auth/me', [AuthController::class, 'me']);

Route::get('animes/top', [AnimeController::class, 'top']);
Route::get('mangas/top', [MangaController::class, 'top']);
Route::apiResource('animes', AnimeController::class);
Route::apiResource('mangas', MangaController::class);
