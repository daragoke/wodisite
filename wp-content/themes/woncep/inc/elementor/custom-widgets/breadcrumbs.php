<?php

// Breadcrumbs
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

add_action( 'elementor/element/breadcrumbs/section_style/after_section_start', function ($element, $args ) {

	$element->add_group_control(
		Group_Control_Typography::get_type(),
		[
			'name' => 'typography_link',
			'selector' => '{{WRAPPER}} a',
			'label' => esc_html__( 'Link', 'woncep' ),
		]
	);
	$element->add_control(
		'breadcrumb_last_text',
		[
			'label' => esc_html__( 'Color Title', 'woncep' ),
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .breadcrumb_last' => 'color: {{VALUE}};',
			],
		]
	);
	$element->add_control(
		'breadcrumb_last_icon',
		[
			'label' => esc_html__( 'Color Icon', 'woncep' ),
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} i, .breadcrumbs-icon' => 'color: {{VALUE}};',
			],
		]
	);


}, 10, 2 );
