<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| These routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|--------------------------------------------------------------------------
*/

// Location API Routes
Route::prefix('locations')->group(function () {
    Route::get('/countries', [LocationController::class, 'getCountries']);
    Route::get('/states/{country}', [LocationController::class, 'getStates']);
    Route::get('/cities/{state}', [LocationController::class, 'getCities']);
});

// Manager API Route
Route::get('/companies/{companyId}/managers', [EmployeeController::class, 'getManagersByCompany']);
