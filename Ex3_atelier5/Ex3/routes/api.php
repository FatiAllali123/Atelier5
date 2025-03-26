<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;

Route::post('/rooms', [RoomController::class, 'store']);
Route::put('/rooms/{room}', [RoomController::class, 'update']);
Route::delete('/rooms/{room}', [RoomController::class, 'destroy']);
