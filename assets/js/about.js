/**
 * PCES About Us Page JavaScript
 * Functionality specific to the About Us page
 * 
 * @package PCES_Homepage
 * @since 1.0.0
 */

(function($) {
    'use strict';

    // About page namespace
    window.PCES = window.PCES || {};
    PCES.About = PCES.About || {};

    /**
     * Initialize about page functionality
     */
    PCES.About.init = function() {
        PCES.About.setupTeamSection();
        PCES.About.setupPartnersCarousel();
        PCES.About.setupScrollAnimations();
        PCES.About.setupImageLightbox();
        PCES.About.setupCounterAnimations();
    };

    /**
     * Team section interactions
     */
    PCES.About.setupTeamSection = function() {
        var $teamMembers = $('.pces-team-member');
        if (!$teamMembers.length) return;

        // Animate team members on scroll
        PCES.About.animateOnScroll($teamMembers, 'animate-fade-in-up', 150);

        // Team member hover effects
        $teamMembers.each(function() {
            var $member = $(this);
            var $image = $member.find('img');

            $member.on('mouseenter', function() {
                if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                    $image.css('transform', 'scale(1.05)');
                }
                $member.addClass('hovered');
            });

            $member.on('mouseleave', function() {
                $image.css('transform', 'scale(1)');
                $member.removeClass('hovered');
            });

            // Click to expand team member info (if needed)
            $member.on('click', function() {
                var memberName = $member.find('h3').text();
                PCES.About.trackEvent('team_member_click', {
                    member_name: memberName
                });
            });
        });

        // Organization tree animations
        var $orgTree = $('.pces-org-tree');
        if ($orgTree.length) {
            PCES.About.animateOrgTree($orgTree);
        }
    };

    /**
     * Partners carousel functionality
     */
    PCES.About.setupPartnersCarousel = function() {
        var $partnersGrid = $('.pces-partners-grid');
        var $partnerCards = $('.pces-partner-card');
        
        if (!$partnerCards.length) return;

        // Animate partner cards on scroll
        PCES.About.animateOnScroll($partnerCards, 'animate-slide-up', 100);

        // Partner card interactions
        $partnerCards.each(function() {
            var $card = $(this);
            var $logo = $card.find('.pces-partner-logo');
            var $learnMoreBtn = $card.find('.pces-btn');

            // Hover effects
            $card.on('mouseenter', function() {
                if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                    $logo.css('transform', 'scale(1.1)');
                }
                $card.addClass('hovered');
            });

            $card.on('mouseleave', function() {
                $logo.css('transform', 'scale(1)');
                $card.removeClass('hovered');
            });

            // Track learn more clicks
            $learnMoreBtn.on('click', function() {
                var partnerName = $card.find('h3').text();
                PCES.About.trackEvent('partner_learn_more_click', {
                    partner_name: partnerName
                });
            });
        });

        // Auto-rotate partners if there are many
        if ($partnerCards.length > 6) {
            PCES.About.setupPartnerRotation($partnerCards);
        }
    };

    /**
     * Scroll animations for about page sections
     */
    PCES.About.setupScrollAnimations = function() {
        // Hero section animation
        var $heroElements = $('.pces-about-hero').find('h1, p, img');
        PCES.About.animateOnScroll($heroElements, 'animate-fade-in-up', 200);

        // Company info section
        var $companyElements = $('.pces-about-company').find('.pces-company-text, .pces-company-image');
        PCES.About.animateOnScroll($companyElements, 'animate-slide-in-left');

        // Mission and vision
        var $missionItems = $('.pces-mission-item');
        PCES.About.animateOnScroll($missionItems, 'animate-fade-in-up', 300);

        // DPO section
        var $dpoElements = $('.pces-about-dpo').find('.pces-dpo-image, .pces-dpo-text');
        PCES.About.animateOnScroll($dpoElements, 'animate-slide-in-right');
    };

    /**
     * Image lightbox functionality
     */
    PCES.About.setupImageLightbox = function() {
        var $images = $('.pces-about-hero img, .pces-company-image img, .pces-dpo-image img');
        
        $images.each(function() {
            var $img = $(this);
            
            // Make images clickable for lightbox
            $img.css('cursor', 'pointer');
            
            $img.on('click', function() {
                var imgSrc = $img.attr('src');
                var imgAlt = $img.attr('alt') || 'Image';
                
                PCES.About.openLightbox(imgSrc, imgAlt);
            });
        });
    };

    /**
     * Counter animations for statistics
     */
    PCES.About.setupCounterAnimations = function() {
        var $counters = $('[data-counter]');
        if (!$counters.length) return;

        var animated = [];

        $(window).on('scroll.debounced', function() {
            $counters.each(function() {
                var counter = this;
                var $counter = $(counter);
                
                if (animated.indexOf(counter) !== -1) return;
                
                if (PCES.utils.isInViewport(counter)) {
                    animated.push(counter);
                    PCES.About.animateCounter($counter);
                }
            });
        });
    };

    /**
     * Animate organization tree
     */
    PCES.About.animateOrgTree = function($orgTree) {
        var $levels = $orgTree.find('.pces-org-level');
        
        PCES.About.animateOnScroll($levels, 'animate-org-level', 400);
    };

    /**
     * Setup partner rotation
     */
    PCES.About.setupPartnerRotation = function($partnerCards) {
        var currentIndex = 0;
        var visibleCount = 6;
        var rotationInterval = 5000; // 5 seconds

        // Hide excess partners initially
        $partnerCards.slice(visibleCount).hide();

        setInterval(function() {
            // Fade out current visible partners
            $partnerCards.slice(currentIndex, currentIndex + visibleCount).fadeOut(500, function() {
                // Calculate next set
                currentIndex = (currentIndex + visibleCount) % $partnerCards.length;
                
                // Fade in next set
                $partnerCards.slice(currentIndex, currentIndex + visibleCount).fadeIn(500);
            });
        }, rotationInterval);
    };

    /**
     * Open image lightbox
     */
    PCES.About.openLightbox = function(imgSrc, imgAlt) {
        var lightboxHtml = `
            <div class="pces-lightbox" role="dialog" aria-modal="true" aria-labelledby="lightbox-title">
                <div class="pces-lightbox-overlay"></div>
                <div class="pces-lightbox-content">
                    <button class="pces-lightbox-close" aria-label="Close lightbox">&times;</button>
                    <img src="${imgSrc}" alt="${imgAlt}" id="lightbox-title">
                </div>
            </div>
        `;
        
        $('body').append(lightboxHtml);
        $('.pces-lightbox').addClass('show');
        $('body').addClass('pces-modal-open');

        // Close lightbox events
        $('.pces-lightbox-close, .pces-lightbox-overlay').on('click', function() {
            PCES.About.closeLightbox();
        });

        // Close on escape key
        $(document).on('keydown.lightbox', function(e) {
            if (e.keyCode === 27) {
                PCES.About.closeLightbox();
            }
        });
    };

    /**
     * Close image lightbox
     */
    PCES.About.closeLightbox = function() {
        $('.pces-lightbox').removeClass('show');
        $('body').removeClass('pces-modal-open');
        
        setTimeout(function() {
            $('.pces-lightbox').remove();
        }, 300);
        
        $(document).off('keydown.lightbox');
    };

    /**
     * Animate counter numbers
     */
    PCES.About.animateCounter = function($counter) {
        var target = parseInt($counter.data('counter'));
        var current = 0;
        var increment = target / 60;
        var duration = 2000;
        var stepTime = duration / 60;

        var timer = setInterval(function() {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            $counter.text(Math.floor(current));
        }, stepTime);
    };

    /**
     * Animate elements on scroll
     */
    PCES.About.animateOnScroll = function($elements, animationClass, staggerDelay) {
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
    PCES.About.trackEvent = function(eventName, parameters) {
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
        // Only initialize on about page
        if ($('body').hasClass('page-about') || $('.pces-about-hero').length) {
            try {
                PCES.About.init();
            } catch (error) {
                PCES.handleError(error, 'about page initialization');
            }
        }
    });

})(jQuery);

