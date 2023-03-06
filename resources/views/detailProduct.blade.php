@extends("layouts.main")
@section("isi")
<section>
  <div class="container-md">  
    {{ Breadcrumbs::render('produk.name', $product) }}
    <div class="row">
      <div class="col-md-6">
        <div id="sync1" class="owl-carousel owl-theme">
          @foreach($product->productGallery->where("jenis","carousel") as $crl)
          <div class="item">
            <img src="{{asset("img/productCarousel/".$crl->gambar)}}" class="img-thumbnail" alt="{{$crl->name}}">
          </div>
          @endforeach
        </div>
      </div>
      <div class="col-md-6">
        <h2 class="mt-4 productName">{{$product->name}}</h2>
        <input class="cartId" type="hidden" value="{{rand(100, 500)}}">
        <span class="product-price fs-2">Rp. {{rupiah($product->size[0]->price)}}</span>
        <span class="product-price-old text-decoration-line-through fs-5">Rp. {{rupiah($product->size[0]->old_price)}}</span>
        <p class="product-text">
          {!! $product->deskripsi !!}
        </p>
        @isset($product->variant[0]->name)
        <div class="row">
          <span class="font-dark fw-bold">Variant : </span>
          <div>
            @foreach($product->variant as $var)
            @if($loop->first)
            <a class="btn option variant active" data-variant="{{$var->name}}">{{$var->name}}</a>
            @continue
            @endif
            <a class="btn option variant" data-variant="{{$var->name}}">{{$var->name}}</a>
            @endforeach
          </div>
        </div>
        @endisset

        @isset($product->size[0]->name)
        <div class="row size my-3">
          <span class="font-dark fw-bold">Ukuran : </span>
          <div>

            @foreach($product->size as $siz)
            @if($loop->first)
            <a class="btn option size active" data-size="{{$siz->name}}" data-price-size="{{$siz->price}}">{{$siz->name}} : {{rupiah($siz->price ?? 0)}}</a>
            @continue
            @endif
            <a class="btn option size" data-size="{{$siz->name}}" data-price-size="{{$siz->price}}">{{$siz->name}} : {{rupiah($siz->price?? 0)}} </a>
            @endforeach
          </div>
        </div>
        @endisset
        <div class="row">
          <div class="col d-flex align-items-center">
            <button class="btn minus btn-outline-secondary px-3 rounded-0" onclick="decrement(this)">-</button>
            <input type="number" class="form-control quantity-form rounded-0" value="1">
            <button class="btn plus btn-outline-success px-3 rounded-0" onclick="increment(this)">+</button>
            <button class="btn btn-primary px-3 py-2 ms-3 checkout"><i
              class="bi bi-cart"></i> Keranjang</button>
            <span class="click-icon ">
              <i class="fa-regular fa-heart"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="row my-3">
      <div class="col body-product">
        <ul class="nav nav-body mt-4 mb-3">
          <li class="nav-item">
            <a class="nav-link current" data-body="body-description">Description</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-body="body-gallery">Gallery</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-body="body-reviews">Reviews</a>
          </li>
        </ul>

          <div class="all-lato-font body-description body-content">
            {!! $product->body!!}
          </div>
          <div class="animated-thumbnails-gallery d-none body-gallery body-content">
            @foreach($product->productGallery->where("jenis", "gallery") as $gallery)
            <a href="/img/productGallery/{{$gallery->gambar}}" class="gallery-item">
              <img src="{{asset('img/productGallery/'.$gallery->gambar)}}" class="item">
            </a>
            @endforeach
          </div>
          <div class="body-reviews d-none body-content">
            Reviews
          </div>
      </div>
    </div>
  </div>
</section>
@endsection