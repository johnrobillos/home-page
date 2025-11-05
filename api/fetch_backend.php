<?php

if (!defined('ABSPATH')) {
    exit;
}

function fetch_database() 
{
    global $wpdb;

    $query = "SELECT * FROM `ojtgo_posting` ORDER BY blog_date DESC";
    $results = $wpdb->get_results($query, ARRAY_A);

    // ✅ Clean backslashes from all strings
    $cleaned_results = stripslashes_deep($results);

    wp_send_json_success($cleaned_results); // ✅ Cleaned output
}

add_action('wp_ajax_fetch_database', 'fetch_database');
add_action('wp_ajax_nopriv_fetch_database', 'fetch_database');
