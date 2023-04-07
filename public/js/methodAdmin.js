import Trix from 'trix';

function previewImage(event) {
  const image = event;
  const imgPreview = $(event).siblings(".image_preview");
  console.log(image);
  const ofReader = new FileReader();
  ofReader.readAsDataURL(image.files[0]);
  ofReader.onload = function(ofREvent) {
    imgPreview.attr("src",  ofREvent.target.result);
  }
}


document.addEventListener("trix-attachment-add", function(event) {
  var attachment = event.attachment;
  var editor = event.target;
  var editorKind = editor.getAttribute("data-kind");
  if (attachment.file) {
    uploadAttachment(attachment, editorKind);
  }
});

document.addEventListener("trix-attachment-remove", function(event) {
  console.log("sebuah file dihapus");
});

function uploadAttachment(attachment, editorKind) {
  var file = attachment.file;
  var form = new FormData;
  var csrfToken = document.querySelector("meta[name='csrf-token']").getAttribute("content");
  form.append("file", file);
  form.append("kind", editorKind);
  var xhr = new XMLHttpRequest;
  xhr.open("POST", "/toPending", true); // file diupload di folder pending terlebih dahulu
  xhr.setRequestHeader("X-CSRF-Token", csrfToken);
  xhr.upload.onprogress = function(event) {
    var progress = event.loaded / event.total * 100;
    attachment.setUploadProgress(progress);
  };
  xhr.onload = function() {
    if (xhr.status === 200) {
      var data = JSON.parse(xhr.responseText);
      console.log(data);
      return attachment.setAttributes({
        url: data.attachment_url,
        href: data.attachment_url
      });
    }
  };
  return xhr.send(form);
};


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
