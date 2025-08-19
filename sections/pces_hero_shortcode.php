<?php
// Content variables - easy to edit
$company_name = "Philippines Central Engagement Services Inc.";
$description = "Opportunities shouldn't be a privilege. We create job platforms so under served Filipinos can rise, grow, and thrive — because when doors are open, the sky is never the limit.";
$cta_text = "Explore our Services";
$cta_link = "#services";

// Extended section content
$mission_text = "At PCES Inc., we believe that everyone deserves access to meaningful work—regardless of background, ability, or life circumstance. As a proudly Filipino-led technology company, we are driven by a mission to create inclusive, purpose-centered employment solutions that reflect the diversity of our communities.";
$tagline_part1 = "Created by Filipinos";
$tagline_part2 = "for the Filipinos";
?>

<section class="pces-hero-new position-relative">
    <!-- Blue gradient background -->
    <div class="hero-gradient-bg"></div>
    
    <div class="container-fluid px-4">
        <div class="row min-vh-100 align-items-center">
            <!-- Left side - Content card -->
            <div class="col-lg-6">
                <div class="hero-content-card">
                    <h1 class="hero-company-name"><?php echo esc_html($company_name); ?></h1>
                    <p class="hero-description"><?php echo esc_html($description); ?></p>
                    <a href="<?php echo esc_url($cta_link); ?>" class="hero-cta-btn"><?php echo esc_html($cta_text); ?></a>
                </div>
            </div>
            
            <!-- Right side - 3D Building illustration -->
            <div class="col-lg-6 d-flex justify-content-center align-items-center">
                <div class="hero-illustration">
                    <!-- 3D Building SVG -->
                    <svg class="building-svg" viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg">
                        <!-- Building blocks with 3D effect -->
                        <defs>
                            <linearGradient id="buildingGradient1" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#87CEEB;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#4682B4;stop-opacity:1" />
                            </linearGradient>
                            <linearGradient id="buildingGradient2" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#B0E0E6;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#5F9EA0;stop-opacity:1" />
                            </linearGradient>
                        </defs>
                        
                        <!-- Building structure -->
                        <g class="building-group">
                            <!-- Base building -->
                            <polygon points="100,350 200,350 250,300 150,300" fill="url(#buildingGradient1)" stroke="#2E5984" stroke-width="2"/>
                            <polygon points="200,350 250,300 250,200 200,250" fill="url(#buildingGradient2)" stroke="#2E5984" stroke-width="2"/>
                            <polygon points="150,300 250,200 250,150 150,250" fill="url(#buildingGradient1)" stroke="#2E5984" stroke-width="2"/>
                            
                            <!-- Middle building -->
                            <polygon points="250,300 350,300 400,250 300,250" fill="url(#buildingGradient2)" stroke="#2E5984" stroke-width="2"/>
                            <polygon points="350,300 400,250 400,150 350,200" fill="url(#buildingGradient1)" stroke="#2E5984" stroke-width="2"/>
                            <polygon points="300,250 400,150 400,100 300,200" fill="url(#buildingGradient2)" stroke="#2E5984" stroke-width="2"/>
                            
                            <!-- Tall building -->
                            <polygon points="400,250 500,250 550,200 450,200" fill="url(#buildingGradient1)" stroke="#2E5984" stroke-width="2"/>
                            <polygon points="500,250 550,200 550,50 500,100" fill="url(#buildingGradient2)" stroke="#2E5984" stroke-width="2"/>
                            <polygon points="450,200 550,50 550,30 450,180" fill="url(#buildingGradient1)" stroke="#2E5984" stroke-width="2"/>
                        </g>
                        
                        <!-- Grid lines for detail -->
                        <g class="grid-lines" stroke="#2E5984" stroke-width="1" opacity="0.6">
                            <!-- Horizontal lines -->
                            <line x1="100" y1="320" x2="250" y2="270"/>
                            <line x1="100" y1="330" x2="250" y2="280"/>
                            <line x1="250" y1="270" x2="400" y2="220"/>
                            <line x1="250" y1="280" x2="400" y2="230"/>
                            <line x1="400" y1="220" x2="550" y2="170"/>
                            <line x1="400" y1="200" x2="550" y2="150"/>
                            
                            <!-- Vertical lines -->
                            <line x1="120" y1="350" x2="170" y2="300"/>
                            <line x1="140" y1="350" x2="190" y2="300"/>
                            <line x1="270" y1="300" x2="320" y2="250"/>
                            <line x1="290" y1="300" x2="340" y2="250"/>
                            <line x1="420" y1="250" x2="470" y2="200"/>
                            <line x1="440" y1="250" x2="490" y2="200"/>
                        </g>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Extended Hero Section - Mission Statement -->
<section class="hero-extended py-5">
    <div class="container">
        <div class="row align-items-center">
            <!-- Left side - Mission paragraph -->
            <div class="col-lg-6">
                <p class="mission-text"><?php echo esc_html($mission_text); ?></p>
            </div>
            
            <!-- Right side - Tagline -->
            <div class="col-lg-6 text-center">
                <div class="tagline-container">
                    <h2 class="tagline-part1"><?php echo esc_html($tagline_part1); ?></h2>
                    <h2 class="tagline-part2"><?php echo esc_html($tagline_part2); ?></h2>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* New Hero Section Styling */
