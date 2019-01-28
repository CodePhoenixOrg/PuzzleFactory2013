<?php    
	$cs=connection(CONNECT,$database);
	$query = getArgument("query", "SELECT");
	$event = getArgument("event", "onLoad");
	$action = getArgument("action", "Ajouter");
	$id = getArgument("id");
	$di = getArgument("di");
	$app_id = getArgument("app_id");

	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(app_id) from applications;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$app_id=$rows[0]+1;
			$app_link="";
			$di_name="";
		break;
		case "Modifier":
			$sql="select * from applications where app_id='$app_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$app_id=$rows["app_id"];
			$app_link=$rows["app_link"];
			$di_name=$rows["di_name"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":
			$sql="insert into applications (".
				"app_id, ".
				"app_link, ".
				"di_name".
			") values (".
				"'$app_id', ".
				"'$app_link', ".
				"'$di_name'".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$app_id = filterPOST("app_id");
			$app_link = filterPOST("app_link");
			$di_name = filterPOST("di_name");
			$sql="update applications set ".
				"app_id='$app_id', ".
				"app_link='$app_link', ".
				"di_name='$di_name' ".
			"where app_id='$app_id'";
			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from applications where app_id='$app_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection(DISCONNECT,$database);
		echo "<script language='JavaScript'>window.location.href='page.php?id=22&lg=fr'</script>";
	}
?>
