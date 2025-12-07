// ============================================
// EXISTING LOGOUT FUNCTIONALITY
// ============================================
$(document).ready(function() {
    $('#logoutButton').click(function() {
        $.ajax({
            url: 'logout.php',
            method: 'POST',
            success: function(response) {
                $('.nav-login-account-icon').html('');
                $('.nav-login-account-icon').html('<div onclick="openForm(\'myFormSignUp\')">Sign up</div>');
                $('#main-cont').show()
                $('#myFormLogIn').show()
                $('body').css('overflow', 'hidden')
                $('.fa-regular').css('display', 'none')
                $('.fa-shopping-cart').css('display', 'none')
                $('.cart-counter').css('display', 'none')
                localStorage.removeItem('userDetails')
                window.location.reload()
            },
            error: function(xhr, status, error) {
                console.log("Logout failed: " + error);
            }
        });
    });
});

// ============================================
// EXISTING USER DROPDOWN FUNCTIONALITY
// ============================================
const userDetails = localStorage.getItem('userDetails')

if(userDetails){
    const userIcon = document.querySelector('.fa-user');
    const dropdownMenu = document.getElementById('dropdownMenu');
    
    if (userIcon && dropdownMenu) {
        let isDropdownVisible = false;

        userIcon.addEventListener('mouseenter', () => {
            if (!isDropdownVisible) {
                dropdownMenu.style.display = 'block';
            }
        });

        userIcon.addEventListener('click', () => {
            if (isDropdownVisible) {
                dropdownMenu.style.display = 'none';
            } else {
                dropdownMenu.style.display = 'block';
            }
            isDropdownVisible = !isDropdownVisible;
        });

        userIcon.addEventListener('mouseleave', () => {
            if (!isDropdownVisible) {
                dropdownMenu.style.display = 'none';
            }
        });
    }
}

console.log(userDetails)

// ============================================
// MOBILE LOGIN SECTION UPDATE FUNCTION
// ============================================
function updateMobileLoginSection() {
    // Remove existing mobile login section
    $('.mobile-login-section').remove();
    
    const userDetails = localStorage.getItem('userDetails');
    let mobileLoginHTML = '';

    if (userDetails) {
        // User is logged in
        mobileLoginHTML = `
            <div class="mobile-login-section">
                <div class="mobile-user-info">
                    <i class="fa-regular fa-user"></i>
                    <span class="mobile-user-name">My Account</span>
                </div>
                <div class="mobile-menu-links">
                    <a href="../components/profile.php">Profile</a>
                    <a href="../components/orders.php">Orders</a>
                </div>
                <button class="mobile-logout-btn" id="mobileLogoutButton">Log Out</button>
            </div>
        `;
    } else {
        // User is not logged in
        mobileLoginHTML = `
            <div class="mobile-login-section">
                <div class="mobile-guest-section">
                    <button class="mobile-login-btn" onclick="openForm('myFormSignUp')">Sign Up / Log In</button>
                </div>
            </div>
        `;
    }

    $('.nav-text-cont').prepend(mobileLoginHTML);
}


function applyMobileViewStyles() {
    const windowWidth = $(window).width();
    
    if (windowWidth <= 1024) {
        // Apply mobile-specific styles
        $('body').addClass('mobile-view');
        
        // Ensure dropdowns are hidden on mobile load
        $('.concern-dropdown-cont, .ingredient-dropdown-cont').hide();
        
        // Ensure mobile menu is closed on load
        $('.nav-hamburger').removeClass('active');
        $('.nav-text-cont').removeClass('active');
        $('.nav-overlay').removeClass('active');
        $('body').removeClass('menu-open');
        
        // Hide desktop user dropdown
        $('#dropdownMenu').hide();
        
        // Initialize mobile login section
        updateMobileLoginSection();
    } else {
        // Desktop view
        $('body').removeClass('mobile-view');
        
        // Show desktop elements
        $('.nav-searchbar-cont').show();
        $('.nav-right-icon .nav-login-account-icon').show();
        
        // Remove mobile login section if exists
        $('.mobile-login-section').remove();
        
        // Reset any mobile menu states
        $('.nav-hamburger').removeClass('active');
        $('.nav-text-cont').removeClass('active').removeAttr('style');
        $('.nav-overlay').removeClass('active');
        $('body').removeClass('menu-open');
        
        // Ensure dropdowns work properly on desktop
        $('.concern-dropdown-cont, .ingredient-dropdown-cont').removeAttr('style');
    }
}

