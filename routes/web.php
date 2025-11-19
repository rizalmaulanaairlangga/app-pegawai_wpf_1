<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    DepartmentController,
    EmployeeController,
    PositionController,
    AttendanceController,
    SalaryController,
    MyProfileController,
    MyAttendanceController,
    MySalaryController,
};

// ======================
// 🔐 AUTHENTICATION
// ======================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔁 Forgot Password (simulasi)
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot.password');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password.send');


/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    // Jika sudah login, redirect ke halaman sesuai role
    $user = Auth::user();
    if ($user) {
        switch ($user->role) {
            case 'admin':
                return redirect('/departments');
            case 'staff':
                return redirect('/dashboard');
            default:
                return view('home');
        }
    }
    return view('home');
})->name('home');

/*
|--------------------------------------------------------------------------
| ADMIN AREA - Pakai middleware auth dan role:admin
|--------------------------------------------------------------------------
*/
Route::middleware(['role:admin'])
    ->name('admin.') // ⬅️ Tambah ini
    ->group(function () {
        Route::resource('departments', DepartmentController::class);
        Route::resource('employees', EmployeeController::class);
        Route::resource('positions', PositionController::class);
        Route::resource('attendances', AttendanceController::class);
        Route::resource('salaries', SalaryController::class);
    });

/*
|--------------------------------------------------------------------------
| STAFF AREA - Pakai middleware auth dan role:staff
|--------------------------------------------------------------------------
*/
Route::middleware(['role:staff'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        return view('staff.dashboard', compact('user'));
    });

    Route::resource('myprofile', MyProfileController::class);

    // Tambahan route untuk absensi dirinya sendiri
    Route::resource('myattendance', MyAttendanceController::class)->only(['index']);
    // Tombol aksi absensi pribadi
    Route::post('/myattendance/checkin', [App\Http\Controllers\MyAttendanceController::class, 'checkIn'])
        ->name('myattendance.checkin');
    Route::post('/myattendance/checkout', [App\Http\Controllers\MyAttendanceController::class, 'checkOut'])
        ->name('myattendance.checkout');
    Route::get('/my-salaries', [App\Http\Controllers\MySalaryController::class, 'index'])
        ->name('mysalaries.index');
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\StaffDashboardController::class, 'index'])
            ->name('staff.dashboard');
    });

});

