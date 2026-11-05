
// REQUIRED FIELD ALERTS
document.addEventListener('invalid', function (event) {

    const field = event.target;
    const form = field.form;

    if (!form) return;

    event.preventDefault();

    const firstInvalid = Array.from(form.elements).find(
        element => element.willValidate && !element.validity.valid
    );

    if (field !== firstInvalid) return;

    const label = field.labels?.[0]?.textContent.trim()
        || field.name.replaceAll('_', ' ');

    if (field.validity.valueMissing) {
        alert('Please fill out the required field: ' + label);
    } else {
        alert('Please enter a valid value for: ' + label);
    }

    field.focus();

}, true);


// LETTERS-ONLY INPUT FIELDS
document.addEventListener('input', function (event) {

    const field = event.target;

    if (!(field instanceof HTMLInputElement)) return;

    // Fields that should contain letters instead of numbers.
    const lettersOnlyFields = [
        'name',
        'reference_name',
        'reference_relationship',
        'animal_preference_other',
        'preferred_breed',
        'shelter_source_other'
    ];

    if (!lettersOnlyFields.includes(field.name)) return;

    // Keep letters, spaces, periods, apostrophes and hyphens.
    field.value = field.value.replace(/[^\p{L}\s.'-]/gu, '');

});
