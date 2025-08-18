/**
 * PCES Terms of Use Page JavaScript
 * Functionality specific to the Terms of Use page with toggle functionality
 * 
 * @package PCES_Homepage
 * @since 1.0.0
 */

(function($) {
    'use strict';

    // Terms page namespace
    window.PCES = window.PCES || {};
    PCES.Terms = PCES.Terms || {};

    /**
     * Initialize terms page functionality
     */
    PCES.Terms.init = function() {
        PCES.Terms.setupToggleSwitch();
        PCES.Terms.setupScrollAnimations();
        PCES.Terms.setupContentNavigation();
        PCES.Terms.setupPrintFunctionality();
        PCES.Terms.setupAccessibility();
    };

    /**
     * Toggle switch functionality
     */
    PCES.Terms.setupToggleSwitch = function() {
        var $toggleOptions = $('.pces-toggle-option');
        var $togglePanels = $('.pces-toggle-panel');
        
        if (!$toggleOptions.length || !$togglePanels.length) return;

        // Set initial state
        var initialTab = PCES.utils.getUrlParameter('type') || 'employer';
        PCES.Terms.switchToTab(initialTab);

        // Toggle option click events
        $toggleOptions.on('click', function() {
            var $option = $(this);
            var targetTab = $option.data('target');
            
            if (!$option.hasClass('active')) {
                PCES.Terms.switchToTab(targetTab);
                
                // Update URL without page reload
                if (history.pushState) {
                    var newUrl = window.location.pathname + '?type=' + targetTab;
                    history.pushState({type: targetTab}, '', newUrl);
                }
                
                // Track toggle usage
                PCES.Terms.trackEvent('terms_toggle_switch', {
                    from_type: $('.pces-toggle-option.active').data('target'),
                    to_type: targetTab
                });
            }
        });

        // Handle browser back/forward buttons
        window.addEventListener('popstate', function(event) {
            var type = event.state ? event.state.type : 'employer';
            PCES.Terms.switchToTab(type);
        });

        // Keyboard navigation for toggle
        $toggleOptions.on('keydown', function(e) {
            var $current = $(this);
            var $next, $prev;

            switch(e.keyCode) {
                case 37: // Left arrow
                case 38: // Up arrow
                    e.preventDefault();
                    $prev = $current.prev('.pces-toggle-option');
                    if (!$prev.length) {
                        $prev = $('.pces-toggle-option').last();
                    }
                    $prev.focus().click();
                    break;
                case 39: // Right arrow
                case 40: // Down arrow
                    e.preventDefault();
                    $next = $current.next('.pces-toggle-option');
                    if (!$next.length) {
                        $next = $('.pces-toggle-option').first();
                    }
                    $next.focus().click();
                    break;
                case 13: // Enter
                case 32: // Space
                    e.preventDefault();
                    $current.click();
                    break;
            }
        });
    };

    /**
     * Switch to specific tab
     */
    PCES.Terms.switchToTab = function(tabType) {
        var $toggleOptions = $('.pces-toggle-option');
        var $togglePanels = $('.pces-toggle-panel');
        
        // Update toggle buttons
        $toggleOptions.removeClass('active').attr('aria-pressed', 'false');
        $toggleOptions.filter('[data-target="' + tabType + '"]').addClass('active').attr('aria-pressed', 'true');
        
        // Update content panels
        $togglePanels.removeClass('active').attr('aria-hidden', 'true');
        $togglePanels.filter('[data-panel="' + tabType + '"]').addClass('active').attr('aria-hidden', 'false');
        
        // Announce change to screen readers
        var tabName = tabType.charAt(0).toUpperCase() + tabType.slice(1);
        PCES.announceToScreenReader('Switched to ' + tabName + ' terms');
        
        // Scroll to top of content
        var $content = $('.pces-terms-content');
        if ($content.length) {
            $('html, body').animate({
                scrollTop: $content.offset().top - 100
            }, 300);
        }
    };

    /**
     * Scroll animations for terms page
     */
    PCES.Terms.setupScrollAnimations = function() {
        // Header animation
        var $headerElements = $('.pces-terms-header').find('h1, p');
        PCES.Terms.animateOnScroll($headerElements, 'animate-fade-in-up', 200);

        // Toggle animation
        var $toggleContainer = $('.pces-terms-toggle');
        PCES.Terms.animateOnScroll($toggleContainer, 'animate-zoom-in');

        // Content animation
        var $contentContainer = $('.pces-terms-content');
        PCES.Terms.animateOnScroll($contentContainer, 'animate-slide-up');
    };

    /**
     * Content navigation within terms
     */
    PCES.Terms.setupContentNavigation = function() {
        // Create table of contents if there are multiple sections
        var $sections = $('.pces-terms-section h2, .pces-terms-section h3');
        
        if ($sections.length > 3) {
            PCES.Terms.createTableOfContents($sections);
        }

        // Smooth scrolling for internal links
        $(document).on('click', 'a[href^="#"]', function(e) {
            var target = $(this.getAttribute('href'));
            
            if (target.length) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 500);
                
                // Update focus for accessibility
                target.attr('tabindex', '-1').focus();
            }
        });

        // Highlight current section in navigation
        if ($('.pces-terms-toc').length) {
            $(window).on('scroll.debounced', function() {
                PCES.Terms.updateActiveNavItem();
            });
        }
    };

    /**
     * Print functionality
     */
    PCES.Terms.setupPrintFunctionality = function() {
        // Add print button
        var printButton = '<button class="pces-print-btn" title="Print Terms"><i class="bi bi-printer"></i> Print</button>';
        $('.pces-terms-header').append(printButton);

        // Print button click
        $(document).on('click', '.pces-print-btn', function() {
            // Show all content for printing
            $('.pces-toggle-panel').addClass('print-visible');
            
            // Track print action
            PCES.Terms.trackEvent('terms_print_clicked', {
                current_tab: $('.pces-toggle-option.active').data('target')
            });
            
            window.print();
            
            // Hide non-active content after printing
            setTimeout(function() {
                $('.pces-toggle-panel').removeClass('print-visible');
            }, 1000);
        });

        // Print styles
        PCES.Terms.addPrintStyles();
    };

    /**
     * Accessibility enhancements
     */
    PCES.Terms.setupAccessibility = function() {
        // Add ARIA attributes
        $('.pces-toggle-option').attr('role', 'tab');
        $('.pces-toggle-panel').attr('role', 'tabpanel');
        $('.pces-toggle-group').attr('role', 'tablist');

        // Add skip links for long content
        var $longSections = $('.pces-terms-section').filter(function() {
            return $(this).height() > 1000;
        });

        $longSections.each(function() {
            var $section = $(this);
            var sectionId = 'section-' + Math.random().toString(36).substr(2, 9);
            $section.attr('id', sectionId);
            
            var skipLink = '<a href="#' + sectionId + '-end" class="pces-skip-section">Skip this section</a>';
            $section.prepend(skipLink);
            $section.append('<div id="' + sectionId + '-end"></div>');
        });

        // Focus management
        $('.pces-toggle-option').on('focus', function() {
            $(this).addClass('focused');
        }).on('blur', function() {
            $(this).removeClass('focused');
        });
    };

    /**
     * Create table of contents
     */
    PCES.Terms.createTableOfContents = function($sections) {
        var tocHtml = '<div class="pces-terms-toc"><h3>Table of Contents</h3><ul>';
        
        $sections.each(function(index) {
            var $section = $(this);
            var sectionId = 'terms-section-' + index;
            var sectionText = $section.text();
            var sectionLevel = $section.prop('tagName').toLowerCase();
            
            $section.attr('id', sectionId);
            
            var listClass = sectionLevel === 'h3' ? 'toc-subsection' : '';
            tocHtml += '<li class="' + listClass + '"><a href="#' + sectionId + '">' + sectionText + '</a></li>';
        });
        
        tocHtml += '</ul></div>';
        
        $('.pces-terms-content').prepend(tocHtml);
    };

    /**
     * Update active navigation item
     */
    PCES.Terms.updateActiveNavItem = function() {
        var scrollTop = $(window).scrollTop();
        var $tocLinks = $('.pces-terms-toc a');
        var $sections = $('.pces-terms-section h2, .pces-terms-section h3');
        
        var currentSection = '';
        
        $sections.each(function() {
            var $section = $(this);
            var sectionTop = $section.offset().top - 150;
            
            if (scrollTop >= sectionTop) {
                currentSection = '#' + $section.attr('id');
            }
        });
        
        $tocLinks.removeClass('active');
        if (currentSection) {
            $tocLinks.filter('[href="' + currentSection + '"]').addClass('active');
        }
    };

    /**
     * Add print styles
     */
    PCES.Terms.addPrintStyles = function() {
        var printStyles = `
            @media print {
                .pces-terms-toggle,
                .pces-print-btn,
                .pces-back-to-top {
                    display: none !important;
                }
                
                .pces-toggle-panel {
                    display: none !important;
                }
                
                .pces-toggle-panel.active,
                .pces-toggle-panel.print-visible {
                    display: block !important;
                }
                
                .pces-terms-content {
                    box-shadow: none !important;
                    border: 1px solid #ccc !important;
                }
                
                body {
                    font-size: 12pt !important;
                    line-height: 1.4 !important;
                }
                
                h1, h2, h3 {
                    page-break-after: avoid !important;
                }
                
                .pces-terms-toc {
                    page-break-after: always !important;
                }
            }
        `;
        
        var styleSheet = document.createElement('style');
        styleSheet.textContent = printStyles;
        document.head.appendChild(styleSheet);
    };

    /**
     * Animate elements on scroll
     */
    PCES.Terms.animateOnScroll = function($elements, animationClass, staggerDelay) {
        staggerDelay = staggerDelay || 0;
        var animated = [];

        $(window).on('scroll.debounced', function() {
            $elements.each(function(index) {
                var element = this;
                var $element = $(element);
                
                if (animated.indexOf(element) !== -1) return;
                
                if (PCES.utils.isInViewport(element)) {
                    animated.push(element);
                    
                    setTimeout(function() {
                        $element.addClass(animationClass);
                    }, index * staggerDelay);
                }
            });
        });
    };

    /**
     * Track events for analytics
     */
    PCES.Terms.trackEvent = function(eventName, parameters) {
        // Google Analytics 4
        if (typeof gtag !== 'undefined') {
            gtag('event', eventName, parameters);
        }
        
        // Custom analytics
        if (typeof PCES.analytics !== 'undefined') {
            PCES.analytics.track(eventName, parameters);
        }
    };

    /**
     * Initialize when DOM is ready
     */
    $(document).ready(function() {
        // Only initialize on terms page
        if ($('body').hasClass('page-terms') || $('.pces-terms-page').length) {
            try {
                PCES.Terms.init();
            } catch (error) {
                PCES.handleError(error, 'terms page initialization');
            }
        }
    });

})(jQuery);

