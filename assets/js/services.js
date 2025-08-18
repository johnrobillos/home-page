/**
 * PCES Services Page JavaScript
 * Functionality specific to the Services detail page
 * 
 * @package PCES_Homepage
 * @since 1.0.0
 */

(function($) {
    'use strict';

    // Services page namespace
    window.PCES = window.PCES || {};
    PCES.Services = PCES.Services || {};

    /**
     * Initialize services page functionality
     */
    PCES.Services.init = function() {
        PCES.Services.setupServiceCards();
        PCES.Services.setupScrollAnimations();
        PCES.Services.setupFilteringAndSorting();
        PCES.Services.setupStatisticsAnimation();
        PCES.Services.setupCallToAction();
    };

    /**
     * Service platform cards interactions
     */
    PCES.Services.setupServiceCards = function() {
        var $serviceCards = $('.pces-service-platform');
        if (!$serviceCards.length) return;

        // Animate service cards on scroll
        PCES.Services.animateOnScroll($serviceCards, 'animate-fade-in-up', 150);

        $serviceCards.each(function() {
            var $card = $(this);
            var $image = $card.find('.pces-service-image img');
            var $visitBtn = $card.find('.pces-visit-site-btn');
            var $learnMoreBtn = $card.find('.pces-learn-more-btn');

            // Hover effects
            $card.on('mouseenter', function() {
                if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                    $image.css('transform', 'scale(1.05)');
                }
                $card.addClass('hovered');
            });

            $card.on('mouseleave', function() {
                $image.css('transform', 'scale(1)');
                $card.removeClass('hovered');
            });

            // Track visit site clicks
            $visitBtn.on('click', function() {
                var serviceName = $card.find('.pces-service-title').text();
                var serviceUrl = $visitBtn.attr('href');
                
                PCES.Services.trackEvent('service_visit_click', {
                    service_name: serviceName,
                    service_url: serviceUrl
                });
            });

            // Track learn more clicks
            $learnMoreBtn.on('click', function() {
                var serviceName = $card.find('.pces-service-title').text();
                
                PCES.Services.trackEvent('service_learn_more_click', {
                    service_name: serviceName
                });
                
                // Show more details modal or expand card
                PCES.Services.showServiceDetails($card);
            });
        });
    };

    /**
     * Scroll animations for services page
     */
    PCES.Services.setupScrollAnimations = function() {
        // Header animation
        var $headerElements = $('.pces-services-header').find('h1, p');
        PCES.Services.animateOnScroll($headerElements, 'animate-fade-in-up', 200);

        // Statistics section
        var $statsElements = $('.pces-services-stats').find('.pces-stat-item');
        PCES.Services.animateOnScroll($statsElements, 'animate-zoom-in', 100);

        // Call to action
        var $ctaElements = $('.pces-services-cta').find('h2, p, .pces-btn');
        PCES.Services.animateOnScroll($ctaElements, 'animate-fade-in-up', 150);
    };

    /**
     * Service filtering and sorting functionality
     */
    PCES.Services.setupFilteringAndSorting = function() {
        // Add filter controls if there are many services
        var $serviceCards = $('.pces-service-platform');
        if ($serviceCards.length <= 4) return;

        PCES.Services.createFilterControls();
        PCES.Services.setupFilterEvents();
    };

    /**
     * Statistics animation
     */
    PCES.Services.setupStatisticsAnimation = function() {
        var $statsSection = $('.pces-services-stats');
        var $statNumbers = $('.pces-stat-number');
        
        if (!$statsSection.length || !$statNumbers.length) return;

        var animated = false;

        $(window).on('scroll.debounced', function() {
            if (animated) return;

            if (PCES.utils.isInViewport($statsSection[0])) {
                animated = true;
                
                $statNumbers.each(function(index) {
                    var $stat = $(this);
                    
                    setTimeout(function() {
                        PCES.Services.animateStatNumber($stat);
                    }, index * 200);
                });
            }
        });
    };

    /**
     * Call to action interactions
     */
    PCES.Services.setupCallToAction = function() {
        var $ctaBtn = $('.pces-services-cta .pces-btn');
        
        $ctaBtn.on('click', function() {
            PCES.Services.trackEvent('services_cta_click', {
                cta_text: $ctaBtn.text(),
                cta_url: $ctaBtn.attr('href')
            });
        });
    };

    /**
     * Show service details modal
     */
    PCES.Services.showServiceDetails = function($card) {
        var serviceName = $card.find('.pces-service-title').text();
        var serviceDescription = $card.find('.pces-service-description').text();
        var serviceFeatures = [];
        
        $card.find('.pces-service-features li').each(function() {
            serviceFeatures.push($(this).text());
        });

        var modalHtml = `
            <div class="pces-service-modal" role="dialog" aria-modal="true" aria-labelledby="service-modal-title">
                <div class="pces-modal-overlay"></div>
                <div class="pces-modal-content">
                    <div class="pces-modal-header">
                        <h2 id="service-modal-title">${serviceName}</h2>
                        <button class="pces-modal-close" aria-label="Close modal">&times;</button>
                    </div>
                    <div class="pces-modal-body">
                        <p>${serviceDescription}</p>
                        ${serviceFeatures.length ? `
                            <h3>Key Features:</h3>
                            <ul>
                                ${serviceFeatures.map(feature => `<li>${feature}</li>`).join('')}
                            </ul>
                        ` : ''}
                    </div>
                    <div class="pces-modal-footer">
                        <a href="${$card.find('.pces-visit-site-btn').attr('href')}" class="pces-btn pces-btn-primary" target="_blank">
                            Visit ${serviceName} <i class="bi bi-arrow-up-right"></i>
                        </a>
                        <button class="pces-btn pces-btn-secondary pces-modal-close">Close</button>
                    </div>
                </div>
            </div>
        `;

        $('body').append(modalHtml);
        $('.pces-service-modal').addClass('show');
        $('body').addClass('pces-modal-open');

        // Close modal events
        $('.pces-modal-close, .pces-modal-overlay').on('click', function() {
            PCES.Services.closeServiceModal();
        });

        // Close on escape key
        $(document).on('keydown.serviceModal', function(e) {
            if (e.keyCode === 27) {
                PCES.Services.closeServiceModal();
            }
        });
    };

    /**
     * Close service details modal
     */
    PCES.Services.closeServiceModal = function() {
        $('.pces-service-modal').removeClass('show');
        $('body').removeClass('pces-modal-open');
        
        setTimeout(function() {
            $('.pces-service-modal').remove();
        }, 300);
        
        $(document).off('keydown.serviceModal');
    };

    /**
     * Create filter controls
     */
    PCES.Services.createFilterControls = function() {
        var filterHtml = `
            <div class="pces-services-filters">
                <div class="pces-filter-group">
                    <label for="service-category">Filter by Category:</label>
                    <select id="service-category" class="pces-form-control">
                        <option value="all">All Services</option>
                        <option value="recruitment">Recruitment</option>
                        <option value="training">Training</option>
                        <option value="accessibility">Accessibility</option>
                    </select>
                </div>
                <div class="pces-sort-group">
                    <label for="service-sort">Sort by:</label>
                    <select id="service-sort" class="pces-form-control">
                        <option value="default">Default Order</option>
                        <option value="name">Name (A-Z)</option>
                        <option value="name-desc">Name (Z-A)</option>
                    </select>
                </div>
            </div>
        `;

        $('.pces-services-header').after(filterHtml);
    };

    /**
     * Setup filter events
     */
    PCES.Services.setupFilterEvents = function() {
        var $categoryFilter = $('#service-category');
        var $sortFilter = $('#service-sort');

        $categoryFilter.on('change', function() {
            PCES.Services.filterServices();
        });

        $sortFilter.on('change', function() {
            PCES.Services.sortServices();
        });
    };

    /**
     * Filter services by category
     */
    PCES.Services.filterServices = function() {
        var selectedCategory = $('#service-category').val();
        var $serviceCards = $('.pces-service-platform');

        $serviceCards.each(function() {
            var $card = $(this);
            var cardCategory = $card.data('category') || 'recruitment';

            if (selectedCategory === 'all' || cardCategory === selectedCategory) {
                $card.show().addClass('animate-fade-in');
            } else {
                $card.hide().removeClass('animate-fade-in');
            }
        });

        // Track filter usage
        PCES.Services.trackEvent('services_filter_used', {
            filter_type: 'category',
            filter_value: selectedCategory
        });
    };

    /**
     * Sort services
     */
    PCES.Services.sortServices = function() {
        var sortBy = $('#service-sort').val();
        var $servicesGrid = $('.pces-services-grid');
        var $serviceCards = $('.pces-service-platform');

        var sortedCards = $serviceCards.sort(function(a, b) {
            var aName = $(a).find('.pces-service-title').text();
            var bName = $(b).find('.pces-service-title').text();

            switch (sortBy) {
                case 'name':
                    return aName.localeCompare(bName);
                case 'name-desc':
                    return bName.localeCompare(aName);
                default:
                    return 0;
            }
        });

        $servicesGrid.append(sortedCards);

        // Track sort usage
        PCES.Services.trackEvent('services_sort_used', {
            sort_type: sortBy
        });
    };

    /**
     * Animate statistic numbers
     */
    PCES.Services.animateStatNumber = function($stat) {
        var targetText = $stat.text();
        var targetNumber = parseInt(targetText.replace(/[^\d]/g, ''));
        
        if (isNaN(targetNumber)) return;

        var current = 0;
        var increment = targetNumber / 60;
        var duration = 2000;
        var stepTime = duration / 60;
        var suffix = targetText.replace(/[\d,]/g, '');

        var timer = setInterval(function() {
            current += increment;
            if (current >= targetNumber) {
                current = targetNumber;
                clearInterval(timer);
            }
            $stat.text(PCES.utils.numberWithCommas(Math.floor(current)) + suffix);
        }, stepTime);
    };

    /**
     * Animate elements on scroll
     */
    PCES.Services.animateOnScroll = function($elements, animationClass, staggerDelay) {
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
    PCES.Services.trackEvent = function(eventName, parameters) {
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
        // Only initialize on services page
        if ($('body').hasClass('page-services') || $('.pces-services-page').length) {
            try {
                PCES.Services.init();
            } catch (error) {
                PCES.handleError(error, 'services page initialization');
            }
        }
    });

})(jQuery);

