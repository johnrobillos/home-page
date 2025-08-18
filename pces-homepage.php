<?php
/**
 * Plugin Name: PCES Homepage
 * Description: Custom shortcodes for PCES homepage redesign with Bootstrap and custom styling
 * Version: 1.0
 * Author: PCES Inc.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Enqueue styles and scripts for PCES homepage
 */
function pces_homepage_enqueue_assets() {
    // Always load Bootstrap Icons on frontend
    wp_enqueue_style(
        'bootstrap-icons',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css',
        array(),
        '1.10.0'
    );

    // Only enqueue other assets on pages that use our shortcodes
    global $post;
    if (is_a($post, 'WP_Post') && (
        has_shortcode($post->post_content, 'pces_hero') ||
        has_shortcode($post->post_content, 'pces_services') ||
        has_shortcode($post->post_content, 'pces_differentiators') ||
        has_shortcode($post->post_content, 'pces_clients') ||
        has_shortcode($post->post_content, 'pces_metrics') ||
        has_shortcode($post->post_content, 'pces_news')
    )) {
        
        // Bootstrap CSS (using same version as existing plugin)
        wp_enqueue_style(
            'bootstrap-css',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',
            array(),
            '5.3.0'
        );

        // Custom PCES Homepage CSS
        wp_enqueue_style(
            'pces-homepage-css',
            plugins_url('assets/css/pces-homepage.css', __FILE__),
            array('bootstrap-css'),
            '1.0'
        );

        // Bootstrap JS Bundle (includes Popper)
        wp_enqueue_script(
            'bootstrap-js',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js',
            array('jquery'),
            '5.3.0',
            true
        );

        // Custom PCES Homepage JavaScript (optional)
        wp_enqueue_script(
            'pces-homepage-js',
            plugins_url('assets/js/pces-homepage.js', __FILE__),
            array('jquery'),
            '1.0',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'pces_homepage_enqueue_assets');

/**
 * Hero Section Shortcode
 * Usage: [pces_hero]
 */
add_shortcode('pces_hero', function() {
    ob_start();
    include_once plugin_dir_path(__FILE__) . 'templates/pces_hero_shortcode.php';
    return ob_get_clean();
});

/**
 * Services Section Shortcode
 * Usage: [pces_services]
 */

add_shortcode('pces_services', function() {
    ob_start();
    include_once plugin_dir_path(__FILE__) . 'templates/pces_services_shortcode.php';
    return ob_get_clean();
});

/**
 * Differentiators Section Shortcode
 * Usage: [pces_differentiators]
 */

add_shortcode('pces_differentiators', function() {
    ob_start();
    include_once plugin_dir_path(__FILE__) . 'templates/pces_differentiators_shortcode.php';
    return ob_get_clean();
});

/**
 * Client Logos Section Shortcode
 * Usage: [pces_clients]
 */

add_shortcode('pces_clients', function() {
    ob_start();
    include_once plugin_dir_path(__FILE__) . 'templates/pces_clients_shortcode.php';
    return ob_get_clean();
});

/**
 * Growth Metrics Section Shortcode
 * Usage: [pces_metrics]
 */
function pces_metrics_shortcode($atts) {
    // Chart image filenames - easy to edit by modifying these variables
    // Just add the filename, the shortcode will handle the full Media Library URL
    $pie_chart_filename = 'growth-pie-chart.png';
    $bar_chart_filename = 'growth-bar-chart.png';
    
    // Section content - easy to edit
    $section_title = 'Backed by Measurable Growth';
    $pie_chart_title = 'Revenue Growth';
    $bar_chart_title = 'Client Satisfaction';
    
    // Get chart URLs from Media Library
    $pie_chart_url = pces_get_media_url($pie_chart_filename);
    $bar_chart_url = pces_get_media_url($bar_chart_filename);
    
    // Build HTML output
    $output = '<section class="pces-metrics py-5">';
    $output .= '<div class="container">';
    $output .= '<h2 class="text-center mb-5">' . esc_html($section_title) . '</h2>';
    $output .= '<div class="row justify-content-center">';
    
    // Pie Chart Column
    if ($pie_chart_url) {
        $output .= '<div class="col-md-6 mb-4">';
        $output .= '<div class="metrics-chart text-center">';
        $output .= '<h4 class="mb-3">' . esc_html($pie_chart_title) . '</h4>';
        $output .= '<img src="' . esc_url($pie_chart_url) . '" alt="' . esc_attr($pie_chart_title) . '" class="chart-image img-fluid">';
        $output .= '</div>';
        $output .= '</div>';
    }
    
    // Bar Chart Column
    if ($bar_chart_url) {
        $output .= '<div class="col-md-6 mb-4">';
        $output .= '<div class="metrics-chart text-center">';
        $output .= '<h4 class="mb-3">' . esc_html($bar_chart_title) . '</h4>';
        $output .= '<img src="' . esc_url($bar_chart_url) . '" alt="' . esc_attr($bar_chart_title) . '" class="chart-image img-fluid">';
        $output .= '</div>';
        $output .= '</div>';
    }
    
    // Fallback content if no charts are found
    if (!$pie_chart_url && !$bar_chart_url) {
        $output .= '<div class="col-12">';
        $output .= '<div class="alert alert-info text-center">';
        $output .= '<p class="mb-0">Chart images not found. Please upload "' . esc_html($pie_chart_filename) . '" and "' . esc_html($bar_chart_filename) . '" to the WordPress Media Library.</p>';
        $output .= '</div>';
        $output .= '</div>';
    }
    
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</section>';
    
    return $output;
}
add_shortcode('pces_metrics', 'pces_metrics_shortcode');

/**
 * Helper function to get Media Library URL by filename
 * This function searches the WordPress Media Library for a file by name
 */
function pces_get_media_url($filename) {
    global $wpdb;
    
    // Search for the attachment by filename
    $attachment = $wpdb->get_row($wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'attachment' AND post_title = %s OR guid LIKE %s",
        pathinfo($filename, PATHINFO_FILENAME),
        '%' . $filename
    ));
    
    if ($attachment) {
        return wp_get_attachment_url($attachment->ID);
    }
    
    // Fallback: try to find by searching post_name (slug)
    $attachment = $wpdb->get_row($wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'attachment' AND post_name = %s",
        pathinfo($filename, PATHINFO_FILENAME)
    ));
    
    if ($attachment) {
        return wp_get_attachment_url($attachment->ID);
    }
    
    // If not found, return a placeholder or empty string
    return '';
}

