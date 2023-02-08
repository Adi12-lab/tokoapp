@extends("layouts.main")
@section('isi')
<section>
  <div class="container">
    <div class="row">
      <h1 class="my-4">Keranjang Anda</h1>
      @foreach($products as $product)
      <div class="card mb-3">
        <div class="row cart-row">
          <input type="hidden" class="form-control" value="{{$product['id']}}">
          <div class="col-md-2 cart-col">
            <img src="img/product/{{$product["gambar"]}}" alt=""
            >
          </div>
          <div class="col-md-3 cart-col">
            <h4 class="card-title">{{$product["name"]}}</h4>
          </div>
          <div class="col-md-2 cart-col">
            <span class="text-muted fs-5 fw-bold">Rp. {{$product["price"]}}</span>
          </div>
          <div class="col-md-2 d-flex cart-col">
            <button class="btn minus btn-outline-secondary px-3 rounded-0" onclick="decrement(this)">-</button>
            <input type="number" class="form-control quantity-form rounded-0" value="{{$product["quantity"]}}">
            <button class="btn plus btn-outline-success px-3 rounded-0" onclick="increment(this)">+</button>
          </div>
          <div class="col-md-2 cart-col">
            <span class="text-success fs-5 fw-bold">Rp. {{$product["priceSum"]}}</span>
          </div>
          <div class="col-md-1 cart-col">

            <a class="removeCart"><i class="fa-solid fa-trash-can text-danger fs-4"></i></a>
          </div>
        </div>
      </div>
      @endforeach

    </div>
  </div>
</section>
@endsection