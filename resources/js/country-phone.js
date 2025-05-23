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

// Normalize and extract digits only
function extractDigits(value) {
    return value.replace(/\D/g, '');
}

// Format number as xxx xxx xxx
function formatLocalNumber(digits) {
    const sliced = digits.slice(0, 9);
    return `${sliced.slice(0, 3)} ${sliced.slice(3, 6)} ${sliced.slice(6, 9)}`.trim();
}

// Apply full formatting with country code
function formatPhoneNumber(rawNumber, selectedCountry) {
    const digits = extractDigits(rawNumber);

    // Strip existing country code if present
    const code = countryCodes[selectedCountry] || '';
    const cleanedDigits = digits.startsWith(code.replace('+', '')) ? digits.slice(code.length - 1) : digits;

    const localNumber = formatLocalNumber(cleanedDigits);
    return code + ' ' + localNumber;
}

// Event: update phone number when country changes
function updatePhoneNumber() {
    const locationSelect = document.getElementById('location');
    const phoneInput = document.getElementById('phone');
    
    if (locationSelect && phoneInput) {
        const selectedCountry = locationSelect.options[locationSelect.selectedIndex].text;
        const formatted = formatPhoneNumber(phoneInput.value, selectedCountry);
        phoneInput.value = formatted;
    }
}

// Validate input: clean up and enforce formatting
function validatePhoneInput(event) {
    const phoneInput = event.target;
    const digits = extractDigits(phoneInput.value);

    // Keep max 12 digits (country + 9-digit number)
    const trimmed = digits.slice(0, 12);

    // Allow user to continue typing; formatting happens on blur
    phoneInput.value = trimmed;
}

// On load: set correct country based on existing phone number
function initializePhoneNumber() {
    const locationSelect = document.getElementById('location');
    const phoneInput = document.getElementById('phone');

    if (locationSelect && phoneInput) {
        const currentValue = phoneInput.value.replace(/\s+/g, '');
        
        for (const [country, code] of Object.entries(countryCodes)) {
            if (currentValue.startsWith(code)) {
                for (let i = 0; i < locationSelect.options.length; i++) {
                    if (locationSelect.options[i].text === country) {
                        locationSelect.selectedIndex = i;
                        break;
                    }
                }
                break;
            }
        }

        locationSelect.addEventListener('change', updatePhoneNumber);
        phoneInput.addEventListener('input', validatePhoneInput);
        phoneInput.addEventListener('blur', updatePhoneNumber);

        if (phoneInput.value) {
            updatePhoneNumber();
        }
    }
}

document.addEventListener('DOMContentLoaded', initializePhoneNumber);
