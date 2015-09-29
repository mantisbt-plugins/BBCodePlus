(function($) {
	$(document).ready(function() {
		
		// scan bbcolor classes.
		var colorElements = $("span[class*='bbcolor-']");
		if (colorElements != null) {
			// iterate through the elements and extract the color from the class name.
			colorElements.each(function(index, obj) {
				// regex matches.
				var matches = /^bbcolor\-([^\s]+)/.exec($(obj).attr('class'));
				// get the color.
				color = matches[1];
				// set the element's color
				// (this is accepted by CSP guidelines per http://www.cspplayground.com/compliant_examples#style)
				$(obj).css('color', color);
			});
		}

		// scan bbhighlight classes.
		var highlightElements = $("span[class*='bbhighlight-']");
		if (highlightElements != null) {
			// iterate through the elements and extract the size from the class name.
			highlightElements.each(function(index, obj) {
				// regex matches.
				var matches = /^bbhighlight\-([^\s]+)/.exec($(obj).attr('class'));
				// get the color.
				color = matches[1];
				// set the element's background color.
				// (this is accepted by CSP guidelines per http://www.cspplayground.com/compliant_examples#style)
				$(obj).css('background-color', color);
			});			
		}
		
		// scan bbsize classes.
		var sizeElements = $("span[class*='bbsize-']");
		if (sizeElements != null) {
			// iterate through the elements and extract the size from the class name.
			sizeElements.each(function(index, obj) {
				// regex matches.
				var matches = /^bbsize\-([^\s]+)/.exec($(obj).attr('class'));
				// get the color.
				size = matches[1];
				// set the element's size
				// (this is accepted by CSP guidelines per http://www.cspplayground.com/compliant_examples#style)
				$(obj).css('font-size', size + '%');
			});			
		}
		
	});
})(jQuery);