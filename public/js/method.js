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

  // Isotope
  let $grid = $(".grid.product").isotope({
    // options
    itemSelector: ".grid-item",
    getSortData: {
      nama: ".product-title",
      hargaMurah: function (itemElem) {
        return parseInt(
          $(itemElem).find(".product-price").data("price"),
          10
        );
      },
      hargaMahal: function (itemElem) {
        return parseInt(
          $(itemElem).find(".product-price").data("price"),
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

    //ini dropdwon untuk sorting
    if ($(this).parents(".dropdown").hasClass("sort")) {
      const nameSort = $(this).data("sort");
      const valueSort = $(this).data("sort-by");
      $(".dropdown-toggle").children(".sortBy").html(nameSort);
      $grid.isotope({
        sortBy: valueSort,
      });

      //ini dropdwon yang lain
    } else {
      const valDropDown = $(this).data("dropdown");
      const dropdown = $(this).parents(".dropdown");
      //Kita ganti htmlnya
      dropdown.find(".dropdown-html").html(valDropDown);

      //kita ganti propertinya
      if (dropdown.hasClass("size")) {
        dropdown
          .find(".dropdown-html")
          .data("select-drop", valDropDown);
      } else if (dropdown.hasClass("variant")) {
        dropdown
          .find(".dropdown-html")
          .data("select-drop", valDropDown);
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
  let provinceDrop = [];
  let cityDrop = [];
  let dataCost = {
    courier: undefined,
    dataOrigin: [],
    destination: undefined
  };
  let cart_totals = {};
  let dataCostTest = {
    courier: "pos",
    dataOrigin: [
      { origin_code: '23', origin_name: 'Kota Bandung', origin_weight: '1200' },
      { origin_code: '431', origin_name: 'Kota Sukabumi', origin_weight: '400' },
      { origin_code: '126', origin_name: 'Kabupaten Garut', origin_weight: '200' }],
    destination: "232"
  }

  $.each($("input[name='origin_code[]']"), (i, item) => {
    dataCost.dataOrigin.push({
      origin_code: $(item).val(),
      origin_name: $(item).data("name"),
      origin_weight: $(item).data("weight")
    });
  });
  // sendDataCost(dataCostTest);
  $.each($(".residence[data-kind-residence=province] .dropdown-menu-body").children(".drop-list"), (i, item) => {//ambil semua element dan masukan pada provinceDrop
    // console.log(item)
    provinceDrop.push([$(item).data("id"), $(item).text()]);
  });

  $('.dropdown-menu-body').on('click', '.drop-list', function (e) {
    let tempDrop = []; //tempDrop dapat berisi dari provinceDrop cityDrop dll

    //Ambil saudaranya, dan hilangkan kelas active
    $(this).siblings('.drop-list').removeClass('active');
    const drop_list = $(this).text();
    //Ambil orangtuanya(residence) dan temukan dropdown-toggle yang spesifik
    $(this).parents(".residence").find(".label-dropdown").addClass("d-none");// hilangkan label
    $(this).parents(".residence").find('.label-active').text(drop_list).removeClass("d-none"); //aktifkan yang aktif

    const kindRresidence = $(this).parents(".residence").data("kind-residence");
    const dropdownMenu = $(this).parents(".dropdown-menu-body");

    switch (kindRresidence) {
      //Jika residence yang dipilih adalah provinsi
      case "province":
        tempDrop = provinceDrop;
        //Ubah label dropdown city (menjadi pilih kabupaten/kota)
        $(".residence[data-kind-residence='city']").find(".label-dropdown").removeClass("d-none");
        $(".residence[data-kind-residence='city']").find(".label-active").addClass("d-none");
        $(".residence[data-kind-residence='city']").find(".dropdown-menu-body").empty();


        $.ajax({
          url: "/getCity",
          type: "get",
          dataType: "json",

          data: {
            id: $(this).data("id")
          },
          beforeSend: function () {
            // Menampilkan loader
            $(".residence[data-kind-residence='city']").find('.image-loader').toggleClass('d-none');
          },
          success: function (results) {
            const result = results.rajaongkir.results;
            let residenceCityBody = $('.residence[data-kind-residence="city"] .dropdown-menu-body');
            //kosongkan terlebih dahulu
            residenceCityBody.empty();

            //setelah itu tambahkan itemnya
            $.each(result, (i, item) => {
              residenceCityBody.append(`
              <li class="drop-list" data-id="${item.city_id}">
              ${item.type} ${item.city_name}
              </li>
              `);
            });
            //Di push ke variabel cityDrop untuk digunakan kembali untuk case berikutnya
            residenceCityBody.children('.drop-list').each(function (i, e) {
              cityDrop.push([$(e).data("id"), $(e).text()]);
            });
            $(".residence[data-kind-residence='city']").find(".image-loader").toggleClass("d-none");//Hilangkan loadernya

          }
        });

        //tambahkan data untuk city
        break;
      case "city":
        tempDrop = cityDrop;
        // Tujuan, untuk cost
        dataCost.destination = $(this).data("id");
        $(".residence[data-kind-residence='expedition-package']").find(".label-dropdown").removeClass("d-none");
        $(".residence[data-kind-residence='expedition-package']").find(".label-active").addClass("d-none");
        $(".residence[data-kind-residence='expedition-package']").find(".dropdown-menu-body").empty();
        $(".cart-totals").find(".destination").text($(this).text());
        sendDataCost(dataCost); //Kirim data untuk diproses biayanya
        break;
      case 'expedition':
        dataCost.courier = $(this).data("courier");
        dropdownMenu.children(`.drop-list[data-courier="${$(this).data("courier")}"]`).addClass("active");
        $(".residence[data-kind-residence='expedition-package']").find(".label-dropdown").removeClass("d-none");
        $(".residence[data-kind-residence='expedition-package']").find(".label-active").addClass("d-none");
        $(".residence[data-kind-residence='expedition-package']").find(".dropdown-menu-body").empty();
        sendDataCost(dataCost); //Kirim data untuk diproses biayanya
        return;
      case 'expedition-package':
        dropdownMenu.children(`.drop-list[data-service="${$(this).data("service")}"]`).addClass("active");
        console.log(typeof $(this).data("price"));
        const ongkir = $(this).data("price");
        //Di tulis di ongkirnya
        $(".cart-totals").find(".ongkir").data("price", ongkir);
        $(".cart-totals").find(".ongkir").text(rupiah(ongkir));

        //Sub total + ongkir
        const subTotal = $(".cart-totals").find(".sub-total").data("price");
        const total = ongkir + subTotal;

        //letakkan di total cost

        $(".cart-totals").find(".total-cost").data("price", total);
        $(".cart-totals").find(".total-cost").text(rupiah(total));
        return;
      default:
        console.log("dropdown cart not found");
        return;
    }
    dropdownMenu.siblings(".dropdown-input").val(''); //Kosongkan searchnya
    dropdownMenu.empty(); //Kosongkan semua drop list yang berada di dropdown-menu-body
    //isi semua dengan data yang ada
    $.each(tempDrop, (i, item) => {
      dropdownMenu.append(`<li class="drop-list" data-id="${item[0]}">${item[1]}</li>`);
    });
    dropdownMenu.children(`.drop-list[data-id="${$(this).data("id")}"]`).addClass("active"); //jadikan data yang sekarang menjadi active

  });

  //Mengambil data untuk diproses dalam sebuah event keyup
  $('.dropdown-input').on('keyup', function () {
    let dropdownMenu = $(this).siblings(".dropdown-menu-body");
    dropdownMenu.empty();
    //Ambil inputwn

    let arrDropList = [];
    switch (dropdownMenu.parents(".residence").data("kind-residence")) {
      case "province":
        arrDropList = provinceDrop;
        break;
      case "city":
        arrDropList = cityDrop;
        break;
      default:
        console.log("not found");
    }
    const searchValue = $(this).val().toLowerCase();
    //Ambil drop_list
    let result = arrDropList.filter((item) => item[1].toLowerCase().includes(searchValue));
    $.each(result, (i, item) => {
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
    $.ajax({
      url: '/getCost',
      type: 'get',
      dataType: "json",
      data: {
        dataCost: data
      },
      headers: {
        "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content"),
      },
      beforeSend: function () {
        $(".residence[data-kind-residence='expedition-package']").find('.image-loader').toggleClass('d-none');
      },
      success: function (response) {
        console.log(response);

        let expeditionPackage = $('.residence[data-kind-residence="expedition-package"] .dropdown-menu-body');
        //kosongkan terlebih dahulu
        expeditionPackage.empty();
        //setelah itu tambahkan itemnya
        $.each(response, (i, item) => {
          expeditionPackage.append(`
          <li class="drop-list d-flex" data-service="${item.service}" data-price='${item.total_cost}'> ${item.description} (${item.service}) <span class="text-danger d-inline-block ms-auto">Rp ${item.total_cost}</span>
          </li>
          `);
        });
        $(".residence[data-kind-residence='expedition-package']").find(".image-loader").toggleClass("d-none");//Hilangkan loadernya

      }
    })
  }
  else {
    console.log("data belum siap");
  }
}

function rupiah(num) {
  return "Rp "+num.toLocaleString("id-ID"); 
}
