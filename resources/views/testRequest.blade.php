@extends("admin.main")

@section('content')
<div class="container mt-4">
    <form action="/metal/testRequest" method="post">
        @csrf
        <button type="button" class="add_row_button">Tambah tr</button>
        <table>
            <thead class="body_table_size">
                <tr>
                    <td><input type="text" name="input_test[]"></td>
                </tr>
            </thead>
        </table>
        <button type="submit">submit</button>
    </form>
</div>
@endsection