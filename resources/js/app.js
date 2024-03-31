import 'flowbite';

import Swiper from 'swiper';
// // import Swiper styles
import 'swiper/css';

        window.addEventListener('livewire:init', function () {
            const swiper = new Swiper('.swiper',{
                spaceBetween: 5,
                centeredSlides: true,
                autoplay: {
                    delay: 1000,
                },
            });
        })

document.addEventListener("livewire:navigating", () => {
    // Mutate the HTML before the page is navigated away...
    initFlowbite();
    // initSwiper();
});

document.addEventListener("livewire:navigated", () => {
    // Reinitialize Flowbite components
    initFlowbite();
    const swiper = new Swiper('.swiper',{
        spaceBetween: 5,
        centeredSlides: true,
        autoplay: {
            ParallaxOptions: true,
            delay: 1000,
        },
    });
});

document.addEventListener('DOMContentLoaded', function() {
    initFlowbite();
    const swiper = new Swiper('.swiper',{
        spaceBetween: 5,
        centeredSlides: true,
        autoplay: {
            ParallaxOptions: true,
            delay: 1000,
        },
    });
    // swiper.init();
});
