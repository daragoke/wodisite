<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	/**
	 * Functions hooked in to woncep_loop_post action.
	 *
	 * @see woncep_post_thumbnail       - 10
	 * @see woncep_post_header          - 15
	 * @see woncep_post_content         - 30
	 */
	do_action( 'woncep_loop_post' );
	?>

</article><!-- #post-## -->

