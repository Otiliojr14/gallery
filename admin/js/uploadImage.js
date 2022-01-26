import { titlePhotoInput, formPhoto, fileUpload } from "./selectors.js";

const mime_types = [ 'image/jpeg', 'image/png' ];

window.onload = () => {
    formPhoto.addEventListener('submit', subirFoto);
}

function subirFoto(e) {
    e.preventDefault();

    const titlePhoto = titlePhotoInput.value;

    if (titlePhoto === '') {
        swal({
            type: "error",
            title: "Error!",
            text: "The name of the photo is empty",
          });
        return;
    }

    if (fileUpload.files.length === 0) {
        swal({
            type: "error",
            title: "Error!",
            text: "There's no file uploaded",
          });

        return;
    }

    const file = fileUpload.files[0];

    if (mime_types.indexOf(file.type) == -1) {
        swal({
            type: "error",
            title: "Error!",
            text: "Please select jpeg, jpg or png files only.",
          });

        return;
    }

    const data = new FormData();
    data.append('file', fileUpload.files[0]);

    // AJAX

    const xhr = new XMLHttpRequest();

    xhr.open('POST', './models/model-photo.php', true);

    xhr.onload = function () {
        if (this.status === 200) {
            const response = xhr.responseText;
            console.log(response);
            
        }
    }

    xhr.send(data);
}