<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <header class="page-title">
        <?php
        if (is_single()) :
            the_title(sprintf('<h1 class="entry-title"><a href="%s">', esc_url(twentyfifteen_get_link_url())), '</a></h1>');
        else :
            the_title(sprintf('<h2 class="entry-title"><a href="%s">', esc_url(twentyfifteen_get_link_url())), '</a></h2>');
        endif;
        ?>
    </header>
    <!-- .entry-header -->

    <div class="entry-content">
        <?php
        /* translators: %s: Name of current post */
        the_content(sprintf(
            esc_html__('Continue reading %s', 'organ'),
            the_title('<span class="screen-reader-text">', '</span>', false)
        ));

        wp_link_pages(array(
            'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__('Pages:', 'organ') . '</span>',
            'after' => '</div>',
            'link_before' => '<span>',
            'link_after' => '</span>',
            'pagelink' => '<span class="screen-reader-text">' . esc_html__('Page', 'organ') . ' </span>%',
            'separator' => '<span class="screen-reader-text">, </span>',
        ));
        ?>
    </div>
    <!-- .entry-content -->

    <?php
    // Author bio.
    if (is_single() && get_the_author_meta('description')) :
        get_template_part('author-bio');
    endif;
    ?>

    <footer class="entry-footer">

        <?php edit_post_link(esc_html__('Edit','organ'), '<span class="edit-link">', '</span>'); ?>
    </footer>
    <!-- .entry-footer -->

</article><!-- #post-## -->
