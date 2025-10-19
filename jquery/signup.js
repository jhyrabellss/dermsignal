function validateInput(input) {
    
  input.value = input.value.replace(/\D/g, '');
}

function validateEmail(email) {
  const emailPattern = /^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|outlook\.com|hotmail\.com)$/;
  return emailPattern.test(email);
}

function validatePassword(password) {
  const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
  return passwordPattern.test(password);
}

function validateContactNo(contactNo) {
  const contactPattern = /^09\d{9}$/;
  return contactPattern.test(contactNo);
}

$(document).ready(() => {
  $(".button").on("click", function(event) {
      event.preventDefault();

      const fname = $('#fname').val();
      const mname = $('#mname').val();
      const lname = $('#lname').val();
      const email = $('#email').val();
      const username = $('#username').val();
      const password = $('#password').val();
      const confirmPass = $('#confirmPass').val();

      console.log({ email, username, password });

      if (email && username && password && confirmPass) {
          if (!validateEmail(email)) {
              Swal.fire({
                  title: "Invalid Email!",
                  text: "Please enter a valid email address from gmail.com, yahoo.com, etc.",
                  
              });
              return;
          }

          if (!validatePassword(password)) {
              Swal.fire({
                  title: "Weak Password!",
                  text: "Password must be at least 8 characters long and include at least one uppercase letter and one lowercase letter.",
                  
              });
              return;
          }


          //if (!validateContactNo(contactNo)) {
              //Swal.fire({
                  //title: "Invalid Contact Number!",
                  //text: "Contact number must be 11 digits long and start with 09.",
                  
              //});
              //return;
          //}

          if (password === confirmPass) {
              $.ajax({
                  url: "./backend/user/signup.php",
                  method: "post",
                  data: {
                      email,
                      username,
                      password,
                      fname,
                      lname,
                      mname
                  },
                  success: (response) => {
                      if (response !== "existed") {
                          Swal.fire({
                              title: "Registered Successfully",
                              text: "Account has been created",
                              
                          }).then((result) => {
                              if (result.isConfirmed) {
                                  window.location.href = window.location.href;
                              }
                          });
                      } else {
                          Swal.fire({
                              title: "Account Existed!",
                              text: "Your username/email already exists.",
                              
                          });
                      }
                  },
                  error: () => {
                      alert("Failed to connect!");
                  }
              });
          } else {
              Swal.fire({
                  title: "Password doesn't match!",
                  text: "Make sure that your password are the same.",
                  
              });
          }
      } else {
          Swal.fire({
              title: "Empty Field!",
              text: "Make sure all fields are filled.",
              
          });
      }
  });
});
console.log(email)