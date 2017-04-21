$(function() {
    // gallery
    altair_gallery.init();
});


altair_gallery  = {
    init: function() {
        $('.gallery_grid_item').children('a').magnificPopup({
            closeMarkup: '<button title="%title%" class="mfp-close"></button>',
            // animation
            removalDelay: 280,
            mainClass: 'md-scale',
            type:'image',
            gallery: {
                enabled: true
            }
        });
    }
};