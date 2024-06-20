jQuery(function($) {
    var scroll,
    newscroll;

    // Header
    // $(window).scroll(function () {
    //     scroll = $(window).scrollTop();

    //     if ($(window).scrollTop() > 100) {
    //         $('.header').addClass('scrolled');
    //     } else {
    //         $('.header').removeClass('scrolled');
    //     }
    // });

    $('.js-header__toggler').on('click', function (e) {
        e.preventDefault();
        newscroll = scroll;
        $('body').toggleClass('navbar-open');
        $('html').toggleClass('navbar-open');
        // $('body').css('top', -scroll + 'px');
        $('.navbar-collapse').toggleClass('show');
        $('.header__search-mobile .js-searchform').removeClass('show');
    });

    

    $(document).ready(function() {
        function headerResize() {
            var windowWidth = $(window).width();
            if(windowWidth <= 991) { // Assuming 991px is your breakpoint for mobile devices
                $('.header__search-mobile .js-search-icon').on('click', function (e) {
                    e.preventDefault();
                    $(this).parent('.js-searchform').submit();
                });
                $('.header__top-menu-desktop .lang-item-first').prependTo('.header-on-mobile'); // Move the lang-item into the top header
            } else {
                $('body:not(.rtl) .header-on-mobile .lang-item-first').insertBefore($('.header__top-menu-desktop li').last()); // Move it back to its original position or another as per design
                $('body.rtl .header-on-mobile .lang-item-first').appendTo('.header__top-menu-desktop');
            }
        }
    
        // Run on document ready
        headerResize();
    
        // Run on window resize
        $(window).resize(function() {
             // Run on document ready
            headerResize();
        });
    });

    $(document).on('click', '.js-header-search', function (e) {
        e.preventDefault();
        $(this).parent('.js-searchform').find('input').focus();

        if ($(this).parent('.js-searchform').hasClass('active')) {
            $(this).parent('.js-searchform').submit();
        } else {
            $(this).parent('.js-searchform').addClass('active');
        }

        $(document).on('click', function (e) {
            if (!$(e.target).is('.js-searchform, .js-searchform *')) {
                $('.js-searchform').removeClass('active');
            }
        });
    });

    var input = document.getElementById( 'file-input' );
    var infoArea = document.getElementById( 'file-upload-filename' );
    
    if (input || infoArea ) {
        input.addEventListener( 'change', showFileName );
    }
    
    function showFileName( event ) {

        // the change event gives us the input it occurred in 
        var input = event.srcElement;
        
        // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
        var fileName = input.files[0].name;
    
        // use fileName however fits your app best, i.e. add it into a div
        infoArea.textContent = 'File name: ' + fileName;
    }

    // $('.share-social-medias').each(function () {
    //     var shareLink = $(this).find('.share-icon-twitter');

    //     $(shareLink).on('click', function() {
    //         $('meta[property="og:image"]').replaceWith('<meta property=og:image" content="https://zantimes.com/wp-content/uploads/2024/02/favicon.png">');
    //         $('meta[name="twitter:image"]').replaceWith('<meta name="twitter:image" content="https://zantimes.com/wp-content/uploads/2024/02/favicon.png">');
    //     })
    // });
   
}); 