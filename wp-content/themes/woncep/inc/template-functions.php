<?php
if (!function_exists('woncep_display_comments')) {
    /**
     * Woncep display comments
     *
     * @since  1.0.0
     */
    function woncep_display_comments() {
        // If comments are open or we have at least one comment, load up the comment template.
        if (comments_open() || 0 !== intval(get_comments_number())) :
            comments_template();
        endif;
    }
}

if (!function_exists('woncep_comment')) {
    /**
     * Woncep comment template
     *
     * @param array $comment the comment array.
     * @param array $args the comment args.
     * @param int $depth the comment depth.
     *
     * @since 1.0.0
     */
    function woncep_comment($comment, $args, $depth) {
        if ('div' === $args['style']) {
            $tag       = 'div';
            $add_below = 'comment';
        } else {
            $tag       = 'li';
            $add_below = 'div-comment';
        }
        ?>
        <<?php echo esc_attr($tag) . ' '; ?><?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?> id="comment-<?php comment_ID(); ?>">
        <div class="comment-body">
        <div class="comment-meta commentmetadata">
            <div class="comment-author vcard">
                <?php echo get_avatar($comment, 128); ?>
                <?php printf('<cite class="fn">%s</cite>', get_comment_author_link()); ?>
            </div>
            <?php if ('0' === $comment->comment_approved) : ?>
                <em class="comment-awaiting-moderation"><?php esc_attr_e('Your comment is awaiting moderation.', 'woncep'); ?></em>
                <br/>
            <?php endif; ?>

            <a href="<?php echo esc_url(htmlspecialchars(get_comment_link($comment->comment_ID))); ?>" class="comment-date">
                <?php echo '<time datetime="' . get_comment_date('c') . '">' . get_comment_date() . '</time>'; ?>
            </a>
        </div>
        <?php if ('div' !== $args['style']) : ?>
        <div id="div-comment-<?php comment_ID(); ?>" class="comment-content">
    <?php endif; ?>
        <div class="comment-text">
            <?php comment_text(); ?>
        </div>
        <div class="reply">
            <?php
            comment_reply_link(
                array_merge(
                    $args, array(
                        'add_below' => $add_below,
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth'],
                    )
                )
            );
            ?>
            <?php edit_comment_link(esc_html__('Edit', 'woncep'), '  ', ''); ?>
        </div>
        </div>
        <?php if ('div' !== $args['style']) : ?>
            </div>
        <?php endif; ?>
        <?php
    }
}

if (!function_exists('woncep_footer_widgets')) {
    /**
     * Display the footer widget regions.
     *
     * @return void
     * @since  1.0.0
     */
    function woncep_footer_widgets() {
        $rows    = intval(apply_filters('woncep_footer_widget_rows', 1));
        $regions = intval(apply_filters('woncep_footer_widget_columns', 5));
        for ($row = 1; $row <= $rows; $row++) :

            // Defines the number of active columns in this footer row.
            for ($region = $regions; 0 < $region; $region--) {
                if (is_active_sidebar('footer-' . esc_attr($region + $regions * ($row - 1)))) {
                    $columns = $region;
                    break;
                }
            }

            if (isset($columns)) :
                ?>
                <div class="col-full">
                    <div class=<?php echo '"footer-widgets row-' . esc_attr($row) . ' col-' . esc_attr($columns) . ' fix"'; ?>>
                        <?php
                        for ($column = 1; $column <= $columns; $column++) :
                            $footer_n = $column + $regions * ($row - 1);

                            if (is_active_sidebar('footer-' . esc_attr($footer_n))) :
                                ?>
                                <div class="block footer-widget-<?php echo esc_attr($column); ?>">
                                    <?php dynamic_sidebar('footer-' . esc_attr($footer_n)); ?>
                                </div>
                            <?php
                            endif;
                        endfor;
                        ?>
                    </div><!-- .footer-widgets.row-<?php echo esc_attr($row); ?> -->
                </div>
                <?php
                unset($columns);
            endif;
        endfor;
    }
}

