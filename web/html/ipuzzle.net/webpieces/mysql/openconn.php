<?php 
function dbconnection($a="") {
	$host="localhost";
	$user="akades";
	$passwd="25643152";
		if($a=="connect") {
		$myconn=$cs->connect($host, $user, $passwd);
			if($myconn) {
				echo "succeeded\n";
			} else {
				echo "failed\n";
			}
		} else if($a=="disconnect") {
			$myconn=$cs->connect($host, $user, $passwd);
			$cs->close($myconn);
		}
		return $myconn;
	}
?>
