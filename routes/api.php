<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\PlaceController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\HotelController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\GuideController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\UserBookingController;
use App\Http\Controllers\User\CommentController;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => ['auth:sanctum']],function() {

});

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::post('password/email', ForgotPasswordController::class);
Route::post('password/code/check', ResetPasswordController::class);


Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum','admin']], function () {

    Route::group(['prefix' => 'place'],function () {
       Route::post('/',[PlaceController::class,'store']);
       Route::get('/',[PlaceController::class,'index']);
       Route::get('/{id}',[PlaceController::class,'show']);
       Route::post('/{id}',[PlaceController::class,'update']);
       Route::delete('/{id}',[PlaceController::class,'destroy']);
    });

    Route::group(['prefix' => 'packages'],function () {
        Route::post('/',[PackageController::class,'store']);
        Route::get('/',[PackageController::class,'index']);
        Route::get('/{package}',[PackageController::class,'show']);
        Route::post('/{id}',[PackageController::class,'update']);
        Route::delete('/{id}',[PackageController::class,'destroy']);
    });

    Route::group(['prefix' => 'hotel'],function () {
        Route::post('/',[HotelController::class,'store']);
        Route::get('/',[HotelController::class,'index']);
        Route::get('/{id}',[HotelController::class,'show']);
        Route::post('/{id}',[HotelController::class,'update']);
        Route::delete('/{id}',[HotelController::class,'destroy']);
    });

    Route::group(['prefix' => 'booking'],function () {
        Route::get('booking-request/list',[BookingController::class,'pendingBookingList']);
        Route::post('booking-request/approve/{id}',[BookingController::class,'bookingApprove']);
        Route::post('booking-request/remove/{id}',[BookingController::class,'bookingRemoveByAdmin']);
        Route::get('running/packages',[BookingController::class,'runningPackage']);
        Route::post('running/package/complete/{id}',[BookingController::class,'runningPackageComplete']);
    });

    Route::group(['prefix' => 'users'],function () {
        Route::get('/userslist',[UserController::class,'index']);
        Route::get('/adminslist',[UserController::class,'adminList']);
        Route::get('/{id}',[UserController::class,'show']);
        Route::delete('/{id}', [UserController::class, 'block']);
    });

    Route::group(['prefix' => 'guiders'],function () {
        Route::post('/',[GuideController::class,'store']);
    });

});

Route::group(['prefix' => 'user', 'middleware' => ['auth:sanctum','user']], function () {
    Route::get('/',[DashboardController::class,'index']);

    Route::get('profile-info',[DashboardController::class,'showProfile']);
    Route::post('profile-info/update',[DashboardController::class,'updateProfile']);

    Route::group(['prefix' => 'places'],function () {
        Route::get('/',[DashboardController::class,'getPlaces']);
        Route::get('/details/{id}',[DashboardController::class,'getPlaceDetails']);
        Route::get('/country/{id}',[DashboardController::class,'getPlaceByCountry']);
    });

    Route::group(['prefix' => 'hotels'],function () {
        Route::get('/',[DashboardController::class,'getHotels']);
        Route::get('/details/{id}',[DashboardController::class,'getHotelDetails']);
        Route::get('/country/{id}',[DashboardController::class,'getHotelByCountry']);
    });

    Route::group(['prefix' => 'packages'],function () {
        Route::get('/',[DashboardController::class,'getPackage']);
        Route::get('/details/{id}',[DashboardController::class,'getPackageDetails']);
        Route::get('/country/{id}',[DashboardController::class,'getPackageByCountry']);
    });

    Route::group(['prefix' => 'bookings'],function () {
        Route::get('tour-history/list',[UserBookingController::class,'tourHistory']);
        Route::get('booking-request/list',[UserBookingController::class,'pendingBookingList']);
        Route::post('booking-request/cancel/{id}',[UserBookingController::class,'cancelBookingRequest']);
        Route::post('package/{id}',[UserBookingController::class,'bookPackage']);
    });

    Route::group(['prefix' => 'comments'],function () {
        Route::post('/',[CommentController::class,'store']);
        Route::get('/package/{package}',[CommentController::class,'index']);
        Route::get('/{comment}',[CommentController::class,'show']);
        Route::post('/{id}',[CommentController::class,'update']);
        Route::delete('/{id}',[CommentController::class,'destroy']);
    });

    Route::post('/pay/package/{id}',[PaymentController::class,'payPackage']);
    Route::get('logout', [AuthController::class, 'logout']);
});

Route::get('getGuide/{id}',[GuideController::class,'show']);
