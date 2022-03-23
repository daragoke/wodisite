(function ($) {
    'use strict';

    function tooltip() {
        $('body').on('mouseenter', '.group-action .woosc-btn:not(.tooltipstered), .group-action .wooscp-btn:not(.tooltipstered) ,.group-action .woosq-btn:not(.tooltipstered) ,.group-action .woosw-btn:not(.tooltipstered),.group-action .compare-button .compare:not(.tooltipstered), .group-action .yith-wcqv-button:not(.tooltipstered), .group-action .yith-wcwl-add-to-wishlist > div > a:not(.tooltipstered), .woncep-color-type:not(.tooltipstered)', function () {
            var $element = $(this);

            if (typeof $.fn.tooltipster !== 'undefined') {
                $element.tooltipster({
                    position: 'top',
                    functionBefore: function (instance, helper) {
                        instance.content(instance._$origin.text());
                    },
                    theme: 'opal-product-tooltipster',
                    delay: 0,
                    animation: 'grow'
                }).tooltipster('show');
            }

        }).on('mouseenter', '.shop-tooltip', function () {
            var $element = $(this);
            if (typeof $.fn.tooltipster !== 'undefined') {
                $element.tooltipster({
                    position: 'top',
                    theme: 'opal-product-tooltipster',
                    delay: 0,
                    animation: 'grow'
                });
            }
        });
    }

    function ajax_wishlist_count() {
        var counter = $('.header-wishlist, .footer-wishlist');
        $(document).on('added_to_wishlist removed_from_wishlist', function () {

            $.ajax({
                url: yith_wcwl_l10n.ajax_url,
                data: {
                    action: 'yith_wcwl_update_wishlist_count'
                },
                dataType: 'json',
                success: function (data) {
                    counter.find('.count').html(data.count);
                },
            });
        });


        $('body').on('woosw_change_count', function (event, count) {
            counter.find('.count').html(count);
        });

        if ($('.woosw-check').length) {
            $.ajax({
                url: woosw_vars.ajax_url,
                data: {
                    action: 'woosw_ajax_update_count'
                },
                dataType: 'json',
                success: function (data) {
                    counter.find('.count').html(data.count);
                    counter.attr('href', data.url);
                },
            });
        }
    }

    function ajax_live_search() {
        $(document).ready(function () {
            var $parent = $('.woocommerce-product-search'),
                $inputsearch = $('.woocommerce-product-search .search-field'),
                $result = $('.ajax-search-result'),
                template = wp.template('ajax-live-search-template');

            $('body').on('click', function () {
                $result.hide();
            })

            if ($inputsearch.length) {
                // $inputsearch.focusout(function () {
                //     $result.hide();
                // });

                $inputsearch.keyup(function () {
                    if (this.value.length > 2) {
                        $.ajax({
                            context: this,
                            url: woncepAjax.ajaxurl,
                            type: 'post',
                            data: {
                                action: 'woncep_ajax_search_products',
                                query: this.value
                            },
                            beforeSend: function () {
                                $parent.addClass('loading');
                            },
                            success: function (data) {
                                $parent.removeClass('loading');
                                var $data = $.parseJSON(data);
                                $result.empty();
                                $result.show();
                                $.each($data, function (i, item) {
                                    $result.append(template({
                                        url: item.url,
                                        title: item.value,
                                        img: item.img,
                                        price: item.price
                                    }));
                                });
                            }
                        });
                    } else {
                        $result.hide();
                    }
                })
                    .on('click', function (e) {
                        e.stopPropagation();
                    })
                    .on('focus', function (event) {
                        if (this.value.length > 2) {
                            $result.show();
                        }
                    });
            }
        });

    }

    tooltip();

    ajax_live_search();

    $(document).ready(function () {
        ajax_wishlist_count();
    });

})(jQuery);
