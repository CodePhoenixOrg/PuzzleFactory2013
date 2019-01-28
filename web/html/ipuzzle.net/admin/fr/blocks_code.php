<?php    
	$cs=connection(CONNECT,$database);
	$query = getArgument("query", "SELECT");
	$event = getArgument("event", "onLoad");
	$action = getArgument("action", "Ajouter");
	$id = getArgument("id");
	$di = getArgument("di");
	$bl_id = getArgument("bl_id");

	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(bl_id) from blocks;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$bl_id=$rows[0]+1;
			$bl_column="";
			$bl_type="";
			$di_name="";
		break;
		case "Modifier":
			$sql="select * from blocks where bl_id='$bl_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$bl_id=$rows["bl_id"];
			$bl_column=$rows["bl_column"];
			$bl_type=$rows["bl_type"];
			$di_name=$rows["di_name"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":
			$sql="insert into blocks (".
				"bl_id, ".
				"bl_column, ".
				"bl_type, ".
				"di_name".
			") values (".
				"'$bl_id', ".
				"'$bl_column', ".
				"'$bl_type', ".
				"'$di_name'".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$bl_id = filterPOST("bl_id");
			$bl_column = filterPOST("bl_column");
			$bl_type = filterPOST("bl_type");
			$di_name = filterPOST("di_name");
			$sql="update blocks set ".
				"bl_id='$bl_id', ".
				"bl_column='$bl_column', ".
				"bl_type='$bl_type', ".
				"di_name='$di_name' ".
			"where bl_id='$bl_id'";
			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from blocks where bl_id='$bl_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection(DISCONNECT,$database);
		echo "<script language='JavaScript'>window.location.href='page.php?id=20&lg=fr'</script>";
	}
?>
