/**
 * PCES Carousel Component JavaScript
 * Reusable carousel functionality for image sliders, testimonials, and content carousels
 * 
 * @package PCES_Homepage
 * @since 1.0.0
 */

(function($) {
    'use strict';

    // Carousel namespace
    window.PCES = window.PCES || {};
    PCES.Carousel = PCES.Carousel || {};

    /**
     * Initialize carousel functionality
     */
    PCES.Carousel.init = function() {
        $('.pces-carousel').each(function() {
            var $carousel = $(this);
            PCES.Carousel.setupCarousel($carousel);
        });
    };

    /**
     * Setup individual carousel
     */
    PCES.Carousel.setupCarousel = function($carousel) {
        var options = {
            autoplay: $carousel.data('autoplay') !== false,
            interval: $carousel.data('interval') || 5000,
            pause: $carousel.data('pause') || 'hover',
            wrap: $carousel.data('wrap') !== false,
            keyboard: $carousel.data('keyboard') !== false,
            touch: $carousel.data('touch') !== false
        };

        var carousel = new PCESCarousel($carousel[0], options);
        
        // Store instance for external access
        $carousel.data('pces-carousel', carousel);
    };

    /**
     * Carousel Class
     */
    function PCESCarousel(element, options) {
        this.element = element;
        this.$element = $(element);
        this.options = $.extend({}, PCESCarousel.DEFAULTS, options);
        
        this.currentIndex = 0;
        this.isSliding = false;
        this.interval = null;
        this.touchStartX = 0;
        this.touchEndX = 0;
        
        this.init();
    }

    PCESCarousel.DEFAULTS = {
        autoplay: true,
        interval: 5000,
        pause: 'hover',
        wrap: true,
        keyboard: true,
        touch: true
    };

    PCESCarousel.prototype.init = function() {
        this.$items = this.$element.find('.pces-carousel-item');
        this.$indicators = this.$element.find('.pces-carousel-indicators [data-pces-target]');
        this.$prevBtn = this.$element.find('.pces-carousel-control-prev');
        this.$nextBtn = this.$element.find('.pces-carousel-control-next');
        this.$playPauseBtn = this.$element.find('.pces-carousel-play-pause');
        
        if (this.$items.length === 0) return;
        
        this.setupEvents();
        this.setActiveItem(0);
        
        if (this.options.autoplay) {
            this.startAutoplay();
        }
        
        this.updatePlayPauseButton();
    };

    PCESCarousel.prototype.setupEvents = function() {
        var self = this;
        
        // Navigation buttons
        this.$prevBtn.on('click', function(e) {
            e.preventDefault();
            self.prev();
        });
        
        this.$nextBtn.on('click', function(e) {
            e.preventDefault();
            self.next();
        });
        
        // Indicators
        this.$indicators.on('click', function(e) {
            e.preventDefault();
            var index = $(this).data('pces-slide-to');
            self.goTo(index);
        });
        
        // Play/pause button
        this.$playPauseBtn.on('click', function(e) {
            e.preventDefault();
            self.toggleAutoplay();
        });
        
        // Keyboard navigation
        if (this.options.keyboard) {
            $(document).on('keydown.pces-carousel', function(e) {
                if (!self.$element.is(':visible')) return;
                
                switch(e.keyCode) {
                    case 37: // Left arrow
                        e.preventDefault();
                        self.prev();
                        break;
                    case 39: // Right arrow
                        e.preventDefault();
                        self.next();
                        break;
                    case 32: // Space
                        e.preventDefault();
                        self.toggleAutoplay();
                        break;
                }
            });
        }
        
        // Touch/swipe support
        if (this.options.touch && 'ontouchstart' in window) {
            this.$element.on('touchstart', function(e) {
                self.touchStartX = e.originalEvent.touches[0].clientX;
            });
            
            this.$element.on('touchend', function(e) {
                self.touchEndX = e.originalEvent.changedTouches[0].clientX;
                self.handleSwipe();
            });
        }
        
        // Pause on hover
        if (this.options.pause === 'hover') {
            this.$element.on('mouseenter', function() {
                self.pauseAutoplay();
            });
            
            this.$element.on('mouseleave', function() {
                if (self.options.autoplay) {
                    self.startAutoplay();
                }
            });
        }
        
        // Pause when not visible
        $(document).on('visibilitychange', function() {
            if (document.hidden) {
                self.pauseAutoplay();
            } else if (self.options.autoplay) {
                self.startAutoplay();
            }
        });
    };

    PCESCarousel.prototype.next = function() {
        if (this.isSliding) return;
        
        var nextIndex = this.currentIndex + 1;
        if (nextIndex >= this.$items.length) {
            if (!this.options.wrap) return;
            nextIndex = 0;
        }
        
        this.goTo(nextIndex);
    };

    PCESCarousel.prototype.prev = function() {
        if (this.isSliding) return;
        
        var prevIndex = this.currentIndex - 1;
        if (prevIndex < 0) {
            if (!this.options.wrap) return;
            prevIndex = this.$items.length - 1;
        }
        
        this.goTo(prevIndex);
    };

    PCESCarousel.prototype.goTo = function(index) {
        if (this.isSliding || index === this.currentIndex) return;
        
        var direction = index > this.currentIndex ? 'next' : 'prev';
        this.slide(direction, index);
    };

    PCESCarousel.prototype.slide = function(direction, index) {
        var self = this;
        var $activeItem = this.$items.eq(this.currentIndex);
        var $nextItem = this.$items.eq(index);
        
        this.isSliding = true;
        
        // Trigger slide start event
        var slideEvent = $.Event('pces:slide.start', {
            relatedTarget: $nextItem[0],
            direction: direction,
            from: this.currentIndex,
            to: index
        });
        this.$element.trigger(slideEvent);
        
        if (slideEvent.isDefaultPrevented()) {
            this.isSliding = false;
            return;
        }
        
        // Update indicators
        this.updateIndicators(index);
        
        // Perform slide animation
        if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            // No animation for reduced motion
            $activeItem.removeClass('active');
            $nextItem.addClass('active');
            this.currentIndex = index;
            this.isSliding = false;
            this.onSlideComplete();
        } else {
            // Animated slide
            $nextItem.addClass(direction === 'next' ? 'pces-carousel-item-next' : 'pces-carousel-item-prev');
            
            // Force reflow
            $nextItem[0].offsetHeight;
            
            $activeItem.addClass(direction === 'next' ? 'pces-carousel-item-left' : 'pces-carousel-item-right');
            $nextItem.addClass(direction === 'next' ? 'pces-carousel-item-left' : 'pces-carousel-item-right');
            
            setTimeout(function() {
                $activeItem.removeClass('active pces-carousel-item-left pces-carousel-item-right');
                $nextItem.removeClass('pces-carousel-item-next pces-carousel-item-prev pces-carousel-item-left pces-carousel-item-right').addClass('active');
                
                self.currentIndex = index;
                self.isSliding = false;
                self.onSlideComplete();
            }, 600);
        }
    };

    PCESCarousel.prototype.onSlideComplete = function() {
        // Trigger slide complete event
        var slideEvent = $.Event('pces:slide.complete', {
            relatedTarget: this.$items.eq(this.currentIndex)[0],
            from: this.previousIndex,
            to: this.currentIndex
        });
        this.$element.trigger(slideEvent);
        
        // Update progress bar if exists
        this.updateProgressBar();
    };

    PCESCarousel.prototype.setActiveItem = function(index) {
        this.$items.removeClass('active');
        this.$items.eq(index).addClass('active');
        this.currentIndex = index;
        this.updateIndicators(index);
        this.updateProgressBar();
    };

    PCESCarousel.prototype.updateIndicators = function(index) {
        this.$indicators.removeClass('active').attr('aria-selected', 'false');
        this.$indicators.eq(index).addClass('active').attr('aria-selected', 'true');
    };

    PCESCarousel.prototype.updateProgressBar = function() {
        var $progressBar = this.$element.find('.pces-carousel-progress-bar');
        if ($progressBar.length) {
            var progress = ((this.currentIndex + 1) / this.$items.length) * 100;
            $progressBar.css('width', progress + '%');
        }
    };

    PCESCarousel.prototype.startAutoplay = function() {
        var self = this;
        this.pauseAutoplay();
        
        this.interval = setInterval(function() {
            self.next();
        }, this.options.interval);
        
        this.updatePlayPauseButton();
    };

    PCESCarousel.prototype.pauseAutoplay = function() {
        if (this.interval) {
            clearInterval(this.interval);
            this.interval = null;
        }
        
        this.updatePlayPauseButton();
    };

    PCESCarousel.prototype.toggleAutoplay = function() {
        if (this.interval) {
            this.options.autoplay = false;
            this.pauseAutoplay();
        } else {
            this.options.autoplay = true;
            this.startAutoplay();
        }
    };

    PCESCarousel.prototype.updatePlayPauseButton = function() {
        var $icon = this.$playPauseBtn.find('i');
        if (this.interval) {
            $icon.removeClass('bi-play').addClass('bi-pause');
            this.$playPauseBtn.attr('aria-label', 'Pause slideshow');
        } else {
            $icon.removeClass('bi-pause').addClass('bi-play');
            this.$playPauseBtn.attr('aria-label', 'Play slideshow');
        }
    };

    PCESCarousel.prototype.handleSwipe = function() {
        var swipeThreshold = 50;
        var diff = this.touchStartX - this.touchEndX;
        
        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                this.next();
            } else {
                this.prev();
            }
        }
    };

    PCESCarousel.prototype.destroy = function() {
        this.pauseAutoplay();
        $(document).off('keydown.pces-carousel');
        this.$element.off('.pces-carousel');
        this.$element.removeData('pces-carousel');
    };

    // jQuery plugin
    $.fn.pcesCarousel = function(option) {
        return this.each(function() {
            var $this = $(this);
            var data = $this.data('pces-carousel');
            var options = typeof option === 'object' && option;

            if (!data) {
                $this.data('pces-carousel', (data = new PCESCarousel(this, options)));
            }
            
            if (typeof option === 'string') {
                data[option]();
            }
        });
    };

    // Auto-initialize
    $(document).ready(function() {
        if ($('.pces-carousel').length) {
            try {
                PCES.Carousel.init();
            } catch (error) {
                PCES.handleError(error, 'carousel component initialization');
            }
        }
    });

    // Expose constructor
    PCES.Carousel.Constructor = PCESCarousel;

})(jQuery);

