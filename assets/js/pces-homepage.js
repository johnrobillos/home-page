/**
 * PCES Homepage JavaScript
 * Version: 1.0
 * 
 * This file contains basic JavaScript interactions for the PCES homepage.
 * Includes smooth scrolling and simple hover effects.
 */

/**
 * Apply dynamic colors to service cards
 */
function applyServiceCardColors() {
    const serviceCards = document.querySelectorAll('.service-card[data-service-color]');
    
    if (serviceCards.length === 0) {
        console.log('No service cards found with data-service-color attribute');
        return;
    }
    
    console.log(`Found ${serviceCards.length} service cards with colors`);
    
    serviceCards.forEach((card, index) => {
        const color = card.getAttribute('data-service-color');
        if (!color) {
            console.warn('Service card missing color value', card);
            return;
        }
        
        console.log(`Applying color ${color} to service card ${index + 1}`);
        
        // Create unique class name for this card
        const uniqueClass = `service-card-${index}`;
        card.classList.add(uniqueClass);
        
        // Create and inject CSS for this specific card
        const style = document.createElement('style');
        style.textContent = `
            .${uniqueClass}:hover {
                border-left-color: ${color} !important;
                border-left-width: 4px !important;
            }
        `;
        document.head.appendChild(style);
    });
}

// Run on DOM content loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded, applying service card colors...');
    applyServiceCardColors();
    
    // Also run after a short delay in case of dynamic content loading
    setTimeout(applyServiceCardColors, 1000);
    
    /**
     * Smooth scrolling for anchor links
     */
    const smoothScrollLinks = document.querySelectorAll('a[href^="#"]');
    
    smoothScrollLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // Skip if it's just a hash
            if (href === '#') return;
            
            const target = document.querySelector(href);
            
            if (target) {
                e.preventDefault();
                
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    /**
     * Add animation classes when elements come into view
     */
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);
    
    // Observe service cards for animation
    const serviceCardsForAnimation = document.querySelectorAll('.service-card');
    serviceCardsForAnimation.forEach(card => {
        observer.observe(card);
    });
    
    /**
     * Add loading state to buttons when clicked
     */
    const ctaButtons = document.querySelectorAll('.pces-hero .btn');
    
    ctaButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Add a subtle loading effect
            this.style.opacity = '0.8';
            
            setTimeout(() => {
                this.style.opacity = '1';
            }, 200);
        });
    });
    
    /**
     * Console log for debugging (remove in production)
     */
    console.log('PCES Homepage JavaScript loaded successfully');
    
});