/**
 * Load the reusable header template
 * 
 * @param array $args Optional. Array of header arguments. See pces-header.php for available options.
 * @return void
 */
function pces_load_header($args = array()) {
    $template_path = plugin_dir_path(__FILE__) . 'templates/pces-header.php';
    
    // Check if the template file exists
    if (file_exists($template_path)) {
        // Extract args to make them available in the template
        extract(wp_parse_args($args, array()));
        
        // Start output buffering
        ob_start();
        
        // Include the template file
        include $template_path;
        
        // Get the output and clean the buffer
        $output = ob_get_clean();
        
        // Output the header
        echo $output;
    } else {
        // Fallback if template file is missing
        echo '<!-- Header template not found -->';
    }
}

/**
 * Shortcode to display the header
 * 
 * Usage: [pces_header key1="value1" key2="value2"]
 * 
 * @param array $atts Shortcode attributes.
 * @return string Rendered header HTML.
 */
function pces_header_shortcode($atts) {
    // Parse shortcode attributes
    $args = shortcode_atts(
        array(
            // Logo settings
            'logo_url'      => '',
            'logo_alt'      => get_bloginfo('name'),
            
            // Navigation links (comma-separated list of title|url pairs)
            'nav_links'     => '',
            
            // Colors
            'bg_color'      => '#ffffff',
            'text_color'    => '#333333',
            'hover_color'   => '#F54927',
            
            // CTA Button
            'cta_text'      => 'Get Started',
            'cta_url'       => '#get-started',
            'cta_style'     => 'btn-primary',
        ),
        $atts,
        'pces_header'
    );
    
    // Parse nav_links if provided as a shortcode attribute
    if (!empty($args['nav_links'])) {
        $nav_links = array();
        $links = explode(',', $args['nav_links']);
        
        foreach ($links as $link) {
            $parts = explode('|', trim($link));
            if (count($parts) === 2) {
                $key = sanitize_title($parts[0]);
                $nav_links[$key] = array(
                    'title' => $parts[0],
                    'url'   => $parts[1]
                );
            }
        }
        
        if (!empty($nav_links)) {
            $args['nav_links'] = $nav_links;
        }
    }
    
    // Start output buffering
    ob_start();
    
    // Load the header with the provided arguments
    pces_load_header($args);
    
    // Return the buffered output
    return ob_get_clean();
}
add_shortcode('pces_header', 'pces_header_shortcode');

