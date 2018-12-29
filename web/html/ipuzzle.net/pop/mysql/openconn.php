<?php 
function dbconnection($a="") { 
	$host="http://phpmyadmin.free.fr";
	$user="akades";
	$passwd="25643152";
	if($a=="connect") {
		$myconn=$cs->pconnect($host, $user, $passwd);
		if($myconn) {
			echo "succeeded\n";
		}
		else
			echo "failed\n";
	}
	else if($a=="disconnect") {
		$myconn=$cs->pconnect($host, $user, $passwd);
		$cs->close($myconn);
	}
}
?>
		