/**
 * CSS animations and styles for services page
 */
if (typeof document !== 'undefined') {
    var servicesStyles = `
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
        
        .animate-zoom-in {
            animation: animate-zoom-in 0.6s ease-out forwards;
        }
        
        .pces-service-platform.hovered {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }
        
        .pces-services-filters {
            display: flex;
            gap: 2rem;
            justify-content: center;
            align-items: end;
            margin: 2rem 0;
            padding: 2rem;
            background: var(--pces-light, #f8f9fa);
            border-radius: 12px;
        }
        
        .pces-filter-group,
        .pces-sort-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .pces-filter-group label,
        .pces-sort-group label {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--pces-dark, #343a40);
        }
        
        .pces-service-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .pces-service-modal.show {
            opacity: 1;
            visibility: visible;
        }
        
        .pces-modal-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }
        
        .pces-modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .pces-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2rem 2rem 1rem 2rem;
            border-bottom: 1px solid #e9ecef;
        }
        
        .pces-modal-header h2 {
            margin: 0;
            color: var(--pces-primary, #007bff);
        }
        
        .pces-modal-close {
            background: none;
            border: none;
            font-size: 2rem;
            cursor: pointer;
            color: var(--pces-secondary, #6c757d);
            padding: 0;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        
        .pces-modal-close:hover {
            background: var(--pces-light, #f8f9fa);
            color: var(--pces-dark, #343a40);
        }
        
        .pces-modal-body {
            padding: 2rem;
        }
        
        .pces-modal-body h3 {
            color: var(--pces-dark, #343a40);
            margin-top: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .pces-modal-body ul {
            padding-left: 1.5rem;
        }
        
        .pces-modal-body li {
            margin-bottom: 0.5rem;
            line-height: 1.6;
        }
        
        .pces-modal-footer {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            padding: 1rem 2rem 2rem 2rem;
            border-top: 1px solid #e9ecef;
        }
        
        @media (max-width: 767.98px) {
            .pces-services-filters {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .pces-modal-content {
                width: 95%;
                max-height: 90vh;
            }
            
            .pces-modal-header,
            .pces-modal-body,
            .pces-modal-footer {
                padding: 1.5rem;
            }
            
            .pces-modal-footer {
                flex-direction: column;
                gap: 0.75rem;
            }
        }
        
        @media (prefers-reduced-motion: reduce) {
            .animate-zoom-in {
                animation: none;
                opacity: 1;
                transform: none;
            }
            
            .pces-service-platform.hovered {
                transform: none;
            }
            
            .pces-service-modal {
                transition: none;
            }
        }
    `;
    
    var styleSheet = document.createElement('style');
    styleSheet.textContent = servicesStyles;
    document.head.appendChild(styleSheet);
}