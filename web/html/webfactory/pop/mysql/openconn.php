<?php    
function dbconnection($a="") {
	$host="62.193.197.96";
	$user="root";
	$passwd="root";
		if($a=="connect") {
		$myconn=mysqli_pconnect($host, $user, $passwd);
			if($myconn) {
				echo "succeeded\r\n";
			} else {
				echo "failed\r\n";
			}
		} else if($a=="disconnect") {
			$myconn=mysqli_pconnect($host, $user, $passwd);
			mysqli_close($myconn);
		}
	}
?>
