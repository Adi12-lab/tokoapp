
<nav class="navbar navbar-expand-lg fixed-top bg-light">
  <div class="container">
    <a class="navbar-brand" href="/">Afwaja <span>Shop</span></a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
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
      <form class="d-flex" role="search">
        <input class="form-control rounded-0 me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-grad ms-0 rounded-0" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>