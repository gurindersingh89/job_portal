<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminJobController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes(['verify' => true]);
Route::get('/', [DashboardController::class, 'index'])->middleware('verified_user');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['verified'])->group(function(){
    Route::resource('profile', UserProfileController::class);
});
Route::prefix('admin')->name('admin.')->middleware('is_admin')->group(function(){
    Route::get('dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('jobs', AdminJobController::class);
    Route::post('jobs/status/update', [AdminJobController::class, 'jobStatusUpdate']);
    Route::resource('users', AdminUserController::class);
});