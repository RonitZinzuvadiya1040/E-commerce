<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Frontend\FrontProductController;

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

Route::get('/', function () {
    return view('welcome');
});

# ----------------------------------------------------- Backend routes ------------------------------------------------- #

# ------------------------------------------ All Normal Users Routes List -------------------------------------------- #

Route::middleware(['auth', 'verified', 'user-access:user'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/home', [HomeController::class, 'userHome'])->name('user.home');
        Route::prefix('profile')->group(function () {
            Route::get('/', [ProfileController::class, 'userProfile'])->name('user.profile');
            Route::put('/', [ProfileController::class, 'update'])->name('user.profile.update');
            Route::put('/password', [ProfileController::class, 'updatePassword'])->name('user.profile.update.password');
        });
    });

    # Products routes
    Route::get('/products', [ProductController::class, 'index'])->name('product.index'); # List products for all users
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show'); # View single product
});

# ------------------------------------------ All Admin Routes List -------------------------------------------- #

Route::middleware(['auth', 'verified', 'user-access:admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/home', [HomeController::class, 'adminHome'])->name('admin.home');
        Route::prefix('profile')->group(function () {
            Route::get('/', [ProfileController::class, 'adminProfile'])->name('admin.profile');
            Route::put('/', [ProfileController::class, 'update'])->name('admin.profile.update');
            Route::put('/password', [ProfileController::class, 'updatePassword'])->name('admin.profile.update.password');
        });

        # Products routes
        Route::get('/products', [ProductController::class, 'index'])->name('admin.product.index'); # List products for admin
        Route::get('/product/create', [ProductController::class, 'create'])->name('admin.product.create'); # Add product form
        Route::post('/products', [ProductController::class, 'store'])->name('admin.product.store'); # Store new product
        Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('admin.product.edit'); # Edit product form
        Route::put('/product/{id}', [ProductController::class, 'update'])->name('admin.product.update'); # Update product
        Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('admin.product.destroy'); # Delete product
        # Brands routes
        Route::get('/brands', [BrandController::class, 'index'])->name('admin.brand.index'); # List brands for admin
        Route::get('/brand/create', [BrandController::class, 'create'])->name('admin.brand.create'); # Add brand form
        Route::post('/brands', [BrandController::class, 'store'])->name('admin.brand.store'); # Store new brand
        Route::get('/brand/{id}/edit', [BrandController::class, 'edit'])->name('admin.brand.edit'); # Edit brand form
        Route::put('/brand/{id}', [BrandController::class, 'update'])->name('admin.brand.update'); # Update brand
        Route::delete('/brand/{id}', [BrandController::class, 'destroy'])->name('admin.brand.destroy'); # Delete brand
        # Categories routes
        Route::get('/categories', [CategoryController::class, 'index'])->name('admin.category.index'); # List category for admin
        Route::get('/category/create', [CategoryController::class, 'create'])->name('admin.category.create'); # Add category form
        Route::post('/categories', [CategoryController::class, 'store'])->name('admin.category.store'); # Store new category
        Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit'); # Edit category form
        Route::put('/category/{id}', [CategoryController::class, 'update'])->name('admin.category.update'); # Update category
        Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy'); # Delete category
    });
});

# ------------------------------------------ All Manager Routes List -------------------------------------------- #

Route::middleware(['auth', 'verified', 'user-access:manager'])->group(function () {
    Route::prefix('manager')->group(function () {
        Route::get('/home', [HomeController::class, 'managerHome'])->name('manager.home');
        Route::get('/profile', [ProfileController::class, 'managerProfile'])->name('manager.profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('manager.profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('manager.profile.update.password');
    });

    # Products routes
    Route::get('/products', [ProductController::class, 'index'])->name('product.index'); # List products for all users
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show'); # View single product
    # Brands routes
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index'); # List brands
    Route::get('/brand/{id}', [BrandController::class, 'show'])->name('brand.show'); # View single brand
});

# Email verification routes
Auth::routes(['verify' => true]);

# Verification notice route
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})
    ->middleware('auth')
    ->name('verification.notice');

# Verification handler route
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    # Redirect based on user role
    $user = $request->user();

    switch ($user->type) {
        case 1: # Admin
            return redirect()->route('admin.home');
        case 2: # Manager
            return redirect()->route('manager.home');
        default:
            # User or any other type
            return redirect()->route('user.home');
    }
})
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

# Resend verification email route
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'Verification link sent!');
})
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.resend');

### ------------------------------------------------------ Frontend routes ------------------------------------------------------------- ###
Route::middleware(['auth', 'verified', 'user-access:user'])->group(function () {
    Route::get('/category/{id}', [HomeController::class, 'showCategoryProducts'])->name('category.products');
});
