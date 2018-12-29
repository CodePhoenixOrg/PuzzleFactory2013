<?php 
	include_once("puzzle/ipz_mysqlconn.php");
	$cs=connection(CONNECT, $database);
	if(empty($event)) $event="onLoad";
	if($event=="onLoad") {
	} else if($event=="onRun") {
		switch ($action) {
		case "Ajouter":
			$sql="insert into newsletter (".
				"nlr_email".
			") values (".
				"'$nlr_email'".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from newsletter where nlr_email='$nlr_email'";
			$stmt = $cs->query($sql);
		break;
		}
		echo "<script language='JavaScript'>window.location.href='page.php?id=&lg=fr'</script>";
	} else if($event=="onUnload") {
		$cs=connection(DISCONNECT, $database);
		echo "<script language='JavaScript'>window.location.href='page.php?id=&lg=fr'</script>";
	}
?>

