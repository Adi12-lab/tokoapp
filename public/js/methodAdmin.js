function previewImage(event) {
  const image = event;
  const imgPreview = $(event).siblings(".image_preview");
  const ofReader = new FileReader();
  ofReader.readAsDataURL(image.files[0]);
  ofReader.onload = function(ofREvent) {
    imgPreview.attr("src",  ofREvent.target.result);
  }
}

$(document).ready(function() {
  
  
  $("input[name='size_name[]']").change(function() { //pertama yang diambil, jadi yang ditambahkan jquery tidak akan terseleksi(jangan kuatir)
    if($(this).val().length != 0) {
      $(".add_row_button.size").prop("disabled", false);
    } else $(".add_row_button.size").prop("disabled", true);
  })

    $(".add_row_button").click(function() {
      const kind_table = $(this).siblings("table").data("kind-table");
      switch(kind_table) {
        case "size_table":
          $(".body_table.size").append(
            `<tr>
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
          $(".body_table.variant").append(
            ` <tr>
            <input type="hidden" name="variant_id[]" value="0" >
            <td><input class="form-control" type="text" name="variant_name[]"></td>
            <td><button type="button" class="btn-close ms-3 mt-1"></button> </td> 
          </tr>`
          )
          break;
  
      }
    });
    
    $(".body_table").on("click", ".btn-close", function() {
      $(this).parents("tr").remove();
    });

});
