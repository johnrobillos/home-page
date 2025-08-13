<?php
/**
 * PCES Reusable Footer Template
 * 
 * @package PCES_Homepage
 * @since 1.0.0
 * 
 * @param array $args {
 *     Optional. Array of footer arguments.
 *     @type string $logo_url           URL of the logo image.
 *     @type string $company_name       Company name for copyright text.
 *     @type array  $social_links       Array of social media links with 'icon' and 'url'.
 *     @type array  $legal_links        Array of legal links with 'title' and 'url'.
 *     @type string $bg_color           Background color (CSS color value).
 *     @type string $text_color         Text color (CSS color value).
 *     @type string $accent_color       Accent color for links and buttons.
 * }
 */

// Default values
$defaults = array(
    'logo_url'      => home_url('/wp-content/uploads/icons/PCES-Inc-o-white-Trademark.png'),
    'company_name'  => get_bloginfo('PCES Inc'),
    'social_links'  => array(
        'facebook'  => array('url' => 'https://www.facebook.com/PCESInc1', 'icon' => 'bi-facebook'),
        'instagram' => array('url' => 'https://www.instagram.com/pces_inc?utm_source=ig_web_button_share_sheet&igsh=NzEzYjU0OXE0Z3Fh', 'icon' => 'bi-instagram'),
        'tiktok'    => array('url' => 'https://www.tiktok.com/@pces_incorporated', 'icon' => 'bi-tiktok'),
        'youtube'   => array('url' => 'https://www.youtube.com/@pces_inc', 'icon' => 'bi-youtube'),
    ),
    'legal_links'   => array(
        'terms'     => array('url' => '#', 'title' => 'Terms of Use'),
        'privacy'   => array('url' => '#', 'title' => 'Privacy Notice')
    ),
    'bg_color'      => '#F54927',
    'text_color'    => '#8F8F8F',
    'accent_color'  => '#00FF37',
);

$args = wp_parse_args($args, $defaults);
?>

<footer class="pces-footer py-4" style="background-color: <?php echo esc_attr($args['bg_color']); ?>; color: <?php echo esc_attr($args['text_color']); ?>;">
    <div class="container">
        <div class="row align-items-center">
            <!-- Logo -->
            <div class="col-md-4 text-center text-md-start mb-3 mb-md-0">
                <?php if (!empty($args['logo_url'])) : ?>
                    <img src="<?php echo esc_url($args['logo_url']); ?>" 
                         alt="<?php echo esc_attr($args['company_name']); ?>" 
                         class="footer-logo" 
                         style="max-height: 40px; width: auto;">
                <?php endif; ?>
            </div>

            <!-- Social Icons -->
            <div class="col-md-4 text-center mb-3 mb-md-0">
                <div class="social-links d-flex justify-content-center gap-3">
                    <?php foreach ($args['social_links'] as $network => $social) : ?>
                        <a href="<?php echo esc_url($social['url']); ?>" 
                           class="social-link" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           aria-label="<?php echo esc_attr(ucfirst($network)); ?>"
                           style="color: <?php echo esc_attr($args['accent_color']); ?>">
                            <i class="bi <?php echo esc_attr($social['icon']); ?> fs-5"></i>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Legal Links -->
            <div class="col-md-4 text-center text-md-end">
                <div class="legal-links">
                    <?php 
                    $links = array_values($args['legal_links']);
                    $last = count($links) - 1;
                    foreach ($links as $index => $link) : 
                    ?>
                        <a href="<?php echo esc_url($link['url']); ?>" 
                           class="text-decoration-none" 
                           style="color: <?php echo esc_attr($args['text_color']); ?>;">
                            <?php echo esc_html($link['title']); ?>
                        </a>
                        <?php if ($index < $last) : ?>
                            <span class="mx-2" style="color: <?php echo esc_attr($args['text_color']); ?>">|</span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="row mt-3">
            <div class="col-12 text-center">
                <p class="mb-0 small" style="color: <?php echo esc_attr($args['text_color']); ?>; opacity: 0.8;">
                    &copy; <?php echo date('Y'); ?> <?php echo esc_html($args['company_name']); ?>. 
                    <?php echo esc_html__('All rights reserved.', 'pces-homepage'); ?>
                </p>
            </div>
        </div>
    </div>
</footer>
