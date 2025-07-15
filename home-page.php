<?php

/**
 * Plugin Name: Home Page
 * Description: Enqueues a script for the 'Home Page' page and includes a shortcode for a static HTML landing page.
 * Version: 1.0
 * Author: PCES Inc.
 */


//  Commit Before Implementing Design Alignment to Figma

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'api/contact_form.php';
require_once plugin_dir_path(__FILE__) . 'api/fetch_backend.php';

// Enqueue the script on the specific page
function home_page_enqueue_script()
{


    if (is_page('home')) {

        wp_enqueue_style(
            'home-page-css',
            plugins_url('/css/styles.css', __FILE__)
        );


        // jquery
        wp_enqueue_script(
            'asset-jquery-ni-jess',
            'https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js',
            array(),
            null,
            true
        );
        
        
        // font style
        wp_enqueue_style(
            'font-style-ni-charls',
            'https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap',
            array(),
            null
        );


        // Enqueue Bootstrap 5 CSS from CDN
        wp_enqueue_style(
            'bootstrap-css',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css',
            array(),
            '5.3.2'
        );



        // custom jQuery
        wp_enqueue_script(
            'home-page-script',
            plugin_dir_url(__FILE__) . '/js/home-page.js',
            array('jquery'),
            '1.0',
            true
        );

        // Enqueue Angular Sanitize (depends on angular-core)
        wp_enqueue_script(
            'angular-sanitize',
            'https://ajax.googleapis.com/ajax/libs/angularjs/1.8.3/angular-sanitize.min.js',
            ['angular-core'],
            null,
            true
        );

        // Your app script (depends on both AngularJS and Sanitize)
        wp_enqueue_script(
            'my-angular-app',
            plugins_url('js/angular.js', __FILE__),
            ['angular-core', 'angular-sanitize'],
            null,
            true
        );

        // Angular JS
        wp_enqueue_script(
            'angular-js',
            'https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js',
            array(),
            null,
            true
        );



        // AngularJS Route
        wp_enqueue_script(
            'angular-route',
            plugins_url('js/angular.js', __FILE__),
            ['jquery'],
            null,
            true
        );

        // // Enqueue ngStorage AFTER AngularJS
        // wp_enqueue_script(
        //     'ngStorage',
        //     'https://cdnjs.cloudflare.com/ajax/libs/ngStorage/0.3.11/ngStorage.min.js',
        //     array('angular-js'), // Ensure AngularJS is loaded first
        //     null,
        //     true
        // );
        wp_enqueue_script(
            'cryptojs',
            'https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js',
            array('angular-js'),  // Ensure it loads after AngularJS
            '4.1.1',
            true // Load in the footer
        );

        // Enqueue ngStorage AFTER AngularJS
        wp_enqueue_script(
            'ngStorage',
            'https://cdnjs.cloudflare.com/ajax/libs/ngStorage/0.3.11/ngStorage.min.js',
            array('angular-js'), // Ensure AngularJS is loaded first
            null,
            true
        );

        // ✅ Load Quill CSS and JS
        wp_enqueue_script(
            'quill-js',
            'https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.min.js',
            [],
            null,
            true
        );

        wp_enqueue_style(
            'quill-css',
            'https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css',
            [],
            null
        );


        // Enqueue OJT Registration Form Script (Angular-based AJAX)
        wp_enqueue_script(
            'ojt-fym-form-js',
            plugin_dir_url(__FILE__) . 'js/ojt-fym-form.js',
            array('angular-js', 'jquery', 'quill-js'),
            '1.0.2',
            true
        );

        // Google reCAPTCHA v3 (Retrieve site key dynamically)
        $recaptcha_site_key = defined('RECAPTCHA_SITE_KEY') ? RECAPTCHA_SITE_KEY : '';
        wp_enqueue_script(
            'google-recaptcha',
            "https://www.google.com/recaptcha/api.js?render=$recaptcha_site_key",
            array(),
            null,
            true
        );

        // lottie
        wp_enqueue_script(
            'my-lottie-js',
            'https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.10.2/lottie.min.js',
            array('jquery'),
            null,
            true
        );

        wp_localize_script('ojt-fym-form-js', 'adminAjax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'homeUrl' => home_url(),
            'secretKey' => OJT_SECRET_KEY,
            'nonce' => wp_create_nonce('login_nonce'), // ← include everything you need
            'recaptchaSiteKey' => RECAPTCHA_SITE_KEY // ✅ Add this!

        ));

        // social icons footer
        wp_enqueue_style(
            'uil-applicant-dsfg',
            "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        );

        // High Chart Plugins

        // highchart js
        wp_enqueue_script('highchart-js', 'https://code.highcharts.com/highcharts.js', array(), null, true);

        // highchart - exporting
        wp_enqueue_script('highchart-exporting-js', 'https://code.highcharts.com/modules/exporting.js', array(), null, true);

        // highchart - export data
        wp_enqueue_script('highchart-exportdata-js', 'https://code.highcharts.com/modules/export-data.js', array(), null, true);

        // highchart - accessibility
        wp_enqueue_script('hightchart-accessibility', 'https://code.highcharts.com/modules/accessibility.js', array(), null, true);

        // If using custom jQuery version (not recommended unless needed)
        wp_deregister_script('jquery');

        wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js', array(), '3.7.1', true);

        // Bootstrap JS
        // wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), '4.5.2', true);

        // Bootstrap CSS (optional)
        // wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');

        // Enqueue Select2 CSS & JS
        wp_enqueue_style('select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css');

        wp_enqueue_script('select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js', array('jquery'), null, true);
    }
}
add_action('wp_enqueue_scripts', 'home_page_enqueue_script');




