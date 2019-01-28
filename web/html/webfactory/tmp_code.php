<?php   
	$cs=connection(CONNECT,$database);
	$query = getArgument("query", "SELECT");
	$event = getArgument("event", "onLoad");
	$action = getArgument("action", "Ajouter");
	$id = getArgument("id");
	$di = getArgument("di");
	$cl_id = getArgument("cl_id");
	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(cl_id) from changelog;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$cl_id=$rows[0]+1;
			$cl_title="";
			$cl_text="";
			$cl_date="";
			$cl_time="";
			$fr_id="";
			$mbr_id="";
		break;
		case "Modifier":
			$sql="select * from changelog where cl_id='$cl_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$cl_id=$rows["cl_id"];
			$cl_title=$rows["cl_title"];
			$cl_text=$rows["cl_text"];
			$cl_date=$rows["cl_date"];
			$cl_time=$rows["cl_time"];
			$fr_id=$rows["fr_id"];
			$mbr_id=$rows["mbr_id"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":
			$cl_id = filterPOST("cl_id");
			$cl_title = filterPOST("cl_title");
			$cl_text = filterPOST("cl_text");
			$cl_date = filterPOST("cl_date");
			$cl_time = filterPOST("cl_time");
			$fr_id = filterPOST("fr_id");
			$mbr_id = filterPOST("mbr_id");
			$cl_title=escapeChars($cl_title);
			$sql="insert into changelog (".
				"cl_id, ".
				"cl_title, ".
				"cl_text, ".
				"cl_date, ".
				"cl_time, ".
				"fr_id, ".
				"mbr_id".
			") values (".
				"$cl_id, ".
				"'$cl_title', ".
				"'$cl_text', ".
				"'$cl_date', ".
				"'$cl_time', ".
				"$fr_id, ".
				"$mbr_id".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$cl_id = filterPOST("cl_id");
			$cl_title = filterPOST("cl_title");
			$cl_text = filterPOST("cl_text");
			$cl_date = filterPOST("cl_date");
			$cl_time = filterPOST("cl_time");
			$fr_id = filterPOST("fr_id");
			$mbr_id = filterPOST("mbr_id");
			$cl_title=escapeChars($cl_title);
			$sql="update changelog set ".
				"cl_id='$cl_id', ".
				"cl_title='$cl_title', ".
				"cl_text='$cl_text', ".
				"cl_date='$cl_date', ".
				"cl_time='$cl_time', ".
				"fr_id='$fr_id', ".
				"mbr_id='$mbr_id' ".
			"where cl_id='$cl_id'";
			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from changelog where cl_id='$cl_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection(DISCONNECT,$database);
		echo "<script language='JavaScript'>window.location.href='page.php?id=24&lg=fr'</script>";
	}
?>
