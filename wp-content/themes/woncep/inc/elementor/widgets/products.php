<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! woncep_is_woocommerce_activated() ) {
	return;
}

use Elementor\Controls_Manager;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Woncep_Elementor_Widget_Products extends \Elementor\Widget_Base {


	public function get_categories() {
		return array( 'woncep-addons' );
	}

	/**
	 * Get widget name.
	 *
	 * Retrieve tabs widget name.
	 *
	 * @return string Widget name.
	 * @since  1.0.0
	 * @access public
	 *
	 */
	public function get_name() {
		return 'woncep-products';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve tabs widget title.
	 *
	 * @return string Widget title.
	 * @since  1.0.0
	 * @access public
	 *
	 */
	public function get_title() {
		return esc_html__( 'Products', 'woncep' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve tabs widget icon.
	 *
	 * @return string Widget icon.
	 * @since  1.0.0
	 * @access public
	 *
	 */
	public function get_icon() {
		return 'eicon-tabs';
	}


	public function get_script_depends() {
		return [
			'woncep-elementor-products',
			'slick',
			'tooltipster'
		];
	}

	/**
	 * Register tabs widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		//Section Query
		$this->start_controls_section(
			'section_setting',
			[
				'label' => esc_html__( 'Settings', 'woncep' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

        $options_product_type = [
            'newest'       => esc_html__('Newest Products', 'woncep'),
            'on_sale'      => esc_html__('On Sale Products', 'woncep'),
            'best_selling' => esc_html__('Best Selling', 'woncep'),
            'top_rated'    => esc_html__('Top Rated', 'woncep'),
            'featured'     => esc_html__('Featured Product', 'woncep'),
        ];

        if (woncep_is_elementor_pro_activated()) {
            $options_product_type['ids'] = esc_html__('Product Ids', 'woncep');
        }

        $this->add_control(
            'product_type',
            [
                'label'   => esc_html__('Product Type', 'woncep'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'newest',
                'options' => $options_product_type,
            ]
        );

        if (woncep_is_elementor_pro_activated()) {
            $this->add_control(
                'product_ids',
                [
                    'label'        => esc_html__('Product ids', 'woncep'),
                    'type'         => ElementorPro\Modules\QueryControl\Module::QUERY_CONTROL_ID,
                    'label_block'  => true,
                    'autocomplete' => [
                        'object' => ElementorPro\Modules\QueryControl\Module::QUERY_OBJECT_POST,
                        'query'  => [
                            'post_type' => 'product',
                        ],
                    ],
                    'multiple'     => true,
                    'condition'    => [
                        'product_type' => 'ids'
                    ]
                ]
            );
        }

		$this->add_control(
			'limit',
			[
				'label'   => esc_html__( 'Posts Per Page', 'woncep' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
			]
		);

		$this->add_responsive_control(
			'column',
			[
				'label'          => esc_html__( 'columns', 'woncep' ),
				'type'           => \Elementor\Controls_Manager::SELECT,
				'default'        => 3,
				'tablet_default' => 2,
				'mobile_default' => 1,
				'options'        => [ 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6 ],
			]
		);


		$this->add_control(
			'advanced',
			[
				'label' => esc_html__( 'Advanced', 'woncep' ),
				'type'  => Controls_Manager::HEADING,
                'condition' => [
                        'product_type!'  => 'ids'
                ]
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order By', 'woncep' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'       => esc_html__( 'Date', 'woncep' ),
					'id'         => esc_html__( 'Post ID', 'woncep' ),
					'menu_order' => esc_html__( 'Menu Order', 'woncep' ),
					'popularity' => esc_html__( 'Number of purchases', 'woncep' ),
					'rating'     => esc_html__( 'Average Product Rating', 'woncep' ),
					'title'      => esc_html__( 'Product Title', 'woncep' ),
					'rand'       => esc_html__( 'Random', 'woncep' ),
				],
                'condition' => [
                    'product_type!'  => 'ids'
                ]
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'woncep' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc'  => esc_html__( 'ASC', 'woncep' ),
					'desc' => esc_html__( 'DESC', 'woncep' ),
				],
                'condition' => [
                    'product_type!'  => 'ids'
                ]
			]
		);

		$this->add_control(
			'categories',
			[
				'label'    => esc_html__( 'Categories', 'woncep' ),
				'type'     => Controls_Manager::SELECT2,
				'options'  => $this->get_product_categories(),
				'label_block' => true,
				'multiple' => true,
                'condition' => [
                    'product_type!'  => 'ids'
                ]
			]
		);

		$this->add_control(
			'cat_operator',
			[
				'label'     => esc_html__( 'Category Operator', 'woncep' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'IN',
				'options'   => [
					'AND'    => esc_html__( 'AND', 'woncep' ),
					'IN'     => esc_html__( 'IN', 'woncep' ),
					'NOT IN' => esc_html__( 'NOT IN', 'woncep' ),
				],
				'condition' => [
					'categories!' => ''
				],
			]
		);

		$this->add_control(
			'tag',
			[
				'label'    => esc_html__( 'Tags', 'woncep' ),
				'type'     => Controls_Manager::SELECT2,
				'label_block' => true,
				'options'  => $this->get_product_tags(),
				'multiple' => true,
                'condition' => [
                    'product_type!'  => 'ids'
                ]
			]
		);

		$this->add_control(
			'tag_operator',
			[
				'label'     => esc_html__( 'Tag Operator', 'woncep' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'IN',
				'options'   => [
					'AND'    => esc_html__( 'AND', 'woncep' ),
					'IN'     => esc_html__( 'IN', 'woncep' ),
					'NOT IN' => esc_html__( 'NOT IN', 'woncep' ),
				],
				'condition' => [
					'tag!' => ''
				],
			]
		);

		$this->add_control(
			'paginate',
			[
				'label'   => esc_html__( 'Paginate', 'woncep' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'       => esc_html__( 'None', 'woncep' ),
					'pagination' => esc_html__( 'Pagination', 'woncep' ),
				],
			]
		);

		$this->add_control(
			'product_layout',
			[
				'label'   => esc_html__( 'Product Layout', 'woncep' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => [
					'grid' => esc_html__( 'Grid', 'woncep' ),
					'list' => esc_html__( 'List', 'woncep' ),
				],
			]
		);

		$this->add_control(
			'list_layout',
			[
				'label'     => esc_html__( 'List Layout', 'woncep' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '1',
				'options'   => [
					'1' => esc_html__( 'Style 1', 'woncep' ),
					'2' => esc_html__( 'Style 2', 'woncep' ),
					'3' => esc_html__( 'Style 3', 'woncep' ),
					'4' => esc_html__( 'Style 4', 'woncep' ),
					'5' => esc_html__( 'Style 5', 'woncep' ),
				],
				'condition' => [
					'product_layout' => 'list'
				]
			]
		);

		$this->add_control(
			'hide_except',
			[
				'label'      => esc_html__( 'Hide Except', 'woncep' ),
				'type'       => Controls_Manager::SWITCHER,
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'product_layout',
							'operator' => '==',
							'value'    => 'list',
						],
						[
							'name'     => 'list_layout',
							'operator' => '==',
							'value'    => '5',
						]
					],
				]
			]
		);

		$this->add_control(
			'hide_border',
			[
				'label'        => esc_html__( 'Hide Border', 'woncep' ),
				'type'         => Controls_Manager::SWITCHER,
				'condition'    => [
					'product_layout' => 'list',
				],
				'return_value' => 'hide',
				'prefix_class' => 'product-list-border-'
			]
		);

		$this->add_responsive_control(
			'product_gutter',
			[
				'label'      => esc_html__( 'Gutter', 'woncep' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} ul.products li.product'      => 'padding-left: calc({{SIZE}}{{UNIT}} / 2); padding-right: calc({{SIZE}}{{UNIT}} / 2); margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} ul.products li.product-item' => 'padding-left: calc({{SIZE}}{{UNIT}} / 2); padding-right: calc({{SIZE}}{{UNIT}} / 2); margin-bottom: calc({{SIZE}}{{UNIT}} - 1px);',
					'{{WRAPPER}} ul.products'                 => 'margin-left: calc({{SIZE}}{{UNIT}} / -2); margin-right: calc({{SIZE}}{{UNIT}} / -2);',
				],
			]
		);

		$this->end_controls_section();
		// End Section Query

        $this->start_controls_section(
            'section_style_product',
            [
                'label' => esc_html__('Product', 'woncep'),
                'tab' => Controls_Manager::TAB_STYLE,

            ]
        );
        $this->start_controls_tabs( 'product_title_style' );

        $this->start_controls_tab(
            'product_normal',
            [
                'label' => esc_html__( 'Normal', 'woncep' ),
            ]
        );
        $this->add_control(
            'divider_product_color',
            [
                'label' => esc_html__('Color Divider', 'woncep'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} ul.products li.product .product-caption' => 'border-top-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_product_color',
            [
                'label' => esc_html__('Color Title', 'woncep'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} ul.products li.product h3 a:not(:hover)' => 'color: {{VALUE}};',
                    '{{WRAPPER}} ul.products li.product .woocommerce-loop-product__title a:not(:hover)' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .product-block .product-caption .woocommerce-loop-product__title:after' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'price_product_color',
            [
                'label' => esc_html__('Color Price', 'woncep'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} ul.products li.product .price' => 'color: {{VALUE}};',
                    '{{WRAPPER}} ul.products li.product .price del' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'add_to_cart_product_color',
            [
                'label' => esc_html__('Color Cart', 'woncep'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} ul.products li.product a[class*="product_type_"]:not(:hover)' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_action_product_color',
            [
                'label' => esc_html__('Color Button action', 'woncep'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .shop-action .yith-wcqv-button:not(:hover):before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .shop-action .yith-wcwl-add-to-wishlist > div > a:not(:hover):before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .shop-action .compare:not(:hover):before' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'product_hover',
            [
                'label' => esc_html__( 'Hover', 'woncep' ),
            ]
        );

        $this->add_control(
            'title_product_color_hover',
            [
                'label' => esc_html__('Color Title', 'woncep'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} ul.products li.product .woocommerce-loop-product__title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'add_to_cart_product_color_hover',
            [
                'label' => esc_html__('Color Cart', 'woncep'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} ul.products li.product a[class*="product_type_"]:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_action_product_color_hover',
            [
                'label' => esc_html__('Color Button action', 'woncep'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .shop-action .yith-wcqv-button:hover:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .shop-action .yith-wcwl-add-to-wishlist > div > a:hover:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .shop-action .compare:hover:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();


        $this->end_controls_section();

		// Carousel Option
		$this->add_control_carousel();
	}

	protected function get_product_categories() {
		$categories = get_terms( array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => false,
			)
		);
		$results    = array();
		if ( ! is_wp_error( $categories ) ) {
			foreach ( $categories as $category ) {
				$results[ $category->slug ] = $category->name;
			}
		}

		return $results;
	}

	protected function get_product_tags() {
		$tags    = get_terms( array(
				'taxonomy'   => 'product_tag',
				'hide_empty' => false,
			)
		);
		$results = array();
		if ( ! is_wp_error( $tags ) ) {
			foreach ( $tags as $tag ) {
				$results[ $tag->slug ] = $tag->name;
			}
		}

		return $results;
	}

	protected function get_product_type( $atts, $product_type ) {
		switch ( $product_type ) {
			case 'featured':
				$atts['visibility'] = "featured";
				break;

			case 'on_sale':
				$atts['on_sale'] = true;
				break;

			case 'best_selling':
				$atts['best_selling'] = true;
				break;

			case 'top_rated':
				$atts['top_rated'] = true;
				break;

			default:
				break;
		}

		return $atts;
	}

	/**
	 * Render tabs widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->woocommerce_default( $settings );
	}

	private function woocommerce_default( $settings ) {
		$type = 'products';
		$atts = [
			'limit'          => $settings['limit'],
			'columns'        => $settings['enable_carousel'] === 'yes' ? 1 : $settings['column'],
			'orderby'        => $settings['orderby'],
			'order'          => $settings['order'],
			'product_layout' => $settings['product_layout'],
		];

		$class = '';


		if ( $settings['product_layout'] == 'list' ) {

			$class .= ' products-list';
			$class .= ' producs-list-' . $settings['list_layout'];
			$class .= ' woocommerce-product-list';

			if ( ! empty( $settings['list_layout'] ) && $settings['list_layout'] == '2' ) {
				$atts['show_category'] = true;
				$atts['show_button']   = true;
			}

			if ( ! empty( $settings['list_layout'] ) && $settings['list_layout'] == '3' ) {
				$atts['show_category'] = true;
				$atts['show_except']   = true;
			}

			if ( ! empty( $settings['list_layout'] ) && $settings['list_layout'] == '5' ) {
				$atts['show_category']  = true;
				$atts['show_except']    = true;
				$atts['show_time_sale'] = true;
				$atts['show_rating']    = true;
			}

			if ( $settings['hide_except'] == 'yes' ) {
				$atts['show_except'] = '';
			}

		}

		$atts = $this->get_product_type( $atts, $settings['product_type'] );
		if ( isset( $atts['on_sale'] ) && wc_string_to_bool( $atts['on_sale'] ) ) {
			$type = 'sale_products';
		} elseif ( isset( $atts['best_selling'] ) && wc_string_to_bool( $atts['best_selling'] ) ) {
			$type = 'best_selling_products';
		} elseif ( isset( $atts['top_rated'] ) && wc_string_to_bool( $atts['top_rated'] ) ) {
			$type = 'top_rated_products';
		}

        if (isset($settings['product_ids']) && ! empty( $settings['product_ids'] )  && $settings['product_type'] == 'ids') {
            $atts['ids'] = implode( ',', $settings['product_ids'] );
        }

		if ( ! empty( $settings['categories'] ) ) {
			$atts['category']     = implode( ',', $settings['categories'] );
			$atts['cat_operator'] = $settings['cat_operator'];
		}

		if ( ! empty( $settings['tag'] ) ) {
			$atts['tag']          = implode( ',', $settings['tag'] );
			$atts['tag_operator'] = $settings['tag_operator'];
		}

		// Carousel
		if ( $settings['enable_carousel'] === 'yes' ) {
			$atts['carousel_settings'] = json_encode( wp_slash( $this->get_carousel_settings() ) );
			$atts['product_layout']    = 'carousel';
			if ( $settings['product_layout'] == 'list' ) {
				$atts['product_layout'] = 'list-carousel';
			}
		} else {
			if ( ! empty( $settings['column_tablet'] ) ) {
				$class .= ' columns-tablet-' . $settings['column_tablet'];
			}

			if ( ! empty( $settings['column_mobile'] ) ) {
				$class .= ' columns-mobile-' . $settings['column_mobile'];
			}
		}
		$atts['class'] = $class;

		if ( $settings['paginate'] === 'pagination' ) {
			$atts['paginate'] = 'true';
		}

		echo ( new WC_Shortcode_Products( $atts, $type ) )->get_content(); // WPCS: XSS ok
	}

	protected function add_control_carousel( $condition = array() ) {
		$this->start_controls_section(
			'section_carousel_options',
			[
				'label'     => esc_html__( 'Carousel Options', 'woncep' ),
				'type'      => Controls_Manager::SECTION,
				'condition' => $condition,
			]
		);

		$this->add_control(
			'enable_carousel',
			[
				'label' => esc_html__( 'Enable', 'woncep' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);


		$this->add_control(
			'navigation',
			[
				'label'     => esc_html__( 'Navigation', 'woncep' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'dots',
				'options'   => [
					'both'   => esc_html__( 'Arrows and Dots', 'woncep' ),
					'arrows' => esc_html__( 'Arrows', 'woncep' ),
					'dots'   => esc_html__( 'Dots', 'woncep' ),
					'none'   => esc_html__( 'None', 'woncep' ),
				],
				'condition' => [
					'enable_carousel' => 'yes'
				],
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label'     => esc_html__( 'Pause on Hover', 'woncep' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'enable_carousel' => 'yes'
				],
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'     => esc_html__( 'Autoplay', 'woncep' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'enable_carousel' => 'yes'
				],
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Speed', 'woncep' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => [
					'autoplay'        => 'yes',
					'enable_carousel' => 'yes'
				],
				'selectors' => [
					'{{WRAPPER}} .slick-slide-bg' => 'animation-duration: calc({{VALUE}}ms*1.2); transition-duration: calc({{VALUE}}ms)',
				],
			]
		);

		$this->add_control(
			'infinite',
			[
				'label'     => esc_html__( 'Infinite Loop', 'woncep' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'enable_carousel' => 'yes'
				],
			]
		);

		$this->add_control(
			'product_carousel_border',
			[
				'label'        => esc_html__( 'Border Wrapper', 'woncep' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'border-wrapper-',
				'condition'    => [
					'enable_carousel' => 'yes'
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'carousel_arrows',
			[
				'label'      => esc_html__( 'Carousel Arrows', 'woncep' ),
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'enable_carousel',
							'operator' => '==',
							'value'    => 'yes',
						],
						[
							'name'     => 'navigation',
							'operator' => '!==',
							'value'    => 'none',
						],
						[
							'name'     => 'navigation',
							'operator' => '!==',
							'value'    => 'dots',
						],
					],
				],
			]
		);

		//Style arrow
		$this->add_control(
			'style_arrow',
			[
				'label' => esc_html__( 'Style Arrow', 'woncep' ),
				'type'  => Controls_Manager::HEADING,
			]
		);
		//add icon next size
		$this->add_responsive_control(
			'icon_size',
			[
				'label'     => esc_html__( 'Size', 'woncep' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .slick-arrow:before' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		//add icon next color
		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'woncep' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .slick-arrow:before' => 'color: {{VALUE}};',
				],
				'separator' => 'after'

			]
		);

		$this->add_control(
			'next_heading',
			[
				'label' => esc_html__( 'Next button', 'woncep' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'next_vertical',
			[
				'label'       => esc_html__( 'Next Vertical', 'woncep' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'top'    => [
						'title' => esc_html__( 'Top', 'woncep' ),
						'icon'  => 'eicon-v-align-top',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'woncep' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				]
			]
		);

		$this->add_responsive_control(
			'next_vertical_value',
			[
				'type'       => Controls_Manager::SLIDER,
				'show_label' => false,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => - 1000,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min' => - 100,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors'  => [
					'{{WRAPPER}} .slick-next' => 'top: unset; bottom: unset; {{next_vertical.value}}: {{SIZE}}{{UNIT}};',
				]
			]
		);
		$this->add_control(
			'next_horizontal',
			[
				'label'       => esc_html__( 'Next Horizontal', 'woncep' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'left'  => [
						'title' => esc_html__( 'Left', 'woncep' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'woncep' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'defautl'     => 'right'
			]
		);
		$this->add_responsive_control(
			'next_horizontal_value',
			[
				'type'       => Controls_Manager::SLIDER,
				'show_label' => false,
				'size_units' => [ 'px', 'em', '%' ],
				'range'      => [
					'px' => [
						'min'  => - 1000,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min' => - 100,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => - 45,
				],
				'selectors'  => [
					'{{WRAPPER}} .slick-next' => 'left: unset; right: unset;{{next_horizontal.value}}: {{SIZE}}{{UNIT}};',
				]
			]
		);


		$this->add_control(
			'prev_heading',
			[
				'label'     => esc_html__( 'Prev button', 'woncep' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'prev_vertical',
			[
				'label'       => esc_html__( 'Prev Vertical', 'woncep' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'top'    => [
						'title' => esc_html__( 'Top', 'woncep' ),
						'icon'  => 'eicon-v-align-top',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'woncep' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				]
			]
		);

		$this->add_responsive_control(
			'prev_vertical_value',
			[
				'type'       => Controls_Manager::SLIDER,
				'show_label' => false,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => - 1000,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min' => - 100,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors'  => [
					'{{WRAPPER}} .slick-prev' => 'top: unset; bottom: unset; {{prev_vertical.value}}: {{SIZE}}{{UNIT}};',
				]
			]
		);
		$this->add_control(
			'prev_horizontal',
			[
				'label'       => esc_html__( 'Prev Horizontal', 'woncep' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'left'  => [
						'title' => esc_html__( 'Left', 'woncep' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'woncep' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'defautl'     => 'left'
			]
		);
		$this->add_responsive_control(
			'prev_horizontal_value',
			[
				'type'       => Controls_Manager::SLIDER,
				'show_label' => false,
				'size_units' => [ 'px', 'em', '%' ],
				'range'      => [
					'px' => [
						'min'  => - 1000,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min' => - 100,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => - 45,
				],
				'selectors'  => [
					'{{WRAPPER}} .slick-prev' => 'left: unset; right: unset; {{prev_horizontal.value}}: {{SIZE}}{{UNIT}};',
				]
			]
		);

        $this->add_control(
            'color_button',
            [
                'label' => esc_html__( 'Color button', 'woncep' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );
        $this->add_control(
            'button_color_normal',
            [
                'label' => esc_html__( 'Color Normal', 'woncep' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-prev:before' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .slick-next:before' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'button_color',
            [
                'label' => esc_html__( 'Color Active', 'woncep' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-prev:hover:before' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .slick-prev:focus:before' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .slick-slider button.slick-next:hover:before' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .slick-slider button.slick-next:focus:before' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->end_controls_section();


        $this->start_controls_section(
            'carousel_dots',
            [
                'label'      => esc_html__( 'Carousel Dots', 'woncep' ),
                'conditions' => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'enable_carousel',
                            'operator' => '==',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'navigation',
                            'operator' => '!==',
                            'value'    => 'none',
                        ],
                        [
                            'name'     => 'navigation',
                            'operator' => '!==',
                            'value'    => 'arrows',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'testimonial_dots_align',
            [
                'label'        => esc_html__('Alignment', 'woncep'),
                'type'         => Controls_Manager::CHOOSE,
                'options'      => [
                    'left'   => [
                        'title' => esc_html__('Left', 'woncep'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'woncep'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'woncep'),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'      => 'center',
                'selectors'    => [
                    '{{WRAPPER}} .slick-dots' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_carousel_dots_style');

        $this->start_controls_tab(
            'tab_carousel_dots_normal',
            [
                'label' => esc_html__('Normal', 'woncep'),
            ]
        );

        $this->add_control(
            'carousel_dots_color',
            [
                'label'     => esc_html__('Color', 'woncep'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .slick-dots li button:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_dots_opacity',
            [
                'label'     => esc_html__('Opacity', 'woncep'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-dots li button:before' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_carousel_dots_hover',
            [
                'label' => esc_html__('Hover', 'woncep'),
            ]
        );

        $this->add_control(
            'carousel_dots_color_hover',
            [
                'label'     => esc_html__('Color Hover', 'woncep'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .slick-dots li button:hover:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .slick-dots li button:focus:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_dots_opacity_hover',
            [
                'label'     => esc_html__('Opacity', 'woncep'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-dots li button:hover:before' => 'opacity: {{SIZE}};',
                    '{{WRAPPER}} .slick-dots li button:focus:before' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_carousel_dots_activate',
            [
                'label' => esc_html__('Activate', 'woncep'),
            ]
        );

        $this->add_control(
            'carousel_dots_color_activate',
            [
                'label'     => esc_html__('Color', 'woncep'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .slick-dots li.slick-active button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_dots_opacity_activate',
            [
                'label'     => esc_html__('Opacity', 'woncep'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-dots li.slick-active button:before' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'dots_vertical_value',
            [
                'label'     => esc_html__('Spacing', 'woncep'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range'      => [
                    'px' => [
                        'min'  => - 1000,
                        'max'  => 1000,
                        'step' => 1,
                    ],
                    '%'  => [
                        'min' => - 100,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => '',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .slick-dots' => 'bottom: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

	}

	protected function get_carousel_settings() {
		$settings = $this->get_settings_for_display();

		return array(
			'navigation'         => $settings['navigation'],
			'autoplayHoverPause' => $settings['pause_on_hover'] === 'yes' ? true : false,
			'autoplay'           => $settings['autoplay'] === 'yes' ? true : false,
			'autoplayTimeout'    => $settings['autoplay_speed'],
			'items'              => $settings['column'],
			'items_tablet'       => $settings['column_tablet'] ? $settings['column_tablet'] : $settings['column'],
			'items_mobile'       => $settings['column_mobile'] ? $settings['column_mobile'] : 1,
			'loop'               => $settings['infinite'] === 'yes' ? true : false,
		);
	}

	protected function render_carousel_template() {
		?>
        var carousel_settings = {
        navigation: settings.navigation,
        autoplayHoverPause: settings.pause_on_hover === 'yes' ? true : false,
        autoplay: settings.autoplay === 'yes' ? true : false,
        autoplayTimeout: settings.autoplay_speed,
        items: settings.column,
        items_tablet: settings.column_tablet ? settings.column_tablet : settings.column,
        items_mobile: settings.column_mobile ? settings.column_mobile : 1,
        loop: settings.infinite === 'yes' ? true : false,
        };
		<?php
	}
}

$widgets_manager->register_widget_type( new Woncep_Elementor_Widget_Products() );
