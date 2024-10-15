<?php

use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DeliveryInController;
use App\Http\Controllers\Api\DeliveryInTransactionController;
use App\Http\Controllers\Api\DeliveryOutController;
use App\Http\Controllers\Api\DeliveryOutTransactionController;
use App\Http\Controllers\Api\DeliveryTypeController;
use App\Http\Controllers\Api\GradeController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\ProductionController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SupplierController;
use App\Models\DeliveryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::controller(AuthController::class)->group(function(){
    //Route::post('register', 'register');
    Route::post('/auth/login', 'loginUser');
    Route::post('/reset-pwd', 'resetPassword');
    Route::post('/auth/change-password', 'changePassword');
   // Route::post('/auth/change-password', 'changePassword');
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware('auth:sanctum')->group( function () {
    Route::resource('din', DeliveryInController::class);
    Route::resource('delivery-type', DeliveryTypeController::class);
    Route::resource('product-category', ProductCategoryController::class);
    Route::resource('grade', GradeController::class);
    Route::resource('profile', ProfileController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('customer', CustomerController::class);
    Route::resource('delivery-in-transaction', DeliveryInTransactionController::class);
    Route::controller(DeliveryInTransactionController::class)->group(function(){
        // //Route::post('register', 'register');
        // Route::get('/transactions', 'allTransactions');
        // Route::get('/transaction/{id}', 'showTransaction');
        Route::get('/transaction-by-deliveryin/{id}', 'showTransactionByDeliveryIn');

    });
    Route::resource('dout', DeliveryOutController::class);
    Route::resource('delivery-out-transaction', DeliveryOutTransactionController::class);
    Route::controller(DeliveryOutTransactionController::class)->group(function(){
        // //Route::post('register', 'register');
        // Route::get('/transactions', 'allTransactions');
        // Route::get('/transaction/{id}', 'showTransaction');
        Route::get('/transaction-by-deliveryout/{id}', 'showTransactionByDeliveryOut');

    });
    Route::controller(ProfileController::class)->group(function(){
        Route::post('update-info', 'updateProfile');
        Route::get('/users', 'allStaffs');
        Route::get('/user-list', 'allUsers');
       // Route::get('/transaction/{id}', 'showTransaction');
    });
    Route::resource('production', ProductionController::class);
    Route::controller(ProductionController::class)->group(function(){
        //Route::post('register', 'register');

        Route::post('/prduction-create', 'productionStore');
        Route::get('/transactions', 'allTransactions');
        Route::get('/cases', 'allCases');
        Route::get('/tables', 'allTables');
        Route::get('/measurements', 'allMeasurements');
        Route::get('/transaction/{id}', 'showTransaction');
        Route::get('/transaction-by-production/{pid}', 'showTransactionByProduction');

    });
    Route::resource('attendance', AttendanceController::class);
    Route::controller(AttendanceController::class)->group(function(){
        //Route::post('register', 'register');
        Route::post('/checkin', 'storeCheckIn');
        Route::post('/checkout', 'storeCheckOut');

    });
   // Route::resource('pr-transaction', ProductionController::class);
});

//Route::post('/auth/login', [AuthController::class, 'loginUser']);
