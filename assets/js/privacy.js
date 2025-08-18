/**
 * PCES Privacy Notice Page JavaScript
 * Functionality specific to the Privacy Notice page
 * 
 * @package PCES_Homepage
 * @since 1.0.0
 */

(function($) {
    'use strict';

    // Privacy page namespace
    window.PCES = window.PCES || {};
    PCES.Privacy = PCES.Privacy || {};

    /**
     * Initialize privacy page functionality
     */
    PCES.Privacy.init = function() {
        PCES.Privacy.setupScrollAnimations();
        PCES.Privacy.setupTableOfContents();
        PCES.Privacy.setupReadingProgress();
        PCES.Privacy.setupPrintFunctionality();
        PCES.Privacy.setupAccessibility();
        PCES.Privacy.setupContactLinks();
    };

    /**
     * Scroll animations for privacy page
     */
    PCES.Privacy.setupScrollAnimations = function() {
        // Header animation
        var $headerElements = $('.pces-privacy-header').find('h1, p');
        PCES.Privacy.animateOnScroll($headerElements, 'animate-fade-in-up', 200);

        // Content sections
        var $contentSections = $('.pces-privacy-content h2');
        PCES.Privacy.animateOnScroll($contentSections, 'animate-slide-in-left', 100);

        // Special sections
        var $specialSections = $('.pces-privacy-highlight, .pces-privacy-important, .pces-privacy-note');
        PCES.Privacy.animateOnScroll($specialSections, 'animate-zoom-in', 150);

        // Contact section
        var $contactSection = $('.pces-privacy-contact');
        PCES.Privacy.animateOnScroll($contactSection, 'animate-slide-up');
    };

    /**
     * Create and setup table of contents
     */
    PCES.Privacy.setupTableOfContents = function() {
        var $headings = $('.pces-privacy-content h2, .pces-privacy-content h3');
        
        if ($headings.length < 3) return;

        var tocHtml = '<div class="pces-privacy-toc"><h3>Table of Contents</h3><ul>';
        
        $headings.each(function(index) {
            var $heading = $(this);
            var headingId = 'privacy-section-' + index;
            var headingText = $heading.text();
            var headingLevel = $heading.prop('tagName').toLowerCase();
            
            $heading.attr('id', headingId);
            
            var listClass = headingLevel === 'h3' ? 'toc-subsection' : '';
            tocHtml += '<li class="' + listClass + '"><a href="#' + headingId + '">' + headingText + '</a></li>';
        });
        
        tocHtml += '</ul></div>';
        
        $('.pces-privacy-content').prepend(tocHtml);

        // Setup TOC interactions
        PCES.Privacy.setupTocInteractions();
    };

    /**
     * Setup table of contents interactions
     */
    PCES.Privacy.setupTocInteractions = function() {
        var $tocLinks = $('.pces-privacy-toc a');
        
        // Smooth scrolling for TOC links
        $tocLinks.on('click', function(e) {
            e.preventDefault();
            var target = $(this.getAttribute('href'));
            
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 500);
                
                // Update focus for accessibility
                target.attr('tabindex', '-1').focus();
                
                // Track TOC usage
                PCES.Privacy.trackEvent('privacy_toc_click', {
                    section: target.attr('id')
                });
            }
        });

        // Highlight current section
        $(window).on('scroll.debounced', function() {
            PCES.Privacy.updateActiveTocItem();
        });

        // Collapse/expand TOC on mobile
        if ($(window).width() < 768) {
            var $tocHeader = $('.pces-privacy-toc h3');
            var $tocList = $('.pces-privacy-toc ul');
            
            $tocHeader.css('cursor', 'pointer').on('click', function() {
                $tocList.slideToggle();
                $tocHeader.toggleClass('collapsed');
            });
            
            $tocList.hide();
        }
    };

    /**
     * Setup reading progress indicator
     */
    PCES.Privacy.setupReadingProgress = function() {
        // Create progress bar
        var progressHtml = '<div class="pces-reading-progress"><div class="pces-progress-bar"></div></div>';
        $('body').prepend(progressHtml);

        var $progressBar = $('.pces-progress-bar');
        var $content = $('.pces-privacy-content');
        
        if (!$content.length) return;

        $(window).on('scroll.debounced', function() {
            var scrollTop = $(window).scrollTop();
            var contentTop = $content.offset().top;
            var contentHeight = $content.outerHeight();
            var windowHeight = $(window).height();
            
            var progress = Math.max(0, Math.min(100, 
                ((scrollTop - contentTop + windowHeight) / contentHeight) * 100
            ));
            
            $progressBar.css('width', progress + '%');
        });
    };

    /**
     * Print functionality
     */
    PCES.Privacy.setupPrintFunctionality = function() {
        // Add print button
        var printButton = '<button class="pces-print-btn" title="Print Privacy Notice"><i class="bi bi-printer"></i> Print</button>';
        $('.pces-privacy-header').append(printButton);

        // Print button click
        $(document).on('click', '.pces-print-btn', function() {
            // Track print action
            PCES.Privacy.trackEvent('privacy_print_clicked');
            
            window.print();
        });

        // Add print styles
        PCES.Privacy.addPrintStyles();
    };

    /**
     * Accessibility enhancements
     */
    PCES.Privacy.setupAccessibility = function() {
        // Add skip links for long sections
        var $longSections = $('.pces-privacy-content > *').filter(function() {
            return $(this).height() > 800;
        });

        $longSections.each(function() {
            var $section = $(this);
            var sectionId = 'privacy-skip-' + Math.random().toString(36).substr(2, 9);
            $section.attr('id', sectionId);
            
            var skipLink = '<a href="#' + sectionId + '-end" class="pces-skip-section">Skip this section</a>';
            $section.before(skipLink);
            $section.after('<div id="' + sectionId + '-end"></div>');
        });

        // Improve table accessibility
        $('.pces-data-table').each(function() {
            var $table = $(this);
            
            // Add table caption if missing
            if (!$table.find('caption').length) {
                $table.prepend('<caption>Privacy Policy Data Categories</caption>');
            }
            
            // Add scope attributes to headers
            $table.find('th').attr('scope', 'col');
        });

        // Enhance form accessibility
        $('.pces-privacy-contact form').each(function() {
            var $form = $(this);
            
            // Add fieldset and legend if missing
            if (!$form.find('fieldset').length) {
                $form.wrapInner('<fieldset><legend>Contact Data Protection Officer</legend></fieldset>');
            }
        });
    };

    /**
     * Setup contact links tracking
     */
    PCES.Privacy.setupContactLinks = function() {
        // Track contact link clicks
        $('.pces-privacy-contact a, .pces-privacy-contact-link').on('click', function() {
            var linkType = $(this).attr('href').indexOf('mailto:') === 0 ? 'email' : 'page';
            
            PCES.Privacy.trackEvent('privacy_contact_click', {
                link_type: linkType,
                link_url: $(this).attr('href')
            });
        });

        // Add copy functionality for email addresses
        $('.pces-privacy-contact a[href^="mailto:"]').each(function() {
            var $link = $(this);
            var email = $link.attr('href').replace('mailto:', '');
            
            $link.attr('title', 'Click to copy email address');
            
            $link.on('click', function(e) {
                e.preventDefault();
                PCES.Privacy.copyToClipboard(email);
            });
        });
    };

    /**
     * Update active TOC item
     */
    PCES.Privacy.updateActiveTocItem = function() {
        var scrollTop = $(window).scrollTop();
        var $tocLinks = $('.pces-privacy-toc a');
        var $headings = $('.pces-privacy-content h2, .pces-privacy-content h3');
        
        var currentSection = '';
        
        $headings.each(function() {
            var $heading = $(this);
            var headingTop = $heading.offset().top - 150;
            
            if (scrollTop >= headingTop) {
                currentSection = '#' + $heading.attr('id');
            }
        });
        
        $tocLinks.removeClass('active');
        if (currentSection) {
            $tocLinks.filter('[href="' + currentSection + '"]').addClass('active');
        }
    };

    /**
     * Copy text to clipboard
     */
    PCES.Privacy.copyToClipboard = function(text) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(function() {
                PCES.Privacy.showCopyFeedback('Email address copied to clipboard!');
            }).catch(function() {
                PCES.Privacy.fallbackCopyToClipboard(text);
            });
        } else {
            PCES.Privacy.fallbackCopyToClipboard(text);
        }
    };

    /**
     * Fallback copy to clipboard
     */
    PCES.Privacy.fallbackCopyToClipboard = function(text) {
        var textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.left = '-999999px';
        textArea.style.top = '-999999px';
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            document.execCommand('copy');
            PCES.Privacy.showCopyFeedback('Email address copied to clipboard!');
        } catch (err) {
            PCES.Privacy.showCopyFeedback('Unable to copy. Please select and copy manually.');
        }
        
        document.body.removeChild(textArea);
    };

    /**
     * Show copy feedback
     */
    PCES.Privacy.showCopyFeedback = function(message) {
        var $feedback = $('<div class="pces-copy-feedback">' + message + '</div>');
        $('body').append($feedback);
        
        setTimeout(function() {
            $feedback.addClass('show');
        }, 10);
        
        setTimeout(function() {
            $feedback.removeClass('show');
            setTimeout(function() {
                $feedback.remove();
            }, 300);
        }, 3000);
    };

    /**
     * Add print styles
     */
    PCES.Privacy.addPrintStyles = function() {
        var printStyles = `
            @media print {
                .pces-print-btn,
                .pces-back-to-top,
                .pces-reading-progress,
                .pces-skip-section {
                    display: none !important;
                }
                
                .pces-privacy-toc {
                    page-break-after: always !important;
                }
                
                .pces-privacy-content {
                    box-shadow: none !important;
                    border: 1px solid #ccc !important;
                }
                
                body {
                    font-size: 11pt !important;
                    line-height: 1.4 !important;
                }
                
                h1, h2, h3 {
                    page-break-after: avoid !important;
                }
                
                .pces-data-table {
                    page-break-inside: avoid !important;
                }
                
                .pces-privacy-highlight,
                .pces-privacy-important,
                .pces-privacy-note {
                    page-break-inside: avoid !important;
                    border: 1px solid #ccc !important;
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
    PCES.Privacy.animateOnScroll = function($elements, animationClass, staggerDelay) {
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
    PCES.Privacy.trackEvent = function(eventName, parameters) {
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
        // Only initialize on privacy page
        if ($('body').hasClass('page-privacy') || $('.pces-privacy-page').length) {
            try {
                PCES.Privacy.init();
            } catch (error) {
                PCES.handleError(error, 'privacy page initialization');
            }
        }
    });

})(jQuery);

/**
 * CSS animations and styles for privacy page
 */
if (typeof document !== 'undefined') {
    var privacyStyles = `
        @keyframes animate-slide-in-left {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes animate-zoom-in {
            from {
                opacity: 0;
                transform: scale(0.95);
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
        
        .animate-slide-in-left {
            animation: animate-slide-in-left 0.6s ease-out forwards;
        }
        
        .animate-zoom-in {
            animation: animate-zoom-in 0.5s ease-out forwards;
        }
        
        .animate-slide-up {
            animation: animate-slide-up 0.6s ease-out forwards;
        }
        
        .pces-reading-progress {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: rgba(0, 0, 0, 0.1);
            z-index: 9999;
        }
        
        .pces-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--pces-primary, #007bff) 0%, var(--pces-blue, #0056b3) 100%);
            width: 0%;
            transition: width 0.1s ease;
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
        
        .pces-privacy-toc {
            background: var(--pces-light, #f8f9fa);
            padding: 2rem;
            border-radius: 8px;
            margin-bottom: 3rem;
            border-left: 4px solid var(--pces-primary, #007bff);
            position: sticky;
            top: 2rem;
        }
        
        .pces-privacy-toc h3 {
            margin-top: 0;
            color: var(--pces-primary, #007bff);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .pces-privacy-toc h3.collapsed::after {
            content: '▼';
            transform: rotate(-90deg);
            transition: transform 0.3s ease;
        }
        
        .pces-privacy-toc h3:not(.collapsed)::after {
            content: '▼';
            transition: transform 0.3s ease;
        }
        
        .pces-privacy-toc ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .pces-privacy-toc li {
            margin-bottom: 0.5rem;
        }
        
        .pces-privacy-toc li.toc-subsection {
            margin-left: 1.5rem;
            font-size: 0.9rem;
        }
        
        .pces-privacy-toc a {
            color: var(--pces-secondary, #6c757d);
            text-decoration: none;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            display: block;
            transition: all 0.3s ease;
        }
        
        .pces-privacy-toc a:hover,
        .pces-privacy-toc a.active {
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
        
        .pces-copy-feedback {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--pces-success, #28a745);
            color: #fff;
            padding: 12px 20px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            z-index: 9999;
            opacity: 0;
            transform: translateX(100px);
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .pces-copy-feedback.show {
            opacity: 1;
            transform: translateX(0);
        }
        
        @media (max-width: 767.98px) {
            .pces-print-btn {
                position: static;
                margin: 1rem auto 0 auto;
                display: block;
                width: fit-content;
            }
            
            .pces-privacy-toc {
                padding: 1.5rem;
                position: static;
            }
            
            .pces-privacy-toc h3 {
                cursor: pointer;
            }
            
            .pces-privacy-toc li.toc-subsection {
                margin-left: 1rem;
            }
            
            .pces-copy-feedback {
                top: 10px;
                right: 10px;
                left: 10px;
                text-align: center;
            }
        }
        
        @media (prefers-reduced-motion: reduce) {
            .animate-slide-in-left,
            .animate-zoom-in,
            .animate-slide-up {
                animation: none;
                opacity: 1;
                transform: none;
            }
            
            .pces-progress-bar {
                transition: none;
            }
            
            .pces-print-btn:hover {
                transform: none;
            }
            
            .pces-copy-feedback {
                transition: none;
            }
        }
    `;
    
    var styleSheet = document.createElement('style');
    styleSheet.textContent = privacyStyles;
    document.head.appendChild(styleSheet);
}