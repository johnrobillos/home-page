var app = angular.module('homeApp', ['ngStorage']);

app.run(function($timeout, $window, $rootScope) {

    $timeout(function () {
        const hash = window.location.hash;

        if (hash) {
            const id = hash.substring(1); // "news" from "#news"
            const el = document.getElementById(id);

            // Only call if function exists (ensures controller is loaded)
            if (typeof $rootScope.setActivePage === 'function') {
                $rootScope.setActivePage(id);
            }

            if (el) {
                const offset = el.offsetTop - 30; // adjust for fixed header
                $window.scrollTo({
                    top: offset,
                    behavior: 'smooth'
                });
            }
        }
    }, 1000); // Delay long enough to ensure DOM is ready
});

// Charls Added

app.controller('homeController', function($scope, $http, $timeout, $window, $rootScope, $sessionStorage, $document) {

    $scope.activePage = 'home'; // Default page
    $scope.showActivePage = 'contact';

    // Modal state for news post
    $scope.selectedNewsPost = null;

    $scope.selectedBlog = null;

    $scope.toggleBlogExpansion = function(blog) {
        $scope.selectedBlog = ($scope.selectedBlog === blog) ? null : blog;
    };

    $scope.isVideo = function(mediaUrl) {
        return mediaUrl && mediaUrl.match(/\.(mp4|webm|ogg)$/i);
    };

    $scope.scrollToTop = function() {
    $window.scrollTo({ top: 0, behavior: 'smooth' });
};

    // BLOGS
    $scope.blogs = [];

    $scope.fetchBlogs = function () {
        $http({
            method: 'POST',
            url: adminAjax.ajaxurl,
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            data: "action=fetch_database&post_type=blog"
        }).then(function (response) {
            const baseURL = window.location.origin + "/wp-content/uploads/icons/posting_portal/";

            // Filter only those with post_type === 'blog'
            const allPosts = response.data;
            $scope.blogs = allPosts
                .filter(blog => blog.post_type === 'blog')
                .map(blog => {
                    blog.blog_media = blog.blog_media.startsWith('http') ? blog.blog_media : baseURL + blog.blog_media;
                    return blog;
                });
        }, function (error) {
            console.error('Error fetching blogs:', error);
        });
    };

    // sequenced list of all categories by posted date
    $scope.getFilteredHighlights = function() {
        if ($scope.activeHighlight === 'all') {
            return $scope.allHighlights; // Already merged and sorted!
        }
        switch ($scope.activeHighlight) {
            case 'news': return $scope.newsPosts;
            case 'testimonial': return $scope.testimonialPosts;
            case 'facebook': return $scope.facebookPosts;
            case 'instagram': return $scope.instagramPosts;
            case 'tiktok': return $scope.tiktokPosts;
            default: return [];
        }
    };

    $scope.$watch('activePage', function(newVal) {
        if (newVal === 'highlights') {
            $scope.activeHighlight = 'all';
        }
    });


    $scope.selectedNewsPost = null;

    $scope.toggleNewsExpansion = function(post) {
        $scope.selectedNewsPost = ($scope.selectedNewsPost === post) ? null : post;
    };

    // NEWS
    $scope.newsPosts = [];

    $scope.fetchNews = function () {
        $http({
            method: 'POST',
            url: adminAjax.ajaxurl,
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            data: "action=fetch_database&post_type=news"
        }).then(function (response) {
            const baseURL = window.location.origin + "/wp-content/uploads/icons/posting_portal/";
            $scope.newsPosts = response.data.map(post => {

                post.blog_media = post.blog_media.startsWith('http') ? post.blog_media : baseURL + post.blog_media;
                return {
                    title: post.title_blog,
                    description: post.blog_description,
                    date: post.blog_date,
                    image: post.blog_media
                };
            });
            $scope.mergeAllHighlights(); // <-- add this here
        }, function (error) {
            console.error('Error fetching news:', error);
        });
    };

    // TESTIMONIALS
    $scope.testimonialPosts = [];

    $scope.fetchTestimonials = function () {
        $http({
            method: 'POST',
            url: adminAjax.ajaxurl,
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            data: "action=fetch_database&post_type=testimonial"
        }).then(function (response) {
            const baseURL = window.location.origin + "/wp-content/uploads/icons/posting_portal/";
            $scope.testimonialPosts = response.data.map(post => {

                post.blog_media = post.blog_media.startsWith('http') ? post.blog_media : baseURL + post.blog_media;
                return {
                    title: post.title_blog,
                    role: post.role,
                    description: post.blog_description,
                    date: post.blog_date,
                    image: post.blog_media,
                };
            });
            $scope.mergeAllHighlights();
        }, function (error) {
            console.error('Error fetching testimonials:', error);
        });
    };

    // FACEBOOK
    $scope.facebookPosts = [];
    $scope.fetchFacebook = function () {
        $http({
            method: 'POST',
            url: adminAjax.ajaxurl,
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            data: "action=fetch_database&post_type=facebook"
        }).then(function (response) {
            const baseURL = window.location.origin + "/wp-content/uploads/icons/posting_portal/";
            $scope.facebookPosts = response.data.map(post => {

                post.blog_media = post.blog_media && post.blog_media.startsWith('http') ? post.blog_media : baseURL + post.blog_media;
                return {
                    title: post.title_blog,
                    description: post.blog_description,
                    date: post.blog_date,
                    image: post.blog_media,
                    link: post.link
                };
            });
            $scope.mergeAllHighlights();
        }, function (error) {
            console.error('Error fetching Facebook posts:', error);
        });
    };

    // INSTAGRAM
    $scope.instagramPosts = [];
    $scope.fetchInstagram = function () {
        $http({
            method: 'POST',
            url: adminAjax.ajaxurl,
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            data: "action=fetch_database&post_type=instagram"
        }).then(function (response) {
            const baseURL = window.location.origin + "/wp-content/uploads/icons/posting_portal/";
            $scope.instagramPosts = response.data.map(post => {
        
                post.blog_media = post.blog_media && post.blog_media.startsWith('http') ? post.blog_media : baseURL + post.blog_media;
                return {
                    title: post.title_blog,
                    description: post.blog_description,
                    date: post.blog_date,
                    image: post.blog_media,
                    link: post.link
                };
            });
            $scope.mergeAllHighlights();
        }, function (error) {
            console.error('Error fetching Instagram posts:', error);
        });
    };


    // TIKTOK
    $scope.tiktokPosts = [];
    $scope.fetchTikTok = function () {
        $http({
            method: 'POST',
            url: adminAjax.ajaxurl,
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            data: "action=fetch_database&post_type=tiktok"
        }).then(function (response) {
            const baseURL = window.location.origin + "/wp-content/uploads/icons/posting_portal/";
            $scope.tiktokPosts = response.data.map(post => {

                post.blog_media = post.blog_media && post.blog_media.startsWith('http') ? post.blog_media : baseURL + post.blog_media;
                return {
                    title: post.title_blog,
                    description: post.blog_description,
                    date: post.blog_date,
                    image: post.blog_media,
                    link: post.link
                };
            });
            $scope.mergeAllHighlights();
        }, function (error) {
            console.error('Error fetching TikTok posts:', error);
        });
    };

    $scope.mergeAllHighlights = function () {
        $scope.allHighlights = [].concat(
            ($scope.newsPosts || []).map(post => ({ ...post, type: 'news' })),
            ($scope.testimonialPosts || []).map(post => ({ ...post, type: 'testimonial' })),
            ($scope.facebookPosts || []).map(post => ({ ...post, type: 'facebook' })),
            ($scope.instagramPosts || []).map(post => ({ ...post, type: 'instagram' })),
            ($scope.tiktokPosts || []).map(post => ({ ...post, type: 'tiktok' }))
        );
        $scope.allHighlights.sort(function (a, b) {
            return new Date(b.date) - new Date(a.date);
        });
    };

    // AUTO-LOAD on controller init
    $scope.fetchBlogs();
    $scope.fetchNews();
    $scope.fetchTestimonials(); // Add this
    $scope.fetchFacebook();
    $scope.fetchInstagram();
    $scope.fetchTikTok();
          
      $scope.credentials = {
        username: '',
        password: ''

    };

controllerAs: 'vm',


$scope.showPage = function(page) {
    $scope.currentPage = page; // Correctly assign the page name passed to the function
};

    $scope.scrollToSection = function(sectionId) {
        var element = document.getElementById(sectionId);
        if (element) {
            setTimeout(function() {
                $window.scrollTo({
                    top: element.offsetTop - 30, // Optional: Add offset to adjust for header height
                    behavior: "smooth" // Smooth scrolling
                });
            }, 100); // Add a timeout of 100ms
        }
    };

// Navigation handler
$scope.setActivePage = function(page) {
    $scope.activePage = page;


    // Smooth scroll to top
    $timeout(function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }, 0);
};

// Expose it globally so `app.run` can call it
$rootScope.setActivePage = $scope.setActivePage;


    $scope.$watch('activePage', function(newVal, oldVal) {
        if (newVal !== oldVal) {
            // Scroll to top after view changes
            // setTimeout(function() {
            //     window.scrollTo({
            //         top: 0,
            //         behavior: 'smooth'
            //     });
            // }, 100); // delay ensures DOM is ready
        }
    });

        // Show the rest of the team
        $scope.showAllTeam = false;

$scope.toggleTeamVisibility = function () {
  $scope.showAllTeam = !$scope.showAllTeam;
};

// Hide hidden team on section change
$scope.$on('$locationChangeStart', function () {
  $scope.showAllTeam = false;
});
        // Our Values Section Lottie Animations
        // Fast Lottie Animation
        var fastLottie = lottie.loadAnimation({
            container: document.getElementById('fast'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: "/wp-content/uploads/lottie/fast.json"
        });

        // Seamless Lottie Animation
        var seamlessLottie = lottie.loadAnimation({
            container: document.getElementById('seamless'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: "/wp-content/uploads/lottie/seamless.json"
        });

        // Empower Lottie Animation
        var empowerLottie = lottie.loadAnimation({
            container: document.getElementById('empower'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: "/wp-content/uploads/lottie/empower.json"
        });

        // Grow Lottie Animation
        var growLottie = lottie.loadAnimation({
            container: document.getElementById('grow'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: "/wp-content/uploads/lottie/Grow.json"
        });

        // teamwork lottie
        var emp_details = lottie.loadAnimation({
            container: $("#teamwork_2")[0],
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: "/wp-content/uploads/lottie/teamwork_2.json"
        });

        // line lottie
        var line = lottie.loadAnimation({
            container: $("#line")[0], 
            renderer: 'svg', 
            loop: true, 
            autoplay: true, 
            path: "/wp-content/uploads/lottie/line.json"
        });
        

        // virutal lottie
        jQuery(document).ready(function($) {
        var virtual_lottie = lottie.loadAnimation({
         container: $("#virtual")[0],
         renderer: 'svg',
         loop: true,
         autoplay: true,
         path: "/wp-content/uploads/lottie/virtual_job.json"
    });
 });
        // // magnifying lottie
        var magnify_lottie = lottie.loadAnimation({
            container: $("#magnify-job-lottie")[0], // HTML container element
            renderer: 'svg', // Render as SVG
            loop: true, // Animation should loop
            autoplay: true, // Start playing automatically
            path: "/wp-content/uploads/lottie/magnify.json" // Path to your Lottie JSON file
        });

        // how # 1 Lottie
        var step1 = lottie.loadAnimation({
            container: $("#step1")[0], // HTML container element
            renderer: 'svg', // Render as SVG
            loop: true, // Animation should loop
            autoplay: true, // Start playing automatically
            path: "/wp-content/uploads/lottie/step1.json" // Path to your Lottie JSON file
        });

        // how # 2 Lottie
        var step2 = lottie.loadAnimation({
            container: $("#step2")[0], // HTML container element
            renderer: 'svg', // Render as SVG
            loop: true, // Animation should loop
            autoplay: true, // Start playing automatically
            path: "/wp-content/uploads/lottie/step2.json" // Path to your Lottie JSON file
        });

        // how # 3 Lottie
        var step3 = lottie.loadAnimation({
            container: $("#step3")[0], // HTML container element
            renderer: 'svg', // Render as SVG
            loop: true, // Animation should loop
            autoplay: true, // Start playing automatically
            path: "/wp-content/uploads/lottie/step3.json" // Path to your Lottie JSON file
        });

        // how # 4 Lottie
        var step4 = lottie.loadAnimation({
            container: $("#step4")[0], // HTML container element
            renderer: 'svg', // Render as SVG
            loop: true, // Animation should loop
            autoplay: true, // Start playing automatically
            path: "/wp-content/uploads/lottie/step4.json" // Path to your Lottie JSON file
        });

        // person lottie
        var rocket_lottie = lottie.loadAnimation({
            container: $("#rocket-lottie")[0], // HTML container element
            renderer: 'svg', // Render as SVG
            loop: true, // Animation should loop
            autoplay: true, // Start playing automatically
            path: "/wp-content/uploads/lottie/workforce_colored.json" // Path to your Lottie JSON file
        });

        $scope.credentials = {
            username: '',
            password: ''
        };

        // Mobile navbar collapse
        // Automatically collapse navbar on mobile when any nav-link is clicked
        document.querySelectorAll('.navbar-nav .nav-link, .navbar-nav .dropdown-item, .navbar-btn').forEach(function (el) {
            el.addEventListener('click', function (e) {
                // Skip collapse if it's a dropdown toggle (e.g., About, Policy)
                if (el.classList.contains('dropdown-toggle')) {
                    return;
                }
        
                const collapseElement = document.getElementById('navbarSupportedContent');
                const bsCollapse = bootstrap.Collapse.getInstance(collapseElement);
        
                // Collapse only if it's currently shown
                if (bsCollapse && collapseElement.classList.contains('show')) {
                    bsCollapse.hide();
                }
            });
        });

        // Close the navbar when clicking outside of it
        document.addEventListener('click', function (event) {
            const navbar = document.getElementById('navbarSupportedContent');
            const toggler = document.querySelector('.navbar-toggler');
        
            const isNavbarOpen = navbar.classList.contains('show');
        
            if (
                isNavbarOpen &&
                !navbar.contains(event.target) &&
                !toggler.contains(event.target)
            ) {
                const bsCollapse = bootstrap.Collapse.getInstance(navbar);
                if (bsCollapse) {
                    bsCollapse.hide();
                }
            }
        });

// AngularJS controller logic
$scope.selectedNews = null;
$scope.showFullNewsPage = false;

// Open full news view
// $scope.openFullNews = function(news) {
//   $scope.selectedNews = news;
//   $scope.showFullNewsPage = true;

  // Scroll to full-news-section after DOM update
//   $timeout(function () {
//     var el = document.getElementById("full-news-section");
//     if (el) {
//       el.scrollIntoView({ behavior: "auto", block: "start" });
//     }
//   }, 100); // Adjust delay if necessary
// };


// Close full news view
$scope.closeFullNews = function() {
  $scope.selectedNews = null;
  $scope.showFullNewsPage = false;
};

// toggle faq tab
$scope.toggleFaq = function (faqList, index) {
    if (!faqList || !Array.isArray(faqList)) return;

    faqList.forEach((faq, i) => {
        faq.open = (i === index) ? !faq.open : false;
    });
};

$scope.$watch('faqTab', function (newTab) {
    if (newTab === 'ojtgo') {
        $scope.ojtgoFaqs.forEach(faq => faq.open = false);
    } else if (newTab === 'student') {
        $scope.studentFaqs.forEach(faq => faq.open = false);
    } else if (newTab === 'employer') {
        $scope.employerFaqs.forEach(faq => faq.open = false);
    }
});

// FAQ's
$scope.faqTab = 'ojtgo';

// for OJTGo FAQs
$scope.ojtgoFaqs = [

    {
    question: "What is Hirebilis?",
    answer: {
      paragraph: "Hirebilis is a digital job-matching platform built to simplify job searching in the Philippines. It connects job seekers with companies based on their location, skills, and preferences. With an easy-to-use interface and smart matching system, Hirebilis helps applicants find relevant job opportunities quickly and efficiently."
    },
    open: false
  },
  {
    question: "How does Hirebilis work?",
    answer: {
      paragraph: "Hirebilis allows job seekers to create a professional profile and search for job opportunities posted by employers. The system automatically matches applicants to job openings that fit their background and location. Employers can then review applications, reach out to qualified candidates, and proceed with the hiring process—all within the platform."
    },
    open: false
  },
  {
    question: "Who can use Hirebilis?",
    answer: {
      paragraph: "Anyone looking for a job in the Philippines can use Hirebilis, whether you're a fresh graduate or someone with years of experience. Employers from various industries also use the platform to find qualified candidates. It's designed to make job searching and hiring more accessible, reliable, and stress-free."
    },
    open: false
  },
  {
    question: "Is Hirebilis a legitimate platform?",
    answer: {
      paragraph: "Yes, Hirebilis is a secure and verified job-matching platform developed by a trusted organization. All employers are screened before they can post job listings to ensure the authenticity and safety of every opportunity. Our goal is to provide a reliable space for applicants and employers to connect meaningfully."
    },
    open: false
  },
  {
    question: "What makes Hirebilis different from other job portals?",
    answer: {
      paragraph: "Hirebilis is locally built with the specific needs of Filipino job seekers and employers in mind. It emphasizes fast, accurate matching based on skillsets, location, and job type. The platform offers a user-friendly experience for both sides, removing the usual complexity and delays found in traditional job search processes."
    },
    open: false
  }
];
  
// for Student FAQs
$scope.studentFaqs = [

    {
    question: "How can I find a job using Hirebilis?",
    answer: {
      paragraph: "To find a job, simply create a profile on Hirebilis and complete your personal and professional details. Once set up, the platform will automatically show you job openings that match your background and preferences. You can apply directly through the platform and wait for employers to contact you."
    },
    open: false
  },
  {
    question: "Do I need to pay to apply for jobs on Hirebilis?",
    answer: {
      paragraph: "No, applying for jobs on Hirebilis is completely free. The platform is designed to help applicants find jobs without any hidden fees or charges. You can apply to multiple job posts, manage your applications, and communicate with employers at no cost."
    },
    open: false
  },
  {
    question: "How will I know if an employer is interested in my application?",
    answer: {
      paragraph: "Once you apply for a job, you’ll be notified if the employer views your profile or decides to contact you. You’ll also receive updates on the status of your application through your dashboard or email notifications."
    },
    open: false
  },
  {
    question: "Can I update my resume or profile after signing up?",
    answer: {
      paragraph: "Yes, you can edit your profile anytime after registration. It’s recommended to keep your information updated, especially when you gain new experience, skills, or certifications, to improve your chances of getting matched with the right opportunities."
    },
    open: false
  },
  {
    question: "What should I do if I don’t get hired right away?",
    answer: {
      paragraph: "Finding the right job may take time, and that's okay. Keep your profile updated, regularly check new job posts, and apply to roles that match your qualifications. Stay active on the platform, and you’ll increase your chances of getting hired."
    },
    open: false
  },
  {
    question: "Is there a limit to how many jobs I can apply for?",
    answer: {
      paragraph: "No, there’s no limit. You can apply to as many job postings as you like. However, it's best to apply only to jobs that match your skills and interests for a better chance of getting hired."
    },
    open: false
  },
  {
    question: "Will employers see my contact details right away?",
    answer: {
      paragraph: "Employers can only access your contact details after reviewing your application. Your information is kept secure and is only shared with potential employers who are genuinely interested in your profile."
    },
    open: false
  }
];

// for Employer FAQs  
$scope.employerFaqs = [
    {
    question: "How do I post a job on Hirebilis?",
    answer: {
      paragraph: "To post a job, register as an employer and complete your company profile. Once registered, you can create job listings by providing the role details, qualifications, and other requirements. After posting, you can immediately start receiving applications from qualified job seekers."
    },
    open: false
  },
  {
    question: "How does Hirebilis help in finding the right candidate?",
    answer: {
      paragraph: "Hirebilis uses a smart matching system that filters applicants based on your job requirements, such as skills, location, and experience. This helps you quickly find candidates who are most suited for the position, saving time and improving the quality of hires."
    },
    open: false
  },
  {
    question: "Can I contact applicants directly through the platform?",
    answer: {
      paragraph: "Yes, employers can directly message applicants through the built-in communication system. This makes it easy to schedule interviews, ask questions, or provide updates about the hiring process without leaving the platform."
    },
    open: false
  },
  {
    question: "Do I need to pay to use Hirebilis as an employer?",
    answer: {
      paragraph: "Hirebilis offers a free tier for employers to post jobs and access applicant profiles. Optional premium services may be available in the future for advanced features, but core job posting and applicant communication remain free."
    },
    open: false
  },
  {
    question: "Is there a limit to how many job posts I can create?",
    answer: {
      paragraph: "Currently, you can create multiple job posts without restrictions. However, to maintain quality, all job listings are subject to review and approval by the Hirebilis admin team before going live."
    },
    open: false
  },
  {
    question: "How do I know if an applicant is qualified?",
    answer: {
      paragraph: "Each applicant profile includes detailed information such as skills, experience, and educational background. You can also view uploaded resumes and use filters to shortlist candidates based on your specific requirements."
    },
    open: false
  },
  {
    question: "Can I edit a job posting after it's been published?",
    answer: {
      paragraph: "Yes, you can update your job postings anytime from your employer dashboard. Changes will be reviewed to ensure quality and compliance before being reflected publicly."
    },
    open: false
  }
];

    // added by lorenzo @ 04/25/2025

    // Used as a stopper for clicks for every submitting buttons
    $scope.isCreating = false;

    // For reseting value
    $scope.resetModalFields = function () {
    
        // Credentials
        $scope.credentials = {
            username: '',
            email: '',
            password: ''
        };
    
        // Forgot Password Flow
        $scope.accountEmail = '';
        $scope.otpCode = '';
        $scope.passRecoveryOtp = '';
        $scope.forgotPass = {
            password: '',
            confirmPass: ''
        };
    
        // Reset password visibility toggles
        $scope.isLogPasswordVisible = false;
        $scope.isNewPassVisible = false;
        $scope.isConfirmPassVisible = false;
        $scope.isRegPasswordVisible = false;
    
        // Clear validation errors
        $scope.usernameValid = true;
        $scope.usernameError = '';
        $scope.emailValid = true;
        $scope.emailError = '';
        $scope.passwordValid = false;
        $scope.passChecks = {};
    
    };

    // Modified by Lorenzo @ 04/25/2025
    $scope.loginUser = function() {
        if ($scope.isCreating) return; // Prevent multiple calls/spam click
        $scope.isCreating = true;

        if (!$scope.credentials.username || !$scope.credentials.password) {
            Swal.fire({
                title: "Error",
                text: "Please enter both username and password.",
                icon: "error",
                timer: 1500,
                timerProgressBar: true,
                showConfirmButton: false,                
                returnFocus: false,              // prevents re-focusing the previous button
                allowOutsideClick: false
            });

            $scope.isCreating = false;
            return;
        }
    
        $http.post(adminAjax.ajaxurl, $.param({
            action: 'login_backend',
            data: $.param($scope.credentials),
            security: adminAjax.nonce
        }), {
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function(response) {
    
            // Fix: Ensure response format is correctly handled
            let responseData = response.data.data ? response.data.data : response.data;
    

            if (responseData.success || response.data.success) {

                // added by Lorenzo @ 04/07/2025
                $scope.isModalActive = false;       // close modal if login successful

                Swal.fire({
                    title: 'Login Successful!',
                    text: 'Redirecting to your dashboard...',
                    icon: 'success',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    returnFocus: false,              // prevents re-focusing the previous button
                    didClose: () => {
                        if (responseData.redirect) {
                            window.location.href = responseData.redirect;
                        } else {
                            Swal.fire("Error", "Redirect URL missing. Please contact support.", "error");
                        }
                    }
                });


                // added by Lorenzo @ 04/25/2025
                $timeout(function () {
                    document.activeElement.blur(); // removes focus on the button
                });

                $timeout(function () {
                    $scope.isCreating = false;          // Reset to false after process is finished
                }, 2000);

            } else {
                Swal.fire("Login Failed", responseData.message || "Invalid credentials.", "error");
            
                $scope.isCreating = false;          // Reset to false after process is finished
            }
        }, function(error) {
            Swal.fire("Error", "An error occurred while logging in.", "error");
        
            $scope.isCreating = false;          // Reset to false after process is finished
        });
    };      
    
     $document.on('keydown', function(event) {
        if (event.key !== 'Enter') return;
    
        $scope.$apply(function() {
            switch($scope.currentModalContent) {
                case 'login':
                    $scope.loginUser();
                    break;
                case 'register':
                    $scope.storeCredentials();
                    break;
                case 'verify':
                    $scope.verifyAndProceed('register');
                    break;
                case 'forgot-pass':
                    $scope.sendForgotPassword();
                    break;  
                case 'verify-forgot-pass':
                    $scope.verifyAndProceed('pass-recovery');
                    break;   
                case 'change-pass':
                    $scope.changePassword();
                    break;                         
                    
            }
        });
    });


    // Optional: Clean up when controller is destroyed
    $scope.$on('$destroy', function() {
        $document.off('keydown');
    });    
    

    // Code Migrated @ 04/07/2025
    
    // John Code for Register


    // openLoginModalNavReg modified (at Lorenzo code)
    // modified by Lorenzo @ 04/02/2025
    $scope.setUserType = function(userType) {
        
        
        if ($sessionStorage.userCredentials) {
            delete $sessionStorage.userCredentials;
        }
  
        // Store user type
        $scope.userType = userType;
        $scope.credentials.role  = userType;
        

        // Modification
        // Animate from confirm user to register form
        $scope.openRegisterModalDirect();
        
    };

    // Added by Lorenzo @ 04/25/2025
    // Validate OTP input
    $scope.validateOtp = function(target) {
        // Prevent non-numeric input and limit input to 6 digits only
        $scope[target] = $scope[target].replace(/\D/g, '').substring(0, 6);
    }

    // proceedToVerification modified (at lorenzo code)
    
    // Modified by Lorenzo @ 04/22/2025 - Migrated @ 04/23/2025
    // Verify Registration OTP and Forgot Password OTP
    $scope.verifyAndProceed = function(target) {
        
        if ($scope.isCreating) return; // Prevent multiple calls/spam click
        $scope.isCreating = true;
    
        if (target === "register") {            // Verification - registration
            var enteredOtp = $scope.otpCode;
            var email = $sessionStorage.emailForOtp;
        
            if (!enteredOtp || enteredOtp.trim() === '') {
                
                Swal.fire({
                    icon: 'warning',
                    title: 'Missing 6 Digit Code',
                    text: 'Please enter the OTP code you received in your email',
                    timer: 1500,
                    timerProgressBar: true,
                    showConfirmButton: false,                
                    returnFocus: false,              // prevents re-focusing the previous button
                    allowOutsideClick: true
                });    
                      
                $scope.isCreating = false; // Reset to allow retry
                return;
            }

            if (!email) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Missing Email',
                    text: 'Session expired. Please start registration again',
                    timer: 1500,
                    timerProgressBar: true,
                    showConfirmButton: false,                
                    returnFocus: false,              // prevents re-focusing the previous button
                    allowOutsideClick: true
                });   
                
                $scope.isCreating = false; // Reset to allow retry
                return;
            }        
        
            $http.post('/wp-json/myplugin/v1/validate_otp/', {
                email: email,
                otp: enteredOtp
            }).then(function(response) {
                
                    const data = response.data;
                
                    if (data.success === false) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid OTP',
                            text: data.message || 'Please check the OTP and try again.',
                            timer: 1500,
                            timerProgressBar: true,
                            showConfirmButton: false,
                            returnFocus: false,
                            allowOutsideClick: true
                        });
                
                        $scope.isCreating = false;
                        return;
                    }                
                
                // Clear OTP email after successful verification
                 delete $sessionStorage.emailForOtp;

                // Hide the modal before redirecting
                $scope.isModalActive = false;

                Swal.fire({
                    title: 'OTP Verified!',
                    text: 'You will be redirected to your dashboard shortly.',
                    icon: 'success',
                    timer: 1500,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    returnFocus: false,          // prevents re-focusing the previous button
                    willClose: () => {
                        // Redirect based on user type
                        if ($scope.userType === 'employer') {
                            $scope.redirectToPageEmployer();
                        } else {
                            $scope.redirectToPage();
                        }
                    }
                });
            
                $timeout(function () {
                    document.activeElement.blur(); // removes focus on the button
                });

                $timeout(function () {
                    $scope.isCreating = false;          // Reset to false after process is finished
                }, 1500);
        
            }).catch(function(error) {
            
                const message = error?.data?.message || 'OTP is incorrect or expired.';
            
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid OTP',
                    text: message,
                    timer: 1500,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    returnFocus: false,
                    allowOutsideClick: true
                });                

               $scope.isCreating = false;          // Reset to false after process is finished
            });

        } 
        else if (target === "pass-recovery") {
            /************* Millard Code  Added 4-22 *************/

            var email = $sessionStorage.resetEmail;
            var enteredOtp = $scope.passRecoveryOtp;
        
            if (!email) {
                Swal.fire({
                title: "Missing Email",
                text: "Email session is missing. Please start password recovery again.",
                icon: "warning",
                timer: 1500,
                timerProgressBar: true,
                showConfirmButton: false,                
                returnFocus: false,              // prevents re-focusing the previous button
                allowOutsideClick: false
                });
                
                $scope.isCreating = false; // Reset to allow retry
                return;
            }
            
            if (!enteredOtp || enteredOtp.trim() === '') {
                Swal.fire({
                title: "Missing Code",
                text: "Please enter the OTP code you received in your email.",
                icon: "warning",
                timer: 1500,
                timerProgressBar: true,
                showConfirmButton: false,                
                returnFocus: false,              // prevents re-focusing the previous button
                allowOutsideClick: false
                });                
                $scope.isCreating = false; // Reset to allow retry
                return;
            }
                   
            $http.post('/wp-json/myplugin/v1/validate_otp_forgot/', {
                email: email,
                otp: enteredOtp
            }).then(function(response) {
                
                const data = response.data;
                
                if (data.success === false) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid OTP',
                        text: data.message || 'Please check the OTP and try again.',
                        timer: 1500,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        returnFocus: false,
                        allowOutsideClick: true
                    });
            
                    $scope.isCreating = false;
                    return;
                }                      
                
              Swal.fire({
                    title: 'Success!',
                    text: 'OTP verified. You may now change your password.',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    returnFocus: false          // prevents re-focusing the previous button
                }).then(function () {
                    
                    
                    $timeout(function () {
                        // Clear OTP email after successful verification
                        delete $sessionStorage.emailForOtp;
                        $scope.switchModalContent('change-pass'); // Open change password modal
                    }, 300);
                });

                $timeout(function () {
                    document.activeElement.blur(); // removes focus on the button
                });

                $scope.isCreating = false;          // Reset to false after process is finished
          
            }).catch(function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid OTP',
                    text: error.data.message || 'OTP is incorrect or expired.',
                    timer: 1500,
                    timerProgressBar: true,
                    showConfirmButton: false,                
                    returnFocus: false,              // prevents re-focusing the previous button
                    allowOutsideClick: false
                });                


                $scope.isCreating = false;          // Reset to false after process is finished
            });
          
            /************* End Millard Code  Added 4-22 *************/
        }

    };
    

    // Handle password visibility state
    $scope.isRegPasswordVisible = false;
    $scope.isLogPasswordVisible = false;
    $scope.isNewPassVisible = false;            // added by Lorenzo @ 04/24/2025
    $scope.isConfirmPassVisible = false;        // added by Lorenzo @ 04/24/2025

    $scope.togglePasswordVisibility = function (target) {
        $scope[target] = !$scope[target];        
    };
    

    //Sir Jess Angular // 


    $scope.redirectToPage = function() {
        window.location.href = "/registration";
    };
    
    $scope.redirectToPageEmployer = function() {
        window.location.href = "/registration-employer";
    };


    var secretKey = adminAjax.secretKey; // Must match encryption key

    // Function to encrypt data
    function encryptData(data) {
        return CryptoJS.AES.encrypt(JSON.stringify(data), secretKey).toString();
    }
    
    // Code Migrated @ 04/07/2025

    // added code by Lorenzo @ 04/10/2025
    //      - Limit create account button click to one
    //      - Prevent breaking of login/register modal UI


    // Modified by Lorenzo @ 04/02/2025
    $scope.storeCredentials = function() {
        if ($scope.isCreating) return; // Prevent multiple calls/spam click
        if ($scope.isFormInvalid() || !$scope.passwordValid || !$scope.usernameValid) return;// Prevent action        
        $scope.isCreating = true;

        var userData = {
            username: $scope.credentials.username,
            email: $scope.credentials.email,
            password: $scope.credentials.password,
            role: $scope.credentials.role 
        };
    
        // Encrypt before storing
        var encryptedData = encryptData(userData);
        // Store in rootScope and sessionStorage
        $rootScope.userCredentials = encryptedData;
        $sessionStorage.userCredentials = encryptedData;
    
        // Store raw email separately for OTP operations
        $sessionStorage.emailForOtp = userData.email;

        // Send OTP
        $http.post('/wp-json/myplugin/v1/send_otp/', {
            email: userData.email,
             type: 'register'
        }).then(function (response) {
            
            if (response.data.success === false) {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed to Send OTP',
                    text: response.data.message,
                    confirmButtonColor: '#d33'
                });
        
                $scope.isCreating = false;
                return;
            }       
        
            Swal.fire({
                icon: 'success',
                title: 'OTP Sent Successfully!',
                text: 'A 6-digit OTP has been sent to your email.',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                returnFocus: false // prevents re-focusing the previous button
            }).then(() => {
                // Use timeout to force proper DOM repaint in Firefox
                $timeout(() => {
                    // Open OTP modal
                    $scope.switchModalContent('verify');
                    // Start cooldown (3 minutes)
                    $scope.startOtpCooldown(180);

                    $timeout(function () {
                        document.activeElement.blur(); // removes focus
                    });

                    $scope.isCreating = false;      // re-enable create account button
                }, 50); // 50ms is enough

            });

        }).catch(function (error) {

            Swal.fire({
                icon: 'error',
                title: 'Failed to Send OTP',
                text: error.data.message || "Something went wrong. Please try again.",
                confirmButtonColor: '#d33'
            });
            $scope.isCreating = false; // Re-enable button on failure
        });    
        
    };
        /************* Millard Code Added 4-25  ************/

    $scope.resendRegistrationOtp = function () {
        const email = $sessionStorage.emailForOtp;

    
        if (!email) {
            Swal.fire('Missing Email', 'Email session is missing. Please restart registration.', 'warning');
            return;
        }
    
        if ($scope.otpCooldown) {
            Swal.fire('Please Wait', `You can resend the OTP after ${$scope.otpCooldownSeconds} seconds.`, 'info');
            return;
        }
    
        $http.post('/wp-json/myplugin/v1/send_otp/', {
            email: email,
            type: 'register'
        }).then(function (response) {
            Swal.fire({
                icon: 'success',
                title: 'OTP Resent',
                text: 'A new OTP has been sent to your email.',
                timer: 1500,
                showConfirmButton: false
            });
    
            // Restart cooldown
            $scope.startOtpCooldown(180);
    
        }).catch(function (error) {
            Swal.fire({
                icon: 'error',
                title: 'Failed to Resend OTP',
                text: error.data.message || 'Please try again later.',
                confirmButtonColor: '#d33'
            });
        });
    };
        /************* End Millard Code Added 4-25  ************/

    $scope.submit_reg = function() {
    
        Swal.fire({
            title: 'Registration Successful!',
            text: 'You will be redirected to your dashboard.',
            icon: 'success',
            confirmButtonText: 'Ok'
        });
    
    }

    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            $('.selectize').selectize();
        }, 500); // Ensures Selectize initializes after data loads
    });
    
    // Debounce function to delay logging
    function debounce(func, wait) {
        let timeout;
        return function() {
            let context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }
    
    // for tracking inputs and it will console.log it 
    // Function to log changes with debounce
    $scope.logChange = debounce(function(field, value) {
        // console.log(`Updated ${field}:`, value);
    }, 500); // 500ms delay
    
    //Validations Code start here Added Millard 03/12 ??//

    //Credentials Validation Function

    $scope.credentials = {
        username: "",
        email: "",
        password: "",
        role: ""
    };

    // Code Migrated @ 04/11/2025
    // Modified by Lorenzo @ 04/11/2025
    $scope.usernameValid = true;
    
    // Username Validation (Only letters, numbers, underscores, and dots)
    $scope.validateUsername = function () {
        if (!$scope.credentials || $scope.credentials.username === '' || $scope.credentials.username === null) {
            $scope.usernameError = "Username is required.";
            $scope.usernameValid = false;
            
            return;
        };
        
        const lengthValid = $scope.credentials.username.length >= 4 && $scope.credentials.username.length <= 20;
        if (!lengthValid) {
            $scope.usernameError = "Username must be 4-20 characters";
            $scope.usernameValid = false;          

            return;
        };

        const regex = /^[a-zA-Z0-9_.]+$/
        if (!regex.test($scope.credentials.username)) {
            $scope.usernameError = " Username only accepts letters, numbers, \n underscores, or dots.";
            $scope.usernameValid = false;       

            return;
        };

        $http({
            method: 'POST',
            url: adminAjax.ajaxurl,
            data: $.param({
                action: 'check_username_exists',
                username: $scope.credentials.username
            }),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function (response) {

            if (response.data.success && response.data.data.exists) {
                $scope.usernameError = "Username is already taken.";
                $scope.usernameValid = false;
            } else {
                $scope.usernameError = "";
                $scope.usernameValid = true;
            }
            
        }, function (error) {

            $scope.usernameError = "Error checking username.";
            $scope.usernameValid = false;
        });
    };

    // Modified by Lorenzo @ 04/11/2025  

    $scope.emailValid = true;          // Temporary Fix    
    // Email Validation
    $scope.validateEmail = function () {
        
        if (!$scope.credentials || $scope.credentials.email === '') {
            $scope.emailError = "Email is required.";
            $scope.emailValid = false;          // initiallize value

            return;
        };
        
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!regex.test($scope.credentials.email)) {
            $scope.emailError = "Invalid email format.";
            $scope.emailValid = false;          // initiallize value

            return;
        };
            
        // Format is valid, now check if email already exists in the WP database
        
        $scope.emailError = "";

        $http({
            method: 'POST',
            url: adminAjax.ajaxurl,
            data: $.param({
                action: 'check_email_exists',
                email: $scope.credentials.email
            }),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function (response) {


            if (response.data.success && response.data.data.exists) {
                $scope.emailError = "Email is already registered.";
                $scope.emailValid = false;
            } else {
                $scope.emailValid = true;       // Email is now valid
                $scope.emailError = "";
            }

            
        }, function (error) {
            $scope.emailError = "Error checking email.";
            $scope.emailValid = false;
        });
    };

    // Modified by Lorenzo @ 04/11/2025
    // Create separate checking for each 
    // password requirements

    // Check specific password requirements
    $scope.passChecks = {
        length: false,
        upper: false,
        lower: false,
        number: false,
        special: false,
        matched: false      // Added by Lorenzo @ 04/12/2025
    };

    $scope.passwordValid = false;

    //  Password Validation
    $scope.validatePassword = function (target) {

        let pwd = $scope[target].password || '';
        $scope.passChecks.length = pwd.length >= 8;
        $scope.passChecks.upper = /[A-Z]/.test(pwd);
        $scope.passChecks.lower = /[a-z]/.test(pwd);
        $scope.passChecks.number = /[0-9]/.test(pwd);
        $scope.passChecks.special = /[\W_]/.test(pwd);

        // Added by Lorenzo @ 04/12/2025
        // Modified by Lorenzo @ 04/25/2025
        if (target === "forgotPass") { 
            $scope.passChecks.matched = $scope.forgotPass.password === $scope.forgotPass.confirmPass;
        } else {
            $scope.passChecks.matched = true;       // always to true for registration password input
        }

        $scope.passwordValid = Object.values($scope.passChecks).every(Boolean);

    };


    // Function to check form validity
    $scope.isFormInvalid = function () {
        return !$scope.credentials.username || !$scope.credentials.email || !$scope.credentials.password ||
            $scope.usernameError || $scope.emailError || !$scope.passwordValid;
    };

    // goToNextPage removed by lorenzo

    // Validations Code end here Added Millard 03/12 ??//
    
    // Check Login Status --- John 18/03
    // Check Login Status --- Updated __--Milalrd 04/15

    $scope.isInitialized = false;
    $scope.isLoggedIn = false;

    // Fetch login status from WordPress
    $http.get(window.location.origin + "/wp-admin/admin-ajax.php?action=check_login_status")
        .then(function(response) {
            if (response.data && response.data.success) {
                $scope.apiUrl = response.data.data.api_url;
                $scope.userRole = response.data.data.role;
                $scope.isLoggedIn = true; // Not logged in
                // Auto-redirect based on role
                if ($scope.userRole === 'applicant') {
                     $scope.dashboardUrl = '/app-dashboard';
                } else if ($scope.userRole === 'employer') {
                    $scope.dashboardUrl = '/emp-dashboard';
                }

            } else {
                throw new Error("Invalid API URL response");
            }
        })
        .catch(function() {
            $scope.isLoggedIn = false; // Not logged in
        })
        .finally(function() {
            $scope.isInitialized = true; // Angular ready
        });

    
    $scope.homeUrl = ""; // Store the WordPress home URL
    $scope.currentPath = window.location.pathname; // Get current page path
    
    // Fetch WordPress Home URL dynamically
    $http.get(window.location.origin + "/wp-admin/admin-ajax.php?action=get_home_url")
        .then(function(response) {
            if (response.data && response.data.success) {
                $scope.homeUrl = response.data.data.home_url; // Save Home URL
            }
        })
        .catch(function() {});
    
    // Function to navigate and update active class
    $scope.goTo = function(path) {
        if ($scope.homeUrl) {
            let fullUrl = $scope.homeUrl + path;
            window.location.href = fullUrl;
        }
    };
    
    // Function to check if a menu item is active
    $scope.isActive = function(path) {
        let currentPath = window.location.pathname.replace(/\/$/, ""); // Remove trailing slash
        let checkPath = path.replace(/\/$/, ""); // Ensure consistency
    
        return currentPath === checkPath ? "active" : "";
    };

    // Code Migrated @ 04/07/2025
    /************* Lorenzo Code *************/

    // !!! Login/register modal animation

    // Modal visibility state
    $scope.isModalActive = false;

    // Which modal content is showing: 
    //      'login', 'register', 'verify', 'user-type, forgot-pass, verify-forgot-pass, or change-pass'
    $scope.currentModalContent = null;

    // Apply animation to slide in the modal and section
    $scope.toggleModal = function () {
        $scope.currentModalContent = null;
        $timeout(() => {
            $scope.resetModalFields();          // Reset data on close
        }, 400); 

        $scope.isModalActive = !$scope.isModalActive;
    };

    // For Opening modal

    // Login button
    $scope.openLoginModalNav = function () {
        $scope.isModalActive = true;
        $scope.currentModalContent = 'login';
    };

    // Register button
    $scope.openLoginModalNavReg = function () {
        $scope.isModalActive = true;
        $scope.currentModalContent = 'user-type';
    };

    // Send Request button
    $scope.openRegisterModalDirect = function () {

        $scope.isModalActive = true;
        $scope.currentModalContent = 'register';
    };

    // Added @ 05/06/2025
    // remove scroll when login/register modal is active
    $scope.$watch('isModalActive', function (newVal) {
        document.documentElement.style.overflowY = newVal ? 'hidden' : 'auto';
    });


    // Modal Pages Transition (When Already Open) 

    // Modified by Lorenzo @ 04/25/2025 - from multiple to one function
    $scope.switchModalContent = function(target) {
        
        $timeout(() => {
            $scope.resetModalFields();          // reset value when navigating
        }, 400);             
        $scope.currentModalContent = target;
    }

    /************* Lorenzo Code *************/
    // End of Code Migrated @ 04/07/2025

    // Migrated code @ 04/23/2025
    /************* Millard Code  Added 4-21 *************/
    $scope.sendForgotPassword = function () {

        if ($scope.isCreating) return; // Prevent multiple calls/spam click
        $scope.isCreating = true;

        if (!$scope.accountEmail || !$scope.accountEmail.includes('@')) {
            Swal.fire({
                title: "Invalid Email",
                text: "Please enter a valid email address.",
                icon: "warning",
                timer: 1500,
                timerProgressBar: true,
                showConfirmButton: false,                
                returnFocus: false,              // prevents re-focusing the previous button
                allowOutsideClick: false
            });
            
            $scope.isCreating = false;            
            return;
        }
            // Store trimmed email BEFORE request
            $sessionStorage.resetEmail = $scope.accountEmail.trim();

            
            Swal.fire({
              title: 'Sending 6 Digit Code...',
              allowOutsideClick: false,
              allowEscapeKey: false,
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true,
              returnFocus: false,
              didOpen: () => {
                Swal.showLoading();
                document.activeElement.blur(); // Prevent auto-focusing any hidden button
              }
            });

      
        $http({
            method: 'POST',
            url: adminAjax.ajaxurl,
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            data: $.param({
                action: 'send_forgot_password_otp',
                email: $scope.accountEmail,
                type: 'forgot'
            })
        }).then(function (response) {
            if (response.data.success) {

                // Modified by Lorenzo @ 04/22/2025
                Swal.fire({
                    title: 'Success!',
                    text: response.data.data.message,
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    returnFocus: false          // prevents re-focusing the previous button
                }).then(function () {
                    // Added by Lorenzo @ 04/2025
                    $timeout(function () {
                        $scope.switchModalContent('verify-forgot-pass')

                        $timeout(function () {
                            document.activeElement.blur(); // removes focus
                        });
    
                        $scope.isCreating = false;      // re-enable create account button

                        $scope.startOtpCooldown(180); // Start 3-minute cooldown
                    }, 300); // Optional delay after modal closes
                });
            } else {
                Swal.fire('Error', response.data.data.message || 'Email not found.', 'error');
                $scope.isCreating = false;      // re-enable create account button
            }
            }, function () {
                Swal.fire('Error', 'Something went wrong. Please try again later.', 'error');
                $scope.isCreating = false;      // re-enable create account button
            });
    };
    /************* End Millard Code  Added 4-21 *************/

    /************* Millard Code  Added 4-22 *************/

    $scope.changePassword = function () {

        // Added by Lorenzo @ 04/24/2025
        if (!$scope.passwordValid) return;          // Prevents changing of password if input requirements are not met

        const newPassword = $scope.forgotPass.password;
        const confirmPassword = $scope.forgotPass.confirmPass;
        const email = $sessionStorage.resetEmail;
    
    
        $http.post('/wp-json/myplugin/v1/update_forgot_password/', {
            email: email,
            password: newPassword
        }).then(function (response) {
            Swal.fire({
                title: 'Success!',
                text: 'Your password has been updated.',
                icon: 'success',
                returnFocus: false          // prevents re-focusing the previous button
            }).then(() => {
                delete $sessionStorage.resetEmail;
                
                $timeout(function () {
                    $scope.switchModalContent('login');

                    $timeout(function () {
                        document.activeElement.blur(); // removes focus
                    });

                    $scope.isCreating = false;      // re-enable create account button
                    
                }, 300); // Optional delay after modal closes
            });
        }).catch(function (error) {
            Swal.fire('Error', error.data.message || 'Something went wrong.', 'error');

            $scope.isCreating = false;      // re-enable create account button
        });
    };
    
    /************* End Millard Code  Added 4-22 *************/

    /************* Millard Code Added 4-25  ************/
    $scope.otpCooldown = false;
    $scope.otpCooldownSeconds = 0;
    let resendInterval = null;

    $scope.startOtpCooldown = function (seconds) {
        $scope.otpCooldown = true;
        $scope.otpCooldownSeconds = seconds;
    
        resendInterval = setInterval(() => {
            $scope.otpCooldownSeconds--;
            $scope.$apply();
    
            if ($scope.otpCooldownSeconds <= 0) {
                clearInterval(resendInterval);
                $scope.otpCooldown = false;
                $scope.$apply();
            }
        }, 1000);
    };

    $scope.resendForgotOtp = function () {
        if (!$sessionStorage.resetEmail) {
            Swal.fire('Error', 'Missing email session. Please restart recovery.', 'error');
            return;
        }
    
        $scope.accountEmail = $sessionStorage.resetEmail;
        $scope.sendForgotPassword(); // Reuse the same function
    };
    
    
    /************* End Millard Code Added 4-25  ************/
    
    /************* Jeal Code Added 05-14  ************/
    
    $scope.contactFormData = {
        name: '',
        email: '',
        mobile: '',
        message: ''
    };
    $scope.onsubmit = false;
    
    
    $scope.submitContactForm = function () {
        const { name, email, mobile, message } = $scope.contactFormData;
    
        // Regex patterns
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        const mobilePattern = /^(?:\+63|09)\d{9}$/;
    
        // Validation
        if (!name || name.trim() === '') {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please enter your name.',
                confirmButtonColor: '#d33'
            });
            return;
        }
    
        if (!email || !emailPattern.test(email.trim())) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please enter a valid email address.',
                confirmButtonColor: '#d33'
            });
            return;
        }
    
        if (!mobile) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please enter a valid mobile number (e.g. +639xxxxxxxxx or 09xxxxxxxxx).',
                confirmButtonColor: '#d33'
            });
            return;
        }
    
        if (!message || message.trim() === '') {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please enter your message.',
                confirmButtonColor: '#d33'
            });
            return;
        }
        
        $scope.onsubmit = true; // disable button        
    
        grecaptcha.ready(function () {
            grecaptcha.execute(adminAjax.recaptchaSiteKey, { action: 'submit' }).then(function (token) {
                const formData = new FormData();
                formData.append('action', 'submit_contact_form');
                formData.append('name', name);
                formData.append('email', email);
                formData.append('mobile', mobile);
                formData.append('message', message);
                formData.append('recaptcha_token', token);
    
                fetch(`${window.location.origin}/wp-admin/admin-ajax.php`, {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        alert(res.data.message);
                        $scope.contactFormData = {}; // clear form
                        $scope.$apply();
                    } else {
                        alert(res.data.message || 'Submission failed.');
                    }
                    $scope.onsubmit = false; // re-enable button
                    $scope.$apply();
                })
                .catch(() => {
                    $scope.onsubmit = false; // re-enable button
                    $scope.$apply();
                    alert('An error occurred while submitting the form.');
                });
            });
        });
    };
    
    /************* End Jeal Code Added 05-14  ************/    
    
});

