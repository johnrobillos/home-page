/**
 * PCES Plugin Debug Toolkit
 * 
 * Copy and paste these functions into your browser console for debugging
 * Or include this file in your development environment
 */

// 🔍 CSS Debugging Functions
const PCESDebug = {
    
    /**
     * Find all CSS rules affecting service cards
     */
    findServiceCardRules() {
        console.log('🔍 Searching for .service-card CSS rules...');
        const rules = [];
        
        Array.from(document.styleSheets).forEach((sheet, sheetIndex) => {
            try {
                Array.from(sheet.cssRules || []).forEach((rule, ruleIndex) => {
                    if (rule.selectorText && rule.selectorText.includes('service-card')) {
                        rules.push({
                            selector: rule.selectorText,
                            cssText: rule.cssText,
                            stylesheet: sheet.href || 'inline',
                            sheetIndex,
                            ruleIndex,
                            specificity: this.calculateSpecificity(rule.selectorText)
                        });
                    }
                });
            } catch(e) {
                console.warn('Cannot access stylesheet:', sheet.href, e.message);
            }
        });
        
        // Sort by specificity (highest first)
        rules.sort((a, b) => b.specificity - a.specificity);
        
        console.table(rules);
        return rules;
    },
    
    /**
     * Calculate CSS specificity score
     */
    calculateSpecificity(selector) {
        const ids = (selector.match(/#/g) || []).length * 100;
        const classes = (selector.match(/\./g) || []).length * 10;
        const elements = (selector.match(/[a-zA-Z]/g) || []).length * 1;
        const important = selector.includes('!important') ? 1000 : 0;
        
        return important + ids + classes + elements;
    },
    
    /**
     * Check which styles are actually applied to service cards
     */
    checkAppliedStyles() {
        console.log('🎨 Checking applied styles on service cards...');
        const cards = document.querySelectorAll('.service-card');
        
        cards.forEach((card, index) => {
            const computedStyle = window.getComputedStyle(card);
            const color = card.getAttribute('data-service-color');
            
            console.group(`Card ${index + 1} (Color: ${color})`);
            console.log('Border:', computedStyle.border);
            console.log('Border-left:', computedStyle.borderLeft);
            console.log('Border-color:', computedStyle.borderColor);
            console.log('Background:', computedStyle.backgroundColor);
            console.log('Classes:', card.className);
            console.groupEnd();
        });
    },
    
    /**
     * Test hover states manually
     */
    testHoverStates() {
        console.log('🖱️ Testing hover states...');
        const cards = document.querySelectorAll('.service-card');
        
        cards.forEach((card, index) => {
            const color = card.getAttribute('data-service-color');
            console.log(`Testing card ${index + 1} with color ${color}`);
            
            // Simulate hover
            card.dispatchEvent(new MouseEvent('mouseenter', { bubbles: true }));
            
            setTimeout(() => {
                const hoverStyle = window.getComputedStyle(card);
                console.log(`Hover border-left: ${hoverStyle.borderLeftColor}`);
                
                // Remove hover
                card.dispatchEvent(new MouseEvent('mouseleave', { bubbles: true }));
            }, 100);
        });
    },
    
    /**
     * Check for plugin conflicts
     */
    checkPluginConflicts() {
        console.log('⚠️ Checking for plugin conflicts...');
        
        // Check for duplicate Bootstrap
        const bootstrapCSS = Array.from(document.querySelectorAll('link[href*="bootstrap"]'));
        const bootstrapJS = Array.from(document.querySelectorAll('script[src*="bootstrap"]'));
        
        console.log('Bootstrap CSS files:', bootstrapCSS.length);
        bootstrapCSS.forEach(link => console.log('  -', link.href));
        
        console.log('Bootstrap JS files:', bootstrapJS.length);
        bootstrapJS.forEach(script => console.log('  -', script.src));
        
        // Check for PCES plugins
        const pcesStyles = Array.from(document.querySelectorAll('link[id*="pces"], style[id*="pces"]'));
        const pcesScripts = Array.from(document.querySelectorAll('script[src*="pces"]'));
        
        console.log('PCES CSS files:', pcesStyles.length);
        pcesStyles.forEach(style => console.log('  -', style.id, style.href || 'inline'));
        
        console.log('PCES JS files:', pcesScripts.length);
        pcesScripts.forEach(script => console.log('  -', script.src));
    },
    
    /**
     * Monitor DOM changes for debugging
     */
    monitorDOMChanges() {
        console.log('👀 Starting DOM change monitoring...');
        
        const observer = new MutationObserver(mutations => {
            mutations.forEach(mutation => {
                if (mutation.type === 'childList') {
                    mutation.addedNodes.forEach(node => {
                        if (node.nodeType === 1 && node.classList && node.classList.contains('service-card')) {
                            console.log('🆕 New service card added:', node);
                        }
                    });
                }
                
                if (mutation.type === 'attributes' && mutation.target.classList && mutation.target.classList.contains('service-card')) {
                    console.log('🔄 Service card attributes changed:', mutation.target, mutation.attributeName);
                }
            });
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true,
            attributes: true,
            attributeFilter: ['class', 'style', 'data-service-color']
        });
        
        // Return function to stop monitoring
        return () => {
            observer.disconnect();
            console.log('🛑 DOM monitoring stopped');
        };
    },
    
    /**
     * Generate CSS override for testing
     */
    generateCSSOverride(cardIndex, color) {
        const css = `
            .service-card:nth-child(${cardIndex + 1}):hover {
                border-left-color: ${color} !important;
                border-left-width: 4px !important;
            }
        `;
        
        const style = document.createElement('style');
        style.textContent = css;
        style.id = `debug-override-${cardIndex}`;
        document.head.appendChild(style);
        
        console.log(`✅ Added debug CSS override for card ${cardIndex + 1}`);
        return style;
    },
    
    /**
     * Clean up debug overrides
     */
    cleanupDebugCSS() {
        const debugStyles = document.querySelectorAll('style[id^="debug-override"]');
        debugStyles.forEach(style => style.remove());
        console.log(`🧹 Removed ${debugStyles.length} debug CSS overrides`);
    },
    
    /**
     * Full diagnostic report
     */
    fullDiagnostic() {
        console.log('🏥 Running full PCES diagnostic...');
        console.log('=====================================');
        
        this.checkPluginConflicts();
        console.log('');
        
        this.findServiceCardRules();
        console.log('');
        
        this.checkAppliedStyles();
        console.log('');
        
        // Check JavaScript functions
        console.log('🔧 JavaScript Functions:');
        console.log('applyServiceCardColors:', typeof applyServiceCardColors);
        console.log('jQuery:', typeof jQuery, jQuery ? jQuery.fn.jquery : 'not loaded');
        console.log('Bootstrap:', typeof bootstrap);
        
        console.log('=====================================');
        console.log('✅ Diagnostic complete!');
    }
};

// 🚀 Quick access functions
window.debugPCES = PCESDebug;

// Auto-run basic diagnostic if service cards are present
if (document.querySelectorAll('.service-card').length > 0) {
    console.log('🎯 Service cards detected! Use debugPCES.fullDiagnostic() for complete analysis');
    console.log('Quick commands:');
    console.log('  debugPCES.checkAppliedStyles() - Check current styles');
    console.log('  debugPCES.testHoverStates() - Test hover effects');
    console.log('  debugPCES.checkPluginConflicts() - Find conflicts');
    console.log('  debugPCES.fullDiagnostic() - Complete analysis');
}