.pces-hero-new {
    position: relative;
    min-height: 100vh;
    overflow: hidden;
    padding: 80px 0 40px 0;
}

/* Blue gradient background */
.hero-gradient-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #00BFFF 0%, #1E90FF 50%, #4169E1 100%);
    border-radius: 0 0 40px 40px;
    z-index: 1;
}

/* Content card styling */
.hero-content-card {
    background: white;
    border-radius: 20px;
    padding: 50px 40px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    margin: 40px 0;
    position: relative;
    z-index: 2;
}

.hero-company-name {
    color: #1a237e;
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 30px;
}

.hero-description {
    color: #424242;
    font-size: 1.1rem;
    line-height: 1.6;
    margin-bottom: 40px;
}

.hero-cta-btn {
    display: inline-block;
    background: transparent;
    color: #1a237e;
    border: 2px solid #1a237e;
    padding: 15px 30px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.hero-cta-btn:hover {
    background: #1a237e;
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(26, 35, 126, 0.3);
}

/* 3D Building illustration */
.hero-illustration {
    position: relative;
    z-index: 2;
    max-width: 600px;
    width: 100%;
}

.building-svg {
    width: 100%;
    height: auto;
    max-width: 500px;
    filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.2));
}

.building-group {
    animation: float 6s ease-in-out infinite;
}

.grid-lines {
    animation: pulse 4s ease-in-out infinite;
}

/* Animations */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

@keyframes pulse {
    0%, 100% { opacity: 0.6; }
    50% { opacity: 0.3; }
}

/* Responsive design */
@media (max-width: 991px) {
    .pces-hero-new {
        padding: 60px 0 40px 0;
    }
    
    .hero-content-card {
        padding: 40px 30px;
        margin: 20px auto;
        text-align: center;
    }
    
    .hero-company-name {
        font-size: 2rem;
        margin-bottom: 25px;
    }
    
    .hero-description {
        font-size: 1rem;
        margin-bottom: 30px;
    }
    
    .building-svg {
        max-width: 400px;
        margin-top: 30px;
    }
}

@media (max-width: 768px) {
    .hero-gradient-bg {
        border-radius: 0 0 30px 30px;
    }
    
    .hero-content-card {
        padding: 30px 25px;
        margin: 20px 15px;
    }
    
    .hero-company-name {
        font-size: 1.8rem;
    }
    
    .hero-description {
        font-size: 0.95rem;
    }
    
    .hero-cta-btn {
        padding: 12px 25px;
        font-size: 0.9rem;
    }
    
    .building-svg {
        max-width: 300px;
    }
}

@media (max-width: 576px) {
    .pces-hero-new {
        padding: 40px 0 30px 0;
    }
    
    .hero-content-card {
        padding: 25px 20px;
        margin: 15px 10px;
    }
    
    .hero-company-name {
        font-size: 1.6rem;
        margin-bottom: 20px;
    }
    
    .hero-description {
        font-size: 0.9rem;
        margin-bottom: 25px;
    }
    
    .building-svg {
        max-width: 250px;
        margin-top: 20px;
    }
}

/* Extended Hero Section Styling */
.hero-extended {
    background: white;
    padding: 80px 0;
    margin-top: -20px; /* Slight overlap with main hero */
}

.mission-text {
    color: #666666;
    font-size: 1.1rem;
    line-height: 1.7;
    margin: 0;
    padding-right: 40px;
}

.tagline-container {
    padding-left: 40px;
}

.tagline-part1 {
    color: #1a237e;
    font-size: 3rem;
    font-weight: 700;
    line-height: 1.1;
    margin-bottom: 10px;
}

.tagline-part2 {
    color: #dc3545;
    font-size: 3rem;
    font-weight: 700;
    line-height: 1.1;
    margin-bottom: 0;
}

/* Responsive design for extended section */
@media (max-width: 991px) {
    .hero-extended {
        padding: 60px 0;
    }
    
    .mission-text {
        font-size: 1rem;
        padding-right: 0;
        margin-bottom: 40px;
        text-align: center;
    }
    
    .tagline-container {
        padding-left: 0;
    }
    
    .tagline-part1,
    .tagline-part2 {
        font-size: 2.5rem;
    }
}

@media (max-width: 768px) {
    .hero-extended {
        padding: 50px 0;
    }
    
    .mission-text {
        font-size: 0.95rem;
        margin-bottom: 30px;
    }
    
    .tagline-part1,
    .tagline-part2 {
        font-size: 2rem;
    }
}

@media (max-width: 576px) {
    .hero-extended {
        padding: 40px 0;
    }
    
    .mission-text {
        font-size: 0.9rem;
        margin-bottom: 25px;
    }
    
    .tagline-part1,
    .tagline-part2 {
        font-size: 1.8rem;
    }
}
</style>