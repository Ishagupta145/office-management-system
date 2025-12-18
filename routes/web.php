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

// Manager routes
Route::get('/employees/managers/{companyId}', [EmployeeController::class, 'getManagersByCompany']);
Route::get('/api/companies/{companyId}/managers', [EmployeeController::class, 'getManagersByCompany']);
