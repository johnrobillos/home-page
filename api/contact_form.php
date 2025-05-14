<?php

if (!defined('ABSPATH')) {
    exit;
}

function handle_contact_form_submission() {
    if (!isset($_POST['name'], $_POST['email'], $_POST['mobile'], $_POST['message'], $_POST['recaptcha_token'])) {
        wp_send_json_error(array('message' => 'Invalid form data.'));
    }

    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $mobile = sanitize_text_field($_POST['mobile']);
    $message = sanitize_textarea_field($_POST['message']);
    $recaptcha_token = $_POST['recaptcha_token'];

    // Verify reCAPTCHA v3 token
    $recaptcha_secret = defined('RECAPTCHA_SECRET_KEY') ? RECAPTCHA_SECRET_KEY : '';
    $response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', array(
        'body' => array(
            'secret'   => $recaptcha_secret,
            'response' => $recaptcha_token
        )
    ));

    if (is_wp_error($response)) {
        wp_send_json_error(array('message' => 'reCAPTCHA request failed.'));
    }

    $response_body = wp_remote_retrieve_body($response);
    $result = json_decode($response_body, true);

    // Check reCAPTCHA response
    if (!$result || !isset($result['success']) || !$result['success'] || $result['score'] < 0.5) {
        wp_send_json_error(array('message' => 'reCAPTCHA verification failed. Please try again.'));
    }

    // Email recipient
    $to = 'info@ojtgo.com';
    $subject = 'New Inquiry from OJTGo Contact Form';
    
    // Email headers
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: OJTGo <no-reply@ojtgo.com>',
        'Reply-To: ' . $email
    );
    
    $home_url = home_url();
    
    // Professional email template
    $email_message = "
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                color: #333;
                background-color: #f4f4f4;
                padding: 20px;
            }
            .container {
                max-width: 600px;
                background: #ffffff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            .header {
                background: #0161aa;
                padding: 15px;
                color: #fff;
                text-align: center;
                font-size: 20px;
                font-weight: bold;
                border-top-left-radius: 8px;
                border-top-right-radius: 8px;
            }
            .content {
                padding: 20px;
            }
            .footer {
                text-align: center;
                font-size: 12px;
                color: #666;
                padding-top: 20px;
                border-top: 1px solid #ddd;
            }
            .label {
                font-weight: bold;
                color: #0161aa;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>New Inquiry from OJTGo</div>
            <div class='content'>
                <p><span class='label'>Name:</span> $name</p>
                <p><span class='label'>Email:</span> $email</p>
                <p><span class='label'>Mobile:</span> $mobile</p>
                <p><span class='label'>Message:</span><br>" . nl2br($message) . "</p>
            </div>
            <div class='footer'>
                <p>OJTGo | PCES Inc.<br>
                <a href='$home_url' style='color:#0161aa; text-decoration: none;'>Visit our Website</a></p>
            </div>
        </div>
    </body>
    </html>";


    if (wp_mail($to, $subject, $email_message, $headers)) {
        wp_send_json_success(array('message' => 'Your message has been sent successfully.'));
    } else {
        wp_send_json_error(array('message' => 'Failed to send message. Please try again.'));
    }
}
add_action('wp_ajax_submit_contact_form', 'handle_contact_form_submission');
add_action('wp_ajax_nopriv_submit_contact_form', 'handle_contact_form_submission');

?>
