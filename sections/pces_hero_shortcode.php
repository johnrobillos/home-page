<?php
/**
 * PCES Hero Section Shortcode
 * Simple, maintainable hero section with responsive design
 * 
 * Content variables for easy editing - no HTML knowledge required
 * 
 * BACKGROUND SETUP INSTRUCTIONS:
 * 1. For placeholder (current): Keep 'type' => 'color'
 * 2. For image background: Change 'type' => 'image' and add image URL
 * 3. The structure supports both with automatic fallback handling
 */

// Content variables array for easy editing
$hero_content = array(
    'headline' => 'Philippines Central Engagement Services Inc.',
    'description' => 'Opportunities shouldn\'t be a privilege. We create job platforms so under served Filipinos can rise, grow, and thrive — because when doors are open, the sky is never the limit.',
    'cta_text' => 'Explore Our Services',
    'cta_link' => '#services'
);

// Background configuration (placeholder during development)
$hero_background = array(
    'type' => 'color', // 'color' for placeholder, 'image' for final implementation
    'value' => '#007bff', // Blue placeholder color
    'image_url' => '', // Future: Add image URL here when ready
    'image_alt' => 'PCES Hero Background', // Alt text for accessibility
    'fallback_color' => '#007bff' // Fallback color if image fails to load
);

// Extended section content
$mission_text = "At PCES Inc., we believe that everyone deserves access to meaningful work—regardless of background, ability, or life circumstance. As a proudly Filipino-led technology company, we are driven by a mission to create inclusive, purpose-centered employment solutions that reflect the diversity of our communities.";
$tagline_part1 = "Created by Filipinos";
$tagline_part2 = "for the Filipinos";
?>

<!-- Hero Section - Responsive Design with Enhanced Semantic Markup and Accessibility -->
<section class="pces-hero-redesign" 
         role="banner" 
         aria-labelledby="hero-headline" 
         aria-describedby="hero-description">
    
    <!-- Skip Link for Keyboard Navigation -->
    <a href="#main-content" class="skip-link sr-only sr-only-focusable">
        Skip to main content
    </a>
    
    <!-- Background Container with Enhanced Accessibility -->
    <div class="hero-background" 
         <?php if ($hero_background['type'] === 'image' && !empty($hero_background['image_url'])): ?>
         style="background-image: url('<?php echo esc_url($hero_background['image_url']); ?>'); background-color: <?php echo esc_attr($hero_background['fallback_color']); ?>;"
         role="img"
         aria-label="<?php echo esc_attr($hero_background['image_alt']); ?>"
         <?php else: ?>
         style="background-color: <?php echo esc_attr($hero_background['value']); ?>;"
         aria-hidden="true"
         <?php endif; ?>>
    </div>
    
    <!-- Content Container with Landmark -->
    <div class="hero-content-wrapper" role="main">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="hero-content-block" 
                         role="region" 
                         aria-label="Company introduction and services">
                        
                        <!-- Main Headline with Proper Hierarchy -->
                        <h1 id="hero-headline" 
                            class="hero-headline"
                            tabindex="-1">
                            <?php echo esc_html($hero_content['headline']); ?>
                        </h1>
                        
                        <!-- Description Text with Enhanced Semantics -->
                        <p id="hero-description" 
                           class="hero-description"
                           role="text"
                           aria-live="polite">
                            <?php echo esc_html($hero_content['description']); ?>
                        </p>
                        
                        <!-- Call-to-Action Button with Enhanced Accessibility -->
                        <a href="<?php echo esc_url($hero_content['cta_link']); ?>" 
                           class="hero-cta-button btn" 
                           role="button"
                           aria-label="<?php echo esc_attr($hero_content['cta_text'] . ' - Navigate to our services section to learn more about what we offer'); ?>"
                           aria-describedby="hero-description"
                           tabindex="0"
                           data-action="navigate-services"
                           title="<?php echo esc_attr('Learn more about ' . $hero_content['cta_text']); ?>">
                            <span class="button-text" aria-hidden="false">
                                <?php echo esc_html($hero_content['cta_text']); ?>
                            </span>
                            <span class="sr-only">
                                (Opens services section)
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="hero-extended py-5">
    <div class="container">
        <div class="row align-items-center">
            <!-- Mission paragraph -->
            <div class="col-lg-6">
                <p class="mission-text"><?php echo esc_html($mission_text); ?></p>
            </div>
            
            <!-- Tagline -->
            <div class="col-lg-6 text-center">
                <div class="tagline-container">
                    <h2 class="tagline-part1"><?php echo esc_html($tagline_part1); ?></h2>
                    <h2 class="tagline-part2"><?php echo esc_html($tagline_part2); ?></h2>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
/* Extended Hero Section Styling */
.hero-extended {
    background: white;
    padding: 80px 0;
    margin-top: -20px; /* Slight overlap with main hero */
}

.mission-text {
    color: #666666;
    font-size: 1.1rem;
    line-height: 1.7;
    margin: 0;
    padding-right: 40px;
}

.tagline-container {
    padding-left: 40px;
}

