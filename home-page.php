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





        // custom jQuery
        wp_enqueue_script(
            'home-page-script',
            plugin_dir_url(__FILE__) . '/js/home-page.js',
            array('jquery'),
            '1.0',
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

        // Enqueue ngStorage AFTER AngularJS
        wp_enqueue_script(
            'ngStorage',
            'https://cdnjs.cloudflare.com/ajax/libs/ngStorage/0.3.11/ngStorage.min.js',
            array('angular-js'), // Ensure AngularJS is loaded first
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


        // Enqueue OJT Registration Form Script (Angular-based AJAX)
        wp_enqueue_script(
            'ojt-fym-form-js',
            plugin_dir_url(__FILE__) . 'js/ojt-fym-form.js',
            array('angular-js', 'jquery'),
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
    <div class="pt-3 mt-5 px-0 mx-0" ng-app="angularApp" ng-controller="angular_controller" ng-cloak class="angular-cloak">


        <!-- Modified by Lorenzo @ 03/31/2025 -->

        <!-- Modified by Charls -->

        <!-- navbar -->
        <nav class="navbar navbar-expand-lg fixed-top bg-body-tertiary border border-lg-0">
            <div class="container-fluid">
                <a class="navbar-brand" href="#" ng-click="setActivePage('home')">
                    <img src="<?php echo home_url('/wp-content/uploads/icons/OJTGO-630X310.png') ?>" alt="Logo" style="height: 50px;" class="d-inline-block align-text-center">
                </a>

                <a href="javascript:void(0)" class="navbar-toggler border border-muted bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </a>

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
                                <li>
                                    <a class="dropdown-item" href="#about" ng-click="setActivePage('about'); scrollToSection('about', $event)">About Us</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#news" ng-click="setActivePage('news'); scrollToSection('news', $event)">News</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Legal Dropdown -->
                        <li class="nav-item dropdown w-100 text-start">
                            <a class="nav-link dropdown-toggle w-100 text-start" id="policyDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Policy
                            </a>
                            <ul class="dropdown-menu w-100" aria-labelledby="policyDropdown" style="border: none;">
                                <li>
                                    <a class="dropdown-item" href="#privacy" ng-click="setActivePage('privacy')">Privacy Notice</a>
                                </li>
                                <li><a class="dropdown-item" href="#terms" ng-click="setActivePage('terms')">Terms of use</a></li>
                            </ul>
                        </li>

                        <!-- Contact navbar -->
                        <li class="nav-item mb-3 mb-lg-0 me-lg-3">
                            <a class="nav-link" href="#contact" ng-click="scrollToSection('contact', $event)" style="white-space: nowrap;">
                                Contact Us
                            </a>
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


        <!-- Home section test -->
        <section id="home" ng-show="activePage === 'home'">
            <div class="row justify-content-between flex-grow-1">
                <div class="row justify-content-between align-items-center col-xl-10 col-xxl-8 mx-auto">

                    <!-- Greeter -->
                    <div class="col-md-7 col-xxl-6" id="page-top" style="margin-top: 100px;">
                        <div class="h-100 d-flex flex-column justify-content-between">
                            <img src="/wp-content/uploads/2025/03/OJTGO-630X310.png" alt="Logo" class="img-fluid mb-3">
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

                    <!-- No Resume Required -->
                    <div class="col-12 col-md-6 mb-4">
                        <div class="h-100 shadow rounded-2 border-muted p-3 bg-light d-flex flex-column">
                            <div id="virtual" style="height: 200px;"></div>
                            <div class="text-center mt-auto">
                                <h2 class="fw-bold">No Resume Required</h2>
                                <p>Students can showcase their skills and qualifications directly through the OJTGo system—eliminating the need for traditional resumes and simplifying the application process for both students and employers.</p>
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
                        <img src="https://vin.ojtgo.com/wp-content/uploads/2025/05/dpo.jpg" alt="DPO Logo" class="img-fluid" style="max-width: 200px;">
                    </div>
                </div>
            </div>
        </section>

        <!-- Privacy Notice Section -->
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

                        <li><strong>PCES Inc.</strong> Level 10-01, One Global Place, 25th St. corner 5th Ave., Bonifacio Global City, Brgy. Fort Bonifacio, Taguig City 1630</li>
                        <li><strong>Email:</strong> <a href="mailto:ojt@ojtgo.com" style="color: deepskyblue;">ojt@ojtgo.com</a></li>
                        <li><strong>Phone:</strong> (02) 8628-2072</li>
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
            <div class="blue-circle-lower-right"></div>
        </div>

        <!-- About Us Section -->
        <section id="about" ng-show="activePage === 'about'">
            <section class="bg-light text-center pt-5 pb-2">
                <div class="container">
                    <h1 class="display-4 text-white fw-semibold fs-3 text-center p-3 rounded" style="background-color:rgb(0, 43, 86);">
                        About Us
                    </h1>
                    <p class="lead mt-3">At <strong>OJTGo</strong>, we bridge the gap between education and industry, providing students with seamless access to valuable internship opportunities.
                        Our platform empowers students by connecting them with organizations that align with their academic backgrounds, career goals, and personal growth.
                        We believe internships are more than just academic requirements—they are stepping stones to meaningful careers.</p>
                </div>
            </section>

            <!-- Mission and Vision Section -->
            <section class="bg-light pt-2 pb-4">
                <div class="container text-left">
                    <div class="mb-5">
                        <h2 class="text-primary">Our Mission</h2>
                        <p class="lead mt-3">To empower students by providing them with seamless access to valuable internship opportunities,
                            equipping them with the skills and experience needed to succeed in the professional world. We aim to connect
                            educational institutions, students, and employers in a collaborative environment that fosters growth, learning, and career readiness.
                        </p>
                    </div>
                    <div>
                        <h2 class="text-primary">Our Vision</h2>
                        <p class="lead mt-3">To be the leading digital platform for internships in the Philippines, ensuring every student gains practical
                            experience that enhances their future career prospects. We strive to create a workforce-ready generation by
                            bridging academia and industry through innovative and inclusive job matching technology.
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
                                <img src="https://vin.ojtgo.com/wp-content/uploads/2025/05/ojtgo.png"
                                    alt="introduce"
                                    class="img-fluid rounded shadow-lg"
                                    style="max-width: 90%; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);">
                            </div>

                            <!-- Text -->
                            <div class="col-md-6 order-2 order-md-2">
                                <h2 class="text-primary">Introducing OJTGo</h2>
                                <p>A platform built by students, for students. OJTGo aims to simplify the internship journey by connecting students, OJT coordinators, and host companies (HTEs) in one convenient, organized space. We designed it to reduce unnecessary costs, streamline the application process, and minimize mismatches between students and companies. With OJTGo, students can find internships that suit their course and location, while coordinators and companies can manage applications and assignments more efficiently. It is not just a platform. It is our way of solving a problem we experienced ourselves, and making things better for the future interns.</p>
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
                                <p>We saw it firsthand. We were once interns ourselves, and we noticed a problem that has been around for generations. Every year, thousands of students search for internships, creating a high demand with limited quality opportunities. The competition is tough, and the process is expensive. If you were unlucky, you would end up mismatched with a company that does not help you grow.</p>
                                <p>As graduating students, we had to juggle thesis deadlines, clearance fees, and the pressure of securing an internship—all while spending on transportation, meals, and application requirements. Most internships do not even offer basic allowances. This is the sad reality for many students, year after year.</p>
                            </div>
                            <!-- Image -->
                            <div class="col-md-6 order-1 order-md-2">
                                <img src="https://vin.ojtgo.com/wp-content/uploads/icons/home/solved-scaled.jpg"
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
                                <img src="https://vin.ojtgo.com/wp-content/uploads/icons/home/solved-scaled.jpg"
                                    alt="Our Story" class="img-fluid rounded shadow">
                            </div>
                            <!-- Text -->
                            <div class="col-md-6 order-2 order-md-2">
                                <h2 class="text-primary">What we created?</h2>
                                <p>We created a platform designed to reduce the cost and hassle of finding an internship. It connects students, OJT Coordinators, and host companies in one convenient space. The goal is to make internships more accessible and organized—for everyone involved.</p>
                                <p>As graduating students, we had to juggle thesis deadlines, clearance fees, and the pressure of securing an internship—all while spending on transportation, meals, and application requirements. Most internships do not even offer basic allowances. This is the sad reality for many students, year after year.</p>
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

                    <!-- showed team -->
                    <div class="row justify-content-center fw-bold fs-5 mt-4">
                        <!-- Team Member 1 -->
                        <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                            <div class="team-img-container mb-2">
                                <img src="https://vin.ojtgo.com/wp-content/uploads/2025/05/sirval.png" alt="sir Val">
                            </div>
                            <p class="text-center m-0">Valery Minello</p>
                            <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Chief Executive Officer</p>
                        </div>

                        <!-- Team Member 2 -->
                        <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                            <div class="team-img-container mb-2">
                                <img src="https://vin.ojtgo.com/wp-content/uploads/2025/05/leo2.jpg" alt="sir Leo">
                            </div>
                            <p class="text-center m-0">Leo Herrera</p>
                            <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Chief Operating Officer</p>
                        </div>

                        <!-- Team Member 3 -->
                        <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                            <div class="team-img-container mb-2">
                                <img src="https://vin.ojtgo.com/wp-content/uploads/2025/05/sirjeal.jpg" alt="sir Jeal">
                            </div>
                            <p class="text-center m-0">Jeal Pascua</p>
                            <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Cybersecurity/Chief Finance Officer</p>
                        </div>

                        <!-- Team Member 4 -->
                        <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                            <div class="team-img-container mb-2">
                                <img src="https://vin.ojtgo.com/wp-content/uploads/2025/05/john.jpg" alt="ma'am Jinah">
                            </div>
                            <p class="text-center m-0">John Ronald Robillos</p>
                            <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Web and System Developer/DPO</p>
                        </div>

                        <!-- Team Member 5 -->
                        <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                            <div class="team-img-container mb-2">
                                <img src="https://vin.ojtgo.com/wp-content/uploads/2025/05/jess-3.jpg" alt="sir Jess">
                            </div>
                            <p class="text-center m-0">Jess Baggao</p>
                            <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Web Developer</p>
                        </div>

                        <!-- Team Member 6 -->
                        <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                            <div class="team-img-container mb-2">
                                <img src="https://vin.ojtgo.com/wp-content/uploads/2025/05/nicolee-2.jpg" alt="ma'am Nicole">
                            </div>
                            <p class="text-center m-0">Roan Nicole Marcellana</p>
                            <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Marketing Specialist</p>
                        </div>

                        <!-- Team Member 7 -->
                        <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                            <div class="team-img-container mb-2">
                                <img src="https://vin.ojtgo.com/wp-content/uploads/2025/05/steph.jpg" alt="ma'am Steph">
                            </div>
                            <p class="text-center m-0">Stephanie Cuenca</p>
                            <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Marketing Sales Associate</p>
                        </div>

                        <!-- Team Member 8 -->
                        <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                            <div class="team-img-container mb-2">
                                <img src="https://vin.ojtgo.com/wp-content/uploads/2025/05/jinah-1.jpg" alt="ma'am Jinah">
                            </div>
                            <p class="text-center m-0">Jinalyn Diamos</p>
                            <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">HR Manager</p>
                        </div>



                        <!-- Hidden team -->
                        <section ng-if="currentPage === 'rest' || true"> <!-- Set true for universal visibility -->
                            <div class="row justify-content-center mt-4 fw-bold fs-5" ng-show="showAllTeam">

                                <!-- Team Member 9 -->
                                <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                                    <div class="team-img-container mb-2">
                                        <img src="https://vin.ojtgo.com/wp-content/uploads/icons/home/lorenzo-scaled.jpg" alt="Lorenzo">
                                    </div>
                                    <p class="text-center m-0">Lorenzo Daniel Jarata</p>
                                    <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Front-End Developer</p>
                                </div>

                                <!-- Team Member 10 -->
                                <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                                    <div class="team-img-container mb-2">
                                        <img src="https://vin.ojtgo.com/wp-content/uploads/icons/home/millard-scaled.jpg" alt="Millard">
                                    </div>
                                    <p class="text-center m-0">Millard John Ortillano</p>
                                    <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Back-End Developer</p>
                                </div>

                                <!-- Team Member 7 -->
                                <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                                    <div class="team-img-container mb-2">
                                        <img src="https://vin.ojtgo.com/wp-content/uploads/icons/home/khianah.jpg" alt="Khianah">
                                    </div>
                                    <p class="text-center m-0">Khianah Marie Gadacho</p>
                                    <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">UI/UX Designer</p>
                                </div>

                                <!-- Team Member 8 -->
                                <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                                    <div class="team-img-container mb-2">
                                        <img src="https://vin.ojtgo.com/wp-content/uploads/icons/home/jazmine.jpg" alt="Jazmine">
                                    </div>
                                    <p class="text-center m-0">Jazmine Danielle Gundran</p>
                                    <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Marketing</p>
                                </div>

                                <!-- Team Member 9 -->
                                <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                                    <div class="team-img-container mb-2">
                                        <img src="https://vin.ojtgo.com/wp-content/uploads/icons/home/aivie.jpg" alt="Aivie">
                                    </div>
                                    <p class="text-center m-0">Aivie Concepcion</p>
                                    <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Marketing</p>
                                </div>

                                <!-- Team Member 10 -->
                                <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                                    <div class="team-img-container mb-2">
                                        <img src="https://vin.ojtgo.com/wp-content/uploads/icons/home/katrishna.jpg"
                                            alt="Katrishna">
                                    </div>
                                    <p class="text-center m-0">Kathrisha Sapon</p>
                                    <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Quality Assurance
                                    </p>
                                </div>

                                <!-- Team Member 11 -->
                                <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                                    <div class="team-img-container mb-2">
                                        <img src="https://vin.ojtgo.com/wp-content/uploads/2025/05/vin.png" alt="Charls">
                                    </div>
                                    <p class="text-center m-0">Arvin Charls Basco</p>
                                    <p class="text-center fw-light m-0" style="color:rgb(78, 78, 78);">Front-End Developer
                                    </p>
                                </div>

                                <!-- Team Member 12 -->
                                <div class="col-6 col-md-3 mb-4 d-flex flex-column align-items-center">
                                    <div class="team-img-container mb-2">
                                        <img src="https://vin.ojtgo.com/wp-content/uploads/icons/home/arandelle.jpg"
                                            alt="Arandelle">
                                    </div>
                                    <p class="text-center m-0">Arandelle Paguinto</p>
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

        <!-- News Section -->
        <section id="news" ng-show="activePage === 'news'" class="bg-light py-5">

            <div class="container">
                <h1 class="display-4 text-white fw-semibold fs-3 text-center p-3 rounded mb-5" style="background-color:rgb(0, 43, 86);">
                    News and Events
                </h1>

                <!-- Responsive Featured Image with Bottom-Left Overlay Text -->
                <div class="position-relative mb-5 rounded-3 overflow-hidden" style="height: 450px;">
                    <!-- Background Image -->
                    <img src="https://vin.ojtgo.com/wp-content/uploads/2025/05/example-1.jpg" alt="OJTGo Feature"
                        class="w-100 h-100 img-fluid" style="object-fit: cover; filter: brightness(0.6);">

                    <!-- Dark Overlay -->
                    <div class="position-absolute top-0 start-0 w-100 h-100"
                        style="background-color: rgba(0, 0, 0, 0.5); z-index: 1;"></div>

                    <!-- Overlay Text (Bottom-Left) -->
                    <div class="position-absolute bottom-0 start-0 text-white px-4 pb-4"
                        style="z-index: 2; max-width: 700px;">
                        <h3 class="fw-bold display-6 d-none d-md-block">OJTGo: Built by Students</h3>
                        <h4 class="fw-bold d-block d-md-none fs-4">OJTGo: Built by Students</h4>

                        <p class="lead mt-2" style="font-size: 1.3rem;">
                            A platform created by students, dedicated to transforming your internship journey with transparency, opportunities, and real growth.
                        </p>
                    </div>
                </div>




            </div>

            <!-- News List View (only shown when NOT viewing full news) -->
            <section class="m-4 border rounded-5">
                <div ng-if="!showFullNewsPage" class="news-list-section p-4">
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        <div class="col" ng-repeat="news in newsList">
                            <div class="card h-500 shadow-sm border-0 d-flex flex-column p-0"
                                ng-click="openFullNews(news)"
                                style="cursor: pointer; overflow: hidden; position: relative; height: 350px;">

                                <img ng-src="{{news.image}}" class="w-100"
                                    alt="News Image"
                                    style="height: 350px; width: 100%; object-fit: contain; display: block;">

                                <div class="news-overlay p-3" style="flex-grow: 1; overflow: auto;">
                                    <h5 class="card-title mb-1 fw-bold">{{ news.title }}</h5>
                                    <small class="text-light">Posted on {{ news.date }}</small>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Full News Detail View (only shown when viewing full news) -->
            <section id="full-news-section" ng-if="showFullNewsPage" class="full-news-section p-4 pt-5">
                <div class="full-news-section p-2 p-md-4">

                    <button class="btn btn-outline-primary mt-3 mb-4" ng-click="closeFullNews()">← Back to News</button>

                    <div class="row">
                        <div class="col-md-6 position-relative">
                            <div class="w-100" style="height: 500px; overflow: hidden; border-radius: 8px;">
                                <img ng-src="{{selectedNews.image}}" class="img-fluid w-100 h-100"
                                    alt="News Image" style="object-fit: contain;">
                            </div>
                        </div>

                        <div class="col-md-6 d-flex flex-column justify-content-end mt-3">
                            <h3 class="text-primary fw-bold">{{ selectedNews.title }}</h3>
                            <p class="text-muted"><small>Posted on {{ selectedNews.date }}</small></p>
                        </div>
                    </div>

                    <div class="mt-4 px-0 px-md-3">
                        <p class="w-100" style="font-size: 1.1rem; background-color: rgba(0, 0, 0, 0.6); color: #ffffff; padding: 1rem; border-radius: 8px;">
                            {{ selectedNews.summary }}
                        </p>
                    </div>
                </div>
            </section>

        </section>


        <!-- Contact Us Section -->
        <!-- Full-width container for the Contact Section -->
        <div style="background-color:rgb(173, 207, 241); padding: 20px 0;" id="contact">
            <div class="container">
                <h4 class="fw-semibold text-center mb-3 fs-1 fs-lg-2" style="color:rgb(0, 50, 101);">
                    Bridge Students to Success—OJTGo Connects Them with the Right Opportunities
                </h4>


                <div class="row justify-content-between align-items-center">
                    <!-- Contact Details -->
                    <div class="col-md-5 mb-4 mb-md-0 text-white">
                        <div class="h-100 rounded-3 p-4 shadow-lg position-relative overflow-hidden" style="color:rgb(0, 50, 101);">
                            <div style="z-index: 1; position: relative;">
                                <h3 class="fw-bold mb-3" style="color:rgb(0, 50, 101);">Contact Information</h3>
                                <p class="mb-3">Feel free to reach out to us with any questions or concerns.</p>

                                <div class="mb-3">
                                    <h5 class="fw-bold m-0">Office Address</h5>
                                    <p class="m-0">Level 10-01, One Global Place, 25th St. corner 5th Ave., Bonifacio Global City, Brgy. Fort Bonifacio, Taguig City 1630</p>
                                    <h5 class="fw-bold m-0">Sattelite Address</h5>
                                    <p class="m-0">One Building Lot 22 Blk 56, Costa Verde, Brgy Tejeros, Rosario Cavite
                                    </p>
                                </div>

                                <div class="mb-3">
                                    <h5 class="fw-bold m-0">Landline Number</h5>
                                    <p class="m-0">(046) 852-1073</p>
                                    <h5 class="fw-bold m-0">Contact Number</h5>
                                    <p class="m-0">0966-200-5909</p>
                                </div>

                                <div class="mb-3">
                                    <h5 class="fw-bold m-0">Email</h5>
                                    <p class="m-0">ojt@ojtgo.com</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="col-md-6">
                        <div class="h-100 rounded-3 p-2 shadow-lg bg-white position-relative overflow-hidden">
                            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(0, 99, 177, 0.1), rgba(255, 255, 255, 0.1)); z-index: 0;"></div>
                            <div style="z-index: 1; position: relative;">
                                <h3 class="fw-bold mb-4" style="color:rgb(0, 50, 101);">Send Us a Message</h3>
                                <form name=" contactForm" ng-submit="submitContactForm()" novalidate>
                                    <div class="mb-2">
                                        <!-- Name -->
                                        <label for="contact-us-name" class="form-label fw-semibold">Name</label>
                                        <input type="text" class="form-control custom-fields" style="border: 1px solid #0063b1;" ng-model="contactFormData.name" placeholder="e.g. John Doe" required>
                                    </div>

                                    <div class="mb-2">
                                        <!-- Email -->
                                        <label for="contact-us-email" class="form-label fw-semibold">Email</label>
                                        <input type="email" class="form-control custom-fields" style="border: 1px solid #0063b1;" ng-model="contactFormData.email" placeholder="johndoe@example.com" required>
                                    </div>

                                    <div class="mb-2">
                                        <!-- Mobile Number -->
                                        <label for="contact-us-mobile" class="form-label fw-semibold">Mobile Number</label>
                                        <input type="text" class="form-control custom-fields" style="border: 1px solid #0063b1;" ng-model="contactFormData.mobile" placeholder="+63 9 xxxxxxxxx" required>
                                    </div>

                                    <div class="mb-2">
                                        <!-- Message -->
                                        <label for="contact-us-message" class="form-label fw-semibold">Comment or Message</label>
                                        <textarea class="form-control custom-fields" style="border: 1px solid #0063b1; height: 80px;" ng-model="contactFormData.message" rows="4" placeholder="Start typing..." required></textarea>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="d-grid mt-4">
                                        <button
                                            type="submit"
                                            class="btn text-white fw-bold py-1"
                                            style="background-color:rgb(0, 50, 101);; border: 1px solid #0161aa; font-size: 1.1rem;">
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
        <div class="footer-container" style="background-color: #1565c0; color: white; padding: 10px;">
            <div class="row justify-content-between">

                <!-- logo -->
                <div class="col-lg-3 ps-lg-5 text-lg-start">
                    <div class="h-100 p-3">
                        <img style="height: 80px;" src="<?php echo home_url('/wp-content/uploads/icons/OJTGO-630X310-white.png') ?>" alt="ojtgo-logo" class="footer-logo">
                        <p class="m-0 text-secondary d-none"><i>Everybody deserves to reach their dream jobs!</i></p>

                        <!-- Social Icons -->
                        <div class="social-icons mt-3 d-flex justify-content-lg-start gap-2">
                            <a href="https://www.facebook.com/ojtgo.pces/" class="me-2" target="_blank">
                                <div class="social-circle bg-light rounded-circle" style="width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="fab fa-facebook-f text-dark"></i>
                                </div>
                            </a>
                            <a href="https://www.instagram.com/ojtgo_pces/" class="me-2" target="_blank">
                                <div class="social-circle bg-light rounded-circle" style="width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="fab fa-instagram text-dark"></i>
                                </div>
                            </a>
                            <a href="https://www.tiktok.com/@ojtgo_pces" class="me-2" target="_blank">
                                <div class="social-circle bg-light rounded-circle" style="width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="fab fa-tiktok text-dark"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- right panel -->
                <div class="col-lg-9 mt-3 mt-lg-0">
                    <div class="h-100 p-3">
                        <div class="row justify-content-between">


                            <!-- Company -->
                            <div class="col-lg-4">
                                <p class="fw-bold">Company</p>
                                <p><a class="text-white text-decoration-none" href="#" ng-click="setActivePage('home')"><small>Home</small></a></p>
                                <p><a href="#about" class="text-white text-decoration-none" ng-click="setActivePage('about', $event);"><small>About Us</small></a></p>
                                <p><a class="text-white text-decoration-none" href="#news" ng-click="setActivePage('news'); scrollToSection('news', $event)"><small>News</small></a></p>
                                <p><a href="#contact" class="text-white text-decoration-none" ng-click="scrollToSection('contact', $event)"><small>Contact Us</small></a></p>
                                <p><a href="#" class="text-white text-decoration-none" ng-click="scrollToSection('whyojtgo', $event)"><small>Why OJTGo?</small></a></p>
                            </div>


                            <!-- Get In Touch -->
                            <div class="col-lg-4 mt-3 mt-lg-0">
                                <p class="fw-bold">Get in Touch</p>
                                <div class="text-white">
                                    <p class="mb-1 text-wrap text-white text-decoration-none">
                                        <small><strong>Office Address:</strong> Level 10-01, One Global Place, 25th St. Corner, 5th Ave., Bonifacio Global City, Brgy. Fort Bonifacio, Taguig City 1630, Philippines</small>
                                    </p>
                                    <p class="mb-1 text-wrap text-white text-decoration-none">
                                        <small><strong>Satellite Address:</strong> One Building Lot 22 Blk 56, Costa Verde, Brgy Tejeros, Rosario Cavite</small>
                                    </p>
                                </div>

                                <div class="text-white">
                                    <p class="mb-1"><a href="mailto:ojt@ojtgo.com" class="text-white text-decoration-none"><small><strong>Email:</strong> ojt@ojtgo.com</small></a></p>
                                    <p class="mb-1"><small><strong>Mobile No.:</strong> 0966-200-5909</small></p>
                                    <p class="mb-1"><small><strong>Tel No.:</strong> (046) 852-1073</small></p>
                                </div>
                            </div>

                            <!-- Legality -->
                            <div class="col-lg-4 mt-3 mt-lg-0">
                                <div class="ms-0 ms-lg-0">
                                    <p class="fw-bold legal-offset">Legal</p>
                                    <p>
                                        <a class="text-white text-decoration-none legal-offset" href="#privacy" ng-click="setActivePage('privacy')">
                                            <small>Privacy Notice</small>
                                        </a>
                                    </p>
                                    <p>
                                        <a class="text-white text-decoration-none legal-offset" href="#terms" ng-click="setActivePage('terms')">
                                            <small>Terms of use</small>
                                        </a>
                                    </p>
                                </div>
                            </div>

                        </div>
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
