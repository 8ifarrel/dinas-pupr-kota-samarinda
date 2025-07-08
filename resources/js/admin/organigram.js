import * as FilePond from "filepond";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import Cropper from "cropperjs";
import "cropperjs/dist/cropper.css";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css";

FilePond.registerPlugin(FilePondPluginImagePreview);

document.addEventListener("DOMContentLoaded", () => {
    const fileInput = document.querySelector('input[name="foto_organigram"]');
    const editButton = document.querySelector("#edit-image-button");
    const cropperModalElement = document.getElementById("cropperModal");
    const imageToCrop = document.getElementById("image-to-crop");
    const cropButton = document.getElementById("crop-button");
    const currentImg = document.getElementById("current-organigram-img");

    let uploadedFileUrl = null;
    let cropper = null;

    const cropperModal = new Modal(cropperModalElement);

    const csrfToken = document.head.querySelector(
        'meta[name="csrf-token"]'
    ).content;

    window.addEventListener("beforeunload", () => {
        if (uploadedFileUrl) {
            fetch("/filepond/revert", {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ fileUrl: uploadedFileUrl }),
            });
        }
    });

    // Tentukan labelIdle sesuai mode create/edit
    let labelIdle = 'Seret foto ke sini atau <span class="filepond--label-action">telusuri foto</span>';
    if (currentImg) {
        labelIdle += '<br>(kosongkan jika tidak ingin mengubah foto)';
    }

    const pond = FilePond.create(fileInput, {
        allowMultiple: false,
        acceptedFileTypes: ["image/*"],
        labelIdle: labelIdle,
        // credits: false,
        server: {
            process: {
                url: "/filepond/process",
                method: "POST",
                headers: { "X-CSRF-TOKEN": csrfToken },
            },
            revert: {
                url: "/filepond/revert",
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Content-Type": "application/json",
                },
            },
        },
        onprocessfile: (error, file) => {
            if (!error) {
                let serverId = file.serverId;
                // Cegah error jika response bukan JSON (misal error HTML)
                let fileUrl = null;
                try {
                    fileUrl = JSON.parse(serverId).fileUrl;
                } catch (e) {
                    // Tampilkan pesan error atau alert jika perlu
                    alert("Terjadi kesalahan saat upload file. Silakan coba lagi.");
                    return;
                }
                uploadedFileUrl = fileUrl;
                editButton.style.display = "inline-block";
            }
        },
        onprocessfilerevert: () => {
            uploadedFileUrl = null;
            editButton.style.display = "none";
        },
    });

    if (editButton) {
        editButton.addEventListener("click", () => {
            if (uploadedFileUrl) {
                imageToCrop.src = uploadedFileUrl;
                cropperModal.show();
                if (cropper) cropper.destroy();
                cropper = new Cropper(imageToCrop, {
                    // aspectRatio: 16 / 9,
                    viewMode: 1,
                });
            }
        });
    }

    cropButton.addEventListener("click", () => {
        if (cropper) {
            cropper.getCroppedCanvas().toBlob((blob) => {
                const file = new File(
                    [blob],
                    `cropped_organigram.${blob.type.split("/")[1]}`,
                    {
                        type: blob.type,
                    }
                );
                fetch("/filepond/revert", {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ fileUrl: uploadedFileUrl }),
                }).then(() => {
                    pond.removeFile(pond.getFiles()[0].id);
                    pond.addFile(file);
                    cropperModal.hide();
                    cropper.destroy();
                    cropper = null;
                });
            });
        }
    });
});
