function fetchSecondaryVariants(url, productId) {
    fetch(url, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(response => {
        renderSecondaryValues(response.data, productId);
    })
    .catch(error => {
        console.error('Error fetching attribute values:', error);
    });
}

function renderSecondaryValues(data, productId) {
    // Get all secondary attribute value labels for the given product
    const secondaryValueLabels = document.querySelectorAll(`#secondary-values-${productId} .secondary-value-label`);
    // Get the IDs of available secondary attribute values from the response
    const availableValueIds = data.map(function(variant) {
        updateAvailableQuantityField(productId, variant.quantity);
        return variant.secondary_attribute_value.id;
    });
    // Loop through all secondary value labels and enable/disable based on fetched data
    secondaryValueLabels.forEach(label => {
        // Remove selection from all labels
        label.classList.remove('bg-primary');
        const span = document.querySelector('#selected-secondary-value');
        // Uncheck the associated radio input
        const radioInputId = label.getAttribute('for');
        const radioInput = document.getElementById(radioInputId);
        unselectRadio(radioInput);
        const valueId = parseInt(label.getAttribute('data-value-id'));
        if (availableValueIds[0] === valueId) {
            label.classList.add('bg-primary');
            if (span) {
                span.textContent = label.getAttribute('data-value');
            }
            selectRadio(radioInput);
            const selectedVariant = data.find(v => v.secondary_attribute_value.id === valueId);
            if (selectedVariant) {
                updateAvailableQuantityField(productId, selectedVariant.quantity);
            }
        }
        if (availableValueIds.includes(valueId)) {
            label.classList.remove('disabled');
            radioInput.disabled = false;
        } else {
            label.classList.add('disabled');
            radioInput.disabled = true;
        }

        if (radioInput) {
            radioInput.addEventListener('change', function () {
                secondaryValueLabels.forEach(l => l.classList.remove('bg-primary'));
                label.classList.add('bg-primary');
                if (span) {
                    span.textContent = label.getAttribute('data-value');
                }
                const selectedVariant = data.find(v => v.secondary_attribute_value.id === valueId);
                if (selectedVariant) {
                    updateAvailableQuantityField(productId, selectedVariant.quantity);
                }
            });
        }
    });
}

function updateAvailableQuantityField(productId, quantity) {
    const availableQuantityField = document.getElementById('available_quantity_' + productId);
    if (availableQuantityField) {
        availableQuantityField.value = quantity;
    }
}

function unselectRadio(radio) {
    if (radio) {
        radio.checked = false;
    }
}

function selectRadio(radio) {
    if (radio) {
        radio.checked = true;
    }
}

