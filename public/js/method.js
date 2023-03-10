$(document).ready(function () {
  //lightgallery
  $(".animated-thumbnails-gallery").each(function (indeks, element) {
    lightGallery(element, {
      thumbnail: true,
    });
  });
  //owl-carousel
  $(".owl-carousel").owlCarousel({
    center: true,
    dots: false,
    nav: true,
    navText: [
      "<i class='fa-solid fa-chevron-left'></i>",
      "<i class='fa-solid fa-chevron-right'></i>",
    ],
    loop: true,
    margin: 10,
    autoplay: true,
    autoplayTimeout: 2400,
    responsive: {
      200: {
        items: 1,
      },
      600: {
        items: 4,
      },
    },
  });

  //Dropdown Isotope
  let $grid = $(".grid.product").isotope({
    // options
    itemSelector: ".grid-item",
    getSortData: {
      nama: ".product-title",
      hargaMurah: function (itemElem) {
        return parseInt(
          $(itemElem).find(".product-price").attr("data-price"),
          10
        );
      },
      hargaMahal: function (itemElem) {
        return parseInt(
          $(itemElem).find(".product-price").attr("data-price"),
          10
        );
      },
    },
    layoutMode: "vertical",
    sortAscending: {
      hargaMahal: false,
    },
  });
  //Dropdown
  $(".dropdown-item").click(function (e) {
    e.preventDefault();
    $(this)
    .parent()
    .siblings()
    .each(function (i, e) {
      $(e).find("i").addClass("invisible");
    });
    if ($(this).parents(".dropdown").hasClass("sort")) {
      const nameSort = $(this).attr("data-sort");
      const valueSort = $(this).attr("data-sort-by");
      $(".dropdown-toggle").children(".sortBy").html(nameSort);
      $grid.isotope({
        sortBy: valueSort,
      });
    } else {
      const valDropDown = $(this).attr("data-dropdown");
      const dropdown = $(this).parents(".dropdown");
      //Kita ganti htmlnya
      dropdown.find(".dropdown-html").html(valDropDown);

      //kita ganti propertinya
      if (dropdown.hasClass("size")) {
        dropdown
        .find(".dropdown-html")
        .attr("data-select-drop", valDropDown);
      } else if (dropdown.hasClass("variant")) {
        dropdown
        .find(".dropdown-html")
        .attr("data-select-drop", valDropDown);
      }
    }
    $(this).children().removeClass("invisible"); // tag i
  });
//----AFWAJA SHOP CART-----

  //Menghapus cart
  $(".removeCart").click(function (e) {
    e.preventDefault();
    const productId = $(this)
    .parents(".cart-row")
    .find("input[type='hidden']")
    .val();
    $.ajax({
      url: "/deleteCart",
      type: "post",
      headers: {
        "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content"),
      },
      data: {
        id: productId,
      },
      success: function (text) {
        console.log(text);
        window.location.reload();
      },
    });
  });
  
  //Update Cart
  $(".update-cart").click(function () {
    let allCart = [];
    $(".cart-id").each(function (i, e) {
      let cartRow = $(e).parents(".cart-row");
      cartId = cartRow.find(".cart-id").val();
      cartTitle = cartRow.find(".cart-title").html();
      cartSize = cartRow.find(".size.dropdown .dropdown-html").attr("data-select-drop");
      if (cartSize == undefined) cartSize = null;
      cartVariant = cartRow.find(".variant.dropdown .dropdown-html").attr("data-select-drop");
      if (cartVariant == undefined) cartVariant = null;
      cartQuantity = cartRow.find(".quantity-form").val();

      let singleCart = {
        id: cartId,
        name: cartTitle,
        size: cartSize,
        variant: cartVariant,
        quantity: cartQuantity,
      };
      allCart.push(singleCart);
    });

    $.ajax({
      url: "/updateCart",
      type: "post",
      headers: {
        "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content"),
      },
      data: {
        request: allCart
      },
      success: function (text) {
        window.location.reload();
        // window.location.reload();
      },
    });
  });
  

  const orginalDrop = [];
  $(".drop-list").each(function(i,item) {
    orginalDrop.push([$(item).data("id"), $(item).text()]);
  });
  
  $('.dropdown-menu-body').on('click', '.drop-list',function(e) {
    //Ambil saudaranya, dan hilangkan kelas active
    $(this).siblings('.drop-list').removeClass('active');
    const drop_list = $(this).text();
    //Ambil orangtuanya(residence) dan temukan dropdown-toggle yang spesifik
    $(this).parents(".residence").find('.dropdown-toggle').html(drop_list);
    const dropdownMenu =$(this).parents(".dropdown-menu-body");
    dropdownMenu.siblings(".dropdown-input").val('');
    dropdownMenu.empty();
    $.each(orginalDrop, (i, item) => {
      dropdownMenu.append(`<li class="drop-list" data-id="${item[0]}">${item[1]}</li>`);
    });
    $(`.drop-list[data-id="${$(this).data("id")}"]`).addClass("active");
    
    $.ajax({
      url:"/getCity",
      type:"get",
      dataType:"json",
      data: {
        id:$(this).data("id")
      },
      success: function(results) {
        const result = results.rajaongkir.results;
        $(".residence.city .dropdown-menu-body").empty();
        $.each(result, (i,item) => {
          $(".residence.city .dropdown-menu-body").append(`
          <li class="drop-list" data-id="${item.city_id}">
            ${item.type} ${item.city_name}
          </li>
          `);
        });
      }
    });
  });
  
  

  let arrDropList = [];
  $(".drop-list").each(function(i, e) {
    arrDropList.push([$(e).data("id"), $(e).text().toLowerCase()]);
  });
  
  

  $('.dropdown-input').on('keyup', function() {
    let dropdownMenu = $(this).siblings(".dropdown-menu-body");
    dropdownMenu.empty();
    //Ambil inputwn
    const searchValue = $(this).val().toLowerCase();
    //Ambil drop_list
    let result = arrDropList.filter((item) => item[1].includes(searchValue)).
    map(
      (str) => [str[0], str[1].split(" "). // [sumatra, barat]
        map((word) => word.charAt(0).toUpperCase() + word.slice(1)).
        join("  ")]
    );
    $.each(result, (i,item) => {
    dropdownMenu.append(`<li class="drop-list" data-id="${item[0]}">${item[1]}</li>`);
    });
  });

  
  //Body detail product
  $(".btn.option").click(function () {
    $(this).siblings().removeClass("active");
    $(this).addClass("active");
  });
  $(".body-product .nav-tabs .nav-link").click(function (e) {
    e.preventDefault();
    $(this).parents(".nav-tabs").find(".nav-link").removeClass("current");
    $(this).addClass("current");
  });
});
$(".checkout").click(function () {
  const cartId = $(".cartId").val();
  const productName = $(".productName").html();
  const productSize = $(".option.size.active").attr("data-size");
  const productVariant = $(".option.variant.active").attr("data-variant");
  const productPrice = $(".option.size.active").attr("data-price-size");
  const productQuantity = $(".quantity-form").val();
  const formData = new FormData();
  formData.append("id", cartId);
  formData.append("name", productName);
  formData.append("size", productSize);
  formData.append("price", productPrice);
  formData.append("variant", productVariant);
  formData.append("quantity", productQuantity);


  $.ajax({
    url: "/addCart",
    type: "post",
    headers: {
      "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content"),
    },
    data: formData,
    processData: false,
    contentType: false,
    success: function() {
      window.location.reload();
    },
    error: function (jqXHR,
      textStatus,
      errorThrown) {
      console.log(jqXHR);
      console.log(textStatus);
      console.log(errorThrown);
    }


  });
  // formData.append()
});

