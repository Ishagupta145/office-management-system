<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('companies.index');
});

// Company Routes
Route::resource('companies', CompanyController::class);

// Employee Routes
Route::resource('employees', EmployeeController::class);

// Location API Routes
Route::prefix('api/locations')->group(function () {
    Route::get('/countries', [LocationController::class, 'getCountries']);
    Route::get('/states/{country}', [LocationController::class, 'getStates']);
    Route::get('/cities/{state}', [LocationController::class, 'getCities']);
});

// Manager-by-company API
Route::prefix('api')->group(function () {
    Route::get('/companies/{companyId}/managers', [EmployeeController::class, 'getManagersByCompany']);
});


