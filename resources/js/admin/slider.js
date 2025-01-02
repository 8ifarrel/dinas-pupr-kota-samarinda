import * as FilePond from "filepond";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import Cropper from "cropperjs";
import "cropperjs/dist/cropper.css";

FilePond.registerPlugin(FilePondPluginImagePreview);

document.addEventListener("DOMContentLoaded", function () {
    const fileInput = document.querySelector('input[name="foto_slider"]');
    const editButton = document.querySelector("#edit-image-button");
    const cropperModalElement = document.getElementById("cropperModal");
    const imageToCrop = document.getElementById("image-to-crop");
    const cropButton = document.getElementById("crop-button");

    let uploadedFileUrl = null;
    let cropper = null;

    const cropperModal = new Modal(cropperModalElement);

    const pond = FilePond.create(fileInput, {
        allowMultiple: false,
        acceptedFileTypes: ["image/*"],
        labelIdle: 'Seret foto ke sini atau <span class="filepond--label-action">telusuri foto</span>',
        server: {
            process: {
                url: "/filepond/process",
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.head.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
            },
            revert: {
                url: "/filepond/revert",
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.head.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    "Content-Type": "application/json",
                },
            },
        },
        onprocessfile: (error, file) => {
            if (!error) {
                const serverId = file.serverId;
                uploadedFileUrl = JSON.parse(serverId).fileUrl;
                editButton.style.display = "inline-block";
            }
        },
        onprocessfilerevert: (file) => {
            uploadedFileUrl = null;
            editButton.style.display = "none";
        },
    });

    window.addEventListener("beforeunload", () => {
        if (uploadedFileUrl) {
            navigator.sendBeacon(
                "/filepond/revert",
                JSON.stringify({ fileUrl: uploadedFileUrl })
            );
        }
    });

    if (editButton) {
        editButton.addEventListener("click", function () {
            const imageUrl = uploadedFileUrl;
            if (imageUrl) {
                imageToCrop.src = imageUrl;
                cropperModal.show();
                if (cropper) {
                    cropper.destroy();
                }
                cropper = new Cropper(imageToCrop, {
                    aspectRatio: 21 / 9,
                    viewMode: 1,
                });
            }
        });
    }

    cropButton.addEventListener("click", function () {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas();
            canvas.toBlob((blob) => {
                const file = new File([blob], "cropped_image.jpg", {
                    type: "image/jpeg",
                });
                // Remove the previous file from FilePond using revert
                fetch("/filepond/revert", {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector('meta[name="csrf-token"]').content,
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