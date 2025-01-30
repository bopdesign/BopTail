/**
 * Allows the result of default HTML escaping for select2 templates and selections to be modified.
 *
 * @url https://www.advancedcustomfields.com/resources/javascript-api/#filters-select2_escape_markup
 */
// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function () {
	if (typeof acf !== 'undefined') {
		// Add a filter to the ACF object
		acf.add_filter('select2_escape_markup', function (escaped_value, original_value, select, settings, field, instance) {
			// Do something to the original_value to override the default escaping, then return it.
			// This value should still have some kind of escaping for security, but you may wish to allow specific HTML.
			if (field[0].dataset.name === 'color_picker' || field[0].dataset.name === 'gradient_picker' || field[0].dataset.name === 'social_name') {
				return original_value;
			}

			if (field[0].classList.contains('acf-clone')) {
				// Find the parent with the .acf-field-clone class and locate the .acf-field-name input
				let fieldClone = field.closest('.acf-field-clone');
				if (fieldClone) {
					let fieldName = fieldClone.querySelector('.acf-field-name');
					if (fieldName && (fieldName.value === 'color_picker' || fieldName.value === 'gradient_picker')) {
						// Return the original value without escaping
						return original_value;
					}
				}
			}

			// Return the default escaped value
			return escaped_value;
		});
	}
});