if (!function_exists('woncep_credit')) {
    /**
     * Display the theme credit
     *
     * @return void
     * @since  1.0.0
     */
    function woncep_credit() {
        ?>
        <div class="site-info">
            <?php echo apply_filters('woncep_copyright_text', $content = esc_html__('Copyright', 'woncep') . ' &copy; ' . date('Y') . ' ' . '<a class="site-url" href="' . site_url() . '">' . get_bloginfo('name') . '</a>' . esc_html__('. All Rights Reserved.', 'woncep')); ?>
        </div><!-- .site-info -->
        <?php
    }
}

if (!function_exists('woncep_social')) {
    function woncep_social() {
        $social_list = woncep_get_theme_option('social_text', []);
        if (count($social_list) < 0) {
            return;
        }
        ?>
        <div class="woncep-social">
            <ul>
                <?php

                foreach ($social_list as $social_item) {
                    ?>
                    <li><a href="<?php echo esc_url($social_item); ?>"></a></li>
                    <?php
                }
                ?>

            </ul>
        </div>
        <?php
    }
}

if (!function_exists('woncep_site_welcome')) {
    /**
     * Site branding wrapper and display
     *
     * @return void
     * @since  1.0.0
     */
    function woncep_site_welcome() {
        ?>
        <div class="site-welcome">
            <?php
            echo woncep_get_theme_option('welcome-message', 'Welcome to our online store!');
            ?>
        </div>
        <?php
    }
}

if (!function_exists('woncep_site_branding')) {
    /**
     * Site branding wrapper and display
     *
     * @return void
     * @since  1.0.0
     */
    function woncep_site_branding() {
        ?>
        <div class="site-branding">
            <?php echo woncep_site_title_or_logo(); ?>
        </div>
        <?php
    }
}

if (!function_exists('woncep_site_title_or_logo')) {
    /**
     * Display the site title or logo
     *
     * @param bool $echo Echo the string or return it.
     *
     * @return string
     * @since 2.1.0
     */
    function woncep_site_title_or_logo() {
        ob_start();
        the_custom_logo(); ?>
        <div class="site-branding-text">
            <?php if (is_front_page()) : ?>
                <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                          rel="home"><?php bloginfo('name'); ?></a></h1>
            <?php else : ?>
                <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                         rel="home"><?php bloginfo('name'); ?></a></p>
            <?php endif; ?>

            <?php
            $description = get_bloginfo('description', 'display');

            if ($description || is_customize_preview()) :
                ?>
                <p class="site-description"><?php echo esc_html($description); ?></p>
            <?php endif; ?>
        </div><!-- .site-branding-text -->
        <?php
        $html = ob_get_clean();
        return $html;
    }
}

if (!function_exists('woncep_primary_navigation')) {
    /**
     * Display Primary Navigation
     *
     * @return void
     * @since  1.0.0
     */
    function woncep_primary_navigation() {
        ?>
        <nav class="main-navigation" role="navigation" aria-label="<?php esc_attr_e('Primary Navigation', 'woncep'); ?>">
            <?php
            $args = apply_filters('woncep_nav_menu_args', [
                'fallback_cb'     => '__return_empty_string',
                'theme_location'  => 'primary',
                'container_class' => 'primary-navigation',
            ]);
            wp_nav_menu($args);
            ?>
        </nav>
        <?php
    }
}

if (!function_exists('woncep_mobile_navigation')) {
    /**
     * Display Handheld Navigation
     *
     * @return void
     * @since  1.0.0
     */
    function woncep_mobile_navigation() {
        ?>
        <nav class="mobile-navigation" aria-label="<?php esc_attr_e('Mobile Navigation', 'woncep'); ?>">
            <?php
            wp_nav_menu(
                array(
                    'theme_location'  => 'handheld',
                    'container_class' => 'handheld-navigation',
                )
            );
            ?>
        </nav>
        <?php
    }
}

