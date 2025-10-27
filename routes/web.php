<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

use App\Http\Controllers\{
    DepartmentController,
    EmployeeController,
    PositionController,
    AttendanceController,
    SalaryController
};

Route::resource('/', DepartmentController::class);

Route::resource('departments', DepartmentController::class);
Route::resource('employees', EmployeeController::class);
Route::resource('positions', PositionController::class);
Route::resource('attendances', AttendanceController::class);
Route::resource('salaries', SalaryController::class);

