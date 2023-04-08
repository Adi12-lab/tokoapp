import Trix from 'trix';

document.addEventListener("DOMContentLoaded", function() {
  const editors = Array.from(document.querySelectorAll('.attachment-trix'));
  const hiddenAttachment = Array.from(document.querySelectorAll("input[name='hidden_attachment[]']"));
  // Setiap editors kita push sebuah object yang berisi
  console.log(hiddenAttachment);
  // editor.addEventListener("trix-initialize", function() {

  //    const url = 'http://localhost:8000/storage/origin-produk/carousel/Capture.PNG';
  //    const xhr = new XMLHttpRequest();
  //    xhr.open('GET', url, true);
  //    xhr.responseType = 'blob';
   
  //    xhr.onload = function() {
  //      if (xhr.readyState == 4 && xhr.status === 200) {
  //        const blob = xhr.response;
  //        const fileName = 'Capture.PNG';
  //        const fileType = blob.type;
  //       //  const file = new File([blob], fileName, { type: fileType });
  //       const attachment = new Trix.Attachment({
  //         contentType: fileType,
  //         filename: fileName,
  //         url: url
  //       });
  //       console.log(editor);
  //        editor.editor.insertAttachment(attachment);
  //      }
  //    }; 
  //   xhr.send();
  
  // })
  document.addEventListener("trix-attachment-add", function(event) {
      var attachment = event.attachment;
      var editor = event.target;
      var editorKind = editor.getAttribute("data-kind");
      if (attachment.file) {
        uploadAttachment(attachment, editorKind);
      }
    });
    
    document.addEventListener("trix-attachment-remove", function(event) {
      var editorKind = event.target.closest(".attachment-trix").getAttribute("data-kind");
      var attachmentName = event.attachment.file.name;
      console.log(attachmentName);
      removeAttachment(attachmentName, editorKind);
    });

    function removeAttachment(attachmentName, editorKind) {
      var csrfToken = document.querySelector("meta[name='csrf-token']").getAttribute("content");
      var form = new FormData;
      form.append("attachmentName", attachmentName);
      form.append("kind", editorKind);

      var xhr = new XMLHttpRequest;
      xhr.open("POST", '/removeAttachment', true);
      xhr.setRequestHeader("X-CSRF-Token", csrfToken);

      xhr.onreadystatechange = function () {
        if(xhr.readyState == 4 && xhr.status == 200) {
          console.log(xhr.responseText);
        }
      }
      return xhr.send(form);
     
    }
  
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
});