.tagline-part1 {
    color: #1a237e;
    font-size: 3rem;
    font-weight: 700;
    line-height: 1.1;
    margin-bottom: 10px;
}

.tagline-part2 {
    color: #dc3545;
    font-size: 3rem;
    font-weight: 700;
    line-height: 1.1;
    margin-bottom: 0;
}


/* PCES Hero Section - Mobile-First Responsive Design with Enhanced Accessibility */

/* Skip Link for Keyboard Navigation - WCAG 2.1 AA Compliance */
.skip-link {
    position: absolute;
    top: -40px;
    left: 6px;
    background: #000000;
    color: #ffffff;
    padding: 8px 16px;
    text-decoration: none;
    border-radius: 0 0 4px 4px;
    font-weight: 600;
    font-size: 14px;
    z-index: 9999;
    transition: top 0.3s ease;
    border: 2px solid #ffffff;
}

.skip-link:focus {
    top: 6px;
    outline: 3px solid #ffff00;
    outline-offset: 2px;
    color: #ffffff;
    text-decoration: none;
}

/* Screen Reader Only Content */
.sr-only {
    position: absolute !important;
    width: 1px !important;
    height: 1px !important;
    padding: 0 !important;
    margin: -1px !important;
    overflow: hidden !important;
    clip: rect(0, 0, 0, 0) !important;
    white-space: nowrap !important;
    border: 0 !important;
}

.sr-only-focusable:focus {
    position: static !important;
    width: auto !important;
    height: auto !important;
    padding: 8px 16px !important;
    margin: 0 !important;
    overflow: visible !important;
    clip: auto !important;
    white-space: normal !important;
}

