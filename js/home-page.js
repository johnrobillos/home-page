// $('document').ready(function() {


//     console.log("Testing...");

//     // Idea: Add a visual queue that the search button is disabled
//     // $("#roles-block-scroll").click(function() {

        
//     //     let $isCourseChanged = $('#course-filter').val();
//     //     let $isRoleChanged = $('#role-filter').val();
        
//     //     let $condition = $isCourseChanged !== '' || $isRoleChanged !== '';
        
//     //     if($condition) {

//     //         $('html, body').animate({
//     //             scrollTop: $('#roles-block').offset().top
//     //         }, 500); 

//     //     } else {



//     //     }
        
        
        
        

//     // })

    



//     // Handle state and animation of the information-entry-modal 
//     $('.trigger-entry-modal').on('click', function() {

//         console.log("Button fired");

//         if ($('#modal-overlay').hasClass('active')) {

//             $('#modal-overlay').removeClass('active');
//             $('#information-entry-modal').removeClass('active');

//         } else {

//             $('#modal-overlay').addClass('active');
//             $('#information-entry-modal').addClass('active');

//         }

//     })




//     // Handles the content animation and setting state of information-entry-modal 
//     // (Login and register modal)
//     const $loginContent = $('#login-content');
//     const $registerContent = $('#register-content');
//     const $verifyContent = $('#verify-content');

//     const $registerLink = $('#register-account');
//     const $loginLink = $('.login-account');
//     const $createAccBtn = $('#create-acc-btn');

//     // Register Click
//     $registerLink.on('click', function () {

//         $loginContent.addClass('active-slide-out').removeClass('active-slide-in');
//         setTimeout(() => {
//             $registerContent.addClass('active-slide-in').removeClass('active-slide-out');
//         }, 400); // Should be tha same time as the transition time in css

//     });

//     // Login Click
//     $loginLink.on('click', function () {

//         $registerContent.addClass('active-slide-out').removeClass('active-slide-in');
//         $verifyContent.addClass('active-slide-out').removeClass('active-slide-in');
//         setTimeout(() => {
//             $loginContent.addClass('active-slide-in').removeClass('active-slide-out');
//         }, 400); // Should be tha same time as the transition time in css
        
//     });

//     // Create Account Click
//     $createAccBtn.on('click', function () {

//         $registerContent.addClass('active-slide-out').removeClass('active-slide-in');
//         setTimeout(() => {
//             $verifyContent.addClass('active-slide-in').removeClass('active-slide-out');
//         }, 400); // Should be tha same time as the transition time in css

//     })







// })