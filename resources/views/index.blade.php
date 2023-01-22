@extends("layouts/main")
@section("isi")
<section class="header">
  <div class="container-fluid">
    <div class="header-hero row justify-content-center">
      <div class="col-md-10 d-flex align-items-center">
        <div class="header-hero-content">
          <h1>Temukan keperluan untuk ibadahmu disini </h1>
          <p class="fs-5">
            Tentunya dengan aman dan terpercaya dan insyallah berkah.
          </p>
          <a href="" class="btn d-block p-3 rounded border-0 text-decoration-none">Baca Lanjut</a>
        </div>
      </div>
    </div>
   </div>
</section>

<section class="about">
  <div class="container-fluid">
    <div class="row mt-4">
      <div id="animated-thumbnails-gallery" class="col-md-6 d-flex flex-wrap justify-content-end">
        <a href="img/home/header-1.jpg" class="gallery-item d-block me-2">
          <img src="img/home/header-1.jpg" class="">
        </a>
        <a href="img/home/header-2.jpg" class="gallery-item d-block">
          <img src="img/home/header-2.jpg" class="">
        </a>
        <span class="d-inline-block p-3 text-white text-center mt-2 d-flex align-items-center">
          "Demi Allah aman dan terpercaya"
        </span>
        <a href="img/home/header-2.jpg" class="gallery-item d-block mt-2">
          <img src="img/home/header-3.jpg" class="">
        </a>

      </div>
      <div class="col-md-6">
         <h3 class="mt-4">Dapatkanlah di Afwaja Shop</h3>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo error impedit, expedita perspiciatis quisquam laborum consequuntur voluptas, in, nobis illum nisi voluptates aliquam debitis!
        </p>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur doloremque libero, tempora excepturi similique?
        </p>
        <a href="" class="about-link btn px-3 py-2"> Baca Lanjut</a>
      </div>
    </div>
    
  </div>
  
</section>

<!-- Start Reason -->
<section class="reason">
  <div class="container-fluid">
    <div class="row title position-relative">
      <span class="pre-title d-block mb-4">Lihat alasan mengapa beli disini</span>
      <h1 class="text-center ">Kenapa membeli disini ?</h1>
    </div>
    <div class="row g-4 alasan p-5 mt-3">
      <div class="col-lg-3 col-md-6 my-2">
        <div class="card border-0 p-3 text-center">
          <i class="fa-solid fa-tags"></i>
          <div class="card-body">
            <h5 class="card-title text-center">Harga Terjangkau</h5>
            <p class="card-text">
              Some quick example text to build on the card title and make up the bulk of the card's content.
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 my-2">
        <div class="card border-0 p-3 text-center">
          <i class="fa-solid fa-truck-fast"></i>
          <div class="card-body">
            <h5 class="card-title text-center">Pengiriman cepat</h5>
            <p class="card-text">
              Some quick example text to build on the card title and make up the bulk of the card's content.
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 my-2">
        <div class="card border-0 p-3 text-center">
          <i class="fa-solid fa-stopwatch"></i>
          <div class="card-body">
            <h5 class="card-title text-center">Waktu proses cepat</h5>
            <p class="card-text">
              Some quick example text to build on the card title and make up the bulk of the card's content.
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 my-2">
        <div class="card border-0 p-3 text-center">
          <i class="fa-solid fa-box"></i>
          <div class="card-body">
            <h5 class="card-title text-center">Barang berkualitas</h5>
            <p class="card-text text-wrap">
              Some quick example text to build on the card title and make up the bulk of the card's content.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End reason -->

<!--Quotes-->
<section class="quotes">
  <div class="container-fluid">
    <div class="row px-2 px-md-0 justify-content-center">
      <div class="quotes-content col-md-11 rounded fs-4 text-white p-5">
      " Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt quaerat doloremque dolore in aliquid voluptates placeat atque aut! Similique ducimus non explicabo laudantium, ipsa veritatis labore distinctio, modi consectetur totam eveniet repellat! "
      </div>
    </div>
  </div>
</section>

<!--End Quotes-->

<!-- Produk -->
<section class="produk">
  <div class="container-fluid">
    <div class="row title text-center my-3">
      <span class="pre-title d-block mb-4">Lihat produk kami</span>
      <h1>Produk</h1>
      <p>Dibawah ini adalah produk - produk dari afwaja shop yang sering dibeli oleh mereka yang percaya</p>
    </div>
    <div class="daftar-produk row py-2 g-4 mt-3">
          @foreach($products as $product)
      <div class="col-md-4">
          <div class="card border-0">
            <img src="img/produk/{{$product->gambar}}" class="card-img-top rounded-4" alt="...">
            <div class="card-body border-transparent p-2">
              <a class="produk-title d-inline-block text-decoration-none">{{$product->nama}}</a>

              <div class="product-card-bottom">
                <span class="produk-price">Rp. {{$product->harga}}</span>
                <span class="produk-price-old text-decoration-line-through">Rp. {{$product->harga}}</span>
                <a href="" class="btn add"><i class="bi bi-cart"></i> Add</a>
                <a href="/products/{{$product->slug}}" class="btn btn-detail d-block mt-3">Detail</a>
              </div>

            </div>
          </div>
      </div>
          @endforeach
    </div>
  </div>
</section>
<!-- End Produk -->

<!-- Galeri -->
<section class="galeri">
  <div class="container mt-4">
    <div class="row title my-3">
      <h1 class="text-center">Galeri</h1>
    </div>
    <div id="animated-thumbnails-gallery" class="row justify-content-center">
      <a href="img/home/gallery/gambar1.jpg " class="gallery-item d-block">
        <img src="img/home/gallery/gambar1.jpg" class="img-thumbnail">
      </a>
      <a href="img/home/gallery/gambar2.jpg" class="gallery-item d-block">
        <img src="img/home/gallery/gambar2.jpg" class="img-thumbnail">
      </a>
      <a href="img/home/gallery/gambar3.jpg" class="gallery-item d-block">
        <img src="img/home/gallery/gambar3.jpg" class="img-thumbnail">
      </a>
      <a href="img/home/gallery/gambar4.jpg" class="gallery-item d-block">
        <img src="img/home/gallery/gambar4.jpg" class="img-thumbnail">
      </a>
      <a href="img/home/gallery/gambar5.jpg" class="gallery-item d-block">
        <img src="img/home/gallery/gambar5.jpg" class="img-thumbnail">
      </a>
      <a href="img/home/gallery/gambar6.jpg" class="gallery-item d-block">
        <img src="img/home/gallery/gambar6.jpg" class="img-thumbnail">
      </a>
      <a href="img/home/gallery/gambar7.jpg" class="gallery-item d-block">
        <img src="img/home/gallery/gambar7.jpg" class="img-thumbnail">
      </a>
      <a href="img/home/gallery/gambar8.jpg" class="gallery-item d-block">
        <img src="img/home/gallery/gambar8.jpg" class="img-thumbnail">
      </a>
    </div>
  </div>
</section>
<!-- End Galeri -->





@endsection