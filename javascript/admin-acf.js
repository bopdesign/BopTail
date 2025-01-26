/**
 * Allows the result of default HTML escaping for select2 templates and selections to be modified.
 *
 * @url https://www.advancedcustomfields.com/resources/javascript-api/#filters-select2_escape_markup
 */
jQuery(document).ready(function ($) {
	if (typeof acf !== 'undefined') {
		// console.log('ACF is defined', acf);

		acf.add_filter('select2_escape_markup', function (escaped_value, original_value, $select, settings, field, instance) {
			// Do something to the original_value to override the default escaping, then return it.
			// This value should still have some kind of escaping for security, but you may wish to allow specific HTML.
			if ('color_picker' === field.data('name') || 'gradient_picker' === field.data('name')) {
				return original_value;
			}

			if (field.hasClass('acf-clone')) {
				// Get the name of the field
				var fieldName = field.closest('.acf-field-clone').find('.acf-field-name').val();

				// Check if the field name matches your specific field
				if ('color_picker' === fieldName || 'gradient_picker' === fieldName) {
					// Return the original value without escaping
					return original_value;
				}
			}

			// return
			return escaped_value;
		});
	}
});
