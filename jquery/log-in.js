$(document).ready(() => {
  $("#submit").on("click", function(e) {
    e.preventDefault(); // Prevent form submission

    const username = $("#uname").val();
    const password = $("#pass").val();

    if (username && password) {
      $.ajax({
        url: "../backend/user/login.php",
        method: "post",
        data: {
          username,
          password
        },
        success: function(response) {
          if (response === "Invalid Password") {
            Swal.fire({
              title: "Invalid Password",
              showConfirmButton: false,
              timer: 3000,
            });
          } else if (response === "deactivated") {
            Swal.fire({
              title: "Account Deactivated!",
              showConfirmButton: false,
              timer: 3000,
            });
          } else {
            console.log(response);
            Swal.fire({
              title: "Welcome back!",
              text: "Successfully Logged in",
              showConfirmButton: false,
              timer: 3000,
            }).then(() => { // Redirection happens after the modal closes
              const data = JSON.parse(response);
              if (data.role_id == 1) {
                localStorage.setItem("userDetails", response);
                window.location.href = window.location.href;
              } else if (data.role_id == 2) {
                localStorage.setItem("adminDetails", response);
                window.location.href = "../admin/index.php";
              } else if (data.role_id == 3) {
                localStorage.setItem("cashierDetails", response);
                window.location.href = "../cashier1/index.php";
              }
            });
          }
        },
        error: function() {
          alert("Connection Error");
        }
      });
    }
  });
});