app.directive('controlTab', function($timeout) {
    return {
        restrict: 'A',
        scope: {
            controlTab: '@'
        },
        link: function(scope, element) {
            function updateTabbables() {
                const isActive = scope.$parent.currentModalContent === scope.controlTab;
                const focusables = element[0].querySelectorAll('a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])');


                focusables.forEach(el => {
                    if (isActive) {
                        el.removeAttribute('tabindex');
                    } else {
                        el.setAttribute('tabindex', '-1');
                    }
                });
            }

            scope.$watch(() => scope.$parent.currentModalContent, function() {
                $timeout(updateTabbables, 0);
            });
        }
    };
});

app.filter('limitHtmlTo', ['$sce', function($sce) {
    return function(html, limit) {
        if (!html || typeof html !== 'string') return '';

        const div = document.createElement('div');
        div.innerHTML = html;

        let count = 0;
        let output = '';

        function traverse(node) {
            if (count >= limit) return;

            if (node.nodeType === Node.TEXT_NODE) {
                const remaining = limit - count;
                const text = node.nodeValue.slice(0, remaining);
                output += text;
                count += text.length;
            } else if (node.nodeType === Node.ELEMENT_NODE) {
                const tag = node.nodeName.toLowerCase();
                output += `<${tag}${getAttributes(node)}>`;
                for (let i = 0; i < node.childNodes.length; i++) {
                    traverse(node.childNodes[i]);
                    if (count >= limit) break;
                }
                output += `</${tag}>`;
            }
        }

        function getAttributes(el) {
            if (!el.attributes) return '';
            return Array.from(el.attributes).map(attr => ` ${attr.name}="${attr.value}"`).join('');
        }

        traverse(div);

        if (count >= limit) {
            output += '...';
        }

        return $sce.trustAsHtml(output);
    };
}]);



