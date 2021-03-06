<?php   
	include_once("puzzle/ipz_mysqlconn.php");
	include_once("puzzle/ipz_db_controls.php");
	$cs=connection(CONNECT,$database);
	$query = getArgument("query", "SELECT");
	$event = getArgument("event", "onLoad");
	$action = getArgument("action", "Ajouter");
	$id = getArgument("id");
	$di = getArgument("di");
	$zc_id = getArgument("zc_id");
	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(zc_id) from pz_zip_code;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$zc_id=$rows[0]+1;
			$zc_code="";
			$zc_city="";
		break;
		case "Modifier":
			$sql="select * from pz_zip_code where zc_id='$zc_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$zc_id=$rows["zc_id"];
			$zc_code=$rows["zc_code"];
			$zc_city=$rows["zc_city"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":
			$zc_id = filterPOST("zc_id");
			$zc_code = filterPOST("zc_code");
			$zc_city = filterPOST("zc_city");
			$zc_code=escapeChars($zc_code);
			$zc_city=escapeChars($zc_city);
			$sql="insert into pz_zip_code (".
				"zc_id, ".
				"zc_code, ".
				"zc_city".
			") values (".
				"$zc_id, ".
				"'$zc_code', ".
				"'$zc_city'".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$zc_id = filterPOST("zc_id");
			$zc_code = filterPOST("zc_code");
			$zc_city = filterPOST("zc_city");
			$zc_code=escapeChars($zc_code);
			$zc_city=escapeChars($zc_city);
			$sql="update pz_zip_code set ".
				"zc_id='$zc_id', ".
				"zc_code='$zc_code', ".
				"zc_city='$zc_city' ".
			"where zc_id='$zc_id'";
			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from pz_zip_code where zc_id='$zc_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection(DISCONNECT,$database);
		echo "<script language='JavaScript'>window.location.href='page.php?id=0&lg=fr'</script>";
	}
?>
