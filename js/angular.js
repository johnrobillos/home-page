var app = angular.module('angularApp', ['ngStorage']);

// Deleting/clearing sessionStorage on page reload
app.run(function($sessionStorage) {
    // 🧹 Clear sessionStorage keys from ngStorage before any controller uses them
    delete $sessionStorage.userCredentials;
    delete $sessionStorage.emailForOtp;
});

app.run(function($timeout, $window, $rootScope) {
    console.log('app.run triggered');

    $timeout(function () {
        const hash = window.location.hash;
        console.log('Hash:', hash);

        if (hash) {
            const id = hash.substring(1); // "news" from "#news"
            const el = document.getElementById(id);
            console.log('Element found:', el);

            // ✅ Only call if function exists (ensures controller is loaded)
            if (typeof $rootScope.setActivePage === 'function') {
                console.log(`Calling setActivePage('${id}')`);
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









app.controller('angular_controller', function($scope, $http, $timeout, $window, $rootScope, $sessionStorage, $document) {
     console.log('Controller loaded');
      $scope.credentials = {
        username: '',
        password: ''

    };

    // Charls Added

$scope.activePage = 'home'; // Default page
$scope.showActivePage = 'contact';
// Add this temporarily to your controller
console.log('Current page:', $scope.activePage);

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


// for news section functionality
$scope.newsList = [
    {
      title: 'OJTGo Has Officially Launched!',
      summary: `We’re thrilled to announce that OJTGo is now LIVE and ready to support your internship journey! 🙌
                This innovative platform is designed by students, for students, to make finding and securing OJT opportunities easier and faster. 
                No more endless waiting or unanswered messages — with OJTGo, you can browse verified internships, apply directly to companies, and track 
                your application status all in one place. Whether you’re just starting or looking for your next big break, OJTGo is here to help you take the 
                next step in your career with confidence.`,
      date: 'May 12, 2025',
      image: 'https://vin.ojtgo.com/wp-content/uploads/icons/OJTGO-630X310.png'
    },

    // {
    //   title: 'Tips to Land Your Dream Internship',
    //           summary: `Check out our top tips to help you stand out in your OJT applications and get noticed by top companies. 
    //           From crafting a strong resume to acing your interview, these simple but effective strategies will boost your chances of 
    //           landing the internship you’ve always wanted. Start preparing now and take control of your future!`,
    //   date: 'May 14, 2025',
    //   image: 'https://vin.ojtgo.com/wp-content/uploads/2025/05/ojtgo3.jpg'
    // },

    // {
    //   title: 'Internship Horror Stories – And How OJTGo Solves Them',
    //   summary:'Internships should be stepping stones to your career — not nightmares. Unfortunately, many students face issues like unpaid work, vague job descriptions, and recruiters who disappear without a trace. In this post, we dive into these common internship horror stories and show exactly how OJTGo’s transparent and student-focused platform is designed to solve them. Say goodbye to frustration and hello to clear, fair, and meaningful internship opportunities!',
    //   date: 'May 15, 2025',
    //   image: 'https://vin.ojtgo.com/wp-content/uploads/2025/05/ojtgo5.jpg'
    // },
        
    // {
    //   title: 'OJTGo Team Speaks at Cavite State University',
    //   summary: 'Our founders recently had the honor of speaking at Cavite State University, sharing valuable insights about the challenges students face during internships and how technology can transform the experience. They discussed the vision behind OJTGo — a platform built to connect students with real opportunities and make the internship process smoother and more transparent. This event marked a big step toward fostering stronger ties between education and industry through innovation.',
    //   date: 'May 16, 2025',
    //   image: 'https://vin.ojtgo.com/wp-content/uploads/2025/05/ojtgo2.jpg'
    // },

    // {
    //     title: 'OJTGo Expands to More Schools Nationwide',
    //     summary: 'We’re excited to announce that OJTGo is growing! Our platform is now partnering with even more colleges and universities across the Philippines, helping thousands of students access verified internship opportunities closer to home. This nationwide expansion reflects our commitment to bridging the gap between students and employers, providing a trusted, easy-to-use tool for career development no matter where you study.',
    //     date: 'May 17, 2025',
    //     image: 'https://vin.ojtgo.com/wp-content/uploads/2025/05/ojtgo7.jpg'
    //   },
    
    //   {
    //     title: 'Student Testimonials: How OJTGo Helped Me Land an Internship',
    //     summary: 'Don’t just take our word for it — hear from the students themselves! In this post, we share inspiring stories from real users who successfully found and secured valuable internships through OJTGo. From landing their first OJT role to gaining hands-on experience in their dream industries, these testimonials highlight how the platform makes a difference in students’ lives and futures.',
    //     date: 'May 18, 2025',
    //     image: 'https://vin.ojtgo.com/wp-content/uploads/2025/05/ojtgo6.jpg'
    //   },
  ];
  



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

    console.log('Active Page:', $scope.activePage); // Debugging

    // Smooth scroll to top
    $timeout(function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }, 0);
};

// ✅ Expose it globally so `app.run` can call it
$rootScope.setActivePage = $scope.setActivePage;


    $scope.$watch('activePage', function(newVal, oldVal) {
        if (newVal !== oldVal) {
            console.log('Active Page:', newVal);
            // Scroll to top after view changes
            setTimeout(function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }, 100); // delay ensures DOM is ready
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


        // magnifying lottie
        var magnify_lottie = lottie.loadAnimation({
            container: $("#magnify-job-lottie")[0], // HTML container element
            renderer: 'svg', // Render as SVG
            loop: true, // Animation should loop
            autoplay: true, // Start playing automatically
            path: "/wp-content/uploads/lottie/magnify.json" // Path to your Lottie JSON file
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
$scope.openFullNews = function(news) {
  $scope.selectedNews = news;
  $scope.showFullNewsPage = true;

  // Scroll to full-news-section after DOM update
  $timeout(function () {
    var el = document.getElementById("full-news-section");
    if (el) {
      el.scrollIntoView({ behavior: "auto", block: "start" });
    }
  }, 100); // Adjust delay if necessary
};

// Close full news view
$scope.closeFullNews = function() {
  $scope.selectedNews = null;
  $scope.showFullNewsPage = false;
};

        

          






          

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
            console.log("Login Response:", response.data); // Debugging
    
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
                            console.error("Missing redirect URL:", responseData);
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
                console.error("Login Failed:", responseData);
                Swal.fire("Login Failed", responseData.message || "Invalid credentials.", "error");
            
                $scope.isCreating = false;          // Reset to false after process is finished
            }
        }, function(error) {
            console.error("AJAX Error:", error);
            Swal.fire("Error", "An error occurred while logging in.", "error");
        
            $scope.isCreating = false;          // Reset to false after process is finished
        });
    };
    
    // Handle Enter key on Login Content
    // $scope.handleLoginKeypress = function($event) {
    //     if ($event.key === "Enter" && $scope.currentModalContent === 'login') {
    //         $scope.loginUser();
    //     }
    // };
    
    // // Handle Enter key on Login Content
    // $scope.handleCreateAccKeypress = function($event) {
    //     if ($event.key === "Enter" && $scope.currentModalContent === 'register') {
    //         $scope.storeCredentials();
    //     }
    // };  
    
    // // Handle Enter key on Login Content
    // $scope.handleVerifyOTPKeypress = function($event) {
    //     if ($event.key === "Enter" && $scope.currentModalContent === 'verify') {
    //         $scope.verifyAndProceed('register');
    //     }
    // };       
    
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
        
        console.log('before: ', $scope.isCreating);
        

        // console.log("User selected:", userType);
        
        if ($sessionStorage.userCredentials) {
            delete $sessionStorage.userCredentials;
            console.log("🧹 userCredentials session cleared.");
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


        console.log("🔉 Verifying OTP and Proceeding...");
    
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
                console.error("OTP validation failed:", error);
            
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
        
            console.log('📨 Email for OTP:', email);
            console.log('🔢 Entered OTP:', enteredOtp);
        
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
    
    // openLoginModalNav modified (at lorenzo code)
    // openLoginModalApply removed @04/07/2025
    
  
    // For Dropdowns List options revised &added 4-5-25  

    // For Course and Role
    // $scope.courseJobMapping = {};
    // $scope.filterData = {
    //     selectedCourse: null,
    //     selectedRole: null
    // };
    // $scope.courses = [];
    // $scope.jobTitles = [];
    
    // $http.get('/wp-admin/admin-ajax.php?action=get_course_job_titles')
    //     .then(function(response) {
    //         $scope.courseJobMapping = response.data || {};
    //         $scope.courses = Object.keys($scope.courseJobMapping).sort();
    //     })
    //     .catch(function(error) {
    //         console.error("❌ Error fetching mapping:", error);
    //     });
    
    // $scope.updateJobTitles = function () {
    //     let course = $scope.filterData.selectedCourse?.trim();
    //     console.log("➡️ Course selected:", course);
    
    //     if (course && $scope.courseJobMapping[course]) {
    //         $scope.jobTitles = [...new Set($scope.courseJobMapping[course])].map(j => j.trim()).sort();
    //         console.log("🎯 Job Titles:", $scope.jobTitles);
    //     } else {
    //         $scope.jobTitles = [];
    //         console.warn("⚠️ No matching job titles for course:", course);
    //     }
    
    //      $scope.filterData.selectedRole = null;
    // };



    // $scope.locationFilter = {
    //     province: null,
    //     city: null
    // };
    
    // $scope.provinceList = [];
    // $scope.cityList = [];
    
    // // ✅ Load provinces and cities from backend
    // $http.post(adminAjax.ajaxurl, $.param({ action: 'get_philippines_data_for_posting' }), {
    //     headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
    // }).then(function(response) {
    //     if (response.data.provinces && response.data.cities) {
    //         $scope.provinceList = response.data.provinces;
    //         $scope.allCities = response.data.cities;
    //     }
    // }).catch(function(error) {
    //     console.error("❌ Failed to load location data:", error);
    // });
    
    // ✅ When province changes, load cities under it
    // $scope.loadCitiesForProvince = function () {
    //     const selected = $scope.locationFilter.province;
    
    //     if (!selected) {
    //         $scope.cityList = [];
    //         $scope.locationFilter.city = null;
    //         return;
    //     }
    
    //     const province = $scope.provinceList.find(p => p.province_name === selected);
    //     if (province) {
    //         $scope.cityList = $scope.allCities
    //             .filter(city => city.province_code === province.province_code)
    //             .map(city => city.city_name);
    
    //         $scope.locationFilter.city = null; // reset city when province changes
    //     }
    // };
    
    




    
    

    //////


    $scope.submit_reg = function() {
    
        Swal.fire({
            title: 'Registration Successful!',
            text: 'You will be redirected to your dashboard.',
            icon: 'success',
            confirmButtonText: 'Ok'
        });
    
    }


    // Added by Lorenzo @ 04/07/2025
    // Assign colors to variables
    // $scope.greenColor = '#288237';              // General Color                // #C93F24
    // $scope.redColor = '#C93F24';                // General Color                // #C93F24
    // $scope.pendingColor = '#DEB93F';            // Status label color           // #DEB93F
    // $scope.processingColor = '#C88040';         // Status label color           // #C88040
    // $scope.interviewColor = '#3B6EBC';          // Status label color           // #3B6EBC
    // $scope.internshipOfferColor = '#74398D';    // Status label color           // #74398D
    // $scope.highToMidColor = '#A8C924';          // matching percentage color    // #A8C924
    // $scope.midToLowColor = '#C99524';           // matching percentage color    // #C99524
    // $scope.grayColor = '#6c757d';               // For inactive or disabled     // #6c757d



    // // Assign correct color for the correct percentage range
    // $scope.getMatchColor = function (percentage) {
    //     if (percentage >= 80) return $scope.greenColor;
    //     if (percentage >= 51) return $scope.highToMidColor;
    //     if (percentage >= 25) return $scope.midToLowColor;
    //     if (percentage >= 0) return $scope.redColor;  
                
    //     return $scope.redColor;             //default color
    // };


    // // Fetch job posts from backend once
    // $scope.fetch_job_posts = function() {
    //   $http({
    //       method: 'POST',
    //       url: adminAjax.ajaxurl,
    //       headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    //       data: $.param({ action: 'fetch_job_posts' })
    //     }).then(function (response) {
    //         $scope.job_posts = response.data;
    //         if ($scope.job_posts.length > 0) {
    //             $scope.original_job_post = angular.copy($scope.job_posts);
    //             $scope.first_row = $scope.job_posts[0]._ID;
    
    //             $scope.job_post_selected($scope.first_row);
    //             $scope.updateMatchPercentage();         
    //             $scope.sortJobsByMatch();
    //             // Calculate match percentage after fetching jobs

    //         }

    //     }, function (error) {
    //          console.error("Error fetching job posts:", error);
    //     });
    // };

    // Initialize filters
    // $scope.match_per = 100; // Default matching percentage

    // $scope.fetch_job_posts();
    

    
// $scope.updateChart = function(match_percentage) {
//     console.log("Updating Chart with:", match_percentage);

//     match_percentage = parseFloat(match_percentage) || 0;

//     // Delay rendering to allow DOM to settle
//     $timeout(function () {
//         const chartContainer = document.getElementById('container');

//         if (!chartContainer) {
//             console.warn("⛔ Chart container #container still not found after timeout.");
//             return;
//         }

//         if ($scope.chartInstance) {
//             $scope.chartInstance.destroy();
//         }

//         // Determine color
//         let color = '#6c757d';
//         if (match_percentage >= 80) color = $scope.greenColor;
//         else if (match_percentage >= 51) color = $scope.highToMidColor;
//         else if (match_percentage >= 25) color = $scope.midToLowColor;
//         else if (match_percentage > 0) color = $scope.redColor;

//         $scope.chartInstance = Highcharts.chart('container', {
//             chart: {
//                 type: 'pie',
//                 plotBackgroundColor: null,
//                 plotBorderWidth: 0,
//                 plotShadow: false
//             },
//             title: {
//                 text: match_percentage + '%',
//                 align: 'center',
//                 verticalAlign: 'middle',
//                 y: 50,
//                 style: {
//                     fontSize: '24px',
//                     fontWeight: 'bold'
//                 }
//             },
//             plotOptions: {
//                 pie: {
//                     startAngle: -90,
//                     endAngle: 90,
//                     center: ['50%', '75%'],
//                     innerSize: '75%',
//                     borderWidth: 0
//                 }
//             },
//             series: [{
//                 name: 'Matching Percentage',
//                 data: [
//                     { name: 'Matching Percentage', y: match_percentage, color: color },
//                     { name: 'Mismatch', y: 100 - match_percentage, color: '#e0e0e0' }
//                 ]
//             }]
//         });
//     }, 100); // Delay of 100ms to wait for DOM to update
// };



    // Callable scope fucntion for calcualting the match percentage
    // $scope.calculateMatchPercentage = function(job) {
    //     let match = 100;
        
    //     // Default: assume matched

    //     if ($scope.filterData.selectedRole && job.employer_job_offer_job_title_preferred !== $scope.filterData.selectedRole) {
    //         match -= 50;
            
    //     }

    //     if ($scope.filterData.selectedCourse && job.employer_job_offer_emp_preferred_course !== $scope.filterData.selectedCourse) {
    //         match -= 25;
    //     }

    //     if ($scope.locationFilter.province && job.employer_job_offer_preferred_job_location !== $scope.locationFilter.province) {
    //         match -= 15;
    //     }

    //     if ($scope.locationFilter.city && job.employer_job_offer_preferred_job_city !== $scope.locationFilter.city) {
    //         match -= 10;
    //     }

    //     return Math.max(0, match);
    // };

    // $scope.updateMatchPercentage = function () {
    //     let totalPercentage = 0;

    //     $scope.job_posts.forEach(job => {
    //         let match_percentage = $scope.calculateMatchPercentage(job);

    //         job.match_percentage = match_percentage;
    //         totalPercentage += match_percentage;

    //         if ($scope.viewpost_job_title === job.employer_job_offer_job_title_preferred) {
    //             $scope.match_per = match_percentage;
    //         }
    //     });

    //     if (
    //         !$scope.filterData.selectedCourse &&
    //         !$scope.filterData.selectedRole &&
    //         !$scope.locationFilter.province &&
    //         !$scope.locationFilter.city
    //     ) {
    //         $scope.match_per = 100;
    //     } else {
    //         $scope.match_per = totalPercentage / ($scope.job_posts.length || 1);
    //     }

        
    //     $scope.sortJobsByMatch(); 
    //     $scope.updateChart($scope.match_per);
    // };
    // $scope.hasSearched = false;
    // $scope.filterJobs = function () {
    //     $scope.hasSearched = true;
    //     console.log("🔍 Filtering jobs based on:", {
    //         course: $scope.filterData.selectedCourse,
    //         role: $scope.filterData.selectedRole,
    //         province: $scope.locationFilter.province,
    //         city: $scope.locationFilter.city
    //     });
        

    //     if (!$scope.job_posts || $scope.job_posts.length === 0) {
    //         console.warn("⚠ No job posts available!");
    //         return;
    //     }
        
    //     // ✅ Set per-field searched status
    //     $scope.hasSearchedCourse = !!$scope.filterData.selectedCourse;
    //     $scope.hasSearchedJob = !!$scope.filterData.selectedRole;
    //     $scope.hasSearchedProvince = !!$scope.locationFilter.province;
    //     $scope.hasSearchedCity = !!$scope.locationFilter.city;        

    //     let totalMatches = 0;
    //     let matchedJobs = 0;

    //     $scope.job_posts.forEach(job => {
            
    //         job.jobmatched = job.employer_job_offer_job_title_preferred === $scope.filterData.selectedRole;
    //         job.coursematched =  job.employer_job_offer_emp_preferred_course === $scope.filterData.selectedCourse;
            
    //         job.provincematched = job.employer_job_offer_preferred_job_location === $scope.locationFilter.province;
    //         job.citymatched =  job.employer_job_offer_preferred_job_city === $scope.locationFilter.city;            
            

    //         let match_percentage = $scope.calculateMatchPercentage(job);
    //         job.match_percentage = match_percentage;

    //         if (match_percentage > 0) {
    //             totalMatches += match_percentage;
    //             matchedJobs++;
    //         }
            
    //         // ✅ Update match flags for the job currently shown in modal
    //         if ($scope.viewpost_job_title && job.employer_job_offer_job_title_preferred === $scope.viewpost_job_title) {
    //             $scope.jobmatched = job.jobmatched;
    //             $scope.coursematched = job.coursematched;
    //             $scope.provincematched = job.provincematched;
    //             $scope.citymatched = job.citymatched;
    //         }            
    //     });

    //     if ($scope.viewpost_job_title) {
    //         const selectedJob = $scope.job_posts.find(job => job.employer_job_offer_job_title_preferred === $scope.viewpost_job_title);
    //         $scope.match_per = selectedJob ? selectedJob.match_percentage : 0;
    //     } else {
    //         $scope.match_per = matchedJobs > 0 ? totalMatches / matchedJobs : 0;
    //     }

    //     $scope.updateChart($scope.match_per);
    //     $scope.sortJobsByMatch(); 
    //     console.log("✅ Filtered match %:", $scope.match_per);
    // };


    // Modified by Lorenzo 
    //      @ 04/02/2025
    //      @ 04/24/2025
    $scope.selectedJobPostId = null;        // initial value, for applying active class
    $scope.dataLoaded = true;              // Initially, data is not loaded
    // Added by Lorenzo @ 05/05/2025
    $scope.reloadData = true;              // For loading animation when selecting job posting

    // $scope.job_post_selected = function(job_post_id) {

    //     $scope.reloadData = true;       // run the loading animation

    //     $http({
    //         method: 'POST',
    //         url: adminAjax.ajaxurl,
    //         headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    //         data: $.param({ 
    //             action: 'view_job_post',
    //             job_post_id: job_post_id
    //         })
    //     }).then(function (response) {
    //         $.each(response.data, function(index, job) {
    //             console.log("📌 Job Selected:", job.employer_job_offer_job_title_preferred);

    //             // Set job details
    //             $scope.viewpost_biz_name = job.business_name;
    //             $scope.viewpost_biz_logo = job.logo_url;
    //             $scope.viewpost_job_title = job.employer_job_offer_job_title_preferred;
    //             $scope.viewpost_job_shift = job.employer_job_offer_shifting_schedule;
    //             $scope.viewpost_job_work_mode = job.employer_job_offer_preferred_work_mode;
    //             $scope.viewpost_with_allowance = job.employer_job_offer_emp_provide_allowance;
    //             $scope.viewpost_biz_province = job.employer_job_offer_preferred_job_location;       // Added by Lorenzo @ 04/10/2025
    //             $scope.viewpost_biz_city = job.employer_job_offer_preferred_job_city;               // Added by Lorenzo @ 04/10/2025
    //             $scope.viewpost_immediate_hiring = (job.employer_job_offer_emp_ia === 'yes') 
    //                 ? '' 
    //                 : job.employer_job_offer_date_available_hiring;

    //             $scope.selectedJob = job;
                
    //             // ✅ Assign per-field match flags
    //             $scope.jobmatched = job.employer_job_offer_job_title_preferred === $scope.filterData.selectedRole;
    //             $scope.coursematched = job.employer_job_offer_emp_preferred_course === $scope.filterData.selectedCourse;
    //             $scope.provincematched = job.employer_job_offer_preferred_job_location === $scope.locationFilter.province;
    //             $scope.citymatched = job.employer_job_offer_preferred_job_city === $scope.locationFilter.city;
                                

    //             // Load languages
    //             $scope.selectedLanguagesModal = [];
    //             for (let i = 1; i <= 3; i++) {  
    //                 let lang = job[`employer_job_offer_emp_language${i}`];
    //                 let spoken = job[`employer_job_offer_emp_verbal${i}`];
    //                 let written = job[`employer_job_offer_emp_written${i}`];

    //                 if (lang) {
    //                     $scope.selectedLanguagesModal.push({
    //                         name: lang,
    //                         spoken: parseInt(spoken) || 0,
    //                         written: parseInt(written) || 0
    //                     });
    //                 }
    //             }

    //             // ✅ Use central match % calculator
    //             let match_percentage = $scope.calculateMatchPercentage(job);
    //             $scope.match_per = match_percentage;
    //             console.log("🎯 Selected Job Match %:", $scope.match_per);

    //             $timeout(() => $scope.updateChart($scope.match_per));
    //             $scope.$applyAsync();
    //             $scope.dataLoaded = true;                               // Set dataLoaded to true once all data is fetched

    //             // Modified by Lorenzo @ 04/24/2025
    //             $scope.selectedJobPostId = job_post_id;


    //             $scope.reloadData = false;          // Data is loaded, hide loading animation

    //         });

    //     }, function (error) {
    //         console.error("Error fetching job details:", error);
    //     });
    // };


    // $scope.sortJobsByMatch = function () {
    //     $scope.job_posts.sort((a, b) => b.match_percentage - a.match_percentage);
    // };
    


    // Function to reset selected filters and match percentage
    // $scope.resetFilters = function () {
    //     $scope.hasSearchedCourse = false;    
    //     $scope.hasSearchedJob = false;   
    //     $scope.hasSearchedProvince = false;    
    //     $scope.hasSearchedCity = false;    
    //     $scope.filterData.selectedCourse = null;
    //     $scope.filterData.selectedRole = null;
    //     $scope.locationFilter.province = null;
    //     $scope.locationFilter.city = null;
        
    //     $scope.jobmatched = null;
    //     $scope.coursematched = null;
    //     $scope.provincematched = null;
    //     $scope.citymatched = null;     
    //     $scope.match_per = 100;
    //     $scope.job_posts = angular.copy($scope.original_job_post);

    //     if ($scope.job_posts) {
    //         $scope.job_posts.forEach(job => {
    //             job.match_percentage = 100;
    //         });
    //     }

    //     $scope.updateChart($scope.match_per);
    //     $scope.sortJobsByMatch();
    // };


    /////
    
    
    //Added for Changing Realtime of View Job List 04/29/2025
    
    // $scope.hasSearchedCourse = false;    
    // $scope.hasSearchedJob = false;   
    // $scope.hasSearchedProvince = false;    
    // $scope.hasSearchedCity = false;    
    // $scope.resetFieldMatch = function(field) {
    //     console.log('Reset triggered by:', field);
    
    //     if (field === 'course') {
    //         $scope.coursematched = null;
    //         $scope.hasSearchedCourse = false;
    //     }
    //     if (field === 'role') {
    //         $scope.jobmatched = null;
    //         $scope.hasSearchedJob = false;
    //     }
    //     if (field === 'province') {
    //         $scope.provincematched = null;
    //         $scope.hasSearchedProvince = false;
    //     }
    //     if (field === 'city') {
    //         $scope.citymatched = null;
    //         $scope.hasSearchedCity = false;
    //     }
    
    //     $scope.hasSearched = false; // Always reset search status since any change means new search is needed
    // };

        
    
  





    // Handle search button state
    // Idea: Add a visual queue that the search button is disabled
    // Idea: highlight the filter in red border after displaying error
    // $scope.scrollToRoles = function() {
    //     const isCourseChanged = angular.element('#course-filter').val();
    //     const isRoleChanged = angular.element('#role-filter').val();

    //     const condition = isCourseChanged !== '' || isRoleChanged !== '';

    //     if (condition) {
    //         $timeout(() => {
    //             const rolesBlock = angular.element('#roles-block');
    //             if (rolesBlock.length) {
    //                 $window.scrollTo({
    //                     top: rolesBlock.offset().top,
    //                     behavior: 'smooth'
    //                 });
    //             }
    //         }, 0);
    //     } else {

    //         Swal.fire({
    //             title: 'Action Restricted',
    //             text: 'Please select a filter first!',
    //             icon: 'error',
    //             confirmButtonText: 'Ok'
    //         });
    //     }
    // };


    

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
        console.log("User Role (credentials.role):", $scope.credentials.role); 
        console.log("Compiled User Data:", userData);
        
            // Encrypt before storing
        var encryptedData = encryptData(userData);
        // Store in rootScope and sessionStorage
        $rootScope.userCredentials = encryptedData;
        $sessionStorage.userCredentials = encryptedData;
    
        console.log("Encrypted Credentials:", encryptedData);

        // 📨 Store raw email separately for OTP operations
        $sessionStorage.emailForOtp = userData.email;
        console.log("Email for OTP:", $sessionStorage.emailForOtp);

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
            
            console.log("OTP Sent:", response.data);
            
            
        
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
            console.error("OTP Error:", error.data.message || "Unknown error");

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
            console.error("Error checking username:", error);
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
        console.log("Checking email:", $scope.credentials.email);
        
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
            console.log("Email check response:", response.data);


            if (response.data.success && response.data.data.exists) {
                $scope.emailError = "Email is already registered.";
                $scope.emailValid = false;
            } else {
                $scope.emailValid = true;       // Email is now valid
                $scope.emailError = "";
            }

            
        }, function (error) {
            console.error("Error checking email:", error);
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
        }, 400); console.log('exits: ', $scope.currentModalContent)               
        $scope.currentModalContent = target;

        console.log(typeof target);
        console.log('active: ', $scope.currentModalContent)
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
            console.log('📦 Stored resetEmail:', $sessionStorage.resetEmail);

            
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
    
        console.log("📨 Email:", email);
        console.log("🔐 New Password:", newPassword);
        console.log("🔐 Confirm Password:", confirmPassword);
    
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
    
    $scope.submitContactForm = function () {
        const { name, email, mobile, message } = $scope.contactFormData;
    
        if (!name || !email || !mobile || !message) {
            alert('Please fill in all fields.');
            return;
        }
    
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
                })
                .catch(() => {
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