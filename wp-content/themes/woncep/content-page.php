<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	/**
	 * Functions hooked in to woncep_page action
	 *
	 * @see woncep_page_header          - 10
	 * @see woncep_page_content         - 20
	 *
	 */
	do_action( 'woncep_page' );
	?>
</article><!-- #post-## -->
