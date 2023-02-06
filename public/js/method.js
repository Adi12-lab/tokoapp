$(document).ready(function() {
    //lightgallery
    lightGallery(document.getElementById('animated-thumbnails-gallery'), {
        thumbnail: true,
    });
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

    $(".grid-item a.btn").click(function(e) {
        e.preventDefault();
        const namaProduct = $(this).parents(".card-body").children(".product-title").text();
        console.log(namaProduct);

    });


    $(".removeCart").click(function(e) {
        e.preventDefault();
        const productId = $(this).siblings(".form-control").val();
        $.ajax({
            url: "/deleteCart",
            type: "post",
            headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
            data: {
                id: productId
            },
            success: function(text) {
                console.log(text);
                window.location.reload();
            }
        });

    });

});
