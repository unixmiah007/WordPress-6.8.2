<div class="stea-wid-main-heading">
    <h2>Widgets</h2> 
</div>

<?php
$stea_widgets_list = [
    [
        'name'         => 'stea-button',
        'label'        => esc_html__('Button', 'st-elementor-addons'),
        'type'         => 'checkbox',
        'default'      => 'on',
        'widget_type'  => 'free',
        'categories'   => ['Essential', 'Forms'], // Multiple categories
        'demo_url'     => '#',
        'video_url'    => '#',
    ],
    [
        'name'         => 'stea-flexbox-slider',
        'label'        => esc_html__('Flexbox Slider', 'st-elementor-addons'),
        'type'         => 'checkbox',
        'default'      => 'on',
        'widget_type'  => 'free',
        'categories'   => ['Creative', 'Advanced'],
        'demo_url'     => '#',
        'video_url'    => '#',
    ],
    [
        'name'         => 'stea-marquee',
        'label'        => esc_html__('Marquee', 'st-elementor-addons'),
        'type'         => 'checkbox',
        'default'      => 'on',
        'widget_type'  => 'free',
        'categories'   => ['Creative', 'Social', 'Advanced'],
        'demo_url'     => '#',
        'video_url'    => '#',
    ],
    [
        'name'         => 'stea-product-grid',
        'label'        => esc_html__('Product Grid', 'st-elementor-addons'),
        'type'         => 'checkbox',
        'default'      => 'on',
        'widget_type'  => 'free',
        'categories'   => ['Woocommerce', 'Social'],
        'demo_url'     => '#',
        'video_url'    => '#',
    ],
    [
        'name'         => 'stea-product-select-filter',
        'label'        => esc_html__('Product Select Filter', 'st-elementor-addons'),
        'type'         => 'checkbox',
        'default'      => 'on',
        'widget_type'  => 'free',
        'categories'   => ['Woocommerce', 'Social'],
        'demo_url'     => '#',
        'video_url'    => '#',
    ],
    [
        'name'         => 'stea-product-checkbox-filter',
        'label'        => esc_html__('Product Checkbox Filter', 'st-elementor-addons'),
        'type'         => 'checkbox',
        'default'      => 'on',
        'widget_type'  => 'free',
        'categories'   => ['Woocommerce', 'Social'],
        'demo_url'     => '#',
        'video_url'    => '#',
    ],
    [
        'name'         => 'stea-add-to-cart',
        'label'        => esc_html__('Add To Cart', 'st-elementor-addons'),
        'type'         => 'checkbox',
        'default'      => 'on',
        'widget_type'  => 'free',
        'categories'   => ['Woocommerce', 'Social'],
        'demo_url'     => '#',
        'video_url'    => '#',
    ],
    [
        'name'         => 'stea-breadcrumb',
        'label'        => esc_html__('WC Breadcrumb', 'st-elementor-addons'),
        'type'         => 'checkbox',
        'default'      => 'on',
        'widget_type'  => 'free',
        'categories'   => ['Woocommerce', 'Social'],
        'demo_url'     => '#',
        'video_url'    => '#',
    ],
    [
        'name'         => 'stea-product-price',
        'label'        => esc_html__('Product Price', 'st-elementor-addons'),
        'type'         => 'checkbox',
        'default'      => 'on',
        'widget_type'  => 'free',
        'categories'   => ['Woocommerce', 'Social'],
        'demo_url'     => '#',
        'video_url'    => '#',
    ],
    [
        'name'         => 'stea-product-data-tab',
        'label'        => esc_html__('Product Data Tab', 'st-elementor-addons'),
        'type'         => 'checkbox',
        'default'      => 'on',
        'widget_type'  => 'free',
        'categories'   => ['Woocommerce', 'Social'],
        'demo_url'     => '#',
        'video_url'    => '#',
    ],
    [
        'name'         => 'stea-page-cart',
        'label'        => esc_html__('Cart', 'st-elementor-addons'),
        'type'         => 'checkbox',
        'default'      => 'on',
        'widget_type'  => 'free',
        'categories'   => ['Woocommerce', 'Social'],
        'demo_url'     => '#',
        'video_url'    => '#',
    ],
    [
        'name'         => 'stea-page-checkout',
        'label'        => esc_html__('Checkout', 'st-elementor-addons'),
        'type'         => 'checkbox',
        'default'      => 'on',
        'widget_type'  => 'free',
        'categories'   => ['Woocommerce', 'Social'],
        'demo_url'     => '#',
        'video_url'    => '#',
    ],
    [
        'name'         => 'stea-nav-menu',
        'label'        => esc_html__('Nav Menu', 'st-elementor-addons'),
        'type'         => 'checkbox',
        'default'      => 'on',
        'widget_type'  => 'free',
        'categories'   => ['Woocommerce', 'Social'],
        'demo_url'     => '#',
        'video_url'    => '#',
    ],
    [
        'name'         => 'stea-post-grid',
        'label'        => esc_html__('Post Grid', 'st-elementor-addons'),
        'type'         => 'checkbox',
        'default'      => 'on',
        'widget_type'  => 'free',
        'categories'   => ['Listing', 'Social'],
        'demo_url'     => '#',
        'video_url'    => '#',
    ],
    [
        'name'         => 'stea-product-rating',
        'label'        => esc_html__('Product Rating', 'st-elementor-addons'),
        'type'         => 'checkbox',
        'default'      => 'on',
        'widget_type'  => 'free',
        'categories'   => ['Woocommerce'],
        'demo_url'     => '#',
        'video_url'    => '#',
    ],
];
?>

