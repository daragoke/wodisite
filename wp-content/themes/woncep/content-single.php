<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	/**
	 * Functions hooked in to woncep_single_post_top action
	 *
	 *  @see woncep_post_header          - 10
	 */
	do_action( 'woncep_single_post_top' );

	/**
	 * Functions hooked in to woncep_single_post action
	 *
	 * @see woncep_post_thumbnail       - 10
	 * @see woncep_post_content         - 30
	 */
	do_action( 'woncep_single_post' );

	/**
	 * Functions hooked in to woncep_single_post_bottom action
	 *
	 * @see woncep_post_taxonomy      - 5
	 * @see woncep_post_nav         	- 10
	 * @see woncep_display_comments 	- 20
	 */
	do_action( 'woncep_single_post_bottom' );
	?>

</article><!-- #post-## -->
