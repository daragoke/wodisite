(function ($) {
    'use strict';

    function login_dropdown() {
        $('.site-header-account').mouseenter(function () {
            $('.account-dropdown', this).append($('.account-wrap'));
        });
    }

    function megamenu_dropdown() {
        $('.icon-down-megamenu').click(function () {
            $(this).toggleClass('selected').siblings('.mega-menu').toggleClass('open');
        });
    }

    function minHeight() {
        var bodyHeight = $(window).outerHeight(),
            headerHeight = $('header.site-header').outerHeight(true),
            footerHeight = $('footer.site-footer').outerHeight(true),
            siteMain = $('.site-content').height(),
            siteMainOut = $('.site-content').outerHeight(true);
        if (bodyHeight > (headerHeight + footerHeight + siteMain)) {

            $('.site-content').css({
                'min-height': bodyHeight - headerHeight - footerHeight - (siteMainOut - siteMain) + 10
            });
        }
    }

    function setPositionLvN($item) {
        var sub = $item.children('.sub-menu'),
            offset = sub.offset(),
            screen_width = document.documentElement.clientWidth,
            sub_width = sub.outerWidth();
        var align_delta = offset.left + sub_width - screen_width;
        if (align_delta > 0) {
            sub.css({'margin-left': -align_delta});
        } else {
            sub.css({'margin-left': 'initial'});
        }
    }

    function initSubmenuHover() {
        $('.main-navigation .has-mega-menu').hover(function (event) {
            var $item = $(event.currentTarget);
            setPositionLvN($item);
        });
    }

    $(document).ready(function () {
        minHeight();
    });
    initSubmenuHover();
    megamenu_dropdown();
    login_dropdown();
})(jQuery);

