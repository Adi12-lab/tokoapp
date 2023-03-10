@extends("layouts.main")

@section('isi')
<section>
  <div class="container-fluid">
    {{ Breadcrumbs::render('produk') }}
    <div class="row">
      <div class="col-lg-10">
        <div class="sort dropdown mb-3">
          <button class="btn dropdown-toggle ms-auto d-block border px-3" type="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            <span><i class="fa-solid fa-sort d-inline-block me-2"></i> Sort by:</span> <span
              class="sortBy">Terbaru</span>
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#" data-sort="Harga termurah" data-sort-by="hargaMurah"><i class="bi bi-check-lg invisible"></i> Harga termurah</a></li>
            <li><a class="dropdown-item" href="#" data-sort="Terbaru"><i class="bi bi-check-lg"></i>Terbaru</a></li>
            <li><a class="dropdown-item" href="#" data-sort="Harga termahal" data-sort-by="hargaMahal"><i
              class="bi bi-check-lg invisible"></i> Harga termahal</a></li>
          </ul>
        </div>
        <div class="grid product">
          @foreach ($products as $product)
          <div class="card grid-item mb-3 rounded-0">
            <div class="row g-0">
              <div class="col-md-4">
                <img src="img/product/{{ $product->image }}" class="img-fluid rounded-start"
                alt="...">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <a class="product-title d-block"
                    href="/produk/{{ $product->slug }}">{{ $product->name }}</a>
                  <span class="product-price fs-2" data-price="{{ $product->size[0]->price ?? 0 }}">
                    Rp. {{rupiah($product->size[0]->price ?? 0)}}</span>
                  <span class="product-price-old text-decoration-line-through">Rp.
                    {{ $product->size[0]->old_price ?? ""}}</span>
                  <div class="product-text">
                    {!! $product->deskripsi !!}
                  </div>

                  <div class="product-bottom mt-2">
                    <form action="{{ route('productIndex.addCart') }}" method="POST">
                      @csrf
                      <input type="hidden" name="id" value="{{ rand(100,500) }}">
                      <input type="hidden" name="name" value="{{ $product->name }}">
                      <input type="hidden" name="size" value="{{$product->size[0]->name ?? ""}}">

                      <input type="hidden" name="price" value="{{ $product->size[0]->price ?? "" }}">
                      <input type="hidden" name="variant" value="{{ $product->variant[0]->name ?? "" }}">
                      <input type="hidden" name="quantity" value="1">
                      <button type="submit" name="submit" class="btn btn-outline-warning"><i
                        class="bi bi-cart text-warning"></i> Tambahkan ke
                        Keranjang</button>
                    </form>
                    <span class="btn text-danger"><i class="fa-regular fa-heart"></i>
                      Favorit</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="col-lg-2">
        TEst
      </div>
    </div>
  </div>

</section>
@endsection