if (!function_exists('woncep_vertical_navigation')) {
    /**
     * Display Vertical Navigation
     *
     * @return void
     * @since  1.0.0
     */
    function woncep_vertical_navigation() {

        if (isset(get_nav_menu_locations()['vertical'])) {
            $string = get_term(get_nav_menu_locations()['vertical'], 'nav_menu')->name;
            ?>
            <nav class="vertical-navigation" aria-label="<?php esc_attr_e('Vertiacl Navigation', 'woncep'); ?>">
                <div class="vertical-navigation-header">
                    <i class="woncep-icon-bars"></i>
                    <span class="vertical-navigation-title"><?php echo esc_html($string); ?></span>
                </div>
                <?php

                $args = apply_filters('woncep_nav_menu_args', [
                    'fallback_cb'     => '__return_empty_string',
                    'theme_location'  => 'vertical',
                    'container_class' => 'vertical-menu',
                ]);

                wp_nav_menu($args);
                ?>
            </nav>
            <?php
        }
    }
}

if (!function_exists('woncep_homepage_header')) {
    /**
     * Display the page header without the featured image
     *
     * @since 1.0.0
     */
    function woncep_homepage_header() {
        edit_post_link(esc_html__('Edit this section', 'woncep'), '', '', '', 'button woncep-hero__button-edit');
        ?>
        <header class="entry-header">
            <?php
            the_title('<h1 class="entry-title">', '</h1>');
            ?>
        </header><!-- .entry-header -->
        <?php
    }
}

if (!function_exists('woncep_page_header')) {
    /**
     * Display the page header
     *
     * @since 1.0.0
     */
    function woncep_page_header() {

        if (is_front_page() || !is_page_template('default')) {
            return;
        }

        if (woncep_is_elementor_activated() && (function_exists('is_cart') && is_cart() || function_exists('is_checkout') && is_checkout() || function_exists('is_account_page') && is_account_page())) {
            return;
        }
        ?>
        <header class="entry-header">
            <?php
            woncep_post_thumbnail('full');
            the_title('<h1 class="entry-title">', '</h1>');
            ?>
        </header><!-- .entry-header -->
        <?php
    }
}

if (!function_exists('woncep_page_content')) {
    /**
     * Display the post content
     *
     * @since 1.0.0
     */
    function woncep_page_content() {
        ?>
        <div class="entry-content">
            <?php the_content(); ?>
            <?php
            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'woncep'),
                    'after'  => '</div>',
                )
            );
            ?>
        </div><!-- .entry-content -->
        <?php
    }
}

if (!function_exists('woncep_breadcrumb_header')) {
    /**
     * Display the breadcrumb header with a link to the single post
     *
     * @since 1.0.0
     */
    function woncep_get_breadcrumb_header() {
        ob_start();

        if (is_page() || is_single()) {
            the_title('<h1 class="breadcrumb-heading">', '</h1>');
        } elseif (is_archive()) {
            if (woncep_is_woocommerce_activated()) {
                echo '<h1 class="breadcrumb-heading"> ' . woocommerce_page_title(false) . '</h1>';
            } else {
                the_archive_title('<h1 class="breadcrumb-heading">', '</h1>');
            }
        }

        return ob_get_clean();
    }
}

