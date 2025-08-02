(function($){

	STEA_HF_EPRO_Compatibility = {

        /**
		 * Binds events for the Elementor Header & Footer.
		 */
		init: function() {
			elementor.on( "document:loaded", function() {
                setTimeout( function() {
                    jQuery.each( elementorFrontend.documentsManager.documents, function ( index, document ) {
                        var $documentElement = document.$element;
                        var ids_array = JSON.parse( stea_hf_admin.ids );
                        ids_array.forEach( function( item, index ){
                        	var elementor_id = $documentElement.data( 'elementor-id' );
                        	if( elementor_id == ids_array[index].id ){
                        		$documentElement.find( '.elementor-document-handle__title' ).text( elementor.translate('edit_element', [ids_array[index].value] ) );
                        	}
                        } );
                    });
                }, 1000 );
            });
		}
	};

	/**
	 * Initialize EHF_EPRO_Compatibility
	 */
	$(function(){
		STEA_HF_EPRO_Compatibility.init();
	});

})(jQuery);
