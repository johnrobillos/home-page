/**
 * PCES Homepage JavaScript
 * Functionality specific to the homepage/landing page
 * 
 * @package PCES_Homepage
 * @since 1.0.0
 */

(function($) {
    'use strict';

    // Homepage namespace
    window.PCES = window.PCES || {};
    PCES.Home = PCES.Home || {};

    /**
     * Initialize homepage functionality
     */
    PCES.Home.init = function() {
        PCES.Home.setupHeroAnimations();
        PCES.Home.setupServiceCards();
        PCES.Home.setupDifferentiators();
        PCES.Home.setupClientLogos();
        PCES.Home.setupMetricsAnimation();
        PCES.Home.setupScrollEffects();
    };

    /**
     * Hero section animations
     */
    PCES.Home.setupHeroAnimations = function() {
        var $hero = $('.pces-hero');
        if (!$hero.length) return;

        // Animate hero content on load
        $(window).on('load', function() {
            $hero.find('h1').addClass('animate-fade-in-up');
            
            setTimeout(function() {
                $hero.find('.lead').addClass('animate-fade-in-up');
            }, 200);
            
            setTimeout(function() {
                $hero.find('.pces-btn').addClass('animate-fade-in-up');
            }, 400);
        });

        // Parallax effect for hero background
        if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            $(window).on('scroll.debounced', function() {
                var scrolled = $(window).scrollTop();
                var rate = scrolled * -0.5;
                $hero.css('transform', 'translateY(' + rate + 'px)');
            });
        }
    };

    /**
     * Service cards hover effects and interactions
     */
    PCES.Home.setupServiceCards = function() {
        var $serviceCards = $('.pces-service-card');
        if (!$serviceCards.length) return;

        $serviceCards.each(function() {
            var $card = $(this);
            var $image = $card.find('img');

            // Hover effects
            $card.on('mouseenter', function() {
                if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                    $image.css('transform', 'scale(1.1)');
                }
                $card.addClass('hovered');
            });

            $card.on('mouseleave', function() {
                $image.css('transform', 'scale(1)');
                $card.removeClass('hovered');
            });

            // Click tracking
            $card.on('click', function() {
                var serviceName = $card.find('h3').text();
                PCES.Home.trackEvent('service_card_click', {
                    service_name: serviceName
                });
            });
        });

        // Animate cards on scroll
        PCES.Home.animateOnScroll($serviceCards, 'animate-slide-up');
    };

    /**
     * Differentiators section animations
     */
    PCES.Home.setupDifferentiators = function() {
        var $differentiators = $('.pces-differentiator-item');
        if (!$differentiators.length) return;

        // Stagger animation on scroll
        PCES.Home.animateOnScroll($differentiators, 'animate-fade-in-up', 100);

        // Add hover effects
        $differentiators.on('mouseenter', function() {
            $(this).addClass('hovered');
        }).on('mouseleave', function() {
            $(this).removeClass('hovered');
        });
    };

    /**
     * Client logos carousel and effects
     */
    PCES.Home.setupClientLogos = function() {
        var $clientItems = $('.pces-client-item');
        if (!$clientItems.length) return;

        // Animate logos on scroll
        PCES.Home.animateOnScroll($clientItems, 'animate-fade-in', 50);

        // Logo hover effects
        $clientItems.each(function() {
            var $item = $(this);
            var $logo = $item.find('.pces-client-logo');

            $item.on('mouseenter', function() {
                $logo.css('filter', 'grayscale(0%)');
                $item.addClass('hovered');
            });

            $item.on('mouseleave', function() {
                $logo.css('filter', 'grayscale(100%)');
                $item.removeClass('hovered');
            });
        });
    };

    /**
     * Growth metrics animation
     */
    PCES.Home.setupMetricsAnimation = function() {
        var $metricsSection = $('.pces-metrics');
        var $metricCharts = $('.pces-metric-chart');
        
        if (!$metricsSection.length || !$metricCharts.length) return;

        var animated = false;

        // Animate metrics when they come into view
        $(window).on('scroll.debounced', function() {
            if (animated) return;

            if (PCES.utils.isInViewport($metricsSection[0])) {
                animated = true;
                
                $metricCharts.each(function(index) {
                    var $chart = $(this);
                    
                    setTimeout(function() {
                        $chart.addClass('animate-zoom-in');
                        
                        // Animate any numbers if present
                        var $numbers = $chart.find('[data-count]');
                        $numbers.each(function() {
                            PCES.Home.animateNumber($(this));
                        });
                    }, index * 200);
                });
            }
        });
    };

    /**
     * Scroll effects and parallax
     */
    PCES.Home.setupScrollEffects = function() {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        var $sections = $('.pces-section');
        
        $(window).on('scroll.debounced', function() {
            var scrollTop = $(window).scrollTop();
            var windowHeight = $(window).height();

            $sections.each(function() {
                var $section = $(this);
                var sectionTop = $section.offset().top;
                var sectionHeight = $section.outerHeight();
                
                // Calculate if section is in viewport
                if (scrollTop + windowHeight > sectionTop && scrollTop < sectionTop + sectionHeight) {
                    var progress = (scrollTop + windowHeight - sectionTop) / (windowHeight + sectionHeight);
                    progress = Math.max(0, Math.min(1, progress));
                    
                    // Apply subtle parallax to background elements
                    var $bgElements = $section.find('.pces-bg-element');
                    if ($bgElements.length) {
                        var translateY = (progress - 0.5) * 50;
                        $bgElements.css('transform', 'translateY(' + translateY + 'px)');
                    }
                }
            });
        });
    };

    /**
     * Animate elements on scroll
     */
    PCES.Home.animateOnScroll = function($elements, animationClass, staggerDelay) {
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
     * Animate numbers counting up
     */
    PCES.Home.animateNumber = function($element) {
        var target = parseInt($element.data('count'));
        var current = 0;
        var increment = target / 50;
        var duration = 2000;
        var stepTime = duration / 50;

        var timer = setInterval(function() {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            $element.text(PCES.utils.numberWithCommas(Math.floor(current)));
        }, stepTime);
    };

    /**
     * Track events for analytics
     */
    PCES.Home.trackEvent = function(eventName, parameters) {
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
        // Only initialize on homepage
        if ($('body').hasClass('home') || $('.pces-hero').length) {
            try {
                PCES.Home.init();
            } catch (error) {
                PCES.handleError(error, 'homepage initialization');
            }
        }
    });

})(jQuery);