if (!function_exists('woncep_post_header')) {
    /**
     * Display the post header with a link to the single post
     *
     * @since 1.0.0
     */
    function woncep_post_header() {
        ?>
        <header class="entry-header">
            <?php

            /**
             * Functions hooked in to woncep_post_header_before action.
             */
            do_action('woncep_post_header_before');
            ?>

            <?php
            if (is_single()) {

                the_title('<h1 class="entry-title">', '</h1>');
                ?>
                <div class="entry-meta">
                    <?php
                    woncep_categories_link();
                    woncep_post_meta();
                    ?>
                </div>
                <?php

            } else {
                ?>
                <div class="entry-meta">
                    <?php
                    woncep_categories_link();
                    woncep_post_meta();
                    ?>
                </div>
                <?php
                the_title(sprintf('<h2 class="alpha entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>');
            }

            ?>

            <?php

            do_action('woncep_post_header_after');
            ?>
        </header><!-- .entry-header -->
        <?php
    }
}

if (!function_exists('woncep_post_content')) {
    /**
     * Display the post content with a link to the single post
     *
     * @since 1.0.0
     */
    function woncep_post_content() {
        ?>
        <div class="entry-content">
            <?php

            /**
             * Functions hooked in to woncep_post_content_before action.
             *
             */
            do_action('woncep_post_content_before');


            the_content(
                sprintf(
                /* translators: %s: post title */
                    __('Read More %s', 'woncep'),
                    '<span class="screen-reader-text">' . get_the_title() . '</span>'
                )
            );

            /**
             * Functions hooked in to woncep_post_content_after action.
             *
             */
            do_action('woncep_post_content_after');

            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'woncep'),
                    'after'  => '</div>',
                )
            );
            ?>
        </div><!-- .entry-content -->
        <?php
    }
}

if (!function_exists('woncep_post_meta')) {
    /**
     * Display the post meta
     *
     * @since 1.0.0
     */
    function woncep_post_meta() {
        if ('post' !== get_post_type()) {
            return;
        }

        // Posted on.
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date('c')),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date('c')),
            esc_html(get_the_modified_date())
        );

        $posted_on = '<span class="posted-on">' . sprintf('<a href="%1$s" rel="bookmark">%2$s</a>', esc_url(get_permalink()), $time_string) . '</span>';

        // Author.
        $author = sprintf(
            '<span class="post-author">%1$s <a href="%2$s" class="url fn" rel="author">%3$s</a></span>',
            esc_html__('by', 'woncep'),
            esc_url(get_author_posts_url(get_the_author_meta('ID'))),
            esc_html(get_the_author())
        );


        echo wp_kses(
            sprintf('%1$s %2$s', $author, $posted_on), array(
                'span' => array(
                    'class' => array(),
                ),
                'a'    => array(
                    'href'  => array(),
                    'title' => array(),
                    'rel'   => array(),
                ),
                'time' => array(
                    'datetime' => array(),
                    'class'    => array(),
                ),
            )
        );
    }
}

