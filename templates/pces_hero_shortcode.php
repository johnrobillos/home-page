<?php
// Content variables - easy to edit
$company_name = "Philippines Central Engagement Services Inc.";
$tagline = "Created by Filipinos for the Filipinos";
$cta_text = "Learn More";
$cta_link = "#services";
?>

<section class="pces-hero position-relative py-5">
    <div class="container position-relative z-1">
        <div class="row min-vh-75 align-items-center">
            <div class="col-lg-7">
                <h1 class="hero-title display-4 fw-bold text-white mb-4"><?php echo esc_html($company_name); ?></h1>
                <div class="divider bg-white mb-4" style="width: 80px; height: 4px;"></div>
                <p class="hero-tagline fs-5 text-white mb-5"><?php echo esc_html($tagline); ?></p>
                <a href="<?php echo esc_url($cta_link); ?>" class="btn btn-primary btn-lg px-5 py-3 fw-bold"><?php echo esc_html($cta_text); ?></a>
            </div>
        </div>
    </div>
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50"></div>
</section>