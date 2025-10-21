$(document).ready(function(){
    $('.prod-type').click(function(e){
      e.preventDefault(); // Prevent the default link behavior
      var typeId = $(this).data('type-id');
      loadProducts(typeId);
    })

    $('.service-type').click(function(e){
      e.preventDefault(); // Prevent the default link behavior
      var service_name = $(this).data('service-name');
      console.log("Service Name: " + service_name);
      loadServices(service_name);
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

  function loadServices(service_name){
    $.ajax({
      url: 'service.php',
      type: 'GET',
      data: { service: service_name },
      success: function(response){
        window.location.href = "service.php?service=" + service_name;
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log("Error: " + textStatus, errorThrown);
      }
    })
  }

  
