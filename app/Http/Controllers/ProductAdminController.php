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
    
    //size harus ada, boleh tidak ada namannya !! tapi harus ada harga
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
    // dd($product->size);
    $product["deskripsi"] = htmlspecialchars_decode($product["deskripsi"]);
    $product["body"] = htmlspecialchars_decode($product["body"]);
    $origin = DB::table("origin")->get();

    //1. ambil gambar dari storage
    $hidden_carousel = Storage::allFiles("$product->slug/carousel");
    $hidden_gallery = Storage::allFiles("$product->slug/gallery");

    return view("admin.product.edit", [
      "product" => $product,
      "origin" => $origin,
      "hidden_carousel" => $hidden_carousel,
      "hidden_gallery" => $hidden_gallery
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
    // dd($request->all());
    $rules = [
      "name" => "required|max:225",
      "kelompok" => "required",
      "stok" => "required|numeric",
      "gambar" => "image|file|max:1024",
      "origin" => "required|numeric",
      "deskripsi" => "required",
      "body" => "required",
      "active_status" => 'required'
      
    ];
    //berarti tida pengen ganti
    if ($product->slug != $request->slug) {
      $rules["slug"] = "required|max:225|unique:products";
    }
    $cradentials = $request->validate($rules);
    $updateProduct = Product::find($product->id);


    $updateProduct->setIsUpdating(true);
    $updateProduct->name = $cradentials['name'];
    $updateProduct->kelompok = $cradentials['kelompok'];
    $updateProduct->stok = $cradentials['stok'];
    if($request->file("gambar")) {
      Storage::delete($product->gambar); //hapus gambar yang lama
      $cradentials["gambar"] = $request->file("gambar")->store("product");
      $updateProduct->gambar = $cradentials['gambar'];
    }
    $updateProduct->origin = $cradentials['origin'];
    $updateProduct->deskripsi = $cradentials['deskripsi'];
    $updateProduct->body = $cradentials['body'];
    $updateProduct->active = $cradentials["active_status"];
    //kita update carousel dan gallerynya
    $updateProduct->save();

    Size::where('product_id', $product->id)->whereNotIn("id",$request["size_id"])->delete();//Size yang ada didatabase yang tidak memiliki pasangan request kita hapus
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
    if(isset($request["variant_name"])) {
      Variant::where("product_id", $product->id)->whereNotIn("id", $request["variant_id"])->delete();
      for($i = 0; $i < count($request["variant_name"]); $i++) {
  
        $data_variant = [
          "product_id" => $product->id,
          "name" => $request["variant_name"][$i]
        ];
        Variant::updateOrInsert(["id" => $request["variant_id"][$i]], $data_variant);
      }
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