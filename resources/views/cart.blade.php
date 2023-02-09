@extends("layouts.main")
@section('isi')
<section>
  <div class="container">
    <div class="row">
      <h1 class="mt-3">Keranjang Anda</h1>
      <p class="bg-red" style="width:max-content;">
        Kami menemukan <span class="text-success">{{$productCount}}</span> produk di keranjang anda..
      </p>
      <button class="btn clearCart ms-auto" onclick="clearCart()"><i class="fa-solid fa-trash-can"></i> Clear cart</button>
    </div>
    <div class="row d-none d-md-flex cart-head">
      <div class="col-md-5">
        <span>Produk</span>
      </div>
      <div class="col-md-2">
        <span>Harga</span>
      </div>
      <div class="col-md-2">
        <span>Jumlah</span>
      </div>
      <div class="col-md-2">
        <span>Sub Harga</span>
      </div>
      <div class="col-md-1">
        <span>Hapus</span>
      </div>
    </div>
    <div class="row">
      @foreach($products as $product)
      <div class="card rounded-0">
        <div class="row cart-row">
          <input type="hidden" class="form-control" value="{{$product['id']}}">
          <div class="col-md-2 cart-col">
            <img src="img/product/{{$product["gambar"]}}" alt=""
            >
          </div>
          <div class="col-md-3 cart-col">
            <h4>{{$product["name"]}}</h4>
          </div>
          <div class="col-md-2 cart-col">
            <span class="text-muted fs-5 fw-bold">Rp. {{rupiah($product["price"])}}</span>
          </div>
          <div class="col-md-2 d-flex cart-col">
            <button class="btn minus btn-outline-secondary px-3 rounded-0" onclick="decrement(this)">-</button>
            <input type="number" class="form-control quantity-form rounded-0" value="{{$product["quantity"]}}">
            <button class="btn plus btn-outline-success px-3 rounded-0" onclick="increment(this)">+</button>
          </div>
          <div class="col-md-2 cart-col">
            <span class="text-success fs-5 fw-bold">Rp. {{rupiah($product["priceSum"])}}</span>
          </div>
          <div class="col-md-1 cart-col">
            <a href="#"class="removeCart"><i class="fa-solid fa-trash-can text-danger fs-4"></i></a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    <div class="row">
      <a href="/produk" class="btn btn-primary px-3 mt-3"><i class="fa-regular fa-circle-left"></i> Lanjut Belanja</a>
      <a href="/cart" class="btn btn-primary px-3 mt-3 ms-auto"><i class="fa-solid fa-rotate"></i> Update Keranjang</a>
    </div>
  </div>
</section>
@endsection