<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class AttachmentController extends Controller
{
    public function toPending(Request $request)
    {

        //Upload file ke folder pending yang didalamnya ada folder yang sesuai dengan nama slug produk

        $path = $request->file("file")->storeAs(
            "pending/" . $request->input("kind"), $request->file("file")->getClientOriginalName()
        );

        return response()->json([
            'url' => asset($path),
            'filename' => basename($path)
        ]);
    }
    public function removeFromPending(Request $request)
    {
        $attachmentName = $request->input("attachmentName");
        $editorKind = $request->input("kind");

        //hapus file yang berada pada editorKind

        Storage::delete("pending/$editorKind/$attachmentName");

        return response("Attachment pending/$editorKind/$attachmentName berhasil dihapus", 200)
            ->header('Content-Type', 'text/plain');
    }
    public function removeFromStorage(Request $request)
    {
        //Hapus gambar dari storagenya
        
        $url = url()->current();
        $origin = substr($url, 0, strrpos($url, "/"));
        $attachmentDatabase = Arr::map(explode(",",$request->getContent()), function($value, $key) use($origin){
            return Str::after($value, $origin.'/storage');
        });

        Storage::delete($attachmentDatabase);

        return response($attachmentDatabase, 200)->header("Content-Type", 'text/plain');
    }
    public function clearPending() {
        Storage::deleteDirectory("pending");
    }
}
