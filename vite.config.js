import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // CSS ------
                "resources/css/app.css",
                "resources/css/viewerjs.css",
                "resources/css/cropperjs.css",
                "resources/css/datatables.css",
                "resources/css/lightbox.css",
                "resources/css/splidejs.css",
                "resources/css/sweetalert2.css",
                "resources/css/quill.css",
                "resources/css/quill-resize-module.css",
                "resources/css/leaflet.css",

                // JS ------
                "resources/js/app.js",
                "resources/js/viewerjs.js",
                "resources/js/cropperjs.js",
                "resources/js/datatables.js",
                "resources/js/lightbox.js",
                "resources/js/splidejs.js",
                "resources/js/sweetalert2.js",
                "resources/js/quill.js",
                "resources/js/quill-resize-module.js",
                "resources/js/leaflet.js",

                "resources/js/chartjs.js",
                "resources/js/chartjs-plugin-datalabels.js",
                "resources/js/splide-autoscroll.js",
                "resources/js/toggle-password-visibility.js",
                "resources/js/clock.js",
                "resources/js/navbar-guest.js",
                "resources/js/jalan-peduli/animasi.js",
                "resources/js/jalan-peduli/shepherd-tour.js",
                "resources/js/jalan-peduli/buat-laporan.js",
                "resources/js/jalan-peduli/pdf-viewer.js",
                "resources/js/jalan-peduli/publik-map.js",
                "resources/js/jalan-peduli/faq.js",
            ],
            refresh: true,
        }),
    ],
});