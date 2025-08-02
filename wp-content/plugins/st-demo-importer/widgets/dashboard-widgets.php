<?php
// Register Blog Widget
function stdi_add_blog_post_widget() {
    wp_add_dashboard_widget(
        'stdi_blog_post_widget',
        'STDI Blog Post',
        'stdi_blog_post_widget_display'
    );
}
add_action('wp_dashboard_setup', 'stdi_add_blog_post_widget');
// Get Post Data From Server
function stdi_get_latest_blogs_from_api() {
    $response = wp_remote_get(STDI_ADMIN_CUSTOM_ENDPOINT . 'get_latest_blogs');

    if (is_wp_error($response)) {
        return array('code' => 500, 'data' => array(), 'error' => $response->get_error_message());
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['code']) && $data['code'] == 100) {
        return array('code' => 100, 'data' => $data['data']);
    } else {
        return array('code' => 500, 'data' => array(), 'error' => 'Unexpected API response');
    }
}
// Post Html
function stdi_blog_post_widget_display() {
    $response = stdi_get_latest_blogs_from_api();

    if ($response['code'] == 100 && !empty($response['data'])) { ?>
        <ul>
            <?php foreach ($response['data'] as $post) : ?>
                <li>
                    <a href="<?php echo esc_url($post['post_permalink']); ?>" target="_blank">
                        <?php echo esc_html($post['post_title']); ?>
                    </a>
                    <p><?php echo esc_html($post['post_content']); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php } else { ?>
        <p>No recent posts available.</p>
    <?php }
}

// Added Bundle Promotion At Dashboard Welcome Page admin
function stdi_add_bundle_promotion_widget() {
    wp_add_dashboard_widget(
        'stdi_bundle_promotion_widget',
        'WP Theme Bundle',
        'stdi_bundle_promotion_widget_display'
    );
}
add_action('wp_dashboard_setup', 'stdi_add_bundle_promotion_widget');

function stdi_bundle_promotion_widget_display() {
    ?>
    <div class="stdi-image-wrap">
        <a href="https://striviothemes.com/product/wordpress-theme-bundle/" target="_blank" rel="noopener noreferrer">
            <img src="<?php echo esc_url(STDI_URL . 'widgets/assets/img/bundle-sec-img-at-glance.webp'); ?>" alt="WordPress Theme Bundle">
        </a>
    </div>
    <canvas id="stdi-notice-confetti"></canvas>
    <?php
}

// Added Promotional Banner //
add_action( 'admin_notices', 'stdi_render_plugin_update_notice');

function stdi_hide_theme_notice() {
    wp_enqueue_script(
        'plugin-notice-js',
        STDI_URL . 'widgets/assets/js/plugin-update-notice.js',
        [
            'jquery'
        ]
    );
}
add_action( 'admin_enqueue_scripts', 'stdi_hide_theme_notice' );

add_action( 'admin_head', 'stdi_enqueue_scripts' );
function stdi_render_plugin_update_notice() {
    echo '<div class="notice stdi-plugin-update-notice is-dismissible">
                        
                        <div>
                            <h3><span>Premium Elementor Bundle</span><br> WP Theme Bundle – Access all themes for only $79</h3>
                            <p>Grab all our premium themes now for just $79! Elevate your website with our<br>Ultimate WordPress Theme Bundle – the ideal solution for all your design needs!</p>
                            <a class="stdi-buy-now" href="https://striviothemes.com/product/wordpress-theme-bundle/">Get Your Bundle Deal!</a>
                        </div>
                        <div class="stdi-image-wrap"><img src="'. esc_url(STDI_URL) .'widgets/assets/img/bundle-sec-img.webp"></div>
                        <canvas id="stdi-notice-confetti"></canvas>
                </div>';
}

function stdi_enqueue_scripts() {
    // Load Confetti
    wp_enqueue_script( 'stdi-confetti-js', STDI_URL .'widgets/assets/js/confetti/confetti.min.js', ['jquery'] );

    // Scripts & Styles
    echo "
    <style>
        .stdi-buy-now {
            text-decoration: none;
            background: #4CAF50 !important;
            color: white;
            padding: 10px 20px;
            border: solid 1px #4CAF50 !important;
            border-radius: 5px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            font-weight: bold;
        }
        
        .stdi-buy-now:hover{
            color: #ffff;
            background: #3b883d !important;
        }

        .stdi-buy-now::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to right,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.5) 50%,
                rgba(255, 255, 255, 0) 100%
        );
        border-radius: 50%;
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }
            100% {
                transform: translateX(100%);
            }
        }

        .stdi-plugin-update-notice {
            position: relative;
            display: flex;
            align-items: center;
            margin-top: 20px;
            margin-bottom: 20px;
            padding: 30px;
            border: 0 !important;
            box-shadow: 0 0 5px rgb(0 0 0 / 0.1);
        }

        .stdi-plugin-update-notice h3 {
            font-size: 36px;
            margin-top: 0;
            margin-bottom: 20px;
        }

        .stdi-plugin-update-notice h3 span {
          display: inline-block;
          margin-bottom: 20px;
          font-size: 12px;
          color: #fff;
          background-color: #f51f3d;
          padding: 2px 12px 4px;
          border-radius: 3px;
        }

        .stdi-plugin-update-notice p {
          margin-top: 10px;
          margin-bottom: 30px;
          font-size: 14px;
        }
        
        .stdi-plugin-update-notice .stdi-image-wrap {
          margin-left: auto;
        }

        .stdi-plugin-update-notice .stdi-image-wrap img {
          zoom: 0.45;
        }

        @media screen and (max-width: 1366px) {
            .stdi-plugin-update-notice h3 {
                font-size: 32px;
            }

            .stdi-plugin-update-notice .stdi-image-wrap img {
              zoom: 0.4;
            }
        }

        @media screen and (max-width: 1280px) {
            .stdi-plugin-update-notice .stdi-image-wrap img {
              zoom: 0.35;
            }
        }

        #stdi-notice-confetti {
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          pointer-events: none;
        }
    </style>";

    
}