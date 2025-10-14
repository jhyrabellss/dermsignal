const input = document.querySelector('.custom-comment')
const commentButton = document.querySelectorAll('.comment-buttons button')
const cancelButton = document.querySelector('.cancel-button')
const writeCommentButton = document.querySelector('.write-comment-button')
const nameInitial = document.querySelector('.name-initial-custom')
const starRating = document.querySelectorAll('.stars i')



input.addEventListener('focus', () =>{
  commentButton.forEach(button =>{
    button.style.display = 'block'
  })
})

cancelButton.addEventListener('click', () =>{
  commentButton.forEach(button =>{
    button.style.display = 'none'
  })
})
 
 input.addEventListener('input', () =>{
  if(input.value === ''){
    writeCommentButton.style.backgroundColor = '';
    writeCommentButton.style.transition = 'all 0.5s ease';
  }
  else{
     writeCommentButton.style.backgroundColor = 'var(--background-color)'
    writeCommentButton.style.transition = 'all 0.5s ease';
  }
})

  // Select all elements with the "i" tag and store them in a NodeList called "stars"
  const stars = document.querySelectorAll(".stars i");

  // Loop through the "stars" NodeList
  stars.forEach((star, index1) => {
    // Add an event listener that runs a function when the "click" event is triggered
    star.addEventListener("click", () => {
      // Loop through the "stars" NodeList Again
      stars.forEach((star, index2) => {
        // Add the "active" class to the clicked star and any stars with a lower index
        // and remove the "active" class from any stars with a higher index
        index1 >= index2 ? star.classList.add("active") : star.classList.remove("active");
      });
    });
  });





  const commentCont = document.querySelector('.comments-main-cont')

  starRating.forEach(star => {
    star.addEventListener('click', (event) => {
      const clickedStar = event.target;
      let ratingValue = clickedStar.getAttribute('data-value');
      localStorage.setItem('rating-value', ratingValue);
      document.querySelector('.rating-box').classList.add('rating-box-display');
      document.querySelector('.rating-box').innerHTML = 'Thank you for rating!!';
      
      // Set a timeout to hide the rating box after 5 seconds
      setTimeout(() => {
        document.querySelector('.rating-box').style.opacity = '0';
      }, 1000);
      document.querySelector('.rating-box').style.transition = 'opacity 1s ease'
    });
  });
  


  
   
 

  input.addEventListener('keydown', (event) =>{
    if(event.key ==='Enter'){
      handleCommentSubmit()
    }
  })




  function addCommentToHTML(commentContents){
    const newDiv = document.createElement('div')
    newDiv.classList.add('comments-cont');
    const starRating = parseInt(commentContents.rating)

    newDiv.innerHTML =`
      <div class="name-initial">${commentContents.initial}</div>
          <div>
            <div>
              ${commentContents.name} | ${commentContents.date}</div>
              <div class="rated">
                <div> <svg class ="rating-icon" xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                  <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"></path></svg></div>
                  <div>${starRating.toFixed(1)}</div>
              </div>
            <div class="commented">${commentContents.comment}</div>
          </div>
    `;
    commentCont.appendChild(newDiv)
  }

  console.log(localStorage.getItem('comments'))

  //Nilagay ko here to reset the comments when needed.
  
  localStorage.removeItem('comments')
