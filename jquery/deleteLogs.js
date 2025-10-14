$(document).ready(()=>{
    $('#delete-logs').on('click', function(){

        Swal.fire({
            title: "Are you sure?",
            text: "This log will be deleted.",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                url: "../backend/admin/deleteLogs.php",
                method: "post",
                success: function(response){
                    if(response === 'success'){
                        window.location.reload();
                    }
                },
                error: function(){
                    alert("Connection Error")
                }
              })
            }
          });
    })
});