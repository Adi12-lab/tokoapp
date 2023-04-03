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
(function() {
  var HOST = "http://localhost:8000/upload-attachment/";

  addEventListener("trix-attachment-add", function(event) {
    if (event.attachment.file) {
      uploadFileAttachment(event.attachment)
    }
  })

  function uploadFileAttachment(attachment) {
    uploadFile(attachment.file, setProgress, setAttributes)

    function setProgress(progress) {
      attachment.setUploadProgress(progress)
    }

    function setAttributes(attributes) {
      attachment.setAttributes(attributes)
    }
  }

  function uploadFile(file, progressCallback, successCallback) {
    var csrfToken = document.querySelector("meta[name='csrf-token']").getAttribute("content");
    var key = createStorageKey(file)
    var formData = createFormData(key, file)
    var xhr = new XMLHttpRequest()

    xhr.open("POST", HOST, true)
    xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

    xhr.upload.addEventListener("progress", function(event) {
      var progress = event.loaded / event.total * 100
      progressCallback(progress)
    })

    xhr.addEventListener("load", function(event) { 
      if (xhr.status == 200) {
        var attributes = {
          url: HOST + key,
          href: HOST + key + "?content-disposition=attachment"
        }
        successCallback(attributes)
        // console.log(attributes)
      }
    })
    xhr.send(formData) //Pengiriman data ke host
  }

  function createStorageKey(file) {
    var date = new Date()
    var day = date.toISOString().slice(0,10)
    var name = date.getTime() + "-" + file.name
    return [ "tmp", day, name ].join("/")
  }

  function createFormData(key, file) {
    var data = new FormData()
    data.append("key", key)
    data.append("Content-Type", file.type)
    data.append("file", file)
    return data
  }
})();
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
