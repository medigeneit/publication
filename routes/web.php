<?php

use App\Http\Controllers\AccountCategoryController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard',[ DashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'admin'])->group(function () {

    Route::resources([
        'users'                     => UserController::class,
        'categories'                => CategoryController::class,
        'authors'                   => AuthorController::class,
        'products'                  => ProductController::class,
        'publishers'                => PublisherController::class,
        'sales'                     => SaleController::class,
        'outlets'                   => OutletController::class,
        'distributions'             => DistributionController::class,
        'storages'                  => StorageController::class,
        'account-categories'        => AccountCategoryController::class,
        'accounts'                  => AccountController::class,
        'incomes'                   => IncomeController::class,
        'expenses'                  => ExpenseController::class,
    ]);
});
