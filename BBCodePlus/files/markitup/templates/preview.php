<?php
	// call the core file.
	require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . '../../../../../core.php' );
	require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . '../../../BBCodePlus.php' );
	
	// instance the plugin.
	$BBCodePlus = new BBCodePlusPlugin();	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>markItUp! preview template</title>
<link rel="stylesheet" type="text/css" href="~/templates/preview.css" />
<link rel="stylesheet" type="text/css" href="~/../bbcode.css" />
<?php echo $BBCodePlus->resources(); ?>
</head>
<body>
<?php
echo $BBCodePlus->string_process_bbcode($_POST["data"]);
?>
</body>
</html>