<?php

// Icon List
add_action( 'elementor/element/icon-list/section_text_style/after_section_end', function ( $element, $args ) {
	/** @var \Elementor\Element_Base $element */
	// Remove Schema
	$element->update_control( 'icon_color', [
		'scheme' => [],
	] );

	$element->update_control( 'text_color', [
		'scheme'    => [],
		'selectors' => [
			'{{WRAPPER}} .elementor-icon-list-items .elementor-icon-list-item .elementor-icon-list-text' => 'color: {{VALUE}};',
		],
	] );

	$element->update_control( 'text_color_hover', [
		'scheme'    => [],
		'selectors' => [
			'{{WRAPPER}} .elementor-icon-list-items .elementor-icon-list-item:hover .elementor-icon-list-text' => 'color: {{VALUE}};',
		],
	] );

	$element->update_control( 'icon_typography', [
		'scheme'    => [],
		'selectors' => '{{WRAPPER}} .elementor-icon-list-items .elementor-icon-list-item:hover .elementor-icon-list-text',
	] );

	$element->update_control( 'divider_color', [
		'scheme'  => [],
		'default' => ''
	] );

}, 10, 2 );
