<?php
	// call the core file.
	require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . '../../../../../core.php' );
	require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . '../../../core/bbcode_api.php' );
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>markItUp! preview template</title>
<link rel="stylesheet" type="text/css" href="~/templates/preview.css" />
<link rel="stylesheet" type="text/css" href="~/../bbcode.css" />
</head>
<body>
<?php
echo plugin_BBCode_parse($_POST["data"]);
?>
</body>
</html>