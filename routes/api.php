<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorApiController;
use App\Http\Controllers\AppointmentApiController;
use App\Http\Controllers\TimeslotApiController;

Route::apiResource('doctors', DoctorApiController::class);
Route::apiResource('appointments', AppointmentApiController::class);
Route::apiResource('timeslots', TimeslotApiController::class);