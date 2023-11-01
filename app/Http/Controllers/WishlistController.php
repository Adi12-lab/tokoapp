<?php

namespace App\Http\Controllers;

use App\Models\Product; // Ganti dengan model produk Anda
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
class WishlistController extends Controller
{
    public function addWishlist(Request $slug)
    {   
        dd($slug);
        $product = Product::with(['size'])->firstWhere('slug', $slug);
        $wishlist = json_decode(request()->cookie('wishlist'), true) ?? [];
       
        if (!array_key_exists($slug, $wishlist)) {
            $wishlist[$slug] = [
                'id' => $product->id,
                'slug' => $product->slug,
                'name' => $product->name,
                'gambar' => $product->gambar,
                'price' => $product->size[0]['price'],
                'stok' => $product->stok
                // Tambahkan atribut lain yang diperlukan
            ];
        }

        $wishlistCookie = cookie('wishlist', json_encode($wishlist), 60 * 24 * 30); // Cookie berlaku selama 30 hari
        
        return response()->withCookie($wishlistCookie);
    }

    public function index()
    {
        $wishlist = json_decode(request()->cookie('wishlist'), true) ?? [];
        return view('wishlist', compact('wishlist'));
    }
    public function clear() {
        return redirect ()->route ('wishlist.index')->withCookie (Cookie::forget ('wishlist'));
    }
    public function removeWishlist($slug) {
        $temp = collect(json_decode(Cookie::get('wishlist'), true));
        $filtered = $temp->filter(function($item) use($slug){
            return $item["slug"] !== $slug;
        });
        $wishlistCookie = Cookie::make("wishlist", json_encode(($filtered)), 60 * 24 * 30);
        
        return redirect()->back()->withCookie($wishlistCookie);
    }
}


