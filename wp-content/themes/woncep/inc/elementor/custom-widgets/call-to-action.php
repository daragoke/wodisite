<?php

// Call to Action

use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;

add_action('elementor/element/call-to-action/button_style/after_section_end', function ($element, $args) {
	$element->update_control(
		'button_border_width',
		[
			'type' => Controls_Manager::HIDDEN,
		]
	);
}, 10, 2);

add_action('elementor/element/call-to-action/button_style/before_section_end', function ($element, $args) {

	$element->add_control(
		'button_border_width_1',
		[
			'label' =>esc_html__( 'Border Width', 'woncep' ),
			'type' => Controls_Manager::DIMENSIONS,
			'selectors' => [
				'{{WRAPPER}} .elementor-cta__button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'separator' => 'before',
		]
	);

	$element->add_responsive_control(
		'button_text_padding',
		[
			'type'      => \Elementor\Controls_Manager::DIMENSIONS,
			'label'     => esc_html__('Padding', 'woncep'),
			'selectors' => [
				'{{WRAPPER}} .elementor-cta__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);
}, 10, 2);

add_action('elementor/element/call-to-action/section_content_style/before_section_end', function ($element, $args) {

	$element->add_group_control(
		Group_Control_Text_Shadow::get_type(),
		[
			'label'     => esc_html__('Text Shadow Title', 'woncep'),
			'name' => 'text_shadow',
			'selector' => '{{WRAPPER}} .elementor-cta__title',
		]
	);
	$element->add_group_control(
		Group_Control_Text_Shadow::get_type(),
		[
			'label'     => esc_html__('Text Shadow Description', 'woncep'),
			'name' => 'text_shadow_2',
			'selector' => '{{WRAPPER}} .elementor-cta__description',
		]
	);

}, 10, 2);
