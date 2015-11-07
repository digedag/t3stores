jQuery(function($) {
//	$(document).ready(function() {
	

	var stores = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('search'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		// `states` is an array of state names defined in "The Basics"
		local: storeData
	});

	jQuery('#stores .typeahead').typeahead({
	  hint: true,
//	  highlight: true,
	  minLength: 1
	},
	{
	  name: 'states',
	  display: 'value',
	  source: stores,
	  templates: {
//		    empty: [
//		      '<div class="empty-message">',
//		        'unable to find any stores that match the current query',
//		      '</div>'
//		    ].join('\n'),
		    suggestion: Handlebars.compile('<div><strong>{{name}}</strong> – {{zip}} {{city}}<br/>{{address}}</div>')
		  }
	});

	jQuery('#stores .typeahead').bind('typeahead:select', function(ev, suggestion) {
		  console.log(suggestion);
		  jQuery('#storeUID').val(suggestion.uid);
	});
});
