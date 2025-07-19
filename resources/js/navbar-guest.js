document.addEventListener("DOMContentLoaded", function () {
    var navbar = document.getElementById("navbar");
    var navbarMenu = document.getElementById("navbarMenu");
    var dropdownNavbarProfil = document.getElementById("dropdownNavbarProfil");
    var dropdownNavbarInformasiPUPR = document.getElementById(
        "dropdownNavbarInformasiPUPR"
    );

    if (
        !navbar ||
        !navbarMenu ||
        !dropdownNavbarProfil ||
        !dropdownNavbarInformasiPUPR
    ) {
        return;
    }

    var lastScrollY = window.scrollY;
    var ticking = false;

    function updateNavbar() {
        if (lastScrollY > 88 && window.innerWidth >= 1024) {
            navbar.classList.add(
                "bg-white",
                "shadow-lg",
                "fixed",
                "w-full",
                "z-50",
                "top-0",
                "start-0"
            );
            navbar.classList.remove(
                "transition",
                "duration-200",
                "ease-out",
                "lg:bg-brand-blue"
            );
            navbar.classList.add("transition", "duration-350", "ease-in");

            navbarMenu.classList.remove("lg:text-white", "lg:bg-brand-blue");
            navbarMenu.classList.add(
                "lg:text-brand-blue",
                "transition",
                "duration-350",
                "ease-in"
            );

            dropdownNavbarProfil.classList.remove("lg:!top-[148px]");
            dropdownNavbarProfil.classList.add("lg:!top-[60px]");

            dropdownNavbarInformasiPUPR.classList.remove("lg:!top-[148px]");
            dropdownNavbarInformasiPUPR.classList.add("lg:!top-[60px]");
        } else {
            navbar.classList.remove(
                "bg-white",
                "shadow-lg",
                "fixed",
                "w-full",
                "z-50",
                "top-0",
                "start-0"
            );
            navbar.classList.add(
                "transition",
                "duration-200",
                "ease-out",
                "lg:bg-brand-blue"
            );
            navbar.classList.remove("transition", "duration-350", "ease-in");

            navbarMenu.classList.add("lg:text-white", "lg:bg-brand-blue");
            navbarMenu.classList.remove(
                "lg:text-brand-blue",
                "transition",
                "duration-350",
                "ease-in"
            );

            dropdownNavbarProfil.classList.remove("lg:!top-[60px]");
            dropdownNavbarProfil.classList.add("lg:!top-[148px]");

            dropdownNavbarInformasiPUPR.classList.remove("lg:!top-[60px]");
            dropdownNavbarInformasiPUPR.classList.add("lg:!top-[148px]");
        }
        ticking = false;
    }

    function onScroll() {
        lastScrollY = window.scrollY;
        if (!ticking) {
            window.requestAnimationFrame(updateNavbar);
            ticking = true;
        }
    }

    window.addEventListener("scroll", onScroll);
});
