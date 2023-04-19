<?php

use App\Models\Product;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductAdminController;
use App\Http\Controllers\RajaOngkirController;
use App\Http\Controllers\AttachmentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!

*/

Route::get('/', function () {
  return view("index", [
    "products" => Product::all(),
    "countCart" => \Cart::getContent()->count()
  ]);
})->name("home");

Route::get("/produk", [ProductController::class, "index"])->name("produk");
Route::get("/produk/{slug}", [ProductController::class, "detail"])->name("produk.name");
Route::controller(CartController::class)->group(function() {
  Route::post("/addCart", "addCart")->name("productIndex.addCart");
  Route::get("/cart", "cartContent")->name("cart");
  Route::get("/deleteCart", "deleteCart");
  Route::post("/updateCart", "updateCart");
  Route::get("/clearCart", "clearCart");
  Route::get("/testCart", "testCart");
});

Route::controller(UserController::class)->group(function() {
  Route::get("/metal", "login")->name("login");
  Route::post("/metal/dashboard", "authenticate")->name("authenticate");
  Route::get("/metal/dashboard", "index")->middleware("auth");
  Route::post("/metal", "logout")->name("logout");

});

Route::controller(RajaOngkirController::class)->group(function() {
  Route::get("/getProvince", "get_province");
  Route::get("/getCity", "get_city");
});

Route::resource("/metal/products", ProductAdminController::class)->middleware("auth");

Route::get("/metal/testRequest", function() {
  return view("testRequest");
});
Route::post("/metal/testRequest", function(Request $request) {
  dd($request->all());
});

//Menangani attachment dari 
Route::controller(AttachmentController::class)->group(function() {
  Route::post("/toPending", "toPending" );
  Route::post("/removeFromPending", "removeFromPending");
  Route::post("/removeFromStorage", "removeFromStorage");
});
