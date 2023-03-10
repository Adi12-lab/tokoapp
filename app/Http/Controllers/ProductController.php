<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Colour;
use Cart;

class ProductController extends Controller
{
  public function index(Request $request) {
    $products = Product::with(["size", "variant"])->get();
    $countCart = Cart::getContent()->count();
    for ($i = 0; $i < count($products); $i++) {
      $products[$i]["deskripsi"] = htmlspecialchars_decode($products[$i]["deskripsi"]);
    }
    
    return view("product", [
      "products" => $products,
      "countCart" => $countCart
    ]);
  }
  public function detail($slug) {
    $product = Product::firstWhere("slug", $slug);
    $product["deskripsi"] = htmlspecialchars_decode($product["deskripsi"]);
    
    $product["body"] = htmlspecialchars_decode($product["body"]);
    
    return view("detailProduct", [
      "product" => $product,
      "countCart" => \Cart::getContent()->count()
    ]);
  }
}