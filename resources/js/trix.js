import Trix from 'trix';

document.addEventListener("DOMContentLoaded", function () {
  //=================Attribute diluar fungsi====================

  const csrfToken = document.querySelector("meta[name='csrf-token']").getAttribute("content");
  const editors = Array.from(document.querySelectorAll('.attachment-trix'));
  const hiddenAttachment = Array.from(document.querySelectorAll("input[name='hidden_attachment[]']")).
    map(function (item) {
      return {
        "hidden_kind": item.getAttribute("data-hidden"), //untuk bsa dapat dimasukan ke jenis editornya masing -masing
        "hidden_url": item.value
      }
    });
  let attachmentDatabase = []; //berisi attachment apa saja yang berasal dari database

  // Setiap editors kita push sebuah object yang berisi
  editors.forEach(function (item) {
    item.input_hidden = hiddenAttachment.filter((filItem) => filItem.hidden_kind == item.getAttribute("data-kind"));
  });

  editors.forEach(function (editor) {
    editor.addEventListener("trix-initialize", function () {
      editor.input_hidden.forEach(function (hiddenItem) {
        const url = `${window.location.origin}/storage/${hiddenItem.hidden_url}`; //gambar diambil dari sini
        const xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.responseType = 'blob'; //bertipe blob
        xhr.onload = function () {
          if (xhr.readyState == 4 && xhr.status === 200) {
            const blob = xhr.response;
            const fileName = url.split('/').pop();
            const fileType = blob.type;
            const attachment = new Trix.Attachment({
              contentType: fileType,
              filename: fileName,
              url: url,
              fromWhere: "database"
            });
            editor.editor.insertAttachment(attachment);
          }
        };
        xhr.send();
      })
    });
  });

  //Event Listener menambahkan attachment

  document.addEventListener("trix-attachment-add", function (event) {
    var attachment = event.attachment;
    var editor = event.target;
    var editorKind = editor.getAttribute("data-kind");
    if (attachment.file) {
      uploadAttachment(attachment, editorKind);
    }
  });

  //Event Listener menghapus attachment

  document.addEventListener("trix-attachment-remove", function (event) {
    var editorKind = event.target.closest(".attachment-trix").getAttribute("data-kind");
    var attachment = event.attachment.attachment.attributes.values;
    var fromDatabase = attachment.fromWhere == 'database' ? true : false;

    removeAttachment(attachment, editorKind, fromDatabase);
  });

  //Event listener Form Submit

  const editProduct = document.querySelector('#editProductForm');
  editProduct.addEventListener('submit', function () {
    var xhr = new XMLHttpRequest;
    xhr.open("POST", "/removeFromStorage", true);
    xhr.setRequestHeader("X-CSRF-Token", csrfToken);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) console.log(xhr.responseText);
    }
    xhr.send(attachmentDatabase);
  });


  //Fungsi menghapus attachment

  function removeAttachment(attachment, editorKind, fromDatabase = false) {
    if (fromDatabase) {//akan diatasi oleh controller laravel
      attachmentDatabase.push(attachment.url);
      return;
    }
    var form = new FormData;
    form.append("attachmentName", attachment.filename);
    form.append("kind", editorKind);

    console.log(fromDatabase);
    var xhr = new XMLHttpRequest;
    xhr.open("POST", '/removeFromPending', true);
    xhr.setRequestHeader("X-CSRF-Token", csrfToken);

    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        console.log(xhr.responseText);
      }
    }
    return xhr.send(form);

  }

  //Fungsi mengupload attachment

  function uploadAttachment(attachment, editorKind) {
    var file = attachment.file;
    var form = new FormData;
    form.append("file", file);
    form.append("kind", editorKind);
    var xhr = new XMLHttpRequest;
    xhr.open("POST", "/toPending", true); // file diupload di folder pending terlebih dahulu
    xhr.setRequestHeader("X-CSRF-Token", csrfToken);
    xhr.upload.onprogress = function (event) {
      var progress = event.loaded / event.total * 100;
      attachment.setUploadProgress(progress);
    };
    xhr.onload = function () {
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
});

