<?php
// begin html structure.
html_begin();
html_head_begin();
html_content_type();
html_css();
html_head_javascript();
html_head_end();
?>
<body class="bbcodeplus-preview-body">
    <div class="bbcodeplus-preview"><?php echo string_display_links($_POST["data"]); ?></div>
</body>
<?php
html_end();
