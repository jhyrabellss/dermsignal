const categoryButtons = document.querySelectorAll('a .category-button');

categoryButtons.forEach(button => {
    button.addEventListener('click', () => {
        // Use '===' for comparison
        if (button.innerText === 'All') {
            clickedItem()
            button.classList.add('background-active')
        } else if (button.innerText === 'Acne') {
            clickedItem()
         
            button.classList.add('background-active')
        } else if (button.innerText === 'Acne Scars') {
            clickedItem()
         
            button.classList.add('background-active')
        } else if (button.innerText === 'Open Pores') {
            clickedItem()
      
            button.classList.add('background-active')
        } else if (button.innerText === 'Pigmentation') {
            clickedItem()
            button.classList.add('background-active')
        }
    });
});

function clickedItem(){
    categoryButtons.forEach(button =>{
        button.classList.remove('background-active')
    })
}
