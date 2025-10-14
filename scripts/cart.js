let body = $('body');
let listCartHtml = $('.item-cont');
let iconCartSpan = $('.cart-counter');

// Function to set the cart's display state based on localStorage
function setCartState() {
    const isCartOpen = localStorage.getItem('cartState') === 'open';
    if (isCartOpen) {
        body.addClass('showCart'); // Open cart if the state is "open"
    } else {
        body.removeClass('showCart'); // Close cart if the state is not "open"
    }
}

// Run the function on page load
setCartState();

// Event to show the cart
$('.nav-cart-icon').on('click', function () {
    body.toggleClass('showCart');
    // Save the cart's state to localStorage
    if (body.hasClass('showCart')) {
        localStorage.setItem('cartState', 'open');
    } else {
        localStorage.setItem('cartState', 'closed');
    }
});

// Event to close the cart tab
$('.exit').on('click', function () {
    body.toggleClass('showCart');
    // Save the cart's state to localStorage
    if (body.hasClass('showCart')) {
        localStorage.setItem('cartState', 'open');
    } else {
        localStorage.setItem('cartState', 'closed');
    }
});



$('.add-btn').on('click', function() {
  const prod_id = $(this).data("item-id");
  const button = $(this);
  if (prod_id) {
      $.ajax({
          url: "../backend/user/addQnty.php",
          method: "GET",
          data: { prod_id },
          success: function(response) {
              window.location.reload();
              let body = $('body');
              if(document.body.classList.contains('showCart')){
                body.classList.add('showCart');
              }
          },
          error: function() {
              alert("Connection Error!");
          }
      });
  }
});


$('.minus-btn').on('click', function() {
  const prod_id = $(this).data("item-id");
  const button = $(this);
  if (prod_id) {
      $.ajax({
          url: "../backend/user/minusQnty.php",
          method: "GET",
          data: { prod_id },
          success: function(response) {
              window.location.reload();
              let body = $('body');
              if(document.body.classList.contains('showCart')){
                body.classList.add('showCart');
              }
          },
          error: function() {
              alert("Connection Error!");
          }
      });
  }
});