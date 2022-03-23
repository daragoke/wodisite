<article id="post-<?php the_ID(); ?>" <?php post_class('hentry'); ?>>

	<?php
    woncep_post_thumbnail();
    woncep_post_header();

    ?>

    <div class="entry-content">
        <?php

        /**
         * Functions hooked in to woncep_post_content_before action.
         *
         */
        do_action('woncep_post_content_before');


        the_excerpt();

        /**
         * Functions hooked in to woncep_post_content_after action.
         *
         */
        do_action('woncep_post_content_after');

        ?>
    </div><!-- .entry-content -->
</article><!-- #post-## -->

