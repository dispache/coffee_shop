<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, HomeController, OrderController, PointController, ReviewController, ProductController, ProfileController, RajaOngkirController, TransactionController};

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

Route::middleware(['alreadyLogin'])->group(function () {
    
    Route::get('/', function () {
        return view('landing.index', [
            "title" => "Landing",
        ]);
    });

    Route::get('/{url}', [AuthController::class, "loginGet"])->where(["url" => "auth|auth/login"])->name("auth");
    Route::post('/auth/login', [AuthController::class, "loginPost"]);
    Route::post('/auth/logout', [AuthController::class, "logoutPost"]);

    Route::get('/auth/register', [AuthController::class, "registrationGet"]);
    Route::post('/auth/register', [AuthController::class, "registrationPost"]);
});

Route::middleware(['auth'])->group(function () {

    Route::controller(HomeController::class)->group(function () {
        Route::get("/home", "index");
        Route::get("/home/customers", "customers");
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get("/profile/my_profile", "myProfile");
        Route::get("/profile/edit_profile", "editProfileGet");
        Route::post("/profile/edit_profile/{user:id}", "editProfilePost");
        Route::get("/profile/change_password", "changePasswordGet");
        Route::post("/profile/change_password", "changePasswordPost");
    });

    Route::controller(ProductController::class)->group(function () {
        Route::get("/product", "index");
        Route::get("/product/data/{id}", "getProductData");

        Route::get("/product/add_product", "addProductGet")->can("add_product", App\Models\Product::class);
        Route::post("/product/add_product", "addProductPost")->can("add_product", App\Models\Product::class);
        Route::get("/product/edit_product/{product:id}", "editProductGet")->can("edit_product", App\Models\Product::class);
        Route::post("/product/edit_product/{product:id}", "editProductPost")->can("edit_product", App\Models\Product::class);
    });

    Route::controller(OrderController::class)->group(function () {
        Route::get("/order/order_data", "orderData");
        Route::get("/order/order_history", "orderHistory");
        Route::get("/order/order_data/{status_id}", "orderDataFilter");
        Route::get("/order/data/{order}", "getOrderData")->can("my_real_order", "order");
        Route::get("/order/getProof/{order}", "getProofOrder")->can("my_real_order", "order");

        Route::get("/order/make_order/{product:id}", "makeOrderGet")->can("create_order", App\Models\Order::class);
        Route::post("/order/make_order/{product:id}", "makeOrderPost")->can("create_order", App\Models\Order::class);
        Route::get("/order/edit_order/{order}", "editOrderGet")->can("edit_order", "order");
        Route::post("/order/edit_order/{order}", "editOrderPost")->can("edit_order", "order");
        Route::get("/order/delete_proof/{order}", "deleteProof")->can("delete_proof", "order");
        Route::post("/order/cancel_order/{order}", "cancelOrder")->can("cancel_order", "order");
        Route::post("/order/upload_proof/{order}", "uploadProof")->can("upload_proof", "order");

        Route::post("/order/reject_order/{order}/{product}", "rejectOrder")->can("reject_order", App\Models\Order::class);
        Route::post("/order/end_order/{order}/{product}", "endOrder")->can("end_order", App\Models\Order::class);
        Route::post("/order/approve_order/{order}/{product}", "approveOrder")->can("approve_order", App\Models\Order::class);
    });

    Route::controller(ReviewController::class)->group(function () {
        Route::get("/review/product/{product}", "productReview");
        Route::get("/review/data/{review}", "getDataReview");
        Route::post("/review/add_review/", "addReview");
        Route::post("/review/edit_review/{review}", "editReview")->can("edit_review", "review");
        Route::post("/review/delete_review/{review}", "deleteReview")->can("delete_review", "review");
    });

    Route::controller(TransactionController::class)->group(function () {
        Route::get("/transaction", "index")->can("is_admin");
        Route::get("/transaction/add_outcome", "addOutcomeGet")->can("is_admin");
        Route::post("/transaction/add_outcome", "addOutcomePost")->can("is_admin");
        Route::get("/transaction/edit_outcome/{transaction}", "editOutcomeGet")->can("is_admin");
        Route::post("/transaction/edit_outcome/{transaction}", "editOutcomePost")->can("is_admin");
    });

    Route::controller(PointController::class)->group(function () {
        Route::get("/point/user_point", "user_point")->can("user_point", App\Models\User::class);
        Route::post("/point/convert_point", "convert_point")->can("convert_point", App\Models\User::class);
    });

});
