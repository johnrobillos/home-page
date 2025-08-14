<?php
/**
 * PCES Reusable Header Template
 * 
 * @package PCES_Homepage
 * @since 1.0.0
 * 
 * @param array $args {
 *     Optional. Array of header arguments.
 *     @type string $logo_url           URL of the logo image.
 *     @type string $logo_alt           Alt text for the logo.
 *     @type array  $nav_links          Array of navigation links with 'title' and 'url'.
 *     @type string $bg_color           Background color (CSS color value).
 *     @type string $text_color         Text color (CSS color value).
 *     @type string $hover_color        Hover color for links.
 *     @type string $cta_text           Text for the call-to-action button.
 *     @type string $cta_url            URL for the call-to-action button.
 *     @type string $cta_style          Style class for the CTA button (e.g., 'btn-primary').
 * }
 */

// Default values
$defaults = array(
    'logo_url'      => home_url('/wp-content/uploads/icons/PCES-Inc-o-white-Trademark.png'),
    'logo_alt'      => get_bloginfo('name'),
    'nav_links'     => array(
        'home'      => array('url' => home_url('/'), 'title' => 'Home'),
        'about'     => array('url' => '#about', 'title' => 'About Us'),
        'services'  => array('url' => '#services', 'title' => 'Services'),
        'careers'   => array('url' => '#careers', 'title' => 'Careers'),
        'contact'   => array('url' => '#contact', 'title' => 'Contact'),
    ),
    'bg_color'      => '#ffffff',
    'text_color'    => '#333333',
    'hover_color'   => '#F54927',
    'cta_text'      => 'Get Started',
    'cta_url'       => '#get-started',
    'cta_style'     => 'btn-primary',
);

$args = wp_parse_args($args, $defaults);
?>

<header class="pces-header navbar navbar-expand-lg" style="background-color: <?php echo esc_attr($args['bg_color']); ?>; color: <?php echo esc_attr($args['text_color']); ?>;">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
            <?php if (!empty($args['logo_url'])) : ?>
                <img src="<?php echo esc_url($args['logo_url']); ?>" 
                     alt="<?php echo esc_attr($args['logo_alt']); ?>" 
                     class="header-logo" 
                     style="height: 40px; width: auto;">
            <?php else : ?>
                <span class="h4 mb-0"><?php echo esc_html($args['logo_alt']); ?></span>
            <?php endif; ?>
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#pcesNavbar" 
                aria-controls="pcesNavbar" 
                aria-expanded="false" 
                aria-label="Toggle navigation"
                style="border-color: <?php echo esc_attr($args['text_color']); ?>;">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Menu -->
        <nav class="collapse navbar-collapse" id="pcesNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php foreach ($args['nav_links'] as $key => $link) : ?>
                    <li class="nav-item">
                        <a class="nav-link" 
                           href="<?php echo esc_url($link['url']); ?>"
                           style="color: <?php echo esc_attr($args['text_color']); ?>;"
                           onmouseover="this.style.color='<?php echo esc_js($args['hover_color']); ?>'"
                           onmouseout="this.style.color='<?php echo esc_js($args['text_color']); ?>'">
                            <?php echo esc_html($link['title']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            
            <!-- CTA Button -->
            <?php if (!empty($args['cta_text'])) : ?>
                <div class="d-flex">
                    <a href="<?php echo esc_url($args['cta_url']); ?>" 
                       class="btn <?php echo esc_attr($args['cta_style']); ?>"
                       style="background-color: <?php echo esc_attr($args['hover_color']); ?>; border-color: <?php echo esc_attr($args['hover_color']); ?>;">
                        <?php echo esc_html($args['cta_text']); ?>
                    </a>
                </div>
            <?php endif; ?>
        </nav>
    </div>
</header>
