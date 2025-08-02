<?php if ( has_post_thumbnail() ) : ?>
                                    <a href="<?php echo esc_url( get_permalink() ); ?>">
                                        <?php the_post_thumbnail('medium', ['class' => 'card-img-top img-fluid']); ?>
                                    </a>
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
                                    </h5>
                                    <p class="card-text"><?php echo wp_trim_words(get_the_excerpt(), 50, '...'); ?></p>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">
                                        <?php the_time( get_option( 'date_format' ) ); ?> / 
                                        <?php 
                                        comments_popup_link( 
                                            esc_html__( '0 Comments', 'st-honey-shop' ), 
                                            esc_html__( '1 Comment', 'st-honey-shop' ), 
                                            esc_html__( '% Comments', 'st-honey-shop' ), 
                                            'post-comments' 
                                        ); 
                                        ?>
                                    </small>
                                    <a href="<?php echo esc_url( get_permalink() ); ?>" class="btn btn-primary float-right st-read-more-btn">
                                        <?php esc_html_e( 'Read more', 'st-honey-shop' ); ?>
                                    </a>
                                </div>