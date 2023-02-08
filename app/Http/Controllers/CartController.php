<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
Use Alert;


class CartController extends Controller
{
   public function addCart(Request $request) {
    $productId = intval($request->productId);
    $productPrice = intval($request->productPrice);
    $productQuantity = intval($request->productQuantity);
    $productName = $request->productName;
    \Cart::add(["id" => $productId, "name" => $productName, "price" => $productPrice,"quantity" => $productQuantity, 'attributes' => array()]);
    Alert::success('Berhasil', 'Barang telah ditambahkan ke keranjang...')->autoClose(3000);
    return back();
    // return $request;
   }

   public function cartContent() {
    $cartCollection = \Cart::getContent();
    $dataProduk = collect([]);
    foreach($cartCollection as $collection) {
        $dataProduk->push(collect(Product::find($collection->id))
        ->merge([
        "quantity" => $collection->quantity,
        "priceSum" => $collection->price * $collection->quantity
        ]));   
    }

    // dd($dataProduk);
    return view("cart", [
        "products" => $dataProduk
        
        ]);
    }
    
    public function deleteCart(Request $request) {
        \Cart::remove($request->id);
        Alert::success('Barang telah dihapus dari keranjang')->autoClose(3000);
        return response($request->id, 200)
            ->header('Content-Type', 'text/plain');
    }
    
    public function degQuantity(Request $request) {
      \Cart::update($request->id);
       return response($request->quantity, 200)
            ->header('Content-Type', 'text/plain');
    }
    
}
