<?php
/**
 * PCES Reusable Footer Template
 * 
 * @package PCES_Homepage
 * @since 1.0.0
 * 
 * @param array $args {
 *     Optional. Array of footer arguments.
 *     @type string $logo_url       URL of the logo image.
 *     @type string $company_name   Company name for copyright text.
 *     @type array  $menu_items     Array of menu items with 'title' and 'url'.
 *     @type array  $social_links   Array of social media links with 'icon' and 'url'.
 *     @type string $bg_color       Background color (CSS color value).
 *     @type string $text_color     Text color (CSS color value).
 *     @type string $accent_color   Accent color for links and buttons.
 * }
 */

// Default values
$defaults = array(
    'logo_url'      => '',
    'company_name'  => get_bloginfo('name'),
    'menu_items'    => array(),
    'social_links'  => array(
        'facebook'  => array('url' => '#', 'icon' => 'bi-facebook'),
        'tiktok'   => array('url' => '#', 'icon' => 'bi-tiktok'),
        'youtube'  => array('url' => '#', 'icon' => 'bi-youtube'),
    ),
    'bg_color'      => '#f8f9fa',
    'text_color'    => '#212529',
    'accent_color'  => '#0073aa',
);

$args = wp_parse_args($args, $defaults);
?>

<footer class="pces-footer py-5" style="background-color: <?php echo esc_attr($args['bg_color']); ?>; color: <?php echo esc_attr($args['text_color']); ?>;">
    <div class="container">
        <div class="row g-4">
            <!-- Logo and Description -->
            <div class="col-lg-4">
                <?php if (!empty($args['logo_url'])) : ?>
                    <img src="<?php echo esc_url($args['logo_url']); ?>" alt="<?php echo esc_attr($args['company_name']); ?>" class="mb-3" style="max-height: 50px;">
                <?php endif; ?>
                <p class="mb-4"><?php echo esc_html__('PCES is a leading provider of quality products and services. We are committed to delivering the best possible experience to our customers.', 'pces-homepage'); ?></p>
                
                <!-- Social Icons -->
                <div class="social-links d-flex gap-3">
                    <?php foreach ($args['social_links'] as $network => $social) : ?>
                        <a href="<?php echo esc_url($social['url']); ?>" class="text-decoration-none" 
                           style="color: <?php echo esc_attr($args['text_color']); ?>;" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           aria-label="<?php echo esc_attr(ucfirst($network)); ?>">
                            <i class="bi <?php echo esc_attr($social['icon']); ?> fs-5"></i>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Quick Links -->
            <?php if (!empty($args['menu_items'])) : ?>
                <div class="col-md-4 col-lg-3">
                    <h5 class="mb-4" style="color: <?php echo esc_attr($args['accent_color']); ?>">
                        <?php echo esc_html__('Quick Links', 'pces-homepage'); ?>
                    </h5>
                    <ul class="list-unstyled">
                        <?php foreach ($args['menu_items'] as $item) : ?>
                            <li class="mb-2">
                                <a href="<?php echo esc_url($item['url']); ?>" 
                                   class="text-decoration-none" 
                                   style="color: <?php echo esc_attr($args['text_color']); ?>">
                                    <?php echo esc_html($item['title']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Contact Info -->
            <div class="col-md-4 col-lg-3">
                <h5 class="mb-4" style="color: <?php echo esc_attr($args['accent_color']); ?>">
                    <?php echo esc_html__('Contact Us', 'pces-homepage'); ?>
                </h5>
                <address class="mb-4">
                    <p class="mb-2">
                        <i class="bi bi-geo-alt me-2"></i>
                        <?php echo esc_html__('Terms of Use', 'pces-homepage'); ?>
                    </p>
                    <p class="mb-2">
                        <i class="bi bi-envelope me-2"></i>
                        <a href="mailto:info@example.com" class="text-decoration-none" 
                           style="color: <?php echo esc_attr($args['text_color']); ?>">
                            info@example.com
                        </a>
                    </p>
                    <p class="mb-0">
                        <i class="bi bi-telephone me-2"></i>
                        <a href="tel:+1234567890" class="text-decoration-none" 
                           style="color: <?php echo esc_attr($args['text_color']); ?>">
                            +1 (234) 567-890
                        </a>
                    </p>
                </address>
            </div>
        </div>

        <!-- Copyright -->
        <div class="row mt-5 pt-4 border-top">
            <div class="col-12 text-center">
                <p class="mb-0">
                    &copy; <?php echo date('Y'); ?> <?php echo esc_html($args['company_name']); ?>. 
                    <?php echo esc_html__('All rights reserved.', 'pces-homepage'); ?>
                </p>
            </div>
        </div>
    </div>
</footer>
