// Country code mapping
const countryCodes = {
    'Ghana': '+233',
    'Nigeria': '+234',
    'Ivory Coast': '+225',
    'Senegal': '+221',
    'Togo': '+228',
    'Benin': '+229',
    'Liberia': '+231',
    'Sierra Leone': '+232',
    'Burkina Faso': '+226',
    'Mali': '+223',
    'Guinea': '+224',
    'Guinea-Bissau': '+245',
    'The Gambia': '+220',
    'Cape Verde': '+238',
    'Niger': '+227'
};

// Function to format phone number
function formatPhoneNumber(number) {
    // Remove all non-digit characters
    const digits = number.replace(/\D/g, '');
    
    // Limit to 9 digits (excluding country code)
    const limitedDigits = digits.slice(0, 9);
    
    // Format into groups of 3
    return `${limitedDigits.slice(0, 3)} ${limitedDigits.slice(3, 6)} ${limitedDigits.slice(6, 9)}`;
}

// Function to update phone number with country code
function updatePhoneNumber() {
    const locationSelect = document.getElementById('location');
    const phoneInput = document.getElementById('phone');
    
    if (locationSelect && phoneInput) {
        const selectedCountry = locationSelect.options[locationSelect.selectedIndex].text;
        const countryCode = countryCodes[selectedCountry] || '';
        
        // Get current phone number without country code
        let currentNumber = phoneInput.value;
        if (currentNumber.startsWith('+')) {
            // Remove the current country code and any spaces
            currentNumber = currentNumber.substring(4).replace(/\s/g, '');
        }
        
        // Format and update phone number with new country code
        const formattedNumber = formatPhoneNumber(currentNumber);
        phoneInput.value = countryCode + ' ' + formattedNumber;
    }
}

// Function to validate phone number input
function validatePhoneInput(event) {
    const phoneInput = event.target;
    let value = phoneInput.value;
    
    // Remove all non-digit characters except plus sign
    value = value.replace(/[^\d+]/g, '');
    
    // Ensure only one plus sign at the start
    if (value.includes('+')) {
        value = '+' + value.replace(/\+/g, '');
    }
    
    // Limit to 12 digits total (3 for country code + 9 for number)
    if (value.length > 12) {
        value = value.slice(0, 12);
    }
    
    // Update the input value
    phoneInput.value = value;
}

// Function to initialize phone number
function initializePhoneNumber() {
    const locationSelect = document.getElementById('location');
    const phoneInput = document.getElementById('phone');
    
    if (locationSelect && phoneInput) {
        // If phone number already exists, extract the country code
        if (phoneInput.value) {
            const currentValue = phoneInput.value;
            const countryCode = currentValue.substring(0, 4); // Get the first 4 characters (e.g., +233)
            
            // Find the country that matches this code
            for (const [country, code] of Object.entries(countryCodes)) {
                if (code === countryCode) {
                    // Find the option with matching text
                    for (let i = 0; i < locationSelect.options.length; i++) {
                        if (locationSelect.options[i].text === country) {
                            locationSelect.selectedIndex = i;
                            break;
                        }
                    }
                    break;
                }
            }
        }
        
        // Add event listeners
        locationSelect.addEventListener('change', function() {
            // Get the phone number without the current country code
            let currentNumber = phoneInput.value;
            if (currentNumber.startsWith('+')) {
                currentNumber = currentNumber.substring(4).replace(/\s/g, '');
            }
            
            // Update the phone number with the new country code
            const selectedCountry = locationSelect.options[locationSelect.selectedIndex].text;
            const countryCode = countryCodes[selectedCountry] || '';
            const formattedNumber = formatPhoneNumber(currentNumber);
            phoneInput.value = countryCode + ' ' + formattedNumber;
        });
        
        phoneInput.addEventListener('input', validatePhoneInput);
        phoneInput.addEventListener('blur', updatePhoneNumber);
        
        // Set maxlength attribute to prevent typing more than needed
        phoneInput.setAttribute('maxlength', '12');
        
        // Trigger initial update if there's a value
        if (phoneInput.value) {
            updatePhoneNumber();
        }
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', initializePhoneNumber); 