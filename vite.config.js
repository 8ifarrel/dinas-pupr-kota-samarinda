import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // CSS ------
                "resources/css/app.css",
                "resources/css/trix.css",
                "resources/css/viewerjs.css",
                "resources/css/cropperjs.css",
                "resources/css/datatables.css",
                "resources/css/lightbox.css",
                "resources/css/splidejs.css",
                "resources/css/sweetalert2.css",

                // JS ------
                "resources/js/app.js",
                "resources/js/trix.js",
                "resources/js/viewerjs.js",
                "resources/js/cropperjs.js",
                "resources/js/datatables.js",
                "resources/js/lightbox.js",
                "resources/js/splidejs.js",
                "resources/js/sweetalert2.js",

                "resources/js/splide-autoscroll.js",
                "resources/js/toggle-password-visibility.js",
                "resources/js/clock.js",
                "resources/js/navbar-guest.js",
            ],
            refresh: true,
        }),
    ],
});
