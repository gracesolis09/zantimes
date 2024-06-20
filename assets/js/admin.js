jQuery('body').on('select2:select', 'div[data-name="posts_category"] select', function(e) {
    var data = e.params.data;
    jQuery(this).closest('.acf-block-panel').find('div[data-name="posts"] select').val('category:'+data.text.toLowerCase() ).trigger('change');
});