<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Variant;
use App\Models\ProductGallery;
use App\Models\Size;


class Product extends Model
{

  use HasFactory;
  protected $guarded = ["id"];

  protected $isUpdating = false;

  public function setIsUpdating($isUpdating)
  {
    $this->isUpdating = $isUpdating;
  }

  public function isUpdating()
  {
    return $this->isUpdating;
  }
  public function productGallery()
  {
    return $this->hasMany(ProductGallery::class);
  }
  public function variant()
  {
    return $this->hasMany(Variant::class);
  }
  public function size()
  {
    return $this->hasMany(Size::class);
  }
  public function getRouteKeyName()
  {
    return 'slug';
  }
}
