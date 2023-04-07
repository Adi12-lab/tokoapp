<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class AttachmentController extends Controller
{
    public function toPending(Request $request) {
       
        //Upload file ke folder pending yang didalamnya ada folder yang sesuai dengan nama slug produk
        
            $path = $request->file("upload")->storeAs(
                "pending", $request->file("upload")->getClientOriginalName()
            );
            
            return response()->json([
                'url' => asset($path),
                'filename' => basename($path)
            ]);
        
    }
   
}