if (!function_exists('woncep_edit_post_link')) {
    /**
     * Display the edit link
     *
     * @since 2.5.0
     */
    function woncep_edit_post_link() {
        edit_post_link(
            sprintf(
                wp_kses(
                /* translators: %s: Name of current post. Only visible to screen readers */
                    __('Edit <span class="screen-reader-text">%s</span>', 'woncep'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            ),
            '<div class="edit-link">',
            '</div>'
        );
    }
}

if (!function_exists('woncep_categories_link')) {
    /**
     * Prints HTML with meta information for the current cateogries
     */
    function woncep_categories_link() {

        // Get Categories for posts.
        $categories_list = get_the_category_list(' ');

        if ('post' === get_post_type() && $categories_list) {
            // Make sure there's more than one category before displaying.
            echo '<span class="categories-link"><span class="screen-reader-text">' . esc_html__('Categories', 'woncep') . '</span>' . $categories_list . '</span>';
        }
    }
}

if (!function_exists('woncep_post_taxonomy')) {
    /**
     * Display the post taxonomies
     *
     * @since 2.4.0
     */
    function woncep_post_taxonomy() {

        /* translators: used between list items, there is a space after the comma */
        $tags_list = get_the_tag_list();
        ?>
        <aside class="entry-taxonomy">
            <?php if ($tags_list) : ?>
                <div class="tags-links">
                    <strong class="screen-reader-text"><?php echo esc_html(_n('Tag:', 'Tags:', count(get_the_tags()), 'woncep')); ?></strong><?php echo get_the_tag_list(); ?>
                </div>
            <?php endif; ?>
        </aside>

        <?php
    }
}

if (!function_exists('woncep_paging_nav')) {
    /**
     * Display navigation to next/previous set of posts when applicable.
     */
    function woncep_paging_nav() {
        global $wp_query;

        $args = array(
            'type'      => 'list',
            'next_text' => _x('Next', 'Next post', 'woncep'),
            'prev_text' => _x('Previous', 'Previous post', 'woncep'),
        );

        the_posts_pagination($args);
    }
}

if (!function_exists('woncep_post_nav')) {
    /**
     * Display navigation to next/previous post when applicable.
     */
    function woncep_post_nav() {

        $prev_post = get_previous_post();
        $next_post = get_next_post();

        $thumb_nail_prev = '';
        $thumb_nail_next = '';

        if ($prev_post) {
            $thumb_nail_prev = get_the_post_thumbnail($prev_post->ID, 'thumbnail');
        };

        if ($next_post) {
            $thumb_nail_next = get_the_post_thumbnail($next_post->ID, 'thumbnail');
        };

        $args = array(
            'next_text' => $thumb_nail_next . '<span><span class="nav-title">' . esc_html__('Next post', 'woncep') . ' </span><span>%title</span></span>',
            'prev_text' => $thumb_nail_prev . '<span><span class="nav-title">' . esc_html__('Previous post', 'woncep') . ' </span><span>%title</span></span>',
        );

        the_post_navigation($args);
    }
}

if (!function_exists('woncep_posted_on')) {
    /**
     * Prints HTML with meta information for the current post-date/time and author.
     *
     * @deprecated 2.4.0
     */
    function woncep_posted_on() {
        _deprecated_function('woncep_posted_on', '2.4.0');
    }
}

if (!function_exists('woncep_homepage_content')) {
    /**
     * Display homepage content
     * Hooked into the `homepage` action in the homepage template
     *
     * @return  void
     * @since  1.0.0
     */
    function woncep_homepage_content() {
        while (have_posts()) {
            the_post();

            get_template_part('content', 'homepage');

        } // end of the loop.
    }
}

if (!function_exists('woncep_social_icons')) {
    /**
     * Display social icons
     * If the subscribe and connect plugin is active, display the icons.
     *
     * @link http://wordpress.org/plugins/subscribe-and-connect/
     * @since 1.0.0
     */
    function woncep_social_icons() {
        if (class_exists('Subscribe_And_Connect')) {
            echo '<div class="subscribe-and-connect-connect">';
            subscribe_and_connect_connect();
            echo '</div>';
        }
    }
}

if (!function_exists('woncep_get_sidebar')) {
    /**
     * Display woncep sidebar
     *
     * @uses get_sidebar()
     * @since 1.0.0
     */
    function woncep_get_sidebar() {
        get_sidebar();
    }
}

if (!function_exists('woncep_post_thumbnail')) {
    /**
     * Display post thumbnail
     *
     * @param string $size the post thumbnail size.
     *
     * @uses has_post_thumbnail()
     * @uses the_post_thumbnail
     * @var $size thumbnail size. thumbnail|medium|large|full|$custom
     * @since 1.5.0
     */
    function woncep_post_thumbnail($size = 'post-thumbnail') {
        if (has_post_thumbnail()) {
            the_post_thumbnail($size ? $size : 'post-thumbnail');
        }
    }
}

if (!function_exists('woncep_primary_navigation_wrapper')) {
    /**
     * The primary navigation wrapper
     */
    function woncep_primary_navigation_wrapper() {
        echo '<div class="woncep-primary-navigation"><div class="col-full">';
    }
}

if (!function_exists('woncep_primary_navigation_wrapper_close')) {
    /**
     * The primary navigation wrapper close
     */
    function woncep_primary_navigation_wrapper_close() {
        echo '</div></div>';
    }
}

if (!function_exists('woncep_header_container')) {
    /**
     * The header container
     */
    function woncep_header_container() {
        echo '<div class="col-full">';
    }
}

if (!function_exists('woncep_header_container_close')) {
    /**
     * The header container close
     */
    function woncep_header_container_close() {
        echo '</div>';
    }
}

if (!function_exists('woncep_header_contact_info')) {
    function woncep_header_contact_info() {
        echo woncep_get_theme_option('contact-info', '');
    }

}

if (!function_exists('woncep_header_account')) {
    function woncep_header_account() {

        if (!woncep_get_theme_option('show-header-account', true)) {
            return;
        }

        if (woncep_is_woocommerce_activated()) {
            $account_link = get_permalink(get_option('woocommerce_myaccount_page_id'));
        } else {
            $account_link = wp_login_url();
        }
        ?>
        <div class="site-header-account">
            <a href="<?php echo esc_url($account_link); ?>"><i class="woncep-icon-user"></i></a>
            <div class="account-dropdown">

            </div>
        </div>
        <?php
    }
}

if (!function_exists('woncep_template_account_dropdown')) {
    function woncep_template_account_dropdown() {
        if (!woncep_get_theme_option('show-header-account', true)) {
            return;
        }
        ?>
        <div class="account-wrap" style="display: none;">
            <div class="account-inner <?php if (is_user_logged_in()): echo "dashboard"; endif; ?>">
                <?php if (!is_user_logged_in()) {
                    woncep_form_login();
                } else {
                    woncep_account_dropdown();
                }
                ?>
            </div>
        </div>
        <?php
    }
}

if (!function_exists('woncep_form_login')) {
    function woncep_form_login() {

        if (woncep_is_woocommerce_activated()) {
            $account_link = get_permalink(get_option('woocommerce_myaccount_page_id'));
        } else {
            $account_link = wp_registration_url();
        }


?>

        <div class="login-form-head">
            <span class="login-form-title"><?php esc_attr_e('Sign in', 'woncep') ?></span>
            <span class="pull-right">
                <a class="register-link" href="<?php echo esc_url($account_link); ?>"
                   title="<?php esc_attr_e('Register', 'woncep'); ?>"><?php esc_attr_e('Create an Account', 'woncep'); ?></a>
            </span>
        </div>
        <form class="woncep-login-form-ajax" data-toggle="validator">
            <p>
                <label><?php esc_attr_e('Username or email', 'woncep'); ?> <span class="required">*</span></label>
                <input name="username" type="text" required placeholder="<?php esc_attr_e('Username', 'woncep') ?>">
            </p>
            <p>
                <label><?php esc_attr_e('Password', 'woncep'); ?> <span class="required">*</span></label>
                <input name="password" type="password" required placeholder="<?php esc_attr_e('Password', 'woncep') ?>">
            </p>
            <button type="submit" data-button-action class="btn btn-primary btn-block w-100 mt-1"><?php esc_html_e('Login', 'woncep') ?></button>
            <input type="hidden" name="action" value="woncep_login">
            <?php wp_nonce_field('ajax-woncep-login-nonce', 'security-login'); ?>
        </form>
        <div class="login-form-bottom">
            <a href="<?php echo wp_lostpassword_url(get_permalink()); ?>" class="lostpass-link" title="<?php esc_attr_e('Lost your password?', 'woncep'); ?>"><?php esc_attr_e('Lost your password?', 'woncep'); ?></a>
        </div>
        <?php
    }
}

if (!function_exists('woncep_account_dropdown')) {
    function woncep_account_dropdown() { ?>
        <?php if (has_nav_menu('my-account')) : ?>
            <nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e('Dashboard', 'woncep'); ?>">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'my-account',
                    'menu_class'     => 'account-links-menu',
                    'depth'          => 1,
                ));
                ?>
            </nav><!-- .social-navigation -->
        <?php else: ?>
            <ul class="account-dashboard">

                <?php if (woncep_is_woocommerce_activated()): ?>
                    <li>
                        <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" title="<?php esc_attr_e('Dashboard', 'woncep'); ?>"><?php esc_html_e('Dashboard', 'woncep'); ?></a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>" title="<?php esc_attr_e('Orders', 'woncep'); ?>"><?php esc_html_e('Orders', 'woncep'); ?></a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url('downloads')); ?>" title="<?php esc_attr_e('Downloads', 'woncep'); ?>"><?php esc_html_e('Downloads', 'woncep'); ?></a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url('edit-address')); ?>" title="<?php esc_attr_e('Edit Address', 'woncep'); ?>"><?php esc_html_e('Edit Address', 'woncep'); ?></a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url('edit-account')); ?>" title="<?php esc_attr_e('Account Details', 'woncep'); ?>"><?php esc_html_e('Account Details', 'woncep'); ?></a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="<?php echo esc_url(get_dashboard_url(get_current_user_id())); ?>" title="<?php esc_attr_e('Dashboard', 'woncep'); ?>"><?php esc_html_e('Dashboard', 'woncep'); ?></a>
                    </li>
                <?php endif; ?>
                <li>
                    <a title="<?php esc_attr_e('Log out', 'woncep'); ?>" class="tips" href="<?php echo esc_url(wp_logout_url(home_url())); ?>"><?php esc_html_e('Log Out', 'woncep'); ?></a>
                </li>
            </ul>
        <?php endif;

    }
}

