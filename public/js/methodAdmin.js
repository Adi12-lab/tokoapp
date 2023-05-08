function previewImage(event) {
  const image = event;
  const imgPreview = $(event).siblings(".image_preview");
  const ofReader = new FileReader();
  ofReader.readAsDataURL(image.files[0]);
  ofReader.onload = function (ofREvent) {
    imgPreview.attr("src", ofREvent.target.result);
  }
}

$(document).ready(function () {


  $("input[name='size_name[]']").change(function () { //pertama yang diambil, jadi yang ditambahkan jquery tidak akan terseleksi(jangan kuatir)
    if ($(this).val().length != 0) {
      $(".add_row_button.size").prop("disabled", false);
    } else $(".add_row_button.size").prop("disabled", true);
  })

  $(".add_row_button").click(function () {
    const kind_table = $(this).siblings("table").data("kind-table");
    switch (kind_table) {
      case "size_table":
        $(".body_table.size").append(
          /*html*/ `<tr>
            <input type="hidden" name="size_id[]" value="0">
            <td><input class="form-control" type="text" name="size_name[]"></td>
            <td><input class="form-control" type="number" name="size_weight[]"></td>
            <td><input class="form-control" type="number" name="size_price[]"></td>
            <td><input class="form-control" type="number" name="old_price[]"></td>
            <td><button type="button" class="btn-close ms-3 mt-1"></button> </td> 
        </tr>`
        );
        break;
      case "variant_table":
        $(".body_table.variant").append(/*html*/
          ` <tr>
            <input type="hidden" name="variant_id[]" value="0" >
            <td><input class="form-control" type="text" name="variant_name[]"></td>
            <td><button type="button" class="btn-close ms-3 mt-1"></button> </td> 
          </tr>`
        )
        break;

    }
  });

  $(".body_table").on("click", ".btn-close", function () {
    $(this).parents("tr").remove();
  });

  // Admin Orders
  // $(".detail-order").click(function() {
  //   $.ajax({
  //     url: '/metal/order',
      
  //   })
  // });
  $(".edit-order").click(function (element) {
    const kodePesanan = $(this).data("id-order");
    $.ajax({
      url: "/metal/order",
      data: {
        id_order: kodePesanan
      },
      success: function (response) {
        console.log(response);
        $("#kode").text(response.id_order);
        $("input[name='id_order']").val(response.id_order);
        $("#nama").val(response.nama_penerima);
        $("#alamat").val(response.alamat);
        $("#note").text(response.alamat);
        $("#tanggal").text(response.tanggal);

        let produk = "";
        response.product_order.forEach(function (item) {
            produk +=   
            `<tr>
              <td>${item.name_product}</td>
              <td>${item.size}</td>
              <td>${item.variant}</td>
              <td>${item.quantity}</td>
              <td>${rupiah(item.price)}</td>
              <td>${rupiah(item.sub_total)}</td>
            </tr>`;
        });
        $(".modal .table tbody").html(produk);

        $("select[name='status']").find("option").each(function(i, item) {
          if($(item).val() == response.status) $(item).attr("selected", "selected");
        });
      }
    })
  })

});

function rupiah(num) {
  return "Rp " + num.toLocaleString("id-ID");
}
