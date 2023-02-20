<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
Use Alert;


class CartController extends Controller
{
   public function addCart(Request $request) {
   //dd($request->all());
    $cartId = intval($request->cartId);
    $productSize = $request->productSize;
    $productVariant = $request->productVariant;
    $productPrice = intval($request->productPrice);
    $productQuantity = intval($request->productQuantity);
    $productName = $request->productName;
    
   $cek = \Cart::getContent()->firstWhere("name",$productName);
   $queryAdd = [
    "name" => $productName, 
    "price" => $productPrice,
    "quantity" => $productQuantity, 
    'attributes' => array(
      "size" => $productSize,
      "variant"=> $productVariant
    )];
  if(isset($cek)) {
    if($cek->attributes->size == $productSize && $cek->attributes->variant == $productVariant) {
      $queryAdd["id"] = $cek->id;
    } else {
      $queryAdd["id"] = $cartId;
    	 }
    }
  else {
    $queryAdd["id"] = $cartId;
  }
    \Cart::add($queryAdd);
     Alert::success('Berhasil', 'Barang telah ditambahkan ke keranjang...')->autoClose(3000);
     return back();
     // return $request;
  }
   

   public function cartContent() {
    $cartCollection = \Cart::getContent();
    $dataProduk = Product::with(["size", "variant"])->get();

    $cartCollection->each( function($item ,$key) use ($dataProduk){
      $item->database_data = $dataProduk->firstWhere("name", $item->name);
      $item->put("priceSum", $item->price * $item->quantity);

    });
    
    return view("cart", [
        "carts" => $cartCollection,
        "productCount" => $cartCollection->count()
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
      $dataCart =  collect($request->input()["request"]);
      if($dataCart->duplicates("name")) {
        return response($dataCart, 200)
        ->header('Content-Type', 'text/plain');
      }
      
     
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
    
}
