<nav class="navbar navbar-expand-lg fixed-top bg-light">
  <div class="container">
    <a class="navbar-brand" href="/">Afwaja <span>Shop</span></a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <span class="d-flex">
      <a href="{{route("wishlist.index")}}" class="position-relative me-4">
        <img src="{{asset("icon-heart.svg")}}" />
      <span class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-success">
        99
        <span class="visually-hidden">unread messages</span>
      </a>
      <a href="/cart" class="position-relative ms-2">
        <img src="{{asset("icon-cart.svg")}}" />
      <span class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-success">
        {{\Cart::getContent()->count()}}
        <span class="visually-hidden">Terdapat</span>
      </a>
    </span>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link {{Request::is("/") ? "current" : ""}}" href="/"><i class="fa-solid fa-house"></i> Home</a>
        </li>
        <li class="nav-item border-lg-0">
          <a class="nav-link {{Request::is("produk") ? "current" : ""}}" href="/produk"><i class="fa-solid fa-box"></i> Produk</a>
        </li>
        <li class="nav-item border-lg-0">
          <a class="nav-link" href="#"><i class="fa-solid fa-blog"></i> Postingan</a>
        </li>
        <li class="nav-item border-lg-0">
          <a class="nav-link" href="#"><i class="fa-solid fa-headphones-simple"></i> Contact</a>
        </li>

      </ul>

        <a href='/pesanan' class="btn btn-grad ms-0 px-3 py-2 rounded" type="submit"><i class="fa-solid fa-basket-shopping text-white"></i> Cek Pesanan</a>
    
    </div>
  </div>
</nav>