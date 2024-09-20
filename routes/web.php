<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController; 
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EmailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/home', function () {
    return view('auth.login');
});


Route::middleware('auth')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('dashboard', [HomeController::class, 'index'])->name('home');

        Route::get('profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
        Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('save-theme-preference', [ProfileController::class, 'saveTheme'])->name('theme.save');

        // Category routes
        Route::prefix('category')->group(function () {
            Route::resource('category', CategoryController::class);
            Route::post('category/delete', [CategoryController::class, 'massDeleteCategoies'])->name('category.mass-delete');
        });

        // Product routes
        Route::resource('products', ProductController::class);
        Route::delete('products/mass-delete', [ProductController::class, 'massDeleteProducts'])->name('products.massDelete');

        // Role routes
        Route::resource('roles', RoleController::class);
        Route::delete('roles/mass-delete', [RoleController::class, 'massDeleteRoles'])->name('roles.massDelete');

        // Permission routes
        Route::resource('permissions', PermissionController::class);

        // User routes
        Route::resource('users', UserController::class);
        Route::post('users/delete', [UserController::class, 'massDeleteUsers'])->name('users.mass-delete');
        Route::post('users/update-active-status', [UserController::class, 'updateActiveStatus'])->name('users.update-active-status');


        // Route to send bulk emails
        Route::get('/send-emails', [EmailController::class, 'sendBulkEmails'])->name('send.emails');

       

    });
});
// Correct usage of Auth::routes()
Auth::routes(['register' => false]);
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

