<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
</head>
<body>
  <div class="container">
    <div class="row">
      <h1 class="my-2">Halaman Login Admin</h1>
      @if(session("invalid"))
      <div class="alert alert-danger" role="alert">
        {{session('invalid')}}
      </div>
      @endif
      <form action="{{route('authenticate')}}" method="post">
        @csrf
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="username" class="form-control" name="username" id="username" value="{{old('username')}}">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="password">
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="remember" name="remember">
          <label class="form-check-label" for="remember">Remember me</label>
        </div>
        <button type="submit" class="btn btn-primary" class="login">Login</button>
      </form>
    </div>
  </div>
  <script src="{{asset('js/bootstrap.bundle.js')}}"></script>
</body>
</html>