//product Detail body navigation
$(".nav-body").find(".nav-link").each(function(i, e) {
  $(e).click(function(el) {
    //kita ambil tujuannya
    let destiny = $(this).attr("data-body");
    el.preventDefault();
    //hilanhkan kelas curent
    $(".nav-body").find(".nav-link").each(function() {
      $(this).removeClass("current");
    });
    //tambahkan kelas current
    $(this).addClass("current");
    //hilangkan body content
    $(".body-content").each(function(e) {
      $(this).fadeOut(500).addClass("d-none");
    });
    //munculkan body content
      $(`.${destiny}`).fadeIn(500).removeClass("d-none");
  });
});

//Mengurangi (decrement)
function decrement(element) {
  var input = $(element).siblings(".quantity-form");
  var productId = $(element)
  .parents(".cart-row")
  .find("input[type='hidden']")
  .val();
  if (parseInt(input.val()) == 1) return false;
  var dikurangi = parseInt(input.val()) - 1;
  input.val(dikurangi);
}

//Menambah (increment)
function increment(element) {
  var input = $(element).siblings(".quantity-form");
  var productId = $(element)
  .parents(".cart-row")
  .find("input[type='hidden']")
  .val();
  var ditambah = parseInt(input.val()) + 1;
  input.val(ditambah);
  
}

function clearCart() {
  $.ajax({
    url:'/clearCart',
    type: 'get',
    headers: {
      "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content"),
    },
    success: function() {
      window.location.reload();
    },
  });
}