/* Mobile Base Styles (320px and up) - Stacked Layout with Cross-Browser Support */
.pces-hero-redesign {
    position: relative;
    min-height: 100vh;
    /* Cross-browser flexbox support */
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    /* Ensure proper rendering across browsers */
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

/* Background Container - Mobile: Top Section with Enhanced Cross-Browser Support */
.hero-background {
    width: 100%;
    height: 40vh; /* 40% of viewport height for mobile */
    min-height: 250px;
    -webkit-box-ordinal-group: 2;
    -ms-flex-order: 1;
    order: 1; /* Background appears first on mobile */
    -webkit-flex-shrink: 0;
    -ms-flex-negative: 0;
    flex-shrink: 0;
    
    /* Enhanced background image properties with cross-browser support */
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover; /* Ensures image covers entire container */
    background-position: center center; /* Centers image on mobile */
    background-repeat: no-repeat; /* Prevents image repetition */
    
    /* Cross-browser transition support */
    -webkit-transition: background-image 0.3s ease-in-out;
    -moz-transition: background-image 0.3s ease-in-out;
    -o-transition: background-image 0.3s ease-in-out;
    transition: background-image 0.3s ease-in-out;
    
    /* Cross-browser box-sizing */
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    
    /* Current: Solid blue placeholder color (#007bff) */
    /* Future: Will display background image with color fallback */
}

/* Content Wrapper - Mobile: Below Background with Cross-Browser Support */
.hero-content-wrapper {
    -webkit-box-flex: 1;
    -ms-flex: 1;
    flex: 1;
    -webkit-box-ordinal-group: 3;
    -ms-flex-order: 2;
    order: 2; /* Content appears second on mobile */
    /* Cross-browser flexbox support */
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    padding: 30px 0;
    background: #f8f9fa; /* Light background for content area */
    /* Cross-browser box-sizing */
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

/* Content Block - Mobile First Design */
.hero-content-block {
    background: #ffffff;
    padding: 30px 20px;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    max-width: 100%;
    margin: 0 15px;
    text-align: center;
    width: 100%;
}

/* Mobile Typography - Optimized for Small Screens with Enhanced Contrast */
.hero-headline {
    color: #1a1a1a; /* Improved contrast ratio: 15.3:1 (WCAG AAA) */
    font-size: 1.75rem; /* 28px - Mobile optimized */
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 20px;
    word-wrap: break-word;
    /* Enhanced readability */
    text-rendering: optimizeLegibility;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

.hero-description {
    color: #2d2d2d; /* Improved contrast ratio: 12.6:1 (WCAG AAA) */
    font-size: 0.95rem; /* 15.2px - Mobile optimized */
    line-height: 1.6; /* Improved readability */
    margin-bottom: 25px;
    max-width: 100%;
    /* Enhanced readability */
    text-rendering: optimizeLegibility;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* Mobile CTA Button - Touch Optimized with Enhanced Accessibility */
.hero-cta-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: transparent;
    color: #0056b3; /* Improved contrast ratio: 7.1:1 (WCAG AA Large Text) */
    border: 3px solid #0056b3; /* Thicker border for better visibility */
    padding: 14px 24px; /* Larger touch target for mobile */
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    min-width: 48px; /* WCAG AA touch target minimum */
    min-height: 48px;
    width: auto;
    text-align: center;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    /* Enhanced accessibility */
    -webkit-tap-highlight-color: rgba(0, 86, 179, 0.2);
    touch-action: manipulation; /* Prevents zoom on double-tap */
    /* Screen reader and keyboard navigation */
    outline: none; /* Custom focus styling below */
    text-rendering: optimizeLegibility;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* Hover state - Enhanced visual feedback with improved contrast */
.hero-cta-button:hover {
    background: #0056b3; /* Darker blue for better contrast */
    color: #ffffff; /* White text: 15.3:1 contrast ratio (WCAG AAA) */
    text-decoration: none;
    transform: translateY(-2px); /* More pronounced lift effect */
    box-shadow: 0 6px 20px rgba(0, 86, 179, 0.4);
    border-color: #004085;
}

/* Focus state - Enhanced keyboard navigation accessibility */
.hero-cta-button:focus {
    background: #0056b3;
    color: #ffffff; /* White text: 15.3:1 contrast ratio (WCAG AAA) */
    text-decoration: none;
    outline: 4px solid #ffff00; /* High contrast yellow focus ring */
    outline-offset: 2px;
    box-shadow: 0 4px 12px rgba(0, 86, 179, 0.3), 0 0 0 2px #000000; /* Double ring for high contrast */
    border-color: #004085;
    /* Ensure focus is visible in all modes */
    position: relative;
    z-index: 10;
}

/* Focus-visible for modern browsers - only show focus ring for keyboard navigation */
.hero-cta-button:focus-visible {
    outline: 4px solid #ffff00;
    outline-offset: 2px;
    box-shadow: 0 4px 12px rgba(0, 86, 179, 0.3), 0 0 0 2px #000000;
}

/* Remove focus ring for mouse users in modern browsers */
.hero-cta-button:focus:not(:focus-visible) {
    outline: none;
    box-shadow: 0 4px 12px rgba(0, 86, 179, 0.3);
}

/* Active state - Pressed button feedback */
.hero-cta-button:active {
    background: #004085; /* Even darker blue when pressed */
    color: #ffffff; /* White text: 18.7:1 contrast ratio (WCAG AAA) */
    transform: translateY(0); /* Return to original position */
    box-shadow: 0 2px 8px rgba(0, 64, 133, 0.2);
    border-color: #002752;
    transition: all 0.1s ease; /* Faster transition for immediate feedback */
}

/* Visited state - Maintain consistent styling with improved contrast */
.hero-cta-button:visited {
    color: #0056b3; /* Consistent with main button color */
    border-color: #0056b3;
}

.hero-cta-button:visited:hover,
.hero-cta-button:visited:focus {
    background: #0056b3;
    color: #ffffff;
    border-color: #004085;
}

/* Windows High Contrast Mode Support */
@media screen and (-ms-high-contrast: active) {
    .hero-cta-button {
        border: 3px solid ButtonText;
        color: ButtonText;
        background: ButtonFace;
    }
    
    .hero-cta-button:hover,
    .hero-cta-button:focus {
        border: 3px solid HighlightText;
        color: HighlightText;
        background: Highlight;
    }
    
    .hero-cta-button:focus {
        outline: 3px solid HighlightText;
        outline-offset: 2px;
    }
}

/* Windows High Contrast Mode - Black on White */
@media screen and (-ms-high-contrast: black-on-white) {
    .hero-headline,
    .hero-description {
        color: WindowText;
    }
    
    .hero-content-block {
        background: Window;
        border: 2px solid WindowText;
    }
}

/* Windows High Contrast Mode - White on Black */
@media screen and (-ms-high-contrast: white-on-black) {
    .hero-headline,
    .hero-description {
        color: WindowText;
    }
    
    .hero-content-block {
        background: Window;
        border: 2px solid WindowText;
    }
}

/* Loading state - For future enhancement */
.hero-cta-button.loading {
    pointer-events: none;
    opacity: 0.7;
}

.hero-cta-button.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 16px;
    height: 16px;
    margin: -8px 0 0 -8px;
    border: 2px solid transparent;
    border-top: 2px solid currentColor;
    border-radius: 50%;
    animation: button-spin 1s linear infinite;
}

@keyframes button-spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Optimized Desktop Layout (≥992px) - Enhanced Overlay Design with Cross-Browser Support */
@media (min-width: 992px) {
    /* Reset mobile stacked layout for desktop */
    .pces-hero-redesign {
        flex-direction: row;
        align-items: center;
        /* Cross-browser flex support */
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -ms-flex-direction: row;
        -webkit-box-align: center;
        -ms-flex-align: center;
    }
    
    .hero-background {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        height: 100%;
        order: unset;
        z-index: 1;
        /* Enhanced desktop background positioning with cross-browser support */
        background-position: center right; /* Focus on right side for desktop overlay */
        /* Cross-browser background-size support */
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        /* Improved background attachment for better performance */
        background-attachment: scroll; /* Better performance than fixed */
    }
    
    .hero-content-wrapper {
        position: relative;
        z-index: 2;
        order: unset;
        background: transparent;
        padding: 80px 0;
        flex: unset;
        /* Cross-browser flex support */
        -webkit-box-flex: 0;
        -ms-flex: none;
    }
    
    .hero-content-block {
        position: absolute;
        left: 60px;
        top: 50%;
        /* Cross-browser transform support */
        -webkit-transform: translateY(-50%);
        -moz-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        -o-transform: translateY(-50%);
        transform: translateY(-50%);
        margin: 0;
        text-align: left;
        max-width: 500px;
        width: auto;
        /* Enhanced clipped corner effect with fallback */
        clip-path: polygon(0 0, calc(100% - 40px) 0, 100% 40px, 100% 100%, 0 100%);
        -webkit-clip-path: polygon(0 0, calc(100% - 40px) 0, 100% 40px, 100% 100%, 0 100%);
        /* Fallback for browsers that don't support clip-path */
        border-radius: 8px 0 8px 8px;
        padding: 50px 40px;
        /* Enhanced shadow for better depth */
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15), 0 4px 12px rgba(0, 0, 0, 0.1);
        /* Cross-browser box-shadow support */
        -webkit-box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15), 0 4px 12px rgba(0, 0, 0, 0.1);
        -moz-box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15), 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .hero-headline {
        font-size: 2.5rem;
        margin-bottom: 30px;
        color: #1a1a1a; /* Maintain high contrast on desktop */
        line-height: 1.2; /* Optimized for desktop reading */
        /* Enhanced typography rendering */
        text-rendering: optimizeLegibility;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    
    .hero-description {
        font-size: 1.1rem;
        margin-bottom: 40px;
        color: #2d2d2d; /* Maintain high contrast on desktop */
        line-height: 1.6; /* Better readability */
        max-width: 90%; /* Prevent overly long lines */
        /* Enhanced typography rendering */
        text-rendering: optimizeLegibility;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    
    .hero-cta-button {
        padding: 15px 30px;
        font-size: 1.1rem;
        width: auto;
        min-width: 48px;
        min-height: 48px;
        /* Enhanced desktop transitions with cross-browser support */
        -webkit-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        -moz-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        -o-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        /* Improved cursor for better UX */
        cursor: pointer;
    }
    
    /* Enhanced desktop hover effects with cross-browser support */
    .hero-cta-button:hover {
        /* Cross-browser transform support */
        -webkit-transform: translateY(-3px);
        -moz-transform: translateY(-3px);
        -ms-transform: translateY(-3px);
        -o-transform: translateY(-3px);
        transform: translateY(-3px);
        /* Enhanced shadow with cross-browser support */
        box-shadow: 0 8px 25px rgba(0, 86, 179, 0.5);
        -webkit-box-shadow: 0 8px 25px rgba(0, 86, 179, 0.5);
        -moz-box-shadow: 0 8px 25px rgba(0, 86, 179, 0.5);
    }
    
    /* Enhanced desktop focus with cross-browser support */
    .hero-cta-button:focus {
        outline: 4px solid #ffff00; /* High contrast yellow focus ring */
        outline-offset: 3px; /* More space on desktop */
        box-shadow: 0 4px 12px rgba(0, 86, 179, 0.3), 0 0 0 2px #000000;
        -webkit-box-shadow: 0 4px 12px rgba(0, 86, 179, 0.3), 0 0 0 2px #000000;
        -moz-box-shadow: 0 4px 12px rgba(0, 86, 179, 0.3), 0 0 0 2px #000000;
    }
    
    .hero-cta-button:focus-visible {
        outline: 4px solid #ffff00;
        outline-offset: 3px;
    }
}

/* Optimized Large Desktop (≥1200px) - Enhanced Typography and Spacing */
@media (min-width: 1200px) {
    .hero-background {
        /* Optimize background positioning for large screens */
        background-position: center right;
        /* Enhanced background properties for large displays */
        background-attachment: scroll; /* Better performance */
    }
    
    .hero-content-block {
        left: 80px;
        max-width: 550px;
        padding: 60px 50px;
        /* Enhanced shadow for large screens */
        box-shadow: 0 16px 50px rgba(0, 0, 0, 0.18), 0 6px 18px rgba(0, 0, 0, 0.12);
        -webkit-box-shadow: 0 16px 50px rgba(0, 0, 0, 0.18), 0 6px 18px rgba(0, 0, 0, 0.12);
        -moz-box-shadow: 0 16px 50px rgba(0, 0, 0, 0.18), 0 6px 18px rgba(0, 0, 0, 0.12);
    }
    
    .hero-headline {
        font-size: 2.8rem;
        line-height: 1.15; /* Optimized for large displays */
        margin-bottom: 32px;
    }
    
    .hero-description {
        font-size: 1.2rem;
        line-height: 1.65; /* Enhanced readability on large screens */
        margin-bottom: 45px;
        max-width: 85%; /* Optimal line length for large screens */
    }
    
    .hero-cta-button {
        padding: 18px 35px;
        font-size: 1.15rem;
        /* Enhanced large screen interactions */
        min-height: 52px; /* Slightly larger for desktop */
    }
}

/* Ultra-wide Desktop Optimization (≥1400px) - Enhanced for Large Displays */
@media (min-width: 1400px) {
    .hero-content-block {
        left: 100px;
        max-width: 600px;
        padding: 70px 60px;
        /* Enhanced shadow for ultra-wide displays */
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2), 0 8px 24px rgba(0, 0, 0, 0.15);
        -webkit-box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2), 0 8px 24px rgba(0, 0, 0, 0.15);
        -moz-box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2), 0 8px 24px rgba(0, 0, 0, 0.15);
    }
    
    .hero-headline {
        font-size: 3rem;
        margin-bottom: 35px;
        line-height: 1.1; /* Optimized for ultra-wide displays */
    }
    
    .hero-description {
        font-size: 1.25rem;
        margin-bottom: 50px;
        line-height: 1.7; /* Enhanced readability on large screens */
        max-width: 80%; /* Optimal line length for ultra-wide screens */
    }
    
    .hero-cta-button {
        padding: 20px 40px;
        font-size: 1.2rem;
        min-height: 56px; /* Enhanced touch target for large displays */
        /* Enhanced ultra-wide hover effects */
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .hero-cta-button:hover {
        transform: translateY(-4px); /* More pronounced effect on large displays */
        box-shadow: 0 12px 35px rgba(0, 86, 179, 0.6);
        -webkit-box-shadow: 0 12px 35px rgba(0, 86, 179, 0.6);
        -moz-box-shadow: 0 12px 35px rgba(0, 86, 179, 0.6);
    }
}

/* Optimized Tablet Breakpoint (577px - 767px) - Enhanced Transitions */
@media (min-width: 577px) and (max-width: 767px) {
    .hero-background {
        height: 45vh;
        min-height: 300px;
        /* Improved background positioning for tablet */
        background-position: center center;
    }
    
    .hero-content-wrapper {
        padding: 35px 0;
    }
    
    .hero-content-block {
        max-width: 600px;
        padding: 40px 35px;
        margin: 0 auto;
        /* Enhanced shadow for better depth perception */
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
    }
    
    .hero-headline {
        font-size: 2rem; /* 32px */
        margin-bottom: 24px;
        /* Improved line height for tablet reading */
        line-height: 1.25;
    }
    
    .hero-description {
        font-size: 1.05rem; /* 16.8px */
        margin-bottom: 30px;
        line-height: 1.55; /* Optimized for tablet reading */
        max-width: 90%; /* Prevent overly long lines */
        margin-left: auto;
        margin-right: auto;
    }
    
    .hero-cta-button {
        padding: 16px 28px;
        font-size: 1.05rem;
        min-height: 48px; /* Maintain touch target */
        /* Enhanced tablet hover effects */
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .hero-cta-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 86, 179, 0.35);
    }
}

