jQuery(function($) {
	
	var stores = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('search'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		local: storeData
	});
	function getStoresWithDefault (q, sync) {
		if (q === '') {
			//console.log('Default liste suchen');
			sync(stores.all().slice(0,5));
		}
		else {
			stores.search(q, sync);
		}
	};

	jQuery('#stores .typeahead').typeahead({
		hint: true,
//	  highlight: true,
		minLength: 0
	},
	{
		name: 'states',
		display: 'value',
		limit: 10,
		source: getStoresWithDefault,
		templates: {
		    empty: [
		      '<div style="margin-left:20px">',
		        'Leider wurde keine Filiale gefunden.',
		      '</div>'
		    ].join('\n'),
		    suggestion: Handlebars.compile('<div><strong>{{name}}</strong> – {{zip}} {{city}}<br/>{{address}}</div>')
		}
	});

	jQuery('#stores .typeahead').bind('typeahead:select', function(ev, suggestion) {
		  //console.log(suggestion);
		  jQuery('#storeUID').val(suggestion.uid);
	});
	jQuery('#stores .typeahead').bind('typeahead:close', function(ev) {
		  if(jQuery('#storeUID').val() == '') {
			  jQuery('#storeSearch').val('');
		  }
	});
	jQuery('#stores .typeahead').bind('typeahead:open', function(ev) {
		  jQuery('#storeUID').val('');
	});

	jQuery( "#t3stores-orderform" ).validator().on('submit', function( event ) {
		if (!event.isDefaultPrevented()) {
			jQuery('#t3stores_finishbtn').button('loading');
		}
	});
	jQuery('#t3stores_finishbtn').button('reset');

});
