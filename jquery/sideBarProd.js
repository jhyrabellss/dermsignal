$(document).ready(function(){
    $('.prod-type').click(function(e){
      e.preventDefault(); // Prevent the default link behavior
      var typeId = $(this).data('type-id');
      loadProducts(typeId);
    })
  })

  function loadProducts(typeId){
    $.ajax({
      url: 'products.php',
      type: 'GET',
      data: { type: typeId },
      success: function(response){
        window.location.href = "products.php?type=" + typeId;
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log("Error: " + textStatus, errorThrown);
      }
    })
  }