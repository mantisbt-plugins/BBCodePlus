<?php
# begin html structure.
html_begin();
html_head_begin();
html_content_type();
html_css();
html_head_javascript();
?>
	 <style>
		  /* override default body style */
		  body {
			  background-color: #fff !important;
			  background-image:none !important;
			  margin: 10px 10px;
		  }
	 </style>
<?php
html_head_end();
html_body_begin();
?>
    <div><?php echo string_display_links($_POST["data"]); ?></div>
<?php
html_body_end();
html_end();