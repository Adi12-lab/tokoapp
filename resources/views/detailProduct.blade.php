@extends("layouts.main")
@section("isi")
<section>
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div id="sync1" class="owl-carousel owl-theme mt-4">
          @foreach($product->variant as $var)
          <div class="item">
            <img src="{{asset("img/variants/".$var->gambar)}}" class="img-thumbnail" alt="">
          </div>
          @endforeach
        </div>
      </div>
      <div class="col-md-6">
        <h2 class="mt-4">{{$product->name}}</h2>
        <span class="product-price fs-2">Rp. {{rupiah($product->price)}}</span>
        <span class="product-price-old text-decoration-line-through fs-5">Rp. {{rupiah($product->price)}}</span>
        <p class="product-text">
          {!! $product->deskripsi !!}
        </p>
        <div class="row">
          <span class="font-dark fw-bold">Warna : </span>
          <div class="ms-md-2">
            @foreach($product->variant as $var)
            @if($loop->first)
            <a class="btn variant active">{{$var->name}}</a>
            @endif
            <a class="btn variant">{{$var->name}}</a>
            @endforeach
          </div>
        </div>

        <div class="row my-3">
          <span class="font-dark fw-bold">Ukuran : </span>
        </div>

        <div class="row">
          <div class="col">
            <button class="btn minus btn-outline-secondary px-3 rounded-0" onclick="decrement(this)">-</button>
            <input type="number" class="form-control quantity-form rounded-0" value="1">
            <button class="btn plus btn-outline-success px-3 rounded-0" onclick="increment(this)">+</button>


            <button class="btn btn-primary px-3 py-2 ms-3"><i
              class="bi bi-cart"></i> Keranjang</button>

            <button class="btn btn-icon-light ms-3"><i class="fa-regular fa-heart fs-3"></i></button>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col all-lato-font">
        {!! $product->body!!}
      </div>
    </div>
  </div>
</section>
@endsection