(function($) {
	$(document).ready(function() {
		
		// declare the path to the previewer using the plugin file processor.
		mySettings.previewParserPath = "./plugin.php?page=BBCodePlus/preview.php";
		// apply to proper text areas.
		if ( $("textarea[name='bugnote_text']") )
			$("textarea[name='bugnote_text']").markItUp(mySettings);
		if ( $("textarea[name='description']") )
			$("textarea[name='description']").markItUp(mySettings);
		if ( $("textarea[name='steps_to_reproduce']") )
			$("textarea[name='steps_to_reproduce']").markItUp(mySettings);
		if ( $("textarea[name='additional_info']") )
			$("textarea[name='additional_info']").markItUp(mySettings);
		if ( $("textarea[name='body']") )
			$("textarea[name='body']").markItUp( mySettings );

	});
})(jQuery);