<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Size;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductAdminController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index() {
    $products = Product::with(["size"])->get();
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
    $origin = DB::table("origin")->get(); //ini diperlukan agar kita dapat menentukan produk tersebut dari mana, karena ongkir berbeda - beda
    
    return view("admin.product.create", [
      "origin" => $origin
    ]);
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request) {   
    //Validasi semuanya terlebih dahulu
    $cradentials = Validator::make($request->all(), 
    [
      "name" => "required|max:225",
      "kelompok" => "required",
      "slug" => "required|max:225|unique:products",
      "stok" => "required|numeric",
      "gambar" => "image|file|max:1024",
      "origin" => "required|numeric",
      "deskripsi" => "required",
      "body" => "required",
      "active" => "required"
    ]);
    if ($cradentials->fails()) {
      return redirect('/metal/products/create')
      ->withErrors($cradentials)
      ->withInput();
    }
    //tambahkan gambar yang sudah terkena validasi
    $validated = $cradentials->validated();
    if($request->file("gambar")) {
      $validated["gambar"] = $request->file("gambar")->store("product");//nantinya gambar tersebut akan disimpan pada storage dengan folder product
    }
    //Ubah deskripsi dan body karaen mereka mengandung html
    $validated["deskripsi"] = htmlspecialchars($validated["deskripsi"]);
    $validated["body"] = htmlspecialchars($validated["body"]);

    Product::create($validated);
    $fetchLagi = Product::firstWhere("slug", $validated["slug"]);
    
    for($i = 0; $i < count($request["size_name"]); $i++ ) {
      Size::create([
        "product_id" => $fetchLagi->id,
        "name" => $request["size_name"][$i],
        "weight" => $request["size_weight"][$i],
        "price" => $request["size_price"][$i],
        "old_price" => $request["old_price"][$i]
      ]);
    }

    //variant bersifat opsional
    if(isset($request["variant_name"])) {
      for($i =0; $i < count($request["variant_name"]); $i++) {
        Variant::create([
          "product_id" => $fetchLagi->id,
          "name" => $request["variant_name"][$i]
        ]);
      }
    }

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
    $product->load(["size","variant","productGallery"]);
    $product["deskripsi"] = htmlspecialchars_decode($product["deskripsi"]);
    $product["body"] = htmlspecialchars_decode($product["body"]);
    $origin = DB::table("origin")->get();

    //1. ambil gambar dari storage
    $test = Storage::url($product->productGallery[0]->gambar);
   
    return view("admin.product.edit", [
      "product" => $product,
      "origin" => $origin,
      "test" => "http://localhost:8000/storage/origin-produk/carousel/Capture.PNG"
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
      "gambar" => "image|file|max:1024",
      "origin" => "required|numeric",
      "deskripsi" => "required",
      "body" => "required"
      
    ];
    //berarti tida pengen ganti
    if ($product->slug != $request->slug) {
      $rules["slug"] = "required|max:225|unique:products";
    }
    
    $cradentials = $request->validate($rules);

    if($request->file("gambar")) {
      Storage::delete($product->gambar);
      $cradentials["gambar"] = $request->file("gambar")->store("product");
    }
    Product::where("id", $product->id)->update($cradentials);

    Size::whereNotIn("id",$request["size_id"])->delete();//Size yang ada didatabase yang tidak memiliki pasangan request kita hapus

    for($i = 0; $i < count($request["size_name"]); $i++) {
      $data_size = [
      "product_id" => $product->id,
      "name" =>$request["size_name"][$i],
      "weight" => $request["size_weight"][$i], 
      "price"=> $request["size_price"][$i], 
      "old_price" => $request["old_price"][$i]
    ];

      Size::updateOrInsert(["id" => $request["size_id"][$i]], $data_size);
       //id yang ditambahkan di javascript adalah 0, sedangkan didatabase tidak mungkin 0, jadi tidak mungkin ada id 0, sehingga data_size adalah ber id 0, dikarenakan tidak ada di database dengan id 0, maka akan dibuat data baru
      
    }

    Variant::whereNotIn("id", $request["variant_id"])->delete();

    for($i = 0; $i < count($request["variant_name"]); $i++) {

      $data_variant = [
        "product_id" => $product->id,
        "name" => $request["variant_name"][$i]
      ];
      Variant::updateOrInsert(["id" => $request["variant_id"][$i]], $data_variant);
    }

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
    return redirect("/metal/products")->with("success", "Produk Telah dihapus");
  }
}