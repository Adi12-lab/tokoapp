<?php

use App\Models\Product;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;

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
  return view("index", [
    "products" => Product::all()
  ]);
});

Route::get("/produk", [ProductController::class, "index"]);

Route::controller(CartController::class)->group(function() {
  Route::post("/addCart", "addCart")->name("productIndex.addCart");
  Route::get("/cart", "cartContent");
  Route::post("/deleteCart", "deleteCart");
  Route::post("/degQuantity", "degQuantity");
  Route::post("/incQuantity", "incQuantity");
});

Route::controller(UserController::class)->group(function() {
  Route::get("/metal", "login")->name("login");
  Route::post("/metal", "authenticate")->name("authenticate");
  Route::get("/dashboard", "index")->middleware("auth");
  Route::post("/dashboard", "logout")->name("logout");
});