import * as FilePond from "filepond";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";

FilePond.registerPlugin(FilePondPluginImagePreview);

document.addEventListener("DOMContentLoaded", function () {
    const fileInput = document.querySelector('input[name="foto_slider"]');
    const editButton = document.querySelector("#edit-image-button");

    let uploadedFileUrl = null;

    const pond = FilePond.create(fileInput, {
        allowMultiple: false,
        acceptedFileTypes: ["image/*"],
        server: {
            process: {
                url: "/e-panel/slider/filepond",
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.head.querySelector('meta[name="csrf-token"]').content,
                },
            },
            revert: {
                url: "/e-panel/slider/filepond-revert",
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.head.querySelector('meta[name="csrf-token"]').content,
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
        onremovefile: () => {
            if (uploadedFileUrl) {
                fetch("/e-panel/slider/filepond-revert", {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector('meta[name="csrf-token"]').content,
                        // "Content-Type": "application/json",
                    },
                })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error(
                                `HTTP error! status: ${response.status}`
                            );
                        }
                        return response.json();
                    })
                    .then((data) => {
                        console.log("File removed:", data.message);
                        uploadedFileUrl = null;
                    })
                    .catch((error) =>
                        console.error("Error removing file:", error)
                    );
            }
        },
    });

    window.addEventListener("beforeunload", () => {
        if (uploadedFileUrl) {
            navigator.sendBeacon(
                "/e-panel/slider/filepond-revert",
                JSON.stringify({ fileUrl: uploadedFileUrl })
            );
        }
    });

    if (editButton) {
        editButton.addEventListener("click", function () {
            const imageUrl = uploadedFileUrl;

            // berisikan code image cropper
            // capek masih bikin laporan akhir kampus merdeka
            // jangan diapa-apain
        });
    }
});
