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
                            <input type="hidden" class="cart-weight" value="{{ $cart->attributes['weight'] }}">
                            {{-- Info Produk --}}
                            <div class="col-md-2 cart-col">
                                <img src="{{ 'storage/' . $cart->database_data->gambar }}">
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
                                        {{ $cart->database_data->originName }}
                                    </span>
                                </div>
                            </div>

                            {{-- Price Produk --}}
                            <div class="col-md-2 cart-col ">
                                <span class="text-secondary fs-5">{{ rupiah($cart->price) }}</span>
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
                                <span class="text-success fs-5 fw-bold">{{ rupiah($cart->priceSum) }}</span>
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

            <div class="row data-penerima mt-3 justify-content-center">
                <div class="col-md-7">
                    <div class="card p-4">
                        <h3>Data penerima</h3>
                        <div class="my-3">
                            <input type="text" class="form-control" data-kind-form="nama_penerima" placeholder="Nama penerima">
                            <span class="ms-2 text-danger text-small alert-error nama_penerima d-none">Nama penerima perlu diisi</span>
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control" data-kind-form="no_telepon" placeholder="No telepon">
                            <span class="ms-2 text-danger text-small alert-error no_telepon d-none">No perlu diisi</span>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" data-kind-form="email" placeholder="Email">
                            <span class="ms-2 text-danger text-small alert-error email d-none">email perlu diisi</span>
                        </div>
                        <div class="mb-3">
                            <div class="residence" data-kind-residence="province">
                                <select class="select-input" style="width:100%;" data-placeholder="Pilih provinsi" data-kind-form="province">
                                    <option value="" selected></option>
                                    @foreach($provinsi as $prov)
                                        <option value="{{$prov->province_id}}">{{$prov->province}}</option>
                                        @endforeach
                                    </select>
                                    <span class="ms-2 text-danger text-small alert-error province d-none">provinsi perlu diisi</span>
                                </div>
                            </div>
                            
                            <div class="mb-3" >
                                <div class="residence position-relative" data-kind-residence="city">
                                    <select class="select-input" style="width:100%" data-placeholder="Pilih kabupaten/kota" data-kind-form="city">
                                        <option value="">Pilih kabupaten/kota</option>
                                    </select>
                                    <img src="{{ asset('img/loader.gif') }}"
                                    class="image-loader position-absolute d-none" height="35"
                                    style="width:35px; right: 40px; bottom:6px;">
                                    
                                    <span class="ms-2 text-danger text-small alert-error city d-none">kabupaten/kota perlu diisi</span>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="residence" data-kind-residence="expedition">
                                    <select class="select-input" style="width:100%" data-placeholder="Pilih ekspedisi">
                                        <option value=""></option>
                                        <option value="jne">JNE</option>
                                        <option value="pos">POS</option>
                                        <option value="tiki">TIKI</option>
                                    </select>
                                    <span class="ms-2 text-danger text-small alert-error expedition d-none">pilih ekspedisi terlebih dahulu</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="residence position-relative" data-kind-residence="expedition_package" >
                                    <select class="select-input" style="width:100%" data-placeholder="Pilih paket ekspedisi" data-kind-form="expedition_package">
                                    </select>
                                    <img src="{{ asset('img/loader.gif') }}"
                                    class="image-loader position-absolute d-none" height="35"
                                    style="width:35px; right: 40px; bottom:6px;">
                                </div>
                            <span class="ms-2 text-danger text-small alert-error expedition_package d-none">pilih paket ekspedisi terlebih dahulu</span>
                            <span class="ms-2 text-small d-block"><strong class="text-danger">Perhatian !!</strong> ongkir
                                mahal karena barang dikirim dari berbagai daerah</span>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" placeholder="Alamat lengkap" data-kind-form="alamat"
                                style="width: 100%; height:200px;"></textarea>
                                <span class="ms-2 text-danger text-small alert-error alamat d-none">alamat perlu diisi</span>
                        </div>
                    </div>
                </div>

                {{-- Cart Total --}}

                <div class="col-md-5">
                    <div class="cart-totals rounded-4">
                        <ul class="cart-totals-ul">
                            <li class="cart-totals-li">
                                <span class="cart-total-label">
                                    <h6 class="text-muted">Sub total</h6>
                                </span>
                                <span class="cart-total-amount">
                                    <h4 class="fw-bold sub-total" data-price="{{ $sub_total }}">
                                        {{ rupiah($sub_total) }}</h4>
                                </span>
                            </li>
                            <li class="cart-totals-li">
                                <span class="cart-total-label">
                                    <h6 class="text-muted">Pengiriman</h6>
                                    <div class="dropdown">
                                        <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            Rincian berat
                                        </button>
                                        <div class="dropdown-menu">
                                            @foreach ($originGroup as $origin)
                                                <ul class="origin-item">
                                                    <strong>{{ $origin['origin_name'] }}</strong>

                                                    @foreach ($origin['items'] as $item)
                                                        <li class="all-lato-font">
                                                            <span>{{ $item['name']." ".$item['attributes']['size'] }}</span>
                                                            <span>{{ $item['total_weight'] }} gram</span>
                                                        </li>
                                                    @endforeach
                                                    <hr>
                                                    <li>
                                                        <span>Total berat : </span>
                                                        <span>{{ $origin['total_weight_origin'] }} gram</span>
                                                    </li>
                                                    <input type="hidden" name="origin_code[]"
                                                        value="{{ $origin['origin_code'] }}"
                                                        data-name='{{ $origin['origin_name'] }}'
                                                        data-weight="{{ $origin['total_weight_origin'] }}">

                                                </ul>
                                                <hr>
                                            @endforeach
                                        </div>
                                    </div>
                                </span>
                                <span class="cart-total-amount">
                                    <h4 class="fw-bold text-success expedition-cost" data-price="0">0</h4>
                                </span>
                            </li>
                            <li class="cart-totals-li">
                                <span class="cart-total-label">
                                    <h6 class="text-muted">Tujuan</h6>
                                </span>
                                <span class="cart-total-amount">
                                    <h4 class="fw-bold destination">-</h4>
                                </span>
                            </li>
                            <li class="cart-totals-li">
                                <span class="cart-total-label">
                                    <h6 class="text-muted">Total</h6>
                                </span>
                                <span class="cart-total-amount">
                                    <h4 class="fw-bold text-success total-cost" data-price="0">0</h4>
                                </span>
                            </li>
                        </ul>
                        <div class="note mt-1 mb-3">
                            <textarea class="form-control" placeholder="Catatan pembeli" id="note" data-kind-form="note"
                            style="width: 100%; height:90px;"></textarea>
                        </div>
                        <button class="cart-checkout w-100 mt-4 d-block" type="button">
                            Checkout Now <i class="fa-solid fa-arrow-right-from-bracket text-white"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
