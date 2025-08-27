

let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

document.addEventListener('DOMContentLoaded', function() {

    const primaryAttributeSelect = document.querySelector('select[name="primary_attribute_id"]');
    const secondryAttributeSelect = document.querySelector('select[name="secondary_attribute_id"]');
    // Event listener for primary attribute select box
    if (primaryAttributeSelect) {
        primaryAttributeSelect.addEventListener('change', function() {
            fetchAttributeValues(this, "primary_attribute_value_id");
        });
    }
    // Event listener for secondry attribute select box
    if (secondryAttributeSelect) {
        secondryAttributeSelect.addEventListener('change', function() {
            fetchAttributeValues(this, "secondary_attribute_value_id");
        });
    }
});

function fetchAttributeValues(attributeSelect, selectName) {

    const selectedAttributeId = attributeSelect.value;
    const route = attributeSelect.dataset.getAttributeValuesUrl;
    if (selectedAttributeId && route) {
        const url = route.replace(':id', selectedAttributeId);        

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
        .then(data => {
            // Remove existing attribute value select box if it exists
            const existingSelect = document.querySelector('select[name="' + selectName + '"]');
            if (existingSelect) {
                existingSelect.parentElement.remove();
            }

            // Create new form-group for the attribute values select box
            const formGroup = document.createElement('div');
            formGroup.className = 'form-group col-md-6';

            // Create label
            const label = document.createElement('label');
            label.textContent = 'Attribute Value';

            // Create select box
            const select = document.createElement('select');
            select.name = selectName;
            select.className = 'form-control item';

            // Add default option
            const defaultOption = document.createElement('option');
            defaultOption.selected = true;
            defaultOption.disabled = true;
            defaultOption.textContent = 'Select value';
            select.appendChild(defaultOption);

            // Populate options from response
            data['attribute-values'].forEach(value => {
                const option = document.createElement('option');
                option.value = value.id;
                option.textContent = value.value_en;
                select.appendChild(option);
            });

            // Append label and select to form-group
            formGroup.appendChild(label);
            formGroup.appendChild(select);

            // Insert the new select box after the primary attribute select box
            attributeSelect.closest('.form-group').insertAdjacentElement('afterend', formGroup);
        })
        .catch(error => {
            console.error('Error fetching attribute values:', error);
        });
    } else {
        // Remove existing attribute value select box if no valid selection
        const existingSelect = document.querySelector('select[name="' + selectName + '"]');
        if (existingSelect) {
            existingSelect.parentElement.remove();
        }
    }
}

