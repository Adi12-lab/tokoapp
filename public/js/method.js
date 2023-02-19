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
  //Dropdown
  $(".dropdown-item").click(function(e) {
    e.preventDefault();
    $(this).parent().siblings().each(function(i, e) {
      $(e).find("i").addClass("invisible");
    });
    if ($(this).parents(".dropdown").hasClass("sort")) {
      
      const nameSort = $(this).attr("data-sort");
      const valueSort = $(this).attr("data-sort-by");
      $(".dropdown-toggle").children(".sortBy").html(nameSort);
      $grid.isotope({
      sortBy: valueSort
    });

    } else{
      const valDropDown = $(this).attr("data-dropdown");
      const dropdown = $(this).parents(".dropdown");
      //Kita ganti htmlnya
      dropdown.find(".dropdown-html").html(valDropDown);
      
        //kita ganti propertinya
      if(dropdown.hasClass("size")) {
        dropdown.find(".dropdown-html").attr("data-select-drop", valDropDown);
      } else if(dropdown.hasClass("variant")) {
        dropdown.find(".dropdown-html").attr("data-select-drop", valDropDown);
        
      }
    }
      $(this).children().removeClass("invisible"); // tag i

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
  $(".update-cart").click(function() {
    let allCart = [];
    $(".cart-id").each(function(i, e) {
      let cartRow = $(e).parents(".cart-row");
      let singleCart = {
      id : cartRow.find(".cart-id").val(),
      name : cartRow.find(".cart-title").html(),
      size : cartRow.find(".size.dropdown .dropdown-html").attr("data-select-drop"),
      variant : cartRow.find(".variant.dropdown .dropdown-html").attr("data-select-drop"),
      quantity : cartRow.find(".form-control .quantity").val()
      };
      allCart.push(singleCart);
    });
    $.ajax({
    url: "/updateCart",
    type: "post",
    headers: {
      'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    },
    data: {request : allCart},
    success: function(text) {
      console.log(text);
    }
  });
    
  });
  //Body detail product
  $('.btn.option').click(function() {
    $(this).siblings().removeClass("active");
    $(this).addClass('active');
  });
  $(".body-product .nav-tabs .nav-link").click(function(e) {
    e.preventDefault();
    $(this).parents(".nav-tabs").find(".nav-link").removeClass("current");
    $(this).addClass("current");
  })
});

//Mengurangi (decrement)
function decrement(element) {
  var input = $(element).siblings(".quantity-form");
  var productId = $(element).parents(".cart-row").find("input[type='hidden']").val();
  if (parseInt(input.val()) == 1) return false;
  var dikurangi = parseInt(input.val())-1;
  input.val(dikurangi);
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