<html><head><meta http-equiv="content-type" content="text/html; charset=UTF-8"></head><body><pre>
<?php 
	include("puzzle/ipz_crypto.php");

	//if(isset($_GET["h"])) $h=$_GET["h"];
	if(isset($_GET["p"])) $p=$_GET["p"];
 	//$h=urldecode($h);
 	$p=urldecode($p);
 	$h=HashPassword($p);
 	
 	$res=(ValidatePassword($p, $h)) ? "TRUE" : "FALSE";
 	echo $res."\r\n";
?>
</pre></body></html>
