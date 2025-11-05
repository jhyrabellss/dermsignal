$(document).ready(function() {
    $('#logoutButton').click(function() {
        // Perform AJAX request to logout.php
        $.ajax({
            url: './components/logout.php',  // This is where the PHP logout code is executed
            method: 'POST',
            success: function(response) {
                $('.nav-login-account-icon').html(''); // Remove the logout button
                $('.nav-login-account-icon').html('<div onclick="openForm(\'myFormSignUp\')">Sign up</div>'); // Show the sign-up button
                $('#main-cont').show()
                $('#myFormLogIn').show()
                $('body').css('overflow', 'hidden')
                $('.fa-regular').css('display', 'none')
                $('.fa-shopping-cart').css('display', 'none')
                $('.cart-counter').css('display', 'none')
                localStorage.removeItem('userDetails')
            },
            error: function(xhr, status, error) {
                // Handle any errors
                console.log("Logout failed: " + error);
            }
        });
    });
});

if(userDetails){
const userIcon = document.querySelector('.fa-user');
const dropdownMenu = document.getElementById('dropdownMenu');
let isDropdownVisible = false;


    userIcon.addEventListener('mouseenter', () => {
    if (!isDropdownVisible) {
        dropdownMenu.style.display = 'block';
    }
});

// Show the dropdown on click and toggle its visibility
userIcon.addEventListener('click', () => {
    if (isDropdownVisible) {
        dropdownMenu.style.display = 'none';
    } else {
        dropdownMenu.style.display = 'block';
    }
    isDropdownVisible = !isDropdownVisible; // Toggle the visibility state
});

// Hide the dropdown on mouse leave, only if it's not clicked
userIcon.addEventListener('mouseleave', () => {
    if (!isDropdownVisible) {
        dropdownMenu.style.display = 'none';
    }
});
}
console.log(userDetails)