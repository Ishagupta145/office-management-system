<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\EmployeeController;

// Location APIs
Route::prefix('locations')->group(function () {
    Route::get('/countries', [LocationController::class, 'getCountries']);
    Route::get('/states/{country}', [LocationController::class, 'getStates']);
    Route::get('/cities/{state}', [LocationController::class, 'getCities']);
});

// Manager by company API
Route::get('/companies/{companyId}/managers', [EmployeeController::class, 'getManagersByCompany']);

