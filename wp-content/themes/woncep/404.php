<?php
get_header(); ?>

    <div id="primary" class="content">

        <main id="main" class="site-main" role="main">

            <div class="error-404 not-found">
				<div class="page-image">
					<img class="image" src="<?php echo get_theme_file_uri('assets/images/404/404.png') ?>" alt="<?php echo esc_attr__('404 Page', 'woncep') ?>">
				</div>
                <div class="page-content">
                    <header class="page-header">
                        <h1 class="page-title"><?php esc_html_e('404', 'woncep'); ?></h1>
                    </header><!-- .page-header -->
                    <div class="error-text">
						<h2><?php esc_html_e("Oops! That page can't be found.", 'woncep') ?></h2>
                        <p><?php esc_html_e("Sorry, but the page you are looking for is not found. Please, make sure you have typed the current URL.", 'woncep') ?></p>
                        <a href="<?php echo esc_url(home_url('/')); ?>"
                           class="button return-home"><?php esc_html_e('Back to Homepage', 'woncep'); ?></a>
                    </div>
                </div><!-- .page-content -->
            </div><!-- .error-404 -->

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
