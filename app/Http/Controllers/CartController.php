<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Alert;
use App\Http\Controllers\RajaOngkirController;
use Illuminate\Support\Facades\DB;
use PDO;

class CartController extends Controller
{
  public function addCart(Request $request) {

    $all = $request->all();
    $cartId = intval($all["id"]);
    $productSize = $all["size"];
    $productVariant = $all["variant"];
    $productPrice = intval($all["price"]);
    $productQuantity = intval($all["quantity"]);
    $productWeight = intval($all["weight"]);
    $productName = $all["name"];

  

    $allCart = \Cart::getContent()->where("name", $productName);
    if ($productSize == "undefined") $productSize = null;
    if ($productVariant == "undefined") $productVariant = null;

    $queryAdd = [
      "name" => $productName,
      "price" => $productPrice,
      "quantity" => $productQuantity,
      'attributes' => array(
        "size" => $productSize,
        "variant" => $productVariant,
        "weight" => $productWeight
      )];
    if ($allCart->isNotEmpty()) {
      foreach ($allCart as $cart) {
        if ($cart->attributes->size == $productSize && $cart->attributes->variant == $productVariant) { //dicek apakah ada yang sama atau tidak
          $queryAdd["id"] = $cart->id;
        } else {
          $queryAdd["id"] = $cartId;
        }
      }
    } else {
      $queryAdd["id"] = $cartId;
    }
    \Cart::add($queryAdd);
    Alert::success('Berhasil', 'Barang telah ditambahkan ke keranjang...');
  }

  public function cartContent() {
    $cartCollection = \Cart::getContent();
    $dataProduk = Product::with(["size", "variant"])->get();
    //Origin
    $origin = DB::table("origin")->get();
    $cartCollection->each(function($item, $key) use ($dataProduk, $origin) {

      $item->database_data = $dataProduk->firstWhere("name", $item->name); //Disini ada informasi gambar produk, nama dll sebagainya yang lebih terperinci
      $item->database_data["originName"] = $origin->firstWhere("id_city", $item->database_data->origin)->nama; //dikasih tau nama originnya
      $item->put("priceSum", $item->price * $item->quantity);

    });
    $total_price_item = $cartCollection->sum("priceSum");
    // dd($cartCollection);
    // //Menampilkan data provinsi di cart
    $provinsi = collect(json_decode(RajaOngkirController::get_province()));
    $provinsi = $provinsi["rajaongkir"]->results;
    

    $originGroup = $cartCollection->groupBy(function($item, $key) {//origin diambil dari database tiap tiapp item cart
      return $item->database_data["originName"];// sehingga akan terkelompok berdasarkan originnya
    })->map(function($item) {
      //Masing - masing item ditotal berat dan quantitynya
      return $item->each(function($inside) {
        $inside->put("total_weight", $inside->attributes["weight"] * $inside->quantity);
      });
    })->map(function($item) {
      //setelah itu ditotal berat dari origin tersebut
      return [
        "items" => $item,
        "origin_name" => $item->first()->database_data->originName,
        "origin_code" => $item->first()->database_data->origin,
        "total_weight_origin" => $item->sum("total_weight")
      ];
    });
    
    // $totalWeightGroup = $originGroup->map(function($item) {
    //   return $item->sum(function($insideItem) {
    //     return $insideItem["attributes"]["weight"] * $insideItem["quantity"];
    //   });
    // });
    
    return view("cart", [
      "carts" => $cartCollection,
      "countCart" => $cartCollection->count(),
      "total_price_item" => $total_price_item,
      "provinsi" => $provinsi,
      "originGroup" => $originGroup
    ]);
  }
  
  // $makanan = ["berkuah" => ["soto", "gule", "gudeg", "bubur"]];
  // bagaimana cara mengubahnya menjadi dibawah ini, menggunakkan method collection dari laravel
  // $makanan = ["berkuah" => ["items" => ["soto", "gule", "gudeg", "bubur"], "count" => 4]];
  public function deleteCart(Request $request) {

    \Cart::remove($request->id);
    Alert::success('Barang telah dihapus dari keranjang')->autoClose(3000);
    return response($request->id, 200)
    ->header('Content-Type', 'text/plain');
  }
  
  public function updateCart(Request $request) {
    //alert()->success("Berhasil", "Keranjang telahb berhasil diupdate");
    $product = Product::with(["size", "variant"])->get();
    $dataCart = collect($request->all()["request"]);
    $processCart = $dataCart->groupBy(['name', 'size', 'variant'])->map(function($group) { //DIkelompokkan yang sama
      return $group->map(function($group2) {
        return $group2->map(function($group3) {
          return [
            "id" => $group3->first()["id"],
            "name" => $group3->first()["name"],
            "size" => $group3->first()["size"],
            "weight" => $group3->first()["weight"],
            "variant" => $group3->first()["variant"],
            "quantity" => $group3->sum("quantity")
          ];
        })->values();
      })->values();
    })->values()->collapse()->collapse()->toArray();
    
    $sameCart = collect([]);//dicek apakah ada yang sama, akan tetapi berbeda id
    foreach ($processCart as $prc) {
      //Ambil cart yang namanya sama
      $sameCart->push($dataCart
        ->where("name", $prc["name"])
        ->where("size", $prc["size"])
        ->where("variant", $prc["variant"])
        ->where("id", "!=", $prc["id"])->values()->collapse());
      
      \Cart::update($prc["id"], [
        "name" => $prc["name"],
        "price" => $product->firstWhere("name", $prc["name"])->size->firstWhere("name", $prc["size"])->price,
        "quantity" => array(
          "relative" => false,
          "value" => $prc["quantity"]),
        'attributes' => array(
          "size" => $prc["size"],
          "variant" => $prc["variant"],
          "weight" => $product->firstWhere("name", $prc["name"])->size->firstWhere("name", $prc["size"])->weight
        )
      ]);
      //Hapus dari sameCart
      //Cek apakah ada sameCart
        foreach ($sameCart as $sac) {
           if(isset($sac["id"])) \Cart::remove($sac["id"]);
        }
    }

    return response($sameCart, 200)
    ->header('Content-Type', 'text/plain');
  }

  public function clearCart() {
    \Cart::clear();
  }
  
  public function testCart() {
   
  }
}