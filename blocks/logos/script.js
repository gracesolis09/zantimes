jQuery(function ($) {
    if ($('.js-zantimes-logo-slider').length > 0) {
        $('.js-zantimes-logo-slider').each(function () {
            $(this).slick({
                arrows: false,
                infinite: true,
                slidesToScroll: 1,
                slidesToShow: 5,
                autoplay: true,
                autoplaySpeed: 10,
                speed: 5000,
                pauseOnHover: false,
                cssEase: 'linear',
                accessibility: false,
                variableWidth: true,
                responsive: [
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 2
                        }
                    }
                ]
            });
            AOS.refresh();
        });
    }
});