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
            '5.3.3'
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

        // Enqueue Highcharts dependencies for metrics section
        if (has_shortcode($post->post_content, 'pces_metrics')) {
            // AngularJS
            wp_enqueue_script(
                'angular-js',
                'https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.9/angular.min.js',
                array(),
                '1.6.9',
                true
            );

            // Highcharts
            wp_enqueue_script(
                'highcharts',
                'https://code.highcharts.com/highcharts.js',
                array(),
                '11.0.0',
                true
            );

            // Highcharts Angular directive
            wp_enqueue_script(
                'highcharts-angular',
                'https://code.highcharts.com/highcharts-ng/dist/highcharts-ng.min.js',
                array('angular-js', 'highcharts'),
                '1.0.0',
                true
            );

            // Dashboard charts JavaScript
            wp_enqueue_script(
                'pces-dashboard-charts',
                plugins_url('assets/js/dashboard-charts.js', __FILE__),
                array('angular-js', 'highcharts-angular'),
                '1.0',
                true
            );
        }
    }
}
add_action('wp_enqueue_scripts', 'pces_homepage_enqueue_assets');

/**
 * Hero Section Shortcode
 * Usage: [pces_hero]
 */
add_shortcode('pces_hero', function() {
    ob_start();
    include_once plugin_dir_path(__FILE__) . 'sections/pces_hero_shortcode.php';
    return ob_get_clean();
});

/**
 * Services Section Shortcode
 * Usage: [pces_services]
 */
add_shortcode('pces_services', function() {
    ob_start();
    include_once plugin_dir_path(__FILE__) . 'sections/pces_services_shortcode.php';
    return ob_get_clean();
});

/**
 * Differentiators Section Shortcode
 * Usage: [pces_differentiators]
 */
add_shortcode('pces_differentiators', function() {
    ob_start();
    include_once plugin_dir_path(__FILE__) . 'sections/pces_differentiators_shortcode.php';
    return ob_get_clean();
});

/**
 * Client Logos Section Shortcode
 * Usage: [pces_clients]
 */
add_shortcode('pces_clients', function() {
    ob_start();
    include_once plugin_dir_path(__FILE__) . 'sections/pces_clients_shortcode.php';
    return ob_get_clean();
});

/**
 * Growth Metrics Section Shortcode
 * Usage: [pces_metrics]
 */
add_shortcode('pces_metrics', function() {
    ob_start();
    include_once plugin_dir_path(__FILE__) . 'sections/pces_metrics_shortcode.php';
    return ob_get_clean();
});

/**
 * Helper function to get Media Library URL by filename
 * This function searches the WordPress Media Library for a file by name
 */
function pces_get_media_url($filename) {
    // Sanitize filename
    $filename = sanitize_file_name($filename);
    
    // Try to find by filename in the database
    $args = array(
        'post_type' => 'attachment',
        'posts_per_page' => 1,
        'meta_query' => array(
            array(
                'key' => '_wp_attached_file',
                'value' => $filename,
                'compare' => 'LIKE'
            )
        )
    );
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        $query->the_post();
        return wp_get_attachment_url(get_the_ID());
    }
    
    // If not found, return direct URL to uploads directory as fallback
    $upload_dir = wp_upload_dir();
    $file_url = $upload_dir['baseurl'] . '/' . $filename;
    
    // Verify file exists before returning
    $file_path = $upload_dir['basedir'] . '/' . $filename;
    return file_exists($file_path) ? $file_url : '';
}
/**
 * Load the reusable header template
 * 
 * @param array $args Optional. Array of header arguments. See pces-header.php for available options.
 * @return void
 */
function pces_load_header($args = array()) {
    $template_path = plugin_dir_path(__FILE__) . 'sections/pces-header.php';
    
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
    $template_path = plugin_dir_path(__FILE__) . 'sections/pces-footer.php';
    
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