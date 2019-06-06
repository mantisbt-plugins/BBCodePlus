<?php
# begin html structure.
html_begin();
html_head_begin();
html_content_type();
layout_head_css();
html_head_javascript();
layout_body_javascript();
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
# close the head and start the body.
layout_page_header_end();
?>
   <div><?php echo string_display_links($_POST["data"]); ?></div>
<?php
# close the body and finish the document.
html_body_end();
html_end();
