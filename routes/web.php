<?php

use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\StockController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductionSetupController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DeliveryInController;
use App\Http\Controllers\DeliveryOutController;
use App\Http\Controllers\DeliveryTypeController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\MeasurementTypeController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\UserController;
use App\Models\DeliveryType;
use App\Models\ProductCategory;
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

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('admin.dashboard');
// })->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    });
    
    Route::resource('dashboard', DashboardController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profiles', [ProfileController::class, 'userProfile'])->name('profile');
    Route::post('/profile/update-password', [ProfileController::class, 'changePassword'])->name('password.update');
    Route::post('/profile/update-profile', [ProfileController::class, 'changeProfile'])->name('profiles.update');


    Route::resource('delivery-in', DeliveryInController::class);
    Route::get('deliveryCsv', [DeliveryInController::class, 'csv']);
    Route::get('deliveryOutCsv', [DeliveryOutController::class, 'csv']);
    Route::controller(DeliveryInController::class)->group(function () {

        Route::get('delivery-in/{id}/delete', 'destroy')->name('delivery-in.destroy');
        Route::get('delivery-in/edit/{id}', 'edit')->name('delivery-in.edit');
        Route::post('delivery-in/update/{id}', 'update')->name('delivery-in.update');

     });
    Route::resource('delivery-out', DeliveryOutController::class);
    Route::controller(DeliveryOutController::class)->group(function () {

        Route::get('delivery-out/{id}/delete', 'destroy')->name('delivery-out.destroy');
        Route::get('delivery-out/edit/{id}', 'edit')->name('delivery-out.edit');
        Route::post('delivery-out/update/{id}', 'update')->name('delivery-out.update');

     });
    Route::resource('production-setup', ProductionSetupController::class);
    Route::controller(ProductionSetupController::class)->group(function () {

        // Route::get('production-setup/{id}/delete', 'destroy')->name('production-setup.destroy');
        // Route::get('production-setup/edit/{id}', 'edit')->name('production-setup.edit');
        // Route::post('production-setup/update/{id}', 'update')->name('production-setup.update');

     });

    Route::resource('productions', ProductionController::class);
    Route::get('productionCsv', [ProductionController::class, 'csv']);
    Route::controller(ProductionController::class)->group(function () {

        Route::get('productions/{id}/delete', 'destroy')->name('productions.destroy');
        Route::get('productions/edit/{id}', 'edit')->name('productions.edit');
        Route::post('productions/update/{id}', 'update')->name('productions.update');

     });
    Route::resource('cases', CaseController::class);
    Route::controller(CaseController::class)->group(function () {
        Route::get('cases/{id}/delete', 'destroy')->name('cases.destroy');
        Route::get('cases/edit/{id}', 'edit')->name('cases.edit');
        Route::post('cases/update/{id}', 'update')->name('cases.update');

     });
    Route::resource('measurement-types', MeasurementTypeController::class);
    Route::controller(MeasurementTypeController::class)->group(function () {

        // Route::get('cash/{id}/delete', 'destroy')->name('cash.destroy');
        // Route::get('cash/edit/{id}', 'edit')->name('cash.edit');
        // Route::post('cash/update/{id}', 'update')->name('cash.update');

     });
    Route::resource('tables', TableController::class);
    Route::controller(TableController::class)->group(function () {

        Route::get('tables/{id}/delete', 'destroy')->name('tables.destroy');
        Route::get('tables/edit/{id}', 'edit')->name('tables.edit');
        Route::post('tables/update/{id}', 'update')->name('tables.update');

     });
    Route::resource('grades', GradeController::class);
    Route::controller(GradeController::class)->group(function () {

        Route::get('grades/{id}/delete', 'destroy')->name('grades.destroy');
        Route::get('grades/edit/{id}', 'edit')->name('grades.edit');
        Route::post('grades/update/{id}', 'update')->name('grades.update');

     });
    Route::resource('product-categories', ProductCategoryController::class);
    Route::controller(ProductCategoryController::class)->group(function () {

        Route::get('product-categories/{id}/delete', 'destroy')->name('product-categories.destroy');
        Route::get('product-categories/edit/{id}', 'edit')->name('product-categories.edit');
        Route::post('product-categories/update/{id}', 'update')->name('product-categories.update');

     });
    Route::resource('delivery-types', DeliveryTypeController::class);
    Route::controller(DeliveryTypeController::class)->group(function () {

        Route::get('delivery-types/{id}/delete', 'destroy')->name('delivery-types.destroy');
        Route::get('delivery-types/edit/{id}', 'edit')->name('delivery-types.edit');
        Route::post('delivery-types/update/{id}', 'update')->name('delivery-types.update');

     });
    Route::resource('customers', CustomerController::class);
    Route::controller(CustomerController::class)->group(function () {

        Route::get('customers/{id}/delete', 'destroy')->name('customers.destroy');
        Route::get('customers/edit/{id}', 'edit')->name('customers.edit');
        Route::post('customers/update/{id}', 'update')->name('customers.update');

     });
    Route::resource('suppliers', SupplierController::class);
    Route::controller(SupplierController::class)->group(function () {
        Route::get('suppliers/{id}/delete', 'destroy')->name('suppliers.destroy');
        Route::get('suppliers/edit/{id}', 'edit')->name('suppliers.edit');
        Route::post('suppliers/update/{id}', 'update')->name('suppliers.update');
     });
    Route::resource('users', UserController::class);
    Route::controller(UserController::class)->group(function () {

        Route::get('users/{id}/delete', 'destroy')->name('users.destroy');
        Route::get('users/edit/{id}', 'edit')->name('users.edit');
        Route::post('users/update/{id}', 'update')->name('users.update');

     });
    Route::resource('attendances', AttendanceController::class);
    Route::controller(AttendanceController::class)->group(function () {
        Route::get('/export-attendance', 'export')->name('export-attn');
        Route::get('/attndata', 'getData')->name('attn');
        Route::get('attendances/edit/{id}', 'edit')->name('attendances.edit');
         Route::post('attendances/update/{id}', 'update')->name('attendances.update');

    });


    Route::get('/report/delivery_in', [ReportController::class, 'deliveryIn']);
    Route::post('/report/delivery_in', [ReportController::class, 'deliveryIn']);

    Route::get('/report/delivery_out', [ReportController::class, 'deliveryOut']);
    Route::post('/report/delivery_out', [ReportController::class, 'deliveryOut']);

    Route::get('/report/production', [ReportController::class, 'production']);
    Route::post('/report/production', [ReportController::class, 'production']);

    Route::get('/report/supplier', [ReportController::class, 'supplier']);
    Route::post('/report/supplier', [ReportController::class, 'supplier']);

    Route::get('/report/customer', [ReportController::class, 'customer']);
    Route::post('/report/customer', [ReportController::class, 'customer']);

    Route::post('/stock/delivery_in', [StockController::class, 'deliveryIn']);
    Route::get('/stock/delivery_in', [StockController::class, 'deliveryIn']);

    Route::post('/stock/delivery_out', [StockController::class, 'deliveryOut']);
    Route::get('/stock/delivery_out', [StockController::class, 'deliveryOut']);


    Route::post('/stock', [StockController::class, 'deliveryStock']);
    Route::get('/stock', [StockController::class, 'deliveryStock']);

});

require __DIR__.'/auth.php';
