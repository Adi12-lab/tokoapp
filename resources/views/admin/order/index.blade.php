@extends('admin.main')
@section('content')
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <h3 class="text-center mt-3">Data Pesanan</h3>
                <div class="col-md-10">
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Kode Pesanan</th>
                                <th scope="col">Nama Penerima</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                    <td>{{ $order->tanggal }}</td>
                                    <td>{{ $order->id_order }}</td>
                                    <td>{{ $order->nama_penerima }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>
                                        <button class="btn btn-info detail-order">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn btn-warning edit-order" data-id-order="{{$order->id_order}}" data-bs-toggle="modal"
                                            data-bs-target="#orderModal">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                        <form action="{{route("delete.order")}}" class="d-inline-block" method="post">
                                            @csrf
                                            @method("DELETE")
                                            <input type="hidden" name="id_order" value="{{$order->id_order}}">
                                            <button class="btn btn-danger delete-order" data-id-order="{{$order->id_order}}" onclick="return confirm('Hapus pesanan {{$order->id_order}} ?')">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </section>


    <!-- Modal -->
    <div class="modal fade" id="orderModal" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Detail Produk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route("update.order")}}" method="post">
                        @csrf
                        @method('PUT')
                    <div class="mb-3">
                        <span>Kode Pesanan</span>
                        <p id="kode" class="fw-bold"></p>
                        <input type="hidden" name="id_order">
                      </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Penerima</label>
                        <input type="text" class="form-control" name="nama_penerima" id="nama">
                      </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea id="alamat" class="form-control" name="alamat" cols="30" rows="6"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="">Catatan</label>
                        <p id="note"></p>
                    </div>
                    <div class="mb-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Produk</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Varian</th>
                                    <th scope="col">Jumlah Unit</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Sub Total</th>
                                </tr>
                            </thead>

                            <tbody>    
                            </tbody>
                        </table>
                    </div>
                    <div class="mb-3">
                        <div id="tanggal">Tanggal</div>
                    </div>
                    <div class="mb-3 w-50">
                        <label for="" class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="Menunggu konfirmasi">Menunggu konfirmasi</option>    
                            <option value="Menunggu pembayaran">Menunggu pembayaran</option>    
                            <option value="Pengemasan">Pengemasan</option>    
                            <option value="Pengiriman">Pengiriman</option>    
                            <option value="Selesai">Selesai</option>    
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
            </div>
        </div>
    </div>
@endsection
