<div class="column-item post-style-3">
    <div class="post-inner">

            <div class="post-thumbnail">
                <a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail() && '' !== get_the_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('woncep-post-grid'); ?>
                    <?php endif; ?>
                </a>
            </div><!-- .post-thumbnail -->


        <div class="entry-content">
            <div class="entry-header">
                <?php
                the_title(sprintf('<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h3>');

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

                echo '<span class="posted-on">' . sprintf('<a href="%1$s" rel="bookmark">%2$s</a>', esc_url(get_permalink()), $time_string) . '</span>';
                ?>
            </div>
        </div>
    </div>
</div>
