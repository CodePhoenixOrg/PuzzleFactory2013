<?php    
	$cs=connection(CONNECT,$database);
	$query = getArgument("query", "SELECT");
	$event = getArgument("event", "onLoad");
	$action = getArgument("action", "Ajouter");
	$id = getArgument("id");
	$di = getArgument("di");
	$br_id = getArgument("br_id");

	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(br_id) from bugreport;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$br_id=$rows[0]+1;
			$br_title="";
			$br_text="";
			$br_importance="";
			$br_status="";
			$br_date="";
			$mbr_id="";
		break;
		case "Modifier":
			$sql="select * from bugreport where br_id='$br_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$br_id=$rows["br_id"];
			$br_title=$rows["br_title"];
			$br_text=$rows["br_text"];
			$br_importance=$rows["br_importance"];
			$br_status=$rows["br_status"];
			$br_date=$rows["br_date"];
			$mbr_id=$rows["mbr_id"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":
			$br_id = filterPOST("br_id");
			$br_title = filterPOST("br_title");
			$br_text = filterPOST("br_text");
			$br_importance = filterPOST("br_importance");
			$br_status = filterPOST("br_status");
			$br_date = filterPOST("br_date");
			$mbr_id = filterPOST("mbr_id");
			$br_title=escapeChars($br_title);
			$br_text=escapeChars($br_text);
			$br_status=escapeChars($br_status);
                        $br_date = dateFrenchToMysql($br_date);
			$sql="insert into bugreport (".
				"br_id, ".
				"br_title, ".
				"br_text, ".
				"br_importance, ".
				"br_status, ".
				"br_date, ".
				"mbr_id".
			") values (".
				"$br_id, ".
				"'$br_title', ".
				"'$br_text', ".
				"$br_importance, ".
				"'$br_status', ".
				"'$br_date', ".
				"$mbr_id".
			")";
			$stmt = $cs->query($sql);

			echo 'SQL ADD: ' . $sql;
		break;
		case "Modifier":
			$br_id = filterPOST("br_id");
			$br_title = filterPOST("br_title");
			$br_text = filterPOST("br_text");
			$br_importance = filterPOST("br_importance");
			$br_status = filterPOST("br_status");
			$br_date = filterPOST("br_date");
			$mbr_id = filterPOST("mbr_id");
			$br_title=escapeChars($br_title);
			$br_text=escapeChars($br_text);
			$br_status=escapeChars($br_status);
                        $br_date = dateFrenchToMysql($br_date);
			$sql="update bugreport set ".
				"br_id=$br_id, ".
				"br_title='$br_title', ".
				"br_text='$br_text', ".
				"br_importance=$br_importance, ".
				"br_status='$br_status', ".
				"br_date='$br_date', ".
				"mbr_id=$mbr_id ".
			"where br_id='$br_id'";
			$stmt = $cs->query($sql);

			echo 'SQL UPDATE: ' . $sql;

		break;
		case "Supprimer":
			$sql="delete from bugreport where br_id='$br_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection(DISCONNECT,$database);
		echo "<script language='JavaScript'>window.location.href='page.php?id=26&lg=fr'</script>";
	}
?>
