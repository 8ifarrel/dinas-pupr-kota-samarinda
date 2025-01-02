import * as FilePond from "filepond";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import Cropper from "cropperjs";
import "cropperjs/dist/cropper.css";

FilePond.registerPlugin(FilePondPluginImagePreview);

document.addEventListener("DOMContentLoaded", () => {
    const fileInput = document.querySelector('input[name="foto_slider"]');
    const editButton = document.querySelector("#edit-image-button");
    const cropperModalElement = document.getElementById("cropperModal");
    const imageToCrop = document.getElementById("image-to-crop");
    const cropButton = document.getElementById("crop-button");

    let uploadedFileUrl = null;
    let cropper = null;

    const cropperModal = new Modal(cropperModalElement);

    const csrfToken = document.head.querySelector(
        'meta[name="csrf-token"]'
    ).content;


    /**
     * TODO:
     * 1. Tambahkan code yang dapat menghapus file jika me-refresh halaman
     */
    const pond = FilePond.create(fileInput, {
        allowMultiple: false,
        acceptedFileTypes: ["image/*"],
        labelIdle:
            'Seret foto ke sini atau <span class="filepond--label-action">telusuri foto</span>',
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
                uploadedFileUrl = JSON.parse(file.serverId).fileUrl;
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
                    aspectRatio: 21 / 9,
                    viewMode: 1,
                });
            }
        });
    }

    /**
     * TODO:
     * 1. Tambahkan code untuk menyesuaikan extensi file yang diupload
     */
    cropButton.addEventListener("click", () => {
        if (cropper) {
            cropper.getCroppedCanvas().toBlob((blob) => {
                const file = new File([blob], "cropped_image.jpg", {
                    type: "image/jpeg",
                });
                fetch("/filepond/revert", {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ fileUrl: uploadedFileUrl }),
                }).then(() => {
                    pond.addFile(file);
                    cropperModal.hide();
                    cropper.destroy();
                    cropper = null;
                });
            });
        }
    });
});
