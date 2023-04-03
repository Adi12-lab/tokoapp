<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content={{csrf_token()}}>
  <title>Document</title>
  <link rel="stylesheet" href="{{asset("css/bootstrap.css")}}">
  <link rel="stylesheet" href="{{asset("css/styleAdmin.css")}}">

  <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
  <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
  <style>
    section {
      margin-top: 65px;
    }
  </style>
</head>
<body>
  @include("admin.partials.navbar")
  
  @yield("content")
 
  <script src="{{asset("js/jquery.js");}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="{{asset("js/bootstrap.bundle.js")}}"></script>
  <script src="{{asset("js/methodAdmin.js")}}"></script>
</body>
</html>