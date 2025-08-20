<?php
// Services data - easy to edit by modifying this array
$services = array(
    array(
        'title' => 'OJTGo',
        'description' => 'Connects students to internship opportunities that match their education, career goals, and personal growth, making the journey from classroom to career smooth and meaningful.',
        'visit_url' => 'https://ojtgo.com',
        'read_more' => '#ojtgo'
    ),
    array(
        'title' => 'Chains2Chances',    
        'description' => 'Links justice-involved individuals with inclusive employers, supporting reentry through skills, opportunity, and shared purpose.',
        'visit_url' => 'https://chains2chances.com',
        'read_more' => '#chains2chances'
    ),
    array(
        'title' => 'PWD-E',
        'description' => 'Bridges persons with disabilities to employers who value diversity, offering accessible and dignified employment opportunities.',
        'visit_url' => 'https://pwd-e.com',
        'read_more' => '#pwd-e'
    ),
    array(
        'title' => 'Hirebilis',
        'description' => 'Hirebilis is a customizable employment and skills-matching platform that can be tailored to the specific needs of any industry. It is designed for use by corporations, small businesses, and government institutions.',
        'visit_url' => 'https://hirebilis.com',
        'read_more' => '#hirebilis'
    )
);
$first_four_services = array_slice($services, 0, 4);
?>

<section class="pces-services py-5" id="services">
    <div class="container">
        <h2 class="text-center mb-5">Services Catered Towards Everyone's Needs</h2>
        <div class="row align-items-center">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="row g-4">
                    <?php foreach($first_four_services as $service): 
                        $image_filename = strtolower(str_replace(' ', '-', $service['title'])) . '.svg';
                        $image_url = home_url('/wp-content/uploads/icons/services/' . $image_filename);
                        $fallback_image = home_url('/wp-content/plugins/pces-homepage/assets/images/service-placeholder.svg');
                    ?>
                        <div class="col-md-6">
                            <div class="service-card h-100 p-4 d-flex flex-column position-relative">
                                <div class="d-flex align-items-center mb-3 service-card-header">
                                    <div class="service-icon-wrapper me-3">
                                        <img src="<?php echo esc_url($image_url); ?>" 
                                             onerror="this.onerror=null; this.src='<?php echo esc_url($fallback_image); ?>'"
                                             alt="<?php echo esc_attr($service['title']); ?>" 
                                             class="service-icon" 
                                             width="40" 
                                             height="40" 
                                             loading="lazy">
                                    </div>
                                    <h4 class="service-title mb-0"><?php echo esc_html($service['title']); ?></h4>
                                </div>
                                <div class="mt-auto">
                                    <div class="d-flex flex-wrap gap-3 mt-3">
                                        <a href="<?php echo esc_url($service['read_more']); ?>" class="text-decoration-underline text-primary">Read more</a>
                                        <a href="<?php echo esc_url($service['visit_url']); ?>" class="btn btn-primary btn-sm rounded-pill px-3" target="_blank">Visit Site</a>
                                    </div>
                                </div>
                                <span class="service-card-hover-indicator"></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="position-relative h-100">
                    <img src="<?php echo esc_url(home_url('/wp-content/uploads/icons/services/services-image.jpg')); ?>" 
                         alt="Services" 
                         class="img-fluid rounded-3 shadow"
                         loading="lazy"
                         width="600"
                         height="400">
                </div>
            </div>
        </div>
    </div>
</section>