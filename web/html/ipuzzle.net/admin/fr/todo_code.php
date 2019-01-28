<?php
	$cs=connection(CONNECT,$database);
	$query = getArgument("query", "SELECT");
	$event = getArgument("event", "onLoad");
	$action = getArgument("action", "Ajouter");
	$id = getArgument("id");
	$di = getArgument("di");
	$td_id = getArgument("td_id");
	$td_id = getArgument("td_id");
	$mbr_id2 = getArgument("mbr_id2");

	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(td_id) from pz_todo;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$td_id=$rows[0]+1;
			$td_title="";
			$td_text="";
			$td_priority="";
			$td_expiry="";
			$td_status="";
			$td_date="";
			$mbr_id="";
		break;
		case "Modifier":
			$sql="select * from pz_todo where td_id='$td_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$td_id=$rows["td_id"];
			$td_title=$rows["td_title"];
			$td_text=$rows["td_text"];
			$td_priority=$rows["td_priority"];
			$td_expiry=$rows["td_expiry"];
			$td_status=$rows["td_status"];
			$td_date=$rows["td_date"];
			$mbr_id=$rows["mbr_id"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":
			$td_id = filterPOST("td_id");
			$td_title = filterPOST("td_title");
			$td_text = filterPOST("td_text");
			$td_priority = filterPOST("td_priority");
			$td_expiry = filterPOST("td_expiry");
			$td_status = filterPOST("td_status");
			$td_date = filterPOST("td_date");
			$mbr_id = filterPOST("mbr_id");
			$td_title=escapeChars($td_title);
			$td_text=escapeChars($td_text);
			$td_status=escapeChars($td_status);
            $td_date = dateFrenchToMysql($td_date);
			$sql="insert into pz_todo (".
				"td_id, ".
				"td_title, ".
				"td_text, ".
				"td_priority, ".
				"td_expiry, ".
				"td_status, ".
				"td_date, ".
				"mbr_id".
			") values (".
				"$td_id, ".
				"'$td_title', ".
				"'$td_text', ".
				"$td_priority, ".
				"'$td_expiry', ".
				"'$td_status', ".
				"'$td_date', ".
				"$mbr_id".
			")";
                        
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$td_id = filterPOST("td_id");
			$td_title = filterPOST("td_title");
			$td_text = filterPOST("td_text");
			$td_priority = filterPOST("td_priority");
			$td_expiry = filterPOST("td_expiry");
			$td_status = filterPOST("td_status");
			$td_date = filterPOST("td_date");
			$mbr_id = filterPOST("mbr_id");
			$td_title=escapeChars($td_title);
			$td_text=escapeChars($td_text);
			$td_status=escapeChars($td_status);
            $td_date = dateFrenchToMysql($td_date);
			$sql="update pz_todo set ".
				"td_id=$td_id, ".
				"td_title='$td_title', ".
				"td_text='$td_text', ".
				"td_priority=$td_priority, ".
				"td_expiry='$td_expiry', ".
				"td_status='$td_status', ".
				"td_date='$td_date', ".
				"mbr_id=$mbr_id ".
			"where td_id='$td_id'";
			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from pz_todo where td_id='$td_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection(DISCONNECT,$database);
		echo "<script language='JavaScript'>window.location.href='page.php?id=25&lg=fr'</script>";
	}
?>
