<?php get_header(); ?>

<!-- Main Container -->
<div id="skip-link-target" class="container-fluid container st-honey-shop-single-wrap mt-5">
    <div class="row">
        <!-- Content Area -->
        <div class="col-lg-8 col-md-7 col-sm-12 content-area">
            <article id="post-<?php the_ID(); ?>" <?php post_class('st-honey-shop-post'); ?>>

            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>   

                <div class="post-media">
                    <?php the_post_thumbnail('full', ['class' => 'img-fluid']); ?>
                </div>

                <header class="post-header">

                    <h1 class="post-title"><?php the_title(); ?></h1>

                    <?php echo '<div class="post-categories">' . get_the_category_list( ',&nbsp;&nbsp;' ) . ' </div>'; ?>

                    <div class="post-meta">

                        <span class="post-date"><?php the_time( get_option( 'date_format' ) ); ?></span>
                        
                        <span class="meta-sep">/</span>
                        
                        <?php comments_popup_link( esc_html__( '0 Comments', 'st-honey-shop' ), esc_html__( '1 Comment', 'st-honey-shop' ), '% '. esc_html__( 'Comments', 'st-honey-shop' ), 'post-comments'); ?>

                    </div>

                </header>

                <div class="post-content">
                    <?php
                    the_content('');
                    $st_honey_shop_defaults = array(
                        'before' => '<p class="single-pagination">'. esc_html__( 'Pages:', 'st-honey-shop' ),
                        'after' => '</p>'
                    );
                    wp_link_pages( $st_honey_shop_defaults );
                    ?>
                </div>

                <footer class="post-footer">
                    <?php 
                    $st_honey_shop_tag_list = get_the_tag_list( '<div class="post-tags">','','</div>');
                    if ( $st_honey_shop_tag_list ) {
                        echo ''. $st_honey_shop_tag_list;
                    }
                    ?>
                    <span class="post-author"><?php esc_html_e( 'By', 'st-honey-shop' ); ?>&nbsp;<?php the_author_posts_link(); ?></span>
                </footer>

            </article>

            <?php
            endwhile;
            endif;

            if ( comments_open() || get_comments_number() ) {
                echo '<div class="comments-area" id="comments">';
                    comments_template( '', true );
                echo '</div>';
            }
            ?>
        </div><!-- .content-area -->

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
          
        </div>
    </div>
</div>

<?php get_footer(); ?>