// Add action to allow other plugins to use our header
do_action('pces_header_loaded');

/**
 * Load the reusable footer template
 *
 * @param array $args Optional. Array of footer arguments. See pces-footer.php for available options.
 * @return void
 */
function pces_load_footer($args = array()) {
    $template_path = plugin_dir_path(__FILE__) . 'templates/pces-footer.php';
    
    // Only load if the template file exists
    if (file_exists($template_path)) {
        // Extract args to make them available in the template
        extract(wp_parse_args($args, array()));
        include $template_path;
    } else {
        // Fallback to a simple footer if template is missing
        echo '<!-- PCES Footer: Template not found -->';
    }
}

/**
 * Shortcode to display the footer
 * 
 * Usage: [pces_footer key1="value1" key2="value2"]
 */
function pces_footer_shortcode($atts) {
    // Start output buffering
    ob_start();
    
    // Default values that match the template
    $defaults = array(
        'logo_url'      => home_url('/wp-content/uploads/icons/services/pces_inc_2025.svg'),
        'company_name'  => get_bloginfo('PCES Inc'),
        'social_links'  => array(
            'facebook'  => array('url' => 'https://www.facebook.com/PCESInc1', 'icon' => 'bi-facebook'),
            'instagram' => array('url' => 'https://www.instagram.com/pces_inc', 'icon' => 'bi-instagram'),
            'tiktok'    => array('url' => 'https://www.tiktok.com/@pces_incorporated', 'icon' => 'bi-tiktok'),
            'youtube'   => array('url' => 'https://www.youtube.com/@pces_inc', 'icon' => 'bi-youtube'),
        ),
        'legal_links'   => array(
            'terms'     => array('url' => '#', 'title' => 'Terms of Use'),
            'privacy'   => array('url' => '#', 'title' => 'Privacy Notice')
        ),
        'bg_color'      => '#0066cc',
        'text_color'    => '#ffffff',
        'accent_color'  => '#004994',
    );
    
    // Parse attributes with our defaults
    $args = shortcode_atts($defaults, $atts);
    
    // Handle social_links and legal_links if passed as JSON strings
    if (isset($atts['social_links']) && is_string($atts['social_links'])) {
        $args['social_links'] = json_decode(wp_unslash($atts['social_links']), true);
    }
    
    if (isset($atts['legal_links']) && is_string($atts['legal_links'])) {
        $args['legal_links'] = json_decode(wp_unslash($atts['legal_links']), true);
    }
    
    // Load the footer with the provided arguments
    pces_load_footer($args);
    
    // Return the buffered content
    return ob_get_clean();
}
add_shortcode('pces_footer', 'pces_footer_shortcode');

// Add action to allow other plugins to use our footer
do_action('pces_footer_loaded');

/**
 * Plugin activation hook
 */
function pces_homepage_activate() {
    // Create assets directories if they don't exist
    $upload_dir = wp_upload_dir();
    $plugin_dir = plugin_dir_path(__FILE__);
    
    // Create CSS directory
    if (!file_exists($plugin_dir . 'assets/css/')) {
        wp_mkdir_p($plugin_dir . 'assets/css/');
    }
    
    // Create JS directory
    if (!file_exists($plugin_dir . 'assets/js/')) {
        wp_mkdir_p($plugin_dir . 'assets/js/');
    }
}
register_activation_hook(__FILE__, 'pces_homepage_activate');

/**
 * Plugin deactivation hook
 */
function pces_homepage_deactivate() {
    // Clean up if needed
}
register_deactivation_hook(__FILE__, 'pces_homepage_deactivate');

?>