/**
 * CSS animations for about page
 */
if (typeof document !== 'undefined') {
    var aboutStyles = `
        @keyframes animate-slide-in-left {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes animate-slide-in-right {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes animate-org-level {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        .animate-slide-in-left {
            animation: animate-slide-in-left 0.8s ease-out forwards;
        }
        
        .animate-slide-in-right {
            animation: animate-slide-in-right 0.8s ease-out forwards;
        }
        
        .animate-org-level {
            animation: animate-org-level 0.6s ease-out forwards;
        }
        
        .pces-team-member.hovered {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .pces-partner-card.hovered {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .pces-lightbox {
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
        
        .pces-lightbox.show {
            opacity: 1;
            visibility: visible;
        }
        
        .pces-lightbox-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(4px);
        }
        
        .pces-lightbox-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 90%;
            max-height: 90%;
        }
        
        .pces-lightbox-content img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 8px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        
        .pces-lightbox-close {
            position: absolute;
            top: -40px;
            right: 0;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            font-size: 24px;
            cursor: pointer;
            color: #333;
            transition: all 0.3s ease;
        }
        
        .pces-lightbox-close:hover {
            background: #fff;
            transform: scale(1.1);
        }
        
        @media (max-width: 767.98px) {
            .pces-lightbox-content {
                max-width: 95%;
                max-height: 95%;
            }
            
            .pces-lightbox-close {
                top: -30px;
                width: 30px;
                height: 30px;
                font-size: 18px;
            }
        }
        
        @media (prefers-reduced-motion: reduce) {
            .animate-slide-in-left,
            .animate-slide-in-right,
            .animate-org-level {
                animation: none;
                opacity: 1;
                transform: none;
            }
            
            .pces-team-member.hovered,
            .pces-partner-card.hovered {
                transform: none;
            }
            
            .pces-lightbox {
                transition: none;
            }
        }
    `;
    
    var styleSheet = document.createElement('style');
    styleSheet.textContent = aboutStyles;
    document.head.appendChild(styleSheet);
}