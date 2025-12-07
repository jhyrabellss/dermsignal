let deliveryMethod = document.querySelectorAll('.radio-input-cont');
const currentLocation = document.getElementById('location')
const storeLocation = document.querySelector('.store-location-cont')
const checkOutShipping = document.querySelector('.checkout-shipping')

let currentLatitude, currentLongitude;

// Function to calculate shipping fee based on total price
function getShippingFee() {
    const totalPriceElement = document.querySelector('.total-price'); // Adjust selector to match your HTML
    if (!totalPriceElement) return 50;

    const totalPrice = parseFloat(totalPriceElement.textContent.replace(/[^0-9.]/g, ''));
    return totalPrice >= 500 ? 0 : 50;
}


deliveryMethod.forEach((deliveryMethod) => {
    deliveryMethod.addEventListener('click', () => {
        removeBackgroundActive()
        deliveryMethod.classList.add('background-color')
        if (deliveryMethod.getAttribute('id') === 'location') {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
                if (currentLocation.getAttribute('id') === 'location') {
                    storeLocation.style.display = 'block'
                }
                checkOutShipping.innerHTML = `  
                <div> Clinic Pickup</div>
                <div> Free </div>`
            }


            function showPosition(position) {
                currentLatitude = position.coords.latitude;
                currentLongitude = position.coords.longitude;

                calculateDistance()
            }
            function calculateDistance() {
                const selectedDestination = `14.70209, 121.02260`;

                const [destLat, destLon] = selectedDestination.split(',').map(Number);

                if (currentLatitude != null && currentLongitude != null) {
                    const distance = getDistanceFromLatLonInKm(currentLatitude, currentLongitude, destLat, destLon);
                    document.querySelector(".current-loc").innerHTML = `Derm Signal Skin Care Clinic (${distance.toFixed(2)} km)`;
                } else {
                    document.querySelector(".current-loc").innerHTML = "Please allow location access first.";
                }

                console.log(destLat);
            }


            // Haversine formula to calculate the distance
            function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
                const R = 6371; // Radius of the Earth in km
                const dLat = deg2rad(lat2 - lat1);
                const dLon = deg2rad(lon2 - lon1);
                const a =
                    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                    Math.sin(dLon / 2) * Math.sin(dLon / 2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                return R * c; // Distance in km
            }

            function deg2rad(deg) {
                return deg * (Math.PI / 180);
            }


            function showError(error) {
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        document.querySelector('.loc-status').innerHTML = `Couldn't get your current location. Try again.`
                        break;
                    case error.POSITION_UNAVAILABLE:
                        document.querySelector('.loc-status').innerHTML = `Couldn't get your current location. Try again.`
                        break;
                    case error.TIMEOUT:
                        document.querySelector('.loc-status').innerHTML = `Couldn't get your current location. Try again.`
                        break;
                    case error.UNKNOWN_ERROR:
                        document.querySelector('.loc-status').innerHTML = `Couldn't get your current location. Try again.`
                        break;
                }
            }
        }
        else {
            storeLocation.style.display = 'none'
            const shippingFee = getShippingFee();
            const shippingText = shippingFee === 0 ? 'Free' : `₱${shippingFee}`;
            checkOutShipping.innerHTML = `  
    <div> Shipping </div>
    <div> ${shippingText} </div>`
            document.querySelector('.loc-status').innerHTML = '';
        }
    });
})


function removeBackgroundActive() {
    deliveryMethod.forEach((deliveryMethod) => {
        deliveryMethod.classList.remove('background-color');
    });
}


const selectRegion = document.querySelector('select');
document.getElementById("myForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent form from submitting

    // Get all text and email input elements in the form
    const inputs = document.querySelectorAll("#myForm input[type='text'], #myForm input[type='email']");
    let allFilled = true;

    // Loop through each input to check if it is empty
    inputs.forEach(input => {
        // Reset any previous highlights
        input.classList.remove("highlight-red");

        // Get placeholder name
        const placeholderName = input.placeholder;
        console.log(placeholderName);

        let newElement = document.createElement('span');
        newElement.classList.add('span-design');
        // Check if the input is empty

        const existingMessage = input.parentNode.querySelector('.span-design');

        if (input.value.trim() === "") {
            input.classList.add("highlight-red");

            if (selectRegion.getAttribute('option-value' === '')) {
                selectRegion.classList.add('highlight-red');
            }


            const firstLetter = placeholderName.charAt(0).toLowerCase();
            const article = ['a', 'e', 'i', 'o', 'u'].includes(firstLetter) ? 'an' : 'a';

            // Check if the error message already exists (prevents duplicate messages)


            if (!existingMessage) { // Only append if the message doesn't exist
                newElement.innerHTML = `Enter ${article} ${placeholderName.toLowerCase()}`;
                newElement.style.color = "red";
                newElement.style.display = "block";
                input.style.marginBottom = '10px'
                input.parentNode.appendChild(newElement);
            }
        } else {
            if (existingMessage) {
                existingMessage.remove()
            }
        }

    });
});

document.getElementById("myForm").addEventListener("input", function () {
    const inputs = document.querySelectorAll("#myForm input[type='text'], #myForm input[type='email']");
    const allFilled = Array.from(inputs).every(input => input.value.trim() !== "");


    const submitButton = document.querySelector(".pay-now");


    if (allFilled) {
        submitButton.addEventListener('click', () => {
            window.location.href = 'https://m.gcash.com/gcash-login-web/index.html#/'
        })
    }


});