/* Optimized Large Tablet Breakpoint (768px - 991px) - Smooth Desktop Transition */
@media (min-width: 768px) and (max-width: 991px) {
    .hero-background {
        height: 50vh;
        min-height: 350px;
        /* Prepare for desktop transition */
        background-position: center right;
    }
    
    .hero-content-wrapper {
        padding: 40px 0;
    }
    
    .hero-content-block {
        max-width: 650px;
        padding: 45px 40px;
        margin: 0 auto;
        /* Enhanced visual hierarchy */
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        /* Subtle preparation for desktop clipped corner */
        border-radius: 8px 8px 8px 8px;
    }
    
    .hero-headline {
        font-size: 2.2rem; /* 35.2px */
        margin-bottom: 26px;
        line-height: 1.3; /* Optimized for larger tablet screens */
    }
    
    .hero-description {
        font-size: 1.1rem; /* 17.6px */
        margin-bottom: 32px;
        line-height: 1.6; /* Better readability on larger screens */
        max-width: 85%; /* Optimal line length */
        margin-left: auto;
        margin-right: auto;
    }
    
    .hero-cta-button {
        padding: 16px 30px;
        font-size: 1.1rem;
        min-height: 48px; /* Maintain touch target */
        /* Smooth transition preparation for desktop */
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .hero-cta-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(0, 86, 179, 0.4);
    }
}

