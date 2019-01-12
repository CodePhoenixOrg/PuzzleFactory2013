<?php    
	$f="openconn.php";
	if (file_exists($f)) unlink($f);
	$myfile=fopen($f,"w");
	fwrite($myfile,
"<?php    \nfunction dbconnection(\$a=\"\") {
\t\$host=\"".$h."\";
\t\$user=\"".$u."\";
\t\$passwd=\"".$p."\";
\t\tif(\$a==\"connect\") {
\t\t\$myconn=mysqli_pconnect(\$host, \$user, \$passwd);
\t\t\tif(\$myconn) {
\t\t\t\techo \"succeeded\\r\\n\";
\t\t\t} else {
\t\t\t\techo \"failed\\r\\n\";
\t\t\t}
\t\t} else if(\$a==\"disconnect\") {
\t\t\t\$myconn=mysqli_pconnect(\$host, \$user, \$passwd);
\t\t\tmysqli_close(\$myconn);
\t\t}
\t}
?>"
);
	fclose($myfile);
?>
