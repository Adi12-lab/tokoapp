<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function toPending(Request $request) {
       
        //Upload file ke folder pending yang didalamnya ada folder yang sesuai dengan nama slug produk
        
            $path = $request->file("file")->storeAs(
                "pending/".$request->input("kind"), $request->file("file")->getClientOriginalName()
            );
            
            return response()->json([
                'url' => asset($path),
                'filename' => basename($path)
            ]);
        
    }
    public function removeAttachment(Request $request) {
        $attachmentName = $request->input("attachmentName");
        $editorKind = $request->input("kind");

        //hapus file yang berada pada editorKind

        Storage::delete("pending/$editorKind/$attachmentName");

        return response("Attachment pending/$editorKind/$attachmentName berhasil dihapus", 200)
        ->header('Content-Type', 'text/plain');
    }
   
}
