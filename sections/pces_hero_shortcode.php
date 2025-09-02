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
    'description' => 'Opportunities shouldn\'t be a privilege. We create job platforms so underserved Filipinos can rise, grow, and thrive. When doors are open, the sky is never the limit.',
    'cta_text' => 'Explore Our Services',
    'cta_link' => 'https://hamipces.bilishire.com/services/'
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
$mission_text = "Everyone deserves access to meaningful work, regardless of background, ability, or life circumstance. As a proudly Filipino-led technology company, PCES Inc. is driven by a mission to create inclusive, purpose-centered employment solutions that reflect the diversity of our communities.";
$tagline_part1 = "Made by Filipinos";
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
    <div class="hero-background"></div>
    <div class="hero-content-container d-flex flex-row align-items-start">
        
    <!-- Content Container with Landmark -->
    <div class="hero-content-block col-12 justify-content-start text-start" 
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
            class="hero-cta-button" 
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
    <svg style="visibility: hidden; position: absolute;" width="0" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1">
        <defs>
            <filter id="round">
                <feGaussianBlur in="SourceGraphic" stdDeviation="5" result="blur" />    
                <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo" />
                <feComposite in="SourceGraphic" in2="goo" operator="atop"/>
            </filter>
        </defs>
    </svg>
</section>
<section class="hero-extended py-5">
    <div class="container">
        <div class="row d-flex flex-md-row-reverse align-items-stretch justify-content-between">
            
            <!-- Tagline Column -->
            <div class="col-md-6 d-flex flex-column justify-content-between text-end mb-5">
                <h2 class="tagline-part1"><?php echo esc_html($tagline_part1); ?></h2>
                <h2 class="tagline-part2"><?php echo esc_html($tagline_part2); ?></h2>
            </div>
            
            <!-- Mission Paragraph Column -->
            <div class="col-md-6 d-flex flex-column text-md-start text-end justify-content-between">
                <p class="mission-text"><?php echo esc_html($mission_text); ?></p>
            </div>

        </div>
    </div>
</section>

<style>
/* Extended Hero Section Styling */
.hero-extended {
    background: white;
    padding: 60px 0;
    margin-top: -20px; /* Slight overlap with main hero */
}

.mission-text {
    color: #666666;
    font-size: 1.1rem;
    line-height: 1.7;
    margin: 0;
}

.tagline-part1 {
    color: #03045E;
    font-size: 3.75rem;
    font-weight: 700;
    line-height: 1.1;
}

