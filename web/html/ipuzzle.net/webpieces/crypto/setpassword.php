<html><head><meta http-equiv="content-type" content="text/html; charset=UTF-8"></head><body><pre>
<?php 
	include("puzzle/ipz_crypto.php");

	if(isset($_GET["p"])) $p=$_GET["p"];
 	$p=urldecode($p);
 	
 	$hash=HashPassword($p);
 	echo $hash."\r\n";
?>
</pre></body></html>
