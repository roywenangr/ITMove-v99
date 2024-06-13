<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReqTripController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ManagementTourController;
use App\Http\Controllers\PaymentHistoryController;

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

Route::get('/', [HomeController::class, 'index'])->name("home");
Route::get('/about', [HomeController::class, 'about'])->name("about");
Route::get('/guide', [HomeController::class,'guide'])->name("guide");



// Toure Route
Route::get('/tour/detail/{id}', [TourController::class, 'detail'])->name("tour.detail");
Route::get('/tour', [TourController::class, 'index'])->name("tour.index");
Route::post('/tour/filter', [TourController::class, 'filter'])->name("tour.filter");

//payment status
Route::get('/payment/status/invoice/{orderId}', [CartController::class, 'paymentStatus'])->name('payment.paymentStatus');



Route::group(['middleware' => ['auth', 'user', 'verified']], function () {

    //cart Route
    Route::get('/cart/{id}', [CartController::class, 'cart'])->name("cart");
    Route::post('/cart/add/{tour}/{qty}', [CartController::class, 'store'])->name("cart.add");
    Route::post('/cart/update/{id}/{qty}', [CartController::class, 'update'])->name("cart.update");
    Route::delete('/cart/delete/{id}', [CartController::class, 'hapus'])->name("cart.delete");

    //request Trip Route
    Route::get('/requestTrip', [ReqTripController::class, 'index'])->name("requestTrip");
    Route::post('/requestTrip', [ReqTripController::class, 'store'])->name("requestTrip.store");
    Route::get('/inbox', [ReqTripController::class, 'inbox'])->name('inbox');

    Route::post('/checkout', [CartController::class, 'checkout'])->name("checkout");
    Route::post('/checkout/alone', [CartController::class, 'checkoutAlone'])->name("checkout.alone");

    Route::get('/checkout/invoice/{trx_id}', [CartController::class, 'invoice'])->name("checkout.invoice");
});


Route::group(['middleware' => ['auth', 'admin']], function () {

    Route::get('/admin/province', [ProvinceController::class, 'showAdmin'])->name("manage.province");
    Route::post('/admin/province', [ProvinceController::class,'store'])->name("manage.province.store");
    Route::get('/admin/province/getData', [ProvinceController::class, 'getData'])->name("manage.province.getData");
    Route::put('/admin/province/updateData/{id}', [ProvinceController::class, 'updateData'])->name("manage.province.updateData");
    Route::delete('/admin/province/deleteData/{id}', [ProvinceController::class, 'deleteData'])->name("manage.province.deleteData");


    Route::get('/admin/destination', [DestinationController::class, 'showAdmin'])->name("manage.destination");
    Route::post('/admin/destination', [DestinationController::class, 'store'])->name("manage.destination.store");
    Route::get('/admin/destination/getData', [DestinationController::class, 'getData'])->name("manage.destination.getData");
    Route::put('/admin/destination/updateData/{id}', [DestinationController::class, 'updateData'])->name("manage.destination.updateData");
    Route::delete('/admin/destination/{id}', [DestinationController::class, 'deleteData'])->name("manage.destination.deleteData");


    Route::get('/admin/tour', [ManagementTourController::class, 'showAdmin'])->name("manage.tour");
    Route::post('/admin/tour', [ManagementTourController::class, 'store'])->name("manage.tour.store");
    Route::get('/admin/tour/getData', [ManagementTourController::class, 'getData'])->name("manage.tour.getData");
    Route::get('/admin/tour/getData/{id}', [ManagementTourController::class, 'getDataById'])->name("manage.tour.getDataById");
    Route::put('/admin/tour/updateData/{id}', [ManagementTourController::class, 'updateData'])->name("manage.tour.updateData");
    Route::delete('/admin/tour/{id}', [ManagementTourController::class, 'deleteData'])->name("manage.tour.deleteData");


    Route::get('/admin/userManagement', [UserController::class, 'showAdmin'])->name("manage.user");
    Route::put('/admin/userManagement/{id}', [UserController::class, 'updateData'])->name("manage.user.updateData");

    Route::get('/admin/inbox', [ReqTripController::class, 'adminInbox'])->name("manage.adminInbox");
    Route::post('/admin/inbox/status/{info}', [ReqTripController::class, 'creatInvoice'])->name("manage.creatInvoice");

});


Route::middleware('auth')->group(function () {
    Route::get('/api/inbox/all', [ReqTripController::class, 'apiInboxAll'])->name('inbox.apiInboxAll');
    Route::get('/api/admin/inbox/all', [ReqTripController::class, 'adminApiInboxAll'])->name('inbox.admin.apiInboxAll');

    Route::get('/get-places/{provinceId}',[PlaceController::class, 'getPlaces'])->name('get-places');
    Route::get('/payment', [PaymentHistoryController::class, 'index'])->name('payment.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
