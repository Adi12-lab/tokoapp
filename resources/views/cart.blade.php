@extends('layouts.main')
@section('isi')
    <section>
        <div class="container">
            {{ Breadcrumbs::render('cart') }}
            <div class="row">
                <h1 class="mt-3">Keranjang Anda</h1>
                <p class="bg-red" style="width:max-content;">
                    Kami menemukan <span class="text-success">{{ $countCart }}</span> produk di keranjang anda..
                </p>
                <button class="btn clearCart ms-auto" onclick="clearCart()"><i class="fa-solid fa-trash-can"></i> Clear
                    cart</button>
            </div>
            <div class="row d-none d-md-flex cart-head">
                <div class="col-md-5">
                    <span>Produk</span>
                </div>
                <div class="col-md-2">
                    <span>Sub Harga</span>
                </div>
                <div class="col-md-2">
                    <span>Jumlah</span>
                </div>
                <div class="col-md-2">
                    <span>Harga</span>
                </div>
                <div class="col-md-1">
                    <span>Hapus</span>
                </div>
            </div>
            <div class="row">

                @foreach ($carts as $cart)
                    <div class="card rounded-0">
                        <div class="row cart-row">
                            <input type="hidden" class="cart-id form-control" value="{{ $cart->id }}">
                            <div class="col-md-2 cart-col">
                                <img src="img/product/{{ $cart->database_data->gambar }}">
                            </div>
                            <div class="col-md-3 text-center py-3">
                                <h4 class="cart-title">{{ $cart->name }}</h4>
                                <div class="row g-2 justify-content-center">
                                    @isset($cart->attributes['size'])
                                        <div class="cart dropdown size">
                                            <button class="btn border-success px-3" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <span class="dropdown-html"
                                                    data-select-drop="{{ $cart->attributes->size }}">{{ $cart->attributes->size }}</span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                @foreach ($cart->database_data->size as $size)
                                                    <li><a class="dropdown-item" data-dropdown="{{ $size->name }}"><i
                                                                class="bi bi-check-lg {{ $cart->attributes->size == $size->name ? '' : 'invisible' }}"></i>
                                                            {{ $size->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endisset
                                    @isset($cart->attributes['variant'])
                                        <div class="cart dropdown variant">
                                            <button class="btn border-danger px-3" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <span class="dropdown-html"
                                                    data-select-drop="{{ $cart->attributes->variant ?? '' }}">{{ $cart->attributes->variant ?? '' }}</span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                @foreach ($cart->database_data->variant as $variant)
                                                    <li><a class="dropdown-item" data-dropdown="{{ $variant->name }}"><i
                                                                class="bi bi-check-lg {{ $cart->attributes->variant == $variant->name ? '' : 'invisible' }}"></i>
                                                            {{ $variant->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endisset
                                </div>

                            </div>
                            <div class="col-md-2 cart-col ">
                                <span class="text-secondary fs-5">Rp. {{ rupiah($cart->price) }}</span>
                            </div>
                            <div class="col-md-2 d-flex cart-col">
                                <button class="btn minus btn-outline-secondary px-3 rounded-0"
                                    onclick="decrement(this)">-</button>
                                <input type="number" class="form-control quantity-form rounded-0"
                                    value="{{ $cart->quantity }}">
                                <button class="btn plus btn-outline-success px-3 rounded-0"
                                    onclick="increment(this)">+</button>
                            </div>
                            <div class="col-md-2 cart-col">
                                <span class="text-success fs-5 fw-bold">Rp. {{ rupiah($cart->priceSum) }}</span>
                            </div>
                            <div class="col-md-1 cart-col">
                                <a href="#"class="removeCart"><i
                                        class="fa-solid fa-trash-can text-danger fs-4"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col d-flex">
                    <a href="/produk" class="btn btn-primary px-3 mt-3"><i class="fa-regular fa-circle-left"></i> Lanjut
                        Belanja</a>
                    <a class="btn btn-primary px-3 mt-3 ms-auto update-cart"><i class="fa-solid fa-rotate"></i> Update
                        Keranjang</a>
                </div>
            </div>

            <div class="row mt-3 justify-content-center">
                <div class="col col-md-7">
                    <div class="card p-4">
                        <h3>Data penerima</h3>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Penerima</label>
                            <input type="text" class="form-control" id="nama">
                        </div>
                        <div class="mb-3">
                            <div class="dropdown residence" data-kind-residence="province">
                                <button class="btn dropdown-toggle border w-100 text-start px-4 py-3" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Pilih provinsi
                                </button>
                                <div class="dropdown-menu w-100 p-3">
                                    <input type="text" class="dropdown-input form-control py-1">
                                    <ul class="dropdown-menu-body mt-2">
                                        <li class="drop-list active">Pilih Provinsi</li>
                                        @foreach ($provinsi as $prov)
                                            <li class="drop-list" data-id="{{ $prov->province_id }}">{{ $prov->province }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="dropdown residence" data-kind-residence="city">
                                <button class="btn dropdown-toggle border w-100 text-start px-4 py-3" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Pilih Kabupaten/Kota
                                </button>
                                <div class="dropdown-menu w-100 p-3">
                                    <input type="text" class="dropdown-input form-control py-1">
                                    <ul class="dropdown-menu-body mt-2">
                                        <li class="drop-list active">Pilih kota</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-md-5">
                  <div class="card p-4">
                    
                  </div>
                </div>
            </div>

            
        </div>
    </section>
@endsection