// ============================================
// MOBILE MENU FUNCTIONALITY
// ============================================
$(document).ready(function() {
    // Create hamburger menu if it doesn't exist
    if ($('.nav-hamburger').length === 0) {
        $('.nav-logo').after(`
            <div class="nav-hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        `);
    }

    // Create overlay if it doesn't exist
    if ($('.nav-overlay').length === 0) {
        $('body').append('<div class="nav-overlay"></div>');
    }

    // Apply mobile view styles on page load
    applyMobileViewStyles();

    // Mobile logout button handler
    $(document).on('click', '#mobileLogoutButton', function() {
        $.ajax({
            url: 'logout.php',
            method: 'POST',
            success: function(response) {
                localStorage.removeItem('userDetails');
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.log("Logout failed: " + error);
            }
        });
    });

    // Toggle mobile menu
    $(document).on('click', '.nav-hamburger', function() {
        $(this).toggleClass('active');
        $('.nav-text-cont').toggleClass('active');
        $('.nav-overlay').toggleClass('active');
        $('body').toggleClass('menu-open');
    });

    // Close menu when overlay is clicked
    $(document).on('click', '.nav-overlay', function() {
        $('.nav-hamburger').removeClass('active');
        $('.nav-text-cont').removeClass('active');
        $(this).removeClass('active');
        $('body').removeClass('menu-open');
    });

    // Close menu when "All Product" or "Services" links are clicked
    $(document).on('click', '.nav-allprod-cont a', function() {
        if ($(window).width() <= 1024) {
            $('.nav-hamburger').removeClass('active');
            $('.nav-text-cont').removeClass('active');
            $('.nav-overlay').removeClass('active');
            $('body').removeClass('menu-open');
        }
    });

    // Handle dropdown toggles on mobile - click only, no hover
    $(document).on('click', '.nav-concern-cont, .nav-ingredients-cont', function(e) {
        if ($(window).width() <= 1024) {
            e.preventDefault();
            e.stopPropagation();
            
            const $clickedItem = $(this);
            const $dropdown = $clickedItem.next('.concern-dropdown-cont, .ingredient-dropdown-cont');
            const isOpen = $dropdown.is(':visible');
            
            // Close all dropdowns and remove open class
            $('.concern-dropdown-cont, .ingredient-dropdown-cont').slideUp(300);
            $('.nav-concern-cont, .nav-ingredients-cont').removeClass('open');
            
            // If the clicked dropdown was closed, open it
            if (!isOpen) {
                $dropdown.slideDown(300);
                $clickedItem.addClass('open');
            }
        }
    });

    // Prevent hover events on mobile for dropdowns
    $(document).on('mouseenter mouseleave', '.nav-concern-cont, .nav-ingredients-cont', function(e) {
        if ($(window).width() <= 1024) {
            e.preventDefault();
            e.stopPropagation();
            return false;
        }
    });

    // Close menu when clicking on dropdown product/ingredient links
    $(document).on('click', '.concern-dropdown-cont a, .ingredient-dropdown-cont a', function(e) {
        if ($(window).width() <= 1024) {
            setTimeout(function() {
                $('.nav-hamburger').removeClass('active');
                $('.nav-text-cont').removeClass('active');
                $('.nav-overlay').removeClass('active');
                $('body').removeClass('menu-open');
                $('.concern-dropdown-cont, .ingredient-dropdown-cont').slideUp(300);
            }, 100);
        }
    });

    // Close menu when clicking on Free Skin Assessment
    $(document).on('click', '.nav-free-skin-assessment-cont', function() {
        if ($(window).width() <= 1024) {
            $('.nav-hamburger').removeClass('active');
            $('.nav-text-cont').removeClass('active');
            $('.nav-overlay').removeClass('active');
            $('body').removeClass('menu-open');
        }
    });
});

let resizeTimer;
$(window).resize(function() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
        applyMobileViewStyles();
    }, 250);
});

$(window).on('orientationchange', function() {
    setTimeout(function() {
        applyMobileViewStyles();
    }, 300);
});