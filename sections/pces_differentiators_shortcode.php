<?php
// Differentiators data - easy to edit by modifying this array
$differentiators = array(
    array(
        'icon' => 'bi-star',
        'title' => 'Specialized Matching',
        'description' => 'We build niche platforms with smart matching algorithms for specific jobseekers, such as PDLs or persons with disabilities.'
    ),
    array(
        'icon' => 'bi-bar-chart',
        'title' => 'Lower Barriers to Entry',
        'description' => 'Our systems are designed to minimize costs and speed up recruitment for both applicants and employers.'
    ),
    array(
        'icon' => 'bi-shield',
        'title' => 'Data Privacy Compliant',
        'description' => 'We comply with the Data Privacy Act of 2012 by storing data securely with encryption and never selling personal information.'
    ),
    array(
        'icon' => 'bi-shield-check',
        'title' => 'Verified and Legitimate Jobs',
        'description' => 'We vet employers and check job postings against labor laws to ensure safe and legal opportunities.'
    ),
    array(
        'icon' => 'bi-people',
        'title' => 'Connecting Diverse Filipino Talent',
        'description' => 'We connect Filipino jobseekers, including students, skilled professionals, and disadvantaged groups, with employers who value their talents.'
    ),
    array(
        'icon' => 'bi-sliders',
        'title' => 'Customizable Platforms',
        'description' => 'We can design and deploy white-label job boards and matching systems tailored to the specific needs of schools, NGOs, LGUs, and private companies.'
    )
);
?>

<section class="pces-differentiators py-5">
    <div class="container">
        <h2 class="text-center mb-5">What Makes Us Different</h2>
        <div class="row">
            <?php foreach($differentiators as $differentiator): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="differentiator-card text-center h-100 p-4">
                        <i class="<?php echo esc_attr($differentiator['icon']); ?> fs-1 text-primary mb-3"></i>
                        <h5 class="mb-3 fw-bold"><?php echo esc_html($differentiator['title']); ?></h5>
                        <p class="mb-0"><?php echo esc_html($differentiator['description']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>