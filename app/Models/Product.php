<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Variant;

class Product extends Model
{
  use HasFactory;
  protected $guarded = ["id"];
  public function variant() {
    return $this->hasMany(Variant::class);
  }
  public function getRouteKeyName() {
    return 'slug';
  }
}