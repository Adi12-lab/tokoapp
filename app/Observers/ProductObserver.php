<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

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
        $files = Arr::map($files, function ($value, $key) {
            $temp = explode("/", $value);
            return "$temp[1]/$temp[2]"; //carousel/file
        });

        //Pindahkan ke direktori yang bernama sesuai dengan slug produknya
        foreach ($files as $file) {
            Storage::move("pending/$file", "$product->slug/$file");
        }
        //tambahkan ke table product_gallery
        // 1. ambil nama carousel
        $file_become_folder = Storage::allDirectories($product->slug);
        // 2. masuk ke folder carousel
        foreach ($file_become_folder as $folder) { //folder = origin-product/carousel
            // 3. ambil semua filenya
            $files = Storage::allFiles($folder);
            foreach ($files as $file) {
                // 4. tambahkan ke database
                ProductGallery::create([
                    "product_id" => $product->id,
                    "jenis" => explode("/", $folder)[1], //jenis
                    "gambar" => $file,
                ]);
            }
        }
        Storage::deleteDirectory("pending"); // karena bisa saja ada file yang diupload tapi tidak jadi
    }

    /**
     * Handle the Product "updated" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function saving(Product $product)
    {
        if($product->isUpdating()) {// karena jika tidak begini, maka jika ada pembuatan produk baru maka akan ketriger juga
            //===Hapus gambar yang dikehendaki dari database
            foreach ($product->productGallery as $gallery) { //semua gambar yang dikehendaki dihapus
                if (Storage::missing($gallery->gambar)) $product->productGallery()->firstWhere("gambar", $gallery->gambar)->delete();
            }
            //=====pindahkan file pending kedalam folder slugnya=====
            $files = Storage::allFiles("pending");
          
            foreach ($files as $file) {
                $extension = explode('.',$file);
                $kind = explode("/", $file)[1]; //jenis = carousel, gallery
                $new_file_name = "$kind/".Str::random(20).".".end($extension);
                Storage::move($file, "$product->slug/$new_file_name");
                ProductGallery::create([
                    "product_id" => $product->id,
                    "jenis" => $kind, //jenis
                    "gambar" => "$product->slug/$new_file_name", //slug/jenis/namaFIle
                ]);
            }
        }
       
        Storage::deleteDirectory("pending"); // karena bisa saja ada file yang diupload tapi tidak jadi
    }

    public function deleting(Product $product)
    { // Saya tambahkan sendiri
        $product->size()->delete();
        $product->variant()->delete();
        Storage::delete($product->gambar); //hapus file dari folder product

        $gallery = Arr::map($product->productGallery->toArray(), function ($item) {
            return $item["gambar"];
        });
        Storage::delete($gallery); //hapus file gambarnya
        Storage::deleteDirectory($product->slug); //hapus direktorinya
        $product->productGallery()->delete(); //hapu semua gallerynya

    }
    /**
     * Handle the Product "deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
}
