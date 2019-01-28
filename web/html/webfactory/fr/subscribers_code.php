<?php    
	$cs=connection(CONNECT,$database);
	$query = getArgument("query");
	$event = getArgument("event");
	$action = getArgument("action");
	$sub_id = getArgument("sub_id");
	if(empty($query)) $query="SELECT";
	if(empty($event)) $event="onLoad";
	if(empty($action)) $action="Ajouter";
	if(isset($pc)) $curl_pager="&pc=$pc";
	if(isset($sr)) $curl_pager.="&sr=$sr";
	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(sub_id) from subscribers;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$sub_id=$rows[0]+1;
			$sub_email="";
		break;
		case "Modifier":
			$sql="select * from subscribers where sub_id='$sub_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$sub_id=$rows["sub_id"];
			$sub_email=$rows["sub_email"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":
			$sql="insert into subscribers (".
				"sub_id, ".
				"sub_email".
			") values (".
				"'$sub_id', ".
				"'$sub_email'".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$sub_id = filterPOST("sub_id");
			$sub_email = filterPOST("sub_email");
			$sql="update subscribers set ".
				"sub_id='$sub_id', ".
				"sub_email='$sub_email' ".
			"where sub_id='$sub_id'";
			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from subscribers where sub_id='$sub_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection(DISCONNECT,$database);
		echo "<script language='JavaScript'>window.location.href='page.php?id=34&lg=fr'</script>";
	}
?>