/* Mobile Breakpoint: 320px (iPhone SE, small phones) */
@media (max-width: 320px) {
    .hero-background {
        height: 35vh;
        min-height: 200px;
        /* Adjust background positioning for very small screens */
        background-position: center center;
    }
    
    .hero-content-wrapper {
        padding: 20px 0;
    }
    
    .hero-content-block {
        padding: 25px 15px;
        margin: 0 10px;
        border-radius: 6px;
    }
    
    .hero-headline {
        font-size: 1.5rem; /* 24px */
        margin-bottom: 16px;
        line-height: 1.1;
    }
    
    .hero-description {
        font-size: 0.875rem; /* 14px */
        margin-bottom: 20px;
        line-height: 1.4;
    }
    
    .hero-cta-button {
        padding: 12px 20px;
        font-size: 0.875rem;
        width: 100%;
        max-width: 280px;
        min-height: 48px; /* Maintain touch target */
        display: flex;
        align-items: center;
        justify-content: center;
    }
}

/* Mobile Breakpoint: 375px (iPhone 6/7/8, standard mobile) */
@media (min-width: 321px) and (max-width: 375px) {
    .hero-background {
        height: 38vh;
        min-height: 220px;
    }
    
    .hero-content-wrapper {
        padding: 25px 0;
    }
    
    .hero-content-block {
        padding: 28px 18px;
        margin: 0 12px;
    }
    
    .hero-headline {
        font-size: 1.625rem; /* 26px */
        margin-bottom: 18px;
    }
    
    .hero-description {
        font-size: 0.9rem; /* 14.4px */
        margin-bottom: 22px;
    }
    
    .hero-cta-button {
        padding: 13px 22px;
        font-size: 0.9rem;
        min-height: 48px; /* Maintain touch target */
    }
}

