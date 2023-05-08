const base_url = window.location.origin;
$(document).ready(function () {
  //lightgallery
  $(".animated-thumbnails-gallery").each(function (indeks, element) {
    lightGallery(element, {
      thumbnail: true,
    });
  });
  //==============Owl-carousel======================
  var sync1 = $("#sync1");
  var sync2 = $("#sync2");
  var slidesPerPage = 4; //globaly define number of elements per page
  var syncedSecondary = true;

  sync1.owlCarousel({
    items: 1,
    slideSpeed: 2000,
    autoplay: false,
    dots: false,
    loop: true,
    responsiveRefreshRate: 200,

  }).on('changed.owl.carousel', syncPosition);

  sync2
    .on('initialized.owl.carousel', function () {
      sync2.find(".owl-item").eq(0).addClass("current");
    })
    .owlCarousel({
      items: slidesPerPage,
      dots: false,
      nav: true,
      smartSpeed: 200,
      slideSpeed: 500,
      slideBy: slidesPerPage, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
      responsiveRefreshRate: 100,
      navText: [`<i class="fa-solid fa-arrow-left"></i>`, `<i class="fa-solid fa-arrow-right"></i>`]
    }).on('changed.owl.carousel', syncPosition2);

  function syncPosition(el) {
    //if you set loop to false, you have to restore this next line
    //var current = el.item.index;

    //if you disable loop you have to comment this block
    var count = el.item.count - 1;
    var current = Math.round(el.item.index - (el.item.count / 2) - .5);

    if (current < 0) {
      current = count;
    }
    if (current > count) {
      current = 0;
    }

    //end block

    sync2
      .find(".owl-item")
      .removeClass("current")
      .eq(current)
      .addClass("current");
    var onscreen = sync2.find('.owl-item.active').length - 1;
    var start = sync2.find('.owl-item.active').first().index();
    var end = sync2.find('.owl-item.active').last().index();

    if (current > end) {
      sync2.data('owl.carousel').to(current, 100, true);
    }
    if (current < start) {
      sync2.data('owl.carousel').to(current - onscreen, 100, true);
    }
  }

  function syncPosition2(el) {
    if (syncedSecondary) {
      var number = el.item.index;
      sync1.data('owl.carousel').to(number, 100, true);
    }
  }

  sync2.on("click", ".owl-item", function (e) {
    e.preventDefault();
    var number = $(this).index();
    sync1.data('owl.carousel').to(number, 300, true);
  });

  $(".daftar-galeri").owlCarousel({
    items: 6

  });


  //=======Sorting Harga===========

  //Mixitup
  var grid = document.querySelector(".grid");
  if (grid != null) {
    var mixer = mixitup(grid);
    var sortButtons = document.querySelectorAll('[data-sort]');

    sortButtons.forEach(function (button) {
      button.addEventListener('click', function () {
        var sortValue = this.getAttribute('data-sort');
        mixer.sort(sortValue);
      });
    });
  }
  //Dropdown
  $(".dropdown-item").click(function (e) {
    e.preventDefault();
    $(this)
      .parent()
      .siblings()
      .each(function (i, e) {
        $(e).find("i").addClass("invisible");
      });

    //ini dropdwon untuk sorting
    if ($(this).parents(".dropdown").hasClass("sort")) {
      const valueSort = $(this).data("sort-by");
      $(".dropdown-toggle").children(".sortBy").text(valueSort);

      //ini dropdwon yang lain
    } else {
      const valDropDown = $(this).data("dropdown");
      const dropdown = $(this).parents(".dropdown");
      //Kita ganti htmlnya
      dropdown.find(".dropdown-html").html(valDropDown);
      //kita ganti propertinya
      dropdown
        .find(".dropdown-html")
        .data("select-drop", valDropDown);
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
      type: "get",
      headers: {
        "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content"),
      },
      data: {
        id: productId,
      },
      success: function (text) {
        window.location.reload();
      },
    });
  });

  //Update Cart
  $(".update-cart").click(function () {
    let allCart = []; //Mengandung semua cart
    $(".cart-id").each(function (i, e) {
      let cartRow = $(e).parents(".cart-row");
      cartId = cartRow.find(".cart-id").val();
      cartTitle = cartRow.find(".cart-title").html();
      cartSize = cartRow.find(".size.dropdown .dropdown-html").data("select-drop");
      if (cartSize == undefined) cartSize = null;
      cartVariant = cartRow.find(".variant.dropdown .dropdown-html").data("select-drop");
      if (cartVariant == undefined) cartVariant = null;
      cartQuantity = cartRow.find(".quantity-form").val();
      cartWeight = cartRow.find(".cart-weight").val();

      let singleCart = {
        id: cartId,
        name: cartTitle,
        size: cartSize,
        weight: cartWeight,
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

  //===========Product Blade. php===========

  $(".addCart").click(function () {
    const thisParents = $(this).parents('.product-bottom');
    const cartId = thisParents.find("input[name='id']").val();
    const productName = thisParents.find("input[name='name']").val();
    const productSize = thisParents.find("input[name='size']").val();
    const productWeight = thisParents.find("input[name='weight']").val();
    const productVariant = thisParents.find("input[name='variant']").val();
    const productPrice = thisParents.find("input[name='price']").val();
    const productQuantity = thisParents.find("input[name='quantity']").val();
    const formData = new FormData();
    formData.append("id", cartId);
    formData.append("name", productName);
    formData.append("size", productSize);
    formData.append("weight", productWeight);
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
      success: function () {
        window.location.reload();
      }
    });

  })

  //==========Cart & Raja Ongkir API==========
  
  let dataCost = {
    courier: undefined,
    dataOrigin: [],
    destination: undefined
  };

  let dataCart = {
    nama_penerima: '',
    no_telepon: '',
    email: '',
    province: '',
    city: '',
    expedition: '',
    expedition_package:'',
    alamat: '',
    products: [

    ],

  }
  $.each($('.cart-row'), function(i, item) {

    dataCart.products.push({
      nama:`${$(item).find('.cart-title').text()} ${$(item).find('.dropdown.size .dropdown-html').data('select-drop') ?? ''} ${$(item).find('.dropdown.variant .dropdown-html').data('select-drop') ?? ''}`
    });
  });
  // let cart_totals = {};
  // let dataCostTest = {
  //   courier: "pos",
  //   dataOrigin: [
  //     { origin_code: '23', origin_name: 'Kota Bandung', origin_weight: '1200' },
  //     { origin_code: '431', origin_name: 'Kota Sukabumi', origin_weight: '400' },
  //     { origin_code: '126', origin_name: 'Kabupaten Garut', origin_weight: '200' }],
  //   destination: "232"
  // }

  //semua yang ada di checkout akan didata
  $.each($("input[name='origin_code[]']"), (i, item) => {
    dataCost.dataOrigin.push({
      origin_code: $(item).val(),
      origin_name: $(item).data("name"),
      origin_weight: $(item).data("weight")
    });
  });
  console.log(dataCost);
  // sendDataCost(dataCostTest);
  $.each($('.select-input'), function (i, item) {
    $(item).select2({
      placeholder: $(item).data('placeholder'),
      width: 'resolve'
    })
  });

//Form control yang berada di dalam data-penerima

 $('.form-control').on('change', function(item) {
  const kindForm = $(this).data('kind-form');
  const value = $(this).val();
  switch(kindForm) {
    case 'nama_penerima':
      dataCart.nama_penerima = value;
      break;
    case 'no_telepon':
      dataCart.no_telepon = value;
      break;
    case 'email':
      dataCart.email = value;
      break;
    case 'alamat':
      dataCart.alamat = value;
      break;
    case 'note':
      dataCart.note = value;
  }
  console.log(dataCart);
});

// Select2
  $('.select-input').on("select2:select", function (el) {
    const kindRresidence = $(this).parents(".residence").data("kind-residence");
    const selectedOption = el.params.data.element;
    let optionTemp = `<option value='' selected></option>`;
    switch (kindRresidence) {

      case 'province':
        const residenceCity = $(".residence[data-kind-residence='city']");
        $.ajax({
          url: '/getCity',
          type: 'get',
          data: {
            id: $(this).val()
          },
          beforeSend: function () {
            residenceCity.find('.image-loader').toggleClass('d-none');
          },
          success: function (results) {
            residenceCity.find('.image-loader').toggleClass('d-none');

            $.each(results, function (i, result) {
              optionTemp += `\n<option value='${result.city_id}' data-destination='${result.type} ${result.city_name}'> ${result.type} ${result.city_name}</option>`
            });
            residenceCity.find('.select-input').html(optionTemp);
          }
        });

        dataCart.province = $(selectedOption).text();//Data expedition untuk data Cart

        $('.cart-totals .destination').text('-');
        $('.cart-totals .expedition-cost').data('price', 0);
        $('.cart-totals .expedition-cost').text('0');
        $('.cart-totals .total-cost').text('0')
        $('.cart-totals .total-cost').data('price',0)

        break;
      case 'city':
        dataCost.destination = $(this).val();
        dataCart.city = $(selectedOption).text();
        const destination = $(selectedOption).data('destination');
        $('.cart-totals .destination').text(destination);
        sendDataCost(dataCost);
        $('.cart-totals .expedition-cost').data('price', 0);
        $('.cart-totals .expedition-cost').text('0');
        $('.cart-totals .total-cost').text('0');
        $('.cart-totals .total-cost').data('price',0)
        break;
      case 'expedition':
        dataCost.courier = $(this).val();
        dataCart.expedition = $(this).val();
        sendDataCost(dataCost);
        $('.cart-totals .expedition-cost').data('price', 0);
        $('.cart-totals .expedition-cost').text('0');
        $('.cart-totals .total-cost').text('0')
        $('.cart-totals .total-cost').data('price',0)
        break;
      case 'expedition_package':
        dataCart.expedition_package = $(selectedOption).data('label');
        const subTotal = $('.cart-totals .sub-total').data('price');
        const expeditionCost = $(selectedOption).data('price');

        const totalCost = subTotal + expeditionCost;

        $('.cart-totals .expedition-cost').data('price', expeditionCost);
        $('.cart-totals .expedition-cost').text(rupiah(expeditionCost));
        $('.cart-totals .total-cost').data('price', totalCost);
        $('.cart-totals .total-cost').text(rupiah(totalCost));
        
    }
  })
  //Mengambil data untuk diproses dalam sebuah event keyup

  // Tombol checkout cart

  $(".cart-checkout").click(function () {
    const {nama_penerima, no_telepon,email, province, city, expedition_package, alamat, note} = dataCart;
    $('.alert-error').addClass('d-none');
    if(nama_penerima != '' && no_telepon != '' && email != '' && alamat != '' && province != '' && city != '' && expedition_package != '' ) {
      console.log("data siap dikirimkan");
    } else {
      const keys = Object.keys(dataCart);
      const emptyData = keys.filter(key => dataCart[key] == '');

      emptyData.forEach(function(item) {
        $(`.alert-error.${item}`).removeClass('d-none');
      });
      console.log(dataCart);

    }
    
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
$(".addCart.body").click(function () {
  const cartId = $(".cartId").val();
  const productName = $(".productName").text();
  const productSize = $(".option.size.active").data("size");
  const productWeight = productSize ? $(".option.size.active").data("weight-size") : $("input[name='weight']").val();
  const productVariant = $(".option.variant.active").data("variant");
  const productPrice = productSize ? $(".option.size.active").data("price-size") : $("input[name='price']").val();
  const productQuantity = $(".quantity-form").val();
  const formData = new FormData();
  formData.append("id", cartId);
  formData.append("name", productName);
  formData.append("size", productSize);
  formData.append("weight", productWeight);
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
    success: function () {
      window.location.reload();
    }
  });
  // formData.append()
});

//product Detail body navigation
$(".nav-body").find(".nav-link").each(function (i, e) {
  $(e).click(function (el) {
    //kita ambil tujuannya
    let destiny = $(this).attr("data-body");
    el.preventDefault();
    //hilanhkan kelas curent
    $(".nav-body").find(".nav-link").each(function () {
      $(this).removeClass("current");
    });
    //tambahkan kelas current
    $(this).addClass("current");
    //hilangkan body content
    $(".body-content").each(function (e) {
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
    url: '/clearCart',
    type: 'get',
    headers: {
      "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content"),
    },
    success: function () {
      window.location.reload();
    },
  });
}


function sendDataCost(data) {
  if (data.courier != undefined && data.destination != undefined) {
    console.log(data);
    let optionTemp = `<option value=''> </option>`;
    const residenceExpeditionPackage = $(".residence[data-kind-residence='expedition_package']");
    $.ajax({
      url: '/getCost',
      type: 'get',
      dataType: "json",
      data: {
        dataCost: data
      },
      beforeSend: function () {
        residenceExpeditionPackage.find(".image-loader").toggleClass('d-none')
      },
      success: function (response) {
        console.log(response);

        //setelah itu tambahkan itemnya
        $.each(response, (i, item) => {
          optionTemp += `\n<option value='${item.service}' data-price='${item.total_cost}' data-label='${item.description} ${item.service}'>  ${item.description} (${item.service}) <span class="text-danger d-inline-block ms-auto">${rupiah(item.total_cost)}</span> </option> `
        });

        residenceExpeditionPackage.find('.select-input').html(optionTemp);
        residenceExpeditionPackage.find(".image-loader").toggleClass("d-none");//Hilangkan loadernya

      }
    })
  }
}

function rupiah(num) {
  return "Rp " + num.toLocaleString("id-ID");
}

