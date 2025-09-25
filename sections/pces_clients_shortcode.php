<?php
// Client logo filenames - easy to edit by modifying this array
$client_logos = array(
    'company_01.svg',
    'company_02.svg', 
    'company_03.svg',
    'company_04.svg',
    'company_05.svg',
    'company_06.svg',
    'company_07.svg',
    'company_08.svg',
    'company_09.svg',
    'company_10.svg',
    'company_11.svg'
);
?>

<!-- Simple Vanilla JS Carousel -->
<div class="company-carousel-section" id="clientCarousel">
    <div class="fade-left"></div>
    <div class="fade-right"></div>

    <h5 class="carousel-title mb-5">TRUSTED BY THESE LEADING COMPANIES</h5>

    <div class="carousel-track-container mt-5 mb-5" onmouseenter="stopAutoScroll()" onmouseleave="startAutoScroll()">
        <div class="carousel-track" id="carouselTrack">
            <?php 
            // Create three sets of logos for seamless loop
            for($set = 0; $set < 3; $set++) {
                foreach($client_logos as $index => $logo_filename) {
                    $logo_path = '/wp-content/uploads/icons/partners/' . $logo_filename;
                    echo '<div class="carousel-slide">';
                    echo '<img src="' . $logo_path . '" alt="Company ' . ($index + 1) . '">';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
</div>

<script>
// Seamless infinite carousel functionality
let currentTransform = 0;
let autoScrollEnabled = true;
let autoScrollInterval;
const scrollSpeed = 1; // Slower, smoother scrolling
const slideWidth = 180; // Width of each slide (150px + 30px gap)
const totalSlides = <?php echo count($client_logos); ?>;

// Start auto-scroll when page loads
document.addEventListener('DOMContentLoaded', function() {
    startAutoScroll();
});

function startAutoScroll() {
    if (autoScrollInterval) clearInterval(autoScrollInterval);
    autoScrollEnabled = true;
    
    autoScrollInterval = setInterval(function() {
        if (autoScrollEnabled) {
            currentTransform -= scrollSpeed;
            
            // Calculate the width of one complete set of logos
            const oneSetWidth = totalSlides * slideWidth;
            
            // When we've moved one complete set to the left, reset seamlessly
            if (Math.abs(currentTransform) >= oneSetWidth) {
                // Reset to 0 without transition for seamless loop
                const track = document.getElementById('carouselTrack');
                if (track) {
                    track.style.transition = 'none';
                    currentTransform = 0;
                    track.style.transform = 'translateX(' + currentTransform + 'px)';
                    
                    // Re-enable transition after a brief moment
                    setTimeout(function() {
                        track.style.transition = 'transform 0.1s linear';
                    }, 10);
                }
            } else {
                updateCarouselPosition();
            }
        }
    }, 16); // ~60fps for smoother animation
}

function stopAutoScroll() {
    autoScrollEnabled = false;
    if (autoScrollInterval) clearInterval(autoScrollInterval);
}

function nextSlide() {
    currentTransform -= slideWidth;
    const oneSetWidth = totalSlides * slideWidth;
    
    if (Math.abs(currentTransform) >= oneSetWidth) {
        currentTransform = 0;
    }
    
    updateCarouselPosition();
}

function prevSlide() {
    currentTransform += slideWidth;
    
    if (currentTransform > 0) {
        const oneSetWidth = totalSlides * slideWidth;
        currentTransform = -oneSetWidth + slideWidth;
    }
    
    updateCarouselPosition();
}

function updateCarouselPosition() {
    const track = document.getElementById('carouselTrack');
    if (track) {
        track.style.transform = 'translateX(' + currentTransform + 'px)';
    }
}
</script>

<style>
/* Carousel Styles */
.company-carousel-section {
    position: relative;
    background: white;
    padding: 40px 0;
    overflow: hidden;
    text-align: center;
}

.carousel-title {
    font-size: 1.5rem;
    color: #333;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 40px;
}

.carousel-controls {
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    transform: translateY(-50%);
    z-index: 10;
    display: flex;
    justify-content: space-between;
    pointer-events: none;
}

.carousel-nav {
    background: rgba(255, 255, 255, 0.8);
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    font-size: 18px;
    cursor: pointer;
    pointer-events: auto;
    transition: all 0.3s ease;
    margin: 0 15px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.carousel-nav:hover {
    background: #333;
    color: white;
}

.carousel-track-container {
    width: 100%;
    overflow: hidden;
    padding: 20px 0;
    position: relative;
}

.carousel-track {
    display: flex;
    transition: transform 0.1s linear;
    gap: 30px;
    will-change: transform;
}

.carousel-slide {
    flex: 0 0 auto;
    width: 150px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.carousel-slide img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    filter: grayscale(100%);
    transition: filter 0.3s ease;
}

.carousel-slide img:hover {
    filter: grayscale(0%);
}

.fade-left, .fade-right {
    position: absolute;
    top: 0;
    bottom: 0;
    width: 100px;
    z-index: 2;
    pointer-events: none;
}

.fade-left {
    left: 0;
    background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(255,255,255,0) 100%);
}

.fade-right {
    right: 0;
    background: linear-gradient(270deg, rgba(255,255,255,1) 0%, rgba(255,255,255,0) 100%);
}
</style>