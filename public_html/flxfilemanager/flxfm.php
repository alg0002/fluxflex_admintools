<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>flxfilemanager</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
	alert('hoge');
})
</script>
</head>
<body>
	<div id="menu">
<?php
	$dir = opendir("../../");
	while( $filename = readdir( $dir ) ){
		print "$filename<br>\n";
	}
	closedir( $dir );
?>
	</div>
	<div id="main">
	</div>
</body>
</html>
