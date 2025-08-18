/**
 * PCES Toggle Component JavaScript
 * Reusable toggle functionality for switches, tabs, and toggle buttons
 * 
 * @package PCES_Homepage
 * @since 1.0.0
 */

(function($) {
    'use strict';

    // Toggle namespace
    window.PCES = window.PCES || {};
    PCES.Toggle = PCES.Toggle || {};

    /**
     * Initialize toggle functionality
     */
    PCES.Toggle.init = function() {
        PCES.Toggle.setupToggleGroups();
        PCES.Toggle.setupToggleTabs();
        PCES.Toggle.setupTogglePills();
        PCES.Toggle.setupToggleSwitches();
        PCES.Toggle.setupAccordionToggles();
    };

    /**
     * Setup toggle groups (radio-like behavior)
     */
    PCES.Toggle.setupToggleGroups = function() {
        $('.pces-toggle-group').each(function() {
            var $group = $(this);
            var $options = $group.find('.pces-toggle-option');
            
            $options.on('click', function() {
                var $option = $(this);
                var targetPanel = $option.data('target');
                
                if (!$option.hasClass('active')) {
                    // Deactivate all options in group
                    $options.removeClass('active').attr('aria-pressed', 'false');
                    
                    // Activate clicked option
                    $option.addClass('active').attr('aria-pressed', 'true');
                    
                    // Show/hide panels
                    $group.find('.pces-toggle-panel').removeClass('active').attr('aria-hidden', 'true');
                    $group.find('[data-panel="' + targetPanel + '"]').addClass('active').attr('aria-hidden', 'false');
                    
                    // Trigger custom event
                    $group.trigger('pces:toggle-changed', [targetPanel, $option]);
                    
                    // Track toggle usage
                    PCES.Toggle.trackEvent('toggle_group_switch', {
                        group_id: $group.attr('id') || 'unnamed',
                        target_panel: targetPanel
                    });
                }
            });
            
            // Keyboard navigation
            $options.on('keydown', function(e) {
                var $current = $(this);
                var $next, $prev;
                
                switch(e.keyCode) {
                    case 37: // Left arrow
                    case 38: // Up arrow
                        e.preventDefault();
                        $prev = $current.prev('.pces-toggle-option');
                        if (!$prev.length) {
                            $prev = $options.last();
                        }
                        $prev.focus().click();
                        break;
                    case 39: // Right arrow
                    case 40: // Down arrow
                        e.preventDefault();
                        $next = $current.next('.pces-toggle-option');
                        if (!$next.length) {
                            $next = $options.first();
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
        });
    };

    /**
     * Setup toggle tabs
     */
    PCES.Toggle.setupToggleTabs = function() {
        $('.pces-toggle-tabs').each(function() {
            var $tabContainer = $(this);
            var $tabs = $tabContainer.find('.pces-tab');
            var $panels = $tabContainer.find('.pces-tab-panel');
            
            $tabs.on('click', function(e) {
                e.preventDefault();
                var $tab = $(this);
                var targetPanel = $tab.attr('href') || $tab.data('target');
                
                if (!$tab.hasClass('active')) {
                    // Deactivate all tabs
                    $tabs.removeClass('active').attr('aria-selected', 'false');
                    
                    // Activate clicked tab
                    $tab.addClass('active').attr('aria-selected', 'true');
                    
                    // Show/hide panels
                    $panels.removeClass('active').attr('aria-hidden', 'true');
                    $(targetPanel).addClass('active').attr('aria-hidden', 'false');
                    
                    // Trigger custom event
                    $tabContainer.trigger('pces:tab-changed', [targetPanel, $tab]);
                    
                    // Track tab usage
                    PCES.Toggle.trackEvent('tab_switch', {
                        tab_container: $tabContainer.attr('id') || 'unnamed',
                        target_panel: targetPanel
                    });
                }
            });
            
            // Keyboard navigation for tabs
            $tabs.on('keydown', function(e) {
                var $current = $(this);
                var $next, $prev;
                
                switch(e.keyCode) {
                    case 37: // Left arrow
                        e.preventDefault();
                        $prev = $current.prev('.pces-tab');
                        if (!$prev.length) {
                            $prev = $tabs.last();
                        }
                        $prev.focus().click();
                        break;
                    case 39: // Right arrow
                        e.preventDefault();
                        $next = $current.next('.pces-tab');
                        if (!$next.length) {
                            $next = $tabs.first();
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
        });
    };

    /**
     * Setup toggle pills (similar to tabs but different styling)
     */
    PCES.Toggle.setupTogglePills = function() {
        $('.pces-toggle-pills').each(function() {
            var $pillContainer = $(this);
            var $pills = $pillContainer.find('.pces-pill');
            var $panels = $pillContainer.find('.pces-pill-panel');
            
            $pills.on('click', function(e) {
                e.preventDefault();
                var $pill = $(this);
                var targetPanel = $pill.attr('href') || $pill.data('target');
                
                if (!$pill.hasClass('active')) {
                    // Deactivate all pills
                    $pills.removeClass('active').attr('aria-pressed', 'false');
                    
                    // Activate clicked pill
                    $pill.addClass('active').attr('aria-pressed', 'true');
                    
                    // Show/hide panels with animation
                    $panels.removeClass('active').fadeOut(200, function() {
                        $(targetPanel).addClass('active').fadeIn(200);
                    });
                    
                    // Trigger custom event
                    $pillContainer.trigger('pces:pill-changed', [targetPanel, $pill]);
                    
                    // Track pill usage
                    PCES.Toggle.trackEvent('pill_switch', {
                        pill_container: $pillContainer.attr('id') || 'unnamed',
                        target_panel: targetPanel
                    });
                }
            });
        });
    };

    /**
     * Setup toggle switches (on/off switches)
     */
    PCES.Toggle.setupToggleSwitches = function() {
        $('.pces-toggle-switch').each(function() {
            var $switch = $(this);
            var $input = $switch.find('input[type="checkbox"]');
            var $label = $switch.find('.pces-switch-label');
            
            // Initial state
            PCES.Toggle.updateSwitchState($switch, $input.is(':checked'));
            
            $input.on('change', function() {
                var isChecked = $(this).is(':checked');
                PCES.Toggle.updateSwitchState($switch, isChecked);
                
                // Trigger custom event
                $switch.trigger('pces:switch-toggled', [isChecked]);
                
                // Track switch usage
                PCES.Toggle.trackEvent('switch_toggled', {
                    switch_id: $input.attr('id') || 'unnamed',
                    new_state: isChecked ? 'on' : 'off'
                });
            });
            
            // Keyboard support
            $switch.on('keydown', function(e) {
                if (e.keyCode === 32) { // Space
                    e.preventDefault();
                    $input.click();
                }
            });
        });
    };

    /**
     * Setup accordion toggles
     */
    PCES.Toggle.setupAccordionToggles = function() {
        $('.pces-accordion').each(function() {
            var $accordion = $(this);
            var $items = $accordion.find('.pces-accordion-item');
            var allowMultiple = $accordion.data('allow-multiple') !== false;
            
            $items.each(function() {
                var $item = $(this);
                var $header = $item.find('.pces-accordion-header');
                var $content = $item.find('.pces-accordion-content');
                var $toggle = $header.find('.pces-accordion-toggle');
                
                $header.on('click', function() {
                    var isExpanded = $item.hasClass('expanded');
                    
                    if (!allowMultiple && !isExpanded) {
                        // Close all other items
                        $items.removeClass('expanded');
                        $items.find('.pces-accordion-content').slideUp(300);
                        $items.find('.pces-accordion-toggle').attr('aria-expanded', 'false');
                    }
                    
                    if (isExpanded) {
                        // Collapse this item
                        $item.removeClass('expanded');
                        $content.slideUp(300);
                        $toggle.attr('aria-expanded', 'false');
                    } else {
                        // Expand this item
                        $item.addClass('expanded');
                        $content.slideDown(300);
                        $toggle.attr('aria-expanded', 'true');
                    }
                    
                    // Trigger custom event
                    $accordion.trigger('pces:accordion-toggled', [$item, !isExpanded]);
                    
                    // Track accordion usage
                    PCES.Toggle.trackEvent('accordion_toggled', {
                        accordion_id: $accordion.attr('id') || 'unnamed',
                        item_index: $items.index($item),
                        new_state: isExpanded ? 'collapsed' : 'expanded'
                    });
                });
                
                // Keyboard support
                $header.on('keydown', function(e) {
                    if (e.keyCode === 13 || e.keyCode === 32) { // Enter or Space
                        e.preventDefault();
                        $header.click();
                    }
                });
            });
        });
    };

    /**
     * Update switch visual state
     */
    PCES.Toggle.updateSwitchState = function($switch, isChecked) {
        var $label = $switch.find('.pces-switch-label');
        
        if (isChecked) {
            $switch.addClass('checked');
            $label.text($label.data('on-text') || 'On');
        } else {
            $switch.removeClass('checked');
            $label.text($label.data('off-text') || 'Off');
        }
    };

    /**
     * Programmatically activate a toggle option
     */
    PCES.Toggle.activateOption = function(groupSelector, optionValue) {
        var $group = $(groupSelector);
        var $option = $group.find('[data-target="' + optionValue + '"]');
        
        if ($option.length) {
            $option.click();
        }
    };

    /**
     * Programmatically activate a tab
     */
    PCES.Toggle.activateTab = function(tabContainerSelector, tabTarget) {
        var $container = $(tabContainerSelector);
        var $tab = $container.find('[href="' + tabTarget + '"], [data-target="' + tabTarget + '"]');
        
        if ($tab.length) {
            $tab.click();
        }
    };

    /**
     * Get current active option in a toggle group
     */
    PCES.Toggle.getActiveOption = function(groupSelector) {
        var $group = $(groupSelector);
        var $activeOption = $group.find('.pces-toggle-option.active');
        
        return $activeOption.length ? $activeOption.data('target') : null;
    };

    /**
     * Get current active tab
     */
    PCES.Toggle.getActiveTab = function(tabContainerSelector) {
        var $container = $(tabContainerSelector);
        var $activeTab = $container.find('.pces-tab.active');
        
        return $activeTab.length ? ($activeTab.attr('href') || $activeTab.data('target')) : null;
    };

    /**
     * Track events for analytics
     */
    PCES.Toggle.trackEvent = function(eventName, parameters) {
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
        if ($('.pces-toggle-group, .pces-toggle-tabs, .pces-toggle-pills, .pces-toggle-switch, .pces-accordion').length) {
            try {
                PCES.Toggle.init();
            } catch (error) {
                PCES.handleError(error, 'toggle component initialization');
            }
        }
    });

})(jQuery);

/**
 * CSS styles for toggle component
 */
if (typeof document !== 'undefined') {
    var toggleStyles = `
        .pces-toggle-group {
            display: flex;
            border-radius: var(--pces-border-radius, 0.375rem);
            overflow: hidden;
            border: 1px solid #dee2e6;
        }
        
        .pces-toggle-option {
            flex: 1;
            padding: 0.75rem 1.5rem;
            background: #fff;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            color: var(--pces-secondary, #6c757d);
            font-weight: 500;
            text-align: center;
            position: relative;
        }
        
        .pces-toggle-option:not(:last-child) {
            border-right: 1px solid #dee2e6;
        }
        
        .pces-toggle-option:hover {
            background: var(--pces-light, #f8f9fa);
            color: var(--pces-primary, #007bff);
        }
        
        .pces-toggle-option.active {
            background: var(--pces-primary, #007bff);
            color: #fff;
        }
        
        .pces-toggle-option:focus {
            outline: 2px solid var(--pces-primary, #007bff);
            outline-offset: -2px;
            z-index: 1;
        }
        
        .pces-toggle-tabs {
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 1rem;
        }
        
        .pces-tab {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            color: var(--pces-secondary, #6c757d);
            text-decoration: none;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .pces-tab:hover {
            color: var(--pces-primary, #007bff);
            border-bottom-color: var(--pces-primary, #007bff);
            text-decoration: none;
        }
        
        .pces-tab.active {
            color: var(--pces-primary, #007bff);
            border-bottom-color: var(--pces-primary, #007bff);
            font-weight: 600;
        }
        
        .pces-tab-panel {
            display: none;
        }
        
        .pces-tab-panel.active {
            display: block;
        }
        
        .pces-toggle-pills {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .pces-pill {
            padding: 0.5rem 1rem;
            background: var(--pces-light, #f8f9fa);
            color: var(--pces-secondary, #6c757d);
            text-decoration: none;
            border-radius: 50px;
            transition: all 0.3s ease;
            cursor: pointer;
            border: 1px solid transparent;
        }
        
        .pces-pill:hover {
            background: var(--pces-primary, #007bff);
            color: #fff;
            text-decoration: none;
        }
        
        .pces-pill.active {
            background: var(--pces-primary, #007bff);
            color: #fff;
            border-color: var(--pces-primary, #007bff);
        }
        
        .pces-pill-panel {
            display: none;
        }
        
        .pces-pill-panel.active {
            display: block;
        }
        
        .pces-toggle-switch {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
        }
        
        .pces-toggle-switch input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .pces-switch-slider {
            position: relative;
            width: 50px;
            height: 24px;
            background: #ccc;
            border-radius: 24px;
            transition: background 0.3s ease;
        }
        
        .pces-switch-slider::before {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 20px;
            height: 20px;
            background: #fff;
            border-radius: 50%;
            transition: transform 0.3s ease;
        }
        
        .pces-toggle-switch.checked .pces-switch-slider {
            background: var(--pces-primary, #007bff);
        }
        
        .pces-toggle-switch.checked .pces-switch-slider::before {
            transform: translateX(26px);
        }
        
        .pces-toggle-switch:focus-within .pces-switch-slider {
            outline: 2px solid var(--pces-primary, #007bff);
            outline-offset: 2px;
        }
        
        .pces-accordion-item {
            border: 1px solid #dee2e6;
            border-radius: var(--pces-border-radius, 0.375rem);
            margin-bottom: 0.5rem;
            overflow: hidden;
        }
        
        .pces-accordion-header {
            padding: 1rem 1.5rem;
            background: var(--pces-light, #f8f9fa);
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background 0.3s ease;
        }
        
        .pces-accordion-header:hover {
            background: #e9ecef;
        }
        
        .pces-accordion-header:focus {
            outline: 2px solid var(--pces-primary, #007bff);
            outline-offset: -2px;
        }
        
        .pces-accordion-toggle {
            transition: transform 0.3s ease;
        }
        
        .pces-accordion-item.expanded .pces-accordion-toggle {
            transform: rotate(180deg);
        }
        
        .pces-accordion-content {
            padding: 1.5rem;
            display: none;
        }
        
        @media (max-width: 767.98px) {
            .pces-toggle-group {
                flex-direction: column;
            }
            
            .pces-toggle-option:not(:last-child) {
                border-right: none;
                border-bottom: 1px solid #dee2e6;
            }
            
            .pces-toggle-pills {
                flex-wrap: wrap;
            }
            
            .pces-tab {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
        }
        
        @media (prefers-reduced-motion: reduce) {
            .pces-toggle-option,
            .pces-tab,
            .pces-pill,
            .pces-switch-slider,
            .pces-switch-slider::before,
            .pces-accordion-header,
            .pces-accordion-toggle {
                transition: none;
            }
        }
    `;
    
    var styleSheet = document.createElement('style');
    styleSheet.textContent = toggleStyles;
    document.head.appendChild(styleSheet);
}