
<header id="masthead" class="site-header header-1" role="banner">
	<div class="header-container">
		<div class="container header-main">
			<div class="header-left">
				<?php
				woncep_site_branding();
				if ( woncep_is_woocommerce_activated() ) {
					?>
					<div class="site-header-cart header-cart-mobile">
						<?php woncep_cart_link(); ?>
					</div>
					<?php
				}
				?>
				<?php woncep_mobile_nav_button(); ?>
			</div>
			<div class="header-center">
				<?php woncep_primary_navigation(); ?>
			</div>
		</div>
	</div>
</header><!-- #masthead -->
