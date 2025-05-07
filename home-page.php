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


// Enqueue the script on the specific page
function home_page_enqueue_script() {


        if (is_page('home-page')) {

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
        
        wp_localize_script('ojt-fym-form-js', 'adminAjax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'secretKey' => OJT_SECRET_KEY,
            'nonce' => wp_create_nonce('login_nonce') // ← include everything you need
        ));
        

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
function home_page_landing_page() {
    ob_start(); ?>
    


    <style>





        .sidebar {
            height: 100%;
            width: 350px;
            position: fixed;
            overflow-y: scroll;
            top: 0;
            left: 0;
            
            color: white;    
        }



        .content {
            height: 100%;
            margin-left: 350px;
            
            color: white;
            overflow-y: auto;
            overflow-x: auto;
        }


        



        @media screen and (max-width: 991px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: static;
            }
            .content {
                margin-left: 0;
            }
        }
        
        


    </style>







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


        <!-- navbar -->
        <nav class="navbar navbar-expand-lg fixed-top bg-body-tertiary">
            <div class="container-fluid">

                <a class="navbar-brand" href="javascript:void(0)">
                    <img src="<?php echo home_url('/wp-content/uploads/2025/03/OJTGO-630X310.png') ?>" alt="Logo" style="height: 50px;" class="d-inline-block align-text-center">
                </a>

                <a href="javascript:void(0)" class="navbar-toggler border border-muted bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </a>
                
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0 align-items-center" ng-cloak ng-show="isInitialized">                    


                        <li class="nav-item" ng-class="isActive('/companies')">                        
                            <a class="nav-link" href="javascript:void(0)" ng-click="goTo('/companies')">Companies</a>
                        </li>
                                            
                        <li class="nav-item" ng-class="isActive('/about-us')">                        
                            <a class="nav-link" href="javascript:void(0)" ng-click="goTo('/about-us')">About Us</a>
                        </li>
                        
                        <li class="nav-item mt-2 mt-lg-0 me-0 me-lg-2">                        
                            <a  class="rounded-3 navbar-btn"
                                href="javascript:void(0)" 
                                ng-click="openLoginModalNav()" 
                                ng-if="!isLoggedIn" 
                            >
                                Login
                            </a>
                        </li>

                        <li class="nav-item dropdown me-0 me-lg-4 mt-3 mt-lg-0">
                            <a
                                class="rounded-3 navbar-btn" 
                                ng-click="openLoginModalNavReg(); show_reg_page_1 = true" 
                                ng-if="!isLoggedIn" 
                                href="javascript:void(0)" 
                                role="button" 
                                aria-expanded="false"
                            >
                                Register
                            </a>           
                        </li>
                            
                        <!-- Show "Dashboard" when user IS logged in -->
                        <li class="nav-item me-2" ng-if="isLoggedIn">                        
                            <a href="/applicant-dashboard" class="btn btn-sm text-dark border border-dark rounded-3">Dashboard</a> 
                        </li>

                    </ul>            
                </div>

                
            </div>
        </nav>


        <!-- Hero Loading -->
        <div 
            class="d-flex flex-column align-items-center justify-content-center container-fluid skeleton-loader kickstart-hero-skeleton" 
            ng-if="!dataLoaded"
        >
            <div class="mb-3 w-50 skeleton-block" style="height: 180px;"></div>


            <!-- Search field skeleton -->
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-3 mb-2">

                <div class="skeleton-block" style="width: 200px; height: 40px; border-radius: 40px;"></div>
                <div class="skeleton-block" style="width: 200px; height: 40px; border-radius: 40px;"></div>
                <div class="skeleton-block" style="width: 200px; height: 40px; border-radius: 40px;"></div>
            
            </div>


            <!-- Search button skeleton -->
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">

                <div class="skeleton-block" style="width: 220px; height: 40px; border-radius: 10px;"></div>
                <div class="skeleton-block" style="width: 220px; height: 40px; border-radius: 10px;"></div>

            </div>
        </div>


        <!-- Hero Container-->
        <div class="d-flex flex-column align-items-center justify-content-center container-fluid p-0 kickstart-hero-container" ng-if="dataLoaded" ng-cloak>

            <div class="d-flex flex-column align-items-center justify-content-center mx-auto col-lg-4">

                <!-- *************************** -->

                <div class="hero-header">
                    <h1 class="fw-bold text-center text-white px-3 px-md-0">
                        Kickstart Your OJT Journey with OJTGo!
                    </h1>
                </div>

                <!-- *************************** -->
            </div>

            <!-- filter Main Container -->
            <div class="d-flex container-fluid flex-column justify-content-center align-items-center">

                <!-- Filter Input -->
                <div class="row justify-content-center align-items-center px-2 gap-3">

                    <!-- Course -->
                    <div class="col-12 col-md-6 col-lg-2 d-flex flex-column justify-content-center">
                        <h5 class="text-white text-start mb-1 d-none d-lg-block">Course</h5>
                        <select 
                            class="form-select input-styles"
                            ng-model="filterData.selectedCourse" 
                            ng-change="resetFieldMatch('course'); updateJobTitles()" 
                            ng-options="course for course in courses">
                            <option value="" disabled>Select a Course</option>
                        </select>
                    </div>

                    <!-- Role -->
                    <div class="col-12 col-md-6 col-lg-2 d-flex flex-column justify-content-center">
                        <h5 class="text-white text-start mb-1 d-none d-lg-block">Role</h5>
                        <select 
                            class="form-select input-styles" 
                            ng-model="filterData.selectedRole"
                            ng-change="resetFieldMatch('role')"
                            ng-disabled="!filterData.selectedCourse"
                            ng-options="role for role in jobTitles">
                            <option value="" disabled>Select a role</option>
                        </select>
                    </div>

                    <!-- Province -->
                    <div class="col-12 col-md-6 col-lg-2 d-flex flex-column justify-content-center">
                        <h5 class="text-white text-start mb-1 d-none d-lg-block">Province</h5>
                        <select 
                            class="form-select input-styles"
                            ng-model="locationFilter.province"
                            ng-change="resetFieldMatch('province'); loadCitiesForProvince()"
                            ng-options="province.province_name as province.province_name for province in provinceList">
                            <option value="" disabled selected>Select a Province</option>
                        </select>
                    </div>

                    <!-- City (conditionally shown) -->
                    <div 
                        class="col-12 col-md-6 col-lg-2 d-flex flex-column justify-content-center" 
                        ng-show="locationFilter.province"
                    >
                        <h5 class="text-white text-start mb-1 d-none d-lg-block">City</h5>
                        <select 
                            class="form-select input-styles"
                            ng-model="locationFilter.city"
                            ng-change="resetFieldMatch('city')"
                            ng-options="city for city in cityList">
                            <option value="" disabled selected>Select a City (Optional)</option>
                        </select>
                    </div>
                </div>

                <!-- Search and reset Button -->
                <div class="row gap-3 align-items-center justify-content-center container-fluid text-center mt-4">
                    <!-- 🔍 Search Button -->
                    <button 
                        id="roles-block-scroll" 
                        ng-click="filterJobs(); scrollToRoles()" 
                        ng-disabled="!(
                            filterData.selectedCourse || 
                            filterData.selectedRole || 
                            locationFilter.province
                        )"  
                        class="col-12 col-lg-6 btn btn-primary text-white filter-btn"
                    >
                        Search <i class="bi bi-arrow-right"></i>
                    </button>

                        <!-- Reset Button -->
                    <button 
                        ng-click="resetFilters()" 
                        class="col-12 col-lg-6 btn btn-secondary text-white filter-btn"
                    >
                        Reset <i class="bi bi-arrow-clockwise"></i>
                    </button>
                </div>

            </div>

        </div>


        <!-- Roles Loading -->
        <div class="row justify-content-between align-items-stretch gap-3 gap-lg-0 container-fluid mt-5 skeleton-loader roles-block-skeleton" ng-if="!dataLoaded">
            
            <!-- Job list pane skeleton -->
            <div class="col-lg-4 d-none d-lg-block list-pane-skeleton">
                <div class="rounded-4 mb-3 skeleton-block" style="width: 100%; height: 250px;" ng-repeat="n in [1,2,3,4,5] track by $index"></div>
            </div>

            <!-- Job detail pane skeleton -->
            <div class="d-flex flex-column col-lg-8 details-pane-skeleton">
                <div class="rounded-4 skeleton-block" style="width: 100%; height: 100%;"></div>
            </div>
        </div>


        <!-- ROLES Block -->
        <div class="mt-5 p-3 p-lg-5 find-match-container" id="roles-block" ng-if="dataLoaded" ng-cloak>
            
            <div class="row justify-content-between align-items-stretch gap-3 gap-lg-0 job-list-container">


                <!-- Job listing pane -->
                <div class="d-none d-lg-flex flex-column col-lg-4 job-list-wrapper">                
                    <div class="job-list-pane scrollable">
                        
                        <div class="rounded p-2 " >

                            <!-- *** -->

                            <a 
                                href="javascript:void(0)" 
                                class="link link-dark" 
                                ng-repeat="job in job_posts"
                            >
                                <div 
                                    ng-click="job_post_selected(job._ID)" 
                                    style="background-color: #f8f9fa;" 
                                    class="p-2 rounded-2 mb-3 job-card"
                                    ng-class="{'active': selectedJobPostId === job._ID}"
                                >                                                                
                                
                                    <!-- headers -->
                                    <!-- Banner -->
                                    <div class="banner" style="width: 100%;">
                                        
                                        <!-- If hiring date exists -->
                                            <div 
                                                class="mb-3 fw-bold ms-2 hiring-urgency" 
                                                ng-style="{ 
                                                    color: job.employer_job_offer_emp_ia === 'yes' ? 'red' : 'green',
                                                    width: '75%', 
                                                    fontSize: '0.825rem' 
                                                }"
                                                >
                                                <i 
                                                    class="me-2" 
                                                    ng-class="job.employer_job_offer_emp_ia === 'yes' 
                                                        ? 'bi bi-exclamation-diamond' 
                                                        : 'bi bi-calendar-check'"
                                                ></i>
                                                {{ job.employer_job_offer_emp_ia === 'yes' 
                                                    ? 'Immediate Hiring!' 
                                                    : job.employer_job_offer_date_available_hiring | date:'MM-dd-yyyy' }}
                                            </div>

                                    </div>


                                    <!-- Image, role and company name -->
                                    <div class="d-flex align-items-center flex-grow-1 overflow-hidden gap-3">
                                        
                                        <div class="biz-image-container flex-shrink-0">
                                            <img 
                                                ng-src="{{ job.logo_url }}" 
                                                class="border border-secondary" 
                                                style="height: 50px; width: 50px; border-radius: 50%; object-fit: cover;" 
                                                alt="company-logo"
                                            >  
                                        </div>
                                        

                                        <div class="biz-info flex-grow-1 overflow-hidden w-100">                                                                         
                                            <h4 class="fw-bold m-0 p-0 text-truncate">{{job.employer_job_offer_job_title_preferred}}</h4>
                                            <small class="fw-normal text-secondary mt-0 text-truncate">{{job.business_name}}</small>
                                        </div>
                                        
                                        <div class="ms-auto flex-shrink-0">
                                            <p 
                                                style="font-size: 14px;" 
                                                class="text-white p-2 rounded text-center"
                                                ng-if="hasSearchedCourse || hasSearchedJob || hasSearchedProvince || hasSearchedCity"
                                                ng-style="{ 'background-color': getMatchColor(job.match_percentage) }"
                                            >
                                                {{ job.match_percentage }}% Match
                                            </p>
                                        </div>


                                    
                                    </div>



                                    <!-- Tags -->
                                    <div class="mt-3 d-flex align-items-start flex-wrap gap-2">

                                        <!-- Work Shift Tag -->
                                        <p class="rounded-pill tag p-1 px-2">
                                            <small>
                                                <i class="bi"
                                                ng-class="{
                                                    'bi-cloud-sun-fill': job.employer_job_offer_shifting_schedule.toLowerCase() === 'day-shift',
                                                    'bi-moon-stars-fill': job.employer_job_offer_shifting_schedule.toLowerCase() === 'night-shift',
                                                    'bi-arrow-left-right': job.employer_job_offer_shifting_schedule.toLowerCase() === 'hybrid'
                                                }"></i>
                                                {{ job.employer_job_offer_shifting_schedule || 'N/A' }}
                                            </small>
                                        </p>

                                        <!-- Work Mode Tag -->
                                        <p class="rounded-pill tag p-1 px-2" ng-if="job.employer_job_offer_preferred_work_mode">
                                            <small>
                                                <i class="bi"
                                                ng-class="{
                                                    'bi-building': job.employer_job_offer_preferred_work_mode.toLowerCase() === 'on-site',
                                                    'bi-wifi': job.employer_job_offer_preferred_work_mode.toLowerCase() === 'remote',
                                                    'bi-shuffle': job.employer_job_offer_preferred_work_mode.toLowerCase() === 'flexible'
                                                }"></i>
                                                {{ job.employer_job_offer_preferred_work_mode }}
                                            </small>
                                        </p>

                                        <!-- Allowance Tag -->
                                        <p class="rounded-pill tag px-2" 
                                        ng-class="job.employer_job_offer_emp_provide_allowance === 'yes' ? 'bg-success text-white' : 'bg-secondary text-white'">
                                            <small>
                                                <i class="bi bi-coin"></i>
                                                {{ job.employer_job_offer_emp_provide_allowance === 'yes' ? 'With Allowance' : 'No Allowance' }}
                                            </small>
                                        </p>

                                    </div>

                                

                                    <!-- Other business info -->
                                    <p class="m-0" style="font-size: 15px;"><i class="bi bi-geo-alt-fill"></i>{{job.employer_job_offer_preferred_job_location_address}}</p>
                                    <p class="m-0" style="font-size: 15px;"><i class="bi bi-mortarboard-fill"></i> {{job.employer_job_offer_emp_education}}</p>

                                    
                                    
                                    <!-- <p class="m-0" style="font-size: 15px;"><i class="bi bi-book-fill"></i><small> Accepting IT Students</small></p> -->
                                
                                    <!-- Rate -->
                                    <!-- <h3 class="text-primary fw-bold m-0">$400-600</h3> -->
                                    <!-- <p style="font-size: 14px;" class="m-0">Monthly</p> -->
                                
                                    
                                    <!-- <p class="mt-3" style="font-size: 15px;"><i class="bi bi-moon-fill"></i>Night Shift</p> -->
                                                                
                                </div>
                            </a>

                        

                            <!-- *** -->



                        </div>
                    </div>
                </div>

                <!-- Job details pane -->
                <div class="d-flex flex-column col-lg-8 job-details-pane">

                    <!-- for mobile -->
                    <div class="my-4 d-grid d-lg-none">
                        <a 
                            data-bs-toggle="offcanvas" 
                            href="#fym-map-mobile" 
                            aria-controls="fym-map-mobile"
                            class="d-xl-none btn btn-dark text-white" 
                            style="font-size: 13px;" 
                        >
                            Show Job Posts
                        </a>
                    </div>

                    <div class="rounded-3 p-0 container-fluid d-flex flex-column job-details-container">

                        <!-- ðŸ”¹ Loading Indicator -->
                        <div ng-show="reloadData" class="text-center my-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Fetching job details, please wait...</p>
                        </div>


                        <div ng-show="!reloadData" ng-cloak>
                            <!-- Header Section -->
                            <div class="border-0 pt-5 pb-3 px-5 row align-items-center justify-content-between gap-3 gap-lg-0">
                                <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center justify-content-lg-start">
                                    <img ng-src="{{ viewpost_biz_logo }}" 
                                        class="rounded-circle border me-3"
                                        style="width: 70px; height: 70px; object-fit: cover; background: #ddd;">
                                    <div>
                                    <h4 class="fw-bold text-dark m-0">
                                        {{ viewpost_job_title }}
                                        <i 
                                            ng-if="hasSearchedJob && jobmatched !== null"
                                            ng-class="jobmatched 
                                                ? 'bi bi-check-circle-fill text-success ms-2' 
                                                : 'bi bi-x-circle-fill text-danger ms-2'">
                                        </i>

                                    </h4>

                                    <h6 class="fw-normal text-secondary m-0">{{ viewpost_biz_name }}</h6>
                                    <small> {{ viewpost_biz_city }} </small>
                                    <small> {{ viewpost_biz_province }} </small>
                                    </div>
                                </div>
                
                                <!-- Right Section: Match Percentage, Request Button & Close Button -->
                                <div class="col-12 col-lg-auto d-flex align-items-center justify-content-center gap-2">
                    
                                    <a 
                                        id="show-login-modal"
                                        href="javascript:void(0)"
                                        class="text-dark d-flex align-items-center justify-content-center modal-send-request trigger-entry-modal"
                                        ng-click="setUserType('intern');"
                                    >
                                        <i class="me-1 bi bi-send"></i>Send Request
                                    </a>                                
                
                                </div>
                                                            
                            </div>


                            <hr class="my-3 mx-5" ng-if="hasSearchedCourse || hasSearchedJob || hasSearchedProvince || hasSearchedCity">

                            <!-- High Chart Container -->
                            <div id="container" class="px-5" style="width: 100%; height: 250px;" ng-if="hasSearchedCourse || hasSearchedJob || hasSearchedProvince || hasSearchedCity">
                                <h2 class="fw-bold">{{job.match_percentage}}</h2>
                            </div>
                
                
                            <hr class="my-3 mx-5" ng-if="hasSearchedCourse || hasSearchedJob || hasSearchedProvince || hasSearchedCity">
                
                            <!-- Modified by Lorenzo @ 04/10/2025 -->
                            <!-- Internship Details -->
                            <div class="d-flex flex-column align-items-center p-3 px-3 px-md-5 internship-details">
                                <h2 class="fw-bold text-center text-dark">Internship Details</h2>
                                <div class="row justify-content-between gap-3" style="width: 100%;">

                                    <div class="col-12 col-md-5">

                                        <p class="fw-bold">
                                            <i class="bi bi-building"></i> Work Mode: 
                                            <span class="fw-normal">{{ viewpost_job_work_mode || 'Not Set'}}</span>
                                        </p>
                                        <p class="fw-bold">
                                            <i class="bi bi-brightness-alt-high"></i> Work Shift:
                                            <span class="fw-normal">{{viewpost_job_shift}}</span>
                                        </p>
                                        <p class="fw-bold">
                                            <i class="bi bi-coin"></i> Provides Allowance: 
                                            <span class="fw-normal {{ selectedJob.employer_job_offer_emp_provide_allowance === 'yes' ? 'text-success' : 'text-danger' }}">
                                                {{ viewpost_with_allowance === 'yes' ? 'With Allowance' : 'Without Allowance' }}
                                            </span>
                                        </p>
                                        <p class="fw-bold">
                                            <i class="bi bi-calendar"></i> Deployment Date: 
                                            <span
                                                class="mb-3 fw-bold ms-2 hiring-urgency" 
                                                ng-style="{ color: viewpost_immediate_hiring === '' ? 'red' : 'green', width: '75%', fontSize: '0.825rem' }"
                                            >
                                                <i class="me-2" ng-class="viewpost_immediate_hiring === '' ? 'bi bi-exclamation-diamond' : 'bi bi-calendar-check'"></i>
                                                {{ viewpost_immediate_hiring === '' ? 'Immediate Hiring!' : viewpost_immediate_hiring }}
                                            </span>
                                        </p>

                                    </div>
                                    

                                    <div class="col-12 col-md-5">
                                        <!-- Added by Lorenzo @ 04/10/2025 -->
                                        <p class="fw-bold">
                                            <i class="bi bi-geo"></i> Preferred Province: 
                                            <span class="mb-3 fw-normal ms-2" >
                                                {{ viewpost_biz_province }}
                                            </span>
                                            <i 
                                                ng-if="hasSearchedProvince && provincematched !== null"
                                                ng-class="hasSearchedProvince 
                                                    ? 'bi bi-check-circle-fill text-success ms-2' 
                                                    : 'bi bi-x-circle-fill text-danger ms-2'">
                                            </i>

                                        </p>
                                        <p class="fw-bold">
                                            <i class="bi bi-geo"></i> Preferred City: 
                                            <span class="mb-3 fw-normal ms-2" >
                                                {{ viewpost_biz_city }}
                                            </span>
                                            <i 
                                                ng-if="hasSearchedCity && citymatched !== null"
                                                ng-class="citymatched 
                                                    ? 'bi bi-check-circle-fill text-success ms-2' 
                                                    : 'bi bi-x-circle-fill text-danger ms-2'">
                                            </i>
                                                
                                        </p>
                                    </div>
                                    
                                    
                                </div>
                            </div>


                            <hr class="my-3 mx-5">

                            <!-- Job Post Description -->
                            <div class="p-3 px-3 px-md-5">
                                <h2 class="fw-bold text-center text-dark">Job Post Description</h2>
                                <p 
                                    class="text-muted posting-description"
                                    ng-class="{
                                        'text-center': !selectedJob.employer_job_offer_job_description,
                                        'text-justify': selectedJob.employer_job_offer_job_description
                                    }"
                                >
                                    {{ selectedJob.employer_job_offer_job_description || 'No description available' }}
                                </p>
                            </div>

                
                            <hr class="my-3 mx-5">
                

                            <!-- Internship Criteria -->
                            <div class="row justify-content-center align-items-start px-3 px-md-5 p-3 internship-criteria">
                                <h2 class="fw-bold text-center text-dark">Internship Criteria</h2>

                                <div class="col-12 col-md-5 d-flex flex-column internship-critera">
                                    <p class="fw-bold">
                                        <i class="bi bi-mortarboard"></i> Academic Level: 
                                        <span class="fw-normal">{{ selectedJob.employer_job_offer_emp_education }}</span>
                                    </p>
                                    <p class="fw-bold">
                                        <i class="bi bi-book"></i> Accepting Students From: 
                                        <span class="fw-normal">{{ selectedJob.employer_job_offer_emp_preferred_course }}</span>
                                        <i 
                                            ng-if="hasSearchedCourse && coursematched !== null"
                                            ng-class="coursematched 
                                                ? 'bi bi-check-circle-fill text-success ms-2' 
                                                : 'bi bi-x-circle-fill text-danger ms-2'">
                                        </i>
                                

                                    </p>
                                    <p class="fw-bold">
                                        <i class="bi bi-clock"></i> OJT Hours: 
                                        <span class="fw-normal">{{selectedJob.employer_job_offer_emp_ojt_min}} - {{selectedJob.employer_job_offer_emp_ojt_max}}</span>                                          
                                    </p>
                                </div> 

                                <div class="col-12 col-md-5 d-flex flex-column justify-content-between internship-critera">                      
                                    <p class="mb-2">
                                        <i class="bi bi-translate"></i> Language:
                                    </p> 

                                    <div ng-repeat="lang in selectedLanguagesModal">
                                        <span class="fw-bold">
                                            {{ lang.name }}
                                        </span>

                                        <!-- Spoken -->
                                        <div class="ms-4 d-flex align-items-center justify-content-start gap-2 mt-1">
                                            <h6 class="fw-bold mb-0">Spoken:</h6>
                                            <div class="progress flex-grow-1">
                                                <div class="progress-bar" style="width: {{ lang.spoken }}%">
                                                    {{ lang.spoken }}%
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Written -->
                                        <div class="ms-4 d-flex align-items-center justify-content-start gap-2 mt-1">
                                            <h6 class="fw-bold mb-0">Written:</h6>
                                            <div class="progress flex-grow-1">
                                                <div class="progress-bar" style="width: {{ lang.written }}%">
                                                    {{ lang.written }}%
                                                </div>
                                            </div>
        
                                        </div>
                                    </div> 
                                </div>

                            </div>

                            <!-- Create Account Persuasion -->
                            <div class="container-fluid text-center mt-3 create-account-banner">
                                <span class="d-block fw-bold text-white text-center">
                                    Want a more thorough search? 
                                    <a 
                                        href="javascript:void(0)" 
                                        class="fw-bold text-primary create-acc-link"
                                        ng-click="setUserType('intern');"
                                    > 
                                        Create an Account
                                    </a>
                                    with us and we'll help!
                                </span>
                            </div>
                        </div>
                        
                    </div>

                    
                </div>

                
            
            
            </div>

        </div>


        
        
        <!-- End of Modified by Lorenzo @ 03/31/2025 -->


        <!-- Footer -->
        <div class="border-top border-muted pt-2" style="margin-top: 50px;">
            <div class="row justify-content-between">
                
                <!-- left panel -->
                <div class="col-lg-3">
                    <div class="h-100">
                        <img style="height: 80px;" src="<?php echo home_url('/wp-content/uploads/2025/03/OJTGO-630X310.png') ?>" alt="jobydep-logo">
                        <p class="m-0 text-secondary d-none"><i>Everybody deserves to reach their dream jobs!</i></p>
                    </div>
                </div>

                <!-- right panel -->
                <div class="col-lg-9 mt-3 mt-lg-0">
                    <div class="h-100">
                        <div class="row justify-content-between">
                            
                        
                            <!-- Company -->
                            <div class="col-lg-4">
                                <p class="fw-bold">Company</p>
                                <p><a href="https://jobydep.com" class="link link-secondary"><small>Home</small></a></p>
                                <p><a href="https://jobydep.com/about-us/" class="link link-secondary"><small>About Us</small></a></p>
                                <p><a href="https://jobydep.com/news-and-blogs/" class="link link-secondary"><small>News and Blogs</small></a></p>
                                <p><a href="https://jobydep.com/why-jobydep/" class="link link-secondary"><small>Why Jobydep?</small></a></p>
                            </div>

                            <!-- Get In Touch -->
                            <div class="col-lg-4 mt-3 mt-lg-0">
                                <p class="fw-bold">Get in Touch</p>
                                <p class="text-wrap"><small>Level 10-01, One Global Place, 25th St. Corner, 5th Ave., Bonifacio Global City, Brgy. Fort Bonifacio, Taguig City 1630, Philippines</small></p>
                                <p><a href="mailto:inquiries@pces.com.ph" class="link link-secondary"><small>Email: inquiries@pces.com.ph</small></a></p>
                                <p class="text-secondary"><small>Telephone: (02) 8628-2072</small></p>
                            </div>

                            <!-- Legality -->
                            <div class="col-lg-4 mt-3 mt-lg-0">
                                <p class="fw-bold">Legal</p>                                                        
                                <p><a href="https://pces.com.ph/privacy-notice" class="link link-secondary"><small>Privacy Notice</small></a></p>
                                <p><a href="https://pces.com.ph/terms-of-use" class="link link-secondary"><small>Terms of Use</small></a></p>
                            </div>


                            
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- 
            Code Migrated 
                @ 04/07/2025 
                @ 04/11/2025 - Register input field error display
                @ 04/23/2025 - Password Recovery 
        -->
        <!-- 
            Login/Register Modal 
            Vesion ni Leonardo
        -->
        
        <div 
            id="modal-overlay" 
            class="modal-overlay container-fluid"
            ng-class="{ 'active': isModalActive, 'active-unmount': !isModalActive }"
        >


            <!-- Main Container -->
            <div 
                id="information-entry-modal" 
                class="d-flex justify-content-center align-items-center information-entry-modal"
                ng-class="{ 'active': isModalActive }"
            >

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
                    ng-cloak
                >


                    <!-- Empty for now -->
                    <div class="d-flex flex-column align-items-center justify-content-center animation-container">

                        <!-- <div class="d-flex flex-column align-items-center justify-content-center mb-3 some-animation">
                            Hello
                        </div> -->

                        <img class="d-block mx-auto" style="height: 70px;" src="<?php echo home_url('/wp-content/uploads/2025/03/OJTGO-630X310.png') ?>">

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
                                        ng-model="credentials.password"
                                    >
                                    <!-- Conditional Use of Icon depends on the current state of the password -->
                                    <span 
                                        id="toggle-pass-visibility" 
                                        class="input-group-text toggle-visibility" 
                                        ng-click="togglePasswordVisibility('isLogPasswordVisible')"
                                    >
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
                        ng-click="switchModalContent('forgot-pass');"
                    >
                        Forgot Your Password?
                    </a>



                    <!-- Login Button -->
                    <a 
                        id="login" 
                        href="javascript:void(0)" 
                        class="col text-center my-5 px-5 py-2 modal-btn login-btn"
                        ng-click="loginUser()"
                    >
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
                            ng-click="switchModalContent('user-type');"
                        >
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
                    ng-cloak
                >


                    <div class="d-flex flex-column align-items-center justify-content-center animation-container">

                        <img class="d-block mx-auto" style="height: 70px;" src="<?php echo home_url('/wp-content/uploads/2025/03/OJTGO-630X310.png') ?>">

                    </div>

                    <!-- Header and Sub Title -->
                    <div class="row flex-column align-items-center justify-content-center mb-3 header">
                        <p class="col-auto fs-1 fw-bold text-center mb-0">Welcome!</p>
                        <p class="col-auto text-secondary text-center mb-0 w-75" style="font-size: 1rem;">We are gald to have you!</p>
                    </div>
                    
                    <p class="text-center">Which type of user are you?</p>

                    <!-- Login Button -->
                    <a 
                        ng-click="setUserType('employer');" 
                        href="javascript:void(0);" 
                        class="text-center my-2 px-5 py-2 modal-btn employer-btn"
                    >
                        Employer
                    </a>

                    <span class="text-center">or</span>

                    <a 
                        ng-click="setUserType('intern');" 
                        href="javascript:void(0);" 
                        class="text-center my-2 px-5 py-2 modal-btn intern-btn"
                    >
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
                    ng-cloak
                >

                    <div class="d-flex flex-column align-items-center justify-content-center animation-container">

                        <img class="d-block mx-auto" style="height: 70px;" src="<?php echo home_url('/wp-content/uploads/2025/03/OJTGO-630X310.png') ?>">

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
                                        required
                                    >
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
                                        ng-change="validateEmail()"
                                    >
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
                                        ng-change="validatePassword('credentials')"
                                    >
                                    <!-- Conditional Use of Icon depends on the current state of the password -->
                                    <span 
                                        id="toggle-pass-visibility" 
                                        class="input-group-text toggle-visibility"
                                        ng-click="togglePasswordVisibility('isRegPasswordVisible')"
                                    >
                                        <i class="bi" ng-class="{'bi-eye': isRegPasswordVisible, 'bi-eye-slash': !isRegPasswordVisible}"></i>
                                    </span><br />
                                </div>
                            </div>
                        </div>
                        <!-- Added code by Lorenzo @ 04/11/2025 -->
                        <div class="rounded text-start mt-2 p-2 guidelines">
                            <small 
                                ng-class="{'text-success': passChecks.length && credentials.password, 'text-danger': credentials.password.length > 0 && !passChecks.length}"
                            >
                                ✔ At least 8 characters</small><br />
                            <small 
                                ng-class="{'text-success': passChecks.lower && credentials.password, 'text-danger': credentials.password.length > 0 && !passChecks.lower}"
                            >
                                ✔ 1 lowercase & </small>
                            <small 
                                ng-class="{'text-success': passChecks.upper && credentials.password, 'text-danger': credentials.password.length > 0 && !passChecks.upper}"
                            >
                                1 uppercase</small><br />
                            <small 
                                ng-class="{'text-success': passChecks.number && credentials.password, 'text-danger': credentials.password.length > 0 && !passChecks.number}"
                            >
                                ✔ At least 1 number</small> <br />
                            <small 
                                ng-class="{'text-success': passChecks.special && credentials.password, 'text-danger': credentials.password.length > 0 && !passChecks.special}"
                            >
                                ✔ At least 1 special character</small> <br />
                        </div>
                    </div>

                    <!-- register Button -->
                    <a 
                        id="create-acc-btn" 
                        href="javascript:void(0)" 
                        class="col text-center my-5 px-5 py-2 modal-btn register-btn"
                        ng-click="storeCredentials();"
                        ng-class="{'disabled': isFormInvalid() && !passwordValid && !usernameValid}"
                    >
                        Create Account
                    </a>



                    <!-- Direct to Login -->
                    <span class="col-12 text-center" style="font-size: 0.875rem;">Already have an account?</span>
                    <p class="col-12 mb-0 text-center" style="font-size: 0.875rem;">
                        <a 
                            href="javascript:void(0)" 
                            class="link-text login-account" 
                            style="font-size: 0.875rem;"
                            ng-click="switchModalContent('login')"
                        >
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
                    ng-cloak
                >


                    <!-- Empty for now -->
                    <div class="d-flex flex-column align-items-center justify-content-center animation-container">

                        <!-- <div class="d-flex flex-column align-items-center justify-content-center mb-3 some-animation">
                            Hello
                        </div> -->

                        <img class="d-block mx-auto" style="height: 70px;" src="<?php echo home_url('/wp-content/uploads/2025/03/OJTGO-630X310.png') ?>">

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
                                ng-change="validateOtp('otpCode')"
                            >
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
                        ng-if="!otpCooldown"
                    >
                        Resend the code.
                    </a>

                    <span 
                        class="col-12 mb-0 text-center text-muted" 
                        style="font-size: 0.875rem;"
                        ng-if="otpCooldown"
                    >
                        Resend available in {{ otpCooldownSeconds }}s
                    </span>


                    <!-- Login Button -->
                    <a 
                    id="verify-email" 
                    href="javascript:void(0)" 
                    class="col text-center my-5 px-5 py-2 modal-btn verify-btn d-flex justify-content-center align-items-center gap-2"
                    ng-click="verifyAndProceed('register')"
                    ng-class="{ 'disabled': isCreating }"
                    >
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
                            ng-click="switchModalContent('login')"
                        >
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
                    ng-cloak
                >

                    <!-- OJT go logo -->
                    <div class="d-flex flex-column align-items-center justify-content-center animation-container">

                        <img class="d-block mx-auto" style="height: 70px;" src="<?php echo home_url('/wp-content/uploads/2025/03/OJTGO-630X310.png') ?>">

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
                                ng-model="accountEmail"
                            >
                        </div>
                        <!-- <small class="text-danger text-wrap" ng-show="emailError">{{ emailError }}</small> -->
                    </div>


                    <!-- Send Instruction Button -->
                    <a 
                        id="login" 
                        href="javascript:void(0)" 
                        class="col text-center my-5 px-5 py-2 modal-btn instructions-btn"
                        ng-click="sendForgotPassword()"
                    >
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
                            ng-click="switchModalContent('login')"
                        >
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
                    ng-cloak
                >


                    <!-- Empty for now -->
                    <div class="d-flex flex-column align-items-center justify-content-center animation-container">

                        <!-- <div class="d-flex flex-column align-items-center justify-content-center mb-3 some-animation">
                            Hello
                        </div> -->

                        <img class="d-block mx-auto" style="height: 70px;" src="<?php echo home_url('/wp-content/uploads/2025/03/OJTGO-630X310.png') ?>">

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
                                ng-change="validateOtp('passRecoveryOtp')"
                            >
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
                        ng-if="!otpCooldown"
                    >
                        Resend the code.
                    </a>

                    <span 
                        class="col-12 mb-0 text-center text-muted" 
                        style="font-size: 0.875rem;"
                        ng-if="otpCooldown"
                    >
                        Resend available in {{ otpCooldownSeconds }}s
                    </span>


                    <!-- Login Button -->
                    <a 
                        id="verify-email-pass-recovery" 
                        href="javascript:void(0)" 
                        class="col text-center my-5 px-5 py-2 modal-btn verify-btn"
                        ng-click="verifyAndProceed('pass-recovery')"
                    >
                        Verify
                    </a>



                    <!-- Direct to Login -->
                    <span class="col-12 text-center" style="font-size: 0.875rem;">Already have an account?</span>
                    <p class="col-12 mb-0 text-center" style="font-size: 0.875rem;">
                        <a 
                            href="javascript:void(0)" 
                            class="link-text login-account"
                            style="font-size: 0.875rem;"
                            ng-click="switchModalContent('login')"
                        >
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
                    ng-cloak
                >

                    <div class="d-flex flex-column align-items-center justify-content-center animation-container">

                        <img class="d-block mx-auto" style="height: 70px;" src="<?php echo home_url('/wp-content/uploads/2025/03/OJTGO-630X310.png') ?>">

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
                                        ng-change="validatePassword('forgotPass')"
                                    >
                                    <!-- Conditional Use of Icon depends on the current state of the password -->
                                    <span 
                                        id="toggle-pass-visibility" 
                                        class="input-group-text toggle-visibility"
                                        ng-click="togglePasswordVisibility('isNewPassVisible')"
                                    >
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
                                        ng-change="validatePassword('forgotPass')"
                                    >
                                    <!-- Conditional Use of Icon depends on the current state of the password -->
                                    <span 
                                        id="toggle-pass-visibility" 
                                        class="input-group-text toggle-visibility"
                                        ng-click="togglePasswordVisibility('isConfirmPassVisible')"
                                    >
                                        <i class="bi" ng-class="{'bi-eye': true, 'bi-eye-slash': false}"></i>
                                    </span><br />
                                </div>
                            </div>
                        </div>


                        <!-- added by Lorenzo @ 04/23/2025 -->
                        <!-- password requirements -->
                        <div class="rounded text-start mt-2 p-2 px-3 px-2 w-100 guidelines">
                            <small 
                                ng-class="{'text-success': passChecks.length && forgotPass.password, 'text-danger': forgotPass.password.length > 0 && !passChecks.length}"
                            >
                                ✔ At least 8 characters</small><br />
                            <small 
                                ng-class="{'text-success': passChecks.lower && forgotPass.password, 'text-danger': forgotPass.password.length > 0 && !passChecks.lower}"
                            >
                                ✔ 1 lowercase & 
                            </small>
                            <small 
                                ng-class="{'text-success': passChecks.upper && forgotPass.password, 'text-danger': forgotPass.password.length > 0 && !passChecks.upper}"
                            >
                                1 uppercase
                            </small><br />
                            <small 
                                ng-class="{'text-success': passChecks.number && forgotPass.password, 'text-danger': forgotPass.password.length > 0 && !passChecks.number}"
                            >
                                ✔ At least 1 number
                            </small> <br />
                            <small 
                                ng-class="{'text-success': passChecks.special && forgotPass.password, 'text-danger': forgotPass.password.length > 0 && !passChecks.special}"
                            >
                                ✔ At least 1 special character
                            </small> <br />
                            <small 
                                ng-class="{'text-success': passChecks.matched && forgotPass.confirmPass, 'text-danger': forgotPass.confirmPass.length > 0 && !passChecks.matched}"
                            >
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
                        ng-class="{'disabled': !passwordValid}"
                    >
                        Change Password
                    </a>



                    <!-- Direct to Login -->
                    <span class="col-12 text-center" style="font-size: 0.875rem;">Already have an account?</span>
                    <p class="col-12 mb-0 text-center" style="font-size: 0.875rem;">
                        <a 
                            href="javascript:void(0)" 
                            class="link-text login-account" 
                            style="font-size: 0.875rem;"
                            ng-click="switchModalContent('login')"
                        >
                            Log in
                        </a>
                        instead.
                    </p>

                </div>

            
            </div>


        </div>
        

        <!-- 
            Login/Register Modal
            Version ni Leonardo
        -->
        
        <!-- End of Code Migrated @ 04/07/2025 -->



        <!-- Added by Lorenzo @05/05/2025 -->
        <!-- find match off canvas -->

        <!-- Off Canvas - job postings card for mobile view -->
        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="fym-map-mobile" aria-labelledby="fym-map-mobile">
        
            <div class="p-2 overflow-y-scroll">

                <div class="offcanvas-header">
                    <h5 class="fw-bolf offcanvas-title">Job Posts</h5>
                    <!-- <a href="javascript:;" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button> -->
                    <a class="btn-close" data-bs-dismiss="offcanvas" href="#offcanvasExample" aria-controls="offcanvasExample">
                        
                    </a>
                </div>



                <div class="offcanvas-body p-0" >   
                    <!-- Intern Post -->
                    <!-- max-height: 700px -->
                    <div 
                        style="height: 100vh; overflow-y: scroll;" 
                        class="rounded" 
                        ng-cloak 
                        ng-init="show_job_lists = false"
                    >
                
                        <a 
                            href="javascript:void(0)" 
                            class="link link-dark" 
                            ng-repeat="job in job_posts"
                        >
                            
                            <!-- Modified by Lorenzo @ 04/28/2025 -->
                            <div 
                                ng-click="job_post_selected(job._ID)" 
                                style="background-color: #f8f9fa;" 
                                class="p-2 rounded-2 mb-3 job-card"
                                ng-class="{'active': selectedJobPostId === job._ID}"
                                data-bs-dismiss="offcanvas"
                            >
                    
                                <!-- Banner -->
                                <div class="banner d-flex align-items-center" style="width: 100%;">
                                    
                                    <!-- If hiring date exists -->
                                    <div 
                                        class="fw-bold ms-2 hiring-urgency" 
                                        ng-style="{ 
                                            color: job.employer_job_offer_emp_ia === 'yes' ? 'red' : 'green',
                                            width: '75%', 
                                            fontSize: '0.825rem' 
                                        }"
                                    >
                                        <i 
                                            class="me-2" 
                                            ng-class="job.employer_job_offer_emp_ia === 'yes' 
                                                ? 'bi bi-exclamation-diamond' 
                                                : 'bi bi-calendar-check'"
                                        ></i>

                                        {{ job.employer_job_offer_emp_ia === 'yes' 
                                            ? 'Immediate Hiring!' 
                                            : job.employer_job_offer_date_available_hiring | date:'MM-dd-yyyy' }}
                                    </div>

                                </div>

                                <!-- Headers -->
                                <!-- Image, role and company name -->
                                <div class="d-flex align-items-center flex-grow-1 overflow-hidden gap-3">
                                        
                                    <div class="biz-image-container flex-shrink-0">
                                        <img 
                                            ng-src="{{ job.logo_url }}" 
                                            class="border border-secondary" 
                                            style="height: 50px; width: 50px; border-radius: 50%; object-fit: cover;" 
                                            alt="company-logo"
                                        >  
                                    </div>
                                    

                                    <div class="biz-info flex-grow-1 overflow-hidden w-100">                                                                         
                                        <h4 class="fw-bold m-0 p-0 text-truncate">{{job.employer_job_offer_job_title_preferred}}</h4>
                                        <small class="fw-normal text-secondary mt-0 text-truncate">{{job.business_name}}</small>
                                    </div>
                                    
                                    <div class="ms-auto flex-shrink-0">
                                        <p 
                                            style="font-size: 14px;" 
                                            class="text-white p-2 rounded text-center fw-bold m-0"
                                            ng-if="hasSearchedCourse || hasSearchedJob || hasSearchedProvince || hasSearchedCity"
                                            ng-style="{ 'background-color': getMatchColor(job.match_percentage) }"
                                        >
                                            {{ job.match_percentage }}% Match
                                        </p>
                                    </div>


                                
                                </div>
                    

                                <!-- Tags -->
                                <div class="mt-3 mb-2 d-flex align-items-start flex-wrap gap-2">

                                    <!-- Work Shift Tag -->
                                    <p class="rounded-pill tag p-1 px-2">
                                        <small>
                                            <i class="bi"
                                            ng-class="{
                                                'bi-cloud-sun-fill': job.employer_job_offer_shifting_schedule.toLowerCase() === 'day-shift',
                                                'bi-moon-stars-fill': job.employer_job_offer_shifting_schedule.toLowerCase() === 'night-shift',
                                                'bi-arrow-left-right': job.employer_job_offer_shifting_schedule.toLowerCase() === 'hybrid'
                                            }"></i>
                                            {{ job.employer_job_offer_shifting_schedule || 'N/A' }}
                                        </small>
                                    </p>

                                    <!-- Work Mode Tag -->
                                    <p class="rounded-pill tag p-1 px-2" ng-if="job.employer_job_offer_preferred_work_mode">
                                        <small>
                                            <i class="bi"
                                            ng-class="{
                                                'bi-building': job.employer_job_offer_preferred_work_mode.toLowerCase() === 'on-site',
                                                'bi-wifi': job.employer_job_offer_preferred_work_mode.toLowerCase() === 'remote',
                                                'bi-shuffle': job.employer_job_offer_preferred_work_mode.toLowerCase() === 'flexible'
                                            }"></i>
                                            {{ job.employer_job_offer_preferred_work_mode }}
                                        </small>
                                    </p>

                                    <!-- Allowance Tag -->
                                    <p 
                                        class="rounded-pill tag px-2" 
                                        ng-class="job.employer_job_offer_emp_provide_allowance === 'yes' ? 'bg-success text-white' : 'bg-secondary text-white'"
                                    >
                                        <small>
                                            <i class="bi bi-coin"></i>
                                            {{ job.employer_job_offer_emp_provide_allowance === 'yes' ? 'With Allowance' : 'No Allowance' }}
                                        </small>
                                    </p>

                                </div>

                    
                                <!-- Other business info -->
                                <p class="m-0" style="font-size: 15px;"><i class="bi bi-geo-alt-fill"></i>{{job.employer_job_offer_preferred_job_location_address}}</p>
                                <p class="m-0" style="font-size: 15px;"><i class="bi bi-mortarboard-fill"></i> {{job.employer_job_offer_emp_education}}</p>
                            </div>
                            
                            
                        </a>
                    </div>
                </div>
                
            </div>        

        </div>

    </div>





    

    




    

    <?php
    return ob_get_clean();
}


add_shortcode('home_page', 'home_page_landing_page');