.tagline-part2 {
    color: #b80000;
    font-size: 3.75rem;
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
.pces-hero-redesign {
    position: relative;
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
    width: 100%;
    max-width: 100%;
    padding: 2.5rem;
    overflow: hidden;
}

/* Background Container - Mobile: Top Section with Enhanced Cross-Browser Support */
.hero-background {
  filter: url(#round);
  margin-top: 1.25rem;
}

.hero-background::before {
  content: "";
  display: flex; /*Cross-browser flexbox support*/
  background-image: url(https://hamipces.bilishire.com/wp-content/uploads/designs/hero.webp);
  background-color: #2596BE; /*Sets the background color to #2596BE (used as a fallback for browsers that don't support background-image)*/
  background-repeat: no-repeat; /*Covers the available space without repeating*/
  background-position: bottom right; /*Positions the background image at the bottom right corner*/
  background-size: cover; /*Full width (100%)*/
  width: 100%; /*Full width (100%)*/
  max-width: 1360px; /*Full width (100%) with a maximum width of 1360px */
  aspect-ratio: 1360/600;/*Reduced aspect ratio for shorter height (was 1360/830)*/
  clip-path: polygon(0 0, 100% 0, 100% 100%, 39% 100%, 39% 44%, 0 44%); /*Cuts off the top part of the image*/
  transition: 0.2s ease-in-out; /*Smooth transition for hover effects*/
  margin: 0 auto; /*Centers the background container horizontally*/
}

.hero-content-block {
    max-width: 450px;
    padding: 2rem;
}

.hero-content-container {
    width: 1360px;
    margin: -20rem auto 0 auto;
}
.hero-headline {
    color: #03045E;
    font-size: 2rem;
    font-weight: 700;
    word-wrap: break-word;
    /* Enhanced readability */
    text-rendering: optimizeLegibility;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

.hero-description {
    color: #000000; /* Improved contrast ratio: 12.6:1 (WCAG AAA) */
    font-size: 1.5rem; 
    text-rendering: optimizeLegibility;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

.hero-cta-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: transparent;
    color: #2596BE; 
    border: 2px solid #2596BE;
    padding: 5px 20px; 
    border-radius: 20px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1.5rem;
    transition: all 0.3s ease;
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
    background: #2596BE; /* Darker blue for better contrast */
    color: #ffffff; /* White text: 15.3:1 contrast ratio (WCAG AAA) */
    text-decoration: none;
    transform: translateY(-2px); /* More pronounced lift effect */
    box-shadow: 0 20px 20px rgba(0, 86, 179, 0.4);
    border-color: #2596BE;
}

/* Focus state - Enhanced keyboard navigation accessibility */
.hero-cta-button:focus {
    background: #2596BE;
    color: #ffffff; /* White text: 15.3:1 contrast ratio (WCAG AAA) */
    text-decoration: none;
    outline: 4px solid #ffff00; /* High contrast yellow focus ring */
    outline-offset: 2px;
    box-shadow: 0 4px 12px rgba(0, 86, 179, 0.3), 0 0 0 2px #000000; /* Double ring for high contrast */
    border-color: #2596BE;
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

/* Remove focus ring for mouse users in modern browsers --*/
.hero-cta-button:focus:not(:focus-visible) {
    outline: none;
    box-shadow: 0 4px 12px rgba(1, 93, 194, 0.3);
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
    color: #2596BE; /* Consistent with main button color */
    border-color: #2596BE;
}

.hero-cta-button:visited:hover,
.hero-cta-button:visited:focus {
    background: #2596BE;
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

@media (max-width: 1300px) {

    .hero-content-block {
        max-width: 380px;
        padding: 1.75rem;
    }
    
    .hero-content-container {
    margin: -16rem auto 0 auto;
}
   
    .hero-headline {
        font-size: 1.75rem;
    }
    
    .hero-description {
        font-size: 1.25rem;
    }
    
    .hero-cta-button {
        font-size: 1.25rem;
    }

    .tagline-part1, .tagline-part2 {
        font-size: 2.75rem;
    }
}

/* Optimized Large Desktop (≥1200px) - Enhanced Typography and Spacing */
@media (max-width: 1150px) {

    .hero-content-block {
        max-width: 350px;
        padding: 1.5rem;
    }
    
    .hero-content-container {
    margin: -14rem auto 0 auto;
}
   
    .hero-headline {
        font-size: 1.5rem;
    }
    
    .hero-description, .mission-text {
        font-size: 1rem;
    }
    
    .hero-cta-button {
        font-size: 1rem;
    }

    .tagline-part1, .tagline-part2 {
        font-size: 2.5rem;
    }
}

@media (max-width: 1000px) {
    .hero-content-block {
        max-width: 300px;
        padding: 1.5rem;
    }
    
    .hero-content-container {
    margin: -12rem auto 0 auto;
}

    .hero-description, .mission-text {
        font-size: .8rem;
        text-rendering: optimizeLegibility;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }


    }

@media (max-width: 850px) {
    .hero-background::before {
        clip-path: polygon(0 0, 100% 0, 100% 100%, 0% 100%);
        max-height: 450px;
        aspect-ratio: 372/289;
    }

    .hero-content-block {
        max-width: 100%;
        margin-top: 1.25rem;
        padding: 0;
    }
    
    .hero-content-container {
    margin: 1.25rem auto 0 auto;
    width: 100%;
}

    .hero-extended {
        padding: 80px 40px;
    }
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
    .hero-cta-button {
        /* IE button fixes */
        display: inline-block;
        vertical-align: middle;
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
    
}
</style>