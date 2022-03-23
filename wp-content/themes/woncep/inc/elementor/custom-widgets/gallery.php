<?php

use Elementor\Controls_Manager;

add_action( 'elementor/element/gallery/image_style/before_section_end', function ($element, $args ) {

	$element->add_control(
		'style_theme',
		[
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'label' => esc_html__( 'Style Theme', 'woncep' ),
			'prefix_class'	=> 'style-theme-woncep-gallery-'
		]
	);
	$element->add_responsive_control(
		'image_gallery_margin',
		[
			'label'      => esc_html__( 'Margin', 'woncep' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'condition' => [
				'style_theme' => 'yes',
			],
			'selectors'  => [
				'{{WRAPPER}} .elementor-gallery__container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);
	$element->add_responsive_control(
		'image_gallery_margin_even',
		[
			'label'      => esc_html__( 'Margin Even', 'woncep' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'condition' => [
				'style_theme' => 'yes',
			],
			'selectors'  => [
				'{{WRAPPER}} .elementor-gallery__container .elementor-gallery-item:nth-child(even)' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);
	$element->add_responsive_control(
		'image_gallery_margin_odd',
		[
			'label'      => esc_html__( 'Margin Odd', 'woncep' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'condition' => [
				'style_theme' => 'yes',
			],
			'selectors'  => [
				'{{WRAPPER}} .elementor-gallery__container .elementor-gallery-item:nth-child(odd)' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);

},10,2);
