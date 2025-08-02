<div class="widget widget-categories">
                    <h3 class="widget-title font-weight-bold"><?php esc_html_e( 'Categories', 'st-honey-shop' ); ?></h3>
                    <hr>
                    <ul class="list-group">
                        <?php 
                        $st_honey_shop_categories = get_categories( array(
                            'orderby' => 'name',
                            'order'   => 'ASC'
                        ) );

                        foreach( $st_honey_shop_categories as $st_honey_shop_category ) {
                            echo '<li class="list-group-item d-flex justify-content-between align-items-center bg-light mb-2 rounded">';
                            echo '<a href="' . esc_url( get_category_link( $st_honey_shop_category->term_id ) ) . '">' . esc_html( $st_honey_shop_category->name ) . '</a>';
                            echo '<span class="badge badge-primary badge-pill st-honey-shop-cat-badge">' . esc_html( $st_honey_shop_category->count ) . '</span>';
                            echo '</li>';
                        }
                        ?>
                    </ul>
                </div>