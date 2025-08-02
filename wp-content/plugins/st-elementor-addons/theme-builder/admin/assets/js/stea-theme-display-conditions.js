(function ( $ ) {

	var init_display_conditions  = function( selector ) {
		
		$(selector).select2({

			placeholder: stea_display_conditions.search,

			ajax: {
			    url: ajaxurl,
			    dataType: 'json',
			    method: 'post',
			    delay: 250,
			    data: function (params) {
			      	return {
			        	q: params.term, // search term
				        page: params.page,
						action: 'stea_hfe_get_posts_by_query',
						nonce: stea_display_conditions.ajax_nonce
			    	};
				},
				processResults: function (data) {
		            return {
		                results: data
		            };
		        },
			    cache: true
			},
			minimumInputLength: 2,
			language: stea_display_conditions.stea_lang
		});
	};

	var update_display_conditions_input = function(wrapper) {
		var new_value = [];
		
		wrapper.find('.stea-hf__display-condition').each(function(i) {
			
			var $this 			= $(this);
			var temp_obj 		= {};
			var rule_condition 	= $this.find('select.stea-hf__display-condition-input');
			var specific_page 	= $this.find('select.stea-hf__display-condition-specific-page');

			var rule_condition_val 	= rule_condition.val();
			var specific_page_val 	= specific_page.val();
			
			if ( '' != rule_condition_val ) {

				temp_obj = {
					type 	: rule_condition_val,
					specific: specific_page_val
				} 
				
				new_value.push( temp_obj );
			};
		})
	};

	var update_close_button = function(wrapper) {

		type 		= wrapper.closest('.stea-hf__display-condition-container').attr('data-type');
		rules 		= wrapper.find('.stea-hf__display-condition');
		show_close	= false;

		if ( 'display' == type ) {
			if ( rules.length > 1 ) {
				show_close = true;
			}
		}else{
			show_close = true;
		}

		rules.each(function() {
			if ( show_close ) {
				jQuery(this).find('.stea-hf__display-condition-delete').removeClass('stea-hf__element-hidden');
			}else{
				jQuery(this).find('.stea-hf__display-condition-delete').addClass('stea-hf__element-hidden');
			}
		});
	};

	var update_exclusion_button = function( force_show, force_hide ) {
		var display_on = $('.stea-hf__display-condition-display-on-wrap');
		var exclude_on = $('.stea-hf__display-condition-exclude-on-wrap');
		
		var exclude_field_wrap = exclude_on.closest('tr');
		var add_exclude_block  = display_on.find('.stea-hf__add-exclude-display-condition-wrapper');
		var exclude_conditions = exclude_on.find('.stea-hf__display-condition');
		
		if ( true == force_hide ) {
			exclude_field_wrap.addClass( 'stea-hf__element-hidden' );
			add_exclude_block.removeClass( 'stea-hf__element-hidden' );
		}else if( true == force_show ){
			exclude_field_wrap.removeClass( 'stea-hf__element-hidden' );
			add_exclude_block.addClass( 'stea-hf__element-hidden' );
		}else{
			
			if ( 1 == exclude_conditions.length && '' == $(exclude_conditions[0]).find('select.stea-hf__display-condition-input').val() ) {
				exclude_field_wrap.addClass( 'stea-hf__element-hidden' );
				add_exclude_block.removeClass( 'stea-hf__element-hidden' );
			}else{
				exclude_field_wrap.removeClass( 'stea-hf__element-hidden' );
				add_exclude_block.addClass( 'stea-hf__element-hidden' );
			}
		}

	};

	$(document).ready(function($) {

		jQuery( '.stea-hf__display-condition' ).each( function() {
			var $this 			= $( this ),
				condition 		= $this.find('select.stea-hf__display-condition-input'),
				condition_val 	= condition.val(),
				specific_page 	= $this.next( '.stea-hf__display-condition-specific-page-wrapper' );

			if( 'specifics' == condition_val ) {
				specific_page.slideDown( 300 );
			}
		} );

		
		jQuery('select.stea-hf__display-condition-select2').each(function(index, el) {
			init_display_conditions( el );
		});

		jQuery('.stea-hf__display-condition-container').each(function() {
			update_close_button( jQuery(this) );
		})

		/* Show hide exclusion button */
		update_exclusion_button();

		jQuery( document ).on( 'change', '.stea-hf__display-condition select.stea-hf__display-condition-input' , function( e ) {
			
			var $this 		= jQuery(this),
				this_val 	= $this.val(),
				field_wrap 	= $this.closest('.stea-hf__display-condition-container');

			if( 'specifics' == this_val ) {
				$this.closest( '.stea-hf__display-condition' ).next( '.stea-hf__display-condition-specific-page-wrapper' ).slideDown( 300 );
			} else {
				$this.closest( '.stea-hf__display-condition' ).next( '.stea-hf__display-condition-specific-page-wrapper' ).slideUp( 300 );
			}

			update_display_conditions_input( field_wrap );
		} );

		jQuery( '.stea-hf__display-condition-container' ).on( 'change', '.stea-hf__display-condition-select2', function(e) {
			var $this 		= jQuery( this ),
				field_wrap 	= $this.closest('.stea-hf__display-condition-container');

			update_display_conditions_input( field_wrap );
		});
		
		jQuery( '.stea-hf__display-condition-container' ).on( 'click', '.stea-hf__add-include-display-condition-wrapper a', function(e) {
			e.preventDefault();
			e.stopPropagation();
			var $this 	= jQuery( this ),
				id 		= $this.attr( 'data-rule-id' ),
				new_id 	= parseInt(id) + 1,
				type 	= $this.attr( 'data-rule-type' ),
				rule_wrap = $this.closest('.stea-hf__display-condition-container').find('.stea-hf__display-condition-builder-wrapper'),
				template  = wp.template( 'stea-hf-display-conditions-' + type + '-condition' ),
				field_wrap 		= $this.closest('.stea-hf__display-condition-container');

			rule_wrap.append( template( { id : new_id, type : type } ) );
			
			init_display_conditions( '.stea-hf-display-condition-'+type+'-on .stea-hf__display-condition-select2' );
			
			$this.attr( 'data-rule-id', new_id );

			update_close_button( field_wrap );
		});

		jQuery( '.stea-hf__display-condition-container' ).on( 'click', '.stea-hf__display-condition-delete', function(e) {
			var $this 			= jQuery( this ),
				rule_condition 	= $this.closest('.stea-hf__display-condition'),
				field_wrap 		= $this.closest('.stea-hf__display-condition-container');
				cnt 			= 0,
				data_type 		= field_wrap.attr( 'data-type' ),
				optionVal 		= $this.siblings('.stea-hf__display-condition-wrapper').children('.stea-hf__display-condition-input').val();

			if ( 'exclude' == data_type ) {
					
				if ( 1 === field_wrap.find('.stea-hf__display-condition-input').length ) {

					field_wrap.find('.stea-hf__display-condition-input').val('');
					field_wrap.find('.stea-hf__display-condition-specific-page').val('');
					field_wrap.find('.stea-hf__display-condition-input').trigger('change');
					update_exclusion_button( false, true );

				}else{
					$this.parent('.stea-hf__display-condition').next('.stea-hf__display-condition-specific-page-wrapper').remove();
					rule_condition.remove();
				}

			} else {

				$this.parent('.stea-hf__display-condition').next('.stea-hf__display-condition-specific-page-wrapper').remove();
				rule_condition.remove();
			}

			field_wrap.find('.stea-hf__display-condition').each(function(i) {
				var condition       = jQuery( this ),
					old_rule_id     = condition.attr('data-rule'),
					select_location = condition.find('.stea-hf__display-condition-input'),
					select_specific = condition.find('.stea-hf__display-condition-specific-page'),
					location_name   = select_location.attr( 'name' );
					
				condition.attr( 'data-rule', i );

				select_location.attr( 'name', location_name.replace('['+old_rule_id+']', '['+i+']') );
				
				condition.removeClass('stea-hf__display-condition-'+old_rule_id).addClass('stea-hf__display-condition-'+i);

				cnt = i;
			});

			field_wrap.find('.stea-hf__add-include-display-condition-wrapper a').attr( 'data-rule-id', cnt )

			update_close_button( field_wrap );
			update_display_conditions_input( field_wrap );
		});
		
		jQuery( '.stea-hf__display-condition-container' ).on( 'click', '.stea-hf__add-exclude-display-condition-wrapper a', function(e) {
			e.preventDefault();
			e.stopPropagation();
			update_exclusion_button( true );
		});
		
	});

}(jQuery));
