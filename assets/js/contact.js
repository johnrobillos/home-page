/**
 * PCES Contact Us Page JavaScript
 * Functionality specific to the Contact Us page including form validation and submission
 * 
 * @package PCES_Homepage
 * @since 1.0.0
 */

(function($) {
    'use strict';

    // Contact page namespace
    window.PCES = window.PCES || {};
    PCES.Contact = PCES.Contact || {};

    /**
     * Initialize contact page functionality
     */
    PCES.Contact.init = function() {
        PCES.Contact.setupFormValidation();
        PCES.Contact.setupFormSubmission();
        PCES.Contact.setupContactInfo();
        PCES.Contact.setupScrollAnimations();
    };

    /**
     * Form validation setup
     */
    PCES.Contact.setupFormValidation = function() {
        var $form = $('.pces-contact-form');
        var $fields = $form.find('.pces-form-control');
        
        if (!$form.length) return;

        // Real-time validation
        $fields.each(function() {
            var $field = $(this);
            var fieldType = $field.attr('type') || $field.prop('tagName').toLowerCase();
            
            // Validate on blur
            $field.on('blur', function() {
                PCES.Contact.validateField($field);
            });
            
            // Clear validation on focus
            $field.on('focus', function() {
                PCES.Contact.clearFieldValidation($field);
            });
            
            // Special handling for email field
            if (fieldType === 'email') {
                $field.on('input', PCES.utils.debounce(function() {
                    if ($field.val().length > 0) {
                        PCES.Contact.validateField($field);
                    }
                }, 500));
            }
        });

        // Form submission validation
        $form.on('submit', function(e) {
            e.preventDefault();
            
            if (PCES.Contact.validateForm($form)) {
                PCES.Contact.submitForm($form);
            }
        });
    };

    /**
     * Form submission handling
     */
    PCES.Contact.setupFormSubmission = function() {
        var $form = $('.pces-contact-form');
        if (!$form.length) return;

        // Add loading state styles
        $form.on('submit', function() {
            var $submitBtn = $form.find('.pces-btn-submit');
            $submitBtn.prop('disabled', true);
            $submitBtn.html('<i class="bi bi-hourglass-split"></i> Sending...');
        });
    };

    /**
     * Contact information interactions
     */
    PCES.Contact.setupContactInfo = function() {
        var $contactItems = $('.pces-contact-item');
        
        // Animate contact items on scroll
        PCES.Contact.animateOnScroll($contactItems, 'animate-fade-in-up', 100);

        // Click to copy functionality
        $contactItems.each(function() {
            var $item = $(this);
            var $content = $item.find('p');
            
            // Add copy functionality for email and phone
            if ($content.find('a[href^="mailto:"], a[href^="tel:"]').length) {
                $item.css('cursor', 'pointer');
                $item.attr('title', 'Click to copy');
                
                $item.on('click', function() {
                    var text = $content.text().trim();
                    PCES.Contact.copyToClipboard(text);
                });
            }
        });
    };

    /**
     * Scroll animations for contact page
     */
    PCES.Contact.setupScrollAnimations = function() {
        // Header animation
        var $headerElements = $('.pces-contact-header').find('h1, p');
        PCES.Contact.animateOnScroll($headerElements, 'animate-fade-in-up', 200);

        // Content sections
        var $contentSections = $('.pces-contact-info, .pces-contact-form-wrapper');
        PCES.Contact.animateOnScroll($contentSections, 'animate-slide-up', 300);
    };

    /**
     * Validate individual field
     */
    PCES.Contact.validateField = function($field) {
        var value = $field.val().trim();
        var fieldName = $field.attr('name');
        var isRequired = $field.prop('required');
        var isValid = true;
        var errorMessage = '';

        // Required field validation
        if (isRequired && !value) {
            isValid = false;
            errorMessage = 'This field is required.';
        }
        // Email validation
        else if (fieldName === 'email' && value && !PCES.utils.isValidEmail(value)) {
            isValid = false;
            errorMessage = 'Please enter a valid email address.';
        }
        // Phone validation (basic)
        else if (fieldName === 'phone' && value && !/^[\d\s\-\+\(\)]+$/.test(value)) {
            isValid = false;
            errorMessage = 'Please enter a valid phone number.';
        }
        // Name validation
        else if (fieldName === 'name' && value && value.length < 2) {
            isValid = false;
            errorMessage = 'Name must be at least 2 characters long.';
        }
        // Message validation
        else if (fieldName === 'message' && value && value.length < 10) {
            isValid = false;
            errorMessage = 'Message must be at least 10 characters long.';
        }

        // Apply validation state
        if (isValid) {
            $field.removeClass('is-invalid').addClass('is-valid');
            PCES.Contact.showFieldFeedback($field, '', 'valid');
        } else {
            $field.removeClass('is-valid').addClass('is-invalid');
            PCES.Contact.showFieldFeedback($field, errorMessage, 'invalid');
        }

        return isValid;
    };

    /**
     * Clear field validation
     */
    PCES.Contact.clearFieldValidation = function($field) {
        $field.removeClass('is-valid is-invalid');
        PCES.Contact.showFieldFeedback($field, '', 'clear');
    };

    /**
     * Show field feedback message
     */
    PCES.Contact.showFieldFeedback = function($field, message, type) {
        var $feedback = $field.siblings('.pces-invalid-feedback, .pces-valid-feedback');
        
        if (!$feedback.length) {
            $feedback = $('<div class="pces-invalid-feedback"></div>');
            $field.after($feedback);
        }

        if (type === 'clear') {
            $feedback.hide().text('');
        } else {
            $feedback.removeClass('pces-invalid-feedback pces-valid-feedback');
            $feedback.addClass(type === 'valid' ? 'pces-valid-feedback' : 'pces-invalid-feedback');
            $feedback.text(message).show();
        }
    };

    /**
     * Validate entire form
     */
    PCES.Contact.validateForm = function($form) {
        var isValid = true;
        var $fields = $form.find('.pces-form-control[required], .pces-form-control[name="email"]');

        $fields.each(function() {
            if (!PCES.Contact.validateField($(this))) {
                isValid = false;
            }
        });

        // Focus first invalid field
        if (!isValid) {
            var $firstInvalid = $form.find('.is-invalid').first();
            if ($firstInvalid.length) {
                $firstInvalid.focus();
                
                // Scroll to field
                $('html, body').animate({
                    scrollTop: $firstInvalid.offset().top - 100
                }, 300);
            }
        }

        return isValid;
    };

    /**
     * Submit form via AJAX
     */
    PCES.Contact.submitForm = function($form) {
        var formData = new FormData($form[0]);
        var $submitBtn = $form.find('.pces-btn-submit');
        var originalBtnText = $submitBtn.html();

        // Add WordPress nonce if available
        if (typeof pces_contact_nonce !== 'undefined') {
            formData.append('pces_contact_nonce', pces_contact_nonce);
        }

        // Add action for WordPress AJAX
        formData.append('action', 'pces_contact_form_submit');

        $.ajax({
            url: pces_ajax_url || '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            timeout: 30000,
            success: function(response) {
                if (response.success) {
                    PCES.Contact.showFormMessage('success', response.data.message || 'Thank you! Your message has been sent successfully.');
                    $form[0].reset();
                    $form.find('.is-valid, .is-invalid').removeClass('is-valid is-invalid');
                    $form.find('.pces-invalid-feedback, .pces-valid-feedback').hide();
                    
                    // Track successful submission
                    PCES.Contact.trackEvent('contact_form_submit', {
                        status: 'success'
                    });
                } else {
                    PCES.Contact.showFormMessage('error', response.data.message || 'Sorry, there was an error sending your message. Please try again.');
                    
                    // Track failed submission
                    PCES.Contact.trackEvent('contact_form_submit', {
                        status: 'error',
                        error: response.data.message
                    });
                }
            },
            error: function(xhr, status, error) {
                var errorMessage = 'Sorry, there was a technical error. Please try again later.';
                
                if (status === 'timeout') {
                    errorMessage = 'The request timed out. Please check your connection and try again.';
                }
                
                PCES.Contact.showFormMessage('error', errorMessage);
                
                // Track technical error
                PCES.Contact.trackEvent('contact_form_submit', {
                    status: 'technical_error',
                    error: error
                });
            },
            complete: function() {
                // Reset button state
                $submitBtn.prop('disabled', false);
                $submitBtn.html(originalBtnText);
            }
        });
    };

    /**
     * Show form message
     */
    PCES.Contact.showFormMessage = function(type, message) {
        var $form = $('.pces-contact-form');
        var $existingMessage = $form.find('.pces-form-message');
        
        // Remove existing message
        $existingMessage.remove();
        
        // Create new message
        var iconClass = type === 'success' ? 'bi-check-circle' : 'bi-exclamation-triangle';
        var messageHtml = `
            <div class="pces-form-message pces-form-message-${type}">
                <i class="bi ${iconClass}"></i>
                ${message}
            </div>
        `;
        
        $form.prepend(messageHtml);
        
        // Scroll to message
        $('html, body').animate({
            scrollTop: $form.offset().top - 100
        }, 300);
        
        // Auto-hide success messages after 5 seconds
        if (type === 'success') {
            setTimeout(function() {
                $('.pces-form-message-success').fadeOut();
            }, 5000);
        }
    };

    /**
     * Copy text to clipboard
     */
    PCES.Contact.copyToClipboard = function(text) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(function() {
                PCES.Contact.showCopyFeedback('Copied to clipboard!');
            }).catch(function() {
                PCES.Contact.fallbackCopyToClipboard(text);
            });
        } else {
            PCES.Contact.fallbackCopyToClipboard(text);
        }
    };

    /**
     * Fallback copy to clipboard
     */
    PCES.Contact.fallbackCopyToClipboard = function(text) {
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
            PCES.Contact.showCopyFeedback('Copied to clipboard!');
        } catch (err) {
            PCES.Contact.showCopyFeedback('Unable to copy. Please select and copy manually.');
        }
        
        document.body.removeChild(textArea);
    };

    /**
     * Show copy feedback
     */
    PCES.Contact.showCopyFeedback = function(message) {
        // Create temporary feedback element
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
        }, 2000);
    };

    /**
     * Animate elements on scroll
     */
    PCES.Contact.animateOnScroll = function($elements, animationClass, staggerDelay) {
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
    PCES.Contact.trackEvent = function(eventName, parameters) {
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
        // Only initialize on contact page
        if ($('body').hasClass('page-contact') || $('.pces-contact-form').length) {
            try {
                PCES.Contact.init();
            } catch (error) {
                PCES.handleError(error, 'contact page initialization');
            }
        }
    });

})(jQuery);

/**
 * CSS animations and styles for contact page
 */
if (typeof document !== 'undefined') {
    var contactStyles = `
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
        
        .animate-slide-up {
            animation: animate-slide-up 0.6s ease-out forwards;
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
        
        .pces-contact-item[title="Click to copy"]:hover {
            background-color: rgba(0, 123, 255, 0.05);
            transform: translateY(-1px);
        }
        
        @media (max-width: 767.98px) {
            .pces-copy-feedback {
                top: 10px;
                right: 10px;
                left: 10px;
                text-align: center;
            }
        }
        
        @media (prefers-reduced-motion: reduce) {
            .animate-slide-up {
                animation: none;
                opacity: 1;
                transform: none;
            }
            
            .pces-copy-feedback {
                transition: none;
            }
            
            .pces-contact-item[title="Click to copy"]:hover {
                transform: none;
            }
        }
    `;
    
    var styleSheet = document.createElement('style');
    styleSheet.textContent = contactStyles;
    document.head.appendChild(styleSheet);
}