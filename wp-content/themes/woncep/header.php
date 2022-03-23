<!doctype html>
<html <?php language_attributes(); ?> class="<?php echo woncep_get_theme_option( 'site_mode' ) == 'dark' ? esc_attr( 'site-dark' ) : ''; ?>">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="profile" href="//gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php do_action( 'woncep_before_site' ); ?>

<div id="page" class="hfeed site">
	<?php
	/**
	 * Functions hooked in to woncep_before_header action
	 *
	 *
	 */
	do_action( 'woncep_before_header' );

	get_template_part( 'template-parts/header/header', 1 );

	/**
	 * Functions hooked in to woncep_before_content action
	 *
	 *
	 */
	do_action( 'woncep_before_content' );
	?>

	<div id="content" class="site-content" tabindex="-1">
		<div class="col-full">

<?php
/**
 * Functions hooked in to woncep_content_top action
 *
 * @see woncep_shop_messages - 10 - woo
 */
do_action( 'woncep_content_top' );