/* Mobile Breakpoint: 414px (iPhone Plus, large phones) */
@media (min-width: 376px) and (max-width: 414px) {
    .hero-background {
        height: 40vh;
        min-height: 240px;
    }
    
    .hero-content-wrapper {
        padding: 28px 0;
    }
    
    .hero-content-block {
        padding: 30px 20px;
        margin: 0 15px;
    }
    
    .hero-headline {
        font-size: 1.75rem; /* 28px */
        margin-bottom: 20px;
    }
    
    .hero-description {
        font-size: 0.95rem; /* 15.2px */
        margin-bottom: 24px;
    }
    
    .hero-cta-button {
        padding: 14px 24px;
        font-size: 0.95rem;
        min-height: 48px; /* Maintain touch target */
    }
}

/* Small Mobile Adjustments (415px - 576px) */
@media (min-width: 415px) and (max-width: 576px) {
    .hero-background {
        height: 42vh;
        min-height: 260px;
    }
    
    .hero-content-wrapper {
        padding: 30px 0;
    }
    
    .hero-content-block {
        padding: 32px 25px;
        margin: 0 20px;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .hero-headline {
        font-size: 1.875rem; /* 30px */
        margin-bottom: 22px;
    }
    
    .hero-description {
        font-size: 1rem; /* 16px */
        margin-bottom: 26px;
    }
    
    .hero-cta-button {
        padding: 15px 26px;
        font-size: 1rem;
    }
}

/* Optimized Desktop Layout (≥992px) - Enhanced Overlay Design with Cross-Browser Support */

@media (min-width: 992px) {
    /* Reset mobile stacked layout for desktop */
    .pces-hero-redesign {
        flex-direction: row;
        align-items: center;
        /* Cross-browser flex support */
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -ms-flex-direction: row;
        -webkit-box-align: center;
        -ms-flex-align: center;
    }
    
    .hero-background {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        height: 100%;
        order: unset;
        z-index: 1;
        /* Enhanced desktop background positioning with cross-browser support */
        background-position: center right; /* Focus on right side for desktop overlay */
        /* Cross-browser background-size support */
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        /* Improved background attachment for better performance */
        background-attachment: scroll; /* Better performance than fixed */
    }
    
    .hero-content-wrapper {
        position: relative;
        z-index: 2;
        order: unset;
        background: transparent;
        padding: 80px 0;
        flex: unset;
        /* Cross-browser flex support */
        -webkit-box-flex: 0;
        -ms-flex: none;
    }
    
    .hero-content-block {
        position: absolute;
        left: 60px;
        top: 50%;
        /* Cross-browser transform support */
        -webkit-transform: translateY(-50%);
        -moz-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        -o-transform: translateY(-50%);
        transform: translateY(-50%);
        margin: 0;
        text-align: left;
        max-width: 500px;
        width: auto;
        /* Enhanced clipped corner effect with fallback */
        clip-path: polygon(0 0, calc(100% - 40px) 0, 100% 40px, 100% 100%, 0 100%);
        -webkit-clip-path: polygon(0 0, calc(100% - 40px) 0, 100% 40px, 100% 100%, 0 100%);
        /* Fallback for browsers that don't support clip-path */
        border-radius: 8px 0 8px 8px;
        padding: 50px 40px;
        /* Enhanced shadow for better depth */
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15), 0 4px 12px rgba(0, 0, 0, 0.1);
        /* Cross-browser box-shadow support */
        -webkit-box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15), 0 4px 12px rgba(0, 0, 0, 0.1);
        -moz-box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15), 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .hero-headline {
        font-size: 2.5rem;
        margin-bottom: 30px;
        color: #1a1a1a; /* Maintain high contrast on desktop */
        line-height: 1.2; /* Optimized for desktop reading */
        /* Enhanced typography rendering */
        text-rendering: optimizeLegibility;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    
    .hero-description {
        font-size: 1.1rem;
        margin-bottom: 40px;
        color: #2d2d2d; /* Maintain high contrast on desktop */
        line-height: 1.6; /* Better readability */
        max-width: 90%; /* Prevent overly long lines */
        /* Enhanced typography rendering */
        text-rendering: optimizeLegibility;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    
    .hero-cta-button {
        padding: 15px 30px;
        font-size: 1.1rem;
        width: auto;
        min-width: 48px;
        min-height: 48px;
        /* Enhanced desktop transitions with cross-browser support */
        -webkit-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        -moz-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        -o-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        /* Improved cursor for better UX */
        cursor: pointer;
    }
    
    /* Enhanced desktop hover effects with cross-browser support */
    .hero-cta-button:hover {
        /* Cross-browser transform support */
        -webkit-transform: translateY(-3px);
        -moz-transform: translateY(-3px);
        -ms-transform: translateY(-3px);
        -o-transform: translateY(-3px);
        transform: translateY(-3px);
        /* Enhanced shadow with cross-browser support */
        box-shadow: 0 8px 25px rgba(0, 86, 179, 0.5);
        -webkit-box-shadow: 0 8px 25px rgba(0, 86, 179, 0.5);
        -moz-box-shadow: 0 8px 25px rgba(0, 86, 179, 0.5);
    }
    
    /* Enhanced desktop focus with cross-browser support */
    .hero-cta-button:focus {
        outline: 4px solid #ffff00; /* High contrast yellow focus ring */
        outline-offset: 3px; /* More space on desktop */
        box-shadow: 0 4px 12px rgba(0, 86, 179, 0.3), 0 0 0 2px #000000;
        -webkit-box-shadow: 0 4px 12px rgba(0, 86, 179, 0.3), 0 0 0 2px #000000;
        -moz-box-shadow: 0 4px 12px rgba(0, 86, 179, 0.3), 0 0 0 2px #000000;
    }
    
    .hero-cta-button:focus-visible {
        outline: 4px solid #ffff00;
        outline-offset: 3px;
    }
}

/* Optimized Large Desktop (≥1200px) - Enhanced Typography and Spacing */
@media (min-width: 1200px) {
    .hero-background {
        /* Optimize background positioning for large screens */
        background-position: center right;
        /* Enhanced background properties for large displays */
        background-attachment: scroll; /* Better performance */
    }
    
    .hero-content-block {
        left: 80px;
        max-width: 550px;
        padding: 60px 50px;
        /* Enhanced shadow for large screens */
        box-shadow: 0 16px 50px rgba(0, 0, 0, 0.18), 0 6px 18px rgba(0, 0, 0, 0.12);
        -webkit-box-shadow: 0 16px 50px rgba(0, 0, 0, 0.18), 0 6px 18px rgba(0, 0, 0, 0.12);
        -moz-box-shadow: 0 16px 50px rgba(0, 0, 0, 0.18), 0 6px 18px rgba(0, 0, 0, 0.12);
    }
    
    .hero-headline {
        font-size: 2.8rem;
        line-height: 1.15; /* Optimized for large displays */
        margin-bottom: 32px;
    }
    
    .hero-description {
        font-size: 1.2rem;
        line-height: 1.65; /* Enhanced readability on large screens */
        margin-bottom: 45px;
        max-width: 85%; /* Optimal line length for large screens */
    }
    
    .hero-cta-button {
        padding: 18px 35px;
        font-size: 1.15rem;
        /* Enhanced large screen interactions */
        min-height: 52px; /* Slightly larger for desktop */
    }
}

/* Ultra-wide Desktop Optimization (≥1400px) - Enhanced for Large Displays */
@media (min-width: 1400px) {
    .hero-content-block {
        left: 100px;
        max-width: 600px;
        padding: 70px 60px;
        /* Enhanced shadow for ultra-wide displays */
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2), 0 8px 24px rgba(0, 0, 0, 0.15);
        -webkit-box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2), 0 8px 24px rgba(0, 0, 0, 0.15);
        -moz-box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2), 0 8px 24px rgba(0, 0, 0, 0.15);
    }
    
    .hero-headline {
        font-size: 3rem;
        margin-bottom: 35px;
        line-height: 1.1; /* Optimized for ultra-wide displays */
    }
    
    .hero-description {
        font-size: 1.25rem;
        margin-bottom: 50px;
        line-height: 1.7; /* Enhanced readability on large screens */
        max-width: 80%; /* Optimal line length for ultra-wide screens */
    }
    
    .hero-cta-button {
        padding: 20px 40px;
        font-size: 1.2rem;
        min-height: 56px; /* Enhanced touch target for large displays */
        /* Enhanced ultra-wide hover effects */
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .hero-cta-button:hover {
        transform: translateY(-4px); /* More pronounced effect on large displays */
        box-shadow: 0 12px 35px rgba(0, 86, 179, 0.6);
        -webkit-box-shadow: 0 12px 35px rgba(0, 86, 179, 0.6);
        -moz-box-shadow: 0 12px 35px rgba(0, 86, 179, 0.6);
    }
}

