const ingredientCategory = document.querySelector('.ingredients');
const ingredientCont = document.querySelector('.ingredient-cont');

// Function to set the display state based on localStorage
function setInitialDisplayState() {
    const isVisible = localStorage.getItem('ingredientContVisibleAcne') === 'true';

    if (isVisible) {
        ingredientCont.style.display = 'flex';
        ingredientCont.classList.add('ingredient-cont-style');
        ingredientCategory.classList.add('ingredients-arrow');
    } else {
        ingredientCont.style.display = 'none';
        ingredientCont.classList.remove('ingredient-cont-style');
        ingredientCategory.classList.remove('ingredients-arrow');
    }
}

// Run this on page load to apply the saved state
setInitialDisplayState();

// Add click event listener to toggle the visibility and save the state
ingredientCategory.addEventListener('click', () => {
    const isVisible = ingredientCont.classList.toggle('ingredient-cont-style');

    if (isVisible) {
        ingredientCont.style.display = 'flex';
        ingredientCategory.classList.add('ingredients-arrow');
    } else {
        ingredientCont.style.display = 'none';
        ingredientCategory.classList.remove('ingredients-arrow');
    }

    // Save the current state to localStorage
    localStorage.setItem('ingredientContVisibleAcne', isVisible);
});

const storedArray = localStorage.getItem('specificIngredientAcne');
const newIngredientArray = storedArray ? JSON.parse(storedArray) : [];

// Initialize specificIngredient with stored ingredients
let specificIngredientAcne = newIngredientArray;
const ingredientActiveBox = document.querySelectorAll('.ingredient-type')




document.addEventListener('DOMContentLoaded', () => {
    const activeBoxIndex = localStorage.getItem('activeBoxIndex');
    if (activeBoxIndex !== null) {
        ingredientActiveBox[activeBoxIndex].classList.add('style');
    }
});

// Add click event listeners
ingredientActiveBox.forEach((box, index) => {
    box.addEventListener('click', () => {
        removeStyle(); // Remove style from all boxes
        box.classList.toggle('style'); // Add style to the clicked box
        localStorage.setItem('activeBoxIndex', index); // Save the active box index
    });
});

// Function to remove styles from all boxes
function removeStyle() {
    ingredientActiveBox.forEach(box => {
        box.classList.remove('style');
    });
}

localStorage.removeItem(activeBoxIndex)