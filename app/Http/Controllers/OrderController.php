<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class OrderController extends Controller
{

    public function index() {
        $orders = Order::all();
        return view("admin.order.index", [
            "orders" => $orders
        ]);
    }
    public function show(Request $request) {
        $order = Order::find($request->id_order);
        $order = Order::find($request->id_order);
        $unformattedDate = $order->tanggal;
        $order->tanggal = Carbon::parse($unformattedDate)->locale('id')->isoFormat('dddd, D MMMM Y');
        $order->product_order = DB::table("product_order")->where("id_order", $request->id_order)->get();
        return response($order);
    }
    public function store(Request $request) {
        
        $random_string = Str::random(10);
        $random_string = Str::upper($random_string);
        $order = new Order;
        $order->id_order = $random_string;
        $order->nama_penerima = $request->nama_penerima;
        $order->no_telepon = $request->no_telepon;
        $order->email = $request->email;
        $order->pengiriman = $request->expedition_package;
        $order->biaya_pengiriman = $request->expedition_cost;
        $order->alamat = "$request->alamat, $request->city, $request->province";
        $order->note = $request->note ?? '';

        $order->save();
        
        foreach($request->products as $product) {
            DB::table("product_order")->insert([
                "id_order" => $random_string,
                "name_product" => $product["name_product"],
                "size" => $product["size"],
                "variant" => $product["variant"],
                "price" => $product["price"],
                "quantity" => $product["quantity"],
                "sub_total" => $product["sub_total"]
            ]);

        };
        return response()->json([
            "kode" => $random_string
        ]);
    }
    public function edit(Request $request) {
        $order = Order::find($request->id_order);
        $order->product_order = DB::table("product_order")->where("id_order", $request->id_order)->get();
        return response($order);

    }
    public function update(Request $request) {
        $order = Order::find($request->id_order);
        $order->nama_penerima = $request->nama_penerima;
        $order->alamat = $request->alamat;
        $order->status = $request->status;
        $order->save();
        return redirect()->back();
    }
    public function delete(Request $request) {
        $order = Order::find($request->id_order);
        $order->delete();
        return redirect()->back();
    }
}
