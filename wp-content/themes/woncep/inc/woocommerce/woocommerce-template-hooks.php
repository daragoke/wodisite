<?php
/**
 * Woncep WooCommerce hooks
 *
 * @package woncep
 */

/**
 * Layout
 *
 * @see  woncep_before_content()
 * @see  woncep_after_content()
 * @see  woocommerce_breadcrumb()
 * @see  woncep_shop_messages()
 */

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

add_action('woocommerce_before_main_content', 'woncep_before_content', 10);
add_action('woocommerce_after_main_content', 'woncep_after_content', 10);


add_action('woocommerce_before_shop_loop', 'woncep_sorting_wrapper', 19);
add_action('woocommerce_before_shop_loop', 'woncep_button_shop_canvas', 19);
add_action('woocommerce_before_shop_loop', 'woncep_button_grid_list_layout', 25);
add_action('woocommerce_before_shop_loop', 'woncep_sorting_wrapper_close', 31);

// Legacy WooCommerce columns filter.
if (defined('WC_VERSION') && version_compare(WC_VERSION, '3.3', '<')) {
    add_filter('loop_shop_columns', 'woncep_loop_columns');
    add_action('woocommerce_before_shop_loop', 'woncep_product_columns_wrapper', 40);
    add_action('woocommerce_after_shop_loop', 'woncep_product_columns_wrapper_close', 40);
}

add_action('woocommerce_product_tabs', function () {
    global $woocommerce_loop;
    $woocommerce_loop['columns'] = apply_filters('woncep_products_from_seller_column', 4);
}, 9);

/**
 * Products
 *
 * @see woncep_upsell_display()
 * @see woncep_single_product_pagination()
 */

