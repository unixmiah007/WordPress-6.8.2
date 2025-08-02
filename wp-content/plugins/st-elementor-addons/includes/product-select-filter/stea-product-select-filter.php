<?php
/**
 * Class STEA_Widget\STEA_Product_Select_Filter_Widget
 */
namespace STEA_Widget;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class STEA_Product_Select_Filter_Widget extends Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'stea_product_select_filter';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return __( 'ST product Select Filter', 'st-elementor-addons' );
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-select';
    }

    /**
     * Get widget categories.
     */
    public function get_categories() {
        return [ 'general' ];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        
     }

    /**
     * Render widget output.
     */
    
    // Render Control Start //
    public function render() {
        echo '<div class="stea-product-grid-filter-select">';
        echo '<select id="stea-product-category-filter-select" class="stea-product-category-filter-select">';
        echo '<option value="">' . __( 'All Categories','st-elementor-addons' ) . '</option>';

        // Get all product categories
        $product_categories = get_terms([
            'taxonomy' => 'product_cat',
            'hide_empty' => true,
        ]);

        foreach ($product_categories as $category) {
            // Get the product count for this category
            $product_count = $category->count;

            // Display category name and product count
            echo '<option value="' . esc_attr($category->slug) . '">';
            echo esc_html($category->name) . ' (' . esc_html($product_count) . ')';
            echo '</option>';
        }

        echo '</select>';
        echo '</div>';
    }


}