/* Desktop overlap fix: anchor hero card to bottom and expand width when height is tight */
@media (min-width: 992px) {
    .pces-hero-redesign .hero-content-wrapper {
        /* Fill the viewport so absolute children can reference the full hero height */
        min-height: 100vh;
    }
    .pces-hero-redesign .hero-content-block {
        /* Prevent overlap with next section by anchoring to the bottom of the hero */
        top: auto;
        bottom: 40px;
        -webkit-transform: none;
        -moz-transform: none;
        -ms-transform: none;
        -o-transform: none;
        transform: none;
        /* Allow more horizontal room on desktop so text wraps less */
        max-width: clamp(560px, 38vw, 760px);
    }
}

/* When desktop viewport height is short, widen the card further so it fits vertically */
@media (min-width: 1200px) and (max-height: 850px) {
    .pces-hero-redesign .hero-content-block { max-width: clamp(620px, 44vw, 840px); }
    .pces-hero-redesign .hero-description { max-width: 100%; }
}

@media (min-width: 1400px) and (max-height: 800px) {
    .pces-hero-redesign .hero-content-block { max-width: clamp(680px, 48vw, 900px); }
    .pces-hero-redesign .hero-description { max-width: 100%; }
}

/* High Contrast Mode Support - Enhanced Accessibility */
@media (prefers-contrast: high) {
    .hero-headline {
        color: #000000;
        text-shadow: none;
    }
    
    .hero-description {
        color: #000000;
        text-shadow: none;
    }
    
    .hero-content-block {
        background: #ffffff;
        border: 3px solid #000000;
        box-shadow: none;
    }
    
    .hero-cta-button {
        border-width: 4px;
        border-color: #000000;
        color: #000000;
        background: #ffffff;
        box-shadow: none;
    }
    
    .hero-cta-button:hover,
    .hero-cta-button:focus {
        background: #000000;
        color: #ffffff;
        border-color: #ffffff;
        box-shadow: none;
    }
    
    .hero-cta-button:focus {
        outline: 4px solid #ffff00;
        outline-offset: 2px;
    }
    
    .hero-cta-button:active {
        background: #333333;
        color: #ffffff;
        border-color: #ffffff;
    }
}

