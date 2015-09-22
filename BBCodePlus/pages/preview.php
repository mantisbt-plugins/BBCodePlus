<?php
html_begin();
html_head_begin();
html_css();
?>
<style>
	.preview {
		background-color: #fff;
	    height:100%; 
		width:100%;
	}
</style>
<?php
html_head_end();
?>
<body>
<div class="preview">
<?php echo string_display_links($_POST["data"]); ?>
</div>
<?php
html_body_end();
html_end();
