<?php
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use App\Models\Product;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
    
});

// Home > Produk
Breadcrumbs::for('produk', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Produk', route('produk'));
    
});
// Home > Cart
Breadcrumbs::for('cart', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Cart', route('cart'));
    
});

// Home > Produk > [ProdukTitle]
Breadcrumbs::for('produk.name', function (BreadcrumbTrail $trail, Product $produk ) {
    $trail->parent('produk');
    $trail->push($produk->name, route('produk.name', $produk->slug));
    
});