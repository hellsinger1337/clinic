<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DoctorController;

Route::apiResource('slots', SlotController::class);
Route::apiResource('doctors', DoctorController::class);
Route::apiResource('clients', ClientController::class);