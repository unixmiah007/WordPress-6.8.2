<div class="stea-wid-main-heading">
    <h2>Extensions</h2> 
</div>

<?php
$stea_widgets_list = [
    [
        'name'         => 'stea-dynamic-tags',
        'label'        => esc_html__('Dynamic Tags', 'st-elementor-addons'),
        'type'         => 'checkbox',
        'default'      => 'on',
        'widget_type'  => 'free',
        'categories'   => ['Creative', 'Social', 'Advanced'],
        'demo_url'     => '#',
        'video_url'    => '#',
    ], [
        'name'         => 'stea-float-effect',
        'label'        => esc_html__('Float Effect', 'st-elementor-addons'),
        'type'         => 'checkbox',
        'default'      => 'on',
        'widget_type'  => 'free',
        'categories'   => ['Creative', 'Advanced'],
        'demo_url'     => '#',
        'video_url'    => '#',
    ], [
        'name'         => 'stea-custom-css',
        'label'        => esc_html__('Custom CSS', 'st-elementor-addons'),
        'type'         => 'checkbox',
        'default'      => 'on',
        'widget_type'  => 'free',
        'categories'   => ['Creative', 'Advanced'],
        'demo_url'     => '#',
        'video_url'    => '#',
    ]
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
            <input type="text" id="stea-widget-search" placeholder="Search Extensions..." />
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
