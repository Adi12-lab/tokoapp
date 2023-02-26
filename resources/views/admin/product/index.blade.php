@extends("admin.main")
@section("content")
<section>

  <div class="container">
    <h1 class="mt-3">Semua Produk</h1>
    @if(session()->has("success"))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{session("success")}}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <a href="/metal/products/create" class="btn btn-secondary my-3">Tambahkan Produk</a>
    <div class="row">
      @foreach($products as $product)
      <div class="col-md-4">
        <div class="card mb-3">
          <img src="{{asset('img/product/'.$product->gambar)}}" class="card-img-top">
          <div class="card-body">
            <h5 class="card-title">{{$product->name}}</h5>
            <p class="product-text">
              {!! $product->deskripsi !!}
            </p>
            <a href="/metal/products/{{$product->slug}}" class="btn btn-primary">Detail</a>
            <a href="/metal/products/{{$product->slug}}/edit" class="btn btn-warning">Edit</a>
            <a href="/metal/products/{{$product->slug}}/size" class="btn btn-info">Sizes</a>
            <form action="/metal/products/{{$product->slug}}" method="post" class="d-inline">
              @csrf
              @method("delete")
              <button class="btn btn-danger" type="submit">Delete</button>
            </form>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    
  </div>
  </section>
  @endsection