remove_action('woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20);
add_action('woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 21);
add_action('yith_quick_view_custom_style_scripts', function () {
    wp_enqueue_script('flexslider');
});

add_action('woocommerce_single_product_summary', 'woncep_single_product_pagination', 1);
add_action('woocommerce_single_product_summary', 'woncep_stock_label', 2);
add_action('woocommerce_single_product_summary', 'woncep_woocommerce_deal_progress_single', 25);

remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
add_action('woocommerce_after_single_product_summary', 'woncep_upsell_display', 15);

add_action('woocommerce_share', 'woncep_social_share', 10);

$product_single_style = woncep_get_theme_option('single_product_gallery_layout', 'horizontal');
switch ($product_single_style) {
    case 'gallery':

        add_theme_support('wc-product-gallery-lightbox');
        add_filter('woocommerce_single_product_image_thumbnail_html', 'woncep_woocommerce_single_product_image_thumbnail_html', 10, 2);
        break;
    case 'flat':

        add_theme_support('wc-product-gallery-lightbox');
        add_filter('woocommerce_single_product_image_thumbnail_html', 'woncep_woocommerce_single_product_image_thumbnail_html', 10, 2);
        break;
    default :
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
        break;
}

/**
 * Cart fragment
 *
 * @see woncep_cart_link_fragment()
 */
if (defined('WC_VERSION') && version_compare(WC_VERSION, '2.3', '>=')) {
    add_filter('woocommerce_add_to_cart_fragments', 'woncep_cart_link_fragment');
} else {
    add_filter('add_to_cart_fragments', 'woncep_cart_link_fragment');
}

remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
add_action('woocommerce_after_cart', 'woocommerce_cross_sell_display');

add_action('woocommerce_checkout_order_review', 'woocommerce_checkout_order_review_start', 5);
add_action('woocommerce_checkout_order_review', 'woocommerce_checkout_order_review_end', 15);

/*
 *
 * Layout Product
 *
 * */
function woncep_include_hooks_product_blocks() {

    remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
    remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
    remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
    remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
    remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);

    add_action('woocommerce_before_shop_loop_item', 'woncep_woocommerce_product_loop_start', -1);


    /**
     * Integrations
     *
     * @see woncep_template_loop_product_thumbnail()
     *
     */

    add_action('woocommerce_before_shop_loop_item_title', 'woncep_woocommerce_product_loop_image', 10);
    add_action('woocommerce_after_shop_loop_item_title', 'woncep_woocommerce_product_loop_bottom', 15);

    add_action('woncep_woocommerce_product_loop_bottom', 'woncep_woocommerce_product_list_button_action', 35);

    add_action('woncep_woocommerce_product_list_button_action', 'woocommerce_template_loop_add_to_cart', 20);
    add_action('woncep_woocommerce_product_loop_image', 'woncep_woocommerce_get_product_label_stock', 4);
    add_action('woncep_woocommerce_product_loop_image', 'woocommerce_show_product_loop_sale_flash', 5);
    add_action('woncep_woocommerce_product_loop_image', 'woncep_template_loop_product_thumbnail', 10);

    add_action('woncep_woocommerce_product_loop_image', 'woocommerce_template_loop_product_link_open', 99);
    add_action('woncep_woocommerce_product_loop_image', 'woocommerce_template_loop_product_link_close', 99);

    add_action('woocommerce_shop_loop_item_title', 'woncep_woocommerce_product_caption_start', -1);

    add_action('woocommerce_shop_loop_item_title', 'woncep_woocommerce_product_caption_end', 997);

    add_action('woocommerce_after_shop_loop_item', 'woncep_woocommerce_product_loop_end', 999);

    add_action('woncep_woocommerce_product_loop_bottom', 'woocommerce_template_loop_price', 15);
    add_action('woncep_woocommerce_product_list_button_action', 'woncep_woocommerce_product_loop_action', 25);

    // Wishlist
    add_action('woncep_woocommerce_product_loop_action', 'woncep_woocommerce_product_loop_wishlist_button', 15);
    add_action('woncep_woocommerce_product_loop_action', 'woncep_wishlist_button', 15);

    // Compare
    add_action('woncep_woocommerce_product_loop_action', 'woncep_woocommerce_product_loop_compare_button', 10);
    add_action('woncep_woocommerce_product_loop_action', 'woncep_compare_button', 10);
    //Remove position button compare default
    add_filter('woosc_button_position_archive','__return_false');

    // QuickView
    if (woncep_is_woocommerce_extension_activated('YITH_WCQV')) {
        remove_action('woocommerce_after_shop_loop_item', array(
            YITH_WCQV_Frontend::get_instance(),
            'yith_add_quick_view_button'
        ), 15);
        add_action('woncep_woocommerce_product_loop_action', array(
            YITH_WCQV_Frontend::get_instance(),
            'yith_add_quick_view_button'
        ), 5);
    }

    add_action('woncep_woocommerce_product_loop_action', 'woncep_quickview_button', 5);

    $product_style = woncep_get_theme_option('wocommerce_block_style', 1);

    switch ($product_style) {
        case 2:
            remove_action('woncep_woocommerce_product_list_button_action', 'woncep_woocommerce_product_loop_action', 25);
            remove_action('woncep_woocommerce_product_loop_bottom', 'woncep_woocommerce_product_list_button_action', 35);
            remove_action('woncep_woocommerce_product_loop_bottom', 'woocommerce_template_loop_add_to_cart', 20);
            remove_action('woncep_woocommerce_product_loop_action', 'woncep_woocommerce_product_loop_compare_button', 10);
			remove_action('woncep_woocommerce_product_loop_action', 'woncep_compare_button', 10);
            remove_action('woocommerce_shop_loop_item_title', 'woncep_woocommerce_product_loop_bottom', 15);

            add_action('woocommerce_after_shop_loop_item_title', 'woncep_woocommerce_product_loop_bottom', 15);
            add_action('woocommerce_shop_loop_item_title', 'woncep_woocommerce_product_loop_action', 25);
            add_action('woncep_woocommerce_product_loop_image', 'woncep_woocommerce_product_loop_action', 25);
            break;
        case 3:
            remove_action('woocommerce_shop_loop_item_title', 'woncep_woocommerce_product_loop_action', 25);
            remove_action('woncep_woocommerce_product_loop_bottom', 'woncep_woocommerce_product_list_button_action', 35);
            remove_action('woncep_woocommerce_product_loop_bottom', 'woocommerce_template_loop_add_to_cart', 20);
            add_action('woncep_woocommerce_product_loop_image', 'woncep_woocommerce_product_loop_action', 25);
            break;
    }

}

woncep_include_hooks_product_blocks();

