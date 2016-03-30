jQuery(function($) {

	jQuery( "#t3stores-storesearch" ).submit(function( event ) {
		var params = jQuery(this).serialize();
		var uri = $(this).attr('action');
		uri = uri + "?" + params + "&type=2020";
		jQuery('#t3stores_searchbtn').button('loading');
		jQuery('#t3stores_storelist').fadeOut('slow')

		jQuery.ajax({
			type: "GET",
            url: uri,
            dataType: "html",
            success: function (result) {
            	jQuery('#t3stores_storelist').html(result).fadeIn('slow');
        		jQuery('#t3stores_searchbtn').button('reset');
            }
		});
		
		event.preventDefault();
		return false;
	});

});