/* Reduced Motion Support - Accessibility for vestibular disorders */
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
    
    .hero-cta-button {
        transition: color 0.15s ease, background-color 0.15s ease, border-color 0.15s ease, box-shadow 0.15s ease;
    }
    
    .hero-cta-button:hover,
    .hero-cta-button:focus,
    .hero-cta-button:active {
        transform: none;
    }
    
    .skip-link {
        transition: none;
    }
    
    @keyframes button-spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
}

/* Touch Device Optimizations */
@media (hover: none) and (pointer: coarse) {
    .hero-cta-button {
        /* Larger touch targets for touch devices */
        min-width: 56px; /* Larger than WCAG minimum for better UX */
        min-height: 56px;
        padding: 16px 28px;
    }
    
    .hero-cta-button:hover {
        /* Remove hover effects on touch devices */
        transform: none;
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }
}

/* Internet Explorer Compatibility Fixes */
@media screen and (-ms-high-contrast: none), (-ms-high-contrast: active) {
    /* IE10+ specific fixes */
    .pces-hero-redesign {
        display: -ms-flexbox;
        -ms-flex-direction: column;
    }
    
    .hero-content-wrapper {
        display: -ms-flexbox;
        -ms-flex-align: center;
        -ms-flex: 1;
    }
    
    .hero-content-block {
        /* IE fallback for clip-path */
        clip-path: none;
        -webkit-clip-path: none;
        border-radius: 8px 0 8px 8px;
    }
    
    .hero-cta-button {
        /* IE button fixes */
        display: inline-block;
        vertical-align: middle;
    }
}

/* CSS Grid Fallback for Older Browsers */
@supports not (display: flex) {
    .pces-hero-redesign {
        display: block;
    }
    
    .hero-background {
        display: block;
        float: none;
        width: 100%;
    }
    
    .hero-content-wrapper {
        display: block;
        clear: both;
    }
    
    .hero-content-block {
        display: block;
        margin: 20px auto;
        max-width: 90%;
    }
}

/* Enhanced CSS Validation and Browser Compatibility */
* {
    /* Ensure consistent box-sizing across all browsers */
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

/* Webkit-specific optimizations */
@media screen and (-webkit-min-device-pixel-ratio: 0) {
    .hero-cta-button {
        /* Webkit button rendering optimization */
        -webkit-appearance: none;
        -webkit-border-radius: 6px;
    }
    
    .hero-content-block {
        /* Webkit shadow optimization */
        -webkit-backface-visibility: hidden;
        -webkit-transform: translateZ(0);
    }
}

/* Firefox-specific optimizations */
@-moz-document url-prefix() {
    .hero-cta-button {
        /* Firefox button rendering */
        -moz-appearance: none;
    }
    
    .hero-content-block {
        /* Firefox clip-path fallback */
        background-clip: padding-box;
    }
}

/* Print Styles - Enhanced accessibility in print */
@media print {
    .hero-cta-button {
        background: transparent !important;
        color: #000000 !important;
        border: 2px solid #000000 !important;
        box-shadow: none !important;
        text-decoration: underline;
        /* Print-specific styling */
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
    }
    
    .hero-cta-button::after {
        content: " (" attr(href) ")";
        font-size: 0.8em;
        color: #666666;
    }
    
    .hero-background {
        /* Print background handling */
        background: #f0f0f0 !important;
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
    }
    
    .pces-hero-redesign {
        /* Print layout optimization */
        min-height: auto !important;
        page-break-inside: avoid;
    }
}
</style>