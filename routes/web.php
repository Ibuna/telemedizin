<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorSearchController;

Route::get('/', function () {
    return view('layouts.app');
});

Route::get('/search/doctors', [DoctorSearchController::class, 'search']);

