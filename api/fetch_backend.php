<?php

function fetch_database() {
    global $wpdb;

    $query = "SELECT * FROM `ojtgo_posting` ORDER BY blog_date DESC";
    $results = $wpdb->get_results($query, ARRAY_A);

    wp_send_json_success($results); // ✅ safer, cleaner
}
add_action('wp_ajax_fetch_database', 'fetch_database');
add_action('wp_ajax_nopriv_fetch_database', 'fetch_database');