if (!function_exists('woncep_header_search_popup')) {
    function woncep_header_search_popup() {
        ?>
        <div class="site-search-popup">
            <div class="site-search-popup-wrap">
                <a href="#" class="site-search-popup-close"><i class="woncep-icon-times-circle"></i></a>
                <?php
                if (woncep_is_woocommerce_activated()) {
                    woncep_product_search();
                } else {
                    ?>
                    <div class="site-search">
                        <?php get_search_form(); ?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
    }
}

if (!function_exists('woncep_header_search_button')) {
    function woncep_header_search_button() {
        if (!woncep_get_theme_option('show-header-search', true)) {
            return;
        }

        add_action('wp_footer', 'woncep_header_search_popup', 1);
        wp_enqueue_script('woncep-search-popup');
        ?>
        <div class="site-header-search">
            <a href="#" class="button-search-popup"><i class="woncep-icon-search"></i></a>
        </div>
        <?php
    }
}

if (!function_exists('woncep_mobile_nav')) {
    function woncep_mobile_nav() {
        if (isset(get_nav_menu_locations()['handheld'])) {
            ?>
            <div class="woncep-mobile-nav">
                <a href="#" class="mobile-nav-close"><i class="woncep-icon-times"></i></a>
                <?php
                woncep_language_switcher_mobile();
                woncep_mobile_navigation();
                woncep_social();
                ?>
            </div>
            <div class="woncep-overlay"></div>
            <?php
        }
    }
}

if (!function_exists('woncep_mobile_nav_button')) {
    function woncep_mobile_nav_button() {
        if (isset(get_nav_menu_locations()['handheld'])) {
            wp_enqueue_script('woncep-nav-mobile');
            ?>
            <a href="#" class="menu-mobile-nav-button">
                <span class="toggle-text screen-reader-text"><?php echo esc_attr(apply_filters('woncep_menu_toggle_text', esc_html__('Menu', 'woncep'))); ?></span>
                <i class="woncep-icon-bars"></i>
            </a>
            <?php
        }
    }
}

if (!function_exists('woncep_language_switcher')) {
    function woncep_language_switcher() {
        $languages = apply_filters('wpml_active_languages', []);
        if (!woncep_is_wpml_activated() || count($languages) <= 0) {
            return;
        }
        ?>
        <div class="woncep-language-switcher">
            <ul class="menu">
                <li class="item">
					<span>
						<img width="18" height="12" src="<?php echo esc_url($languages[ICL_LANGUAGE_CODE]['country_flag_url']) ?>" alt="<?php esc_attr($languages[ICL_LANGUAGE_CODE]['default_locale']) ?>">
						<?php
                        echo esc_html($languages[ICL_LANGUAGE_CODE]['translated_name']);
                        ?>
					</span>
                    <ul class="sub-item">
                        <?php
                        foreach ($languages as $key => $language) {
                            if (ICL_LANGUAGE_CODE === $key) {
                                continue;
                            }
                            ?>
                            <li>
                                <a href="<?php echo esc_url($language['url']) ?>">
                                    <img width="18" height="12" src="<?php echo esc_url($language['country_flag_url']) ?>" alt="<?php esc_attr($language['default_locale']) ?>">
                                    <?php echo esc_html($language['translated_name']); ?>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
            </ul>
        </div>
        <?php
    }
}

if (!function_exists('woncep_language_switcher_mobile')) {
    function woncep_language_switcher_mobile() {
        $languages = apply_filters('wpml_active_languages', []);
        if (!woncep_is_wpml_activated() || count($languages) <= 0) {
            return;
        }
        ?>
        <div class="woncep-language-switcher-mobile">
            <span>
                <img width="18" height="12" src="<?php echo esc_url($languages[ICL_LANGUAGE_CODE]['country_flag_url']) ?>" alt="<?php esc_attr($languages[ICL_LANGUAGE_CODE]['default_locale']) ?>">
            </span>
            <?php
            foreach ($languages as $key => $language) {
                if (ICL_LANGUAGE_CODE === $key) {
                    continue;
                }
                ?>
                <a href="<?php echo esc_url($language['url']) ?>">
                    <img width="18" height="12" src="<?php echo esc_url($language['country_flag_url']) ?>" alt="<?php esc_attr($language['default_locale']) ?>">
                </a>
                <?php
            }
            ?>
        </div>
        <?php
    }
}

if (!function_exists('woncep_footer_default')) {
    function woncep_footer_default() {
        get_template_part('template-parts/copyright');
    }
}


if (!function_exists('woncep_social_share')) {
    function woncep_social_share() {
        get_template_part('template-parts/socials');
    }
}

if (!function_exists('woncep_update_comment_fields')) {
    function woncep_update_comment_fields($fields) {

        $commenter = wp_get_current_commenter();
        $req       = get_option('require_name_email');
        $aria_req  = $req ? "aria-required='true'" : '';

        $fields['author']
            = '<p class="comment-form-author">
			<input id="author" name="author" type="text" placeholder="' . esc_attr__("Your Name *", "woncep") . '" value="' . esc_attr($commenter['comment_author']) .
              '" size="30" ' . $aria_req . ' />
		</p>';

        $fields['email']
            = '<p class="comment-form-email">
			<input id="email" name="email" type="email" placeholder="' . esc_attr__("Email Address *", "woncep") . '" value="' . esc_attr($commenter['comment_author_email']) .
              '" size="30" ' . $aria_req . ' />
		</p>';

        $fields['url']
            = '<p class="comment-form-url">
			<input id="url" name="url" type="url"  placeholder="' . esc_attr__("Your Website", "woncep") . '" value="' . esc_attr($commenter['comment_author_url']) .
              '" size="30" />
			</p>';

        return $fields;
    }
}

add_filter('comment_form_default_fields', 'woncep_update_comment_fields');

if (!function_exists('modify_read_more_link')) {
    function modify_read_more_link() {
        return '<p class="more-link-wrap"><a class="more-link" href="' . get_permalink() . '">' . esc_html__('Read More', 'woncep') . '</a></p>';
    }
}

add_filter('the_content_more_link', 'modify_read_more_link');
