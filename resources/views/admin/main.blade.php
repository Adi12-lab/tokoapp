<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="{{asset("css/bootstrap.css")}}">

  <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
  <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
  <style>
    section {
      margin-top: 65px;
    }
  </style>
</head>
<body>
  @include("admin.partials.navbar")
  
  @yield("content")
      
   <script src="//cdn.jsdelivr.net/npm/eruda"></script>
    <script>eruda.init();</script>
  <script src="{{asset("js/bootstrap.bundle.js")}}"></script>
</body>
</html>