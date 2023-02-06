@extends("layouts.main")
@section('isi')
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <table class="table">
                    <thead>
                        <tr class="table-success">
                          <th scope="col">Gambar</th>
                          <th scope="col">Nama</th>
                          <th scope="col">Harga</th>
                          <th scope="col">Jumlah</th>
                          <th scope="col">Sub-Harga</th>
                          <th scope="col">Delete</th>
                        </tr>
                      </thead>
                    @foreach ($products as $product)
                      <tr>
                      	<td><img src="{{$product["gambar"]}}" class = "img-fluid"alt=""></td>
                      	<td><a href="">{{$product["nama"]}}</a></td>
                      	<td>{{$product["harga"]}}</td>
                      	<td>{{$product["quantity"]}}</td>
                      	<td>
                      		<a href = "/deleteCart"class="btn removeCart btn-danger"><i class="fa-regular fa-trash-can"></i> Remove</a>
                      		<input type="hidden" value="{{$product["id"]}}" class="form-control">
                      	</td>
                      </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</section>
@endsection