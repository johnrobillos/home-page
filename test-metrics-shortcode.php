<?php
/**
 * Simple test for the pces_metrics shortcode
 * This file can be used to test the shortcode output
 */

// Mock WordPress functions for testing
if (!function_exists('esc_html')) {
    function esc_html($text) { return htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); }
}
if (!function_exists('esc_url')) {
    function esc_url($url) { return htmlspecialchars($url, ENT_QUOTES, 'UTF-8'); }
}
if (!function_exists('esc_attr')) {
    function esc_attr($text) { return htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); }
}

// Mock the helper function
function pces_get_media_url($filename) {
    // Return placeholder URLs for testing
    if ($filename === 'growth-pie-chart.png') {
        return 'https://via.placeholder.com/400x300/007bff/ffffff?text=Pie+Chart';
    }
    if ($filename === 'growth-bar-chart.png') {
        return 'https://via.placeholder.com/400x300/28a745/ffffff?text=Bar+Chart';
    }
    return '';
}

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

// Test the shortcode
echo "<!DOCTYPE html>\n";
echo "<html><head><title>Metrics Shortcode Test</title></head><body>\n";
echo "<h1>Testing pces_metrics shortcode:</h1>\n";
echo pces_metrics_shortcode(array());
echo "\n</body></html>";
?>