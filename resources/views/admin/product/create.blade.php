@extends('admin.main')
@section('content')
    <section>
        <div class="container border">
            <div class="row justify-content-center">
                <div class="col col-md-8">
                    <form action="/metal/products" method="post" enctype="multipart/form-data">
                        <h1 class="text-center">Buat Produk</h1>

                        {{-- Data yang wajib --}}
                        <h4>Data Wajib</h4>
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" id="name" name="name">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                value="{{ old('slug') }}" id="slug" name="slug">
                            @error('slug')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="kelompok" class="form-label">Kelompok</label>
                            <input type="text" class="form-control @error('kelompok') is-invalid @enderror"
                                value="{{ old('kelompok') }}" id="kelompok" name="kelompok">
                            @error('kelompok')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="text" class="form-control @error('stok') is-invalid @enderror"
                                value="{{ old('stok') }}" id="stok" name="stok">
                            @error('stok')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="origin" class="form-label">Origin</label>
                            <select class="form-select" name="origin">
                                <option selected>Pilih asal Produk</option>
                                @foreach ($origin as $org)
                                    <option value="{{ $org->id_city }}">{{ $org->nama }}</option>
                                @endforeach
                            </select>
                            @error('origin')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            <img class="image_preview d-block mb-3" style="width:500px;">
                            <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar"
                                name="gambar" onchange="previewImage(this)">
                            @error('gambar')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <input id="deskripsi" type="hidden" name="deskripsi" value="{{ old('deskripsi') }}">
                            @error('deskripsi')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                            <trix-editor input="deskripsi"></trix-editor>
                        </div>
                        <div class="mb-3">
                            <label for="body" class="form-label">Body</label>
                            <input id="body" type="hidden" name="body" value="{{ old('body') }}">
                            @error('body')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                            <trix-editor input="body"></trix-editor>
                        </div>

                        {{-- Bagian Size --}}
                        <div class="table-responsive my-2">
                            <h4>Tambahkan Size</h4>
                            <ul>
                                <li>
                                    Tiap produk pasti memiliki berat dan harga, akan tetapi ada juga produk yang memiliki
                                    size, harga, dan berat, jadi jika produk anda tidak membutuhkakn <strong>jenis
                                        size</strong> maka anda dapat kosongkan <strong> kolom size </strong>,akan tetapi
                                    anda wajib mengisi kolom yang lain. <strong>Mohon untuk tidak menambahkan baris
                                        baru</strong>
                                </li>
                                <li>
                                    apabila produk anda memiliki size, maka wajib anda isi semua
                                </li>
                            </ul>
                            <button class="btn btn-outline-success add_row_button size" type="button" disabled>Add Row</button>
                            <table class="table" data-kind-table="size_table">
                                <thead>
                                    <tr>
                                        <th scope="col">Size</th>
                                        <th scope="col">Berat</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Harga Lama</th>
                                        <th scope="col" class="text-danger">Delete</th>
                                    </tr>
                                </thead>
                                <tbody class="body_table size">

                                    <tr>
                                        <td><input class="form-control size_form" type="text" name="size_name[]"></td>
                                        <td><input class="form-control size_form" type="number" name="size_weight[]"></td>
                                        <td><input class="form-control size_form" type="number" name="size_price[]"></td>
                                        <td><input class="form-control size_form" type="number" name="old_price[]"></td>
                                        <td><button type="button" class="btn-close ms-3 mt-1"></button> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- Bagian Variant --}}

                        <div class="table-responsive my-2">
                            <h4>Tambahkan Variant</h4>
                            <button class="btn btn-outline-success add_row_button" type="button">Add Row</button>
                            <table class="table" data-kind-table="variant_table">
                                <thead>
                                    <tr>

                                        <th scope="col">Variant</th>
                                        <th scope="col" class="text-danger">Delete</th>
                                    </tr>
                                </thead>
                                <tbody class="body_table variant">
                                    <tr>
                                        <td><input class="form-control" type="text" name="variant_name[]"></td>
                                        <td><button type="button" class="btn-close ms-3 mt-1"></button> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mb-3">
                            <h4>Carousel Produk</h4>
                            <input id="attachment-file" type="hidden" name="attachment-file" value="{{ old('attachment-file') }}">
                            @error('attachment-file')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                            <trix-editor class="attachment-file" placeholder="Input gambar disini" input="attachment-file" data-kind="carousel"></trix-editor>
                        </div>
                        
                            <div class="mb-3">
                                <h4>Status Produk</h4>
                                <input type="radio" class="btn-check" value="1" name="active" id="active_product"
                                    autocomplete="off" checked>
                                <label class="btn btn-outline-success" for="active_product">Aktif</label>
                                
                                <input type="radio" class="btn-check" value="0" name="active" id="deactive_product"
                                    autocomplete="off">
                                <label class="btn btn-outline-danger" for="deactive_product">Nonaktif</label>
                            </div>
                            <button class="btn btn-primary form px-4 mb-4" type="submit">Tambahkan Produk</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
