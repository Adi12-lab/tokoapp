<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use Cart;

class ProductController extends Controller
{
  public function index(Request $request) {
    $products = Product::with(["size", "variant"])->get();
    for ($i = 0; $i < count($products); $i++) {
      $products[$i]["deskripsi"] = htmlspecialchars_decode($products[$i]["deskripsi"]);
    }
    
    return view("product", [
      "products" => $products,
    ]);
  }
  public function detail($slug) {
    $product = Product::firstWhere("slug", $slug);
    $product["deskripsi"] = htmlspecialchars_decode($product["deskripsi"]);
    
    $product["body"] = htmlspecialchars_decode($product["body"]);
    
    return view("detailProduct", [
      "product" => $product,
    ]);
  }
}