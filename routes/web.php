<?php

use App\Enums\UserRole;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\NotaInternController;
use App\Http\Controllers\NotaInternReportController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SuratKeluarReportController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratMasukReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::redirect('/', '/dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::middleware(
        'role:' . implode(',', [UserRole::ADMIN()])
    )->group(function () {
        Route::resource('/products', ProductController::class);
    });

    Route::get('/products/{product}/transaction', [ProductController::class, 'transaction'])
        ->name('products.transaction');
    Route::post('/products/{product}/transaction', [ProductController::class, 'transactionPost']);
    Route::get('/products/{product}/decrease', [ProductController::class, 'decrease'])
        ->name('products.decrease');
    Route::post('/products/{product}/decrease', [ProductController::class, 'decreasePost']);
    Route::get('/products/{product}/detail', [ProductController::class, 'detail'])
        ->name('products.detail');
    Route::delete('/products/{product}/{stock}', [ProductController::class, 'destroyStock'])
        ->name('products.stock');

    Route::resource('/histories', HistoryController::class)->only(['index']);
    Route::resource('/stocks', StockController::class)->only(['index']);
    Route::get('/stocks/{product}/add', [StockController::class, 'add'])
        ->name('stocks.add');
    Route::post('/stocks/{product}/add', [StockController::class, 'addPost']);

    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');
    Route::post('/reports', [ReportController::class, 'reportPost']);
    Route::post('/reports/export-all', [ReportController::class, 'exportAll'])->name('reports.exportAll');

    Route::delete('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});


Route::middleware('guest')->group(function () {
    // auth
    Route::get('/login', [AuthController::class, 'index'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/forgot', [AuthController::class, 'forgot'])->name('auth.forgot');
    Route::post('/forgot', [AuthController::class, 'forgotPost']);
    Route::get('/reset/{token}', [AuthController::class, 'reset'])->name('password.reset');
    Route::post('/reset', [AuthController::class, 'resetPost'])->name('password.update');
});
