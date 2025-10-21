let slideIndex = 1;
let autoSlideInterval;

// Wait for DOM to be fully loaded
document.addEventListener("DOMContentLoaded", function() {
    showSlides(slideIndex);
    
    // Start automatic sliding after initial display
    autoSlideInterval = setInterval(function() {
        plusSlides(1);
    }, 3000); // Change slide every 3 seconds
});

function plusSlides(n) {
    clearInterval(autoSlideInterval);
    showSlides(slideIndex += n);
    
    autoSlideInterval = setInterval(function() {
        plusSlides(1);
    }, 3000);
}

function currentSlide(n) {
    clearInterval(autoSlideInterval);
    showSlides(slideIndex = n);
    
    autoSlideInterval = setInterval(function() {
        plusSlides(1);
    }, 3000);
}

function showSlides(n) {
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");
    
    if (slides.length === 0 || dots.length === 0) {
        return;
    }
    
    if (n > slides.length) {
        slideIndex = 1;
    }
    if (n < 1) {
        slideIndex = slides.length;
    }
    
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    
    for (let i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";
}