<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('companies.index');
});

// Company Routes
Route::resource('companies', CompanyController::class);

// Employee Routes
Route::resource('employees', EmployeeController::class);

