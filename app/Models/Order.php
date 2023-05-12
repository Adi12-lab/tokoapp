<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_order';
    protected $keyType = 'string';
    public $timestamps = false;

    protected static function booted(): void
    {
        static::deleting(function (Order $order) {
            DB::table("product_order")->where("id_order", $order->id_order)->delete();
        });
       
    }
}