app.filter('unescape', function () {
    return function (input) {
        if (!input) return '';
        return input
            .replace(/\\'/g, "'")
            .replace(/\\"/g, '"')
            .replace(/\\n/g, '\n')
            .replace(/\\\\/g, '\\');
    };
});


// For Quill JS Posting
app.directive('quillEditor', function () {
    return {
        restrict: 'A',
        require: 'ngModel',
        scope: {
            readonlyView: '=?' // reads readonly-view="true"
        },
        link: function (scope, element, attrs, ngModel) {
            const isReadOnlyView = scope.readonlyView === 'true';

            // If it's just a read-only display, skip Quill entirely
            if (isReadOnlyView) {
                // Just render the content as HTML
                ngModel.$render = function () {
                    element[0].innerHTML = ngModel.$viewValue || '';
                };
                return;
            }

            // Otherwise, initialize Quill with toolbar + editing
            var editor = new Quill(element[0], {
                placeholder: 'No experiences, trainings/seminars, or certifications added yet.',
                readOnly: true // start in read-only mode
            });
            
            editor.enable(false);

            scope.editorInstance = editor;

            editor.on('text-change', function () {
                var html = editor.root.innerHTML;
                scope.$applyAsync(function () {
                    ngModel.$setViewValue(html);
                });
            });

            // Render ngModel value into the editor and fix placeholder handling
            ngModel.$render = function () {
                let value = ngModel.$viewValue || '';

                // Paste content first
                editor.clipboard.dangerouslyPasteHTML(value);

                // If there's no actual text, clear the editor so placeholder shows
                const visibleText = editor.getText().trim();
                if (visibleText === '') {
                    editor.setContents([]); // Trigger placeholder correctly
                }
            };
            
            // Watch the readonlyView variable
            scope.$watch('readonlyView', function (newVal) {
                if (editor) {
                    editor.enable(false); // true if editing, false if readonly
                }
            });            
        }
    };
});
