<?php

use App\Models\Product;
use App\Models\Size;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductAdminController;
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
});

Route::get("/produk", [ProductController::class, "index"]);
Route::get("/produk/{slug}", [ProductController::class, "detail"]);
Route::controller(CartController::class)->group(function() {
  Route::post("/addCart", "addCart")->name("productIndex.addCart");
  Route::get("/cart", "cartContent");
  Route::post("/deleteCart", "deleteCart");
  Route::post("/updateCart", "updateCart");
  Route::get("/testCart", "testCart");
  
});

Route::controller(UserController::class)->group(function() {
  Route::get("/metal", "login")->name("login");
  Route::post("/metal/dashboard", "authenticate")->name("authenticate");
  Route::get("/metal/dashboard", "index")->middleware("auth");
  Route::post("/metal", "logout")->name("logout");

});

Route::resource("/metal/products", ProductAdminController::class)->middleware("auth");

Route::get("/metal/products/{slug}/size",function(Product $slug){
  return view("admin.sizeProduct", [
    "product" => $slug
    ]);
});
Route::post("/metal/products/size", function(Request $request ){
  Size::insert([
    "product_id" => $request->productId,
    "name" => $request->size,
    "price" => $request->price,
    "old_price" => $request->old_price
    ]);
    return back()->with("success", "Size baru sudah ditambahkan");
});
Route::post("/metal/products/size/update", function(Request $request) {

  Size::find($request->sizeId)->update([
    "name" => $request->size,
    "price"  => $request->price,
    "old_price" => $request->old_price
    
    ]);
  return back()->with("success", "Size telah diupdate");
});
