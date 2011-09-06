<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>flxcron</title>
</head>
<body>
<?php
	if( isset($_POST["crontab"]) ){
		$ct = fopen("../../.crontab","w");
		@fwrite($ct,$_POST["crontab"],strlen($_POST["crontab"]));
		fclose($ct);
		print trim( htmlspecialchars( shell_exec("crontab ../../.crontab") ) );
		print "<br>";
	}
?>
	<form method="POST">
	<textarea name="crontab" rows="10" cols="60"><?php
	if( file_exists("../../.crontab") ){
		$ct = fopen("../../.crontab", "r");
		print fread($ct);
		fclose($ct);
	}else{
		touch("../../.crontab");
		chmod("../../.crontab",0604);
	}
?></textarea>
	<input type="submit" value="submit">
	</form>
</body>
</html>
