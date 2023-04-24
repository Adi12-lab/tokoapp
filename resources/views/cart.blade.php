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

                            {{-- Info Produk --}}
                            <div class="col-md-2 cart-col">
                                <img src="{{ 'storage/'.$cart->database_data->gambar }}">
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
                                    <div class="row">
                                        <span>
                                            {{$cart->database_data->originName}}
                                        </span>
                                    </div>
                            </div>
                            
                            {{-- Price Produk --}}
                            <div class="col-md-2 cart-col ">
                                <span class="text-secondary fs-5">Rp. {{ rupiah($cart->price) }}</span>
                            </div>

                            {{-- Quantity Produk --}}
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
                <div class="col-md-7">
                    <div class="card p-4">
                        <h3>Data penerima</h3>
                        <div class="my-3">
                            <input type="text" class="form-control" id="nama" placeholder="Nama penerima">
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control" id="telepon" placeholder="No telepon">
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" id="email" placeholder="Email">
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
                                        <li class="drop-list active">Pilih provinsi</li>
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
                                <button class="btn dropdown-toggle border w-100 text-start px-4 py-3 position-relative" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Pilih kabupaten/kota
                                    <img src="{{asset("img/loader.gif")}}" class="image-loader position-absolute d-none" height="40" style="width:40px; right:0; bottom:8px;">
                                </button>
                                <div class="dropdown-menu w-100 p-3">
                                    <input type="text" class="dropdown-input form-control py-1">
                                    <ul class="dropdown-menu-body mt-2">
                                        <li class="drop-list active">Pilih kabupaten/kota</li>
                                    </ul>
                                </div>
                                
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="dropdown residence" data-kind-residence="cost">
                                <button class="btn dropdown-toggle border w-100 text-start px-4 py-3" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Pilih pengiriman
                                </button>
                                <div class="dropdown-menu w-100 p-3">
                                    <input type="text" class="dropdown-input form-control py-1">
                                    <ul class="dropdown-menu-body mt-2">
                                        <li class="drop-list active">Pilih pengiriman</li>
                                        <li class="drop-list" data-id="jne">JNE</li>
                                        <li class="drop-list" data-id="pos">POS</li>
                                        <li class="drop-list" data-id="tiki">TIKI</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" placeholder="Alamat lengkap" id="floatingTextarea2" style="width: 100%; height:200px;"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Cart Total --}}

                <div class="col-md-5">
                    <div class="cart-totals rounded-4">
                        <ul class="cart-totals-ul">
                            <li class="cart-totals-li">  
                                <span class="cart-total-label"><h6 class="text-muted">Sub total</h6></span>
                                <span class="cart-total-amount"><h4 class="fw-bold">Rp 9.000</h4></span>
                            </li>
                            <li class="cart-totals-li">  
                                <span class="cart-total-label">
                                    <h6 class="text-muted">Pengiriman</h6>
                                    <div class="dropdown">
                                        <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Rincian berat
                                        </button>
                                        <div class="dropdown-menu">
                                            <ul class="origin-item">
                                                <strong>Origin 1</strong>
                                                <li class="all-lato-font">
                                                    <span>Test 1</span>
                                                    <span>67</span>
                                                </li>
                                            </ul>
                                            <hr>
                                        </div>
                                      </div>
                                </span>
                                <span class="cart-total-amount"><h4 class="fw-bold text-success">Rp 12.0000</h4></span>
                            </li>
                            <li class="cart-totals-li">  
                                <span class="cart-total-label"><h6 class="text-muted">Tujuan</h6></span>
                                <span class="cart-total-amount"><h4 class="fw-bold">Kabupaten Lumajang</h4></span>
                            </li>
                            <li class="cart-totals-li">  
                                <span class="cart-total-label"><h6 class="text-muted">Total</h6></span>
                                <span class="cart-total-amount"><h4 class="fw-bold text-success">Rp 12.0000</h4></span>
                            </li>
                        </ul>
                        <button class="cart-checkout w-100 mt-4">Checkout Now <i class="fa-solid fa-arrow-right-from-bracket text-white"></i></button>
                    </div>
                </div>
            </div>

            
        </div>
    </section>
@endsection
