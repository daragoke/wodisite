(function ($) {
    'use strict';
    $( document ).ready(function() {
        $('.menu-mobile-nav-button').on('click', function (e) {
            e.preventDefault();
            $('html').toggleClass('mobile-nav-active');
        });

        $('.woncep-overlay, .mobile-nav-close').on('click', function (e) {
            e.preventDefault();
            $('html').toggleClass('mobile-nav-active');
        });

        var $menu_mobile = $('.handheld-navigation');

        if ($menu_mobile.length > 0) {
            $menu_mobile.find('.menu-item-has-children > a, .page_item_has_children > a').each((index, element) => {
                var $dropdown = $('<button class="dropdown-toggle"></button>');
                $dropdown.insertAfter(element);
                $dropdown.on('click', function (e) {
                    e.preventDefault();
                    $dropdown.toggleClass('toggled-on');
                    $dropdown.siblings('ul').stop().slideToggle(400);
                });
            });
        }
    });
})(jQuery);
