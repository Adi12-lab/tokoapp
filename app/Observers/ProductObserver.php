<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function created(Product $product) //Saat produk terbuat lakukan ini
    {
        //Ambil semua gambar dari folder pending
       $files = Storage::allFiles("pending");
       $files = Arr::map($files, function($value, $key) {
            $temp = explode("/", $value);
            return "$temp[1]/$temp[2]"; //carousel/file
       });
       //buat direktori dengan nama slugnya
       
        //Pindahkan ke direktori yang bernama sesuai dengan slug produknya
        foreach($files as $file) {
           Storage::move("pending/$file", "$product->slug/$file"); 
        }
        //tambahkan ke table product_gallery
            // 1. ambil nama carousel
            $file_become_folder = Storage::allDirectories($product->slug);
            // 2. masuk ke folder carousel
            foreach($file_become_folder as $folder) { //folder = origin-product/carousel
                // 3. ambil semua filenya
                $files = Storage::allFiles($folder);
                foreach($files as $file) {
                    // 4. tambahkan ke database
                    ProductGallery::create([
                        "product_id" => $product->id,
                        "jenis" => explode("/",$folder)[1], //folder = carousel
                        "gambar" => $file,
                    ]);
                }
            }
            Storage::deleteDirectory("pending");
    }

    /**
     * Handle the Product "updated" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        //
    }

    public function deleting(Product $product) {// Saya tambahkan sendiri
        $product->size()->delete();
        $product->variant()->delete();
        Storage::delete($product->gambar);

        $gallery = Arr::map($product->productGallery->toArray(), function($item) {
            return $item["gambar"];
        });
        Storage::delete($gallery);
        Storage::deleteDirecotory($product->slug);
        $product->productGallery()->delete();

    }
    /**
     * Handle the Product "deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        
    }

    /**
     * Handle the Product "restored" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        
    }
}
