<?php   
	$cs=connection(CONNECT,$database);
	$query = getArgument("query", "SELECT");
	$event = getArgument("event", "onLoad");
	$action = getArgument("action", "Ajouter");
	$id = getArgument("id");
	$di = getArgument("di");
	$fr_id = getArgument("fr_id");
	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(fr_id) from forums;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$fr_id=$rows[0]+1;
			$fr_title="";
			$fr_description="";
			$fr_date="";
			$fr_table_name="";
			$me_id="";
		break;
		case "Modifier":
			$sql="select * from forums where fr_id='$fr_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$fr_id=$rows["fr_id"];
			$fr_title=$rows["fr_title"];
			$fr_description=$rows["fr_description"];
			$fr_date=$rows["fr_date"];
			$fr_table_name=$rows["fr_table_name"];
			$me_id=$rows["me_id"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":
			$fr_id = filterPOST("fr_id");
			$fr_title = filterPOST("fr_title");
			$fr_description = filterPOST("fr_description");
			$fr_date = filterPOST("fr_date");
			$fr_table_name = filterPOST("fr_table_name");
			$me_id = filterPOST("me_id");
;
			$sql="insert into forums (".
				"fr_id, ".
				"fr_title, ".
				"fr_description, ".
				"fr_date, ".
				"fr_table_name, ".
				"me_id".
			") values (".
				"$fr_id, ".
				"$fr_title, ".
				"$fr_description, ".
				"$fr_date, ".
				"$fr_table_name, ".
				"$me_id".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$fr_id = filterPOST("fr_id");
			$fr_title = filterPOST("fr_title");
			$fr_description = filterPOST("fr_description");
			$fr_date = filterPOST("fr_date");
			$fr_table_name = filterPOST("fr_table_name");
			$me_id = filterPOST("me_id");
;
			$sql="update forums set ".
				"fr_id='$fr_id', ".
				"fr_title='$fr_title', ".
				"fr_description='$fr_description', ".
				"fr_date='$fr_date', ".
				"fr_table_name='$fr_table_name', ".
				"me_id='$me_id' ".
			"where fr_id='$fr_id'";
			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from forums where fr_id='$fr_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection(DISCONNECT,$database);
		echo "<script language='JavaScript'>window.location.href='page.php?id=23&lg=fr'</script>";
	}
?>
