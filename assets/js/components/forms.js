/**
 * PCES Forms Component JavaScript
 * Reusable form functionality for validation, submission, and interactions
 * 
 * @package PCES_Homepage
 * @since 1.0.0
 */

(function($) {
    'use strict';

    // Forms namespace
    window.PCES = window.PCES || {};
    PCES.Forms = PCES.Forms || {};

    /**
     * Initialize form functionality
     */
    PCES.Forms.init = function() {
        PCES.Forms.setupValidation();
        PCES.Forms.setupInteractions();
        PCES.Forms.setupAccessibility();
        PCES.Forms.setupFileUploads();
    };

    /**
     * Setup form validation
     */
    PCES.Forms.setupValidation = function() {
        var $forms = $('.pces-form');
        
        $forms.each(function() {
            var $form = $(this);
            var $fields = $form.find('.pces-form-control');
            
            // Real-time validation
            $fields.each(function() {
                var $field = $(this);
                
                // Validate on blur
                $field.on('blur', function() {
                    PCES.Forms.validateField($field);
                });
                
                // Clear validation on focus
                $field.on('focus', function() {
                    PCES.Forms.clearFieldValidation($field);
                });
                
                // Special handling for different field types
                var fieldType = $field.attr('type') || $field.prop('tagName').toLowerCase();
                
                if (fieldType === 'email') {
                    $field.on('input', PCES.utils.debounce(function() {
                        if ($field.val().length > 0) {
                            PCES.Forms.validateField($field);
                        }
                    }, 500));
                }
                
                if (fieldType === 'password') {
                    $field.on('input', function() {
                        PCES.Forms.updatePasswordStrength($field);
                    });
                }
            });
            
            // Form submission validation
            $form.on('submit', function(e) {
                if (!PCES.Forms.validateForm($form)) {
                    e.preventDefault();
                }
            });
        });
    };

    /**
     * Setup form interactions
     */
    PCES.Forms.setupInteractions = function() {
        // Character counters
        $('.pces-form-control[maxlength]').each(function() {
            var $field = $(this);
            var maxLength = $field.attr('maxlength');
            
            PCES.Forms.addCharacterCounter($field, maxLength);
        });

        // Show/hide password toggles
        $('.pces-form-control[type="password"]').each(function() {
            var $field = $(this);
            PCES.Forms.addPasswordToggle($field);
        });

        // Auto-resize textareas
        $('.pces-form-control[data-auto-resize]').each(function() {
            var $textarea = $(this);
            PCES.Forms.setupAutoResize($textarea);
        });

        // Form step navigation
        $('.pces-form-steps').each(function() {
            var $stepsContainer = $(this);
            PCES.Forms.setupStepNavigation($stepsContainer);
        });
    };

    /**
     * Setup accessibility features
     */
    PCES.Forms.setupAccessibility = function() {
        // Add ARIA attributes
        $('.pces-form-control').each(function() {
            var $field = $(this);
            var $label = $('label[for="' + $field.attr('id') + '"]');
            
            if ($label.length) {
                $field.attr('aria-labelledby', $label.attr('id') || 'label-' + $field.attr('id'));
            }
            
            if ($field.prop('required')) {
                $field.attr('aria-required', 'true');
            }
        });

        // Announce validation errors to screen readers
        $(document).on('pces:field-invalid', function(e, $field, message) {
            PCES.announceToScreenReader('Error: ' + message);
        });

        // Keyboard navigation for custom form elements
        $('.pces-form-check-input').on('keydown', function(e) {
            if (e.keyCode === 32) { // Space key
                e.preventDefault();
                $(this).click();
            }
        });
    };

    /**
     * Setup file upload functionality
     */
    PCES.Forms.setupFileUploads = function() {
        $('.pces-form-control[type="file"]').each(function() {
            var $fileInput = $(this);
            PCES.Forms.enhanceFileInput($fileInput);
        });
    };

    /**
     * Validate individual field
     */
    PCES.Forms.validateField = function($field) {
        var value = $field.val().trim();
        var fieldName = $field.attr('name');
        var fieldType = $field.attr('type') || $field.prop('tagName').toLowerCase();
        var isRequired = $field.prop('required');
        var isValid = true;
        var errorMessage = '';

        // Required field validation
        if (isRequired && !value) {
            isValid = false;
            errorMessage = 'This field is required.';
        }
        // Email validation
        else if (fieldType === 'email' && value && !PCES.utils.isValidEmail(value)) {
            isValid = false;
            errorMessage = 'Please enter a valid email address.';
        }
        // Phone validation
        else if (fieldType === 'tel' && value && !/^[\d\s\-\+\(\)]+$/.test(value)) {
            isValid = false;
            errorMessage = 'Please enter a valid phone number.';
        }
        // URL validation
        else if (fieldType === 'url' && value && !PCES.Forms.isValidUrl(value)) {
            isValid = false;
            errorMessage = 'Please enter a valid URL.';
        }
        // Number validation
        else if (fieldType === 'number' && value) {
            var min = $field.attr('min');
            var max = $field.attr('max');
            var numValue = parseFloat(value);
            
            if (isNaN(numValue)) {
                isValid = false;
                errorMessage = 'Please enter a valid number.';
            } else if (min && numValue < parseFloat(min)) {
                isValid = false;
                errorMessage = 'Value must be at least ' + min + '.';
            } else if (max && numValue > parseFloat(max)) {
                isValid = false;
                errorMessage = 'Value must be no more than ' + max + '.';
            }
        }
        // Text length validation
        else if (value) {
            var minLength = $field.attr('minlength');
            var maxLength = $field.attr('maxlength');
            
            if (minLength && value.length < parseInt(minLength)) {
                isValid = false;
                errorMessage = 'Must be at least ' + minLength + ' characters long.';
            } else if (maxLength && value.length > parseInt(maxLength)) {
                isValid = false;
                errorMessage = 'Must be no more than ' + maxLength + ' characters long.';
            }
        }

        // Custom validation patterns
        var pattern = $field.attr('pattern');
        if (pattern && value && !new RegExp(pattern).test(value)) {
            isValid = false;
            errorMessage = $field.attr('title') || 'Please match the requested format.';
        }

        // Apply validation state
        if (isValid) {
            $field.removeClass('is-invalid').addClass('is-valid');
            PCES.Forms.showFieldFeedback($field, '', 'valid');
        } else {
            $field.removeClass('is-valid').addClass('is-invalid');
            PCES.Forms.showFieldFeedback($field, errorMessage, 'invalid');
            $(document).trigger('pces:field-invalid', [$field, errorMessage]);
        }

        return isValid;
    };

    /**
     * Clear field validation
     */
    PCES.Forms.clearFieldValidation = function($field) {
        $field.removeClass('is-valid is-invalid');
        PCES.Forms.showFieldFeedback($field, '', 'clear');
    };

    /**
     * Show field feedback message
     */
    PCES.Forms.showFieldFeedback = function($field, message, type) {
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
    PCES.Forms.validateForm = function($form) {
        var isValid = true;
        var $fields = $form.find('.pces-form-control[required], .pces-form-control[type="email"]');

        $fields.each(function() {
            if (!PCES.Forms.validateField($(this))) {
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
     * Add character counter
     */
    PCES.Forms.addCharacterCounter = function($field, maxLength) {
        var counterId = 'counter-' + ($field.attr('id') || Math.random().toString(36).substr(2, 9));
        var counterHtml = '<div class="pces-char-counter" id="' + counterId + '">0 / ' + maxLength + '</div>';
        
        $field.after(counterHtml);
        $field.attr('aria-describedby', counterId);
        
        var $counter = $('#' + counterId);
        
        $field.on('input', function() {
            var currentLength = $field.val().length;
            $counter.text(currentLength + ' / ' + maxLength);
            
            if (currentLength > maxLength * 0.9) {
                $counter.addClass('warning');
            } else {
                $counter.removeClass('warning');
            }
        });
    };

    /**
     * Add password toggle
     */
    PCES.Forms.addPasswordToggle = function($field) {
        var toggleHtml = '<button type="button" class="pces-password-toggle" aria-label="Show password"><i class="bi bi-eye"></i></button>';
        
        $field.wrap('<div class="pces-password-wrapper"></div>');
        $field.after(toggleHtml);
        
        var $toggle = $field.siblings('.pces-password-toggle');
        
        $toggle.on('click', function() {
            var isPassword = $field.attr('type') === 'password';
            
            $field.attr('type', isPassword ? 'text' : 'password');
            $toggle.find('i').toggleClass('bi-eye bi-eye-slash');
            $toggle.attr('aria-label', isPassword ? 'Hide password' : 'Show password');
        });
    };

    /**
     * Setup auto-resize textarea
     */
    PCES.Forms.setupAutoResize = function($textarea) {
        $textarea.on('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        // Initial resize
        $textarea.trigger('input');
    };

    /**
     * Update password strength indicator
     */
    PCES.Forms.updatePasswordStrength = function($field) {
        var password = $field.val();
        var strength = PCES.Forms.calculatePasswordStrength(password);
        
        var $indicator = $field.siblings('.pces-password-strength');
        if (!$indicator.length) {
            $indicator = $('<div class="pces-password-strength"><div class="strength-bar"></div><div class="strength-text"></div></div>');
            $field.after($indicator);
        }
        
        var $bar = $indicator.find('.strength-bar');
        var $text = $indicator.find('.strength-text');
        
        $bar.removeClass('weak medium strong').addClass(strength.level);
        $bar.css('width', strength.percentage + '%');
        $text.text(strength.text);
    };

    /**
     * Calculate password strength
     */
    PCES.Forms.calculatePasswordStrength = function(password) {
        var score = 0;
        var feedback = [];
        
        if (password.length >= 8) score += 25;
        else feedback.push('at least 8 characters');
        
        if (/[a-z]/.test(password)) score += 25;
        else feedback.push('lowercase letters');
        
        if (/[A-Z]/.test(password)) score += 25;
        else feedback.push('uppercase letters');
        
        if (/[0-9]/.test(password)) score += 25;
        else feedback.push('numbers');
        
        if (/[^A-Za-z0-9]/.test(password)) score += 10;
        
        var level, text;
        if (score < 50) {
            level = 'weak';
            text = 'Weak - Add ' + feedback.slice(0, 2).join(' and ');
        } else if (score < 75) {
            level = 'medium';
            text = 'Medium - Add ' + feedback.join(' and ');
        } else {
            level = 'strong';
            text = 'Strong';
        }
        
        return {
            score: score,
            percentage: Math.min(score, 100),
            level: level,
            text: text
        };
    };

    /**
     * Setup step navigation
     */
    PCES.Forms.setupStepNavigation = function($stepsContainer) {
        var $steps = $stepsContainer.find('.pces-form-step');
        var $nextBtns = $stepsContainer.find('.pces-step-next');
        var $prevBtns = $stepsContainer.find('.pces-step-prev');
        var currentStep = 0;
        
        // Show first step
        $steps.eq(currentStep).addClass('active');
        
        // Next button clicks
        $nextBtns.on('click', function() {
            var $currentStep = $steps.eq(currentStep);
            
            if (PCES.Forms.validateStep($currentStep)) {
                $currentStep.removeClass('active');
                currentStep++;
                $steps.eq(currentStep).addClass('active');
                
                PCES.Forms.updateStepIndicator($stepsContainer, currentStep);
            }
        });
        
        // Previous button clicks
        $prevBtns.on('click', function() {
            $steps.eq(currentStep).removeClass('active');
            currentStep--;
            $steps.eq(currentStep).addClass('active');
            
            PCES.Forms.updateStepIndicator($stepsContainer, currentStep);
        });
    };

    /**
     * Validate form step
     */
    PCES.Forms.validateStep = function($step) {
        var isValid = true;
        var $fields = $step.find('.pces-form-control[required]');
        
        $fields.each(function() {
            if (!PCES.Forms.validateField($(this))) {
                isValid = false;
            }
        });
        
        return isValid;
    };

    /**
     * Update step indicator
     */
    PCES.Forms.updateStepIndicator = function($container, currentStep) {
        var $indicators = $container.find('.pces-step-indicator .step');
        
        $indicators.removeClass('active completed');
        $indicators.eq(currentStep).addClass('active');
        $indicators.slice(0, currentStep).addClass('completed');
    };

    /**
     * Enhance file input
     */
    PCES.Forms.enhanceFileInput = function($fileInput) {
        var $wrapper = $('<div class="pces-file-input-wrapper"></div>');
        var $label = $('<label class="pces-file-input-label">Choose files...</label>');
        var $info = $('<div class="pces-file-input-info">No files selected</div>');
        
        $fileInput.wrap($wrapper);
        $fileInput.after($label).after($info);
        
        $fileInput.on('change', function() {
            var files = this.files;
            var fileNames = [];
            
            for (var i = 0; i < files.length; i++) {
                fileNames.push(files[i].name);
            }
            
            if (fileNames.length > 0) {
                $info.text(fileNames.join(', '));
            } else {
                $info.text('No files selected');
            }
        });
    };

    /**
     * Utility functions
     */
    PCES.Forms.isValidUrl = function(url) {
        try {
            new URL(url);
            return true;
        } catch (e) {
            return false;
        }
    };

    /**
     * Initialize when DOM is ready
     */
    $(document).ready(function() {
        if ($('.pces-form').length) {
            try {
                PCES.Forms.init();
            } catch (error) {
                PCES.handleError(error, 'forms component initialization');
            }
        }
    });

})(jQuery);

/**
 * CSS styles for forms component
 */
if (typeof document !== 'undefined') {
    var formsStyles = `
        .pces-char-counter {
            font-size: 0.8rem;
            color: var(--pces-secondary, #6c757d);
            text-align: right;
            margin-top: 0.25rem;
        }
        
        .pces-char-counter.warning {
            color: var(--pces-warning, #ffc107);
        }
        
        .pces-password-wrapper {
            position: relative;
        }
        
        .pces-password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--pces-secondary, #6c757d);
            padding: 5px;
        }
        
        .pces-password-toggle:hover {
            color: var(--pces-primary, #007bff);
        }
        
        .pces-password-strength {
            margin-top: 0.5rem;
        }
        
        .pces-password-strength .strength-bar {
            height: 4px;
            background: #e9ecef;
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 0.25rem;
        }
        
        .pces-password-strength .strength-bar::before {
            content: '';
            display: block;
            height: 100%;
            width: 0%;
            transition: width 0.3s ease, background-color 0.3s ease;
        }
        
        .pces-password-strength .strength-bar.weak::before {
            background: var(--pces-danger, #dc3545);
        }
        
        .pces-password-strength .strength-bar.medium::before {
            background: var(--pces-warning, #ffc107);
        }
        
        .pces-password-strength .strength-bar.strong::before {
            background: var(--pces-success, #28a745);
        }
        
        .pces-password-strength .strength-text {
            font-size: 0.8rem;
            color: var(--pces-secondary, #6c757d);
        }
        
        .pces-file-input-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        
        .pces-file-input-wrapper input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .pces-file-input-label {
            display: block;
            padding: 0.75rem 1rem;
            background: var(--pces-primary, #007bff);
            color: #fff;
            border-radius: var(--pces-border-radius, 0.375rem);
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s ease;
        }
        
        .pces-file-input-label:hover {
            background: var(--pces-blue, #0056b3);
        }
        
        .pces-file-input-info {
            margin-top: 0.5rem;
            font-size: 0.9rem;
            color: var(--pces-secondary, #6c757d);
        }
        
        .pces-form-steps .pces-form-step {
            display: none;
        }
        
        .pces-form-steps .pces-form-step.active {
            display: block;
        }
        
        .pces-step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }
        
        .pces-step-indicator .step {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 0.5rem;
            font-size: 0.9rem;
            color: var(--pces-secondary, #6c757d);
            transition: all 0.3s ease;
        }
        
        .pces-step-indicator .step.active {
            background: var(--pces-primary, #007bff);
            color: #fff;
        }
        
        .pces-step-indicator .step.completed {
            background: var(--pces-success, #28a745);
            color: #fff;
        }
        
        @media (max-width: 767.98px) {
            .pces-password-toggle {
                right: 5px;
                padding: 3px;
            }
            
            .pces-step-indicator .step {
                width: 25px;
                height: 25px;
                font-size: 0.8rem;
                margin: 0 0.25rem;
            }
        }
    `;
    
    var styleSheet = document.createElement('style');
    styleSheet.textContent = formsStyles;
    document.head.appendChild(styleSheet);
}