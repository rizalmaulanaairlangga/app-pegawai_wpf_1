<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ======================
// 📌 Import Controllers By Namespace
// ======================
use App\Http\Controllers\Auth\{
    AuthController,
    ForgotPasswordController,
    ResetPasswordController,
};

use App\Http\Controllers\AccountController;

// Admin Controllers
use App\Http\Controllers\Admin\{
    DepartmentController,
    EmployeeController,
    PositionController,
    AttendanceController,
    SalaryController,
};

// Staff Controllers
use App\Http\Controllers\Staff\{
    MyAttendanceController,
    MySalaryController,
    MyProfileController,
    StaffDashboardController,
};



// Guest-only (belum login)
Route::middleware('guest')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | AUTHENTICATION
    |--------------------------------------------------------------------------
    */
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    
    // Registration
    // show register form
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    
    // proses register
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
    
    
    // Forgot Password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('forgot.password');
    
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('forgot.password.send');
    
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');
    
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
        ->name('password.update');
});

    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $user = Auth::user();
    if ($user) {
        return $user->role === 'admin'
            ? redirect()->route('departments.index')
            : redirect()->route('staff.dashboard');
    }
    return view('home');
})->name('home');


/*
|--------------------------------------------------------------------------
| ADMIN AREA - Pakai middleware role:admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin', 'employee_exists'])->group(function () {
    Route::resource('departments', DepartmentController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('positions', PositionController::class);
    Route::resource('attendances', AttendanceController::class);
    Route::resource('salaries', SalaryController::class);
});


/*
|--------------------------------------------------------------------------
| STAFF AREA - Pakai middleware role:staff
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:staff', 'employee_exists'])->group(function () {

    // Dashboard Staff
    Route::get('/dashboard', [StaffDashboardController::class, 'index'])
        ->name('staff.dashboard');

    // Profile Staff
    Route::resource('myprofile', MyProfileController::class);

    // Absensi Staff
    Route::resource('myattendance', MyAttendanceController::class)->only(['index']);

    // Aksi Check In/Out
    Route::post('/myattendance/checkin', [MyAttendanceController::class, 'checkIn'])
        ->name('myattendance.checkin');
    Route::post('/myattendance/checkout', [MyAttendanceController::class, 'checkOut'])
        ->name('myattendance.checkout');

    // Gaji Staff
    Route::get('/my-salaries', [MySalaryController::class, 'index'])
        ->name('mysalaries.index');
});


Route::middleware(['auth', 'role:admin,staff', 'employee_exists'])->group(function () {
    Route::get('/settings', [AccountController::class, 'edit'])->name('settings.edit');
    // gunakan put untuk semantics update
    Route::put('/settings', [AccountController::class, 'update'])->name('settings.update');
});