(function ($) {
	"use strict";

	function stea_hf_hide_meta_fields () {
		var selected = $( '#stea_hf_template_type' ).val() || 'none';
		$( '.stea-hf__meta-options-table' ).removeClass().addClass( 'stea-hf__meta-options-table widefat stea-hf-selected-template-type-' + selected );
	};

	$(document).on('change', '#stea_hf_template_type', () => stea_hf_hide_meta_fields() );

	stea_hf_hide_meta_fields();

	let selectElement = $('select[name="stea-hf-include-locations[rule][0]"]');
	let option = selectElement.find('option[value="basic-global"]');

	let templateType = $('#stea_hf_template_type').val();
	if ( templateType != 'header' || templateType != 'footer' ) {
		option.remove();
	}

	$('#stea_hf_template_type').on('change', function () {
		let selectElement = $('select[name="stea-hf-include-locations[rule][0]"]');
		let option = selectElement.find('option[value="basic-global"]');
		let basicOptgroup = selectElement.find('optgroup[label="Basic"]');
		if ($(this).val() != 'header' && $(this).val() != 'footer') {
			option.remove();
		} else {
			// Check if the option is not present and add it inside the "Basic" optgroup
			if (option.length === 0) {
				basicOptgroup.prepend('<option value="basic-global">Entire Website</option>');
			}
		}
	});

})(jQuery);
