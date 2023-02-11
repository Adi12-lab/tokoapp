@extends("admin.main")
@section("content")
<section class="">
  <div class="container">
    <div class="row">
      <h1 class="">Selamat Datang Admin</h1>
      <form action="{{route('logout')}}"method="post">
        @csrf
        <button class="btn btn-danger" type="submit">Logout</button>
      </form>
    </div>
  </div>
</section>
@endsection