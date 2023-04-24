@extends("layouts.main")
@section("isi")
<section>
  <div class="container-md">  
    {{ Breadcrumbs::render('produk.name', $product) }}

    {{-- Carousel --}}
    <div class="row">
      <div class="col-md-5">
        <div id="sync1" class="owl-carousel owl-theme">
          @foreach($product->productGallery->where("jenis","carousel") as $crl)
          <div class="item">
            <img src="{{asset("storage/".$crl->gambar)}}" class="img-thumbnail img-fluid" alt="{{$crl->name}}">
          </div>
          @endforeach
        </div>
        <div id="sync2" class="owl-carousel owl-theme mt-3">
          @foreach($product->productGallery->where("jenis","carousel") as $crl)
          <div class="item">
            <img src="{{asset("storage/".$crl->gambar)}}" class="img-thumbnail img-fluid" alt="{{$crl->name}}">
          </div>
          @endforeach
        </div>
      </div>


      <div class="col-md-5 mt-3">
        {{-- Informasi --}}
        <h2 class="mt-4 productName">{{$product->name}}</h2>
        <input class="cartId" type="hidden" value="{{rand(100, 500)}}">
        <span class="product-price fs-2">Rp. {{rupiah($product->size[0]->price)}}</span>
        <span class="product-price-old text-decoration-line-through fs-5">Rp. {{rupiah($product->size[0]->old_price)}}</span>

        {{-- Deskripsi --}}
        <div class="all-lato-font">
          {!! $product->deskripsi !!}
        </div>

        {{-- Variant --}}
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

        {{-- Size --}}
        {{-- Jika ada sizenya maka tampilkan --}}
        @if($product->size[0]->name != null)

        <div class="row size my-3">
          <span class="font-dark fw-bold">Ukuran : </span>
          <div>

            @foreach($product->size as $siz)
            @if($loop->first)
            <a class="btn option size active" data-size="{{$siz->name}}" data-price-size="{{$siz->price}}">{{$siz->name}} : {{rupiah($siz->price ?? 0)}}</a>
            @continue
            @endif
            <a class="btn option size" data-size="{{$siz->name}}" data-price-size="{{$siz->price}}" data-weight-size="{{$siz->weight}}">{{$siz->name}} : {{rupiah($siz->price)}} </a>
            @endforeach
          </div>
        </div>
        {{-- Jika tidak ada maka tampilkan beratnya saja, karena setiap produk pasti punya berat --}}
        @else
        <input type="hidden" name="weight" value="{{$product->size[0]->weight}}">
        <input type="hidden" name="price" value="{{$product->size[0]->price}}">
        @endif

        {{-- Action --}}
        <div class="row mt-3">
          <div class="col d-flex align-items-center">
            <button class="btn minus btn-outline-secondary rounded-0" onclick="decrement(this)">-</button>
            <input type="number" class="form-control quantity-form rounded-0" value="1">
            <button class="btn plus btn-outline-success rounded-0" onclick="increment(this)">+</button>
            <button class="btn btn-primary px-3 py-2 ms-3 addCart body"><i
              class="bi bi-cart"></i> Keranjang</button>
            <button class="btn btn-warning px-3 py-2 ms-3 text-white"><i class="bi bi-bag-check text-white"></i> Checkout </button>
            <a class="action-btn ms-3"><i class="fa-regular fa-heart"></i></a>
          </div>
        </div>
      </div>
    </div>

    {{-- Nav Body Detail Produk --}}
    <div class="row my-3">
      <div class="col-md-9 body-product">
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

            <a href="{{asset("storage/".$gallery->gambar)}}" class="gallery-item">
              <img src="{{asset("storage/".$gallery->gambar)}}" class="item" style="width:250px;">
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