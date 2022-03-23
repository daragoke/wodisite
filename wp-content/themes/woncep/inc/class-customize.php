<?php
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('Woncep_Customize')) {

    class Woncep_Customize {


        public function __construct() {
            add_action('customize_register', array($this, 'customize_register'));
        }

        /**
         * @param $wp_customize WP_Customize_Manager
         */
        public function customize_register($wp_customize) {

            /**
             * Theme options.
             */

            $this->init_woncep_blog($wp_customize);

            $this->woncep_layout($wp_customize);

            $this->init_woncep_social($wp_customize);

            if (woncep_is_woocommerce_activated()) {
                $this->init_woocommerce($wp_customize);
            }

            do_action('woncep_customize_register', $wp_customize);
        }

        /**
         * @param $wp_customize WP_Customize_Manager
         *
         * @return void
         */

        public function woncep_layout($wp_customize) {
            $wp_customize->add_section('woncep_layout', array(
                'title'      => esc_html__('Layout', 'woncep'),
                'capability' => 'edit_theme_options',
            ));

            $wp_customize->add_setting('woncep_options_boxed', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('woncep_options_boxed', array(
                'type'    => 'checkbox',
                'section' => 'woncep_layout',
                'label'   => esc_html__('Layout Boxed', 'woncep'),
            ));

            $wp_customize->add_setting('woncep_options_boxed_width', array(
                'type'              => 'option',
                'default'           => 1400,
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('woncep_options_boxed_width', array(
                'type'    => 'number',
                'section' => 'woncep_layout',
                'label'   => esc_html__('Layout Boxed Max Width (px)', 'woncep'),
            ));

        }


        /**
         * @param $wp_customize WP_Customize_Manager
         *
         * @return void
         */
        public function init_woncep_blog($wp_customize) {

            $wp_customize->add_section('woncep_blog_archive', array(
                'title' => esc_html__('Blog', 'woncep'),
            ));

            // =========================================
            // Select Style
            // =========================================

            $wp_customize->add_setting('woncep_options_blog_style', array(
                'type'              => 'option',
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('woncep_options_blog_style', array(
                'section' => 'woncep_blog_archive',
                'label'   => esc_html__('Blog style', 'woncep'),
                'type'    => 'select',
                'choices' => array(
                    ''             => esc_html__('Standard', 'woncep'),
                    'blog-style-1' => esc_html__('Masonry', 'woncep'),
                    'blog-style-2' => esc_html__('List', 'woncep'),
                    'blog-style-3' => esc_html__('Overlay', 'woncep'),
                ),
            ));

            $wp_customize->add_setting('woncep_options_blog_sidebar', array(
                'type'              => 'option',
                'default'           => 'right',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('woncep_options_blog_sidebar', array(
                'section' => 'woncep_blog_archive',
                'label'   => esc_html__('Sidebar Position', 'woncep'),
                'type'    => 'select',
                'choices' => array(
                    'left'  => esc_html__('Left', 'woncep'),
                    'right' => esc_html__('Right', 'woncep'),

                ),
            ));
        }

        /**
         * @param $wp_customize WP_Customize_Manager
         *
         * @return void
         */
        public function init_woncep_social($wp_customize) {

            $wp_customize->add_section('woncep_social', array(
                'title' => esc_html__('Socials', 'woncep'),
            ));
            $wp_customize->add_setting('woncep_options_social_share', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('woncep_options_social_share', array(
                'type'    => 'checkbox',
                'section' => 'woncep_social',
                'label'   => esc_html__('Show Social Share', 'woncep'),
            ));
            $wp_customize->add_setting('woncep_options_social_share_facebook', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('woncep_options_social_share_facebook', array(
                'type'    => 'checkbox',
                'section' => 'woncep_social',
                'label'   => esc_html__('Share on Facebook', 'woncep'),
            ));
            $wp_customize->add_setting('woncep_options_social_share_twitter', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('woncep_options_social_share_twitter', array(
                'type'    => 'checkbox',
                'section' => 'woncep_social',
                'label'   => esc_html__('Share on Twitter', 'woncep'),
            ));
            $wp_customize->add_setting('woncep_options_social_share_linkedin', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('woncep_options_social_share_linkedin', array(
                'type'    => 'checkbox',
                'section' => 'woncep_social',
                'label'   => esc_html__('Share on Linkedin', 'woncep'),
            ));
            $wp_customize->add_setting('woncep_options_social_share_google-plus', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('woncep_options_social_share_google-plus', array(
                'type'    => 'checkbox',
                'section' => 'woncep_social',
                'label'   => esc_html__('Share on Google+', 'woncep'),
            ));

            $wp_customize->add_setting('woncep_options_social_share_pinterest', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('woncep_options_social_share_pinterest', array(
                'type'    => 'checkbox',
                'section' => 'woncep_social',
                'label'   => esc_html__('Share on Pinterest', 'woncep'),
            ));
            $wp_customize->add_setting('woncep_options_social_share_email', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('woncep_options_social_share_email', array(
                'type'    => 'checkbox',
                'section' => 'woncep_social',
                'label'   => esc_html__('Share on Email', 'woncep'),
            ));
        }

        /**
         * @param $wp_customize WP_Customize_Manager
         *
         * @return void
         */
        public function init_woocommerce($wp_customize) {

            $wp_customize->add_panel('woocommerce', array(
                'title' => esc_html__('Woocommerce', 'woncep'),
            ));

            $wp_customize->add_section('woncep_woocommerce_archive', array(
                'title'      => esc_html__('Archive', 'woncep'),
                'capability' => 'edit_theme_options',
                'panel'      => 'woocommerce',
                'priority'   => 1,
            ));

            $wp_customize->add_setting('woncep_options_woocommerce_archive_layout', array(
                'type'              => 'option',
                'default'           => 'default',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('woncep_options_woocommerce_archive_layout', array(
                'section' => 'woncep_woocommerce_archive',
                'label'   => esc_html__('Layout Style', 'woncep'),
                'type'    => 'select',
                'choices' => array(
                    'default'      => esc_html__('Default', 'woncep'),
                    'canvas' => esc_html__('Hide Sidebar', 'woncep'),
                ),
            ));

            $wp_customize->add_setting('woncep_options_woocommerce_archive_sidebar', array(
                'type'              => 'option',
                'default'           => 'left',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('woncep_options_woocommerce_archive_sidebar', array(
                'section' => 'woncep_woocommerce_archive',
                'label'   => esc_html__('Sidebar Position', 'woncep'),
                'type'    => 'select',
                'choices' => array(
                    'left'  => esc_html__('Left', 'woncep'),
                    'right' => esc_html__('Right', 'woncep'),

                ),
            ));

            $wp_customize->add_setting('woncep_options_woocommerce_archive_fluid', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('woncep_options_woocommerce_archive_fluid', array(
                'type'    => 'checkbox',
                'section' => 'woncep_woocommerce_archive',
                'label'   => esc_html__('Full Width', 'woncep'),
            ));

            // =========================================
            // Single Product
            // =========================================

            $wp_customize->add_section('woncep_woocommerce_single', array(
                'title'      => esc_html__('Single Product', 'woncep'),
                'capability' => 'edit_theme_options',
                'panel'      => 'woocommerce',
            ));

            $wp_customize->add_setting('woncep_options_single_product_gallery_layout', array(
                'type'              => 'option',
                'default'           => 'horizontal',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control('woncep_options_single_product_gallery_layout', array(
                'section' => 'woncep_woocommerce_single',
                'label'   => esc_html__('Gallery Style', 'woncep'),
                'type'    => 'select',
                'choices' => array(
                    'horizontal' => esc_html__('Horizontal', 'woncep'),
                    'vertical'   => esc_html__('Vertical', 'woncep'),
                    'gallery'    => esc_html__('Gallery', 'woncep'),
                    'flat'       => esc_html__('Flat', 'woncep'),
                ),
            ));

            $wp_customize->add_setting('woncep_options_woocommerce_items_thumbnail', array(
                'type'              => 'option',
                'default'           => '5',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control('woncep_options_woocommerce_items_thumbnail', array(
                'section' => 'woncep_woocommerce_single',
                'label'   => esc_html__('Number thumbnails', 'woncep'),
                'type'    => 'select',
                'choices' => array(
                    '1' => esc_html__('1', 'woncep'),
                    '2' => esc_html__('2', 'woncep'),
                    '3' => esc_html__('3', 'woncep'),
                    '4' => esc_html__('4', 'woncep'),
                    '5' => esc_html__('5', 'woncep'),
                    '6' => esc_html__('6', 'woncep'),
                    '7' => esc_html__('7', 'woncep'),
                    '8' => esc_html__('8', 'woncep'),
                ),
            ));


            // =========================================
            // Product
            // =========================================

            $wp_customize->add_section('woncep_woocommerce_product', array(
                'title'      => esc_html__('Product Block', 'woncep'),
                'capability' => 'edit_theme_options',
                'panel'      => 'woocommerce',
            ));

            $wp_customize->add_setting('woncep_options_wocommerce_block_style', array(
                'type'              => 'option',
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control('woncep_options_wocommerce_block_style', array(
                'section' => 'woncep_woocommerce_product',
                'label'   => esc_html__('Style', 'woncep'),
                'type'    => 'select',
                'choices' => array(
                    '1' => esc_html__('Style 1', 'woncep'),
                    '2' => esc_html__('Style 2', 'woncep'),
                    '3' => esc_html__('Style 3', 'woncep'),
                ),
            ));

            $wp_customize->add_setting('woncep_options_woocommerce_product_hover', array(
                'type'              => 'option',
                'default'           => 'none',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control('woncep_options_woocommerce_product_hover', array(
                'section' => 'woncep_woocommerce_product',
                'label'   => esc_html__('Animation Image Hover', 'woncep'),
                'type'    => 'select',
                'choices' => array(
                    'none'          => esc_html__('None', 'woncep'),
                    'bottom-to-top' => esc_html__('Bottom to Top', 'woncep'),
                    'top-to-bottom' => esc_html__('Top to Bottom', 'woncep'),
                    'right-to-left' => esc_html__('Right to Left', 'woncep'),
                    'left-to-right' => esc_html__('Left to Right', 'woncep'),
                    'swap'          => esc_html__('Swap', 'woncep'),
                    'fade'          => esc_html__('Fade', 'woncep'),
                    'zoom-in'       => esc_html__('Zoom In', 'woncep'),
                    'zoom-out'      => esc_html__('Zoom Out', 'woncep'),
                ),
            ));

            $wp_customize->add_setting('woncep_options_wocommerce_row_tablet', array(
                'type'              => 'option',
                'default'           => 3,
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('woncep_options_wocommerce_row_tablet', array(
                'section' => 'woocommerce_product_catalog',
                'label'   => esc_html__('Products per row tablet', 'woncep'),
                'type'    => 'select',
                'choices' => array(
                    '1' => esc_html__('1', 'woncep'),
                    '2' => esc_html__('2', 'woncep'),
                    '3' => esc_html__('3', 'woncep'),
                )
            ));

            $wp_customize->add_setting('woncep_options_wocommerce_row_mobile', array(
                'type'              => 'option',
                'default'           => 2,
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('woncep_options_wocommerce_row_mobile', array(
                'section' => 'woocommerce_product_catalog',
                'label'   => esc_html__('Products per row mobile', 'woncep'),
                'type'    => 'select',
                'choices' => array(
                    '1' => esc_html__('1', 'woncep'),
                    '2' => esc_html__('2', 'woncep'),
                )
            ));
        }
    }
}
return new Woncep_Customize();
