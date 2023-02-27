@extends("admin.main")
@section("content")
<section>
  <div class="container">
    <h1>Buat Produk</h1>
    <div class="row">

      <form action="/metal/products" method="post" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
          <label for="name" class="form-label">Nama Produk</label>
          <input type="text" class="form-control @error("name") is-invalid @enderror" value="{{old("name")}}" id="name" name="name">
          @error("name")
          <div class="invalid-feedback">
            {{$mesagge}}
          </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="slug" class="form-label">Slug</label>
          <input type="text" class="form-control @error("slug") is-invalid @enderror" value="{{old("slug")}}" id="slug" name="slug">
          @error("slug")
          <div class="invalid-feedback">
            {{$message}}
          </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="kelompok" class="form-label">Kelompok</label>
          <input type="text" class="form-control @error("kelompok") is-invalid @enderror" value="{{old("kelompok")}}" id="kelompok" name="kelompok">
          @error("kelompok")
          <div class="invalid-feedback">
            {{$message}}
          </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="stok" class="form-label">Stok</label>
          <input type="text" class="form-control @error("stok") is-invalid @enderror" value="{{old("stok")}}" id="stok" name="stok">
          @error("stok")
          <div class="invalid-feedback">
            {{$message}}
          </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="price" class="form-label">Harga</label>
          <input type="text" class="form-control @error("price") is-invalid @enderror" value="{{old("price")}}" id="price" name="price">
          @error("price")
          <div class="invalid-feedback">
            {{$message}}
          </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="image" class="form-label">Gambar</label>
          <img class="img-preview d-block mb-3" style="width:500px;">
          <input type="file" class="form-control @error("image") is-invalid @enderror" id="image" name="image" onchange="previewImage()">
          @error("image")
          <div class="invalid-feedback">
            {{$message}}
          </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="deskripsi" class="form-label">Deskripsi</label>
          <input id="deskripsi" type="hidden" name="deskripsi" value="{{old("deskripsi")}}">
          @error("deskripsi")
          <p class="text-danger">
            {{$message}}
          </div>
          @enderror
          <trix-editor input="deskripsi"></trix-editor>
        </div>

        <div class="mb-3">
          <label for="body" class="form-label">Body</label>
          <input id="body" type="hidden" name="body" value="{{old("body")}}">
          @error("body")
          <p class="text-danger">
            {{$message}}
          </div>
          @enderror
          <trix-editor input="body"></trix-editor>
        </div>
        <button class="btn btn-success my-3" type="submit">Buat Produk</button>
      </form>
    </div>
  </div>
</section>
@endsection