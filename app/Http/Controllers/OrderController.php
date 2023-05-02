<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
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
        $id_order = $request->id_order;
        $order = Order::find($id_order);
        $product_order = DB::table("product_order")->where("id_order", $id_order)->get();
        $order["product_order"] = $product_order;
        return response($order);
    }

    public function update(Request $request) {
        $id_order = $request->id_order;
        $order = Order::find($id_order);
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