/**
 * CSS animations for homepage
 */
if (typeof document !== 'undefined') {
    var homeStyles = `
        @keyframes animate-fade-in-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes animate-slide-up {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes animate-fade-in {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        @keyframes animate-zoom-in {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        .animate-fade-in-up {
            animation: animate-fade-in-up 0.8s ease-out forwards;
        }
        
        .animate-slide-up {
            animation: animate-slide-up 0.6s ease-out forwards;
        }
        
        .animate-fade-in {
            animation: animate-fade-in 0.6s ease-out forwards;
        }
        
        .animate-zoom-in {
            animation: animate-zoom-in 0.6s ease-out forwards;
        }
        
        .pces-service-card.hovered {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .pces-differentiator-item.hovered {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .pces-client-item.hovered {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        @media (prefers-reduced-motion: reduce) {
            .animate-fade-in-up,
            .animate-slide-up,
            .animate-fade-in,
            .animate-zoom-in {
                animation: none;
                opacity: 1;
                transform: none;
            }
            
            .pces-service-card.hovered,
            .pces-differentiator-item.hovered,
            .pces-client-item.hovered {
                transform: none;
            }
        }
    `;
    
    var styleSheet = document.createElement('style');
    styleSheet.textContent = homeStyles;
    document.head.appendChild(styleSheet);
}