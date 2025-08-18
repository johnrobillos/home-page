/**
 * PCES Global JavaScript
 * Site-wide functionality that applies across all pages
 * 
 * @package PCES_Homepage
 * @since 1.0.0
 */

(function($) {
    'use strict';

    // Global PCES object
    window.PCES = window.PCES || {};

    /**
     * Initialize global functionality
     */
    PCES.init = function() {
        PCES.setupSmoothScrolling();
        PCES.setupBackToTop();
        PCES.setupLazyLoading();
        PCES.setupAccessibility();
        PCES.setupPerformanceOptimizations();
    };

    /**
     * Smooth scrolling for anchor links
     */
    PCES.setupSmoothScrolling = function() {
        $('a[href*="#"]:not([href="#"])').on('click', function(e) {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && 
                location.hostname === this.hostname) {
                
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                
                if (target.length) {
                    e.preventDefault();
                    
                    $('html, body').animate({
                        scrollTop: target.offset().top - 80 // Account for fixed header
                    }, 800, 'swing');
                    
                    // Update focus for accessibility
                    target.focus();
                    if (!target.is(':focus')) {
                        target.attr('tabindex', '-1');
                        target.focus();
                    }
                }
            }
        });
    };

    /**
     * Back to top button functionality
     */
    PCES.setupBackToTop = function() {
        // Create back to top button if it doesn't exist
        if (!$('#pces-back-to-top').length) {
            $('body').append('<button id="pces-back-to-top" class="pces-back-to-top" aria-label="Back to top"><i class="bi bi-arrow-up"></i></button>');
        }

        var $backToTop = $('#pces-back-to-top');

        // Show/hide button based on scroll position
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 300) {
                $backToTop.addClass('show');
            } else {
                $backToTop.removeClass('show');
            }
        });

        // Smooth scroll to top
        $backToTop.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, 600);
        });
    };

    /**
     * Lazy loading for images
     */
    PCES.setupLazyLoading = function() {
        // Only if Intersection Observer is supported
        if ('IntersectionObserver' in window) {
            var imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('pces-lazy');
                        img.classList.add('pces-lazy-loaded');
                        imageObserver.unobserve(img);
                    }
                });
            });

            // Observe all lazy images
            $('.pces-lazy').each(function() {
                imageObserver.observe(this);
            });
        } else {
            // Fallback for older browsers
            $('.pces-lazy').each(function() {
                var $img = $(this);
                $img.attr('src', $img.data('src'));
                $img.removeClass('pces-lazy').addClass('pces-lazy-loaded');
            });
        }
    };

    /**
     * Accessibility enhancements
     */
    PCES.setupAccessibility = function() {
        // Skip to content link
        if (!$('#pces-skip-link').length) {
            $('body').prepend('<a href="#main" id="pces-skip-link" class="pces-skip-link">Skip to main content</a>');
        }

        // Focus management for modals and dropdowns
        $(document).on('keydown', function(e) {
            // Escape key closes modals
            if (e.keyCode === 27) {
                $('.pces-modal.show').removeClass('show');
                $('body').removeClass('pces-modal-open');
            }
        });

        // Announce dynamic content changes to screen readers
        PCES.announceToScreenReader = function(message) {
            var $announcement = $('#pces-sr-announcement');
            if (!$announcement.length) {
                $announcement = $('<div id="pces-sr-announcement" class="pces-sr-only" aria-live="polite" aria-atomic="true"></div>');
                $('body').append($announcement);
            }
            $announcement.text(message);
        };
    };

    /**
     * Performance optimizations
     */
    PCES.setupPerformanceOptimizations = function() {
        // Debounce scroll events
        var scrollTimer;
        $(window).on('scroll', function() {
            if (scrollTimer) {
                clearTimeout(scrollTimer);
            }
            scrollTimer = setTimeout(function() {
                $(window).trigger('scroll.debounced');
            }, 16); // ~60fps
        });

        // Preload critical images on hover
        $('a[href]').on('mouseenter', function() {
            var href = $(this).attr('href');
            if (href && href.match(/\.(jpg|jpeg|png|gif|webp)$/i)) {
                var img = new Image();
                img.src = href;
            }
        });

        // Optimize animations for reduced motion preference
        if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            $('*').css({
                'animation-duration': '0.01ms !important',
                'animation-iteration-count': '1 !important',
                'transition-duration': '0.01ms !important'
            });
        }
    };

    /**
     * Utility functions
     */
    PCES.utils = {
        /**
         * Debounce function
         */
        debounce: function(func, wait, immediate) {
            var timeout;
            return function() {
                var context = this, args = arguments;
                var later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                var callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        },

        /**
         * Throttle function
         */
        throttle: function(func, limit) {
            var inThrottle;
            return function() {
                var args = arguments;
                var context = this;
                if (!inThrottle) {
                    func.apply(context, args);
                    inThrottle = true;
                    setTimeout(function() {
                        inThrottle = false;
                    }, limit);
                }
            };
        },

        /**
         * Check if element is in viewport
         */
        isInViewport: function(element) {
            var rect = element.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        },

        /**
         * Get URL parameters
         */
        getUrlParameter: function(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        },

        /**
         * Format number with commas
         */
        numberWithCommas: function(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },

        /**
         * Validate email address
         */
        isValidEmail: function(email) {
            var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
    };

    /**
     * Error handling
     */
    PCES.handleError = function(error, context) {
        console.error('PCES Error in ' + context + ':', error);
        
        // Send error to analytics if available
        if (typeof gtag !== 'undefined') {
            gtag('event', 'exception', {
                'description': error.message || error,
                'fatal': false
            });
        }
    };

    /**
     * Initialize when DOM is ready
     */
    $(document).ready(function() {
        try {
            PCES.init();
        } catch (error) {
            PCES.handleError(error, 'initialization');
        }
    });

    /**
     * Handle window load event
     */
    $(window).on('load', function() {
        // Remove loading states
        $('body').removeClass('pces-loading');
        
        // Trigger custom event
        $(document).trigger('pces:loaded');
    });

    /**
     * Handle window resize with debouncing
     */
    $(window).on('resize', PCES.utils.debounce(function() {
        $(document).trigger('pces:resized');
    }, 250));

})(jQuery);

/**
 * CSS for global JavaScript functionality
 */
if (typeof document !== 'undefined') {
    var globalStyles = `
        .pces-back-to-top {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 50px;
            height: 50px;
            background: var(--pces-primary, #007bff);
            color: #fff;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
        }
        
        .pces-back-to-top.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .pces-back-to-top:hover {
            background: var(--pces-blue, #0056b3);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 123, 255, 0.4);
        }
        
        .pces-skip-link {
            position: absolute;
            top: -40px;
            left: 6px;
            background: var(--pces-primary, #007bff);
            color: #fff;
            padding: 8px;
            text-decoration: none;
            border-radius: 4px;
            z-index: 10000;
            transition: top 0.3s;
        }
        
        .pces-skip-link:focus {
            top: 6px;
        }
        
        .pces-sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
        
        .pces-lazy {
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .pces-lazy-loaded {
            opacity: 1;
        }
        
        @media (max-width: 767.98px) {
            .pces-back-to-top {
                bottom: 1rem;
                right: 1rem;
                width: 45px;
                height: 45px;
            }
        }
        
        @media (prefers-reduced-motion: reduce) {
            .pces-back-to-top,
            .pces-skip-link,
            .pces-lazy {
                transition: none;
            }
        }
    `;
    
    var styleSheet = document.createElement('style');
    styleSheet.textContent = globalStyles;
    document.head.appendChild(styleSheet);
}