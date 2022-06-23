<?php

use App\Http\Controllers\AccountCategoryController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BindingTypeController;
use App\Http\Controllers\ModeratorTypeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CirculationController;
use App\Http\Controllers\CostCategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PressController;
use App\Http\Controllers\PriceCategoryController;
use App\Http\Controllers\PrintingCostController;
use App\Http\Controllers\PrintingDetailsCategoryValueController;
use App\Http\Controllers\PrintingDetailsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\ProductRequestController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VersionController;
use App\Http\Controllers\VersionVariableController;
use App\Models\BindingType;
use App\Models\PrintingDetailsCategoryValue;
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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });
Route::get('/', [AuthenticatedSessionController::class, 'create'])
                ->middleware('guest')
                ->name('login');

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/customer-list', [CustomerController::class, 'customer_list'])->middleware(['auth', 'verified'])->name('customer-list');

Route::get('/typing-test', function () {
    return Inertia::render('TypingTest');
})->middleware(['auth', 'admin'])->name('typing-test');


require __DIR__ . '/auth.php';

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/printing-cost-categories/{version}', [PrintingCostController::class, 'createWithVerion'])->name('printing-cost-categories');
    Route::resources([
        'users'                     => UserController::class,
        'roles'                     => RoleController::class,
        'publishers'                => PublisherController::class,
        'productions'               => ProductionController::class,
        'presses'                   => PressController::class,
        'version-variables'         => VersionVariableController::class,
        'printing-detail-categories' => PrintingDetailsCategoryValueController::class,
        'cost-categories'           => CostCategoryController::class,
        'product-requests'           => ProductRequestController::class,
        'binding-types'             => BindingTypeController::class,
        'versions'                  => VersionController::class,
        'printing-costs'            => PrintingCostController::class,
        'categories'                => CategoryController::class,
        'authors'                   => AuthorController::class,
        'products'                  => ProductController::class,
        'packages'                  => PackageController::class,
        'sales'                     => SaleController::class,
        'outlets'                   => OutletController::class,
        'distributions'             => DistributionController::class,
        'storages'                  => StorageController::class,
        'account-categories'        => AccountCategoryController::class,
        'accounts'                  => AccountController::class,
        'incomes'                   => IncomeController::class,
        'expenses'                  => ExpenseController::class,
        'price-categories'          => PriceCategoryController::class,
        'moderator-types'           => ModeratorTypeController::class,
        'circulations'              => CirculationController::class,
        'moderators'                => ModeratorController::class,
        'customers'                 => CustomerController::class,
    ]);
});
