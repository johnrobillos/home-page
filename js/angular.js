var app = angular.module('homeApp', ['ngStorage']);

app.run(function($timeout, $window, $rootScope) {

    $timeout(function () {
        const hash = window.location.hash;

        if (hash) {
            const id = hash.substring(1); // "news" from "#news"
            const el = document.getElementById(id);

            // ✅ Only call if function exists (ensures controller is loaded)
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

$scope.showNewsDetails = function(post) {
    $scope.selectedNewsPost = post;
    $('#newsModal').modal('show');
};

$scope.selectedBlog = {};

$scope.showBlogDetails = function(blog) {
    $scope.selectedBlog = blog;
    $('#blogModal').modal('show');
};

$scope.closeBlogModal = function() {
    $('#blogModal').modal('hide');
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');
};

$scope.selectedBlog = null;

$scope.toggleBlogExpansion = function(blog) {
    $scope.selectedBlog = ($scope.selectedBlog === blog) ? null : blog;
};

$scope.isVideo = function(mediaUrl) {
    return mediaUrl && mediaUrl.match(/\.(mp4|webm|ogg)$/i);
};

// // BLOGS
// $scope.blogs = [];

// $scope.fetchBlogs = function () {
//     $http({
//         method: 'POST',
//         url: adminAjax.ajaxurl,
//         headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//         data: "action=fetch_database&post_type=blog"
//     }).then(function (response) {
//         const baseURL = window.location.origin + "/wp-content/uploads/icons/posting_portal/";

//         // Filter only those with post_type === 'blog'
//         const allPosts = response.data;
//         $scope.blogs = allPosts
//             .filter(blog => blog.post_type === 'blog')
//             .map(blog => {
//                 blog.blog_media = blog.blog_media.startsWith('http') ? blog.blog_media : baseURL + blog.blog_media;
//                 return blog;
//             });
//     }, function (error) {
//         console.error('Error fetching blogs:', error);
//     });
// };
$scope.allHighlights = [];
$scope.activeHighlight = 'all'; // Default to show all highlights
// // sequenced list of all categories by posted date
$scope.getFilteredHighlights = function() {
    if ($scope.activeHighlight === 'all') {
        // Return all highlights EXCEPT those with type 'blog'
        return $scope.allHighlights.filter(post => post.type !== 'blog');
    }
    return $scope.allHighlights.filter(post => post.type === $scope.activeHighlight);
};

$scope.filteredHighlights = $scope.getFilteredHighlights();




$scope.fetchAllHighlights = function () {
    $http({
        method: 'POST',
        url: adminAjax.ajaxurl,
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        data: "action=fetch_database"
    }).then(function (response) {
        const baseURL = window.location.origin + "/wp-content/uploads/icons/posting_portal/";

        function unescapeDescription(description) {
            if (!description) return '';
            return description
                .replace(/\\'/g, "'")
                .replace(/\\"/g, '"')
                .replace(/\\n/g, '\n')
                .replace(/\\\\/g, '\\');
        }

        const posts = response.data.map(post => {
            const type = post.post_type; // already in DB
            const blog_media = post.blog_media && post.blog_media.startsWith('http')
                ? post.blog_media
                : baseURL + post.blog_media;

            return {
                type: type,
                title: post.title_blog,
                role: post.role || '',
                description: post.blog_description,
                descriptionUnescaped: unescapeDescription(post.blog_description),
                date: post.blog_date,
                image: blog_media,
                link: post.link || ''
            };
        });

    // Split into two separate arrays
    $scope.blogs = posts.filter(p => p.type === 'blog');
    $scope.allHighlights = posts.filter(p => p.type !== 'blog')
        .sort((a, b) => new Date(b.date) - new Date(a.date));

    // Set default filteredHighlights
    $scope.filteredHighlights = $scope.getFilteredHighlights();
    
    }, function (error) {
        console.error('Error fetching all highlights:', error);
    });
};

$scope.fetchAllHighlights();

$scope.$watch('activeHighlight', function () {
    $scope.filteredHighlights = $scope.getFilteredHighlights();
});


// $scope.$watch('activePage', function(newVal) {
//     if (newVal === 'highlights') {
//         $scope.activeHighlight = 'all';
//     }
// });

// // remove the backdrop when closing news modal
// // $scope.closeNewsModal = function() {
// //     $('#newsModal').modal('hide');
// //     // Remove any leftover backdrop just in case
// //     $('.modal-backdrop').remove();
// //     $('body').removeClass('modal-open');
// // };

// $scope.selectedNewsPost = null;

$scope.toggleNewsExpansion = function(post) {
  $scope.selectedNewsPost = ($scope.selectedNewsPost === post) ? null : post;
};

// Quilljs viewer
$scope.getQuillPreview = function(html) {
    if (!html) return '';
    // Optionally, strip tags and limit text for preview
    var div = document.createElement('div');
    div.innerHTML = html;
    var text = div.innerText || div.textContent || '';
    if (text.length > 200) {
        text = text.substring(0, 200) + '.....';
    }
    return $sce.trustAsHtml(text);
};

$scope.getQuillFull = function(html) {
    return $sce.trustAsHtml(html || '');
};

// // NEWS
// $scope.newsPosts = [];

// $scope.fetchNews = function () {
//     $http({
//         method: 'POST',
//         url: adminAjax.ajaxurl,
//         headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//         data: "action=fetch_database&post_type=news"
//     }).then(function (response) {
//         const baseURL = window.location.origin + "/wp-content/uploads/icons/posting_portal/";
//         $scope.newsPosts = response.data.map(post => {

//             post.blog_media = post.blog_media.startsWith('http') ? post.blog_media : baseURL + post.blog_media;
//             return {
//                 title: post.title_blog,
//                 description: post.blog_description,
//                 date: post.blog_date,
//                 image: post.blog_media
//             };
//         });
//         $scope.mergeAllHighlights(); // <-- add this here
//     }, function (error) {
//         console.error('Error fetching news:', error);
//     });
// };

// // TESTIMONIALS
// $scope.testimonialPosts = [];

// $scope.fetchTestimonials = function () {
//     $http({
//         method: 'POST',
//         url: adminAjax.ajaxurl,
//         headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//         data: "action=fetch_database&post_type=testimonial"
//     }).then(function (response) {
//         const baseURL = window.location.origin + "/wp-content/uploads/icons/posting_portal/";
//         $scope.testimonialPosts = response.data.map(post => {

//             function unescapeDescription(description) {
//                 if (!description) return '';
//                 return description
//                     .replace(/\\'/g, "'")
//                     .replace(/\\"/g, '"')
//                     .replace(/\\n/g, '\n')
//                     .replace(/\\\\/g, '\\');
//             }            
            
//             post.blog_media = post.blog_media.startsWith('http') ? post.blog_media : baseURL + post.blog_media;
//             return {
//                 title: post.title_blog,
//                 role: post.role,
//                 description: post.blog_description,
//                 descriptionUnescaped: unescapeDescription(post.blog_description),                
//                 date: post.blog_date,
//                 image: post.blog_media,
//             };
//         });
//         $scope.mergeAllHighlights();
//     }, function (error) {
//         console.error('Error fetching testimonials:', error);
//     });
// };

// // FACEBOOK
// $scope.facebookPosts = [];
// $scope.fetchFacebook = function () {
//     $http({
//         method: 'POST',
//         url: adminAjax.ajaxurl,
//         headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//         data: "action=fetch_database&post_type=facebook"
//     }).then(function (response) {
//         const baseURL = window.location.origin + "/wp-content/uploads/icons/posting_portal/";
//         $scope.facebookPosts = response.data.map(post => {

//             post.blog_media = post.blog_media && post.blog_media.startsWith('http') ? post.blog_media : baseURL + post.blog_media;
//             return {
//                 title: post.title_blog,
//                 description: post.blog_description,
//                 date: post.blog_date,
//                 image: post.blog_media,
//                 link: post.link
//             };
//         });
//         $scope.mergeAllHighlights();
//     }, function (error) {
//         console.error('Error fetching Facebook posts:', error);
//     });
// };

// // INSTAGRAM
// $scope.instagramPosts = [];
// $scope.fetchInstagram = function () {
//     $http({
//         method: 'POST',
//         url: adminAjax.ajaxurl,
//         headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//         data: "action=fetch_database&post_type=instagram"
//     }).then(function (response) {
//         const baseURL = window.location.origin + "/wp-content/uploads/icons/posting_portal/";
//         $scope.instagramPosts = response.data.map(post => {
        
//             post.blog_media = post.blog_media && post.blog_media.startsWith('http') ? post.blog_media : baseURL + post.blog_media;
//             return {
//                 title: post.title_blog,
//                 description: post.blog_description,
//                 date: post.blog_date,
//                 image: post.blog_media,
//                 link: post.link
//             };
//         });
//         $scope.mergeAllHighlights();
//     }, function (error) {
//         console.error('Error fetching Instagram posts:', error);
//     });
// };


// // TIKTOK
// $scope.tiktokPosts = [];
// $scope.fetchTikTok = function () {
//     $http({
//         method: 'POST',
//         url: adminAjax.ajaxurl,
//         headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//         data: "action=fetch_database&post_type=tiktok"
//     }).then(function (response) {
//         const baseURL = window.location.origin + "/wp-content/uploads/icons/posting_portal/";
//         $scope.tiktokPosts = response.data.map(post => {

//             post.blog_media = post.blog_media && post.blog_media.startsWith('http') ? post.blog_media : baseURL + post.blog_media;
//             return {
//                 title: post.title_blog,
//                 description: post.blog_description,
//                 date: post.blog_date,
//                 image: post.blog_media,
//                 link: post.link
//             };
//         });
//         $scope.mergeAllHighlights();
//     }, function (error) {
//         console.error('Error fetching TikTok posts:', error);
//     });
// };

// $scope.mergeAllHighlights = function () {
//     function unescapeDescription(description) {
//         if (!description) return '';
//         return description
//             .replace(/\\'/g, "'")
//             .replace(/\\"/g, '"')
//             .replace(/\\n/g, '\n')
//             .replace(/\\\\/g, '\\');
//     }

//     $scope.allHighlights = [].concat(
//         ($scope.newsPosts || []).map(post => ({
//             ...post,
//             type: 'news',
//             descriptionUnescaped: unescapeDescription(post.description)
//         })),
//         ($scope.testimonialPosts || []).map(post => ({
//             ...post,
//             type: 'testimonial',
//             descriptionUnescaped: unescapeDescription(post.description)
//         })),
//         ($scope.facebookPosts || []).map(post => ({
//             ...post,
//             type: 'facebook',
//             descriptionUnescaped: unescapeDescription(post.description)
//         })),
//         ($scope.instagramPosts || []).map(post => ({
//             ...post,
//             type: 'instagram',
//             descriptionUnescaped: unescapeDescription(post.description)
//         })),
//         ($scope.tiktokPosts || []).map(post => ({
//             ...post,
//             type: 'tiktok',
//             descriptionUnescaped: unescapeDescription(post.description)
//         }))
//     );

//     $scope.allHighlights.sort(function (a, b) {
//         return new Date(b.date) - new Date(a.date);
//     });
// };





// // AUTO-LOAD on controller init
// $scope.fetchBlogs();
// $scope.fetchNews();
// $scope.fetchTestimonials(); // Add this
// $scope.fetchFacebook();
// $scope.fetchInstagram();
// $scope.fetchTikTok();


          
      $scope.credentials = {
        username: '',
        password: ''

    };

// Add this temporarily to your controller
// automatically scroll to the news section
$scope.showFullNewsPage = false; // default to list

$scope.openFullNews = function(news) {
  $scope.selectedNews = news;
  $scope.showFullNewsPage = true;

  // Scroll to top for full news page
  setTimeout(() => {
    const el = document.querySelector('.card.shadow-sm.border-0.mt-4.p-4');
    if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
    else window.scrollTo({ top: 0, behavior: 'smooth' });
  }, 100);
};

$scope.closeFullNews = function() {
  $scope.showFullNewsPage = false;
  $scope.selectedNews = null;

};

// Use controllerAs syntax (recommended)
controllerAs: 'vm',
// Then in HTML: ng-if="vm.activePage === 'contact'"


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

// ✅ Expose it globally so `app.run` can call it
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
        // teamwork lottie
        var emp_details = lottie.loadAnimation({
            container: $("#teamwork_2")[0],
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: "/wp-content/uploads/lottie/teamwork_2.json"
        });

        // handshake lottie
        var clock_lottie = lottie.loadAnimation({
            container: $("#realtime-lottie")[0], // HTML container element
            renderer: 'svg', // Render as SVG
            loop: true, // Animation should loop
            autoplay: true, // Start playing automatically
            path: "/wp-content/uploads/lottie/handshake.json" // Path to your Lottie JSON file
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

        // connect lottie
        var emp_details = lottie.loadAnimation({
            container: document.getElementById("connect"),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: "/wp-content/uploads/lottie/connect.json"
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

// FAQ's
$scope.faqTab = 'ojtgo';

// for OJTGo FAQs
$scope.ojtgoFaqs = [

    {
        question: "What is OJTGo?",
        answer: {
          list: [
            `OJTGo is a digital internship-matching platform developed by PCES Inc., 
          created by students—for students. It connects graduating students with host companies 
          (HTEs) based on their course, location, and skills. Our goal is to simplify the internship 
          journey and reduce the stress, cost, and mismatches students often experience.`
        ]
        },
        open: false
      },

      {
        question: "How does OJTGo work?",
        answer: {
          list: [
            `Students create profiles on the platform, while employers post internship openings. 
           The system automatically matches candidates to jobs based on course, skills, location, 
           and preferences. Employers can then communicate, interview, and hire directly through the platform.`,
        ]
        },
        open: false
      },

    {
      question: "Who can use OJTGo?",
      answer: {
        paragraph: "OJTGo is designed for:",
        list: [
          "Students looking for internship opportunities that fit their academic background and location",
          "Employers/Host Training Establishments (HTEs) seeking qualified interns efficiently",
          "Schools aiming to streamline internship placement and ensure students gain relevant experience"
        ]
      },
      open: false
    },

    {
      question: "Is this legit?",
      answer: {
        list: [
          `Yes! We work with real companies actively looking for OJTs. Our goal is to make OJT placement 
          affordable, fast, and stress-free for students. We also verify all companies first to ensure they 
          are legitimate and provide a valuable internship experience.`,
          `Absolutely! OJTGo works only with verified companies to guarantee real, value-adding internship 
          experiences. Built from firsthand student experience, OJTGo’s mission is to make internship placement 
          fast, affordable, and meaningful for everyone.`,
        ]
      },
      open: false
    },

  ];
  

// for Student FAQs
$scope.studentFaqs = [

    {
      question: "How do I register as a student?",
      answer: {
        list: [
          `Simply visit OJTGo’s website, sign up using your email, and complete your profile with your education background, 
          internship preferences, and basic personal details. You can also add any relevant experiences, trainings or seminars, 
          and certifications to make your profile more attractive to potential employers.`,
        ]
      },
      open: false
    },

    {
        question: "Is there a fee to use OJTGo?",
        answer: {
          list: [
            `Yes, it’s just ₱60 per month. This gives you access to smart internship matching, exclusive openings, 
            and priority support—plus a 60-day money-back guarantee if you don’t get matched!`,
          ]
        },
        open: false
      },

      {
        question: "How will I know if I’ve been matched?",
        answer: {
          list: [
            `You’ll get a notification on your dashboard and via email with the internship details and next steps`,
          ]
        },
        open: false
      },

      {
        question: "Will I really get an OJT placement",
        answer: {
          list: [
            `Absolutely! OJTGo matches every student with a company based on your course, skills, and preferences.
             We guarantee placement so you can focus on graduating.`,
          ]
        },
        open: false
      },

      {
        question: "Do I need to attend multiple interviews?",
        answer: {
          list: [
            `No need! The process is streamlined. Interviews can be done online within the platform—quick, 
            convenient, and no travel required.`,
          ]
        },
        open: false
      },

      {
        question: "Can I apply for multiple internships?",
        answer: {
          list: [
            `Yes! You can explore and apply to several opportunities that match your qualifications and interests`,
          ]
        },
        open: false
      },

      {
        question: "What if I’m not matched right away?",
        answer: {
          list: [
            `That’s okay! New opportunities are added regularly. Keep your profile updated and check your dashboard 
            often to increase your chances.`,
          ]
        },
        open: false
      },

      {
        question: "What if I don’t get a placement at all?",
        answer: {
          list: [
            `We’ve got your back. If you’re not matched within 60 days, we’ll refund your ₱60—no questions asked.`,
          ]
        },
        open: false
      },
];

// for Employer FAQs  
$scope.employerFaqs = [
    {
      question: "How can companies register on OJTGo?",
      answer: {
        list: [
          `Employers can easily sign up at www.ojtgo.com, create a company profile, and start posting internship opportunities.`
        ]
      },
      open: false
    },

      {
        question: "Is there a cost for employers to post internships?",
        answer: {
          list: [
            `No, it’s completely free! Employers can post unlimited internships and connect with qualified students at no cost.`,
          ]
        },
        open: false
      },

      {
        question: "How does OJTGo help employers find the right interns?",
        answer: {
          list: [
            `OJTGo uses a smart filtering system to help employers find students whose education, skills, and location preferences match 
            the internship requirements—saving time and effort in the selection process.`,
          ]
        },
        open: false
      },

      {
        question: "Can employers directly contact students?",
        answer: {
          list: [
            `Yes! The platform includes a built-in messaging feature that lets employers reach out to students directly, 
            making coordination and hiring faster and more convenient.`,
          ]
        },
        open: false
      },

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

    // Modified by Lorenzo @04/25/2025
    $scope.loginUser = function() {
        if ($scope.isCreating) return; // 🚫 Prevent multiple calls/spam click
        $scope.isCreating = true;

        if (!$scope.credentials.username || !$scope.credentials.password) {
            Swal.fire({
                title: "Error",
                text: "Please enter both username and password.",
                icon: "error",
                timer: 1500,
                timerProgressBar: true,
                showConfirmButton: false,                
                returnFocus: false,              // 🛑 prevents re-focusing the previous button
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
    
            // ðŸ”¹ Fix: Ensure response format is correctly handled
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
                    returnFocus: false,              // 🛑 prevents re-focusing the previous button
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
        
        if ($scope.isCreating) return; // 🚫 Prevent multiple calls/spam click
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
                    returnFocus: false,              // 🛑 prevents re-focusing the previous button
                    allowOutsideClick: true
                });    
                      
                $scope.isCreating = false; // 🛑 Reset to allow retry
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
                    returnFocus: false,              // 🛑 prevents re-focusing the previous button
                    allowOutsideClick: true
                });   
                
                $scope.isCreating = false; // 🛑 Reset to allow retry
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
                
                // 🧹 Clear OTP email after successful verification
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
                    returnFocus: false,          // 🛑 prevents re-focusing the previous button
                    willClose: () => {
                        // 🚀 Redirect based on user type
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
                returnFocus: false,              // 🛑 prevents re-focusing the previous button
                allowOutsideClick: false
                });
                
                $scope.isCreating = false; // 🛑 Reset to allow retry
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
                returnFocus: false,              // 🛑 prevents re-focusing the previous button
                allowOutsideClick: false
                });                
                $scope.isCreating = false; // 🛑 Reset to allow retry
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
                    returnFocus: false          // 🛑 prevents re-focusing the previous button
                }).then(function () {
                    
                    
                    $timeout(function () {
                        // 🧹 Clear OTP email after successful verification
                        delete $sessionStorage.emailForOtp;
                        $scope.switchModalContent('change-pass'); // ➕ Open change password modal
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
                    returnFocus: false,              // 🛑 prevents re-focusing the previous button
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
        if ($scope.isCreating) return; // 🚫 Prevent multiple calls/spam click
        if ($scope.isFormInvalid() || !$scope.passwordValid || !$scope.usernameValid) return;// 🛑 Prevent action        
        $scope.isCreating = true;

        var userData = {
            username: $scope.credentials.username,
            email: $scope.credentials.email,
            password: $scope.credentials.password,
            role: $scope.credentials.role 
        };
    
        // 🛠️ Console to view user role before encryption
        
            // Encrypt before storing
        var encryptedData = encryptData(userData);
        // Store in rootScope and sessionStorage
        $rootScope.userCredentials = encryptedData;
        $sessionStorage.userCredentials = encryptedData;
    
        // 📨 Store raw email separately for OTP operations
        $sessionStorage.emailForOtp = userData.email;

        // ✅ Send OTP
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
                returnFocus: false // 🛑 prevents re-focusing the previous button
            }).then(() => {
                // Use timeout to force proper DOM repaint in Firefox
                $timeout(() => {
                    // Open OTP modal
                    $scope.switchModalContent('verify');
                    // 🔒 Start cooldown (3 minutes)
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
            $scope.isCreating = false; // 🧼 Re-enable button on failure
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

        if ($scope.isCreating) return; // 🚫 Prevent multiple calls/spam click
        $scope.isCreating = true;

        if (!$scope.accountEmail || !$scope.accountEmail.includes('@')) {
            Swal.fire({
                title: "Invalid Email",
                text: "Please enter a valid email address.",
                icon: "warning",
                timer: 1500,
                timerProgressBar: true,
                showConfirmButton: false,                
                returnFocus: false,              // 🛑 prevents re-focusing the previous button
                allowOutsideClick: false
            });
            
            $scope.isCreating = false;            
            return;
        }
            // ✅ Store trimmed email BEFORE request
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
                document.activeElement.blur(); // ✅ Prevent auto-focusing any hidden button
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
                    returnFocus: false          // 🛑 prevents re-focusing the previous button
                }).then(function () {
                    // Added by Lorenzo @ 04/2025
                    $timeout(function () {
                        $scope.switchModalContent('verify-forgot-pass')

                        $timeout(function () {
                            document.activeElement.blur(); // removes focus
                        });
    
                        $scope.isCreating = false;      // re-enable create account button

                        $scope.startOtpCooldown(180); // 🔄 Start 3-minute cooldown
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
                returnFocus: false          // 🛑 prevents re-focusing the previous button
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

app.filter('trustAsHtml', ['$sce', function($sce) {
    return function(html) {
        return $sce.trustAsHtml(html);
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

            // // 🔒 If it's just a read-only display, skip Quill entirely
            // if (isReadOnlyView) {
            //     // Just render the content as HTML
            //     ngModel.$render = function () {
            //         element[0].innerHTML = ngModel.$viewValue || '';
            //     };
            //     return;
            // }

            // ✅ Otherwise, initialize Quill with toolbar + editing
            var editor = new Quill(element[0], {
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

            // ✅ Render ngModel value into the editor and fix placeholder handling
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
            
            // 🔁 Watch the readonlyView variable
            scope.$watch('readonlyView', function (newVal) {
                if (editor) {
                    editor.enable(false); // true if editing, false if readonly
                }
            });            
        }
    };
});
