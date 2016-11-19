jQuery(function($) {
	if(typeof offers != 'undefined')
		offers.initOffers();
	jQuery('.t3stores-offer-amount').change(function(){
		var id = jQuery(this).data('id');
		offers.updateOffer(id, this)
	});
	
	jQuery( "#t3stores-offerform-form" ).submit(function( event ) {
		// Anzahl prüfen
		if(jQuery( "#sum" ).html() == '0.00' ) {
			alert('Bitte zunächst die Artikel auswählen.')
			event.preventDefault();
		}
	});

});

