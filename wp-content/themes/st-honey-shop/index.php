<?php get_header(); ?>

<div id="skip-link-target"  class="mt-5">
    <!-- Main Container -->
    <div class="container st-honey-shop-index-wrap">
        <div class="row">

            <?php
            function st_honey_shop_excerpt_length($st_honey_shop_length) {
                return 20;
            }
            add_filter('excerpt_length', 'st_honey_shop_excerpt_length');
            ?>

            <div class="col-md-8">
                <div class="row">
                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 st-honey-shop-post-card">
                              <?php get_template_part( 'template-parts/content/posts-card' ); ?>
                            </div>
                        </div>
                    <?php endwhile; else: ?>
                        <div class="col-12">
                            <div class="alert alert-warning">
                                <h3><?php esc_html_e( 'Nothing Found!', 'st-honey-shop' ); ?></h3>
                                <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'st-honey-shop' ); ?></p>
                                <div class="ashe-widget widget_search">
                                    <?php get_search_form(); ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                    <!-- Pagination -->
                    <?php the_posts_pagination(); ?>
            </div>

            <!-- Sidebar Area -->
            <div class="col-lg-4 col-md-5 col-sm-12 sidebar-area">
                
                <!-- Post Categories with Count -->
                <?php get_template_part( 'template-parts/sidebar/categories' ); ?>

                <!-- Recent Posts with Thumbnails -->
                <hr>
                <?php get_template_part( 'template-parts/sidebar/post-list' ); ?>

                <!-- Tags -->
                <hr>
                <?php get_template_part( 'template-parts/sidebar/tags' ); ?>

            </div><!-- .sidebar-area -->
        </div>
    </div>
</div>

<?php get_footer(); ?>
