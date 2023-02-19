@extends("layouts.main")
@section("isi")
<section>
  <div class="container-md">
    <div class="row">
      <div class="col-md-6">
        <div id="sync1" class="owl-carousel owl-theme mt-4">

          @foreach($product->productGallery->where("jenis","carousel") as $crl)
          <div class="item">
            <img src="{{asset("img/productCarousel/".$crl->gambar)}}" class="img-thumbnail" alt="{{$crl->name}}">
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
        @if(count($product->variant) > 0)
        <div class="row">
          <span class="font-dark fw-bold">Variant : </span>
          <div>
            @foreach($product->variant as $var)
            @if($loop->first)
            <a class="btn option active">{{$var->name}}</a>
            @continue
            @endif
            <a class="btn option">{{$var->name}}</a>
            @endforeach
          </div>
        </div>
        @endif

        @isset($product->size[0]->name)
        <div class="row my-3">
          <span class="font-dark fw-bold">Ukuran : </span>
          <div>

            @foreach($product->size as $siz)
            @if($loop->first)
            <a class="btn option active">{{$siz->name}} : {{rupiah($siz->price ?? 0)}}</a>
            @continue
            @endif
            <a class="btn option">{{$siz->name}} : {{rupiah($siz->price?? 0)}} </a>
            @endforeach
          </div>
        </div>
        @endisset
        <div class="row">
          <div class="col d-flex align-items-center">
            <button class="btn minus btn-outline-secondary px-3 rounded-0" onclick="decrement(this)">-</button>
            <input type="number" class="form-control quantity-form rounded-0" value="1">
            <button class="btn plus btn-outline-success px-3 rounded-0" onclick="increment(this)">+</button>
            <button class="btn btn-primary px-3 py-2 ms-3"><i
              class="bi bi-cart"></i> Keranjang</button>
            <span class="click-icon ">
              <i class="fa-regular fa-heart"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col body-product">
        <ul class="nav nav-tabs mt-4 mb-3">
          <li class="nav-item">
            <a id="description" href="" class="nav-link current">Description</a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">Gallery</a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">Reviews</a>
          </li>
        </ul>
        <div class="all-lato-font">
          {!! $product->body!!}
        </div>
      </div>
    </div>
  </div>
</section>
@endsection