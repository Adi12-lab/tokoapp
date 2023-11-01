
@extends("layouts.main")
@section("isi")
<section>

    <div class="container">
        <div class="row">
           
                <div class="table-responsive">
                    <table class="table wishlist">
                        <thead class="border">
                            <tr>
                                <th scope="col" colspan="2">Produk</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Status stok</th>
                                <th scope="col">Aksi</th>
                                <th scope="col">Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($wishlist as $item)
                            <tr>
                                <td>
                                    <img src="{{asset("storage/".$item['gambar'])}}">
                                </td>
                                <td>
                                    <h6>
                                        <a href="{{$item['slug']}}">
                                            {{$item['name']}}
                                        </a>
                                    </h6>
                                </td>
                                <td>
                                    <h3 class="product-price">
                                        {{rupiah($item['price'])}}
                                    </h3>
                                </td>
                                <td class="text-center">
                                    <span class="stock-status tersedia">Tersedia</span>
                                </td>
                                <td>
                                    <button class="btn-hover-yellow mx-auto">Keranjang</button>
                                </td>
                                <td class="text-center">
                                    <a href="{{route('wishlist.remove', $item['slug'])}}">
                                        <i class="fa-solid fa-trash-can text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                    
                        </tbody>
                    </table>
    
                </div>
    
        </div>
    </div>
</section>
@endsection