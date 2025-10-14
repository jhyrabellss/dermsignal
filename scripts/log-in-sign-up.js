document.addEventListener('DOMContentLoaded', function() {
  window.openForm = function(name) {
  document.getElementById(name).style.display = "block";
  document.body.classList.add('no-scroll');
  document.getElementById('main-cont').style.display = 'block';
  if(name === 'myFormSignUp'){
      document.getElementById('myFormLogIn').style.display = 'none'

  }
  if(name === 'myFormLogIn'){
      document.getElementById('myFormSignUp').style.display = 'none'
  }
  }
  

  window.closeForm = function(name) {
  document.getElementById(name).style.display = "none";
  document.body.classList.remove('no-scroll');
  document.getElementById('main-cont').style.display = 'none';
  };
});