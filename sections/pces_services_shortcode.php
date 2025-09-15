<?php
// Services data - easy to edit by modifying this array
$services = array(
    array(
        'title' => 'OJTGo',
        'description' => 'Connects students to internship opportunities that match their education, career goals, and personal growth, making the journey from classroom to career smooth and meaningful.',
        'color' => '#4fabfa'
    ),
    array(
        'title' => 'Chains2Chances',    
        'description' => 'Links justice-involved individuals with inclusive employers, supporting reentry through skills, opportunity, and shared purpose.',
        'color' => '#00ff08'
    ),
    array(
        'title' => 'PWD-E',
        'description' => 'Bridges persons with disabilities to employers who value diversity, offering accessible and dignified employment opportunities.',
        'color' => '#32bf4f'
    ),
    array(
        'title' => 'Hirebilis',
        'description' => 'Hirebilis is a customizable employment and skills-matching platform that can be tailored to the specific needs of any industry. It is designed for use by corporations, small businesses, and government institutions.',
        'color' => '#083b6f'
    )
);
$first_four_services = array_slice($services, 0, 4);
?>

<section class="pces-services py-5" id="services">
    <div class="container">
        <h2 class="text-center mb-5">Our Specialized Recruitment Platforms</h2>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="row g-4">
                    <?php foreach($first_four_services as $service): 
                        $image_filename = strtolower(str_replace(' ', '-', $service['title'])) . '.svg';
                        $image_url = home_url('/wp-content/uploads/icons/services/' . $image_filename);
                    ?>
                        <div class="col-md-6">
                            <div class="service-card h-100 p-4 d-flex flex-column" data-service-color="<?php echo esc_attr($service['color']); ?>">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="<?php echo esc_url($image_url); ?>" 
                                         alt="<?php echo esc_attr($service['title']); ?> icon" 
                                         class="me-3" 
                                         style="width: 40px; height: 40px; object-fit: contain;">
                                    <h4 class="mb-0"><?php echo esc_html($service['title']); ?></h4>
                                </div>
                                <p class="mb-0"><?php echo esc_html($service['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>