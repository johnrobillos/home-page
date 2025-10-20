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
            plugins_url('/css/styles.css', __FILE__),
            array(),
            filemtime(plugin_dir_path(__FILE__) . '/css/styles.css')
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

        // Bootstrap Icons
        wp_enqueue_style(
            'bootstrap-icons',
            'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css',
            ['bootstrap-css'],
            '1.11.3',
            'all'
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
            'nonce' => wp_create_nonce('login_nonce'), // ← include everything you need
            'recaptchaSiteKey' => RECAPTCHA_SITE_KEY // ✅ Add this!

        ));

        // social icons footer
        wp_enqueue_style(
            'uil-applicant-dsfg',
            "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        );

        // JS enqueue with auto cache-busting
        wp_enqueue_script(
            'home-page-angular',
            plugins_url('js/angular.js', __FILE__), // URL
            array('jquery'),
            filemtime(plugin_dir_path(__FILE__) . 'js/angular.js'),
            true
        );

        // CSS enqueue with auto cache-busting
        wp_enqueue_style(
            'home-page-style',
            plugin_dir_url(__FILE__) . 'css/styles.css',
            array(),
            filemtime(plugin_dir_path(__FILE__) . 'css/styles.css')
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
    <div class="page-wrapper" ng-app="homeApp" ng-controller="homeController" ng-cloak class="angular-cloak">


        <!-- Modified by Lorenzo @ 03/31/2025 -->

        <!-- Modified by Charls @ 04/10/2025-->

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg fixed-top custom-glass-navbar shadow-sm px-3 py-2" ng-class="{'scrolled': navScrolled}">
            <div class="container-fluid">

                <!-- Logo -->
                <a href="/home/" class="navbar-brand fw-bold d-flex align-items-center">
                    <img src="<?php echo home_url('/wp-content/uploads/icons/c2clogo.png') ?>"
                        alt="Logo" style="height: 40px;" class="me-2">
                    <span class="brand-text">Chains<span style="color:#3B9418;">2</span>Chances</span>
                </a>

                <!-- Toggler -->
                <button class="navbar-toggler border-0 shadow-sm" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!-- Centered nav links -->
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0" style="gap: 1.5rem;" ng-cloak ng-show="isInitialized">
                        <li class="nav-item"><a class="nav-link" href="#home" ng-click="setActivePage('home');">Home</a></li>

                        <!-- About -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="aboutDropdown" role="button" data-bs-toggle="dropdown">About</a>
                            <ul class="dropdown-menu glass-dropdown" aria-labelledby="aboutDropdown">
                                <li><a class="dropdown-item" href="#about" ng-click="setActivePage('about'); scrollToSection('about', $event)">About Us</a></li>
                                <li><a class="dropdown-item" class="nav-link" href="#contact" ng-click="setActivePage('contact');">Contact us</a></li>
                            </ul>
                        </li>

                        <!-- Highlights -->
                        <li class="nav-item"><a class="nav-link" href="#highlights" ng-click="setActivePage('highlights'); scrollToSection('highlights', $event)">Highlights</a></li>

                        <!-- Help -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="helpDropdown" role="button" data-bs-toggle="dropdown">Help</a>
                            <ul class="dropdown-menu glass-dropdown" aria-labelledby="helpDropdown">
                                <li><a class="dropdown-item" style="font-size: 1.1rem;" href="#how" ng-click="setActivePage('how'); scrollToSection('how', $event)">How it works</a></li>
                                <li><a class="dropdown-item" href="#faq" ng-click="setActivePage('faq');">FAQ's</a></li>
                            </ul>
                        </li>
                    </ul>

                    <!-- Right buttons -->
                    <ul class="navbar-nav ms-auto align-items-center gap-2 auth-buttons">
                        <li class="nav-item" ng-if="!isLoggedIn">
                            <a class="btn btn-outline-success rounded-pill px-4 w-100" href="javascript:void(0)" ng-click="openLoginModalNav()">Login</a>
                        </li>
                        <li class="nav-item" ng-if="!isLoggedIn">
                            <a class="btn btn-success rounded-pill px-4 w-100" href="javascript:void(0)" ng-click="openLoginModalNavReg(); show_reg_page_1 = true">Sign Up as Employer</a>
                        </li>
                        <li class="nav-item" ng-if="isLoggedIn && dashboardUrl">
                            <a class="btn btn-success rounded-pill px-4 w-100" ng-href="{{dashboardUrl}}">Dashboard</a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>


        <main class="main-content">

            <!-- home section -->
            <section id="home" ng-show="activePage === 'home'" class="c2c-hero" style="padding-top: 10rem;">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-10 col-xxl-9">

                            <!-- Headline -->
                            <h1 class="hero-title">
                                From Chains Today to <span class="accent">Chances</span> Tomorrow
                            </h1>

                            <!-- Subtext -->
                            <p class="hero-sub mt-3">Job matching that is fair, simple, and built for second chances.</p>

                            <!-- Chips -->
                            <div class="pt-4 d-flex justify-content-center">
                                <div chip-marquee items="roles" speed="0.7" class="w-100"></div>
                            </div>

                            <!-- Primary CTA -->
                            <div class="cta-wrap pt-2">
                                <a ng-if="!isLoggedIn"
                                    href="https://c2c-vin.bilishire.com/"
                                    class="cta-link text-white">
                                    Find Opportunities <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- subtle decor (optional) -->
                <span class="decor decor-l"></span>
                <span class="decor decor-r"></span>
            </section>

            <!-- why chains2chances -->
            <section id="whyc2c" ng-show="activePage === 'home' || activePage === 'whyc2c'" class="whyc2c-section py-5 pt-5" style="margin-top: 100px;">
                <div class="whyc2c-content">

                    <!-- Heading -->
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-white mb-2" style="letter-spacing:.3px;">Why Chains2Chances?</h2>
                        <p class="mb-0 text-white">One Job at a time.</p>
                    </div>

                    <!-- Endless carousel (keeps current card design) -->
                    <div class="c2c-infinite" aria-label="Why C2C carousel">
                        <div class="c2c-infinite c2c-fullbleed">
                            <div class="c2c-marquee">
                                <!-- Group A -->
                                <div class="c2c-marquee-group">
                                    <div class="c2c-item" ng-repeat="f in whyC2C track by $index">
                                        <div class="c2c-card-dark h-100">
                                            <div class="icon-box"><i class="bi" ng-class="f.icon"></i></div>
                                            <h5 class="card-title">{{f.title}}</h5>
                                            <p class="card-desc mb-0">{{f.desc}}</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Group B (duplicate for seamless loop) -->
                                <div class="c2c-marquee-group" aria-hidden="true">
                                    <div class="c2c-item" ng-repeat="f in whyC2C track by $index">
                                        <div class="c2c-card-dark h-100">
                                            <div class="icon-box"><i class="bi" ng-class="f.icon"></i></div>
                                            <h5 class="card-title">{{f.title}}</h5>
                                            <p class="card-desc mb-0">{{f.desc}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <!-- HOW IT WORKS (C2C – V2) -->
            <section id="how" ng-show="activePage === 'home' || activePage === 'how'" class="py-5 c2c-hiw-v2" style="margin-top: 50px;">
                <div class="container" style="padding-top: 40px;">

                    <div class="hiw-hero">
                        <!-- <img class="hiw-hero-illus" src="/wp-content/uploads/icons/model6.png" alt="" aria-hidden="true"> -->

                        <div>
                            <!-- Kicker -->
                            <div class="text-center mb-4">
                                <span class="badge rounded-pill px-3 py-2 fw-semibold c2c-hiw-chip">
                                    <i class="bi bi-broadcast me-1"></i> HOW IT WORKS
                                </span>
                            </div>

                            <!-- Big Title -->
                            <h2 class="display-6 fw-bold text-center mb-2 c2c-hiw-title">
                                Start In Four Steps And Land The Right Job
                            </h2>
                            <p class="text-center text-muted mb-5">
                                Simple, verified, and applicant-first from sign up to successful completion.
                            </p>
                        </div>
                    </div>


                    <!-- Steps Row -->
                    <div class="row g-3 g-md-4 align-items-stretch">

                        <!-- Step 1 -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="c2c-hiw-card h-100 position-relative">
                                <div class="c2c-hiw-step fs-4">1</div>
                                <h5 class="fw-semibold mt-2">Create Account</h5>
                                <p class="text-muted small mb-4">Register and complete your profile with your course, skills, certifications, and location.</p>
                                <span class="c2c-hiw-pill">Easy Signup</span>

                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="c2c-hiw-card h-100 position-relative">
                                <div class="c2c-hiw-step fs-4">2</div>
                                <h5 class="fw-semibold mt-2">Choose Opportunities</h5>
                                <p class="text-muted small mb-4">Review matches from verified hosts. Use GeoMatch to see openings near you.</p>
                                <span class="c2c-hiw-pill">Super Fast</span>

                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="c2c-hiw-card h-100 position-relative">
                                <div class="c2c-hiw-step fs-4">3</div>
                                <h5 class="fw-semibold mt-2">Apply & Interview</h5>
                                <p class="text-muted small mb-4">Send applications, chat in-app, and complete interviews online with no hassle.</p>
                                <span class="c2c-hiw-pill">Smooth Flow</span>

                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="c2c-hiw-card h-100 position-relative">
                                <div class="c2c-hiw-step fs-4">4</div>
                                <h5 class="fw-semibold mt-2">Start Your Job</h5>
                                <p class="text-muted small mb-4">Coordinate with your host, track progress, and complete requirements on time.</p>
                                <span class="c2c-hiw-pill">Easy Process</span>

                            </div>
                        </div>

                    </div>

                    <!-- Extra supportive content -->
                    <div class="mt-5">
                        <div class="c2c-hiw-extra upgraded text-center rounded-4">
                            <div class="extra-badge"><i class="bi bi-life-preserver me-1"></i>We’ve got your back</div>
                            <h4 class="fw-bold mb-2">Need Help Along the Way?</h4>
                            <p class="extra-sub mb-3">
                                Chains2Chances isn’t just about matching. We guide you from your profile setup to your first day on the job.
                            </p>

                            <div class="extra-points">
                                <span><i class="bi bi-check2-circle"></i>Have questions?</span>
                                <span><i class="bi bi-check2-circle"></i>Feeling confused?</span>
                                <span><i class="bi bi-check2-circle"></i>Need guidance?</span>
                            </div>

                            <div class="mt-3">
                                <a href="#contact"
                                    class="extra-cta"
                                    ng-click="scrollToSection('contact', $event)"
                                    aria-label="Contact Us">
                                    Contact Us
                                </a>
                            </div>

                        </div>
                    </div>

                </div>
            </section>

            <!-- DPO / NPC Seal -->
            <section id="dpo" class="c2c-dpo py-5" ng-show="activePage === 'home'">
                <div class="container">
                    <div class="row align-items-center g-4">

                        <!-- Left: copy -->
                        <div class="col-lg-7">
                            <div class="dpo-headline">
                                <span class="badge rounded-pill dpo-badge">
                                    <i class="bi bi-shield-lock me-1"></i> Data Privacy & Compliance
                                </span>
                                <h3 class="fw-bold mt-3 mb-2">NPC Seal of Registration</h3>
                                <p class="lead mb-3">
                                    <strong>PCES Inc.</strong> is officially registered with the
                                    <strong>National Privacy Commission</strong>, demonstrating full compliance with the
                                    <em>Data Privacy Act of 2012</em> and related regulations.
                                </p>
                            </div>

                            <ul class="list-unstyled dpo-list mb-0">
                                <li>
                                    <i class="bi bi-check2-circle"></i>
                                    Protecting user data with robust controls and secure practices.
                                </li>
                                <li>
                                    <i class="bi bi-check2-circle"></i>
                                    Transparent handling of personal information across our services.
                                </li>
                                <li>
                                    <i class="bi bi-check2-circle"></i>
                                    Continuous compliance monitoring and staff training.
                                </li>
                            </ul>
                        </div>

                        <!-- Right: seal card -->
                        <div class="col-lg-5">
                            <div class="dpo-card text-center">
                                <div class="dpo-glow"></div>
                                <img
                                    src="<?php echo home_url('/wp-content/uploads/icons/dpo.jpg') ?>"
                                    alt="NPC Seal of Registration"
                                    class="img-fluid dpo-seal"
                                    style="max-width:140px; width:100%;" />

                                <div class="dpo-meta mt-3">
                                    <div class="small text-muted">Status</div>
                                    <div class="fw-semibold">Registered Organization</div>
                                </div>

                                <div class="d-flex justify-content-center gap-2 mt-3">
                                    <span class="chip"><i class="bi bi-shield-check me-1"></i> Compliant</span>
                                    <span class="chip"><i class="bi bi-file-lock2 me-1"></i> Secure</span>
                                    <span class="chip"><i class="bi bi-eye me-1"></i> Transparent</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>


            <!-- about us -->
            <section id="about" ng-show="activePage === 'about' || activePage === 'about'">

                <!-- Hero -->
                <section class="py-5" style="background: white;">
                    <div class="container text-center" style="padding-top: 25px;">
                        <h2 class="fw-bold mb-3 pt-4"
                            style="font-size:clamp(1.8rem,4vw,2.5rem); color: var(--c2c-footer);">
                            About Chains2Chances
                        </h2>
                        <div style="width:80px; height:4px; background: var(--c2c-main); border-radius:2px; margin:0 auto;"></div>
                        <p class="lead mx-auto pt-4" style="max-width: 860px; color:black;">
                            We create second chances by transforming time in detention into pathways to real, dignified jobs. With Chains2Chances, Persons Deprived of
                            Liberty (PDLs) and reintegration partners connect with inclusive employers through simple tools, fair processes, and data-driven matches.
                        </p>

                        <!-- quick stats -->
                        <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
                            <div class="badge rounded-pill px-3 py-2" style="background:#e6f5eb;color:#14532d;border:1px solid #b7e2c5;">Inclusive Hiring</div>
                            <div class="badge rounded-pill px-3 py-2" style="background:#eef2ff;color:#1e3a8a;border:1px solid #dbe3ff;">Skill Visibility</div>
                            <div class="badge rounded-pill px-3 py-2" style="background:#fff7ed;color:#7c2d12;border:1px solid #ffe0c2;">Digital Profiles</div>
                        </div>
                    </div>
                </section>

                <!-- Mission & Vision -->
                <section class="py-5 bg-white">
                    <div class="container">
                        <div class="row g-5 align-items-start">

                            <!-- Mission -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-start text-start">
                                    <!-- Icon -->
                                    <i class="bi bi-bullseye text-success me-3" style="font-size:3rem; flex-shrink:0;"></i>

                                    <!-- Text -->
                                    <div>
                                        <h3 class="fw-bold mb-3" style="color:#3B9418">Our Mission</h3>
                                        <p style="color:#374151; text-align:justify;">
                                            To empower PDLs and returning citizens by providing
                                            <strong>equitable access</strong> to employment.
                                            We partner with communities and employers to
                                            <strong>bridge skills to opportunities</strong>with clarity, dignity, and support.

                                        </p>
                                        <ul class="list-unstyled mt-3">
                                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Equitable Employment Access</li>
                                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Skill-to-Opportunity Matching</li>
                                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Community and Employer Partnerships</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Vision -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-start text-start">
                                    <!-- Icon -->
                                    <i class="bi bi-eye text-success me-3" style="font-size:3rem; flex-shrink:0;"></i>

                                    <!-- Text -->
                                    <div>
                                        <h3 class="fw-bold mb-3" style="color:#3B9418">Our Vision</h3>
                                        <p style="color:#374151; text-align:justify;">
                                            A Philippines where <strong>second chances are standard</strong>, not special.
                                            A nation where employers value <strong>skills over stigma</strong>, and where communities thrive through
                                            <strong>inclusive hiring</strong>.
                                        </p>
                                        <ul class="list-unstyled mt-3">
                                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Normalizing Second Chances</li>
                                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Skills-Focused Employment</li>
                                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Thriving Inclusive Communities</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>


                <!-- Mission & Programs (C2C – nature-style layout) -->
                <div class="py-5" style="background:#ffffff;">
                    <div class="container">

                        <!-- Top banner leaf (optional: replace with your SVG/PNG) -->
                        <div class="d-none d-md-block mb-3">
                            <div class="c2c-leaf-accent"></div>
                        </div>

                        <!-- Big mission headline with CTA on the right -->
                        <div class="row g-4 align-items-center">
                            <div class="col-md-6">
                                <h2 class="fw-bold lh-sm text-start"
                                    style="font-size:clamp(1.8rem,4vw,2.6rem); color:#111; max-width:800px; margin:0 auto;">
                                    Our mission is to create clear pathways that guide PDLs and returning citizens
                                    from <span style="color:#3B9418;">detention</span> to <span style="color:#3B9418;">dignified work</span>.
                                </h2>
                            </div>
                            <div class="col-md-6">
                                <p class="text-start text-muted mb-5" style="max-width:650px;margin:0 auto; line-height:1.7;">
                                    Insights, guides, and real stories to help you grow. Whether it’s building new skills, exploring career opportunities, or learning
                                    from the experiences of others, the C2C Blog is here to inspire, inform, and support you on your journey toward meaningful and lasting employment.
                                </p>
                                <a href="#highlights" ng-click="setActivePage('highlights'); scrollToSection('highlights', $event)" class="btn btn-success d-inline-flex align-items-center"
                                    style="background:#3B9418; border-color:#3B9418;">
                                    Highlights <i class="bi bi-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Secondary headline + paragraph -->
                        <div class="row g-4 align-items-start mt-5">
                            <div class="col-md-6">
                                <h3 class="fw-semibold lh-sm" style="font-size:clamp(1.6rem,3.5vw,2.2rem); color:#111;">
                                    Initiatives and programs promoting inclusive employment.
                                </h3>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-0">
                                    We design practical steps to make hiring fair and simple. These include skill-first profiles,
                                    employer verification, and job-ready training in partnership with communities.
                                </p>
                            </div>
                        </div>

                        <!-- Three feature cards (image-less; icon-focused) -->
                        <div class="row g-4 mt-3">
                            <!-- Card 1 -->
                            <div class="col-md-6 col-lg-4">
                                <div class="c2c-nature-card h-100 d-flex flex-column">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="c2c-card-icon me-2"><i class="bi bi-person-badge"></i></div>
                                        <h5 class="mb-0 fw-semibold">Digital Employment Profiles</h5>
                                    </div>
                                    <p class="text-muted mt-2 mb-3">
                                        Skill-first profiles highlight completed training, verified experience, and strong
                                        references, allowing employers to see ability instead of stigma.
                                    </p>
                                    <!-- <a href="#profiles" class="btn btn-sm btn-outline-success mt-auto align-self-start">
                                    Read more
                                </a> -->
                                </div>
                            </div>

                            <!-- Card 2 -->
                            <div class="col-md-6 col-lg-4">
                                <div class="c2c-nature-card h-100 d-flex flex-column">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="c2c-card-icon me-2"><i class="bi bi-briefcase"></i></div>
                                        <h5 class="mb-0 fw-semibold">Inclusive Employer Network</h5>
                                    </div>
                                    <p class="text-muted mt-2 mb-3">
                                        Employers are pre-screened and commit to fair hiring practices, clear onboarding, and supportive workplaces.
                                    </p>
                                    <!-- <a href="#employers" class="btn btn-sm btn-outline-success mt-auto align-self-start">
                                    Join our mission
                                </a> -->
                                </div>
                            </div>

                            <!-- Card 3 -->
                            <div class="col-md-12 col-lg-4">
                                <div class="c2c-nature-card h-100 d-flex flex-column">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="c2c-card-icon me-2"><i class="bi bi-tools"></i></div>
                                        <h5 class="mb-0 fw-semibold">Job-Ready Training</h5>
                                    </div>
                                    <p class="text-muted mt-2 mb-3">
                                        Targeted training and practical assessments bring out real skills, helping candidates step into work with confidence from day one.
                                    </p>
                                    <!-- <a href="#training" class="btn btn-sm btn-outline-success mt-auto align-self-start">
                                    Read more
                                </a> -->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Story Blocks (simple & elegant) -->
                <div class="py-5 bg-white">
                    <div class="container">

                        <!-- How it started -->
                        <div class="row align-items-center gy-4 mb-5">
                            <div class="col-md-6">
                                <div class="ratio ratio-16x9 rounded-4 shadow-sm overflow-hidden">
                                    <video
                                        class="w-100 h-100"
                                        autoplay
                                        muted
                                        loop
                                        playsinline
                                        preload="metadata">
                                        <source src="<?php echo esc_url(content_url('/uploads/icons/why.mp4')); ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="p-4 p-lg-5 rounded-3 shadow-sm" style="background:#ffffff;border:1px solid rgba(0,0,0,.06);">
                                    <h3 class="fw-bold mb-2" style="color:#262B33;">Why it started</h3>
                                    <p class="mb-0" style="color:#374151; text-align:justify;">
                                        We identified key gaps: limited roles, high costs, and stigma barriers. In collaboration with facilities and LGU partners,
                                        we developed a practical approach: highlight skills, simplify processes, and connect with inclusive employers.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- What we created -->
                        <div class="row align-items-center gy-4">
                            <!-- Text first on desktop -->
                            <div class="col-md-6 order-2 order-md-1">
                                <div class="p-4 p-lg-5 rounded-3 shadow-sm" style="background:#ffffff;border:1px solid rgba(0,0,0,.06);">
                                    <h3 class="fw-bold mb-2" style="color:#262B33;">What we created</h3>
                                    <p class="mb-0" style="color:#374151; text-align:justify;">
                                        A skill-forward platform with digital employment profiles, employer verification, location-aware listings,
                                        and progress tracking. It is designed to reduce cost, save time, and minimize mismatches.
                                    </p>
                                </div>
                            </div>

                            <!-- Image second on desktop -->
                            <div class="col-md-6 order-1 order-md-2">
                                <div class="c2c-slideshow rounded-4 shadow-sm">
                                    <img src="<?php echo home_url('/wp-content/uploads/icons/pdl.jpg') ?>" alt="C2C slide 1" class="slide">
                                    <img src="<?php echo home_url('/wp-content/uploads/icons/pdl2.jpg') ?>" alt="C2C slide 2" class="slide">
                                    <img src="<?php echo home_url('/wp-content/uploads/icons/pdl3.jpg') ?>" alt="C2C slide 3" class="slide">

                                    <!-- bullets -->
                                    <div class="c2c-dots" aria-hidden="true">
                                        <span class="dot"></span>
                                        <span class="dot"></span>
                                        <span class="dot"></span>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <!-- Team -->
                    <section class="py-5">
                        <div class="container">
                            <h2 class="fw-bold text-center mb-5" style="color:#262B33; font-size:2.5rem;">
                                Meet the Leaders of C2C
                            </h2>

                            <div class="row justify-content-center g-5">
                                <!-- CEO -->
                                <div class="col-12 col-md-4">
                                    <div class="c2c-member text-center p-4 h-100">
                                        <div class="c2c-avatar mb-3" style="width:160px; height:160px; margin:0 auto;">
                                            <img src="<?php echo home_url('/wp-content/uploads/icons/home/sirval.png') ?>"
                                                alt="Valery Minello"
                                                style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                                        </div>
                                        <h4 class="fw-bold mb-1">Valery Minello</h4>
                                        <p class="text-muted mb-0" style="font-size:1.1rem;">Chief Executive Officer</p>
                                        <p class="mt-3" style="color:#555; font-size:.95rem; max-width:320px; margin:0 auto;">
                                            Guiding the vision of C2C, ensuring our mission of second chances and inclusive hiring reaches communities nationwide.
                                        </p>
                                    </div>
                                </div>

                                <!-- COO -->
                                <div class="col-12 col-md-4">
                                    <div class="c2c-member text-center p-4 h-100">
                                        <div class="c2c-avatar mb-3" style="width:160px; height:160px; margin:0 auto;">
                                            <img src="<?php echo home_url('/wp-content/uploads/icons/home/leo2.jpg') ?>"
                                                alt="Leo Herrera"
                                                style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                                        </div>
                                        <h4 class="fw-bold mb-1">Leo Herrera</h4>
                                        <p class="text-muted mb-0" style="font-size:1.1rem;">Chief Operating Officer</p>
                                        <p class="mt-3" style="color:#555; font-size:.95rem; max-width:320px; margin:0 auto;">
                                            Driving operations and partnerships, turning our vision into practical systems that connect people with opportunities.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>


            </section>

            <!-- blogs section -->
            <section id="blogs" ng-show="activePage === 'blogs'" class="bg-white py-5">
                <div class="container" style="padding-top: 30px;">

                    <!-- Section Title -->
                    <div class="text-center mb-5">

                        <h2 class="fw-bold mb-3 pt-4"
                            style="font-size:clamp(1.8rem,4vw,2.5rem); color: var(--c2c-footer);">
                            Our Latest Blogs
                        </h2>
                        <div style="width:80px; height:4px; background: var(--c2c-cta); border-radius:2px; margin:0 auto;"></div>
                        <p class="text-muted mt-3" style="max-width:650px; margin:0 auto;">
                            Explore stories, tips, and insights that guide you toward opportunities, growth, and success.
                        </p>
                    </div>

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
                                        {{ getFormattedDate(blog.date) }}
                                    </small>

                                    <!-- Collapsed Quill-rendered preview -->
                                    <div class="card-text mt-2">
                                        <div ng-bind-html="blog.descriptionUnescaped | limitHtmlTo: 150"></div>
                                        <span class="text-success fw-semibold"
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
            <section id="highlights" ng-show="activePage === 'highlights'" class="bg-white" style="padding-top: 100px;">
                <div class="container">

                    <div class="c2c-heading mb-4">
                        <h1 class="c2c-heading__title">
                            Chains2<span style="color: var(--c2c-main);">Chances</span> Highlights
                        </h1>
                        <div class="c2c-heading__rule"></div>
                    </div>


                    <!-- Highlight Filters (C2C – Chip Bar) -->
                    <div class="container">
                        <div class="c2c-chipbar d-flex flex-wrap gap-2 py-2 justify-content-start align-items-center text-start mb-4"
                            role="tablist" aria-label="Highlight filters">

                            <button type="button" class="c2c-chip"
                                ng-class="{'is-active': activeHighlight === 'all'}"
                                ng-click="activeHighlight='all'"
                                ng-attr-aria-pressed="{{activeHighlight==='all'}}">
                                <i class="bi bi-stars me-2" aria-hidden="true"></i>
                                <span>All</span>
                            </button>

                            <button type="button" class="c2c-chip"
                                ng-class="{'is-active': activeHighlight === 'news'}"
                                ng-click="activeHighlight='news'"
                                ng-attr-aria-pressed="{{activeHighlight==='news'}}">
                                <i class="bi bi-megaphone me-2" aria-hidden="true"></i>
                                <span>News</span>
                            </button>

                            <button type="button" class="c2c-chip"
                                ng-class="{'is-active': activeHighlight === 'testimonial'}"
                                ng-click="activeHighlight='testimonial'"
                                ng-attr-aria-pressed="{{activeHighlight==='testimonial'}}">
                                <i class="bi bi-chat-heart me-2" aria-hidden="true"></i>
                                <span>Testimonials</span>
                            </button>

                        </div>
                    </div>

                    <hr class="mx-auto my-4" style="width: 80%; color: #001F3F;">

                    <!-- Highlights Grid -->
                    <div class="row g-3 scrollable-row">

                        <div class="c2c-subtitle fw-semibold mb-4 mt-2 text-center">
                            Get the latest updates, features, and opportunities
                            to boost your job search.
                        </div>

                        <div class="col-md-4 pb-3" ng-show="activeHighlight === 'all'" ng-repeat="post in filteredHighlights " id="post-{{post.id}}">

                            <!-- News -->
                            <div ng-show="post.type === 'news'"
                                class="card news-card-v2 d-flex flex-column"
                                ng-click="modalExpansion(post)"
                                data-bs-toggle="modal" data-bs-target="#blogModal"
                                aria-label="Open news"
                                style="cursor:pointer;">
                                <div class="news-card-v2__body">
                                    <small class="text-muted">{{ getFormattedDate(post.date) }}</small>
                                    <h5 class="card-title my-2">{{ post.title }}</h5>

                                    <div class="card-text mt-2">
                                        <div ng-bind-html="post.description | limitHtmlTo: 150"></div>
                                    </div>

                                    <div class="mt-auto pt-2">
                                        <span class="see-more d-inline-flex align-items-center gap-1 fw-semibold">
                                            See More <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
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
                                    <div class="mb-2 position-relative" style="font-size: 2rem; line-height: 1; color: var(--c2c-main);">
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
                                        <button class="btn btn-sm"
                                            style="color: var(--c2c-main);"
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

                    <!-- Specified post -->
                    <!-- News Section -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4"
                            ng-show="activeHighlight === 'news'"
                            ng-repeat="post in filteredHighlights | orderBy:'-date'">

                            <div class="news-card-v2 d-flex flex-column"
                                ng-click="modalExpansion(post)"
                                data-bs-toggle="modal" data-bs-target="#blogModal"
                                aria-label="Open news"
                                style="cursor:pointer;">

                                <div class="news-card-v2__body">
                                    <!-- Date and Title -->
                                    <small class="text-muted">{{ getFormattedDate(post.date) }}</small>
                                    <h5 class="card-title my-2">{{ post.title }}</h5>

                                    <!-- Collapsed Description -->
                                    <div class="card-text mt-2">
                                        <div ng-bind-html="post.description | limitHtmlTo: 150"></div>
                                    </div>

                                    <!-- See More -->
                                    <div class="mt-auto pt-2">
                                        <span class="see-more d-inline-flex align-items-center gap-1 fw-semibold">
                                            See More
                                            <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
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
                                    <div class="mb-2 position-relative" style="font-size: 2rem; line-height: 1; color: var(--c2c-main);">
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
                                        <button class="btn btn-sm"
                                            style="color: var(--c2c-main);"
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

                </div>
            </section>

            <!-- Unified Modal -->
            <div class="modal fade" id="blogModal" tabindex="-1" aria-labelledby="unifiedModalLabel" aria-hidden="true" data-bs-focus="false">
                <!-- <pre>{{ selectedModal | json }}</pre> -->

                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                    <!-- Show modal content when any post is selected -->
                    <div class="modal-content" ng-show="selectedModal">

                        <!-- Modal Header -->
                        <div class="modal-header d-flex justify-content-between align-items-start flex-column flex-md-row">
                            <h5 class="modal-type" id="unifiedModalLabel">{{ selectedModal.type | capitalize }}</h5>
                            <div class="text-muted small ms-md-auto mt-2 mt-md-0">
                                {{ getFormattedDate(selectedModal.date) }}
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
                                    <div quill-editor ng-model="selectedModal.description"></div>
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
                                <div class="mb-3" style="font-size: 2.5rem; color: var(--c2c-main);">
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

            <!-- FAQ Section -->
            <section id="faq" ng-show="activePage === 'faq'" class="py-5 bg-white">
                <div class="container" style="padding-top: 70px;">

                    <div class="faq-content p-4 rounded shadow" style="background: linear-gradient(to bottom,rgb(255, 255, 255) 0%, #f9f9f9 100%);">

                        <!-- Heading -->
                        <div class="text-center mb-5">
                            <h2 class="fw-bold mb-3"
                                style="font-size:clamp(1.8rem,4vw,2.4rem); color: var(--c2c-footer)">
                                Frequently Asked Questions
                            </h2>
                            <div style="width:80px; height:4px; background: var(--c2c-cta); border-radius:2px; margin:0 auto;"></div>
                            <p class="text-muted pt-4" style="max-width:650px; margin:0 auto; font-size:1rem;">
                                Find quick answers to common concerns from applicants, employers, and partners.
                            </p>
                        </div>


                        <div class="mx-auto" style="max-width: 900px;">
                            <!-- Tabs -->
                            <div class="d-flex justify-content-center gap-3 mb-4">
                                <button class="custom-tab-button" ng-click="faqTab = 'ojtgo'">Chains2Chances</button>
                                <button class="custom-tab-button" ng-click="faqTab = 'student'">Applicant</button>
                                <button class="custom-tab-button" ng-click="faqTab = 'employer'">Employer</button>
                            </div>

                            <!-- FAQ List (Single Container) -->
                            <div class="accordion">
                                <!-- Unified ng-switch style -->
                                <div ng-switch="faqTab">

                                    <!-- Chains2Chances FAQs -->
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

            <!-- ===================== PRIVACY NOTICE (C2C) ===================== -->
            <section id="privacy" ng-show="activePage === 'privacy'" class="privacy py-5">
                <div class="container" style="padding-top: 4rem;">
                    <!-- Hero -->
                    <header class="privacy-hero text-center mb-4">
                        <span class="privacy-chip">
                            <i class="bi bi-shield-lock me-1"></i> Chains2Chances
                        </span>
                        <h1 class="display-6 fw-bold mt-3 mb-0">Privacy Notice</h1>
                        <small class="text-muted opacity-75">Effective Date: <strong>30 May 2024</strong></small>
                    </header>

                    <!-- Body card -->
                    <div class="privacy-card">
                        <p>
                            <strong>Chains2Chances</strong> (the “Platform”), owned and operated by <strong>PCES Inc.</strong> (“we,” “us,” “our”),
                            is committed to protecting your privacy. This Privacy Notice explains how we collect, use, disclose, retain, and safeguard
                            your information in accordance with the
                            <a href="https://privacy.gov.ph/data-privacy-act/" target="_blank" rel="noopener">
                                Data Privacy Act of 2012 (RA 10173)
                            </a>
                            and National Privacy Commission (NPC) issuances. By using the Platform, you agree to the practices described here.
                        </p>

                        <!-- Section -->
                        <h4 class="privacy-h" style="color: #3B9418;">1) What We Collect</h4>
                        <p><strong>a) Applicant Information</strong></p>
                        <ul class="privacy-list">
                            <li>Identity &amp; contact: name, birthdate, email, mobile number, address</li>
                            <li>Profile: education, course/major, skills, availability, preferences</li>
                            <li>Employment history: job titles, companies, dates, duties, company contact</li>
                            <li>Credentials you provide (e.g., driver’s license status) and attachments you upload</li>
                        </ul>

                        <p><strong>b) Character References</strong> — names, roles, and contact details you submit.
                            You confirm you have obtained their consent before sharing their data.</p>

                        <p><strong>c) Employer/Entity Information</strong> — company name, industry, contact details, authorized representative,
                            business documents, and job post details.</p>

                        <p><strong>d) Non-Personal/Usage Data</strong> — device/browser info, IP address, pages viewed, referrers, and feature usage
                            to improve performance and experience.</p>

                        <h4 class="privacy-h" style="color: #3B9418;">2) Why We Process Your Data</h4>
                        <ul class="privacy-list">
                            <li><strong>Job matching &amp; applications</strong> — to match applicants with roles and enable employers to evaluate candidates.</li>
                            <li><strong>Platform operations</strong> — account creation, verification, login, OTP, notifications, and messaging.</li>
                            <li><strong>Analytics &amp; improvements</strong> — to understand usage and enhance features and reliability.</li>
                            <li><strong>Support &amp; safety</strong> — to respond to requests, prevent fraud/abuse, and enforce terms.</li>
                            <li><strong>Legal compliance</strong> — to comply with laws, subpoenas, and lawful orders.</li>
                            <li><strong>Optional communications</strong> — announcements or promos (only with your consent; you may opt out).</li>
                        </ul>
                        <p class="privacy-note"><em>Lawful bases:</em> consent, contract performance, legitimate interests (e.g., service improvement, security),
                            and legal obligations.</p>

                        <h4 class="privacy-h" style="color: #3B9418;">3) Sharing &amp; Disclosures</h4>
                        <ul class="privacy-list">
                            <li><strong>Employers/Coordinators</strong> — when you apply or express interest, relevant profile data is shared so they can evaluate your application.</li>
                            <li><strong>Service providers</strong> — hosting, storage, analytics, messaging, and support under confidentiality and data protection agreements.</li>
                            <li><strong>Authorities</strong> — if required by law, regulation, or court order.</li>
                        </ul>
                        <p class="mb-4">We do <strong>not</strong> sell or lease your personal data.</p>

                        <h4 class="privacy-h" style="color: #3B9418;">4) Security</h4>
                        <ul class="privacy-list">
                            <li>Transport-layer encryption (HTTPS) and access controls for authorized staff only</li>
                            <li>Regular reviews and vulnerability mitigation</li>
                        </ul>
                        <p class="privacy-note"><em>Note:</em> No system is 100% secure, but we continuously improve our safeguards.</p>

                        <h4 class="privacy-h" style="color: #3B9418;">5) Cookies &amp; Location</h4>
                        <ul class="privacy-list">
                            <li>Cookies help personalize content, remember preferences, and analyze usage.</li>
                            <li>With consent, we may use location to suggest nearby opportunities. You can disable cookies/location in your device or browser settings.</li>
                        </ul>

                        <h4 class="privacy-h" style="color: #3B9418;">6) Your Choices &amp; Rights</h4>
                        <ul class="privacy-list">
                            <li>Update your profile and settings in your account</li>
                            <li>Manage email and notification preferences (service emails may still be sent)</li>
                            <li>Request access, correction, deletion, or restriction of your data</li>
                            <li>Object to processing not based on overriding legitimate grounds</li>
                            <li>Withdraw consent at any time (processing before withdrawal remains lawful)</li>
                            <li>Lodge a complaint with the
                                <a href="https://privacy.gov.ph/data-subject-rights/" target="_blank" rel="noopener">National Privacy Commission</a>
                            </li>
                        </ul>

                        <h4 class="privacy-h" style="color: #3B9418;">7) Retention</h4>
                        <p><strong>Default (Chains2Chances):</strong> We retain personal data only as needed to deliver services and for a maximum of <strong>1 year</strong> after account deactivation or final activity, unless a longer period is required by law or to establish, exercise, or defend legal claims.</p>
                        <ul class="privacy-list">
                            <li>Applicant data: active use + up to 1 year after deactivation/inactivity</li>
                            <li>Employer data &amp; job posts: up to 1 year after account deletion</li>
                            <li>DTR/reports (if applicable): up to 1 year after job completion/account deletion</li>
                        </ul>
                        <p><strong>BJMP/Institution-linked programs (if you are participating):</strong> certain records may be retained for up to <strong>5 years</strong> (or as required by institutional policy, audits, or law). We apply data minimization, encryption at rest (where applicable), and strict access controls.</p>

                        <h4 class="privacy-h" style="color: #3B9418;">8) International Use</h4>
                        <p>If you access the Platform from outside the Philippines, you consent to the cross-border transfer and processing of your data in the Philippines in line with this Notice.</p>

                        <h4 class="privacy-h" style="color: #3B9418;">9) Minors</h4>
                        <p>The Platform is not intended for children under 18 without appropriate consent and supervision. If we learn we’ve collected data from a minor without proper authority, we will take steps to delete it.</p>

                        <h4 class="privacy-h" style="color: #3B9418;">10) Changes to This Notice</h4>
                        <p>We may update this Notice due to changes in law, technology, or our services. The latest version will be posted here with an updated “Effective Date.” Continued use of the Platform constitutes acceptance of the updated terms.</p>

                        <h4 class="privacy-h" style="color: #3B9418;">11) Contact</h4>
                        <p>For privacy questions, requests, or complaints, contact our Data Protection Officer (DPO):</p>
                        <ul class="privacy-list">
                            <li><strong>Email:</strong> <a href="mailto:dpo@pces.com.ph">dpo@pces.com.ph</a></li>
                        </ul>
                    </div>
                </div>
            </section>


            <!-- ===================== TERMS OF USE (C2C, same style as Privacy) ===================== -->
            <section id="terms" ng-show="activePage === 'terms'" class="privacy py-5">
                <div class="container" style="padding-top: 4rem;">

                    <!-- Hero (reuses Privacy hero styles) -->
                    <header class="privacy-hero text-center mb-4">
                        <span class="privacy-chip">
                            <i class="bi bi-file-text me-1"></i> Chains2Chances
                        </span>
                        <h1 class="display-6 fw-bold mt-3 mb-0">Terms of Use</h1>
                        <small class="text-muted opacity-75">Please read carefully before using the Platform</small>
                    </header>

                    <!-- Single glass card body (same component as Privacy) -->
                    <div class="privacy-card">
                        <!-- Employer -->
                        <h4 class="privacy-h" style="color: #3B9418;">Employer</h4>
                        <ol class="privacy-ol">
                            <li><strong>Account Creation and Registration</strong><br>
                                Employers must register for an account and provide accurate and up-to-date information to access and use the Website’s services.
                                You are responsible for keeping your account credentials, including your username and password, confidential. Notify us immediately
                                if you suspect unauthorized access or use of your account.
                            </li>
                            <li><strong>Job Postings and Content</strong><br>
                                By posting job openings, you confirm that all submitted content is accurate, complete, and lawful. You are solely responsible
                                for the content of your job postings and any resulting outcomes. Do not post illegal, defamatory, offensive, or inappropriate content.
                                We reserve the right to remove or modify any content that violates these Terms or our content guidelines.
                            </li>
                            <li><strong>Candidate Selection and Communication</strong><br>
                                You are solely responsible for selecting and hiring candidates. We do not guarantee any applicant’s qualifications, suitability, or performance.
                                All interactions, negotiations, and hiring decisions between you and the applicant are entirely your responsibility. Chains2Chances has no role in employment arrangements.
                            </li>
                            <li><strong>Intellectual Property</strong><br>
                                The Website and all its content—including text, graphics, logos, and software—are protected by intellectual property rights owned by us or our licensors.
                                You may not reproduce, modify, distribute, or use any part of the Website without explicit permission.
                            </li>
                            <li><strong>Limitation of Liability</strong><br>
                                You agree to use the Website at your own risk. We are not liable for any direct, indirect, incidental, consequential, or punitive damages resulting from your use of the Website
                                or any errors in the content provided.
                            </li>
                            <li><strong>Indemnification</strong><br>
                                You agree to indemnify and hold Chains2Chances harmless from any claims, losses, damages, or expenses arising from your use of the Website, violation of these Terms,
                                or breach of any applicable laws.
                            </li>
                            <li><strong>Modification of Terms</strong><br>
                                We reserve the right to update these Terms at any time without prior notice. Changes will take effect immediately upon being posted.
                                Continued use of the Website indicates your acceptance of the updated Terms.
                            </li>
                            <li><strong>Termination</strong><br>
                                If you violate these Terms or engage in fraudulent, abusive, or unlawful behavior, we may suspend or terminate your access to the Website.
                            </li>
                            <li><strong>Severability</strong><br>
                                If any provision of these Terms is deemed invalid or unenforceable, the remaining provisions will remain in full force and effect.
                            </li>
                            <li><strong>Entire Agreement</strong><br>
                                These Terms constitute the entire agreement between you and Chains2Chances regarding your use of the Website as an employer, superseding any prior agreements or understandings.
                            </li>
                        </ol>

                        <!-- Applicant -->
                        <h4 class="privacy-h" style="color: #3B9418;">Applicant</h4>
                        <ol class="privacy-ol">
                            <li><strong>Account Creation and Registration</strong><br>
                                Applicants must register for an account and provide accurate, complete, and current information. You are responsible for maintaining the confidentiality
                                of your account credentials. Report any unauthorized use of your account immediately.
                            </li>
                            <li><strong>Application and Job Conduct</strong><br>
                                You affirm that all information in your application is truthful and complete. You are solely responsible for ensuring your job complies with your academic requirements.
                                Misrepresentation, misconduct, or unprofessional behavior may result in suspension or termination of your account.
                            </li>
                            <li><strong>Matching and Placement</strong><br>
                                Chains2Chances facilitates connections but does not guarantee placement. Job selection and approval are determined solely by host companies.
                                We are not responsible for any outcomes, including mismatches or rejections.
                            </li>
                            <li><strong>Data Use and Communication</strong><br>
                                You consent to the collection and use of your personal data for job matching, communication with HTEs and coordinators, and academic monitoring.
                                System notifications and optional promotional messages may be sent to you, which can be managed via your account settings.
                            </li>
                            <li><strong>Intellectual Property</strong><br>
                                All materials you upload (e.g., resumes, cover letters) remain your intellectual property. By submitting them, you grant Chains2Chances a limited,
                                non-exclusive license to use them solely for applicants facilitation.
                            </li>
                            <li><strong>Limitation of Liability</strong><br>
                                Chains2Chances is not liable for any direct, indirect, incidental, consequential, or punitive damages arising from your use of the Website
                                or any interaction with employers or coordinators.
                            </li>
                            <li><strong>Indemnification</strong><br>
                                You agree to indemnify and hold harmless Chains2Chances from any claims, damages, or expenses resulting from your use of the Website or any breach of these Terms.
                            </li>
                            <li><strong>Modification of Terms</strong><br>
                                These Terms may be modified at any time without prior notice. Continued use of the Website after updates indicates your acceptance of the revised Terms.
                            </li>
                            <li><strong>Termination</strong><br>
                                We reserve the right to suspend or terminate your account if you violate these Terms or engage in inappropriate conduct.
                            </li>
                            <li><strong>Severability</strong><br>
                                If any term is deemed invalid or unenforceable, the remainder shall continue to apply in full effect.
                            </li>
                            <li><strong>Entire Agreement</strong><br>
                                These Terms represent the entire agreement between you and Chains2Chances regarding your use of the Website as an applicant.
                            </li>
                        </ol>

                        <!-- BJMP (Updated) -->
                        <h4 class="privacy-h" style="color: #3B9418;">BJMP (Updated)</h4>
                        <ol class="privacy-ol">
                            <li><strong>Account Creation and Registration</strong><br>
                                <em>Eligibility:</em> BJMP users, including officers, administrators, and any authorized personnel, must create an account to access and use the platform. The information
                                provided during registration must be accurate, complete, and current. You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account.<br>
                                <em>Restricted Access:</em> Access to specific data or functionalities within the platform may be restricted based on your role within the BJMP. Unauthorized access to areas beyond your granted permissions is prohibited and may result in the suspension or termination of your account.
                            </li>
                            <li><strong>Data Handling and Privacy</strong><br>
                                <em>Sensitive Information:</em> BJMP is responsible for handling sensitive information related to Persons Deprived of Liberty (PDL). All users must adhere to the strictest standards of data protection and confidentiality as outlined in the Privacy Notice and applicable laws. Any unauthorized disclosure, misuse, or breach of this information will result in disciplinary action, including possible legal consequences.<br>
                                <em>Data Accuracy:</em> It is the responsibility of BJMP personnel to ensure that all data entered into the platform is accurate and up-to-date. Inaccuracies or omissions can affect the welfare and legal standing of PDLs and must be avoided.
                            </li>
                            <li><strong>Information Sharing and Communication</strong><br>
                                <em>Inter-agency Collaboration:</em> When necessary, BJMP may share information with other government agencies or authorized entities to facilitate legal processes, rehabilitation programs, or other official duties. All information sharing must be conducted in compliance with applicable data protection laws and BJMP policies.<br>
                                <em>Internal Communication:</em> Communication within the platform should be conducted professionally and strictly for official purposes. Any misuse of the communication tools, including sending inappropriate or irrelevant messages, is prohibited.
                            </li>
                            <li><strong>System Use and Compliance</strong><br>
                                <em>Platform Integrity:</em> Users are prohibited from engaging in activities that could compromise the integrity, security, or functionality of the platform. This includes, but is not limited to, introducing viruses, hacking, or attempting to gain unauthorized access to restricted areas of the platform.<br>
                                <em>Compliance with BJMP Policies:</em> All actions performed on the platform must comply with BJMP’s internal policies, as well as local laws and regulations. Failure to adhere to these requirements may result in disciplinary measures, including suspension or termination of access to the platform.
                            </li>
                            <li><strong>Intellectual Property</strong><br>
                                <em>Platform Content:</em> All content, materials, and data accessible through the platform are the property of PCES Inc. and/or its licensors, unless otherwise stated. BJMP personnel may use these materials solely for official duties. Unauthorized reproduction, modification, or distribution of any content is strictly prohibited.
                            </li>
                            <li><strong>Limitation of Liability</strong><br>
                                <em>Operational Risks:</em> BJMP personnel use the platform at their own risk. PCES Inc. is not liable for any direct, indirect, incidental, or consequential damages resulting from the use of the platform, including any errors or omissions in the content or data.<br>
                                <em>Legal Compliance:</em> BJMP and its personnel are solely responsible for ensuring that their use of the platform complies with all applicable laws and regulations. PCES Inc. is not liable for any legal issues arising from non-compliance.
                            </li>
                            <li><strong>Indemnification</strong><br>
                                <em>Responsibility:</em> BJMP personnel agree to indemnify and hold harmless PCES Inc. and its affiliates from any claims, damages, or liabilities arising from the misuse of the platform, violation of these Terms, or any breach of applicable laws or regulations.
                            </li>
                            <li><strong>Termination and Suspension</strong><br>
                                <em>Access Control:</em> PCES Inc. reserves the right to suspend or terminate the access of any BJMP user who violates these Terms or engages in activities that threaten the platform’s security, integrity, or functionality.<br>
                                <em>BJMP Authority:</em> BJMP also reserves the right to revoke platform access for any user who fails to adhere to internal policies or who is no longer authorized to use the platform.
                            </li>
                            <li><strong>Modification of Terms</strong><br>
                                <em>Updates and Changes:</em> These Terms may be updated or modified by PCES Inc. at any time to reflect changes in legal requirements, BJMP policies, or platform functionalities. All BJMP users will be notified of significant changes, and continued use of the platform constitutes acceptance of the revised Terms.
                            </li>
                            <li><strong>Governing Law and Jurisdiction</strong><br>
                                <em>Legal Framework:</em> These Terms are governed by the laws of the Republic of the Philippines and must be interpreted in accordance with these laws. Any disputes arising from or related to these Terms will be resolved under the exclusive jurisdiction of the courts of the Republic of the Philippines.
                            </li>
                            <li><strong>Entire Agreement</strong><br>
                                <em>Full Agreement:</em> These Terms, together with any additional agreements or policies applicable to BJMP’s use of the platform, constitute the entire agreement between BJMP and PCES Inc. regarding the use of the platform and supersede any prior agreements or understandings.
                            </li>
                        </ol>
                    </div>
                </div>
            </section>


            <!-- contact us -->
            <section id="contact"
                ng-show="activePage === 'contact'"
                style="background: vwhite; padding-top: 10rem;">


                <div class="container">
                    <div class="row g-4 align-items-stretch">

                        <!-- Left: CTA / Info -->
                        <div class="col-lg-5">
                            <div class="h-100 p-4 p-md-5 rounded-3 shadow-sm d-flex flex-column justify-content-between"
                                style="background:#ffffff;  border:1px solid rgba(0, 0, 0, 0.42)">
                                <div>
                                    <h2 class="fw-bold mb-2" style="color:#262B33;">Get in touch</h2>
                                    <p class="mb-4 text-muted">Questions, partnerships, or support? We'll reply within 1–2 business days.</p>

                                    <ul class="list-unstyled mb-4">
                                        <li class="d-flex align-items-center mb-2">
                                            <i class="bi bi-envelope-fill me-2" style="color:#3B9418"></i>
                                            <span>support@chains2chances.com</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Optional toggle (kept for your existing logic) -->
                                <button class="btn text-white fw-semibold"
                                    ng-click="showContactForm = !showContactForm"
                                    style="background:#3B9418;border:0">
                                    <span ng-hide="showContactForm">Send us a message</span>
                                    <span ng-show="showContactForm">Back</span>
                                </button>
                            </div>
                        </div>

                        <!-- Right: Contact Form -->
                        <div class="col-lg-7" ng-show="showContactForm">
                            <div class="h-100 p-4 p-md-5 rounded-3 shadow-sm" style="background:#ffffff;border:1px solid rgba(0,0,0,.06)">
                                <h4 class="fw-bold mb-3" style="color:#262B33">Message the C2C Team</h4>

                                <form name="contactForm" ng-submit="submitContactForm()" novalidate>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Full Name</label>
                                        <input type="text" class="form-control" ng-model="contactFormData.name" placeholder="e.g., Juan Dela Cruz" required
                                            style="border:1px solid rgba(0,0,0,.15)">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">Email</label>
                                            <input type="email" class="form-control" ng-model="contactFormData.email" placeholder="you@example.com" required
                                                style="border:1px solid rgba(0,0,0,.15)">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold" for="mobile">Mobile (optional)</label>
                                            <input
                                                id="mobile"
                                                name="mobile"
                                                type="tel"
                                                class="form-control"
                                                ng-model="contactFormData.mobile"
                                                placeholder="+63 9xx xxx xxxx"
                                                inputmode="tel"
                                                ng-trim="true"
                                                ng-pattern="/^(?:\s*$|(?:\+63|0)\s*9\d{2}\s*\d{3}\s*\d{4})$/"
                                                style="border:1px solid rgba(0,0,0,.15)">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">How can we help?</label>
                                        <textarea class="form-control" ng-model="contactFormData.message" rows="4" placeholder="Type your message…" required
                                            style="border:1px solid rgba(0,0,0,.15)"></textarea>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="consent" ng-model="contactFormData.consent" required>
                                        <label class="form-check-label text-muted" for="consent" style="font-size:.9rem">
                                            I agree that C2C may use this information to contact me about my inquiry.
                                        </label>
                                    </div>

                                    <div class="d-grid d-sm-flex gap-2">
                                        <button type="submit" ng-disabled="onsubmit || !contactFormData.consent" class="btn text-white fw-semibold px-4"
                                            style="background:#3B9418;border:0">
                                            <span ng-hide="onsubmit">Submit</span>
                                            <span ng-show="onsubmit"><i class="bi bi-arrow-repeat me-1"></i>Sending…</span>
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary px-4" ng-click="contactFormData = {}">Clear</button>
                                    </div>

                                    <p class="mt-3 text-muted" style="font-size:.85rem">
                                        We respect your privacy. We don't sell your data and only use it to respond to your request.
                                    </p>
                                </form>
                            </div>
                        </div>

                        <!-- If the form is hidden, show a simple brand panel instead -->
                        <div class="col-lg-7" ng-hide="showContactForm">
                            <div class="h-100 p-4 p-md-5 rounded-3 border d-flex align-items-center justify-content-center"
                                style="background:linear-gradient(180deg, #75ad5fff 0%, #b1d8a0ff 50.6%, #f2fff2ff 100%);">
                                <div class="text-center">
                                    <img src="/wp-content/uploads/icons/c2clogo.png" class="img-fluid mb-3" alt="C2C" style="max-width:160px">
                                    <div class="text-muted">Employers • PDL Support • Partnerships</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

        </main>

        <!-- Footer -->
        <footer class="footer-container custom-footer">
            <div class="container text-center">

                <!-- Logo -->
                <div class="footer-logo-wrap mb-3 d-flex justify-content-center">
                    <img style="height: 70px;"
                        src="<?php echo home_url('/wp-content/uploads/icons/c2cwhite.png') ?>"
                        alt="c2c-logo"
                        class="footer-logo">
                </div>

                <!-- Navigation Links -->
                <nav class="footer-nav d-flex flex-column flex-lg-row justify-content-center align-items-center gap-3 mb-3">
                    <a class="footer-link" href="#whyc2c" ng-click="setActivePage('whyc2c'); scrollToSection('whyc2c', $event)">Why Chains2Chances?</a>
                    <a class="footer-link" href="#privacy" ng-click="setActivePage('privacy')">Privacy Policy</a>
                    <a class="footer-link" href="#terms" ng-click="setActivePage('terms')">Terms of Use</a>
                </nav>

                <!-- Social Icons -->
                <div class="social-icons d-flex justify-content-center gap-3 mt-3">
                    <a href="https://www.facebook.com/PCESInc1" target="_blank" class="social-circle">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com/pces_inc" target="_blank" class="social-circle">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.tiktok.com/@pces_incorporated" target="_blank" class="social-circle">
                        <i class="fab fa-tiktok"></i>
                    </a>
                </div>
            </div>
        </footer>

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

                        <img class="d-block mx-auto" style="height: 160px;" src="<?php echo home_url('/wp-content/uploads/icons/c2clogo.png') ?>">

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

                    <span class="col-12 text-center" style="font-size: 0.875rem;">Don't have an employer account?</span>
                    <p class="col-12 mb-0 text-center" style="font-size: 0.875rem;">
                        Why not
                        <a
                            href="javascript:void(0)"
                            class="link-text"
                            style="font-size: 0.875rem;"
                            ng-click="setUserType('employer');">
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

                        <img class="d-block mx-auto" style="height: 160px;" src="<?php echo home_url('/wp-content/uploads/icons/c2clogo.png') ?>">

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

                        <img class="d-block mx-auto img-fluid" style="height: 100px;"
                            src="<?php echo home_url('/wp-content/uploads/icons/c2clogo.png') ?>">

                    </div>

                    <!-- Header and Sub Title -->
                    <div class="row flex-column align-items-center justify-content-center mb-3 header">
                        <p class="col-auto fs-2 fw-bold text-center mb-0">Welcome!</p>
                        <p class="col-auto text-secondary text-center mb-0 w-100" style="font-size: 1rem;">We are glad to have you!</p>
                    </div>


                    <!-- Input Fields w/o password-->
                    <div class="d-flex gap-0 gap-md-3 flex-column justify-content-between">

                        <!-- Username -->
                        <div class="px-2 px-md-0">
                            <div class="row g-3 align-items-center justify-content-center justify-content-md-center">
                                <div class="col-12 col-md-5 text-center text-md-start">
                                    <label class="form-label mb-0 mb-md-2">Username: </label>
                                </div>
                                <div class="col-12 col-md-7 mt-1 pe-md-1 align-self-start custom-width">
                                    <input
                                        type="text"
                                        class="form-control mx-0 reg-field"
                                        ng-class="{'highlight is-invalid': !usernameValid}"
                                        placeholder="john_doe"
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
                        <div class="px-2 px-md-0">
                            <div class="row g-3 align-items-center justify-content-center">
                                <div class="col-12 col-md-5 text-center text-md-start">
                                    <label class="form-label mb-0 mb-md-2">Email: </label>
                                </div>
                                <div class="col-12 col-md-7 mt-1 pe-md-1 align-self-start custom-width">
                                    <input
                                        type="email"
                                        class="form-control mx-0 reg-field"
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
                        <div
                            class="row g-3 align-items-center justify-content-center"
                            style="max-width: 318px;">
                            <div class="col-12 col-md-5 text-center text-md-start">
                                <label class="col-form-label mb-0 mb-md-2 pb-0 pb-md-2">Password: </label>
                            </div>
                            <div class="col-12 col-md-7 px-1 px-md-0 ps-md-2 mt-0">
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
                    </div>

                    <div class="rounded text-start mt-2 p-2 condition">
                        <p class="col-auto text-secondary text-center mb-0 w-100" style="font-size: 0.7rem;">
                            By clicking Create Account, you agree to our
                            <a href="/home/#terms" target="_blank" rel="nofollow">Terms of Use</a> and
                            <a href="/home/#privacy" target="_blank" rel="nofollow">Privacy Notice</a>.
                            You may receive email notifications from us, and you can opt out at any time.
                        </p>
                    </div>

                    <div class="mt-0 mt-md-2 d-flex flex-column justify-content-between align-items-center container-fluid">

                        <!-- register Button -->
                        <a
                            id="create-acc-btn"
                            href="javascript:void(0)"
                            class="col text-center my-4 px-5 py-2 modal-btn register-btn"
                            ng-click="storeCredentials();"
                            ng-class="{'disabled': isFormInvalid() && !passwordValid && !usernameValid}">
                            Create Account
                        </a>

                    </div>





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

                        <img class="d-block mx-auto" style="height: 160px;" src="<?php echo home_url('/wp-content/uploads/icons/c2clogo.png') ?>">

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

                        <img class="d-block mx-auto" style="height: 160px;" src="<?php echo home_url('/wp-content/uploads/icons/c2clogo.png') ?>">

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

                        <img class="d-block mx-auto" style="height: 160px;" src="<?php echo home_url('/wp-content/uploads/icons/c2clogo.png') ?>">

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

                        <img class="d-block mx-auto" style="height: 160px;" src="<?php echo home_url('/wp-content/uploads/icons/c2clogo.png') ?>">

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
