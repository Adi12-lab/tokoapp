<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
