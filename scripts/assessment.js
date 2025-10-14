// Initialize current step and total steps
let currentStep = parseInt(localStorage.getItem('currentStep')) || 1;
const  totalSteps = 4; // Update this if you add more steps

// Show the selected step and hide others
function showStep(step) {
    document.querySelectorAll('.step').forEach((element) => {
        element.style.display = 'none';
    });
    const stepElement = document.getElementById(`step-${step}`);
    if (stepElement) {
        stepElement.style.display = 'block';
    }
    // Save the current step to localStorage
    localStorage.setItem('currentStep', step);
}





const skinAssessment = {
    skinTexture: [],
    skinType:[],
    skinConcern:[]
}   

let  selectedValue;
let skinTextureClass;
let skinTypeClass;
let skinConcernClass;
        

        
        document.querySelectorAll('.container-info').forEach(info => {
            info.addEventListener('click', () => {
                selectedValue = info.getAttribute('data-value');
                console.log('Selected value:', selectedValue);
        
                if (currentStep === 1) {
                    skinAssessment.skinTexture.push(selectedValue);
                    skinTextureClass = skinAssessment.skinTexture;
                    document.querySelector('.skin-texture-issue').innerHTML = `${skinTextureClass}`;
                    // Save to localStorage
                    localStorage.setItem('skinTextureClass', JSON.stringify(skinTextureClass));
                  
                } else if (currentStep === 2) {
                    skinAssessment.skinType.push(selectedValue);
                    skinTypeClass = skinAssessment.skinType;
                    document.querySelector('.skin-type-issue').innerHTML = `${skinTypeClass}`;
                    // Save to localStorage
                    localStorage.setItem('skinTypeClass', JSON.stringify(skinTypeClass));
                
                    console.log('Skin Type Array:', skinTypeClass);
                } else if (currentStep === 3) {
                    skinAssessment.skinConcern.push(selectedValue);
                    skinConcernClass = skinAssessment.skinConcern;
                    document.querySelector('.concern-issue').innerHTML = `${skinConcernClass}`;
                    // Save to localStorage
                    

               
                    localStorage.setItem('skinConcernClass', JSON.stringify(skinConcernClass));
                }
        
                 if (currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);   
                } else {
                    document.getElementById('submit-step').style.display = 'block';
                }
            });
        });
        
        // Get the feedback container

        let feedBack = document.querySelector('.consumer-feedback')
        // Check if there's a stored feedback message in localStorage
        const storedFeedback = localStorage.getItem('feedbackMessage');
        if (storedFeedback) {
            feedBack.innerHTML = storedFeedback; // Set the stored message if available
        }

        // Add an event listener to the parent container (event delegation)
        document.addEventListener('click', (event) => {
            // Check if the clicked element is a div with the class "container-info"
            if (event.target.closest('.container-info')) {
                // Get the data-value of the clicked element (the closest container-info div)
                const skinConcern = event.target.closest('.container-info').getAttribute('data-value');
                
                // Update the feedback with the value of the data-value
                const newFeedback = `89% of consumers said they saw visible action in ${skinConcern} after using this regimen`;
                feedBack.innerHTML = newFeedback;
                
                // Store the feedback message in localStorage
                localStorage.setItem('feedbackMessage', newFeedback);
            }
        });
        
        // Check if there's saved data in localStorage and load it
        window.addEventListener('load', () => {
            const savedSkinTexture = localStorage.getItem('skinTextureClass');
            const savedSkinType = localStorage.getItem('skinTypeClass');
            const savedSkinConcern = localStorage.getItem('skinConcernClass');
        
            // If data exists, parse it and set it to the appropriate elements
            if (savedSkinTexture) {
                skinTextureClass = JSON.parse(savedSkinTexture);
                document.querySelector('.skin-texture-issue').innerHTML = `${skinTextureClass}`;
            }
        
            if (savedSkinType) {
                skinTypeClass = JSON.parse(savedSkinType);
                document.querySelector('.skin-type-issue').innerHTML = `${skinTypeClass}`;
            }
        
            if (savedSkinConcern) {
                skinConcernClass = JSON.parse(savedSkinConcern);
                document.querySelector('.concern-issue').innerHTML = `${skinConcernClass}`;

            }
        });
        
        
        
        // Handle form submission
        document.querySelector('.retake-button').addEventListener('click', () => {
            localStorage.removeItem('skinTextureClass');
            localStorage.removeItem('skinTypeClass');
            localStorage.removeItem('currentStep');
            localStorage.removeItem('skinConcernClass');
            skinAssessment.skinTexture = [];
            skinAssessment.skinType = [];
            skinAssessment.skinConcern = [];

            currentStep = 1;
            showStep(currentStep);
           
        });

        //Prev Button Assessment
        document.querySelectorAll('.previous-button').forEach(prev =>{
            prev.addEventListener('click', () =>{
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
                localStorage.removeItem('skinTextureClass');
                localStorage.removeItem('skinTypeClass');
                localStorage.removeItem('currentStep');
                localStorage.removeItem('skinConcernClass');
                skinAssessment.skinTexture = [];
                skinAssessment.skinType = [];
                skinAssessment.skinConcern = [];
                console.log('LocalStorage items removed');
            }
            })
        })
            
      
        

   
        // Initialize the first step or saved step

        showStep(currentStep);
        localStorage.removeItem('currentStep');
        
        