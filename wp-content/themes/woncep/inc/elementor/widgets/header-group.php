<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

class OSF_Elementor_Header_Group extends Elementor\Widget_Base
{

    public function get_name() {
        return 'woncep-header-group';
    }

    public function get_title() {
        return esc_html__('Woncep Header Group', 'woncep');
    }

    public function get_icon() {
        return 'eicon-lock-user';
    }

    public function get_categories()
    {
        return array('woncep-addons');
    }

    public function get_script_depends() {
        return ['woncep-elementor-header-group', 'slick', 'woncep-cart-canvas'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'header_group_config',
            [
                'label' => esc_html__('Config', 'woncep'),
            ]
        );

        $this->add_control(
            'show_search',
            [
                'label' => esc_html__( 'Show search', 'woncep' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'show_account',
            [
                'label' => esc_html__( 'Show account', 'woncep' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'show_wishlist',
            [
                'label' => esc_html__( 'Show wishlist', 'woncep' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'show_cart',
            [
                'label' => esc_html__( 'Show cart', 'woncep' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this -> add_control(
            'cart_dropdown',
            [
                'condition'  => ['show_cart' => 'yes'],
                'label' => esc_html__('Cart Content', 'woncep'),
                'type'  => Controls_Manager::SELECT,
                'options'   => [
                    '1' => esc_html__('Cart Canvas', 'woncep'),
                    '2' =>  esc_html__('Cart Dropdown', 'woncep'),
                ],
                'default'   => '1',
            ]
        );


        $this->end_controls_section();

        $this -> start_controls_section(
            'header-group-style',
            [
                'label' => esc_html__('Icon','woncep'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__( 'Color', 'woncep' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-header-group-wrapper .header-group-action > div a:not(:hover) i:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-header-group-wrapper .header-group-action > div a:not(:hover):before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-header-group-wrapper .header-group-action .site-header-cart .cart-contents .amount' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'video_size',
            [
                'label'     => esc_html__('Font Size', 'woncep'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-header-group-wrapper .header-group-action > div a i:before' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-header-group-wrapper .header-group-action > div a:before' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute( 'wrapper', 'class', 'elementor-header-group-wrapper' );
        ?>
        <div <?php echo woncep_elementor_get_render_attribute_string('wrapper', $this);?>>
            <div class="header-group-action">
                <?php if ( $settings['show_search'] === 'yes' ):{
                    woncep_header_search_button();
                }
                endif; ?>

                <?php if ( $settings['show_account'] === 'yes' ):{
                    woncep_header_account();
                }
                endif; ?>

                <?php if ( $settings['show_wishlist'] === 'yes' ):{
                    woncep_header_wishlist();
                }
                endif; ?>

                <?php if ( $settings['show_cart'] === 'yes' ):{
                    if ( woncep_is_woocommerce_activated() ) {
                        ?>
                        <div class="site-header-cart menu">
                            <?php woncep_cart_link(); ?>
                            <?php
                            if ( ! apply_filters( 'woocommerce_widget_cart_is_hidden', is_cart() || is_checkout() ) ) {
                                if ( $settings['cart_dropdown'] === '1' ) {
                                    add_action( 'wp_footer', 'woncep_header_cart_side' );
                                } else {
                                    the_widget( 'WC_Widget_Cart', 'title=' );
                                }
                            }
                            ?>
                        </div>
                        <?php
                    }
                }
                endif; ?>
            </div>
        </div>
        <?php
    }
}

$widgets_manager->register_widget_type(new OSF_Elementor_Header_Group());