<!-- filter Wrap -->
<div class="stea-wid-filter-wrap">
    <div class="search-and-tags-wid-wrap">
       
        <!-- Type Filter (Free/Pro) -->
        <div class="stea-wid-filter-buttons">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="free">Free</button>
            <button class="filter-btn" data-filter="pro">Pro</button>
        </div>
         <!-- Search Box -->
         <div class="stea-wid-search-filter">
            <input type="text" id="stea-widget-search" placeholder="Search widgets..." />
        </div>

    </div>
    <!-- Category Filter Buttons (Supports Multiple Categories) -->
    <div class="stea-category-buttons">
        <button class="stea-wid-category-btn active" data-category="all">All</button>
        <button class="stea-wid-category-btn" data-category="essential">Essential</button>
        <button class="stea-wid-category-btn" data-category="advanced">Advanced</button>
        <button class="stea-wid-category-btn" data-category="creative">Creative</button>
        <button class="stea-wid-category-btn" data-category="listing">Listing</button>
        <button class="stea-wid-category-btn" data-category="social">Social</button>
        <button class="stea-wid-category-btn" data-category="forms">Forms</button>
        <button class="stea-wid-category-btn" data-category="woocommerce">WooCommerce</button>
    </div>

</div>


<!-- Widget List -->
<div class='widgets-wrap'>
    <?php 
    $widget_statuses = get_option('stea_widget_status', []);

    foreach ($stea_widgets_list as $widget) :
        $is_checked = isset($widget_statuses[$widget['name']]) ? $widget_statuses[$widget['name']] : $widget['default'];
        $widget_class = ($widget['widget_type'] === 'pro') ? 'pro-widget' : 'free-widget';
        $widget_categories = array_map('strtolower', $widget['categories']); // Convert categories to lowercase
        $widget_category_classes = implode(' ', array_map(fn($cat) => $cat . '-category', $widget_categories)); // CSS Classes
    ?>
        <div class="stea-wid-mbg-box <?php echo esc_attr($widget_class . ' ' . $widget_category_classes); ?>" 
             data-title="<?php echo strtolower(esc_attr($widget['label'])); ?>" 
             data-type="<?php echo esc_attr($widget['widget_type']); ?>" 
             data-categories="<?php echo implode(',', $widget_categories); ?>">
             
            <span class="badge"><?php echo ($widget['widget_type'] === 'pro') ? 'PRO' : 'Free'; ?></span>
            <div class="content">
                <span class="title"><?php echo esc_html($widget['label']); ?></span>
                <label class="toggle">
                    <input type="checkbox" data-widget="<?php echo esc_attr($widget['name']); ?>" <?php echo ($is_checked === 'on') ? 'checked' : ''; ?>>
                    <span class="slider"></span>
                </label>
            </div>
            <div class="links">
                <a href="<?php echo esc_url($widget['demo_url']); ?>" target="_blank">Live Demo</a> | 
                <a href="<?php echo esc_url($widget['video_url']); ?>" target="_blank">Watch Video</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
