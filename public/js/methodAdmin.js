
function previewImage() {
  const image = document.querySelector("#image");
  const imgPreview = document.querySelector(".img-preview");
  const ofReader = new FileReader();
  ofReader.readAsDataURL(image.files[0]);
  ofReader.onload = function(ofREvent) {
    imgPreview.src = ofREvent.target.result;
  }
}
let attachments =[];
document.addEventListener("trix-attachment-add", function(event) {
  var attachment = event.attachment;
  var file = attachment.file;
  var form = new FormData();
  form.append("attachment", file);

  // Mengirimkan file attachment ke endpoint pengunggahan pada Laravel
  axios.post("/upload-attachment", form).then(function(response) {
    var url = response.data.url;

    // Menyimpan URL permanen ke dalam atribut data-trix-attachment pada elemen <trix-attachment>
    var trixId = attachment.getTrixId();
    var trixEditor = document.querySelector("trix-editor[trix-id='" + trixId + "']");
    var attachmentElement = attachment.attachment;

    attachmentElement.setAttributes({
      url: url,
      "data-trix-attachment": JSON.stringify({
        url: url,
        href: url + "?content-disposition=attachment",
        filename: file.name,
        content_type: file.type,
        size: file.size
      })
    });
    console.log(attachmentElement);
  });
});