// Shortcode to display static HTML landing page
function home_page_landing_page()
{
    ob_start(); ?>




    <!-- 
        Modification of Lorenzo

        @ 03/31/2025
        NOTE:
            -> ng-cloak class="angular-cloak" is important
            -> It ensures that the bootstrap is fully loaded 
            -> This solve the flickering hero-container on load of the website
    -->
    <div class="pt-3 mt-5 px-0 mx-0" ng-app="homeApp" ng-controller="homeController" ng-cloak class="angular-cloak">


        <!-- Modified by Lorenzo @ 03/31/2025 -->

        <!-- Modified by Charls @ 04/10/2025-->

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg fixed-top bg-body-tertiary border border-lg-0">
            <div class="container-fluid">
                <!-- Brand -->
                <a class="navbar-brand" href="#home" ng-click="setActivePage('home')">
                    <img src="<?php echo home_url('/wp-content/uploads/icons/OJTGO-630X310.png') ?>" alt="Logo" style="height: 50px;" class="d-inline-block align-text-center">
                </a>

                <!-- Toggler -->
                <a href="javascript:void(0)" class="homeDropdownToggle navbar-toggler border border-muted bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </a>

                <!-- Collapsible Content -->
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-1 gap-lg-1 mb-2 mb-lg-0" ng-cloak ng-show="isInitialized">

                        <!-- Home navbar -->
                        <li class="nav-item text-start">
                            <a class="nav-link" href="#" ng-click="setActivePage('home')">Home</a>
                        </li>

                        <!-- About Dropdown -->
                        <li class="nav-item dropdown w-100 text-start">
                            <a class="nav-link dropdown-toggle w-100 text-start" id="aboutDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                About
                            </a>
                            <ul class="dropdown-menu w-100" aria-labelledby="aboutDropdown" style="border: none;">
                                <li><a class="dropdown-item" href="#highlights" ng-click="setActivePage('highlights'); scrollToSection('highlights', $event)">Highlights</a></li>
                                <li><a class="dropdown-item" href="#about" ng-click="setActivePage('about'); scrollToSection('about', $event)">About Us</a></li>
                                <li><a class="dropdown-item" href="#contact" ng-click="scrollToSection('contact', $event)">Contact Us</a></li>
                            </ul>
                        </li>

                        <!-- Resources Dropdown -->
                        <li class="nav-item dropdown w-100 text-start">
                            <a class="nav-link dropdown-toggle w-100 text-start" id="resourcesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Resources
                            </a>
                            <ul class="dropdown-menu w-100" aria-labelledby="resourcesDropdown" style="border: none;">
                                <li><a class="dropdown-item" href="#blogs" ng-click="setActivePage('blogs'); scrollToSection('blogs', $event)">Blogs</a></li>
                            </ul>
                        </li>

                        <!-- Help Dropdown -->
                        <li class="nav-item dropdown w-100 text-start">
                            <a class="nav-link dropdown-toggle w-100 text-start" id="helpDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Help
                            </a>
                            <ul class="dropdown-menu w-100" aria-labelledby="helpDropdown" style="border: none;">
                                <li><a class="dropdown-item" href="#how" ng-click="setActivePage('how');">How it works</a></li>
                                <li><a class="dropdown-item" href="#faq" ng-click="setActivePage('faq');">FAQ's</a></li>
                            </ul>
                        </li>

                        <!-- Login/Register -->
                        <li class="nav-item me-2" ng-if="!isLoggedIn">
                            <a class="rounded-3 navbar-btn" href="javascript:void(0)" ng-click="openLoginModalNav()">Login</a>
                        </li>

                        <li class="nav-item dropdown me-4 mt-3 mt-lg-0" ng-if="!isLoggedIn">
                            <a class="rounded-3 navbar-btn" ng-click="openLoginModalNavReg(); show_reg_page_1 = true" href="javascript:void(0)" role="button" aria-expanded="false">Register</a>
                        </li>

                        <!-- Dashboard (if logged in) -->
                        <li class="nav-item dropdown me-0 me-lg-4 mt-3 mt-lg-0" ng-if="isLoggedIn && dashboardUrl">
                            <a class="rounded-3 navbar-btn" ng-href="{{dashboardUrl}}" role="button">Dashboard</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Home section test -->
        <section id="home" ng-show="activePage === 'home'">
            <div class="row justify-content-between flex-grow-1">
                <div class="row justify-content-between align-items-center col-xl-10 col-xxl-8 mx-auto">

                    <!-- Greeter -->
                    <div class="col-md-7 col-xxl-6" id="page-top" style="margin-top: 100px;">
                        <div class="h-100 d-flex flex-column justify-content-between">
                            <img src="/wp-content/uploads/icons/OJTGO-630X310.png" alt="Logo" class="img-fluid mb-3">
                            <h3 class="fw-bold">Built by students, for students</h3>

                            <p class="mt-4">
                                A system built to empower students by connecting them with the right opportunities for their growth and success.
                            </p>
                            <div class="mt-3">
                                <!-- Show if logged in as applicant -->
                                <a
                                    ng-if="isLoggedIn"
                                    ng-href="{{dashboardUrl}}"
                                    class="btn btn-primary text-white">
                                    Find a Match
                                </a>

                                <!-- Show if not logged in -->
                                <a
                                    ng-if="!isLoggedIn"
                                    href="/"
                                    class="btn btn-primary text-white">
                                    Find a Match
                                </a>
                            </div>

                        </div>
                    </div>

                    <!-- Lottie Animation -->
                    <div class="col-md-5 col-xxl-6 d-flex justify-content-center align-items-center">
                        <div id="teamwork_2" style="height: 100%; width: 100%; max-height: 500px;"></div>
                    </div>

                </div> <!-- END row justify-content-between align-items-center -->
            </div> <!-- END main row -->

        </section>

        <!-- Why OJT Jobs Section -->
        <section id="whyojtgo" ng-show="activePage === 'home' || activePage === 'whyojtgo'" style="margin-top: 100px; margin-bottom: 100px;">
            <h1 class="display-4 text-primary fw-bold text-center fs-2 mb-4">Why OJTGo?</h1>
            <div class="container">
                <div class="row justify-content-center">

                    <!-- Seamless Matching -->
                    <div class="col-12 col-md-6 mb-4">
                        <div class="h-100 shadow rounded-2 border-muted p-3 bg-light d-flex flex-column">
                            <div id="realtime-lottie" style="height: 200px;"></div>
                            <div class="text-center mt-auto">
                                <h2 class="fw-bold">Seamless Matching</h2>
                                <p>Our advanced system matches students with internship opportunities based on their skills, academic background, and interests.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Smarter than a resume -->
                    <div class="col-12 col-md-6 mb-4">
                        <div class="h-100 shadow rounded-2 border-muted p-3 bg-light d-flex flex-column">
                            <div id="virtual" style="height: 200px;"></div>
                            <div class="text-center mt-auto">
                                <h2 class="fw-bold">Smarter Than a Resume </h2>
                                <p>Our patent-pending digital employment profile is more than just a resume replacement—it’s built for real time and efficient job matching.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Diverse Opportunities -->
                    <div class="col-12 col-md-6 mb-4">
                        <div class="h-100 shadow rounded-2 border-muted p-3 bg-light d-flex flex-column">
                            <div id="magnify-job-lottie" style="height: 200px;"></div>
                            <div class="text-center mt-auto">
                                <h2 class="fw-bold">Diverse Opportunities</h2>
                                <p>We connect students with industries through GeoMatch Listing, helping them find nearby internships while ensuring diverse opportunities.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Workforce-Ready -->
                    <div class="col-12 col-md-6 mb-4">
                        <div class="h-100 shadow rounded-2 border-muted p-3 bg-light d-flex flex-column">
                            <div id="rocket-lottie" style="height: 200px;"></div>
                            <div class="text-center mt-auto">
                                <h2 class="fw-bold">Workforce-Ready</h2>
                                <p>By connecting students with the right opportunities, OJTGo helps prepare future professionals with practical experience before entering the job market.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- DPO Section -->
        <section id="dpo" ng-show="activePage === 'home' || activePage === 'dpo'" class="py-4 bg-white">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Description on the left -->
                    <div class="col-md-8">
                        <p class="mt-5">
                            PCES has been awarded the NPC Seal of Registration for complying with the
                            Data Privacy Act of 2012 and related regulations. The certificate attests that
                            PCES Inc. has taken necessary measures to safeguard user privacy and data security.
                        </p>
                    </div>

                    <!-- Logo on the right -->
                    <div class="col-md-4 text-center">
                        <img src="<?php echo home_url('/wp-content/uploads/icons/dpo.jpg') ?>" alt="DPO Logo" class="img-fluid" style="max-width: 200px;">
                    </div>
                </div>
            </div>
        </section>

        <!-- how it works section -->
        <section id="how" ng-show="activePage === 'how'" class="py-5">
            <div class="container">

                <div class="how-it-works-content p-3 rounded-bottom" style="background: linear-gradient(to bottom, rgb(0, 43, 86) 0%, white 50%);">
                    <h1 class="display-4 text-white fw-bold fs-2 text-center p-3 rounded-top">
                        How OJTGo Works
                    </h1>

                    <div class="row g-4 mt-1">
                        <!-- Step 1 -->
                        <div class="col-md-6 col-lg-3">
                            <div class="step-box h-100 p-4 d-flex flex-column">
                                <div class="step-number-container text-center mb-3">
                                    <div class="step-number mx-auto">1</div>
                                </div>
                                <div id="step1" class="lottie-animation mb-3"></div>
                                <div class="step-content flex-grow-1">
                                    <h3 class="step-title text-center">Step 1: Register & Build Your Profile</h3>
                                    <p class="step-description text-center">Sign up at www.ojtgo.com and create your student profile.
                                        Smarter than a resume—simply share your course, skills, location, internship preferences,
                                        and any relevant experiences or certifications. Our system showcases you directly to potential host companies.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="col-md-6 col-lg-3">
                            <div class="step-box h-100 p-4 d-flex flex-column">
                                <div class="step-number-container text-center mb-3">
                                    <div class="step-number mx-auto">2</div>
                                </div>
                                <div id="step2" class="lottie-animation mb-3"></div>
                                <div class="step-content flex-grow-1">
                                    <h3 class="step-title text-center">Step 2: Get Matched & Explore Opportunities</h3>
                                    <p class="step-description text-center">Once your profile is complete, OJTGo automatically connects you
                                        with real, verified companies based on your academic background, skills, and preferences. You’ll also
                                        discover nearby internships through GeoMatch, making it easier to find opportunities that fit.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="col-md-6 col-lg-3">
                            <div class="step-box h-100 p-4 d-flex flex-column">
                                <div class="step-number-container text-center mb-3">
                                    <div class="step-number mx-auto">3</div>
                                </div>
                                <div id="step3" class="lottie-animation mb-3"></div>
                                <div class="step-content flex-grow-1">
                                    <h3 class="step-title text-center">Step 3: Apply & Connect</h3>
                                    <p class="step-description text-center">Receive match notifications through your dashboard and email. Apply to
                                        multiple internships and use the platform’s built-in messaging to chat directly with employers. Interviews
                                        are done online—quick, easy, and no travel required.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="col-md-6 col-lg-3">
                            <div class="step-box h-100 p-4 d-flex flex-column">
                                <div class="step-number-container text-center mb-3">
                                    <div class="step-number mx-auto">4</div>
                                </div>
                                <div id="step4" class="lottie-animation mb-3"></div>
                                <div class="step-content flex-grow-1">
                                    <h3 class="step-title text-center">Step 4: Start Your OJT</h3>
                                    <p class="step-description text-center">Once you’re accepted, coordinate directly with your host company and start your internship journey.
                                        Gain practical, hands-on experience without the usual stress or extra costs—so you can stay focused on graduation and your goals</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- why ojtgo works for you -->
                    <div class="container mt-5">
                        <h2 class="text-center fw-bold" style="background: linear-gradient(to right, #002B56, #006494); -webkit-background-clip: text; color: transparent;">
                            Why OJTGo Works for You?
                        </h2>


                        <div class="row mt-4 align-items-center">
                            <!-- Left Column: List of Features -->
                            <div class="col-md-6">
                                <div class="list-group">
                                    <div class="list-group-item d-flex justify-content-start align-items-center">
                                        <i class="bi bi-file-earmark-text me-4 text-primary" style="font-size: 1.5rem;"></i>
                                        <div>
                                            <strong>Smarter than a resume</strong><br>
                                            Your profile says it all.
                                        </div>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-start align-items-center">
                                        <i class="bi bi-arrow-right-circle me-4 text-primary" style="font-size: 1.5rem;"></i>
                                        <div>
                                            <strong>Seamless matching system</strong><br>
                                            No more endless searching.
                                        </div>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-start align-items-center">
                                        <i class="bi bi-check-circle me-4 text-primary" style="font-size: 1.5rem;"></i>
                                        <div>
                                            <strong>Verified companies only</strong><br>
                                            Real, reliable opportunities.
                                        </div>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-start align-items-center">
                                        <i class="bi bi-person-badge me-4 text-primary" style="font-size: 1.5rem;"></i>
                                        <div>
                                            <strong>Designed by former interns</strong><br>
                                            We understand your needs.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Message -->
                            <div class="col-md-6 mt-4 mt-md-0">
                                <div class="card text-center p-4 rounded shadow-lg" style="background: linear-gradient(to right, #002B56, #006494); color: white;">
                                    <div class="card-body">
                                        <p class="card-text mb-0">
                                            <strong>OJTGo isn’t just a tool</strong> — it’s our solution to a problem we faced ourselves.<br>
                                            Let’s make your internship journey easier, together.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

            <!-- Video Demo Section -->
            <div class="container mt-5">
                <h2 class="text-center fw-bold" style="color:rgb(0, 43, 86);">Watch OJTGo in Action</h2>
                <p class="text-center mb-4">See how OJTGo works from both the Student and Employer perspectives.</p>

                <div class="row g-4">

                    <!-- Student Side Video -->
                    <div class="col-md-6">
                        <div class="card shadow-sm h-100 border-0">
                            <div class="card-header text-white fw-semibold text-center" style="background-color: rgb(0, 43, 86);">
                                Student Walkthrough
                            </div>
                            <div class="card-body p-0">
                                <div class="ratio ratio-16x9">
                                    <iframe
                                      width="100%"
                                      height="100%"
                                      src="https://www.youtube.com/embed/4Y3lLjOZkc4?rel=0"
                                      title="Student Side Demo"
                                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                      allowfullscreen
                                      style="border:0;">
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Employer Side Video -->
                    <div class="col-md-6">
                        <div class="card shadow-sm h-100 border-0">
                            <div class="card-header text-white fw-semibold text-center" style="background-color: rgb(0, 43, 86);">
                                Employer Walkthrough
                            </div>
                            <div class="card-body p-0">
                                <div class="ratio ratio-16x9">
                                    <iframe
                                      width="100%"
                                      height="100%"
                                      src="https://www.youtube.com/embed/ToQ9amprkvk?rel=0"
                                      title="Employer Side Demo"
                                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                      allowfullscreen
                                      style="border:0;">
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section id="faq" ng-show="activePage === 'faq'" class="py-5 bg-white">
            <div class="container">

                <div class="faq-content p-4 rounded shadow" style="background: linear-gradient(to bottom,rgb(255, 255, 255) 0%, #f9f9f9 100%);">
                    <!-- Heading -->
                    <h1 class="display-4 fw-bold fs-2 text-center mb-4" style="color: #002b56;">
                        Frequently Asked Questions
                    </h1>

                    <div class="mx-auto" style="max-width: 900px;">
                        <!-- Tabs -->
                        <div class="d-flex justify-content-center gap-3 mb-4">
                            <button class="custom-tab-button" ng-click="faqTab = 'ojtgo'">OJTGo</button>
                            <button class="custom-tab-button" ng-click="faqTab = 'student'">Student</button>
                            <button class="custom-tab-button" ng-click="faqTab = 'employer'">Employer</button>
                        </div>

                        <!-- FAQ List (Single Container) -->
                        <div class="accordion">
                            <!-- Unified ng-switch style -->
                            <div ng-switch="faqTab">

                                <!-- OJTGo FAQs -->
                                <div ng-switch-when="ojtgo">
                                    <div class="faq-item" ng-repeat="faq in ojtgoFaqs">
                                        <div class="border-bottom py-2" ng-click="toggleFaq(ojtgoFaqs, $index)" style="cursor: pointer;">
                                            {{ faq.question }}
                                            <span class="float-end">{{ faq.open ? '−' : '+' }}</span>
                                        </div>

                                        <div class="ps-3 pt-1 pb-2 text-dark rounded mb-3"
                                            ng-show="faq.open"
                                            style="background: linear-gradient(to top,rgb(217, 223, 229),rgb(255, 255, 255), rgb(255, 255, 255));">
                                            <p ng-if="faq.answer.paragraph">{{ faq.answer.paragraph }}</p>
                                            <ul ng-if="faq.answer.list" class="no-bullets">
                                                <li ng-repeat="item in faq.answer.list">{{ item }}</li>
                                            </ul>
                                        </div>


                                    </div>
                                </div>

                                <!-- Student FAQs -->
                                <div ng-switch-when="student">
                                    <div class="faq-item" ng-repeat="faq in studentFaqs">
                                        <div class="border-bottom py-2" ng-click="toggleFaq(studentFaqs, $index)" style="cursor: pointer;">
                                            {{ faq.question }}
                                            <span class="float-end">{{ faq.open ? '−' : '+' }}</span>
                                        </div>

                                        <div class="ps-3 pt-1 pb-2 text-dark rounded mb-3"
                                            ng-show="faq.open"
                                            style="background: linear-gradient(to top,rgb(217, 223, 229),rgb(255, 255, 255), rgb(255, 255, 255));">
                                            <p ng-if="faq.answer.paragraph">{{ faq.answer.paragraph }}</p>
                                            <ul ng-if="faq.answer.list" class="no-bullets">
                                                <li ng-repeat="item in faq.answer.list">{{ item }}</li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>

                                <!-- Employer FAQs -->
                                <div ng-switch-when="employer">
                                    <div class="faq-item" ng-repeat="faq in employerFaqs">
                                        <div class="border-bottom py-2" ng-click="toggleFaq(employerFaqs, $index)" style="cursor: pointer;">
                                            {{ faq.question }}
                                            <span class="float-end">{{ faq.open ? '−' : '+' }}</span>
                                        </div>

                                        <div class="ps-3 pt-1 pb-2 text-dark rounded mb-3"
                                            ng-show="faq.open"
                                            style="background: linear-gradient(to top,rgb(217, 223, 229),rgb(255, 255, 255), rgb(255, 255, 255));">
                                            <p ng-if="faq.answer.paragraph">{{ faq.answer.paragraph }}</p>
                                            <ul ng-if="faq.answer.list" class="no-bullets">
                                                <li ng-repeat="item in faq.answer.list">{{ item }}</li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
        </section>

        <!-- Blogs Section -->
        <section id="blogs" ng-show="activePage === 'blogs'" class="bg-white py-5">
            <div class="container">
                <!-- Section Title -->
                <h1 class="display-4 text-white fw-semibold fs-3 text-center p-3 rounded" style="background-color: rgb(0, 43, 86);">
                    Our Latest Blogs
                </h1>

                 <!-- Blog card -->
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    <div class="col" ng-repeat="blog in blogs">
                        <div class="card h-100 shadow-sm border-0 rounded-4 p-3 bg-white d-flex flex-column"
                            style="transition: all 0.3s ease; cursor: pointer;">

                            <!-- Blog Media -->
                            <img ng-if="blog.image"
                                ng-src="{{blog.image}}"
                                loading="lazy"
                                class="card-img-top rounded"
                                alt="{{blog.title}}"
                                style="max-height: 200px; object-fit: cover;">

                            <!-- Blog Content -->
                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{blog.title}}</h5>
                                <small class="text-muted">
                                  {{ getFormattedDate(post.date) }}
                                </small>

                                <!-- Collapsed Quill-rendered preview -->
                                <div class="card-text mt-2">
                                    <div ng-bind-html="blog.descriptionUnescaped | limitHtmlTo: 150"></div>
                                    <span class="text-primary fw-semibold"
                                        ng-click="modalExpansion(blog)"
                                        data-bs-toggle="modal"
                                        data-bs-target="#blogModal">
                                        See More
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div ng-if="blogs.length === 0" class="text-muted mt-3">No blog found.</div>
            </div>
        </section>

        <!-- Highlights section -->
        <section id="highlights" ng-show="activePage === 'highlights'" class="bg-white py-5">
            <div class="container">
                <h1 class="display-4 text-white fw-semibold fs-3 text-center p-3 rounded mb-5" style="background-color: rgb(0, 43, 86);">
                    OJTGo Highlights
                </h1>

                <!-- Highlight Filters (Buttons) -->
                <div class="container">
                    <div class="d-flex flex-wrap justify-content-center gap-2 mb-3">
                        <button class="btn btn-outline-primary"
                            ng-class="{'active': activeHighlight === 'all'}"
                            ng-click="activeHighlight='all'">
                            All
                        </button>
                        <button class="btn btn-outline-primary"
                            ng-class="{'active': activeHighlight === 'news'}"
                            ng-click="activeHighlight = 'news'">
                            News
                        </button>
                        <button class="btn btn-outline-primary"
                            ng-class="{'active': activeHighlight === 'testimonial'}"
                            ng-click="activeHighlight = 'testimonial'">
                            Testimonials
                        </button>
                        <button class="btn btn-outline-primary"
                            ng-class="{'active': activeHighlight === 'facebook'}"
                            ng-click="activeHighlight = 'facebook'">
                            Facebook
                        </button>
                        <button class="btn btn-outline-primary"
                            ng-class="{'active': activeHighlight === 'instagram'}"
                            ng-click="activeHighlight = 'instagram'">
                            Instagram
                        </button>
                        <button class="btn btn-outline-primary"
                            ng-class="{'active': activeHighlight === 'tiktok'}"
                            ng-click="activeHighlight = 'tiktok'">
                            TikTok
                        </button>
                    </div>
                </div>

                <hr class="mx-auto my-4" style="width: 80%; color: #001F3F;">

                <!-- Highlights Grid -->
                <div class="row g-3 scrollable-row">

                    <div class="fw-bold mb-4 mt-5 fs-4" style="color: #001F3F">
                        Get the latest updates, features, and opportunities to boost your job search.
                    </div>

                    <div class="col-md-4 pb-3" ng-show="activeHighlight === 'all'" ng-repeat="post in filteredHighlights " id="post-{{post.id}}">

                        <!-- News -->
                        <div ng-show="post.type === 'news'"
                            class="card h-80 shadow-sm border-0 rounded-4 pb-3 bg-white d-flex flex-column"
                            style="transition: all 0.3s ease; cursor: pointer;">

                            <div class="flex-grow-1 d-flex flex-column ms-3">
                                <small class="text-muted">
                                  {{ getFormattedDate(post.date) }}
                                </small>
                                <h5 class="card-title my-2">{{ post.title }}</h5>

                                <!-- Collapsed Description -->
                                <div class="card-text mt-2">
                                    <div ng-bind-html="post.description | limitHtmlTo: 150"></div>
                                </div>

                                <!-- See More Button -->
                                <div class="mt-auto p-2">
                                    <span class="text-primary fw-semibold d-inline-flex align-items-center gap-1"
                                        ng-click="modalExpansion(post)"
                                        data-bs-toggle="modal" data-bs-target="#blogModal">
                                        See More
                                        <i class="fas fa-arrow-right ms-1" aria-hidden="true" style="font-size: 0.5rem;"></i>
                                    </span>
                                </div>
                            </div>
                        </div>


                        <!-- Testimonial Card -->
                        <div ng-show="post.type === 'testimonial'"
                            class="card h-100 shadow-sm border-0 rounded-4 p-3 bg-light d-flex flex-column"
                            style="max-height: 300px;">

                            <div class="card-body d-flex flex-column h-100" style="min-height: 0;">

                                <!-- Quote Icon & Date -->
                                <div class="mb-2 text-primary position-relative" style="font-size: 2rem; line-height: 1;">
                                    <small class="text-muted position-absolute" style="top: 0; right: 0; font-size: 0.85rem;">
                                      {{ getFormattedDate(post.date) }}
                                    </small>
                                    <i class="fas fa-quote-right"></i>
                                </div>

                                <!-- Description with ellipsis -->
                                <div class="text-center fw-semibold flex-grow-1 mb-2 overflow-hidden text-truncate"
                                    style="font-size: 15px; max-height: 90px; text-overflow: ellipsis; white-space: normal; overflow: hidden;">
                                    <div ng-bind-html="post.descriptionUnescaped | trustAsHtml"></div>
                                </div>

                                <!-- Footer with Profile & Eye Icon -->
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                                    <div class="d-flex align-items-center">
                                        <img ng-src="{{post.image}}" loading="lazy" alt="{{post.title}}"
                                            class="rounded-circle me-2"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0">{{ post.title }}</h6>
                                            <small class="text-muted">{{ post.role }}</small>
                                        </div>
                                    </div>

                                    <!-- ✅ Eye Icon (only this triggers modal) -->
                                    <button class="btn btn-sm text-primary"
                                        ng-click="modalExpansion(post)"
                                        data-bs-toggle="modal" data-bs-target="#blogModal"
                                        aria-label="View Full Testimonial">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>


                        <!-- Facebook Card -->
                        <div ng-show="post.type === 'facebook'" class="card h-100 border-0 shadow-sm d-flex flex-column" style="background-color: #e7f0fd; max-height: 300px;">
                            <div class="card-body d-flex flex-column h-100" style="overflow-y: auto; min-height: 0;">
                                <small class="text-muted">
                                      {{ getFormattedDate(post.date) }}
                                </small>
                                <h5 class="card-title mt-2">{{post.title}}</h5>

                                <!-- QuillJS Viewer for Facebook -->
                                <div ng-bind-html="post.description | trustAsHtml" style="min-height:60px; max-height:auto; overflow:auto;"></div>

                                <a ng-href="{{post.link}}" target="_blank" class="mt-auto text-primary fw-semibold d-inline-flex align-items-center gap-1">
                                    See more on Facebook
                                    <i class="fas fa-hand-point-left ms-1" aria-hidden="true" style="font-size: 1rem;"></i>
                                </a>

                            </div>
                        </div>

                        <!-- Instagram Card -->
                        <div ng-show="post.type === 'instagram'" class="card h-100 border-0 shadow-sm d-flex flex-column" style="background-color: #fff0f6; max-height: 300px;">
                            <div class="card-body d-flex flex-column h-100" style="overflow-y: auto; min-height: 0;">
                                    <small class="text-muted">
                                      {{ getFormattedDate(post.date) }}
                                    </small>
                                <h5 class="card-title mt-2">{{ post.title | unescape }}</h5>

                                <!-- QuillJS Viewer for Instagram -->
                                <div ng-bind-html="post.description | trustAsHtml" style="min-height: 60px; max-height: auto; overflow: auto;"></div>

                                <!-- Aligned at the bottom -->
                                <div class="mt-auto pt-2">
                                    <a ng-href="{{post.link}}" target="_blank" class="mt-3 text-danger fw-semibold d-inline-flex align-items-center gap-1">
                                        View on Instagram
                                        <i class="fas fa-hand-point-left ms-1" aria-hidden="true" style="font-size: 1rem;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>


                        <!-- TikTok Card -->
                        <div ng-show="post.type === 'tiktok'" class="card h-100 border-0 shadow-sm" style="background-color: #f0f0f0; max-height: 300px;">
                            <div class="card-body d-flex flex-column" style="overflow-y: auto; min-height: 0;">
                                <small class="text-muted">
                                      {{ getFormattedDate(post.date) }}
                                </small>
                                <h5 class="card-title mt-2">{{post.title}}</h5>
                                <!-- QuillJS Viewer for TikTok -->
                                <div ng-bind-html="post.description | trustAsHtml" style="min-height:60px; max-height:auto; overflow:auto;"></div>
                                <a ng-href="{{post.link}}" class="mt-auto text-dark fw-semibold d-inline-flex align-items-center gap-1" target="_blank">
                                    Watch on TikTok
                                    <i class="fas fa-hand-point-left ms-1" aria-hidden="true" style="font-size: 1rem;"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Specified post -->
                <!-- News Section -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4" ng-show="activeHighlight === 'news'"
                        ng-repeat="post in filteredHighlights | orderBy:'-date'">

                        <div class="card h-100 shadow-sm border-0 rounded-4 p-3 d-flex flex-column"
                            style="background-color: white; transition: all 0.3s ease; cursor: pointer;">

                            <div class="d-flex flex-column h-100">
                                <!-- Date and Title -->
                                <small class="text-muted">
                                  {{ getFormattedDate(post.date) }}
                                </small>
                                <h5 class="card-title my-2">{{ post.title }}</h5>

                                <!-- Collapsed Description -->
                                <div class="card-text mt-2">
                                    <div ng-bind-html="post.description | limitHtmlTo: 150"></div>
                                </div>

                                <!-- See More -->
                                <div class="mt-auto pt-2">
                                    <span class="text-primary fw-semibold d-inline-flex align-items-center gap-1"
                                        ng-click="modalExpansion(post)"
                                        data-bs-toggle="modal" data-bs-target="#blogModal">
                                        See More
                                        <i class="fas fa-arrow-right ms-1" aria-hidden="true" style="font-size: 1rem;"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Testimonials -->
                <div class="row g-3" ng-show="activeHighlight === 'testimonial'">
                    <div class="col-md-4" ng-repeat="post in filteredHighlights | orderBy:'-date'">

                        <!-- Testimonial Card -->
                        <div class="card h-100 shadow-sm border-0 rounded-4 p-3 bg-light d-flex flex-column" style="max-height: 300px;">
                            <div class="card-body d-flex flex-column h-100" style="min-height: 0;">

                                <!-- Quote Icon & Date -->
                                <div class="mb-2 text-primary position-relative" style="font-size: 2rem; line-height: 1;">
                                    <small class="text-muted position-absolute" style="top: 0; right: 0; font-size: 0.85rem;">
                                      {{ getFormattedDate(post.date) }}
                                    </small>
                                    <i class="fas fa-quote-right"></i>
                                </div>

                                <!-- Description with ellipsis -->
                                <div class="text-center fw-semibold flex-grow-1 mb-2 overflow-hidden text-truncate"
                                    style="font-size: 15px; max-height: 90px; text-overflow: ellipsis; white-space: normal; overflow: hidden;">
                                    <div ng-bind-html="post.descriptionUnescaped | trustAsHtml"></div>
                                </div>

                                <!-- Footer with Profile & Eye Icon -->
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                                    <div class="d-flex align-items-center">
                                        <img ng-src="{{post.image}}" loading="lazy" alt="{{post.title}}"
                                            class="rounded-circle me-2"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0">{{ post.title }}</h6>
                                            <small class="text-muted">{{ post.role }}</small>
                                        </div>
                                    </div>

                                    <!-- Eye Icon -->
                                    <button class="btn btn-sm text-primary"
                                        ng-click="modalExpansion(post)"
                                        data-bs-toggle="modal" data-bs-target="#blogModal"
                                        aria-label="View Full Testimonial">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <!-- Facebook -->
                <div class="row g-3" ng-show="activeHighlight === 'facebook'">
                    <div class="col-md-4" ng-repeat="post in filteredHighlights | orderBy:'-date'">
                        <div class="card h-100 border-0 shadow-sm d-flex flex-column" style="background-color: #e7f0fd; max-height: 300px;">
                            <div class="card-body d-flex flex-column h-100" style="overflow-y: auto; min-height: 0;">
                                <small class="text-muted">
                                      {{ getFormattedDate(post.date) }}
                                </small>
                                <h5 class="card-title mt-2">{{post.title}}</h5>

                                <!-- QuillJS Viewer for Facebook -->
                                <div ng-bind-html="post.description | trustAsHtml" style="min-height:60px; max-height:120px; overflow:auto;"></div>

                                <a ng-href="{{post.link}}" target="_blank" class="mt-auto text-primary fw-semibold d-inline-flex align-items-center gap-1">
                                    See more on Facebook
                                    <i class="fas fa-hand-point-left ms-1" aria-hidden="true" style="font-size: 1rem;"></i>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Instagram -->
                <div class="row g-3" ng-show="activeHighlight === 'instagram'">
                    <div class="col-md-4" ng-repeat="post in filteredHighlights | orderBy:'-date'">
                        <div class="card h-100 border-0 shadow-sm" style="background-color: #fff0f6; max-height: 300px;">
                            <div class="card-body d-flex flex-column" style="overflow-y: auto; min-height: 0;">
                                <small class="text-muted">
                                      {{ getFormattedDate(post.date) }}
                                </small>
                                <h5 class="card-title mt-2">{{ post.title | unescape }}</h5>

                                <!-- QuillJS Viewer for Instagram -->
                                <div ng-bind-html="post.description | trustAsHtml" style="min-height:60px; max-height:120px; overflow:auto;"></div>

                                <a ng-href="{{post.link}}" target="_blank" class="mt-auto text-danger fw-semibold d-inline-flex align-items-center gap-1">
                                    View on Instagram
                                    <i class="fas fa-hand-point-left ms-1" aria-hidden="true" style="font-size: 1rem;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TikTok -->
                <div class="row g-3" ng-show="activeHighlight === 'tiktok'">
                    <div class="col-md-4" ng-repeat="post in filteredHighlights | orderBy:'-date'">
                        <div class="card h-100 border-0 shadow-sm" style="background-color: #f0f0f0; max-height: 300px;">
                            <div class="card-body d-flex flex-column" style="overflow-y: auto; min-height: 0;">
                                <small class="text-muted">
                                      {{ getFormattedDate(post.date) }}
                                </small>
                                <h5 class="card-title mt-2">{{post.title}}</h5>

                                <!-- QuillJS Viewer for TikTok -->
                                <div ng-bind-html="post.description | trustAsHtml" style="min-height:60px; max-height:120px; overflow:auto;"></div>

                                <a ng-href="{{post.link}}" target="_blank" class="mt-auto text-dark fw-semibold d-inline-flex align-items-center gap-1">
                                    Watch on TikTok
                                    <i class="fas fa-hand-point-left ms-1" aria-hidden="true" style="font-size: 1rem;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        
        <!-- Unified Modal -->
        <div class="modal fade" id="blogModal" tabindex="-1" aria-labelledby="unifiedModalLabel" aria-hidden="true" data-bs-focus="false" >
            <!-- <pre>{{ selectedModal | json }}</pre> -->

            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <!-- Show modal content when any post is selected -->
                <div class="modal-content" ng-show="selectedModal">

                    <!-- Modal Header -->
                    <div class="modal-header d-flex justify-content-between align-items-start flex-column flex-md-row">
                        <h5 class="modal-type" id="unifiedModalLabel">{{ selectedModal.type | capitalize }}</h5>
                        <div class="text-muted small ms-md-auto mt-2 mt-md-0">
                            {{ getFormattedDate(post.date) }}
                        </div>
                    </div>


                    <!-- Modal Body -->
                    <div class="modal-body">

                        <!-- Blog Layout -->
                        <div ng-show="selectedModal.type === 'blog'">
                            <img ng-show="selectedModal.image"
                                ng-src="{{selectedModal.image}}"
                                class="img-fluid rounded-3 mb-3 d-block mx-auto"
                                alt="{{selectedModal.title}}"
                                style="max-height: 300px; object-fit: cover;">
                            <div class="quill-wrapper">
                                <div ng-bind-html="selectedModal.descriptionUnescaped | trustAsHtml"></div>
                            </div>
                        </div>

                        <!-- News Layout -->
                        <div ng-show="selectedModal.type === 'news'">
                            <img ng-show="selectedModal.image"
                                ng-src="{{selectedModal.image}}"
                                class="img-fluid rounded-3 mb-3 d-block mx-auto"
                                alt="{{selectedModal.title}}"
                                style="max-height: 300px; object-fit: cover;">
                            <h6>{{selectedModal.title}}</h6>
                            <div ng-bind-html="selectedModal.description | trustAsHtml"></div>
                        </div>

                        <!-- Testimonial Layout -->
                        <div ng-show="selectedModal.type === 'testimonial'">

                            <!-- Author Info at top -->
                            <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                                <img ng-src="{{selectedModal.image}}" alt="{{selectedModal.title}}"
                                    class="rounded-circle me-3"
                                    style="width: 60px; height: 60px; object-fit: cover;">
                                <div>
                                    <h6 class="mb-0">{{ selectedModal.title }}</h6>
                                    <small class="text-muted">{{ selectedModal.role }}</small>
                                </div>
                            </div>

                            <!-- Quotation Icon aligned left -->
                            <div class="text-primary mb-3" style="font-size: 2.5rem;">
                                <i class="fas fa-quote-left"></i>
                            </div>

                            <!-- Full Description -->
                            <div ng-bind-html="selectedModal.descriptionUnescaped | trustAsHtml"
                                class="mb-4"
                                style="font-size: 15px;"></div>
                        </div>



                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal"
                            ng-click="modalExpansion(null)">
                            Close
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Privacy Notice section -->
        <section id="privacy" ng-show="activePage === 'privacy'" class="bg-light py-5 bg-transparent">
            <div class="container">
                <h1 class="display-4 text-white fw-semibold fs-3 text-center p-3 rounded" style="background-color:rgb(0, 43, 86);">
                    Privacy Notice
                </h1>

                <div style="background-color: rgba(0, 0, 0, 0.47); color: white; padding: 2rem; border-radius: 8px;">

                    <p>At <strong>OJTGo</strong>, owned and operated by <strong>PCES Inc.</strong>, we are committed to protecting the privacy of all users—especially interns, employers,
                        and OJT coordinators—who use our platform to facilitate On-the-Job Training (OJT) experiences. This Privacy Notice explains how we collect, use, store, and share your
                        information in accordance with the <a href="https://privacy.gov.ph/data-privacy-act/" target="_blank" rel="noopener noreferrer" style="color: deepskyblue;"><strong><u>Privacy Act of 2012</u></strong></a> and related guidelines from the <strong>National Privacy Commission (NPC)</strong>. By using <strong>OJTGo</strong>, you agree to the practices
                        described in this notice. We encourage you to read it carefully.</p><br>
                    <h4>1. Information We Collect</h4>
                    <p><strong>a) Intern Information</strong><br>
                        When interns register on OJTGo, we collect the following information:
                    </p>
                    <ul>
                        <li>Name, birthdate, email address, and phone number</li>
                        <li>Educational background, academic course, and required OJT hours</li>
                        <li>Skills, personal preferences, and availability</li>
                    </ul><br>

                    <p><strong>b) Character References</strong><br>
                        If references are added, interns must provide names, job titles, and contact details. It is the intern’s responsibility to obtain prior consent from these individuals before sharing their data.
                    </p><br>

                    <p><strong>c) Employer/Entity Information</strong><br>
                        Employers must provide:
                    </p>
                    <ul>
                        <li>Company name, industry, and contact information</li>
                        <li>Business documents for verification</li>
                        <li>Details about internship posts (e.g., requirements, duration, responsibilities)</li>
                    </ul><br>

                    <p><strong>d) OJT Coordinators</strong><br>
                        Coordinators register with academic institution details and create unique coordinator codes for interns to use when linking their accounts.
                    </p><br>

                    <p><strong>e) Non-Personal Information</strong><br>
                        We collect device and browser info, IP address, and usage activity to improve system performance and user experience.</p><br>

                    <h4><strong>2. How We Use Your Information</strong></h4>
                    <p>Your information is used for the following purposes:</p>
                    <ul>
                        <li>Match interns to suitable internship positions based on skills, availability, and preferences</li>
                        <li>Facilitate job applications, communication, and system notifications</li>
                        <li>Allow interns to log Daily Time Records (DTR), submit reports, and track internship completion</li>
                        <li>Provide OJT Coordinators with access to supervise and validate intern progress</li>
                        <li>Generate system analytics to improve platform features and ensure proper service delivery</li>
                        <li>Comply with legal, institutional, and regulatory requirements</li>
                        <li>Send optional announcements or promotional emails (only with your consent)</li>
                    </ul><br>

                    <h4><strong>3. Information Sharing</strong></h4>
                    <p>Your data may be shared with:</p>
                    <ul>
                        <li>Employers, when you apply for an internship</li>
                        <li>Interns, when viewing details of matching opportunities</li>
                        <li>OJT Coordinators, for academic monitoring and assessment</li>
                        <li>Service providers, for hosting, storage, and security (under strict confidentiality agreements)</li>
                        <li>Government or legal authorities, if required by law, court order, or subpoena</li>
                    </ul><br>

                    <p>We do not sell or lease your personal data to any third party.</p><br>

                    <h4>4. Data Security</h4>
                    <p>OJTGo implements technical and organizational measures to protect your data:</p>
                    <ul>
                        <li>HTTPS encryption of all data transmissions</li>
                        <li>Web Application Firewall (WAF) to block threats</li>
                        <li>Access control is limited to authorized personnel</li>
                        <li>Regular security audits and vulnerability assessments</li>
                    </ul><br>

                    <p>Disclaimer: While we take strong precautions, no system is 100% secure. We continuously improve our security infrastructure to reduce risks.
                    </p><br>

                    <h3>5. Cookies and Tracking</h3>
                    <p>We use cookies and tracking tools to:</p>
                    <ul>
                        <li>Personalize your experience</li>
                        <li>Understand usage patterns</li>
                        <li>Recommend location-based opportunities (with your consent)</li>
                    </ul><br>

                    <p>
                        You may manage or disable cookies and location tracking in your browser or device settings.
                    </p><br>

                    <h4>6. Your Privacy Choices</h4>
                    <p>You may exercise the following at any time:</p>
                    <ul>
                        <li>Update your profile through your account dashboard</li>
                        <li>Manage communication preferences, including unsubscribing from emails</li>
                        <li>Access or delete your personal data, subject to retention rules outlined below</li>
                    </ul><br>

                    <p>For sensitive actions (e.g., account deletion), some verification steps or coordinator approval may be required.</p><br>

                    <h4>7. Retention of Personal Information</h4>

                    <p><strong>a) General Retention Policy</strong><br>
                        We retain personal data for only one (1) year, unless required longer by law, accreditation, or academic compliance.</p><br>

                    <p><strong>b) Specific Retention Schedules</strong><br>
                        <strong>Intern data:</strong> Retained during account activity and up to 1 year after deactivation or inactivity.<br>
                        <strong>Employer data:</strong> Retained up to 1 year after account deletion.<br>
                        <strong>Job applications:</strong> Retained up to 1 year for reference and record keeping.<br>
                        <strong>DTR logs and reports:</strong> Stored for 1 year after internship completion or account deletion.<br>
                        <strong>Coordinator data:</strong> Retained for up to 1 year after account deactivation.
                    </p><br>

                    <p><strong>c) Legal or Institutional Exceptions</strong><br>
                        Some data may be retained longer to meet institutional audit requirements or legal obligations.</p><br>

                    <p><strong>d) Data Minimization and Security</strong><br>
                        We strictly collect only necessary data and apply encryption and access control to ensure secure storage during the retention period.</p><br>

                    <h4>8. Consent and Lawful Processing</h4>
                    <p>By using OJTGo, you voluntarily consent to the collection, use, and processing of your data for the purposes stated. You may withdraw your consent at any time by changing your account settings or contacting us. If you use OJTGo from outside the Philippines, you agree to the cross-border transfer of your data to the Philippines for lawful processing.</p><br>

                    <h4>9. Your Rights Under the Law</h4>
                    <p>In accordance with RA 10173 (Data Privacy Act of 2012), you have the right to:</p>
                    <ul>
                        <li>Be informed about how your data is processed</li>
                        <li>Access your personal data</li>
                        <li>Correct inaccurate or outdated information</li>
                        <li>Request deletion or restrict processing</li>
                        <li>Object to unauthorized processing</li>
                        <li>Lodge a complaint with the National Privacy Commission (NPC)</li>
                    </ul><br>

                    <p>Learn more: <a href="https://privacy.gov.ph/data-subject-rights/" target="_blank" style="color: deepskyblue;">https://privacy.gov.ph/data-subject-rights/</a></p><br>

                    <h4>10. Updates to This Notice</h4>
                    <p>We may revise this Privacy Notice to reflect changes in law, technology, or our services. The latest version will always be available on OJTGo.com with an updated "Effective Date." Continued use of our platform constitutes acceptance of any updates.</p><br>

                    <h4>11. Contact Us</h4>
                    <p>For questions or concerns about your data privacy rights or to request data access or deletion, please contact our Data Protection Officer (DPO):</p>
                    <ul><br>
                        <li><strong>Email:</strong> <a href="mailto:ojt@ojtgo.com" style="color: deepskyblue;">ojt@ojtgo.com</a></li>
                    </ul>
                </div>
            </div>
        </section>


        <!-- Terms of Use Section -->
        <section id="terms" ng-show="activePage === 'terms'" class="bg-light py-5 bg-transparent">
            <div class="container">
                <h2 class="display-4 text-white fw-semibold fs-3 text-center p-3 rounded" style="background-color:rgb(0, 43, 86);">
                    Terms of Use
                </h2>

                <div style="background-color: rgba(0, 0, 0, 0.47); color: white; padding: 2rem; border-radius: 8px;">

                    <h4 class="mt-4"><strong>Employer</strong></h4>
                    <ol class="mt-3">
                        <li><strong>Account Creation and Registration</strong><br>
                            Employers must register for an account and provide accurate and up-to-date information to access and use the Website’s services. You are responsible for keeping your account credentials, including your username and password, confidential. Notify us immediately if you suspect unauthorized access or use of your account.
                        </li>
                        <li class="mt-3"><strong>Job Postings and Content</strong><br>
                            By posting job openings, you confirm that all submitted content is accurate, complete, and lawful. You are solely responsible for the content of your job postings and any resulting outcomes. Do not post illegal, defamatory, offensive, or inappropriate content. We reserve the right to remove or modify any content that violates these Terms or our content guidelines.
                        </li>
                        <li class="mt-3"><strong>Candidate Selection and Communication</strong><br>
                            You are solely responsible for selecting and hiring candidates. We do not guarantee any intern’s qualifications, suitability, or performance. All interactions, negotiations, and hiring decisions between you and the intern are entirely your responsibility. OJTGo has no role in employment arrangements.
                        </li>
                        <li class="mt-3"><strong>Intellectual Property</strong><br>
                            The Website and all its content—including text, graphics, logos, and software—are protected by intellectual property rights owned by us or our licensors. You may not reproduce, modify, distribute, or use any part of the Website without explicit permission.
                        </li>
                        <li class="mt-3"><strong>Limitation of Liability</strong><br>
                            You agree to use the Website at your own risk. We are not liable for any direct, indirect, incidental, consequential, or punitive damages resulting from your use of the Website or any errors in the content provided.
                        </li>
                        <li class="mt-3"><strong>Indemnification</strong><br>
                            You agree to indemnify and hold OJTGo harmless from any claims, losses, damages, or expenses arising from your use of the Website, violation of these Terms, or breach of any applicable laws.
                        </li>
                        <li class="mt-3"><strong>Modification of Terms</strong><br>
                            We reserve the right to update these Terms at any time without prior notice. Changes will take effect immediately upon being posted. Continued use of the Website indicates your acceptance of the updated Terms.
                        </li>
                        <li class="mt-3"><strong>Termination</strong><br>
                            If you violate these Terms or engage in fraudulent, abusive, or unlawful behavior, we may suspend or terminate your access to the Website.
                        </li>
                        <li class="mt-3"><strong>Severability</strong><br>
                            If any provision of these Terms is deemed invalid or unenforceable, the remaining provisions will remain in full force and effect.
                        </li>
                        <li class="mt-3"><strong>Entire Agreement</strong><br>
                            These Terms constitute the entire agreement between you and OJTGo regarding your use of the Website as an employer, superseding any prior agreements or understandings.
                        </li>
                    </ol>

                    <h4 class="mt-5"><strong>Intern</strong></h4>
                    <ol class="mt-3">
                        <li><strong>Account Creation and Registration</strong><br>
                            Interns must register for an account and provide accurate, complete, and current information. You are responsible for maintaining the confidentiality of your account credentials. Report any unauthorized use of your account immediately.
                        </li>
                        <li class="mt-3"><strong>Eligibility and Responsibilities</strong><br>
                            You confirm that you are a student or recent graduate eligible for OJT. You agree to conduct yourself professionally and honestly in all interactions with host companies and coordinators.
                        </li>
                        <li class="mt-3"><strong>Application and Internship Conduct</strong><br>
                            You affirm that all information in your application is truthful and complete. You are solely responsible for ensuring your internship complies with your academic requirements. Misrepresentation, misconduct, or unprofessional behavior may result in suspension or termination of your account.
                        </li>
                        <li class="mt-3"><strong>Matching and Placement</strong><br>
                            OJTGo facilitates connections but does not guarantee placement. Internship selection and approval are determined solely by host companies. We are not responsible for any outcomes, including mismatches or rejections.
                        </li>
                        <li class="mt-3"><strong>Data Use and Communication</strong><br>
                            You consent to the collection and use of your personal data for internship matching, communication with HTEs and coordinators, and academic monitoring. System notifications and optional promotional messages may be sent to you, which can be managed via your account settings.
                        </li>
                        <li class="mt-3"><strong>Intellectual Property</strong><br>
                            All materials you upload (e.g., resumes, cover letters) remain your intellectual property. By submitting them, you grant OJTGo a limited, non-exclusive license to use them solely for internship facilitation.
                        </li>
                        <li class="mt-3"><strong>Limitation of Liability</strong><br>
                            OJTGo is not liable for any direct, indirect, incidental, consequential, or punitive damages arising from your use of the Website or any interaction with employers or coordinators.
                        </li>
                        <li class="mt-3"><strong>Indemnification</strong><br>
                            You agree to indemnify and hold harmless OJTGo from any claims, damages, or expenses resulting from your use of the Website or any breach of these Terms.
                        </li>
                        <li class="mt-3"><strong>Modification of Terms</strong><br>
                            These Terms may be modified at any time without prior notice. Continued use of the Website after updates indicates your acceptance of the revised Terms.
                        </li>
                        <li class="mt-3"><strong>Termination</strong><br>
                            We reserve the right to suspend or terminate your account if you violate these Terms or engage in inappropriate conduct.
                        </li>
                        <li class="mt-3"><strong>Severability</strong><br>
                            If any term is deemed invalid or unenforceable, the remainder shall continue to apply in full effect.
                        </li>
                        <li class="mt-3"><strong>Entire Agreement</strong><br>
                            These Terms represent the entire agreement between you and OJTGo regarding your use of the Website as an intern.
                        </li>
                    </ol>

                    <h4 class="mt-5"><strong>Coordinator</strong></h4>
                    <ol class="mt-3">
                        <li><strong>Account Creation and Registration</strong><br>
                            Coordinators must create an account and provide accurate information to use the Website’s services. Keep your login credentials secure and notify us of any unauthorized access.
                        </li>
                        <li class="mt-3"><strong>Eligibility and Responsibilities</strong><br>
                            You confirm that you are authorized by your institution to manage OJT activities. You are responsible for the proper supervision of student interns and ensuring that institutional guidelines are met.
                        </li>
                        <li class="mt-3"><strong>Student Monitoring and Supervision</strong><br>
                            You are accountable for overseeing student progress and ensuring proper internship conduct. Maintain regular communication with both interns and host companies.
                        </li>
                        <li class="mt-3"><strong>Data Access and Use</strong><br>
                            You may access student data strictly for academic supervision and monitoring purposes. Any misuse of data may result in disciplinary actions.
                        </li>
                        <li class="mt-3"><strong>Communication and Professional Conduct</strong><br>
                            Maintain respectful, professional communication with all users. Misconduct may lead to suspension or termination of access.
                        </li>
                        <li class="mt-3"><strong>Intellectual Property</strong><br>
                            The Website’s content is protected by intellectual property laws. Do not reproduce or use content without permission.
                        </li>
                        <li class="mt-3"><strong>Limitation of Liability</strong><br>
                            OJTGo is not liable for any damages arising from the use of the Website or any decision made in connection with student management.
                        </li>
                        <li class="mt-3"><strong>Indemnification</strong><br>
                            You agree to indemnify and defend OJTGo from any claims or damages resulting from your use of the Website or breach of these Terms.
                        </li>
                        <li class="mt-3"><strong>Modification of Terms</strong><br>
                            These Terms may be updated at any time without prior notice. Your continued use of the Website signifies acceptance of any changes.
                        </li>
                        <li class="mt-3"><strong>Termination</strong><br>
                            Your access may be suspended or terminated if you violate these Terms or engage in misconduct.
                        </li>
                        <li class="mt-3"><strong>Severability</strong><br>
                            If any provision is found to be invalid, the rest of the Terms will remain in effect.
                        </li>
                        <li class="mt-3"><strong>Entire Agreement</strong><br>
                            These Terms represent the full agreement between you and OJTGo regarding your role as a coordinator on the Website.
                        </li>
                    </ol>
                </div>
        </section>


        <!-- Grouped decorative circles -->
        <div class="circle-decorations">
            <div class="blue-small-circle"></div>
            <div class="background-circle"></div>
        <!-- Hami 07/11: blue circle removed -->
        </div>

        <!-- about us Section -->
        <section id="about" ng-show="activePage === 'about'">
            <section class="bg-white text-center pt-5 pb-2">
                <div class="container">
                    <h1 class="display-4 text-white fw-semibold fs-3 text-center p-3 rounded" style="background-color:rgb(0, 43, 86);">
                        About Us
                    </h1>
                    <p class="mt-3" style="text-align: justify;">At <strong>OJTGo</strong>, we bridge the gap between education and industry, providing students with smooth or hassle-free access to valuable internship opportunities.
                        Our platform empowers students by connecting them with organizations that align with their academic backgrounds, career goals, and personal growth.
                        We believe internships are more than just academic requirements—they are stepping stones to meaningful careers.</p>
                </div>
            </section>

            <!-- Mission and Vision Section -->
            <section class="bg-white pt-2 pb-4">
                <div class="container text-left">
                    <div class="mb-5">
                        <h2 class="text-primary">Our Mission</h2>
                        <p class="mt-3" style="text-align: justify;">To empower students by providing them with seamless access to valuable internship opportunities,
                            equipping them with the skills and experience needed to succeed in the professional world. We aim to connect
                            educational institutions, students, and employers in a collaborative environment that fosters growth, learning, and career readiness.
                        </p>
                    </div>
                    <div>
                        <h2 class=" text-primary">Our Vision</h2>
                        <p class="mt-3" style="text-align: justify;">To be the ultimate one-stop solution for all OJT needs, ensuring that every student gains practical experience to enhance
                            their future career prospects. We strive to create a workforce-ready generation by bridging academia and industry through innovative and inclusive
                            job-matching technology.
                        </p>
                    </div>
                </div>
            </section>


            <div class="bg-white">
                <!-- Section 1: Image Left, Text Right -->
                <section class="py-5">
                    <div class="container">
                        <div class="row align-items-center">
                            <!-- Image -->
                            <div class="col-md-6 order-1 order-md-1 d-flex justify-content-center justify-content-md-start mb-4 mb-md-0">
                                <img
                                    src="<?php echo home_url('/wp-content/uploads/icons/home/indtroduce.png') ?>"
                                    alt="introduce"
                                    class="img-fluid rounded shadow-lg"
                                    style="max-width: 90%; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);">
                            </div>

                            <!-- Text -->
                            <div class="col-md-6 order-2 order-md-2">
                                <h2 class="text-primary">Introducing OJTGo</h2>
                                <p style="text-align: justify;">A platform built by students, for students. OJTGo aims to simplify the internship journey by connecting students, OJT coordinators, and host companies (HTEs) in one convenient, organized space. We designed it to reduce unnecessary costs, streamline the application process, and minimize mismatches between students and companies. With OJTGo, students can find internships that suit their course and location, while coordinators and companies can manage applications and assignments more efficiently. It is not just a platform. It is our way of solving a problem we experienced ourselves, and making things better for the future interns.</p>
                            </div>
                        </div>
                    </div>
                </section>


                <!-- Section 2: Image Right, Text Left -->
                <section class="py-5">
                    <div class="container">
                        <div class="row align-items-center">
                            <!-- Text -->
                            <div class="col-md-6 order-2 order-md-1">
                                <h2 class="text-primary">How it started?</h2>
                                <p style="text-align: justify;">We saw it firsthand. We were once interns ourselves, and we noticed a problem that has been around for generations. Every year, thousands of students search for internships, creating a high demand with limited quality opportunities. The competition is tough, and the process is expensive. If you were unlucky, you would end up mismatched with a company that does not help you grow.</p>
                                <p style="text-align: justify;">As graduating students, we had to juggle thesis deadlines, clearance fees, and the pressure of securing an internship—all while spending on transportation, meals, and application requirements. Most internships do not even offer basic allowances. This is the sad reality for many students, year after year.</p>
                            </div>
                            <!-- Image -->
                            <div class="col-md-6 order-1 order-md-2">
                                <img src="<?php echo home_url('/wp-content/uploads/icons/home/howwestarted.jpg') ?>"
                                    alt="Our Story" class="img-fluid rounded shadow">
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section 3: Image Left, Text Right -->
                <section class="py-5">
                    <div class="container">
                        <div class="row align-items-center">
                            <!-- Image -->
                            <div class="col-md-6 order-1 order-md-1">
                                <img src="<?php echo home_url('/wp-content/uploads/icons/home/whatwecreated.jpg') ?>"
                                    alt="Our Story" class="img-fluid rounded shadow">
                            </div>
                            <!-- Text -->
                            <div class="col-md-6 order-2 order-md-2">
                                <h2 class="text-primary">What we created?</h2>
                                <p style="text-align: justify;">We created a platform designed to reduce the cost and hassle of finding an internship. It connects students, OJT Coordinators, and host companies in one convenient space. The goal is to make internships more accessible and organized—for everyone involved.</p>
                                <p style="text-align: justify;">As graduating students, we had to juggle thesis deadlines, clearance fees, and the pressure of securing an internship—all while spending on transportation, meals, and application requirements. Most internships do not even offer basic allowances. This is the sad reality for many students, year after year.</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- OJTGo Team -->
            <section class="py-5" style="color: rgb(0, 43, 86);" ng-init="showAllTeam = false">
                <div class="container">
                    <h1 class="display-4 text-white fw-semibold fs-3 text-center p-3 rounded" style="background-color:rgb(0, 43, 86);">
                        Meet the OJTGo Team
                    </h1>

                    <h1 class="display-4 fw-bold fs-3 text-center m-5" style="color:rgb(0, 43, 86);">
                        Management Team
                    </h1>

                    <!-- showed team -->
                    <div class="row justify-content-center fw-bold fs-5 mt-4">
                        <!-- Team Member 1 -->
                        <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                            <div class="team-img-container mb-2">
                                <img src="<?php echo home_url('/wp-content/uploads/icons/home/sirval.png') ?>" alt="sir Val">
                            </div>
                            <p class="text-center m-0">Valery Minello</p>
                            <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Chief Executive Officer</p>
                        </div>

                        <!-- Team Member 2 -->
                        <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                            <div class="team-img-container mb-2">
                                <img src="<?php echo home_url('/wp-content/uploads/icons/home/leo2.jpg') ?>" alt="sir Leo">
                            </div>
                            <p class="text-center m-0">Leo Herrera</p>
                            <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Chief Operating Officer</p>
                        </div>

                        <!-- Team Member 3 -->
                        <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                            <div class="team-img-container mb-2">
                                <img src="<?php echo home_url('/wp-content/uploads/icons/home/sirjeal.jpg') ?>" alt="sir Jeal">
                            </div>
                            <p class="text-center m-0">Jeal Pascua</p>
                            <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Chief Technology Officer</p>
                        </div>

                        <!-- Team Member 4 -->
                        <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                            <div class="team-img-container mb-2">
                                <img src="<?php echo home_url('/wp-content/uploads/icons/home/john.jpg') ?>" alt="ma'am John">
                            </div>
                            <p class="text-center m-0">John Ronald Robillos</p>
                            <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Sales Lead</p>
                        </div>

                        <!-- Team Member 5 -->
                        <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                            <div class="team-img-container mb-2">
                                <img src="<?php echo home_url('/wp-content/uploads/icons/home/jess.jpg') ?>" alt="sir Jess">
                            </div>
                            <p class="text-center m-0">Jess Baggao</p>
                            <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Chief Security Officer</p>
                        </div>

                        <!-- Team Member 6 -->
                        <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                            <div class="team-img-container mb-2">
                                <img src="<?php echo home_url('/wp-content/uploads/icons/home/jinah-1.jpg') ?>" alt="ma'am Jinah">
                            </div>
                            <p class="text-center m-0">Jinalyn Diamos</p>
                            <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">HR Manager</p>
                        </div>

                        <!-- Team Member 7 -->
                        <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                            <div class="team-img-container mb-2">
                                <img src="<?php echo home_url('/wp-content/uploads/icons/home/nicolee-2.jpg') ?>" alt="ma'am Nicole">
                            </div>
                            <p class="text-center m-0">Roan Nicole Marcellana</p>
                            <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Marketing Manager</p>
                        </div>

                        <!-- Team Member 8 -->
                        <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                            <div class="team-img-container mb-2">
                                <img src="<?php echo home_url('/wp-content/uploads/icons/home/steph.jpg') ?>" alt="ma'am Steph">
                            </div>
                            <p class="text-center m-0">Stephanie Cuenca</p>
                            <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Communications Manager</p>
                        </div>



                        <!-- Hidden team -->
                        <section ng-if="currentPage === 'rest' || true"> <!-- Set true for universal visibility -->
                            <div class="row justify-content-center mt-4 fw-bold fs-5" ng-show="showAllTeam">

                                <h1 class="display-4 fw-bold fs-3 text-center m-5" style="color:rgb(0, 43, 86);">
                                    Our OJT
                                </h1>

                                <!-- Team Member 9 -->
                                <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                                    <div class="team-img-container mb-2">
                                        <img src="<?php echo home_url('/wp-content/uploads/icons/home/lorenzo-scaled.jpg') ?>" alt="Lorenzo">
                                    </div>
                                    <p class="text-center m-0">Lorenzo Daniel Jarata</p>
                                    <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Web Developer</p>
                                </div>

                                <!-- Team Member 10 -->
                                <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                                    <div class="team-img-container mb-2">
                                        <img src="<?php echo home_url('/wp-content/uploads/icons/home/millard-scaled.jpg') ?>" alt="Millard">
                                    </div>
                                    <p class="text-center m-0">Millard John Ortillano</p>
                                    <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Web Developer</p>
                                </div>

                                <!-- Team Member 7 -->
                                <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                                    <div class="team-img-container mb-2">
                                        <img src="<?php echo home_url('/wp-content/uploads/icons/home/khianah.jpg') ?>" alt="Khianah">
                                    </div>
                                    <p class="text-center m-0">Khianah Marie Gadacho</p>
                                    <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">UI/UX Designer</p>
                                </div>

                                <!-- Team Member 8 -->
                                <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                                    <div class="team-img-container mb-2">
                                        <img src="<?php echo home_url('/wp-content/uploads/icons/home/jazmine.jpg') ?>" alt="Jazmine">
                                    </div>
                                    <p class="text-center m-0">Jazmine Danielle Gundran</p>
                                    <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Marketing</p>
                                </div>

                                <!-- Team Member 9 -->
                                <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                                    <div class="team-img-container mb-2">
                                        <img src="<?php echo home_url('/wp-content/uploads/icons/home/aivie.jpg') ?>" alt="Aivie">
                                    </div>
                                    <p class="text-center m-0">Aivie Concepcion</p>
                                    <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Marketing</p>
                                </div>

                                <!-- Team Member 10 -->
                                <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                                    <div class="team-img-container mb-2">
                                        <img src="<?php echo home_url('/wp-content/uploads/icons/home/katrishna.jpg') ?>" alt="Katrishna">
                                    </div>
                                    <p class="text-center m-0">Kathrisha Sapon</p>
                                    <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Quality Assurance
                                    </p>
                                </div>

                                <!-- Team Member 11 -->
                                <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                                    <div class="team-img-container mb-2">
                                        <img src="<?php echo home_url('/wp-content/uploads/icons/home/charlss.jpg') ?>" alt="Charls">
                                    </div>
                                    <p class="text-center m-0">Arvin Charls Basco</p>
                                    <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Web Developer
                                    </p>
                                </div>

                                <!-- Team Member 12 -->
                                <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                                    <div class="team-img-container mb-2">
                                        <img src="<?php echo home_url('/wp-content/uploads/icons/home/arandelle.jpg') ?>"
                                            alt="Arandelle">
                                    </div>
                                    <p class="text-center m-0">Arandelle Paguinto</p>
                                    <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Web Developer
                                    </p>
                                </div>

                                <!-- Team Member 13 -->
                                <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                                    <div class="team-img-container mb-2">
                                        <img src="<?php echo home_url('/wp-content/uploads/icons/home/jc.jpg') ?>"
                                            alt="Arandelle">
                                    </div>
                                    <p class="text-center m-0">JC Despabiladeras</p>
                                    <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Web Developer
                                    </p>
                                </div>

                                <!-- Team Member 14 -->
                                <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                                    <div class="team-img-container mb-2">
                                        <img src="<?php echo home_url('/wp-content/uploads/icons/home/mads.jpg') ?>"
                                            alt="Arandelle">
                                    </div>
                                    <p class="text-center m-0">Madeleine Gonzales</p>
                                    <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Communications
                                    </p>
                                </div>

                                <!-- Team Member 15 -->
                                <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                                    <div class="team-img-container mb-2">
                                        <img src="<?php echo home_url('/wp-content/uploads/icons/home/hami.jpg') ?>"
                                            alt="Arandelle">
                                    </div>
                                    <p class="text-center m-0">Hamidah Abdulqader Awad Salem</p>
                                    <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Web Developer
                                    </p>
                                </div>

                            </div>
                        </section>

                        <!-- Toggle Button -->
                        <div class="text-end mt-4">
                            <button
                                class="fw-semibold text-primary"
                                style="border: none; background: none; padding: 0;"
                                ng-click="toggleTeamVisibility()">
                                {{ showAllTeam ? 'Hide All' : 'View All' }}
                            </button>
                        </div>

                    </div>
            </section>

        </section>

        <!-- contact us Section -->
        <div id="contact" class="d-flex flex-column h-100" style="margin-top: 0; padding: 60px 0; background: linear-gradient(to bottom, rgba(207, 220, 255, 1), rgba(255, 255, 255, 1), rgba(207, 220, 255, 1));">

            <div class="container mt-auto">
                <div class="row justify-content-center align-items-center flex-wrap">

                    <h3 class="fw-bold mt-3 fs-2 text-center" style="color: rgb(0, 50, 101);">
                        Bridging Students to Success—<br>OJTGo Connects Them with the Right Opportunities
                    </h3>

                    <!-- Contact Message Box -->
                    <div class="col-md-6 mt-5">
                        <div class="rounded-3 p-4 shadow-lg position-relative overflow-hidden d-flex flex-column justify-content-between h-100"
                            style="background: linear-gradient(rgb(255, 255, 255)); color: rgb(0, 50, 101);">
                            <div style="z-index: 1; position: relative;">
                                <h3 class="fw-bold mb-4" style="color: rgb(0, 50, 101);">
                                    <i class="bi bi-chat-square-dots-fill"></i> Get in Touch
                                </h3>
                                <p class="mb-3" style="font-size: 1rem;">
                                    Have questions, feedback, or need support? We're here to help! Reach out to the OJTGo team and we'll get back to you as soon as possible. Whether you're an intern or an employer, your internship journey is our priority.
                                </p>
                            </div>

                            <button class="btn text-white fw-bold py-1 mt-4"
                                ng-click="showContactForm = !showContactForm"
                                style="background-color: rgb(0, 50, 101); border: 1px solid #0161aa; font-size: 1.1rem;">
                                <span ng-hide="showContactForm">
                                    Send us a message!
                                </span>
                                <span ng-show="showContactForm">
                                    Go Back
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="col-md-6 mt-3" ng-show="showContactForm">
                        <div class="rounded-3 p-4 shadow-lg bg-white position-relative h-100">
                            <div class="position-absolute top-0 start-0 w-100 h-100"
                                style="background: linear-gradient(135deg, rgba(255, 255, 255, 1)); z-index: 0;"></div>
                            <div style="z-index: 1; position: relative;">
                                <h3 class="fw-bold mb-4" style="color: rgb(0, 50, 101);">Send Us a Message</h3>
                                <form name="contactForm" ng-submit="submitContactForm()" novalidate>
                                    <div class="mb-2">
                                        <label class="form-label fw-semibold">Name</label>
                                        <input type="text" class="form-control custom-fields" style="border: 1px solid #0063b1;"
                                            ng-model="contactFormData.name" placeholder="e.g. John Doe" required>
                                    </div>

                                    <div class="mb-2 row">
                                        <div class="col">
                                            <label class="form-label fw-semibold">Email</label>
                                            <input type="email" class="form-control custom-fields" style="border: 1px solid #0063b1;"
                                                ng-model="contactFormData.email" placeholder="e.g. johndoe@example.com" required>
                                        </div>
                                        <div class="col">
                                            <label class="form-label fw-semibold">Mobile Number</label>
                                            <input type="text" class="form-control custom-fields" style="border: 1px solid #0063b1;"
                                                ng-model="contactFormData.mobile" placeholder="e.g. +639xxxxxxxxx" required>
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label fw-semibold">Comment or Message</label>
                                        <textarea class="form-control custom-fields" style="border: 1px solid #0063b1; height: 80px;"
                                            ng-model="contactFormData.message" rows="4" placeholder="Start typing..." required></textarea>
                                    </div>

                                    <div class="d-grid mt-4">
                                        <button type="submit"
                                            ng-class="{'disabled': onsubmit}"
                                            class="btn text-white fw-bold py-1"
                                            style="background-color: rgb(0, 50, 101); border: 1px solid #0161aa; font-size: 1.1rem;">
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer-container" style="background-color: #1565c0; color: white; padding: 20px 10px; margin-top: 0;">
        <div class="container-fluid px-2 px-md-2 px-lg-5">
            <div class="row align-items-start align-items-lg-center d-lg-flex justify-content-lg-between">

            <!-- Logo and Social Icons -->
            <div class="col-12 col-lg-auto text-start mt-4 mb-lg-0">
                <img style="height: 80px;"
                    src="<?php echo home_url('/wp-content/uploads/icons/OJTGO-630X310-white.png') ?>"
                    alt="ojtgo-logo"
                    class="footer-logo mb-3">

                <div class="social-icons d-flex justify-content-start gap-2 mb-4">
                <a href="https://www.facebook.com/ojtgo.pces/" target="_blank">
                    <div class="social-circle bg-light rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 35px; height: 35px;">
                    <i class="fab fa-facebook-f text-dark"></i>
                    </div>
                </a>
                <a href="https://www.instagram.com/ojtgo_pces/" target="_blank">
                    <div class="social-circle bg-light rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 35px; height: 35px;">
                    <i class="fab fa-instagram text-dark"></i>
                    </div>
                </a>
                <a href="https://www.tiktok.com/@ojtgo_pces" target="_blank">
                    <div class="social-circle bg-light rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 35px; height: 35px;">
                    <i class="fab fa-tiktok text-dark"></i>
                    </div>
                </a>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="col-12 col-lg-auto pe-5 mt-3 mt-lg-0">
                <nav class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center text-start text-lg-start gap-2 gap-lg-3">
                <a class="text-white text-decoration-none py-1 px-2" style="font-size: 1.1rem;" href="#home" ng-click="setActivePage('home')">Home</a>
                <a class="text-white text-decoration-none py-1 px-2" style="font-size: 1.1rem;" href="#about" ng-click="setActivePage('about', $event)">About Us</a>
                <a class="text-white text-decoration-none py-1 px-2" style="font-size: 1.1rem;" href="#highlights" ng-click="setActivePage('highlights'); scrollToSection('highlights', $event)">Highlights</a>
                <a class="text-white text-decoration-none py-1 px-2" style="font-size: 1.1rem;" href="#contact" ng-click="scrollToSection('contact', $event)">Contact Us</a>
                <a class="text-white text-decoration-none py-1 px-2" style="font-size: 1.1rem;" href="#whyojtgo" ng-click="setActivePage('whyojtgo'); scrollToSection('whyojtgo', $event)">Why OJTGo?</a>
                <a class="text-white text-decoration-none py-1 px-2" style="font-size: 1.1rem;" href="#privacy" ng-click="setActivePage('privacy')">Privacy Policy</a>
                <a class="text-white text-decoration-none py-1 px-2" style="font-size: 1.1rem;" href="#terms" ng-click="setActivePage('terms')">Terms of Use</a>
                </nav>
            </div>

            </div>
        </div>
        </div>


        <div
            id="modal-overlay"
            class="modal-overlay container-fluid"
            ng-class="{ 'active': isModalActive, 'active-unmount': !isModalActive }">


            <!-- Main Container -->
            <div
                id="information-entry-modal"
                class="d-flex justify-content-center align-items-center information-entry-modal"
                ng-class="{ 'active': isModalActive }">

                <!-- Close button -->
                <span class="close-btn me-3 mt-1 trigger-entry-modal" ng-click="toggleModal()">x</span>

                <!-- 
                
                    Login content is initially active
                    All other contents are in d-none state
                
                -->
                <!-- Login Content -->
                <div
                    id="login-content"
                    control-tab="login"
                    class="d-flex flex-column justify-content-center align-items-center text-center w-100 login-content"
                    ng-class="{
                        'active-slide-in': currentModalContent === 'login',
                        'active-slide-out': currentModalContent !== 'login'
                    }"
                    ng-attr-inert="{{ currentModalContent !== 'login' ? true : undefined }}"
                    ng-cloak>


                    <!-- Empty for now -->
                    <div class="d-flex flex-column align-items-center justify-content-center animation-container">

                        <!-- <div class="d-flex flex-column align-items-center justify-content-center mb-3 some-animation">
                            Hello
                        </div> -->

                        <img class="d-block mx-auto" style="height: 70px;" src="<?php echo home_url('/wp-content/uploads/icons/OJTGO-630X310.png') ?>">

                    </div>

                    <!-- Header and Sub Title -->
                    <div class="row flex-column align-items-center justify-content-center mb-3 header">
                        <p class="col-auto fs-1 fw-bold text-center mb-0">Welcome Back!</p>
                        <p class="col-auto text-secondary text-center mb-0 w-75" style="font-size: 1rem;">Intern or Employer!</p>
                    </div>


                    <!-- Input Fields -->
                    <div class="d-flex gap-0 gap-md-3 flex-column justify-content-between">

                        <div class="row g-3 align-items-center justify-content-center">
                            <div class="col-12 col-md-5">
                                <label class="form-label mb-0">Username or Email:</label>
                            </div>
                            <div class="col-12 col-md-7">
                                <input type="text" class="form-control" ng-model="credentials.username">
                            </div>
                        </div>

                        <div class="row g-3 align-items-center justify-content-center">
                            <div class="col-12 col-md-5">
                                <label class="form-label mb-0">Password:</label>
                            </div>
                            <div class="col-12 col-md-7">
                                <div class="input-group custom-width">
                                    <input
                                        type="{{ isLogPasswordVisible ? 'text' : 'password' }}"
                                        class="form-control password"
                                        ng-model="credentials.password">
                                    <!-- Conditional Use of Icon depends on the current state of the password -->
                                    <span
                                        id="toggle-pass-visibility"
                                        class="input-group-text toggle-visibility"
                                        ng-click="togglePasswordVisibility('isLogPasswordVisible')">
                                        <i ng-class="{'bi-eye': isLogPasswordVisible, 'bi-eye-slash': !isLogPasswordVisible}"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Forgot Password Link -->
                    <a
                        id="forgot-passowrd"
                        href="javascript:void(0)"
                        class="col text-center link-text mt-2"
                        style="font-size: 0.875rem;"
                        ng-click="switchModalContent('forgot-pass');">
                        Forgot Your Password?
                    </a>



                    <!-- Login Button -->
                    <a
                        id="login"
                        href="javascript:void(0)"
                        class="col text-center my-5 px-5 py-2 modal-btn login-btn"
                        ng-click="loginUser()">
                        Login
                    </a>



                    <!-- Direct to Register -->

                    <span class="col-12 text-center" style="font-size: 0.875rem;">Don't have an account?</span>
                    <p class="col-12 mb-0 text-center" style="font-size: 0.875rem;">
                        Why not
                        <a
                            href="javascript:void(0)"
                            class="link-text"
                            style="font-size: 0.875rem;"
                            ng-click="switchModalContent('user-type');">
                            Register Here?
                        </a>
                    </p>


                </div>


                <!-- Which Type of User -->
                <div
                    id="confirm-user-type"
                    class="d-flex flex-column justify-content-center align-items-center text-center confirm-user-type"
                    control-tab="user-type"
                    ng-class="{
                        'active-slide-in': currentModalContent === 'user-type',
                        'active-slide-out': currentModalContent !== 'user-type'
                    }"
                    ng-attr-inert="{{ currentModalContent !== 'user-type' ? true : undefined }}"
                    ng-cloak>


                    <div class="d-flex flex-column align-items-center justify-content-center animation-container">

                        <img class="d-block mx-auto" style="height: 70px;" src="<?php echo home_url('/wp-content/uploads/icons/OJTGO-630X310.png') ?>">

                    </div>

                    <!-- Header and Sub Title -->
                    <div class="row flex-column align-items-center justify-content-center mb-3 header">
                        <p class="col-auto fs-1 fw-bold text-center mb-0">Welcome!</p>
                        <p class="col-auto text-secondary text-center mb-0 w-90" style="font-size: 1rem;">We are glad to have you!</p>
                    </div>

                    <p class="text-center">Which type of user are you?</p>

                    <!-- Login Button -->
                    <a
                        ng-click="setUserType('employer');"
                        href="javascript:void(0);"
                        class="text-center my-2 px-5 py-2 modal-btn employer-btn">
                        Employer
                    </a>

                    <span class="text-center">or</span>

                    <a
                        ng-click="setUserType('intern');"
                        href="javascript:void(0);"
                        class="text-center my-2 px-5 py-2 modal-btn intern-btn">
                        Intern
                    </a>

                </div>


                <!-- Register Content -->
                <div
                    id="register-content"
                    control-tab="register"
                    class="d-flex flex-column justify-content-center align-items-center text-center register-content"
                    ng-class="{
                        'active-slide-in': currentModalContent === 'register',
                        'active-slide-out': currentModalContent !== 'register'
                    }"
                    ng-attr-inert="{{ currentModalContent !== 'register' ? true : undefined }}"
                    ng-cloak>

                    <div class="d-flex flex-column align-items-center justify-content-center animation-container">

                        <img class="d-block mx-auto" style="height: 70px;" src="<?php echo home_url('/wp-content/uploads/icons/OJTGO-630X310.png') ?>">

                    </div>

                    <!-- Header and Sub Title -->
                    <div class="row flex-column align-items-center justify-content-center mb-3 header">
                        <p class="col-auto fs-1 fw-bold text-center mb-0">Welcome!</p>
                        <p class="col-auto text-secondary text-center mb-0 w-100" style="font-size: 1rem;">We are glad to have you!</p>
                    </div>


                    <!-- Input Fields w/o password-->
                    <div class="d-flex gap-0 gap-md-3 flex-column justify-content-between">

                        <!-- Username -->
                        <div class="">
                            <div class="row g-3 align-items-center justify-content-center justify-content-md-center">
                                <div class="col-12 col-md-5">
                                    <label class="form-label mb-0 mb-md-2">Username: </label>
                                </div>
                                <div class="col-12 col-md-7 mt-1 align-self-start custom-width">
                                    <input
                                        type="text"
                                        class="form-control reg-field"
                                        ng-class="{'highlight is-invalid': !usernameValid}"
                                        placeholder="John Doe"
                                        ng-model="credentials.username"
                                        ng-keydown="logTyping('text', credentials.username)"
                                        ng-blur="logFinalValue('text', credentials.username); validateUsername()"
                                        ng-change="validateUsername()"
                                        required>
                                </div>
                            </div>
                            <small class="text-danger text-wrap" ng-show="usernameError">{{ usernameError }}</small>
                        </div>

                        <!-- Email -->
                        <div class="">
                            <div class="row g-3 align-items-center justify-content-center justify-content-md-center">
                                <div class="col-12 col-md-5">
                                    <label class="form-label mb-0 mb-md-2">Email: </label>
                                </div>
                                <div class="col-12 col-md-7 mt-1 align-self-start custom-width">
                                    <input
                                        type="email"
                                        class="form-control reg-field"
                                        ng-class="{'highlight is-invalid': !emailValid}"
                                        placeholder="name@example.com"
                                        ng-model="credentials.email"
                                        ng-keydown="logTyping('email', credentials.email)"
                                        ng-blur="logFinalValue('email', credentials.email); validateEmail()"
                                        ng-change="validateEmail()">
                                </div>
                            </div>
                            <small class="text-danger text-wrap" ng-show="emailError">{{ emailError }}</small>
                        </div>

                        <!-- <small class="m-0" style="font-size: 13px;">
                            An OTP verification code will be sent to your email.
                        </small> -->

                    </div>


                    <!-- Password Input field -->
                    <div class="mt-0 mt-md-2 d-flex flex-column justify-content-between align-items-center container-fluid">

                        <!-- Password -->
                        <div class="row g-3 align-items-center justify-content-between">
                            <div class="col-12 col-md-5">
                                <label class="col-form-label mb-0 mb-md-2">Password: </label>
                            </div>
                            <div class="col-12 col-md-7 mt-0">
                                <div class="mt-1 align-self-start input-group custom-width">
                                    <input
                                        type="{{ isRegPasswordVisible ? 'text' : 'password' }}"
                                        class="form-control password reg-field"
                                        ng-class="{'highlight is-invalid': credentials.password.length > 0 && !passwordValid}"
                                        ng-model="credentials.password"
                                        ng-change="validatePassword('credentials')">
                                    <!-- Conditional Use of Icon depends on the current state of the password -->
                                    <span
                                        id="toggle-pass-visibility"
                                        class="input-group-text toggle-visibility"
                                        ng-click="togglePasswordVisibility('isRegPasswordVisible')">
                                        <i class="bi" ng-class="{'bi-eye': isRegPasswordVisible, 'bi-eye-slash': !isRegPasswordVisible}"></i>
                                    </span><br />
                                </div>
                            </div>
                        </div>
                        <!-- Added code by Lorenzo @ 04/11/2025 -->
                        <div class="rounded text-start mt-2 p-2 guidelines">
                            <small
                                ng-class="{'text-success': passChecks.length && credentials.password, 'text-danger': credentials.password.length > 0 && !passChecks.length}">
                                ✔ At least 8 characters</small><br />
                            <small
                                ng-class="{'text-success': passChecks.lower && credentials.password, 'text-danger': credentials.password.length > 0 && !passChecks.lower}">
                                ✔ 1 lowercase & </small>
                            <small
                                ng-class="{'text-success': passChecks.upper && credentials.password, 'text-danger': credentials.password.length > 0 && !passChecks.upper}">
                                1 uppercase</small><br />
                            <small
                                ng-class="{'text-success': passChecks.number && credentials.password, 'text-danger': credentials.password.length > 0 && !passChecks.number}">
                                ✔ At least 1 number</small> <br />
                            <small
                                ng-class="{'text-success': passChecks.special && credentials.password, 'text-danger': credentials.password.length > 0 && !passChecks.special}">
                                ✔ At least 1 special character</small> <br />
                        </div>

                        <div class="rounded text-start mt-2 p-2 condition">
                            <p class="col-auto text-secondary text-center mb-0 w-100" style="font-size: 0.7rem;">
                                By clicking Create Account, you agree to our
                                <a href="/home/#terms" target="_blank" rel="nofollow">Terms of Use</a> and
                                <a href="/home/#privacy" target="_blank" rel="nofollow">Privacy Notice</a>.
                                You may receive email notifications from us, and you can opt out at any time.
                            </p>
                        </div>

                        <!-- register Button -->
                        <a
                            id="create-acc-btn"
                            href="javascript:void(0)"
                            class="col text-center my-5 px-5 py-2 modal-btn register-btn"
                            ng-click="storeCredentials();"
                            ng-class="{'disabled': isFormInvalid() && !passwordValid && !usernameValid}">
                            Create Account
                        </a>



                        <!-- Direct to Login -->
                        <span class="col-12 text-center" style="font-size: 0.875rem;">Already have an account?</span>
                        <p class="col-12 mb-0 text-center" style="font-size: 0.875rem;">
                            <a
                                href="javascript:void(0)"
                                class="link-text login-account"
                                style="font-size: 0.875rem;"
                                ng-click="switchModalContent('login')">
                                Log in
                            </a>
                            instead.
                        </p>
                    </div>



                </div>


                <!-- Verify Email Content -->
                <div
                    id="verify-content"
                    class="d-flex flex-column justify-content-center align-items-center text-center verify-content"
                    control-tab="verify"
                    ng-class="{
                        'active-slide-in': currentModalContent === 'verify',
                        'active-slide-out': currentModalContent !== 'verify'
                    }"
                    ng-attr-inert="{{ currentModalContent !== 'verify' ? true : undefined }}"
                    ng-cloak>


                    <!-- Empty for now -->
                    <div class="d-flex flex-column align-items-center justify-content-center animation-container">

                        <!-- <div class="d-flex flex-column align-items-center justify-content-center mb-3 some-animation">
                            Hello
                        </div> -->

                        <img class="d-block mx-auto" style="height: 70px;" src="<?php echo home_url('/wp-content/uploads/icons/OJTGO-630X310.png') ?>">

                    </div>

                    <!-- Header and Sub Title -->
                    <div class="row flex-column align-items-center justify-content-center mb-3 header">
                        <p class="col-auto fs-1 fw-bold text-center mb-0">Verify Your Email</p>
                        <p class="col-auto text-secondary text-center mb-0 w-75" style="font-size: 1rem;">We sent you a code through email. Enter it down below.</p>
                    </div>


                    <!-- Input Fields -->
                    <div class="row g-3 align-items-center mb-3">
                        <div class="col-auto">
                            <label class="form-label">Code: </label>
                        </div>
                        <div class="col-auto">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="09XXX"
                                ng-model="otpCode"
                                ng-change="validateOtp('otpCode')">
                        </div>
                    </div>


                    <!-- Resend code Registration -->
                    <span class="col-12 text-center" style="font-size: 0.875rem;">Didn't get a code?</span>

                    <a
                        id="resend-code"
                        href="javascript:void(0)"
                        class="col-12 mb-0 text-center link-text"
                        style="font-size: 0.875rem;"
                        ng-click="resendRegistrationOtp()"
                        ng-class="{ 'text-muted': otpCooldown, 'disabled': otpCooldown }"
                        ng-if="!otpCooldown">
                        Resend the code.
                    </a>

                    <span
                        class="col-12 mb-0 text-center text-muted"
                        style="font-size: 0.875rem;"
                        ng-if="otpCooldown">
                        Resend available in {{ otpCooldownSeconds }}s
                    </span>


                    <!-- Login Button -->
                    <a
                        id="verify-email"
                        href="javascript:void(0)"
                        class="col text-center my-5 px-5 py-2 modal-btn verify-btn d-flex justify-content-center align-items-center gap-2"
                        ng-click="verifyAndProceed('register')"
                        ng-class="{ 'disabled': isCreating }">
                        <span ng-if="!isCreating">Verify</span>
                        <span ng-if="isCreating">
                            <i class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></i>
                            Verifying...
                        </span>
                    </a>




                    <!-- Direct to Login -->
                    <span class="col-12 text-center" style="font-size: 0.875rem;">Already have an account?</span>
                    <p class="col-12 mb-0 text-center" style="font-size: 0.875rem;">
                        <a
                            href="javascript:void(0)"
                            class="link-text login-account"
                            style="font-size: 0.875rem;"
                            ng-click="switchModalContent('login')">
                            Log in
                        </a>
                        instead.
                    </p>



                </div>



                <!-- Forgot Password Content -->
                <div
                    id="forgot-pass"
                    class="d-flex flex-column justify-content-center align-items-center text-center w-100 forgot-pass"
                    control-tab="forgot-pass"
                    ng-class="{
                        'active-slide-in': currentModalContent === 'forgot-pass',
                        'active-slide-out': currentModalContent !== 'forgot-pass'
                    }"
                    ng-attr-inert="{{ currentModalContent !== 'forgot-pass' ? true : undefined }}"
                    ng-cloak>

                    <!-- OJT go logo -->
                    <div class="d-flex flex-column align-items-center justify-content-center animation-container">

                        <img class="d-block mx-auto" style="height: 70px;" src="<?php echo home_url('/wp-content/uploads/icons/OJTGO-630X310.png') ?>">

                    </div>

                    <!-- Header and Sub Title -->
                    <div class="row flex-column align-items-center justify-content-center mb-3 header">
                        <p class="col-auto fs-1 fw-bold text-center mb-0">Forgot Password?</p>
                        <p class="col-auto text-secondary text-center mb-5 w-75" style="font-size: 1rem;">No worries! Just enter your email address and we'll send you a link to reset your password.</p>
                    </div>


                    <!-- Input Fields -->
                    <!-- 
                        Standby: 
                        ng-change="validateEmail();"
                        ng-class="{'highlight': !emailValid}"
                    -->

                    <div class="row g-3 align-items-center justify-content-between mb-3">
                        <div class="col-auto" style="margin-right: 30px">
                            <label class="form-label">Email: </label>
                        </div>
                        <div class="col-auto">
                            <input
                                type="text"
                                class="form-control"
                                ng-model="accountEmail">
                        </div>
                        <!-- <small class="text-danger text-wrap" ng-show="emailError">{{ emailError }}</small> -->
                    </div>


                    <!-- Send Instruction Button -->
                    <a
                        id="login"
                        href="javascript:void(0)"
                        class="col text-center my-5 px-5 py-2 modal-btn instructions-btn"
                        ng-click="sendForgotPassword()">
                        Recover Password
                    </a>


                    <!-- Direct to Login -->
                    <span class="col-12 text-center" style="font-size: 0.875rem;">Remembered your password?</span>
                    <p class="col-12 mb-0 text-center" style="font-size: 0.875rem;">
                        Go ahead and
                        <a
                            href="javascript:void(0)"
                            class="link-text login-account"
                            style="font-size: 0.875rem;"
                            ng-click="switchModalContent('login')">
                            Log in
                        </a>
                        here.
                    </p>


                </div>


                <!-- Added by Lorenzo @ 04/22/2025 - migrated @ 04/23/2025 -->
                <!-- Verify Email - Forgot Password Content -->
                <div
                    id="verify-forgot-pass-content"
                    class="d-flex flex-column justify-content-center align-items-center text-center verify-forgot-pass-content"
                    control-tab="verify-forgot-pass"
                    ng-class="{
                        'active-slide-in': currentModalContent === 'verify-forgot-pass',
                        'active-slide-out': currentModalContent !== 'verify-forgot-pass'
                    }"
                    ng-attr-inert="{{ currentModalContent !== 'verify-forgot-pass' ? true : undefined }}"
                    ng-cloak>


                    <!-- Empty for now -->
                    <div class="d-flex flex-column align-items-center justify-content-center animation-container">

                        <!-- <div class="d-flex flex-column align-items-center justify-content-center mb-3 some-animation">
                            Hello
                        </div> -->

                        <img class="d-block mx-auto" style="height: 70px;" src="<?php echo home_url('/wp-content/uploads/icons/OJTGO-630X310.png') ?>">

                    </div>

                    <!-- Header and Sub Title -->
                    <div class="row flex-column align-items-center justify-content-center mb-3 header">
                        <p class="col-auto fs-1 fw-bold text-center mb-0">Password Recovery</p>
                        <p class="col-auto text-secondary text-center mb-0 w-75" style="font-size: 1rem;">We have sent you a code in your email. Don't forget to also check your spam!</p>
                    </div>


                    <!-- Input Fields -->
                    <div class="row g-3 align-items-center mb-3">
                        <div class="col-auto">
                            <label class="form-label">Code: </label>
                        </div>
                        <div class="col-auto">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="09XXX"
                                ng-model="passRecoveryOtp"
                                ng-change="validateOtp('passRecoveryOtp')">
                        </div>
                    </div>


                    <!-- Resend code Forgot Password-->
                    <span class="col-12 text-center" style="font-size: 0.875rem;">Didn't get a code?</span>
                    <a
                        id="resend-code"
                        href="javascript:void(0)"
                        class="col-12 mb-0 text-center link-text"
                        style="font-size: 0.875rem;"
                        ng-click="resendForgotOtp()"
                        ng-class="{ 'text-muted': otpCooldown, 'disabled': otpCooldown }"
                        ng-if="!otpCooldown">
                        Resend the code.
                    </a>

                    <span
                        class="col-12 mb-0 text-center text-muted"
                        style="font-size: 0.875rem;"
                        ng-if="otpCooldown">
                        Resend available in {{ otpCooldownSeconds }}s
                    </span>


                    <!-- Login Button -->
                    <a
                        id="verify-email-pass-recovery"
                        href="javascript:void(0)"
                        class="col text-center my-5 px-5 py-2 modal-btn verify-btn"
                        ng-click="verifyAndProceed('pass-recovery')">
                        Verify
                    </a>



                    <!-- Direct to Login -->
                    <span class="col-12 text-center" style="font-size: 0.875rem;">Already have an account?</span>
                    <p class="col-12 mb-0 text-center" style="font-size: 0.875rem;">
                        <a
                            href="javascript:void(0)"
                            class="link-text login-account"
                            style="font-size: 0.875rem;"
                            ng-click="switchModalContent('login')">
                            Log in
                        </a>
                        instead.
                    </p>



                </div>


                <!-- Change Password Content -->
                <div
                    id="change-password-content"
                    control-tab="change-pass"
                    class="d-flex flex-column justify-content-center align-items-center text-center change-password-content"
                    ng-class="{
                        'active-slide-in': currentModalContent === 'change-pass',
                        'active-slide-out': currentModalContent !== 'change-pass'
                    }"
                    ng-attr-inert="{{ currentModalContent !== 'change-pass' ? true : undefined }}"
                    ng-cloak>

                    <div class="d-flex flex-column align-items-center justify-content-center animation-container">

                        <img class="d-block mx-auto" style="height: 70px;" src="<?php echo home_url('/wp-content/uploads/icons/OJTGO-630X310.png') ?>">

                    </div>

                    <!-- Header and Sub Title -->
                    <div class="row flex-column align-items-center justify-content-center mb-3 header">
                        <p class="col-auto fs-1 fw-bold text-center mb-0">Password Recovery</p>
                        <p class="col-auto text-secondary text-center mb-0 w-75" style="font-size: 1rem;">Forgot your password? We can help easily!</p>
                    </div>


                    <!-- Password Input field -->
                    <div class="d-flex flex-column justify-content-between gap-2 px-2 px-md-0">

                        <!-- Password -->
                        <div class="row g-3 align-items-center justify-content-center">
                            <div class="col-12 col-md-5">
                                <label class="col-form-label">Password: </label>
                            </div>
                            <div class="col-12 col-md-7">
                                <div class="input-group custom-width">
                                    <input
                                        type="{{ isNewPassVisible ? 'text' : 'password' }}"
                                        class="form-control password"
                                        ng-class="{'is-invalid': forgotPass.password.length > 0 && !passwordValid}"
                                        ng-model="forgotPass.password"
                                        ng-change="validatePassword('forgotPass')">
                                    <!-- Conditional Use of Icon depends on the current state of the password -->
                                    <span
                                        id="toggle-pass-visibility"
                                        class="input-group-text toggle-visibility"
                                        ng-click="togglePasswordVisibility('isNewPassVisible')">
                                        <i class="bi" ng-class="{'bi-eye': true, 'bi-eye-slash': false}"></i>
                                    </span><br />
                                </div>
                            </div>
                        </div>

                        <!--Confirm Password -->
                        <div class="row g-3 align-items-center justify-content-between">
                            <div class="col-12 col-md-5">
                                <label class="col-form-label">Confirm Password: </label>
                            </div>
                            <div class="col-12 col-md-7">
                                <div class="input-group custom-width">
                                    <input
                                        type="{{ isConfirmPassVisible ? 'text' : 'password' }}"
                                        class="form-control password"
                                        ng-class="{'is-invalid': forgotPass.confirmPass.length > 0 && !passChecks.matched}"
                                        ng-model="forgotPass.confirmPass"
                                        ng-change="validatePassword('forgotPass')">
                                    <!-- Conditional Use of Icon depends on the current state of the password -->
                                    <span
                                        id="toggle-pass-visibility"
                                        class="input-group-text toggle-visibility"
                                        ng-click="togglePasswordVisibility('isConfirmPassVisible')">
                                        <i class="bi" ng-class="{'bi-eye': true, 'bi-eye-slash': false}"></i>
                                    </span><br />
                                </div>
                            </div>
                        </div>


                        <!-- added by Lorenzo @ 04/23/2025 -->
                        <!-- password requirements -->
                        <div class="rounded text-start mt-2 p-2 px-3 px-2 w-100 guidelines">
                            <small
                                ng-class="{'text-success': passChecks.length && forgotPass.password, 'text-danger': forgotPass.password.length > 0 && !passChecks.length}">
                                ✔ At least 8 characters</small><br />
                            <small
                                ng-class="{'text-success': passChecks.lower && forgotPass.password, 'text-danger': forgotPass.password.length > 0 && !passChecks.lower}">
                                ✔ 1 lowercase &
                            </small>
                            <small
                                ng-class="{'text-success': passChecks.upper && forgotPass.password, 'text-danger': forgotPass.password.length > 0 && !passChecks.upper}">
                                1 uppercase
                            </small><br />
                            <small
                                ng-class="{'text-success': passChecks.number && forgotPass.password, 'text-danger': forgotPass.password.length > 0 && !passChecks.number}">
                                ✔ At least 1 number
                            </small> <br />
                            <small
                                ng-class="{'text-success': passChecks.special && forgotPass.password, 'text-danger': forgotPass.password.length > 0 && !passChecks.special}">
                                ✔ At least 1 special character
                            </small> <br />
                            <small
                                ng-class="{'text-success': passChecks.matched && forgotPass.confirmPass, 'text-danger': forgotPass.confirmPass.length > 0 && !passChecks.matched}">
                                ✔ Password Matched
                            </small> <br />
                        </div>

                    </div>

                    <!-- Modified by Lorenzo @ 04/24/2025 -->
                    <!-- Change Password -->
                    <a
                        id="change-pass-btn"
                        href="javascript:void(0)"
                        class="col text-center my-5 px-5 py-2 modal-btn change-pass-btn"
                        ng-click="changePassword();"
                        ng-class="{'disabled': !passwordValid}">
                        Change Password
                    </a>



                    <!-- Direct to Login -->
                    <span class="col-12 text-center" style="font-size: 0.875rem;">Already have an account?</span>
                    <p class="col-12 mb-0 text-center" style="font-size: 0.875rem;">
                        <a
                            href="javascript:void(0)"
                            class="link-text login-account"
                            style="font-size: 0.875rem;"
                            ng-click="switchModalContent('login')">
                            Log in
                        </a>
                        instead.
                    </p>

                </div>


            </div>


        </div>


    </div>

    <!-- Off Canvas - job postings card for mobile view -->
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="fym-map-mobile" aria-labelledby="fym-map-mobile">

        <div class="p-2 overflow-y-scroll">

            <div class="offcanvas-header">
                <h5 class="fw-bolf offcanvas-title">Job Posts</h5>
                <!-- <a href="javascript:;" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button> -->
                <a class="btn-close" data-bs-dismiss="offcanvas" href="#offcanvasExample" aria-controls="offcanvasExample">

                </a>
            </div>


        </div>

    </div>

    </div>


<?php
    return ob_get_clean();
}


add_shortcode('home_page', 'home_page_landing_page');
