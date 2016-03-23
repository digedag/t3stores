jQuery(function($) {
	offers.initOffers();
	jQuery('.t3stores-offer-amount').change(function(){
		var id = jQuery(this).data('id');
		offers.updateOffer(id, this)
	});
});

