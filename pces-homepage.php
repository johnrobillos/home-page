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
    // Only enqueue on pages that use our shortcodes
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

        // Font Awesome for icons
        wp_enqueue_style(
            'font-awesome',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
            array(),
            '6.4.0'
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
function pces_hero_shortcode($atts) {
    // Content variables - easy to edit
    $company_name = "Philippines Central Engagement Services Inc.";
    $tagline = "Created by Filipinos for the Filipinos";
    $cta_text = "Learn More";
    $cta_link = "#services";
    
    // Build HTML output
    $output = '<section class="pces-hero">';
    $output .= '<div class="container">';
    $output .= '<div class="row align-items-center min-vh-75">';
    $output .= '<div class="col-lg-6">';
    $output .= '<h1 class="hero-title display-4 fw-bold text-white mb-4">' . esc_html($company_name) . '</h1>';
    $output .= '<p class="hero-tagline lead text-white mb-4">' . esc_html($tagline) . '</p>';
    $output .= '<a href="' . esc_url($cta_link) . '" class="btn btn-primary btn-lg">' . esc_html($cta_text) . '</a>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</section>';
    
    return $output;
}
add_shortcode('pces_hero', 'pces_hero_shortcode');

/**
 * Services Section Shortcode
 * Usage: [pces_services]
 */
function pces_services_shortcode($atts) {
    // Services data - easy to edit by modifying this array
    $services = array(
        array(
            'icon' => 'fas fa-users',
            'title' => 'HR Services',
            'description' => 'Comprehensive human resource solutions for your business needs.'
        ),
        array(
            'icon' => 'fas fa-chart-line',
            'title' => 'Business Analytics',    
            'description' => 'Data-driven insights to help your business grow and succeed.'
        ),
        array(
            'icon' => 'fas fa-cogs',
            'title' => 'Process Optimization',
            'description' => 'Streamline your operations for maximum efficiency and productivity.'
        ),
        array(
            'icon' => 'fas fa-handshake',
            'title' => 'Client Relations',
            'description' => 'Build stronger relationships with your customers and partners.'
        ),
        array(
            'icon' => 'fas fa-laptop-code',
            'title' => 'Technology Solutions',
            'description' => 'Modern technology solutions to digitize your business processes.'
        ),
        array(
            'icon' => 'fas fa-graduation-cap',
            'title' => 'Training & Development',
            'description' => 'Professional development programs for your team members.'
        )
    );
    
    // Build HTML output
    $output = '<section class="pces-services py-5" id="services">';
    $output .= '<div class="container">';
    $output .= '<h2 class="text-center mb-5">Services Catered Towards Everyone\'s Needs</h2>';
    $output .= '<div class="row">';
    
    foreach($services as $service) {
        $output .= '<div class="col-md-4 mb-4">';
        $output .= '<div class="service-card text-center h-100 p-4">';
        $output .= '<i class="' . esc_attr($service['icon']) . ' service-icon fa-3x mb-3"></i>';
        $output .= '<h4 class="mb-3">' . esc_html($service['title']) . '</h4>';
        $output .= '<p>' . esc_html($service['description']) . '</p>';
        $output .= '</div>';
        $output .= '</div>';
    }
    
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</section>';
    
    return $output;
}
add_shortcode('pces_services', 'pces_services_shortcode');

/**
 * Differentiators Section Shortcode
 * Usage: [pces_differentiators]
 */
function pces_differentiators_shortcode($atts) {
    // Differentiators data - easy to edit by modifying this array
    $differentiators = array(
        array(
            'icon' => 'fas fa-star',
            'title' => 'Quality Service',
            'description' => 'Top-notch quality in everything we deliver to our clients.'
        ),
        array(
            'icon' => 'fas fa-clock',
            'title' => '24/7 Support',
            'description' => 'Round-the-clock assistance whenever you need us.'
        ),
        array(
            'icon' => 'fas fa-shield-alt',
            'title' => 'Secure Solutions',
            'description' => 'Your data and business information are always protected.'
        ),
        array(
            'icon' => 'fas fa-rocket',
            'title' => 'Fast Delivery',
            'description' => 'Quick turnaround times without compromising quality.'
        ),
        array(
            'icon' => 'fas fa-heart',
            'title' => 'Filipino Values',
            'description' => 'Built on Filipino values of respect, integrity, and excellence.'
        ),
        array(
            'icon' => 'fas fa-trophy',
            'title' => 'Proven Results',
            'description' => 'Track record of successful projects and satisfied clients.'
        )
    );
    
    // Build HTML output
    $output = '<section class="pces-differentiators py-5">';
    $output .= '<div class="container">';
    $output .= '<h2 class="text-center mb-5">What Makes Us Different</h2>';
    $output .= '<div class="row">';
    
    foreach($differentiators as $differentiator) {
        $output .= '<div class="col-md-6 col-lg-4 mb-4">';
        $output .= '<div class="differentiator-card text-center h-100 p-3">';
        $output .= '<i class="' . esc_attr($differentiator['icon']) . ' differentiator-icon fa-2x mb-3"></i>';
        $output .= '<h5 class="mb-3">' . esc_html($differentiator['title']) . '</h5>';
        $output .= '<p class="small">' . esc_html($differentiator['description']) . '</p>';
        $output .= '</div>';
        $output .= '</div>';
    }
    
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</section>';
    
    return $output;
}
add_shortcode('pces_differentiators', 'pces_differentiators_shortcode');

/**
 * Client Logos Section Shortcode
 * Usage: [pces_clients]
 */
function pces_clients_shortcode($atts) {
    // Client logo filenames - easy to edit by modifying this array
    // Just add the filename, the shortcode will handle the full Media Library URL
    $client_logos = array(
        'client-logo-1.png',
        'client-logo-2.png', 
        'client-logo-3.png',
        'client-logo-4.png',
        'client-logo-5.png',
        'client-logo-6.png',
        'client-logo-7.png',
        'client-logo-8.png'
    );
    
    // Build HTML output
    $output = '<section class="pces-clients py-5">';
    $output .= '<div class="container">';
    $output .= '<h2 class="text-center mb-5">Trusted by these Leading Companies</h2>';
    $output .= '<div class="row justify-content-center">';
    
    foreach($client_logos as $logo_filename) {
        // Generate WordPress Media Library URL programmatically
        $logo_url = pces_get_media_url($logo_filename);
        
        if ($logo_url) {
            $output .= '<div class="col-6 col-md-3 mb-4">';
            $output .= '<div class="client-logo-wrapper text-center">';
            $output .= '<img src="' . esc_url($logo_url) . '" alt="Client Logo" class="client-logo img-fluid">';
            $output .= '</div>';
            $output .= '</div>';
        }
    }
    
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</section>';
    
    return $output;
}
add_shortcode('pces_clients', 'pces_clients_shortcode');

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