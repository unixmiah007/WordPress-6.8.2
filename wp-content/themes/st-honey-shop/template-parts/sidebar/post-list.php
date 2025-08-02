<div class="widget widget-recent-posts">
                    <h3 class="widget-title font-weight-bold"><?php esc_html_e( 'Recent Posts', 'st-honey-shop' ); ?></h3>
                    <hr>
                    <ul class="list-unstyled">
                        <?php
                        $st_honey_shop_recent_posts = wp_get_recent_posts( array(
                            'numberposts' => 5,
                            'post_status' => 'publish'
                        ) );

                        foreach( $st_honey_shop_recent_posts as $st_honey_shop_post_item ) : ?>
                            <li class="media mb-3">
                                <a class="w-25" href="<?php echo esc_url( get_permalink($st_honey_shop_post_item['ID']) ); ?>">
                                    <?php echo get_the_post_thumbnail( $st_honey_shop_post_item['ID'], 'thumbnail', ['class' => 'mr-3 rounded'] ); ?>
                                </a>
                                <div class="media-body">
                                    <h5 class="mt-0 mb-1">
                                        <a href="<?php echo esc_url( get_permalink($st_honey_shop_post_item['ID']) ); ?>">
                                            <?php echo esc_html( $st_honey_shop_post_item['post_title'] ); ?>
                                        </a>
                                    </h5>
                                </div>
                            </li>
                        <?php endforeach; ?>

                        <?php // Removed wp_reset_query(); as it is not needed ?>
                    </ul>
                </div>