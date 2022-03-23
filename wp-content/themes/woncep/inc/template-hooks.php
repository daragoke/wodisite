<?php
/**
 * =================================================
 * Hook woncep_page
 * =================================================
 */
add_action('woncep_page', 'woncep_page_header', 10);
add_action('woncep_page', 'woncep_page_content', 20);

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
add_action('woncep_single_post_top', 'woncep_post_header', 10);

/**
 * =================================================
 * Hook woncep_single_post
 * =================================================
 */
add_action('woncep_single_post', 'woncep_post_thumbnail', 10);
add_action('woncep_single_post', 'woncep_post_content', 30);

/**
 * =================================================
 * Hook woncep_single_post_bottom
 * =================================================
 */
add_action('woncep_single_post_bottom', 'woncep_post_taxonomy', 5);
add_action('woncep_single_post_bottom', 'woncep_post_nav', 10);
add_action('woncep_single_post_bottom', 'woncep_display_comments', 20);

/**
 * =================================================
 * Hook woncep_loop_post
 * =================================================
 */
add_action('woncep_loop_post', 'woncep_post_thumbnail', 10);
add_action('woncep_loop_post', 'woncep_post_header', 15);
add_action('woncep_loop_post', 'woncep_post_content', 30);

/**
 * =================================================
 * Hook woncep_footer
 * =================================================
 */
add_action('woncep_footer', 'woncep_footer_default', 20);

/**
 * =================================================
 * Hook woncep_after_footer
 * =================================================
 */

/**
 * =================================================
 * Hook wp_footer
 * =================================================
 */
add_action('wp_footer', 'woncep_template_account_dropdown', 1);
add_action('wp_footer', 'woncep_mobile_nav', 1);

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
add_action('woncep_sidebar', 'woncep_get_sidebar', 10);

/**
 * =================================================
 * Hook woncep_loop_after
 * =================================================
 */
add_action('woncep_loop_after', 'woncep_paging_nav', 10);

/**
 * =================================================
 * Hook woncep_page_after
 * =================================================
 */
add_action('woncep_page_after', 'woncep_display_comments', 10);

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

/**
 * =================================================
 * Hook woncep_woocommerce_shop_loop_item_title
 * =================================================
 */

/**
 * =================================================
 * Hook woncep_woocommerce_after_shop_loop_item_title
 * =================================================
 */

/**
 * =================================================
 * Hook woncep_woocommerce_after_shop_loop_item
 * =================================================
 */
