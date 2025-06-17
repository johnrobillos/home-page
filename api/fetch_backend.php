<?php

function fetch_database()
{
    global $wpdb;

    $post_type = isset($_POST['post_type']) ? sanitize_text_field($_POST['post_type']) : '';

    if (!empty($post_type)) {
        // Fetch specific post type (news, testimonial, facebook, instagram, tiktok, etc.)
        $query = $wpdb->prepare("SELECT * FROM `ojtgo_posting` WHERE post_type = %s ORDER by blog_date DESC", $post_type);
    } else {
        // Default: fetch all posts
        $query = "SELECT * FROM `ojtgo_posting` ORDER by blog_date DESC";
    }

    $results = $wpdb->get_results($query, ARRAY_A);
    echo json_encode($results);

    wp_die();
}

add_action('wp_ajax_fetch_database', 'fetch_database');
add_action('wp_ajax_nopriv_fetch_database', 'fetch_database');
