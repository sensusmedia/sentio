document.addEventListener('DOMContentLoaded', function() {
    var swiper = new Swiper('.custom-slideshow .swiper-container', {
        // Swiper options here
        loop: true,
        autoplay: {
            delay: 5000,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
});
