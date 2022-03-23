
		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php do_action( 'woncep_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php
		/**
		 * Functions hooked in to woncep_footer action
		 *
		 * @see woncep_footer_default - 20
         * @see woncep_handheld_footer_bar - 25 - woo
		 *
		 */
		do_action( 'woncep_footer' );

		?>

	</footer><!-- #colophon -->

	<?php

		/**
		 * Functions hooked in to woncep_after_footer action
		 * @see woncep_sticky_single_add_to_cart 	- 999 - woo
		 */
		do_action( 'woncep_after_footer' );
	?>

</div><!-- #page -->

<?php

/**
 * Functions hooked in to wp_footer action
 * @see woncep_template_account_dropdown 	- 1
 * @see woncep_mobile_nav - 1
 * @see woncep_render_woocommerce_shop_canvas - 1 - woo
 */

wp_footer();
?>

</body>
</html>