/**
 * CSS animations for carousel component
 */
if (typeof document !== 'undefined') {
    var carouselStyles = `
        .pces-carousel-item-next,
        .pces-carousel-item-prev {
            position: absolute;
            top: 0;
            width: 100%;
        }
        
        .pces-carousel-item-next.pces-carousel-item-left,
        .pces-carousel-item-prev.pces-carousel-item-right {
            transform: translateX(0);
        }
        
        .pces-carousel-item-next,
        .pces-carousel-item.active.pces-carousel-item-right {
            transform: translateX(100%);
        }
        
        .pces-carousel-item-prev,
        .pces-carousel-item.active.pces-carousel-item-left {
            transform: translateX(-100%);
        }
        
        .pces-carousel-control-prev:focus,
        .pces-carousel-control-next:focus {
            outline: 2px solid var(--pces-primary, #007bff);
            outline-offset: 2px;
        }
        
        .pces-carousel-indicators [data-pces-target]:focus {
            outline: 2px solid var(--pces-primary, #007bff);
            outline-offset: 2px;
        }
        
        .pces-carousel-play-pause:focus {
            outline: 2px solid var(--pces-primary, #007bff);
            outline-offset: 2px;
        }
        
        @media (prefers-reduced-motion: reduce) {
            .pces-carousel-item {
                transition: none;
            }
            
            .pces-carousel-item-next,
            .pces-carousel-item-prev,
            .pces-carousel-item.active.pces-carousel-item-left,
            .pces-carousel-item.active.pces-carousel-item-right {
                transform: none;
            }
        }
        
        @media (max-width: 767.98px) {
            .pces-carousel-control-prev,
            .pces-carousel-control-next {
                width: 12%;
            }
            
            .pces-carousel-indicators {
                margin-right: 12%;
                margin-left: 12%;
            }
        }
    `;
    
    var styleSheet = document.createElement('style');
    styleSheet.textContent = carouselStyles;
    document.head.appendChild(styleSheet);
}