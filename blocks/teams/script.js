jQuery(function ($) {
    $('.modal-trigger').on('click', function(e) {
        e.preventDefault();
        var modalId = $(this).attr('data-target');
        $(modalId).modal('show');
        if(e.target.class == 'modal-overlay') {
            // Hide the overlay
            $(this).hide();
            // Add your style changes or other actions here
            // For example, changing the body background color
            $('body').css('background-color', '#f3f3f3');
        }
    });

    $('[data-dismiss="modal"]').on('click', function(e) {
        e.preventDefault();
        var modalId = $(this).attr('data-close');
        $(modalId).modal('hide');
    });
});