@extends("admin.main")
@section("content")
<section>
  <div class="container">
    <div class="row">
      <h3>Semua Size</h3>
      @if(count($product->size) >0 )
      @foreach($product->size as $size)
      <div class="my-3">
      <span class="d-block">{{$size->name}} : {{$size->price ?? "0"}}</span>
      <span class="d-block">Harga Lama {{$size->name}} : {{$size->old_price." " . "(".diskon($size->price, $size->old_price)}}) </span>
      </div>
      @endforeach
      @else
      <span>Belum ada size atau memang tidak ada</span>
      @endif
    </div>

    <h3 class="mt-3">Tambah Size {{$product->name}}</h3>
    @if(session()->has("success"))
    <div class="alert alert-success" role="alert">
      {{session("success")}}
    </div>
    @endif
    <div class="row">
      <form action="/metal/products/size" method="post">
        @csrf
        <input type="hidden" name="productId"value="{{$product->id}}" />
      <div class="mb-3">
        <label for="size" class="form-label">Size</label>
        <input type="text" class="form-control" name="size" id="size" placeholder="A4">
      </div>
      <div class="mb-3">
        <label for="price" class="form-label">Harga Size</label>
        <input type="number" class="form-control" name="price" id="price" placeholder="175000">
      </div>
      <div class="mb-3">
        <label for="old_price" class="form-label">Harga Lama Size</label>
        <input type="number" class="form-control" name="old_price" id="price" placeholder="175000">
      </div>
      <button class="btn btn-primary">Tambah Size</button>
    </form>
  </div>
  <div class="row">
    <h3 class="mt-3">Edit Size</h3>
    @foreach($product->size as $siz)
    <form action="/metal/products/size/update" method="post">
      @csrf
      <input type="hidden" name="sizeId"value="{{$siz->id}}" />
    <div class="mb-3">
      <label for="size" class="form-label">Size {{$siz->name}}</label>
      <input type="text" class="form-control" name="size" id="size" placeholder="A4" value="{{$siz->name}}">
    </div>
    <div class="mb-3">
      <label for="price" class="form-label">Harga Size {{$siz->name}}</label>
      <input type="number" class="form-control" name="price" id="price" placeholder="175000" value="{{$siz->price}}">
    </div>
    <div class="mb-3">
      <label for="old_price" class="form-label">Harga Lama Size {{$siz->name}}</label>
      <input type="number" class="form-control" name="old_price" id="old_price" placeholder="175000" value="{{$siz->old_price}}">
    </div>
    <button class="btn btn-warning mb-3">Edit Size</button>
  </form>
    @endforeach
</div>
</div>
</section>
@endsection