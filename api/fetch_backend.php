<?php

function fetch_database()
{
    global $wpdb;

    // Default: fetch all posts
    $query = "SELECT * FROM `ojtgo_posting` ORDER by blog_date DESC";

    $results = $wpdb->get_results($query, ARRAY_A);
    echo json_encode($results);

    wp_die();
}

add_action('wp_ajax_fetch_database', 'fetch_database');
add_action('wp_ajax_nopriv_fetch_database', 'fetch_database');
