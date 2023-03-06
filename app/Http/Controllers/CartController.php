<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Alert;
use App\Http\Controllers\RajaOngkirController;

class CartController extends Controller
{
  public function addCart(Request $request) {

    $all = $request->all();
    $cartId = intval($all["id"]);
    $productSize = $all["size"];
    $productVariant = $all["variant"];
    $productPrice = intval($all["price"]);
    $productQuantity = intval($all["quantity"]);
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
        "variant" => $productVariant
      )];
    if ($allCart->isNotEmpty()) {
      foreach ($allCart as $cart) {
        if ($cart->attributes->size == $productSize && $cart->attributes->variant == $productVariant) {
          $queryAdd["id"] = $cart->id;
        } else {
          $queryAdd["id"] = $cartId;
        }
      }
    } else {
      $queryAdd["id"] = $cartId;
    }
    //dd($queryAdd);
    \Cart::add($queryAdd);
    Alert::success('Berhasil', 'Barang telah ditambahkan ke keranjang...')->autoClose(3000);
    /*return response($queryAdd,200)
    ->header('Content-Type', 'text/plain');*/

    // return $request;
  }

  public function cartContent() {
    $cartCollection = \Cart::getContent();
    $dataProduk = Product::with(["size", "variant"])->get();

    $cartCollection->each(function($item, $key) use ($dataProduk) {
      $item->database_data = $dataProduk->firstWhere("name", $item->name);
      $item->put("priceSum", $item->price * $item->quantity);

    });
    $provinsi = collect(json_decode(RajaOngkirController::get_province()));
    $provinsi = $provinsi["rajaongkir"]->results;
    
    return view("cart", [
      "carts" => $cartCollection,
      "countCart" => $cartCollection->count(),
      "provinsi" => $provinsi
    ]);
  }

  public function deleteCart(Request $request) {

    \Cart::remove($request->id);
    Alert::success('Barang telah dihapus dari keranjang')->autoClose(3000);
    return response($request->id, 200)
    ->header('Content-Type', 'text/plain');
  }
  
  public function updateCart(Request $request) {
    //alert()->success("Berhasil", "Keranjang telahb berhasil diupdate");
    $product = Product::all();
    $dataCart = collect($request->all()["request"]);
    $processCart = $dataCart->groupBy(['name', 'size', 'variant'])->map(function($group) {
      return $group->map(function($group2) {
        return $group2->map(function($group3) {
          return [
            "id" => $group3->first()["id"],
            "name" => $group3->first()["name"],
            "size" => $group3->first()["size"],
            "variant" => $group3->first()["variant"],
            "quantity" => $group3->sum("quantity")
          ];
        })->values();
      })->values();
    })->values()->collapse()->collapse()->toArray();
    $sameCart = collect([]);
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
          "variant" => $prc["variant"]
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
  /*public function degQuantity(Request $request) {
      \Cart::update($request->id, array(
  "quantity" => -1
  ));
    }
    public function incQuantity(Request $request) {
      \Cart::update($request->id, array(
  "quantity" => +1
  ));
    }*/
  public function clearCart() {
    \Cart::clear();
  }
  
  public function testCart() {
    $dataCart = collect([
      [
        "id" => "453", "name" => "Buku", "size" => "A5", "variant" => "biru", "quantity" => 3
      ],
      [
        "id" => "74", "name" => "Buku", "size" => "A4", "variant" => "biru", "quantity" => 3
      ],
      [
        "id" => "421", "name" => "Buku", "size" => "A5", "variant" => "pink", "quantity" => 3
      ],
      [
        "id" => "4", "name" => "Buku", "size" => "A5", "variant" => "pink", "quantity" => 33
      ],
    ]);
    $processCart = $dataCart->groupBy(['name', 'size', 'variant'])->map(function($group) {
      return $group->map(function($group2) {
        return $group2->map(function($group3) {
          return [
            "id" => $group3->first()["id"],
            "name" => $group3->first()["name"],
            "size" => $group3->first()["size"],
            "variant" => $group3->first()["variant"],
            "quantity" => $group3->sum("quantity")
          ];
        })->values();
      })->values();
    })->values()->collapse()->collapse()->toArray();
    dd($processCart);
  }
}