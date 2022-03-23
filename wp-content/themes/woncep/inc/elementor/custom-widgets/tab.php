<?php

// tabs
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

add_action('elementor/element/tabs/section_tabs_style/after_section_end', function ($element, $args) {
	$element->update_control(
		'background_color',
		[
			'selectors' => [
				'{{WRAPPER}} .elementor-tabs-wrapper' => 'background-color: {{VALUE}};',
			],
		]
	);
	$element->update_control(
		'heading_title',
		[
			'type' => Controls_Manager::HIDDEN,
		]
	);
	$element->update_control(
		'tab_color',
		[
			'type'   => Controls_Manager::HIDDEN,
			'global' => [
				'default' => ''
			]
		]
	);
	$element->update_control(
		'tab_active_color',
		[
			'type'   => Controls_Manager::HIDDEN,
			'global' => [
				'default' => ''
			]
		]
	);
//	$element->update_control(
//		'border_width',
//		[
//			'default' => ''
//		]
//	);
	$element->update_control(
		'content_color',
		[
			'global' => [
				'default' => ''
			]
		]
	);

}, 10, 2);

add_action('elementor/element/tabs/section_tabs_style/before_section_end', function ($element, $args) {
	$element->add_responsive_control(
		'content_padding',
		[
			'type'      => \Elementor\Controls_Manager::DIMENSIONS,
			'label'     => esc_html__('Padding Content', 'woncep'),
			'selectors' => [
				'{{WRAPPER}} .elementor-tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);
	$element->add_control(
		'heading_title_update',
		[
			'label'     =>esc_html__('Title', 'woncep'),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		]
	);

	$element->add_responsive_control(
		'align',
		[
			'label' =>esc_html__( 'Alignment', 'woncep' ),
			'type' => Controls_Manager::CHOOSE,
			'options' => [
				'left'    => [
					'title' =>esc_html__( 'Left', 'woncep' ),
					'icon' => 'eicon-text-align-left',
				],
				'center' => [
					'title' =>esc_html__( 'Center', 'woncep' ),
					'icon' => 'eicon-text-align-center',
				],
				'right' => [
					'title' =>esc_html__( 'Right', 'woncep' ),
					'icon' => 'eicon-text-align-right',
				],
			],
			'condition' => [
				'tabs_style_theme' => 'yes',
			],
			'prefix_class' => 'tabs-style-woncep-align%s-',
			'default' => '',
		]
	);

	$element->start_controls_tabs( 'tabs_title_style' );
	$element->start_controls_tab(
		'tab_title_normal',
		[
			'label' =>esc_html__( 'Normal', 'woncep' ),
		]
	);

	$element->add_control(
		'background_color_title',
		[
			'label'     =>esc_html__('Background Color', 'woncep'),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .elementor-tab-title' => 'background-color: {{VALUE}};',
			],
		]
	);
	$element->add_control(
		'title_tab_color',
		[
			'label'     =>esc_html__('Title Color', 'woncep'),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .elementor-tab-title, {{WRAPPER}} .elementor-tab-title a' => 'color: {{VALUE}};',
			],
		]
	);
	$element->add_control(
		'border_title_tab_color',
		[
			'label'     =>esc_html__('Border Color', 'woncep'),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .elementor-tab-title' => 'border-color: {{VALUE}};',
			],
		]
	);

	$element->end_controls_tab();
	$element->start_controls_tab(
		'tab_title_hover',
		[
			'label' =>esc_html__( 'Hover', 'woncep' ),
		]
	);

	$element->add_control(
		'background_color_title_hover',
		[
			'label'     =>esc_html__('Background Color', 'woncep'),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .elementor-tab-title:hover' => 'background-color: {{VALUE}};',
			],
		]
	);
	$element->add_control(
		'title_tab_color_hover',
		[
			'label'     =>esc_html__('Title Color', 'woncep'),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .elementor-tab-title:hover, {{WRAPPER}} .elementor-tab-title a:hover' => 'color: {{VALUE}};',
			],
		]
	);
	$element->add_control(
		'border_title_tab_color_hover',
		[
			'label'     =>esc_html__('Border Color', 'woncep'),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .elementor-tab-title:hover' => 'border-color: {{VALUE}};',
			],
		]
	);

	$element->end_controls_tab();
	$element->start_controls_tab(
		'tab_title_active',
		[
			'label' =>esc_html__( 'Active', 'woncep' ),
		]
	);
	$element->add_control(
		'background_color_title_active',
		[
			'label'     =>esc_html__('Background Color', 'woncep'),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .elementor-tab-title.elementor-active' => 'background-color: {{VALUE}};',
			],
		]
	);
	$element->add_control(
		'title_tab_active_color',
		[
			'label'     =>esc_html__('Title Color', 'woncep'),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .elementor-tab-title.elementor-active a' => 'color: {{VALUE}};',
			],
		]
	);
	$element->add_control(
		'border_title_tab_active_color',
		[
			'label'     =>esc_html__('Border Color', 'woncep'),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .elementor-tab-title.elementor-active' => 'border-color: {{VALUE}};',
			],
		]
	);
	$element->end_controls_tab();
	$element->end_controls_tabs();

	$element->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		[
			'name' => 'tab_title_shadow',
			'selector' => '{{WRAPPER}} .elementor-tab-title',
			'condition' => [
				'tabs_style_theme' => 'yes',
			],
		]
	);

	$element->add_group_control(
		Group_Control_Border::get_type(),
		[
			'name' => 'border_title',
			'selector' => '{{WRAPPER}} .elementor-tab-title',
		]
	);

	$element->add_control(
		'title_tab_radius',
		[
			'label' => esc_html__('Border Radius', 'woncep'),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => ['px', '%'],
			'selectors' => [
				'{{WRAPPER}} .elementor-tab-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);

	$element->add_responsive_control(
		'title_padding',
		[
			'type'      => \Elementor\Controls_Manager::DIMENSIONS,
			'label'     => esc_html__('Padding Title', 'woncep'),
			'selectors' => [
				'{{WRAPPER}} .elementor-tab-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);

	$element->add_responsive_control(
		'title_margin',
		[
			'type'      => \Elementor\Controls_Manager::DIMENSIONS,
			'label'     => esc_html__('Margin Title', 'woncep'),
			'selectors' => [
				'{{WRAPPER}} .elementor-tab-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'condition' => [
				'tabs_style_theme' => 'yes',
			],
		]
	);

}, 10, 2);

add_action('elementor/element/tabs/section_tabs/before_section_end', function ($element, $args) {
	$element->add_control(
		'tabs_style_theme',
		[
			'label'        => esc_html__('Theme Style', 'woncep'),
			'type'         => Controls_Manager::SWITCHER,
			'default'      => '',
			'condition' => [
				'type' => 'horizontal',
			],
			'prefix_class' => 'tabs-style-woncep-',
		]
	);

}, 10, 2);
