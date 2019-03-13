<?php
// begin html structure.
html_begin();
html_head_begin();
html_content_type();
html_css();
html_head_javascript();
layout_body_javascript();
?>
<link rel="stylesheet" type="text/css" href="<?= plugin_file("bbcodeplus.css") ?>" />
<link rel="stylesheet" type="text/css" href="<?= plugin_file("prism/styles/default.css") ?>" />
<script type="text/javascript" src="<?= plugin_file("bbcodeplus-init.js") ?>"></script>
<script type="text/javascript" src="<?= plugin_file("prism/prism.js") ?>"></script>
<?php
html_head_end();
?>
<body class="bbcodeplus-preview-body">
    <div class="bbcodeplus-preview"><?php echo string_display_links($_POST["data"]); ?></div>
<?php
html_body_end();
html_end();
