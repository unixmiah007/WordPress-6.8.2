<div class="widget widget-tags">
                    <h3 class="widget-title font-weight-bold"><?php esc_html_e( 'Tags', 'st-honey-shop' ); ?></h3>
                    <hr>
                    <div class="tagcloud">
                        <ul class="list-inline">
                            <?php
                            $st_honey_shop_tags = get_tags();
                            foreach ( $st_honey_shop_tags as $st_honey_shop_tag ) {
                                echo '<li class="list-inline-item mt-2"><a href="' . esc_url( get_tag_link($st_honey_shop_tag->term_id) ) . '" class="btn btn-outline-primary st-read-more-btn btn-sm st-tags-btn">' . esc_html( $st_honey_shop_tag->name ) . '</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>