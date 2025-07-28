<?php

/**
 * Plugin Name: Hirebilis Home
 * Description: Duplicated from OJTGo's home-page plugin.
 * Version: 1.0
 * Author: PCES Inc.
 */


//  Commit Before Implementing Design Alignment to Figma

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// require_once plugin_dir_path(__FILE__) . 'api/contact_form.php';
// require_once plugin_dir_path(__FILE__) . 'api/fetch_backend.php';

// Enqueue the script on the specific page
function home_page_enqueue_scripts()
{


    if (is_page('home')) {

        wp_enqueue_style(
            'hirebilis-style',
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


        // Bootstrap 5 CSS
        wp_enqueue_style(
            'bootstrap-css',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
            array(),
            '5.3.3'
        );


        // custom jQuery
        wp_enqueue_script(
            'hirebilis-script',
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

        wp_enqueue_style(
            'bootstrap-icons',
            'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css',
            array(),
            '1.10.5'
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

        // AOS CSS
        wp_enqueue_style('aos-css', 'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css');

        // AOS JS
        wp_enqueue_script('aos-js', 'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js', array(), null, true);

        // Init Script
        wp_add_inline_script('aos-js', 'AOS.init();');

        // High Chart Plugins

        // highchart js
        wp_enqueue_script('highchart-js', 'https://code.highcharts.com/highcharts.js', array(), null, true);

        // highchart - exporting
        wp_enqueue_script('highchart-exporting-js', 'https://code.highcharts.com/modules/exporting.js', array(), null, true);

        // highchart - export data
        wp_enqueue_script('highchart-exportdata-js', 'https://code.highcharts.com/modules/export-data.js', array(), null, true);

        // highchart - accessibility
        wp_enqueue_script('highchart-accessibility', 'https://code.highcharts.com/modules/accessibility.js', array(), null, true);

        // If using custom jQuery version (not recommended unless needed)
        wp_deregister_script('jquery');

        wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js', array(), '3.7.1', true);

        // Enqueue Select2 CSS & JS
        wp_enqueue_style('select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css');

        wp_enqueue_script('select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js', array('jquery'), null, true);
    }
}
add_action('wp_enqueue_scripts', 'home_page_enqueue_scripts');



// Enqueue the app script and styles
// Shortcode to display static HTML landing page
function home_page_shortcode_function()
{
    ob_start(); ?>

    <!-- Hirebilis Home Page / Charls Modification - June 15, 2025 -->
    <div class="pt-3 mt-5 px-0 mx-0 bg-white" ng-app="homeApp" ng-controller="homeController" ng-cloak class="angular-cloak">
        <div class="main-content">

            <!-- Modified by Lorenzo @ 03/31/2025 -->

            <!-- Start of Charls Modification - June 20, 2025 -->

            <!-- navbar -->
            <nav class="navbar navbar-expand-lg fixed-top bg-body-tertiary border border-lg-0">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#" ng-click="setActivePage('home')">
                        <img src="<?php echo home_url('/wp-content/uploads/icons/Hirebilis-630X310-Outlined.svg') ?>" alt="Logo" style="height: 50px;" class="d-inline-block align-text-center">
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
                                <a class="nav-link" href="#" ng-click="setActivePage('home'); scrollToTop()">Home</a>
                            </li>

                            <!-- About Dropdown -->
                            <li class="nav-item dropdown w-100 text-start">
                                <a class="nav-link dropdown-toggle w-100 text-start" id="aboutDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    About
                                </a>
                                <ul class="dropdown-menu w-150" aria-labelledby="aboutDropdown" style="border: none;">
                                    <li>
                                        <a class="dropdown-item" href="#about" ng-click="setActivePage('about'); scrollToTop(); scrollToSection('about', $event)">About Us</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#highlights" ng-click="setActivePage('highlights'); scrollToTop(); scrollToSection('highlights', $event)">Highlights</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#contact" ng-click="scrollToTop(); scrollToSection('contact', $event)">Contact Us</a>
                                    </li>
                                </ul>
                            </li>

                            <!-- Resources -->
                            <li class="nav-item dropdown w-100 text-start">
                                <a class="nav-link dropdown-toggle w-100 text-start" id="resourcesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Resources
                                </a>
                                <ul class="dropdown-menu w-150" aria-labelledby="resourcesDropdown" style="border: none;">
                                    <li>
                                        <a class="dropdown-item" href="#blogs" ng-click="setActivePage('blogs'); scrollToTop(); scrollToSection('blogs', $event)">Blogs</a>
                                    </li>
                                </ul>
                            </li>

                            <!-- Help -->
                            <li class="nav-item dropdown w-100 text-start">
                                <a class="nav-link dropdown-toggle w-100 text-start" id="helpDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Help
                                </a>
                                <ul class="dropdown-menu w-150" aria-labelledby="helpDropdown" style="border: none;">
                                    <li>
                                        <a class="dropdown-item" href="#how" ng-click="setActivePage('how'); scrollToTop()">How it works</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#faq" ng-click="setActivePage('faq'); scrollToTop()">FAQ's</a>
                                    </li>
                                </ul>
                            </li>


                            <!-- Login Register -->
                            <li class="nav-item me-2" ng-if="!isLoggedIn">
                                <a class="rounded-3 navbar-btn" href="javascript:void(0)" ng-click="openLoginModalNav()">
                                    Login
                                </a>
                            </li>

                            <li class="nav-item dropdown me-4 mt-3 mt-lg-0" ng-if="!isLoggedIn">
                                <a class="rounded-3 navbar-btn" ng-click="openLoginModalNavReg(); show_reg_page_1 = true" href="javascript:void(0)" role="button" aria-expanded="false">
                                    Register
                                </a>
                            </li>

                            <!-- Show "Dashboard" when user IS logged in -->
                            <li class="nav-item dropdown me-0 me-lg-4 mt-3 mt-lg-0" ng-if="isLoggedIn && dashboardUrl">
                                <a
                                    class="rounded-3 navbar-btn"
                                    ng-href="{{dashboardUrl}}"
                                    role="button">
                                    Dashboard
                                </a>
                            </li>


                        </ul>
                    </div>
                </div>
            </nav>

            <!-- home section with background image and overlay -->
            <section id="home"
                ng-show="activePage === 'home'"
                style="position: relative; width: 100%; min-height: 100vh; background: url('/wp-content/uploads/icons/taguig.webp') no-repeat center center / cover; color: white;">

                <!-- Overlay -->
                <div class="overlay"></div>


                <!-- Content -->
                <div class="container h-100 d-flex align-items-center" style="position: relative; z-index: 2;">
                    <div class="row justify-content-between w-100">

                        <!-- Left column: Tagline & CTA -->
                        <div class="col-md-7 col-xxl-6">
                            <div class="h-100 d-flex flex-column justify-content-center" style="margin-top: 150px;">

                                <!-- Animated Heading -->
                                <h3 class="fw-bold display-5">
                                    One Click. One Match. Hirebilis.
                                </h3>

                                <!-- Animated Paragraph -->
                                <p class="mt-4 fs-5">
                                    A platform built to empower Filipinos by connecting them with the right jobs—quickly, easily, and meaningfully.
                                </p>

                                <!-- Animated Button -->
                                <div class="mt-4">

                                    <!-- Show if logged in as applicant -->
                                    <a ng-if="isLoggedIn"
                                        ng-href="{{dashboardUrl}}"
                                        class="btn glow-btn px-4 py-2 hire">
                                        Get Hired
                                    </a>

                                    <!-- Show if not logged in -->
                                    <a ng-if="!isLoggedIn"
                                        href="/"
                                        class="btn glow-btn px-4 py-2 hire">
                                        Get Hired
                                    </a>
                                </div>

                            </div>
                        </div>

                        <!-- Right column: Hirebilis Logo -->
                        <div class="col-md-5 col-xxl-6 d-flex justify-content-center align-items-center">
                            <img src="/wp-content/uploads/icons/Hirebilis-Twoline_white.svg"
                                alt="Logo"
                                class="img-fluid"
                                style="max-width: 300px; margin-top: 185px;">
                        </div>

                    </div>
                </div>
            </section>

            <!-- why choose us section -->
            <section id="whyhirebilis" class="mt-3 mb-3"
                ng-show="activePage === 'home' || activePage === 'whyhirebilis'"
                style="padding: 50px 0; background-color: #ffffff; position: relative; overflow: hidden;"
                data-aos="fade-in"
                data-aos-duration="800">

                <div class="container" style="position: relative; z-index: 1;">
                    <h1 class="display-4 fw-bold text-center fs-2 mb-5"
                        style="color: #1D3557;"
                        data-aos="fade-up"
                        data-aos-duration="800">
                        Why choose us?
                    </h1>

                    <div class="row justify-content-center">

                        <div class="col-12 col-md-4 mb-4"
                            data-aos="fade-up"
                            data-aos-delay="0"
                            data-aos-duration="800">
                            <div class="card border-0 rounded-3 shadow-sm h-100 overflow-hidden text-center"
                                style="background-color: #fff;">
                                <div class="card-img-top" style="position: relative; overflow: hidden; height: 650px;">
                                    <img src="/wp-content/uploads/icons/why1webp.webp" class="img-fluid w-100 h-100 object-fit-cover" alt="Fast and Easy Hiring Image">
                                    <div class="overlay d-flex flex-column justify-content-start align-items-center p-3"
                                        style="position: absolute; top: 0; left: 0; width: 100%; height: 25%; background-color: rgba(0, 0, 0, 0.4); color: #fff;">
                                        <h5 class="fw-bold text-uppercase mb-2" style="font-size: 1.1rem;">Fast and Easy Hiring</h5>
                                        <p class="mb-0" style="font-size: 0.95rem;">Whether you're applying or posting a job, the process is quick, simple, and built for speed — no long forms or delays.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4 mb-4"
                            data-aos="fade-up"
                            data-aos-delay="200"
                            data-aos-duration="800">
                            <div class="card border-0 rounded-3 shadow-sm h-100 overflow-hidden text-center"
                                style="background-color: #fff;">
                                <div class="card-img-top" style="position: relative; overflow: hidden; height: 650px;">
                                    <img src="/wp-content/uploads/icons/why2webp.webp" class="img-fluid w-100 h-100 object-fit-cover" alt="Smart Job Matching Image">
                                    <div class="overlay d-flex flex-column justify-content-start align-items-center p-3"
                                        style="position: absolute; top: 0; left: 0; width: 100%; height: 25%; background-color: rgba(0, 0, 0, 0.4); color: #fff;">
                                        <h5 class="fw-bold text-uppercase mb-2" style="font-size: 1.1rem;">Smart Job Matching</h5>
                                        <p class="mb-0" style="font-size: 0.95rem;">Get personalized job recommendations based on your skills, location, and preferences — so you can apply smarter, not harder.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4 mb-4"
                            data-aos="fade-up"
                            data-aos-delay="400"
                            data-aos-duration="800">
                            <div class="card border-0 rounded-3 shadow-sm h-100 overflow-hidden text-center"
                                style="background-color: #fff;">
                                <div class="card-img-top" style="position: relative; overflow: hidden; height: 650px;">
                                    <img src="/wp-content/uploads/icons/why3webp.webp" class="img-fluid w-100 h-100 object-fit-cover" alt="Seamless Process Image">
                                    <div class="overlay d-flex flex-column justify-content-start align-items-center p-3"
                                        style="position: absolute; top: 0; left: 0; width: 100%; height: 25%; background-color: rgba(0, 0, 0, 0.4); color: #fff;">
                                        <h5 class="fw-bold text-uppercase mb-2" style="font-size: 1.1rem;">Seamless Process</h5>
                                        <p class="mb-0" style="font-size: 0.95rem;">Built-in messaging and real-time notifications help job seekers and employers connect instantly and move forward without the wait.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            <!-- dpo section -->
            <section id="dpo" ng-show="activePage === 'home' || activePage === 'dpo'" class="py-4 bg-white mb-5">
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

                    <div class="how-it-works-content p-3 rounded-bottom" style="background: linear-gradient(to bottom, #A8DADC 0%, white 50%);">
                        <h1 class="display-4 fw-bold fs-2 text-center p-3 rounded-top" style="color: #001F3F">
                            How Hirebilis Works
                        </h1>
                        <div class="row g-4 mt-2">
                            <!-- Step 1 -->
                            <div class="col-md-6 col-lg-3">
                                <div class="step-box h-100 p-4 d-flex flex-column">
                                    <div class="step-number-container text-center mb-3">
                                        <div class="step-number mx-auto" style="background-color: var(--light-blue); border-radius: 999px;">1</div>
                                    </div>
                                    <div id="step1" class="lottie-animation mb-3"></div>
                                    <div class="step-content flex-grow-1">
                                        <h3 class="step-title text-center">Step 1: Sign Up & Create Your Profile</h3>
                                        <p class="step-description text-center">Get started by registering at www.websitedotcom. Simply fill in your
                                            basic details—skills, job preferences, and location. Your dynamic profile replaces the traditional resume,
                                            showcasing your strengths effortlessly.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div class="col-md-6 col-lg-3">
                                <div class="step-box h-100 p-4 d-flex flex-column">
                                    <div class="step-number-container text-center mb-3">
                                        <div class="step-number mx-auto" style="background-color: var(--light-blue); border-radius: 999px;">2</div>
                                    </div>
                                    <div id="step2" class="lottie-animation mb-3"></div>
                                    <div class="step-content flex-grow-1">
                                        <h3 class="step-title text-center">Step 2: Get Matched & Explore Opportunities</h3>
                                        <p class="step-description text-center">Our smart matching system connects you with relevant
                                            job opportunities based on your profile. No need to search endlessly—the right jobs come to you.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="col-md-6 col-lg-3">
                                <div class="step-box h-100 p-4 d-flex flex-column">
                                    <div class="step-number-container text-center mb-3">
                                        <div class="step-number mx-auto" style="background-color: var(--light-blue); border-radius: 999px;">3</div>
                                    </div>
                                    <div id="step3" class="lottie-animation mb-3"></div>
                                    <div class="step-content flex-grow-1">
                                        <h3 class="step-title text-center">Step 3: Apply in One Click</h3>
                                        <p class="step-description text-center">Found a job that fits? Apply directly through the platform with just one click.
                                            Your profile is sent instantly to the employer—fast, simple, effective.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 4 -->
                            <div class="col-md-6 col-lg-3">
                                <div class="step-box h-100 p-4 d-flex flex-column">
                                    <div class="step-number-container text-center mb-3">
                                        <div class="step-number mx-auto" style="background-color: var(--light-blue); border-radius: 999px;">4</div>
                                    </div>
                                    <div id="step4" class="lottie-animation mb-3"></div>
                                    <div class="step-content flex-grow-1">
                                        <h3 class="step-title text-center">Step 4: Track & Get Hired</h3>
                                        <p class="step-description text-center">Stay updated with real-time notifications about your application status.
                                            When matched, the employer contacts you directly—you're on your way to getting hired!</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container my-5">
                            <h2 class="text-center fw-bold mb-5" style="color: #001F3F;">
                                Why Hirebilis Works for You
                            </h2>

                            <div class="row g-4 align-items-center">
                                <!-- List on the left -->
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex align-items-start border-0 px-0 mb-3">
                                            <i class="bi bi-check-circle-fill fs-4 me-3" style="color: var(--light-gold);"></i>
                                            <div>
                                                <strong>Smarter than resume</strong> – Your profile does the talking.
                                            </div>
                                        </li>
                                        <li class="list-group-item d-flex align-items-start border-0 px-0 mb-3">
                                            <i class="bi bi-check-circle-fill fs-4 me-3" style="color: var(--light-gold);"></i>
                                            <div>
                                                <strong>Fast job matching</strong> – Get connected with the right opportunities in minutes.
                                            </div>
                                        </li>
                                        <li class=" list-group-item d-flex align-items-start border-0 px-0 mb-3">
                                            <i class="bi bi-check-circle-fill fs-4 me-3" style="color: var(--light-gold);"></i>
                                            <div>
                                                <strong>Real-time job updates</strong> – See the latest openings as they go live.
                                            </div>
                                        </li>
                                        <li class="list-group-item d-flex align-items-start border-0 px-0">
                                            <i class="bi bi-check-circle-fill fs-4 me-3" style="color: var(--light-gold);"></i>
                                            <div>
                                                <strong>Built for speed</strong> – From sign-up to application, everything is designed to save your time.
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Highlighted message on the right -->
                                <div class="col-md-6">
                                    <div class="p-4 rounded-3 shadow-sm" style="background: linear-gradient(135deg, #A3B3B8 0%, #A8DADC 100%);">
                                        <p class="mb-0 fs-5 text-dark fw-semibold">
                                            <strong>Hirebilis isn’t just another job platform</strong> — it’s a smarter, faster way to get hired in the Philippines.<br>
                                            Let’s make job hunting simple, meaningful, and efficient—together.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>

                <!-- Video Demo Section -->
                <div class="container mt-5 d-none">
                    <h2 class="text-center fw-bold" style="color: #001F3F ;">Watch Hirebilis in Action</h2>
                    <p class="text-center mb-4">Explore how Hirebilis works from both the Student and Employer perspectives.</p>

                    <div class="row g-4">

                        <!-- Student Side Video -->
                        <div class="col-md-6">
                            <div class="card shadow-sm h-100 border-0">
                                <div class="card-header text-white fw-semibold text-center" style="background-color: #001F3F;">
                                    Student Side Demo
                                </div>
                                <div class="card-body p-0">
                                    <div class="ratio ratio-16x9">
                                        <iframe
                                            src="https://www.youtube.com/embed/4b_KPbqJQx8"
                                            title="Student Demo" allowfullscreen
                                            style="width:100%;height:100%;border:0;">
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Employer Side Video -->
                        <div class="col-md-6">
                            <div class="card shadow-sm h-100 border-0">
                                <div class="card-header text-white fw-semibold text-center" style="background-color: #001F3F;">
                                    Employer Side Demo
                                </div>
                                <div class="card-body p-0">
                                    <div class="ratio ratio-16x9">
                                        <iframe
                                            src="https://www.youtube.com/embed/4b_KPbqJQx8"
                                            title="Employer Demo" allowfullscreen
                                            style="width:100%; height:100%; border:0;">
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            <!-- <section id="how-it-works" class="py-5" style="background-color: #f8f9fa;">
            <div class="container">
                <h2 class="text-center fw-bold mb-4" style="color: #343a40;">How It Works</h2>
                <p class="text-center text-muted mb-5">Goby Homes facilitates seamless multi-party communication, enhancing transparency in the home-buying process.</p>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card border-0 rounded-4 shadow-sm h-100" style="background-color: #f0f0f5;">
                            <div class="card-body p-4 d-flex align-items-start">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px;">
                                    1
                                </div>
                                <div>
                                    <h5 class="fw-bold text-primary mb-2">Create a Project</h5>
                                    <p class="text-muted mb-0">Enter innovation's realm with our visionary project.</p>
                                    <img src="/wp-content/uploads/icons/how1.png" alt="Create a Project Illustration" class="img-fluid mt-3">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card border-0 rounded-4 shadow-sm h-100" style="background-color: #f0f0f5;">
                            <div class="card-body p-4 d-flex align-items-start">
                                <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px;">
                                    2
                                </div>
                                <div>
                                    <h5 class="fw-bold text-info mb-2">Invite Transactional Members</h5>
                                    <p class="text-muted mb-0">Exclusive invitations await, sparking collaboration.</p>
                                    <img src="/wp-content/uploads/icons/how2.png" alt="Invite Members Illustration" class="img-fluid mt-3">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card border-0 rounded-4 shadow-sm h-100" style="background-color: #f0f0f5;">
                            <div class="card-body p-4 d-flex align-items-start">
                                <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px;">
                                    3
                                </div>
                                <div>
                                    <h5 class="fw-bold text-warning mb-2">Begin Collaborating</h5>
                                    <p class="text-muted mb-0">Unite for a journey of teamwork and innovation.</p>
                                    <img src="/wp-content/uploads/icons/how3.png" alt="Begin Collaboration Illustration" class="img-fluid mt-3">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card border-0 rounded-4 shadow-sm h-100" style="background-color: #f0f0f5;">
                            <div class="card-body p-4 d-flex align-items-start">
                                <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px;">
                                    4
                                </div>
                                <div>
                                    <h5 class="fw-bold text-success mb-2">Close Deals</h5>
                                    <p class="text-muted mb-0">Seal the path to success as deals unfold seamlessly in motion.</p>
                                    <img src="/wp-content/uploads/icons/how4.png" alt="Close Deals Illustration" class="img-fluid mt-3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->

            <!-- faq section -->
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
                                <button class="custom-tab-button" ng-click="faqTab = 'ojtgo'">Hirebilis</button>
                                <button class="custom-tab-button" ng-click="faqTab = 'student'">Applicant</button>
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

            <!-- blogs section -->
            <section id="blogs" ng-show="activePage === 'blogs'" class="bg-white py-5 d-flex flex-column">
                <div class="container">
                    <!-- Section Title -->
                    <h1 class="display-4 text-white fw-semibold fs-3 text-center p-3 rounded" style="background-color: #001F3F;">
                        Our Latest Blogs
                    </h1>

                    <!-- Blog card -->
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        <div class="col" ng-repeat="blog in blogs">

                            <div class="card h-100 shadow-sm border-0 rounded-4 p-3 bg-white d-flex flex-column"
                                ng-class="{'expanded-card': selectedBlog === blog}"
                                style="transition: all 0.3s ease; cursor: pointer;">

                                <!-- Blog Media -->
                                <img ng-if="blog.image"
                                    ng-src="{{blog.image}}"
                                    loading="lazy"
                                    class="card-img-top rounded"
                                    alt="{{blog.title_blog}}"
                                    style="max-height: 200px; object-fit: cover;">

                                <!-- Blog Content -->
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">{{blog.title}}</h5>
                                    <small class="text-muted">{{blog.date | date:'MMMM d, yyyy'}}</small>

                                    <!-- Collapsed Quill-rendered preview -->
                                    <div class="card-text mt-2" ng-if="selectedBlog !== blog">
                                        <div ng-bind-html="blog.descriptionUnescaped | limitHtmlTo: 150"></div>
                                        <span class="text-primary fw-semibold" ng-click="toggleBlogExpansion(blog)">See More</span>
                                    </div>

                                    <!-- Expanded -->
                                    <div ng-if="selectedBlog === blog"
                                        class="mt-3"
                                        style="max-height: 300px; overflow-y: auto;">
                                        <div class="quill-wrapper" readonly-view="true">
                                            <div ng-bind-html="blog.descriptionUnescaped | trustAsHtml" style="height: 300px;"></div>
                                        </div>

                                    </div>
                                    <button ng-if="selectedBlog === blog" class="btn btn-outline-secondary btn-sm mt-3"
                                        ng-click="toggleBlogExpansion(null); $event.stopPropagation()">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div ng-if="blogs.length === 0" class="text-muted mt-3 mb-5 mt-5">No blog found.</div>
                </div>
            </section>

            <!-- highlights section -->
            <section id="highlights" ng-show="activePage === 'highlights'" class="bg-white py-5">
                <div class="container">
                    <h1 class="display-4 fw-bold fs-3 text-center p-3 rounded mb-5" style="color: #001F3F;">
                        Hirebilis Highlights
                    </h1>

                    <!-- Highlight Filters (Buttons) -->
                    <div class="container">
                        <div class="d-flex flex-wrap justify-content-center gap-2 mb-3">
                            <button class="btn hl-button"
                                ng-class="{'active': activeHighlight === 'all'}"
                                ng-click="activeHighlight='all'">
                                All
                            </button>
                            <button class="btn hl-button"
                                ng-class="{'active': activeHighlight === 'news'}"
                                ng-click="activeHighlight = 'news'">
                                News
                            </button>
                            <button class="btn hl-button"
                                ng-class="{'active': activeHighlight === 'testimonial'}"
                                ng-click="activeHighlight = 'testimonial'">
                                Testimonials
                            </button>
                            <button class="btn hl-button"
                                ng-class="{'active': activeHighlight === 'facebook'}"
                                ng-click="activeHighlight = 'facebook'">
                                Facebook
                            </button>
                            <button class="btn hl-button"
                                ng-class="{'active': activeHighlight === 'instagram'}"
                                ng-click="activeHighlight = 'instagram'">
                                Instagram
                            </button>
                            <button class="btn hl-button"
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

            <!-- privacy notice section -->
            <section id="privacy" ng-show="activePage === 'privacy'" class="bg-light py-5 bg-transparent">
                <div class="container">
                    <h1 class="display-4 text-white fw-semibold fs-3 text-center p-3 rounded" style="background-color:#001F3F;">
                        Privacy Notice
                    </h1>

                    <div style="background-color: rgba(0, 0, 0, 0.47); color: white; padding: 2rem; border-radius: 8px;">

                        <p><strong>Hirebilis</strong> is a purpose-driven job-matching platform committed to empowering Filipino
                            job seekers by connecting them quickly and meaningfully with the right employment opportunities. It is
                            owned and operated by <strong>PCES Inc.</strong> and designed for efficiency, equity, and user empowerment. Our platform
                            supports users at every step of their job search journey.
                        </p>

                        <p>At <strong>Hirebilis</strong>, your privacy is important to us. This Privacy Policy explains how we collect, use,
                            protect, and share information when you access or use our platform in accordance with the <a href="https://privacy.gov.ph/data-privacy-act/" target="_blank" rel="noopener noreferrer" style="color: deepskyblue;">Privacy Act of 2012</a> and guidelines from the <strong>National Privacy Commission (NPC)</strong>.
                            By using Hirebilis, you agree to the terms of this policy.
                        </p>

                        <h4>1. Information We Collect</h4>
                        <ul>
                            <li><strong>Personal Information:</strong> Full name, email, contact number, date of birth, location, employment history, educational background, skills, interests, and job preferences.</li>
                            <li><strong>Character References:</strong> Names, job titles, and contact info (shared with prior consent).</li>
                            <li><strong>Employer/Entity Information:</strong> Company name, industry, contact details, verification documents, job post information.</li>
                            <li><strong>Non-Personal Information:</strong> Device/browser data, IP address, usage activity.</li>
                        </ul>

                        <h4>2. How We Use Your Information</h4>
                        <ul>
                            <li>Match job seekers with opportunities based on preferences and skills.</li>
                            <li>Facilitate applications and platform communication.</li>
                            <li>Notify users about relevant jobs.</li>
                            <li>Improve platform performance and user experience.</li>
                            <li>Enable employers to find qualified candidates.</li>
                            <li>Provide customer support.</li>
                            <li>Send promotional emails (with user consent).</li>
                            <li>Ensure platform security and prevent fraud.</li>
                        </ul>
                        <p><strong>We do not sell your personal data to third parties.</strong></p>

                        <h4>3. Information Sharing and Disclosure</h4>
                        <ul>
                            <li>With employers who post relevant jobs.</li>
                            <li>With applicants viewing job opportunities.</li>
                            <li>With trusted service providers under confidentiality agreements.</li>
                            <li>With authorities when legally required or to protect platform integrity.</li>
                        </ul>

                        <h4>4. Data Security</h4>
                        <ul>
                            <li>HTTPS encryption for all data transmission.</li>
                            <li>Web Application Firewall (WAF).</li>
                            <li>Access control limited to authorized staff.</li>
                            <li>Regular audits and security testing.</li>
                        </ul>
                        <p><strong>Disclaimer:</strong> While no system is 100% secure, we continually improve our protection measures.</p>

                        <h4>5. Cookies and Tracking Technologies</h4>
                        <p>We use cookies to enhance your experience and analyze platform usage. You can manage cookie settings in your browser.</p>

                        <h4>6. Your Choices and Rights</h4>
                        <ul>
                            <li>Update your profile via your dashboard.</li>
                            <li>Manage email preferences and unsubscribe anytime.</li>
                            <li>Request access or deletion of your data (subject to verification).</li>
                        </ul>

                        <h4>7. Retention of Personal Information</h4>
                        <p><strong>a) General Policy:</strong> We retain data for 1 year unless required longer by law or institutional rules.</p>
                        <p><strong>b) Specific Schedules:</strong></p>
                        <ul>
                            <li><strong>Applicant data:</strong> Retained during account activity and up to 1 year after inactivity.</li>
                            <li><strong>Employer data:</strong> Retained up to 1 year post-deletion.</li>
                            <li><strong>Job applications:</strong> Retained up to 1 year.</li>
                        </ul>
                        <p><strong>c) Legal/Institutional Exceptions:</strong> Some data may be kept longer for audits or compliance.</p>
                        <p><strong>d) Data Minimization:</strong> We collect only necessary data and use encryption and access control to safeguard it.</p>

                        <h4>8. Consent and Lawful Processing</h4>
                        <p>By using Hirebilis, you consent to our data practices. You may withdraw your consent anytime via your account or by contacting us. Cross-border users agree to data transfer to the Philippines.</p>

                        <h4>9. Your Rights Under the Law</h4>
                        <ul>
                            <li>Be informed about your data use.</li>
                            <li>Access and correct your data.</li>
                            <li>Request deletion or limit processing.</li>
                            <li>Object to unauthorized processing.</li>
                            <li>File a complaint with the <strong>National Privacy Commission (NPC)</strong>.</li>
                        </ul>
                        <p>More info: <a href="https://privacy.gov.ph/data-subject-rights/" target="_blank" style="color: deepskyblue;">https://privacy.gov.ph/data-subject-rights/</a></p>

                        <h4>10. Updates to This Notice</h4>
                        <p>This policy may be updated due to legal or service changes. The most current version is published on <strong>OJTGo.com</strong>. Continued use indicates agreement to changes.</p>

                        <h4>11. Contact Us</h4>
                        <p>For data privacy concerns, access, or deletion requests, contact our Data Protection Officer:</p>
                        <ul>
                            <li><strong>PCES Inc.</strong> Level 10-01, One Global Place, 25th St. corner 5th Ave., Bonifacio Global City, Taguig City 1630</li>
                            <li><strong>Email:</strong> <a href="mailto:ojt@ojtgo.com" style="color: deepskyblue;">ojt@ojtgo.com</a></li>
                            <li><strong>Phone:</strong> (02) 8628-2072</li>
                        </ul>
                    </div>

                </div>
            </section>

            <!-- terms of use section -->
            <section id="terms" ng-show="activePage === 'terms'" class="bg-light py-5 bg-transparent">
                <div class="container">
                    <h2 class="display-4 text-white fw-semibold fs-3 text-center p-3 rounded" style="background-color: #001F3F;">
                        Terms of Use
                    </h2>

                    <div style="background-color: rgba(0, 0, 0, 0.47); color: white; padding: 2rem; border-radius: 8px;">
                        <h4 class="mt-4"><strong>Employer</strong></h4>
                        <ol class="mt-3">
                            <li><strong>Account Creation and Registration</strong><br>
                                Employers must register for an account and provide accurate and up-to-date information to access and use the Website’s services. You are responsible for keeping your account credentials, including your username and password, confidential. Notify us immediately if you suspect unauthorized access or use of your account.
                            </li>
                            <li class="mt-3"><strong>Job Postings and Content</strong><br>
                                By posting job openings, you confirm that all submitted content is accurate, complete, and lawful. You are solely responsible for the content of your job postings and any resulting outcomes. Do not post illegal, defamatory, offensive, or inappropriate content. We reserve the right to remove or modify any content that violates these Terms or our content guidelines.
                            </li>
                            <li class="mt-3"><strong>Candidate Selection and Communication</strong><br>
                                You are solely responsible for selecting and hiring candidates. We do not guarantee any applicant’s qualifications, suitability, or performance. All interactions, negotiations, and hiring decisions between employer and the applicant are entirely your responsibility. Hirebilis has no role in employment arrangements.
                            </li>
                            <li class="mt-3"><strong>Intellectual Property</strong><br>
                                The Website and all its content—including text, graphics, logos, and software—are protected by intellectual property rights owned by us or our licensors. You may not reproduce, modify, distribute, or use any part of the Website without explicit permission.
                            </li>
                            <li class="mt-3"><strong>Limitation of Liability</strong><br>
                                You agree to use the Website at your own risk. We are not liable for any direct, indirect, incidental, consequential, or punitive damages resulting from your use of the Website or any errors in the content provided.
                            </li>
                            <li class="mt-3"><strong>Indemnification</strong><br>
                                You agree to indemnify and hold Hirebilis harmless from any claims, losses, damages, or expenses arising from your use of the Website, violation of these Terms, or breach of any applicable laws.
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
                                These Terms constitute the entire agreement between you and Hirebilis regarding your use of the Website as an employer, superseding any prior agreements or understandings.
                            </li>
                        </ol>

                        <h4 class="mt-5"><strong>Applicant</strong></h4>
                        <ol class="mt-3">
                            <li><strong>Account Creation and Registration</strong><br>
                                Applicant must register for an account and provide accurate, complete, and current information. You are responsible for maintaining the confidentiality of your account credentials. Report any unauthorized use of your account immediately.
                            </li>
                            <li class="mt-3"><strong>Eligibility and Responsibilities</strong><br>
                                You confirm that you are a Filipino job seeker. You agree to conduct yourself professionally and honestly in all interactions with host companies and organizations.
                            </li>
                            <li class="mt-3"><strong>Application Conduct</strong><br>
                                You affirm that all information in your application is truthful and complete. You are solely responsible for ensuring your application complies with your requirements. Misrepresentation, misconduct, or unprofessional behavior may result in suspension or termination of your account.
                            </li>
                            <li class="mt-3"><strong>Matching and Placement</strong><br>
                                Hirebilis facilitates connections but does not guarantee placement. Application selection and approval are determined solely by host companies. We are not responsible for any outcomes, including mismatches or rejections.
                            </li>
                            <li class="mt-3"><strong>Data Use and Communication</strong><br>
                                You consent to the collection and use of your personal data for internship matching, communication with HTEs and coordinators, and academic monitoring. System notifications and optional promotional messages may be sent to you, which can be managed via your account settings.
                            </li>
                            <li class="mt-3"><strong>Intellectual Property</strong><br>
                                All materials you upload, your intellectual property. By submitting them, you grant Hirebilis a limited, non-exclusive license to use them solely for internship facilitation.
                            </li>
                            <li class="mt-3"><strong>Limitation of Liability</strong><br>
                                Hirebilis is not liable for any direct, indirect, incidental, consequential, or punitive damages arising from your use of the Website or any interaction with employers.
                            </li>
                            <li class="mt-3"><strong>Indemnification</strong><br>
                                You agree to indemnify and hold harmless Hirebilis from any claims, damages, or expenses resulting from your use of the Website or any breach of these Terms.
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
                                These Terms represent the entire agreement between you and Hirebilis regarding your use of the Website as an intern.
                            </li>
                        </ol>
                    </div>

            </section>

            <!-- about us section -->
            <section id="about" ng-show="activePage === 'about'">
                <section class="bg-white text-center pt-5 pb-2">
                    <div class="container">
                        <h1 class="display-4 text-white fw-semibold fs-3 text-center p-3 rounded" style="background-color: #001F3F;">
                            About Us
                        </h1>
                        <p class="mt-3" style="font-size: 1.1rem; text-align: justify;"><strong>At Hirebilis, we bridge the gap between talent and opportunity—fast.</strong>
                            Our platform is designed to empower Filipino job seekers by providing seamless access to jobs that match their skills,
                            interests, and career goals. Whether you're looking for your first job, a career shift, or a better opportunity, Hirebilis
                            connects you to employers efficiently and meaningfully. We believe getting hired shouldn't be hard—just fast, fair, and right for you.</p>
                    </div>
                </section>

                <!-- Mission and Vision Section -->
                <section class="pt-4 pb-4">
                    <div class="container" style="background-color: rgba(255, 255, 255, 0.9); border-radius: 10px;">
                        <div class="row">
                            <div class="col-md-6 d-flex align-items-stretch">
                                <div class="card w-100 mb-4" style="border: none; box-shadow: none;">
                                    <div class="card-body">
                                        <h2 class="card-title mb-3" style="color: #001F3F;">Our Mission</h2>
                                        <p class="card-text" style="font-size: 1.1rem; text-align: justify;">
                                            At Hirebilis, our mission is to empower Filipino job seekers by delivering a fast, reliable, and user-friendly platform that connects them with job opportunities that align with their skills, aspirations, and values. We aim to streamline the hiring process through smart matching technology, real-time job updates, and responsive support, ensuring that every applicant feels seen, valued, and connected.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex align-items-stretch">
                                <div class="card w-100 mb-4" style="border: none; box-shadow: none;">
                                    <div class="card-body">
                                        <h2 class="card-title mb-3" style="color: #001F3F;">Our Vision</h2>
                                        <p class="card-text" style="font-size: 1.1rem; text-align: justify;">
                                            Our vision is to become the most trusted and innovative job-matching platform in the Philippines, where job seekers and employers find each other with ease, confidence, and efficiency. We envision a future where every Filipino has fair access to meaningful work, regardless of their background or location. By fostering partnerships with schools, businesses, and communities, we strive to build a workforce that is skilled, future-ready, and empowered to thrive in a rapidly changing world.
                                        </p>
                                    </div>
                                </div>
                            </div>
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
                                        src="<?php echo home_url('/wp-content/uploads/icons/introhirebilisweb.webp') ?>"
                                        alt="introduce"
                                        class="img-fluid rounded shadow-lg"
                                        style="max-width: 90%; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);">
                                </div>

                                <!-- Text -->
                                <div class="col-md-6 order-2 order-md-2">
                                    <h2 style="color: #001F3F;">Introducing Hirebilis</h2>
                                    <p style="font-size: 1.1rem; text-align: justify;">Hirebilis is a modern, purpose-driven job-matching platform built for the fast-paced needs of the Filipino workforce.
                                        Designed with simplicity and efficiency in mind, Hirebilis connects job seekers to the right employers—quickly, easily,
                                        and meaningfully. Whether you're fresh out of school, shifting careers, or searching for your next big opportunity, Hirebilis
                                        helps you take that next step with confidence.
                                        More than just a job board, Hirebilis offers seamless application processes, intelligent job matching, and tools to help users
                                        prepare for and succeed in the workplace. For employers, Hirebilis provides access to a diverse pool of ready-to-work talent and
                                        a streamlined hiring experience.</p>
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
                                    <h2 style="color: #001F3F;">How it started?</h2>
                                    <p style="font-size: 1.1rem; text-align: justify;">Hirebilis began with a simple yet powerful idea: make the job search process faster and smarter for every Filipino.
                                        We saw the struggles of job seekers—long waiting times, overwhelming job boards, and mismatched opportunities—and realized there had to be a better way.
                                        Driven by real experiences and a passion for innovation, our team set out to build a platform that doesn’t just list jobs, but truly connects people to
                                        meaningful work that fits their skills and goals.
                                </div>
                                <!-- Image -->
                                <div class="col-md-6 order-1 order-md-2">
                                    <img src="<?php echo home_url('/wp-content/uploads/icons/howeb.webp') ?>"
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
                                    <img src="<?php echo home_url('/wp-content/uploads/icons/ph.jpg') ?>"
                                        alt="Our Story" class="img-fluid rounded shadow">
                                </div>
                                <!-- Text -->
                                <div class="col-md-6 order-2 order-md-2">
                                    <h2 style="color: #001F3F;">What we created?</h2>
                                    <p style="font-size: 1.1rem; text-align: justify;">We created Hirebilis—a job-matching platform that goes beyond traditional hiring.
                                        Our system is built to be fast, intuitive, and empowering—matching applicants with opportunities that are relevant, timely, and right for them.
                                        For job seekers, we offer a smooth experience from discovery to application. For employers, we provide access to qualified, workforce-ready
                                        talent through a user-friendly dashboard. We didn’t just create a platform—we built a community focused on access, equity, and opportunity for all.
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- our values section -->
                <section class="our-values-section py-5 bg-white">
                    <div class="container">
                        <h2 class="text-center mb-4" style="color: var(--deep-blue); font-weight: bold;">OUR VALUES</h2>
                        <div class="row justify-content-center g-4 mt-5">
                            <!-- Hire Fast -->
                            <div class="col-6 col-md-3 text-center">
                                <div class="icon-container rounded-3 mb-3 d-flex align-items-center justify-content-center"
                                    style="background-color: var(--slate-gray); width: 100px; height: 100px; margin: 0 auto;">
                                    <div id="fast" style="width:100%; height:100%;"></div>
                                </div>
                                <p class="fw-semibold" style="color: #333;">Hire Fast</p>
                            </div>

                            <!-- Seamless Process -->
                            <div class="col-6 col-md-3 text-center">
                                <div class="icon-container rounded-3 mb-3 d-flex align-items-center justify-content-center"
                                    style="background-color: var(--slate-gray); width: 100px; height: 100px; margin: 0 auto;">
                                    <div id="seamless" style="width:100%; height:100%;"></div>
                                </div>
                                <p class="fw-semibold" style="color: #333;">Seamless Process</p>
                            </div>

                            <!-- Empower Users -->
                            <div class="col-6 col-md-3 text-center">
                                <div class="icon-container rounded-3 mb-3 d-flex align-items-center justify-content-center"
                                    style="background-color: var(--slate-gray); width: 100px; height: 100px; margin: 0 auto;">
                                    <div id="empower" style="width:100%; height:100%;"></div>
                                </div>
                                <p class="fw-semibold" style="color: #333;">Empower Users</p>
                            </div>

                            <!-- Grow Together -->
                            <div class="col-6 col-md-3 text-center">
                                <div class="icon-container rounded-3 mb-3 d-flex align-items-center justify-content-center"
                                    style="background-color: var(--slate-gray); width: 100px; height: 100px; margin: 0 auto;">
                                    <div id="grow" style="width:100%; height:100%;"></div>
                                </div>
                                <p class="fw-semibold" style="color: #333;">Grow Together</p>
                            </div>
                        </div>
                    </div>
                </section>


            </section>

            <!-- contact us section -->
            <section id="contact" style="background: url('/wp-content/uploads/icons/net.webp') center center/cover no-repeat; padding: 60px 0; position: relative; z-index: 1;">
                <!-- Optional Overlay -->
                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(1, 1, 1, 0.75); backdrop-filter: blur(3px); z-index: 2;"></div>

                <div class="container position-relative" style="z-index: 3;">
                    <div class="row justify-content-center">

                        <h2 class="fw-bold text-white text-center mb-4">Contact Us</h2>

                        <!-- Heading & Description (Centered) -->
                        <div class="col-lg-6 mb-5 d-flex flex-column justify-content-center align-items-center text-center text-white mx-auto">

                            <p class="mb-2 w-75 text-justify">
                                Have questions, feedback, or need support? We’re here to help! Reach out to the Hirebilis team
                                and we’ll get back to you as soon as possible. Whether you're a job seeker or an employer, your
                                success is our priority.
                            </p>
                            <p class="fw-bold w-75 text-justify">Kaya kung may tanong ka? Sagot namin 'yan, bilis lang!</p>
                        </div>


                        <!-- Contact Form with Glassmorphism -->
                        <div class="col-lg-6 mt-4 mb-3">
                            <div style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-radius: 20px; padding: 20px; 
                        /* Reduced padding */ box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); max-height: 600px; /* Set a max height */ overflow-y: auto; /* Ensure overflow is handled if content exceeds max-height */">
                                <form name="contactForm" ng-submit="submitContactForm()" novalidate>
                                    <!-- Name -->
                                    <div class="form-group mb-3"> <!-- Reduced margin-bottom -->
                                        <label for="contact-us-name" class="form-label text-white fw-semibold">Name</label>
                                        <input type="text" id="contact-us-name"
                                            class="form-control border-0 border-bottom rounded-0 bg-transparent text-white white-placeholder"
                                            style="border-color: #ffffff; color:#e7f0fd;" ng-model="contactFormData.name" placeholder="e.g. John Doe" required>
                                    </div>

                                    <!-- Email -->
                                    <div class="form-group mb-3"> <!-- Reduced margin-bottom -->
                                        <label for="contact-us-email" class="form-label text-white fw-semibold">Email</label>
                                        <input type="email" id="contact-us-email"
                                            class="form-control border-0 border-bottom rounded-0 bg-transparent text-white white-placeholder"
                                            style="border-color: #ffffff; color:#e7f0fd;" ng-model="contactFormData.email" placeholder="johndoe@example.com" required>
                                    </div>

                                    <!-- Mobile Number -->
                                    <div class="form-group mb-3"> <!-- Reduced margin-bottom -->
                                        <label for="contact-us-mobile" class="form-label text-white fw-semibold">Mobile Number</label>
                                        <input type="text" id="contact-us-mobile"
                                            class="form-control border-0 border-bottom rounded-0 bg-transparent text-white white-placeholder"
                                            style="border-color: #ffffff; color:#e7f0fd;" ng-model="contactFormData.mobile" placeholder="+639*********" required>
                                    </div>

                                    <!-- Message -->
                                    <div class="form-group mb-3"> <!-- Reduced margin-bottom -->
                                        <label for="contact-us-message" class="form-label text-white fw-semibold">Message</label>
                                        <textarea id="contact-us-message"
                                            class="form-control border-0 border-bottom rounded-0 bg-transparent text-white white-placeholder"
                                            style="border-color: #ffffff; color: #e7f0fd;"
                                            ng-model="contactFormData.message" rows="3"
                                            placeholder="Start typing..." required></textarea>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="d-grid mt-3"> <!-- Reduced margin-top -->
                                        <button type="submit" ng-class="{'disabled': onsubmit}" class="btn fw-bold text-white py-2"
                                            style="background-color: #001F3F; border: none;">
                                            Send Message
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

        </div>

        <!-- footer section -->
        <section class="footer-container" style="background-color: #001F3F; color: white; padding: 20px 10px;">
            <div class="container-fluid px-2 px-md-2 px-lg-5">

                <div class="row align-items-center d-lg-flex justify-content-lg-between">
                    <div class="col-12 col-lg-auto text-start mt-4 mb-lg-0">
                        <img style="height: 80px;"
                            src="<?php echo home_url('/wp-content/uploads/icons/Hirebilis-Twoline_white.svg') ?>"
                            alt="logo"
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
                            <a class="text-white text-decoration-none py-1 px-2" style="font-size: 1.1rem;" href="#whyhirebilis" ng-click="setActivePage('whyhirebilis'); scrollToSection('whyhirebilis', $event)">Why Hirebilis?</a>
                            <a class="text-white text-decoration-none py-1 px-2" style="font-size: 1.1rem;" href="#privacy" ng-click="setActivePage('privacy')">Privacy Policy</a>
                            <a class="text-white text-decoration-none py-1 px-2" style="font-size: 1.1rem;" href="#terms" ng-click="setActivePage('terms')">Terms of Use</a>
                        </nav>
                    </div>

                </div>
            </div>
        </section>

        <!-- modal overlay for login and register -->
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

                        <img class="d-block mx-auto" style="height: 70px;" src="<?php echo home_url('/wp-content/uploads/icons/Hirebilis-630X310-Outlined.svg') ?>">

                    </div>

                    <!-- Header and Sub Title -->
                    <div class="row flex-column align-items-center justify-content-center mb-3 header">
                        <p class="col-auto fs-1 fw-bold text-center mb-0">Welcome Back!</p>
                        <p class="col-auto text-secondary text-center mb-0 w-75" style="font-size: 1rem;">Applicant or Employer!</p>
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

                        <img class="d-block mx-auto" style="height: 70px;" src="<?php echo home_url('/wp-content/uploads/icons/Hirebilis-630X310-Outlined.svg') ?>">

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
                        Applicant
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

                        <img class="d-block mx-auto" style="height: 70px;" src="<?php echo home_url('/wp-content/uploads/icons/Hirebilis-630X310-Outlined.svg') ?>">

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

                        <img class="d-block mx-auto" style="height: 70px;" src="<?php echo home_url('/wp-content/uploads/icons/Hirebilis-630X310-Outlined.svg') ?>">

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

                        <img class="d-block mx-auto" style="height: 70px;" src="<?php echo home_url('/wp-content/uploads/icons/Hirebilis-630X310-Outlined.svg') ?>">

                    </div>

                    <!-- Header and Sub Title -->
                    <div class="row flex-column align-items-center justify-content-center mb-3 header">
                        <p class="col-auto fs-1 fw-bold text-center mb-0">Forgot Password?</p>
                        <p class="col-auto text-secondary text-center mb-5 w-75" style="font-size: 1rem;">No worries! Just enter your email address and we'll send you a link to reset your password.</p>
                    </div>

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

                        <img class="d-block mx-auto" style="height: 70px;" src="<?php echo home_url('/wp-content/uploads/icons/Hirebilis-630X310-Outlined.svg') ?>">

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

                        <img class="d-block mx-auto" style="height: 70px;" src="<?php echo home_url('/wp-content/uploads/icons/Hirebilis-630X310-Outlined.svg') ?>">

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

        <!-- closing main tag -->
    </div>


<?php
    return ob_get_clean();
}

add_shortcode('home_page', 'home_page_shortcode_function');
