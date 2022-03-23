<?php
/**
 * =================================================
 * Hook woncep_page
 * =================================================
 */

/**
 * =================================================
 * Hook woncep_post_content_before
 * =================================================
 */

/**
 * =================================================
 * Hook woncep_post_content_after
 * =================================================
 */

/**
 * =================================================
 * Hook woncep_single_post_top
 * =================================================
 */

/**
 * =================================================
 * Hook woncep_single_post
 * =================================================
 */

/**
 * =================================================
 * Hook woncep_single_post_bottom
 * =================================================
 */

/**
 * =================================================
 * Hook woncep_loop_post
 * =================================================
 */

/**
 * =================================================
 * Hook woncep_footer
 * =================================================
 */
add_action('woncep_footer', 'woncep_handheld_footer_bar', 25);

/**
 * =================================================
 * Hook woncep_after_footer
 * =================================================
 */
add_action('woncep_after_footer', 'woncep_sticky_single_add_to_cart', 999);

/**
 * =================================================
 * Hook wp_footer
 * =================================================
 */
add_action('wp_footer', 'woncep_render_woocommerce_shop_canvas', 1);

/**
 * =================================================
 * Hook woncep_before_header
 * =================================================
 */

/**
 * =================================================
 * Hook woncep_before_content
 * =================================================
 */

/**
 * =================================================
 * Hook woncep_content_top
 * =================================================
 */
add_action('woncep_content_top', 'woncep_shop_messages', 10);

/**
 * =================================================
 * Hook woncep_post_header_before
 * =================================================
 */

/**
 * =================================================
 * Hook woncep_sidebar
 * =================================================
 */

/**
 * =================================================
 * Hook woncep_loop_after
 * =================================================
 */

/**
 * =================================================
 * Hook woncep_page_after
 * =================================================
 */

/**
 * =================================================
 * Hook woncep_woocommerce_before_shop_loop_item
 * =================================================
 */

/**
 * =================================================
 * Hook woncep_woocommerce_before_shop_loop_item_title
 * =================================================
 */
add_action('woncep_woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
add_action('woncep_woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

/**
 * =================================================
 * Hook woncep_woocommerce_shop_loop_item_title
 * =================================================
 */
add_action('woncep_woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
add_action('woncep_woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

/**
 * =================================================
 * Hook woncep_woocommerce_after_shop_loop_item_title
 * =================================================
 */
add_action('woncep_woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
add_action('woncep_woocommerce_after_shop_loop_item_title', 'woncep_woocommerce_get_product_description', 15);
add_action('woncep_woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 20);
add_action('woncep_woocommerce_after_shop_loop_item_title', 'woncep_woocommerce_product_loop_action', 25);

/**
 * =================================================
 * Hook woncep_woocommerce_after_shop_loop_item
 * =================================================
 */
