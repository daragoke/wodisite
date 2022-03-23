<?php
//Accordion
add_action( 'elementor/element/accordion/section_title_style/before_section_end', function ( $element, $args ) {

	$element->add_control(
		'style_theme',
		[
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'label' => esc_html__( 'Style Theme', 'woncep' ),
			'prefix_class'	=> 'style-theme-woncep-'
		]
	);

},10,2);
