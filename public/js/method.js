$(document).ready(function() {
  //lightgallery
  $(".animated-thumbnails-gallery").each(function(indeks, element) {
    lightGallery(element, {
      thumbnail: true,
    });
  });
  //owl-carousel
  $('.owl-carousel').owlCarousel({
    center: true,
    dots: false,
    nav: true,
    navText: ["<i class='fa-solid fa-chevron-left'></i>", "<i class='fa-solid fa-chevron-right'></i>"],
    loop: true,
    margin: 10,
    autoplay: true,
    autoplayTimeout: 2400,
    responsive: {
      200: {
        items: 1
      },
      600: {
        items: 4
      }
    }
  });
  
  //Dropdown Isotope
  let $grid = $('.grid.product').isotope({
    // options
    itemSelector: '.grid-item',
    getSortData: {
      nama: ".product-title",
      hargaMurah: function(itemElem) {
        return parseInt($(itemElem).find('.product-price').attr('data-price'), 10);
      },
      hargaMahal: function(itemElem) {
        return parseInt($(itemElem).find('.product-price').attr('data-price'), 10);
      }
    },
    layoutMode: 'vertical',
    sortAscending: {
      hargaMahal: false
    }
  });
  //Sorting
  $(".dropdown-item").click(function(e) {
    e.preventDefault();
    $(".dropdown-item").each(function(i, e) {
      $(e).children().addClass("invisible");
    });
    const nameSort = $(this).attr("data-sort");
    const valueSort = $(this).attr("data-sort-by");
    $(".dropdown-toggle").children(".sortBy").html(nameSort);
    $(this).children().removeClass("invisible");

    $grid.isotope({
      sortBy: valueSort
    });

  });

  //Menghapus cart
  $(".removeCart").click(function(e) {
    e.preventDefault();
    const productId = $(this).parents(".cart-row").find("input[type='hidden']").val();
    $.ajax({
      url: "/deleteCart",
      type: "post",
      headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        id: productId
      },
      success: function(text) {
        console.log(text);
        window.location.reload();
      }
    });

  });
  $('.btn.variant').click(function() {
     $(this).siblings().removeClass("active");
     $(this).addClass('active');
  });
});

//Mengurangi (decrement)
function decrement(element) {
  var input = $(element).siblings(".quantity-form");
  var productId = $(element).parents(".cart-row").find("input[type='hidden']").val();
  if (parseInt(input.val()) == 1) return false;
  var dikurangi = parseInt(input.val())-1;
  input.val(dikurangi);
  $.ajax({
    url: "/degQuantity",
    type: "post",
    headers: {
      'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    },
    data: {
      id: productId,
    }

  });
}
function increment(element) {
  var input = $(element).siblings(".quantity-form");
  var productId = $(element).parents(".cart-row").find("input[type='hidden']").val();
  var ditambah = parseInt(input.val())+1;
  input.val(ditambah);
  $.ajax({
    url: "/incQuantity",
    type: "post",
    headers: {
      'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    },
    data: {
      id: productId,
    }

  });
  
}

  
