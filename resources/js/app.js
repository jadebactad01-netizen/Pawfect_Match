document.addEventListener('invalid', function (event) {

    const field = event.target;
    const form = field.form;

    if (!form) return;

    // Prevent the browser's default validation message.
    event.preventDefault();

    // Find the first invalid field in the form.
    const firstInvalid = Array.from(form.elements).find(
        element => element.willValidate && !element.validity.valid
    );

    // Only show one alert at a time.
    if (field !== firstInvalid) return;

    // Get the field's label.
    const label = field.labels?.[0]?.textContent.trim()
        || field.name.replaceAll('_', ' ');

    // Show the appropriate alert.
    if (field.validity.valueMissing) {
        alert('Please fill out the required field: ' + label);
    } else {
        alert('Please enter a valid value for: ' + label);
    }

    // Focus the field that needs correction.
    field.focus();

}, true);
