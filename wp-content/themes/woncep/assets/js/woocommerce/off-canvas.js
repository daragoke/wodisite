(function ($) {
    'use strict';

    $(function () {
        var $body = $('body');
        $body.on('click', '.filter-toggle', function (e) {
            e.preventDefault();
            $('html').toggleClass('off-canvas-active');
        });

        $body.on('click', '.filter-close, .woncep-overlay-filter', function (e) {
            e.preventDefault();
            $('html').toggleClass('off-canvas-active');
        });

        function clone_sidebar() {
            var $canvas = $('.woncep-canvas-filter-wrap');
            if (!$('body').hasClass('shop_filter_canvas')) {
                if ($(window).width() < 1024) {
                    $('#secondary').children().appendTo(".woncep-canvas-filter-wrap");
                    $('.woncep-dropdown-filter-wrap').children().appendTo(".woncep-canvas-filter-wrap");
                } else {
                    $canvas.children().appendTo("#secondary");

                    $canvas.children().appendTo(".woncep-dropdown-filter-wrap");
                }
            }

        }

        clone_sidebar();
        $(window).on('resize', function () {
            clone_sidebar();
        });
        
    });
})(jQuery);
