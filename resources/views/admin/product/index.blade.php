@extends('admin.main')
@section('content')
    <section>

        <div class="container">
            <h1 class="mt-3">Semua Produk</h1>
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <a href="/metal/products/create" class="btn btn-secondary my-3">Tambahkan Produk</a>
            <div class="row">
              <table class="table table-striped">
                <thead class="table-dark">
                  <tr>
                    <th scope="col" style="width:10%;">No </th>
                    <th scope="col" style="width:20%;">Gambar</th>
                    <th scope="col" style="width:20%;">Nama</th>
                    <th scope="col" style="width:10%;">Harga</th>
                    <th scope="col" style="width:10%;">Stok</th>
                    <th scope="col" style="width:10%;">Status</th>
                    <th scope="col" style="width:20%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @php $x = 1; @endphp
                  @foreach ($products as $product)
                  <tr>
                    <th scope="row">{{$x}}</th>
                    {{-- Suatu saat gambar iki pasti tak ubah --}}
                    <td><img src="{{ asset("storage/".$product->gambar)}}" width = "250"alt=""></td> 
                    <td>{{$product->name}}</td>
                    <td>{{$product->size[0]->price ?? ""}}</td>
                    <td>{{$product->stok}}</td>
                    <td>{{$product->active == 1 ? "Aktif" : "Nonaktif"}}</td>
                    <td>
                      <button class="btn btn-info">
                        <i class="fa-solid fa-eye"></i>
                      </button>
                      <a href="/metal/products/{{$product->slug}}/edit" class="btn btn-warning">
                        <i class="fa-regular fa-pen-to-square"></i>
                      </a>
                      <x-modal target="deleteModal{{$product->id}}" type="danger" buttonHtml="<i class='fa-solid fa-trash'></i>" title="Hapus produk ?" body="Hapus produk {{$product->name}}" submitText="Delete" action="/metal/products/{{$product->slug}}" />
                    </td>
                  </tr>
                  @php $x++; @endphp    
                  @endforeach
                </tbody>
              </table>
            </div>
        </div>
    </section>
@endsection
