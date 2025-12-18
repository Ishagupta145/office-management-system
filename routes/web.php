<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LocationController;

/*
| Web Routes (Pages)
*/

Route::get('/', function () {
    return redirect()->route('companies.index');
});

Route::resource('companies', CompanyController::class);
Route::resource('employees', EmployeeController::class);

/*
| API Routes
*/

Route::prefix('locations')->group(function () {
    Route::get('/countries', [LocationController::class, 'getCountries']);
    Route::get('/states/{country}', [LocationController::class, 'getStates']);
    Route::get('/cities/{state}', [LocationController::class, 'getCities']);
});

Route::get('/companies/{companyId}/managers', [EmployeeController::class, 'getManagersByCompany']);
