<?php
// begin html structure.
html_begin();
html_head_begin();
html_content_type();
html_css();
html_head_javascript();

// load bbcode style.
$resources = '<link rel="stylesheet" type="text/css" href="' . plugin_file("bbcodeplus.css") . '" />';
$resources .= '<script type="text/javascript" src="' . plugin_file( 'bbcodeplus-init.js' ) . '"></script>';
if ( ON == plugin_config_get( 'process_highlight' ) ) {
	// load highlighting if turned on.
	$resources .= '<link rel="stylesheet" type="text/css" href="' . plugin_file("bbcodeplus.css") . '" />';		
	$resources .= '<link rel="stylesheet" type="text/css" href="' . plugin_file( 'prism/styles/' . plugin_config_get( 'highlight_css' ) . '.css' ) . '" />';
	$resources .= '<script type="text/javascript" src="' . plugin_file( 'prism/prism.js' ) . '"></script>';			
	
	// load additional languages.
	if ( ON == plugin_config_get( 'highlight_extralangs' ) ) {
		$resources .= '<script type="text/javascript" src="' . plugin_file( 'prism/prism_additional_languages.js' ) . '"></script>';		
	}
}

// output resources.
echo $resources;
?>
</head>
<body>
	<div class="bbcodeplus-preview"><?php echo string_display_links($_POST["data"]); ?></div>
</body>
<?php
html_end();
