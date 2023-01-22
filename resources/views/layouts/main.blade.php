<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{asset("css/bootstrap.css");}}">
    <!-- Bootstrap icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{asset("light/dist/css/lightgallery-bundle.css");}}">
    <link rel="stylesheet" href="{{asset("owl/dist/assets/owl.carousel.css");}}">
    <link rel="stylesheet" href="{{asset("owl/dist/assets/owl.theme.default.css");}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <!-- Own Style -->
    <link rel="stylesheet" href="{{asset("css/style.css");}}">


</head>

<body>
    @include("partials/navbar")

    @yield("isi")

    @include("partials/footer")
    
    
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="{{asset("js/bootstrap.bundle.js");}}"></script>
    <script src="js/jquery.js"></script>
    <script src="{{asset("light/dist/lightgallery.umd.js");}}"></script>
    <script src = "{{asset("owl/dist/owl.carousel.min.js");}}"> </script>
    <script>
   
    lightGallery(document.getElementById('animated-thumbnails-gallery'), {
        thumbnail: true,
    });
    $('.owl-carousel').owlCarousel({
    dots:true,
    loop:true,
    margin:10,
    responsive: {
        200: {
            items:1
        },
        1000:{
            items:3
        }
    }
})
    </script>
    <script>
    </script>
</body>

</html>