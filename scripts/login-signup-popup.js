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


//const body = document.body
//const mainCont = document.getElementById('main-cont')

//function openForm() {


//document.getElementById("myForm").style.display = "block";
//body.classList.add('no-scroll')
//mainCont.style.display = 'block'
//}

//function closeForm() {
//document.getElementById("myForm").style.display = "none";
//body.classList.remove('no-scroll')
//mainCont.style.display = 'none'
//}