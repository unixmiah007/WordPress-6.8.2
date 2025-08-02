<div class="product-item">
	<!-- whishlist -->
	<?php
	$user_id = get_current_user_id();
	$wishlist = get_user_meta($user_id, 'stea_wishlist', true);
	$wishlist = is_array($wishlist) ? $wishlist : [];
	$is_in_wishlist = in_array($product->get_id(), $wishlist);
	?>

	<div class="add-to-wishlist-btn-wrap">
		<button class="stea-add-to-wishlist <?php echo $is_in_wishlist ? 'added' : ''; ?>" 
				data-product-id="<?php echo esc_attr($product->get_id()); ?>">
			<i class="fa <?php echo $is_in_wishlist ? 'fa-heart' : 'fa-heart-o'; ?>"></i>
		</button>
	</div>
	<div class="stea-product-grid-product-image">
		<a href="<?php the_permalink(); ?>">
			<?php if ( has_post_thumbnail() ) {
				the_post_thumbnail();
			} ?>
		</a>
	</div>
	
	<p class="stea-product-grid-product-price">
		<?php echo $product->get_price_html(); ?>
	</p>

	<div class="stea-product-grid-product-rating">
		<?php 
		if ( function_exists( 'wc_get_star_rating_html' ) ) {
			global $product;
			if ( $product ) {
				$rating = $product->get_average_rating(); 
				$count  = $product->get_review_count();  
				for ( $i = 1; $i <= 5; $i++ ) {
					if ( $i <= $rating ) {
						echo '<i class="fa fa-star" style="color: var(--stea-product-grid-regular-star-color-to-show , #ffcc00);"></i>';
					} elseif ( $i - $rating < 1 ) {
						echo '<i class="fa fa-star-half-alt" style="color: var(--stea-product-grid-regular-star-color-to-show , #ffcc00);"></i>';
					} else {
						echo '<i class="fa fa-star-o" style="color: var(--stea-product-grid-regular-empty-star-color-to-show, #ffcc00);"></i>';

					}
				}
			}
		}
		?>
	</div>
	<!-- <div class='stea-product-grid-title-btn-wrap'> -->
		<h5 class="stea-product-grid-product-title">
			<a href="<?php echo esc_url( get_permalink() ); ?>">
				<span><?php echo esc_html( get_the_title() ); ?></span>
			</a>
		</h5>

		<div class="add-to-cart-btn-wrap">
			<?php
			$icon_html = '';

			// Handle icon: SVG or font class
			if (
				isset( $button_add_to_cart_icon['value'] ) &&
				is_array( $button_add_to_cart_icon['value'] ) &&
				isset( $button_add_to_cart_icon['value']['url'] )
			) {
				if ( isset( $button_add_to_cart_icon['library'] ) && $button_add_to_cart_icon['library'] === 'svg' ) {
					$icon_html = '<img src="' . esc_url( $button_add_to_cart_icon['value']['url'] ) . '" alt="' . esc_attr( $add_to_cart_btn_text ) . '" class="stea-icon-svg" />';
				}
			} elseif ( isset( $button_add_to_cart_icon['value'] ) && ! empty( $button_add_to_cart_icon['value'] ) ) {
				$icon_html = '<i class="' . esc_attr( $button_add_to_cart_icon['value'] ) . '"></i>';
			}

			// Set button text
			$button_add_to_cart_title2 = $product->is_type( 'simple' )
				? ( ! empty( $add_to_cart_btn_text ) ? esc_html( $add_to_cart_btn_text ) : esc_html__( 'Add to Cart', 'st-elementor-addons' ) )
				: esc_html( $product->add_to_cart_text() );

			$product_id    = $product->get_id();
			$product_url   = $product->is_type( 'variable' ) ? get_permalink( $product_id ) : $product->add_to_cart_url();
			$product_class = $product->is_type( 'variable' )
				? 'button stea-product-grid-add-to-cart-btn'
				: 'button stea-product-grid-add-to-cart-btn add-to-cart-ajax';

			echo '<a href="' . esc_url( $product_url ) . '" 
						data-product_id="' . esc_attr( $product_id ) . '" 
						class="' . esc_attr( $product_class ) . '">' .
						$icon_html . '<span>' . $button_add_to_cart_title2 . '</span>' .
				'</a>';
			?>
		</div>


	<!-- </div> -->
</div>