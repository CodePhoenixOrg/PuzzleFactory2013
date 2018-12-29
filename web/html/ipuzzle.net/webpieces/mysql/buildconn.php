<?php 
	$f="openconn.php";
	//if(file_exists($f)) unlink($f);
	if(isset($_GET["h"])) $h=$_GET["h"];
	if(isset($_GET["u"])) $u=$_GET["u"];
	if(isset($_GET["p"])) $p=$_GET["p"];
	$cnx=$cs->connect($h, $u, $p);
	echo $cs->client_encoding($cnx)."\n";
	$cs->close($cnx);
	$myfile=fopen($f,"w");
	fwrite($myfile,
"<?php \nfunction dbconnection(\$a=\"\") {
\t\$host=\"".$h."\";
\t\$user=\"".$u."\";
\t\$passwd=\"".$p."\";
\t\tif(\$a==\"connect\") {
\t\t\$myconn=$cs->connect(\$host, \$user, \$passwd);
\t\t\tif(\$myconn) {
\t\t\t\techo \"succeeded\\n\";
\t\t\t} else {
\t\t\t\techo \"failed\\n\";
\t\t\t}
\t\t} else if(\$a==\"disconnect\") {
\t\t\t\$myconn=$cs->connect(\$host, \$user, \$passwd);
\t\t\t$cs->close(\$myconn);
\t\t}
\t\treturn \$myconn;
\t}
?>"
);
	fclose($myfile);
?>
