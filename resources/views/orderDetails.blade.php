<!doctype htms>
<html>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Pesanan Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato&family=Quicksand:wght@500;600;700&display=swap');

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Lato', sans-serif
        }

        body {
            background: linear-gradient(150deg, #97c74e 0%, #2ab9a5 100%);
        }

        h5 {
            color: #3bb77e;
            font-weight: 700;
        }

        #order-heading {
            background-color: #edf4f7;
            position: relative;
            border-top-left-radius: 25px;
            max-width: 800px;
            padding-top: 20px;
            margin: 30px auto 0px
        }

        #order-heading .text-uppercase {
            font-size: 0.9rem;
            color: #777;
            font-weight: 600
        }

        #order-heading .h4 {
            font-family: "Quicksand", sans-serif;
            font-weight: 700;
        }

        #order-heading .h4+div p {
            font-size: 0.8rem;
            color: #777
        }

        .wrapper {
            padding: 0px 50px 50px;
            max-width: 800px;
            margin: 0px auto 70px;
            border-bottom-left-radius: 25px;
            border-bottom-right-radius: 25px;
            background-color: #f7fced;
            box-shadow: rgba(17, 17, 26, 0.05) 0px 4px 16px, rgba(17, 17, 26, 0.05) 0px 8px 32px;
        }

        .table th {
            border-top: none
        }

        .table thead tr.text-uppercase th {
            font-size: 0.8rem;
            padding-left: 0px;
            padding-right: 0px
        }

        .table tbody tr th,
        .table tbody tr td {
            font-size: 0.9rem;
            padding-left: 0px;
            padding-right: 0px;
        }

        .list div b {
            font-size: 0.8rem
        }

        .list .order-item {
            font-weight: 600;
            color: #6db3ec
        }

        .list:hover {
            background-color: #f4f4f4;
            cursor: pointer;
            border-radius: 5px
        }

        label {
            margin-bottom: 0;
            padding: 0;
            font-weight: 900
        }

        button.btn {
            font-size: 0.9rem;
            background-color: #66cdaa
        }

        button.btn:hover {
            background-color: #5cb99a
        }

        .price {
            color: #5cb99a;
            font-weight: 700
        }

        p.text-justify {
            font-size: 0.9rem;
            margin: 0
        }

        .row {
            margin: 0px
        }

        .summary {
            border: 1px solid #ddd;
            border-left: 5px solid #ffa500;
            padding: 10px
        }

        .summary div {
            font-size: 0.9rem
        }

        @media(max-width: 425px) {
            .wrapper {
                padding: 15px
            }

            body {
                font-size: 0.85rem
            }

            .summary div {
                padding-left: 5px
            }

        }
    </style>

</head>

<body class='snippet-body'>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-6">
                <input type="text" class="form-control mt-3 w-75 d-inline" id="id_order_input"
                    placeholder="Masukkan kode pesanan">
                <button class="btn btn-success py-2 mb-1 cek-order" type="button">Cek Pesanan</button>
            </div>
        </div>
    </div>
    {{-- Heading --}}
    <div class="d-flex flex-column justify-content-center align-items-center d-none" id="order-heading">
        <div class="text-uppercase">
            <p>Detail Pemesanan</p>
        </div>
        <div class="h4" id="tanggal"></div>
        <div class="pt-1">
            <p id="id-order"></p>
        </div>

    </div>
    {{-- Wrapper --}}
    <div class="wrapper d-none py-2">
        <div class="table-responsive px-2">
            <table class="table table-borderless">
                <thead>
                    <tr class="text-uppercase text-muted">
                        <th scope="col">produk</th>
                        <th scope="col" class="text-end">jumlah</th>
                        <th scope="col" class="text-end">total</th>
                    </tr>
                </thead>
                <tbody id="product-order">
                </tbody>
            </table>
        </div>
        <div class="pt-2 border-bottom mb-3"></div>
        <div class="d-flex justify-content-start align-items-center py-1 px-2">
            <div class="text-muted">Paket pengiriman</div>
            <div class="ms-auto"> <label id="pengiriman">JNE Layanan Reguler (REG)</label> </div>
        </div>
        <div class="d-flex justify-content-start align-items-center py-1 px-2">
            <div class="text-muted">Pengiriman</div>
            <div class="ms-auto"> <label id='biaya-pengiriman'>Rp 27.000</label> </div>
        </div>
        {{-- <div class="d-flex justify-content-start align-items-center pb-4 px-2 border-bottom">
            <div class="text-muted"> <button class="text-white btn">50% Discount</button> </div>
            <div class="ms-auto price"> -Rp 13.000 </div>
        </div> --}}
        <div class="d-flex justify-content-start align-items-center px-2 py-3 mb-4 border-bottom">
            <div class="text-muted">Total Pesanan</div>
            <h5 class="ms-auto" id="total"></h5>
        </div>

        {{-- Informasi Pembeli --}}
        <div class="row border rounded p-1 my-3">
            <div class="col-12 py-3">
                <div class="d-flex flex-column align-items start"> <b>Alamat pengiriman</b>
                    <p class="text-justify pt-2" id='alamat'></p>
                </div>
            </div>
            <div class="col-12 py-3">
                <div class="d-flex flex-column align-items start"> <b>Catatan Pembeli</b>
                    <p class="text-justify" id="note"></p>
                </div>
            </div>
        </div>

        {{-- Ringkasan --}}
        <div class="ps-3 font-weight-bold">Ringkasan</div>
        <div class="d-sm-flex justify-content-between rounded my-3 summary">
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script>
        //Cek Pesanan
        $('.cek-order').on('click', function() {
            console.log("Test");
            $.ajax({
                url: '/cekOrder',
                type: 'get',
                data: {
                    id_order: $("#id_order_input").val()
                },
                success: function(response) {
                    console.log(response);
                    $("#tanggal").text(response.tanggal);
                    $("#id-order").text(`Order #${response.id_order}`);

                    let product_order = '';
                    let total = 0;
                    let count = 0;
                    $.each(response.product_order, function(i, item) {
                        product_order += /*html */
                            `<tr> 
                            <th scope='row'>${item.name_product} ${item.size == null ? '' : item.size}/${item.variant == null ? '' : item.variant} </th>
                            <td scope='row' class='text-end'>${item.quantity} </td>
                            <td class="text-end"><b>${rupiah(item.sub_total)}</b></td>
                        </tr>`
                        total += item.sub_total;
                        count++;
                    })
                    $("#product-order").html(product_order);

                    $("#biaya-pengiriman").text(rupiah(response.biaya_pengiriman));
                    total += response.biaya_pengiriman;

                    $("#total").text(rupiah(total));
                    $("#alamat").text(response.alamat);
                    $("#note").text(response.note);
                    $(".summary").html( /*html */
                        `
                        <div> <b>#${response.id_order}</b> </div>
                        <div>${response.tanggal}</div>
                        <div>Status: ${response.status}</div>
                        <div> Total: <b> ${rupiah(total)} untuk ${count} item</b> </div>
                    `)

                    $("#order-heading").removeClass("d-none");
                    $(".wrapper").removeClass("d-none");

                }
            })
        })

        function rupiah(num) {
            return "Rp " + num.toLocaleString("id-ID");
        }
    </script>
</body>

</html>
