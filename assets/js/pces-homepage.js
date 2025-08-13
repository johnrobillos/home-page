/**
 * PCES Homepage JavaScript
 * Version: 1.0
 * 
 * This file contains basic JavaScript interactions for the PCES homepage.
 * Includes smooth scrolling and simple hover effects.
 */

document.addEventListener('DOMContentLoaded', function() {
    
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
    const serviceCards = document.querySelectorAll('.service-card');
    serviceCards.forEach(card => {
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