<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('companies.index');
});

/*
|--------------------------------------------------------------------------
| Company Routes
|--------------------------------------------------------------------------
*/
Route::resource('companies', CompanyController::class);

/*
|--------------------------------------------------------------------------
| Employee Routes
|--------------------------------------------------------------------------
*/
Route::resource('employees', EmployeeController::class);



/*
|--------------------------------------------------------------------------
| Manager API Route (AJAX)
|--------------------------------------------------------------------------
*/
Route::get('/employees/managers/{companyId}', [EmployeeController::class, 'getManagersByCompany']);