/**
 * CSS animations and styles for terms page
 */
if (typeof document !== 'undefined') {
    var termsStyles = `
        @keyframes animate-zoom-in {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        @keyframes animate-slide-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-zoom-in {
            animation: animate-zoom-in 0.5s ease-out forwards;
        }
        
        .animate-slide-up {
            animation: animate-slide-up 0.6s ease-out forwards;
        }
        
        .pces-toggle-option.focused {
            outline: 2px solid var(--pces-primary, #007bff);
            outline-offset: 2px;
        }
        
        .pces-print-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: var(--pces-light, #f8f9fa);
            border: 1px solid #dee2e6;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            color: var(--pces-dark, #343a40);
            transition: all 0.3s ease;
        }
        
        .pces-print-btn:hover {
            background: #e9ecef;
            transform: translateY(-1px);
        }
        
        .pces-terms-toc {
            background: var(--pces-light, #f8f9fa);
            padding: 2rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            border-left: 4px solid var(--pces-primary, #007bff);
        }
        
        .pces-terms-toc h3 {
            margin-top: 0;
            color: var(--pces-primary, #007bff);
        }
        
        .pces-terms-toc ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .pces-terms-toc li {
            margin-bottom: 0.5rem;
        }
        
        .pces-terms-toc li.toc-subsection {
            margin-left: 1.5rem;
            font-size: 0.9rem;
        }
        
        .pces-terms-toc a {
            color: var(--pces-secondary, #6c757d);
            text-decoration: none;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            display: block;
            transition: all 0.3s ease;
        }
        
        .pces-terms-toc a:hover,
        .pces-terms-toc a.active {
            background: var(--pces-primary, #007bff);
            color: #fff;
            text-decoration: none;
        }
        
        .pces-skip-section {
            display: inline-block;
            background: var(--pces-info, #17a2b8);
            color: #fff;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.8rem;
            text-decoration: none;
            margin-bottom: 1rem;
        }
        
        .pces-skip-section:hover {
            background: #138496;
            color: #fff;
            text-decoration: none;
        }
        
        @media (max-width: 767.98px) {
            .pces-print-btn {
                position: static;
                margin: 1rem auto 0 auto;
                display: block;
                width: fit-content;
            }
            
            .pces-terms-toc {
                padding: 1.5rem;
            }
            
            .pces-terms-toc li.toc-subsection {
                margin-left: 1rem;
            }
        }
        
        @media (prefers-reduced-motion: reduce) {
            .animate-zoom-in,
            .animate-slide-up {
                animation: none;
                opacity: 1;
                transform: none;
            }
            
            .pces-print-btn:hover {
                transform: none;
            }
        }
    `;
    
    var styleSheet = document.createElement('style');
    styleSheet.textContent = termsStyles;
    document.head.appendChild(styleSheet);
}