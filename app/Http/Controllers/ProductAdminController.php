<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductAdminController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index() {
    $products = Product::all();
    foreach ($products as $product) {
      $product->deskripsi = htmlspecialchars_decode($product->deskripsi);
    }
    return view("admin.product.index", [
      "products" => $products
    ]);
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create() {
    return view("admin.product.create");
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request) {

    $cradentials = Validator::make($request->all(), [
      "name" => "required|max:225",
      "kelompok" => "required",
      "slug" => "required|max:225|unique:products",
      "stok" => "required|numeric",
      "gambar" => "image|file|max:1024",
      "price" => "required|numeric",
      "deskripsi" => "required",
      "body" => "required"
    ]);
    if ($cradentials->fails()) {
      return redirect('/metal/products/create')
      ->withErrors($cradentials)
      ->withInput();
    }
    $validated = $cradentials->validated();
    if($request->file("image")) {
      $validated["gambar"] = $request->file("image")->store("product");
    }
    $validated["deskripsi"] = htmlspecialchars($validated["deskripsi"]);
    $validated["body"] = htmlspecialchars($validated["body"]);

    Product::create($validated);
    $fetchLagi = Product::firstWhere("slug", $validated["slug"]);
    Size::insert([
      "product_id" => $fetchLagi->id,
      "price" => $request->price
    ]);


    return redirect("/metal/products")->with("success", "Produk Anda Telah berhasil ditambahkan");
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Models\Product  $product
  * @return \Illuminate\Http\Response
  */
  public function show(Product $product) {
    //Langsung diquery
    return redirect("/produk");
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Models\Product  $product
  * @return \Illuminate\Http\Response
  */
  public function edit(Product $product) {
    $product["deskripsi"] = htmlspecialchars_decode($product["deskripsi"]);
    $product["body"] = htmlspecialchars_decode($product["body"]);
    return view("admin.product.edit", [
      "product" => $product
    ]);
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Models\Product  $product
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Product $product) {
    $rules = [
      "name" => "required|max:225",
      "kelompok" => "required",
      "stok" => "required|numeric",
      "image" => "image|file|max:1024",
      "deskripsi" => "required",
      "body" => "required"
    ];
    if ($product->slug != $request->slug) {
      $rules["slug"] = "required|max:225|unique:products";
    }
    $cradentials = $request->validate($rules);
    
    Product::where("id", $product->id)->update($cradentials);

    return redirect("/metal/products")->with("success", "Produk Anda Telah berhasil diperbarui");
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Models\Product  $product
  * @return \Illuminate\Http\Response
  */
  public function destroy(Product $product) {
    Product::destroy($product->id);
    Size::where("product_id", $product->id)->delete();
    return redirect("/metal/products")->with("success", "Produk Telah dihapus");
  }
}