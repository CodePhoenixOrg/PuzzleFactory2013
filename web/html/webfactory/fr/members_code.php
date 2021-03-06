<?php    

	$cs=connection(CONNECT,$database);
	$query = getArgument("query", "SELECT");
	$event = getArgument("event", "onLoad");
	$action = getArgument("action", "Ajouter");
	$id = getArgument("id");
	$di = getArgument("di");
	$mbr_id = getArgument("mbr_id");

	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(mbr_id) from members;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$mbr_id=$rows[0]+1;
			$mbr_nom="";
			$mbr_adr1="";
			$mbr_adr2="";
			$mbr_cp="";
			$mbr_email="";
			$mbr_ident="";
			$mbr_mpasse="";
		break;
		case "Modifier":
			$sql="select * from members where mbr_id='$mbr_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$mbr_id=$rows["mbr_id"];
			$mbr_nom=$rows["mbr_nom"];
			$mbr_adr1=$rows["mbr_adr1"];
			$mbr_adr2=$rows["mbr_adr2"];
			$mbr_cp=$rows["mbr_cp"];
			$mbr_email=$rows["mbr_email"];
			$mbr_ident=$rows["mbr_ident"];
			$mbr_mpasse=$rows["mbr_mpasse"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":
			$mbr_id = filterPOST("mbr_id");
			$mbr_nom = filterPOST("mbr_nom");
			$mbr_adr1 = filterPOST("mbr_adr1");
			$mbr_adr2 = filterPOST("mbr_adr2");
			$mbr_cp = filterPOST("mbr_cp");
			$mbr_email = filterPOST("mbr_email");
			$mbr_ident = filterPOST("mbr_ident");
			$mbr_mpasse = filterPOST("mbr_mpasse");
			$mbr_nom=escapeChars($mbr_nom);
			$mbr_adr1=escapeChars($mbr_adr1);
			$mbr_adr2=escapeChars($mbr_adr2);
			$mbr_cp=escapeChars($mbr_cp);
			$mbr_email=escapeChars($mbr_email);
			$mbr_ident=escapeChars($mbr_ident);
			$mbr_mpasse=escapeChars($mbr_mpasse);
			$sql="insert into members (".
				"mbr_id, ".
				"mbr_nom, ".
				"mbr_adr1, ".
				"mbr_adr2, ".
				"mbr_cp, ".
				"mbr_email, ".
				"mbr_ident, ".
				"mbr_mpasse".
			") values (".
				"$mbr_id, ".
				"'$mbr_nom', ".
				"'$mbr_adr1', ".
				"'$mbr_adr2', ".
				"'$mbr_cp', ".
				"'$mbr_email', ".
				"'$mbr_ident', ".
				"'$mbr_mpasse'".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$mbr_id = filterPOST("mbr_id");
			$mbr_nom = filterPOST("mbr_nom");
			$mbr_adr1 = filterPOST("mbr_adr1");
			$mbr_adr2 = filterPOST("mbr_adr2");
			$mbr_cp = filterPOST("mbr_cp");
			$mbr_email = filterPOST("mbr_email");
			$mbr_ident = filterPOST("mbr_ident");
			$mbr_mpasse = filterPOST("mbr_mpasse");
			$mbr_nom=escapeChars($mbr_nom);
			$mbr_adr1=escapeChars($mbr_adr1);
			$mbr_adr2=escapeChars($mbr_adr2);
			$mbr_cp=escapeChars($mbr_cp);
			$mbr_email=escapeChars($mbr_email);
			$mbr_ident=escapeChars($mbr_ident);
			$mbr_mpasse=escapeChars($mbr_mpasse);
			$sql="update members set ".
				"mbr_id=$mbr_id, ".
				"mbr_nom='$mbr_nom', ".
				"mbr_adr1='$mbr_adr1', ".
				"mbr_adr2='$mbr_adr2', ".
				"mbr_cp='$mbr_cp', ".
				"mbr_email='$mbr_email', ".
				"mbr_ident='$mbr_ident', ".
				"mbr_mpasse='$mbr_mpasse' ".
			"where mbr_id='$mbr_id'";
			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from members where mbr_id='$mbr_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection(DISCONNECT,$database);
		echo "<script language='JavaScript'>window.location.href='page.php?id=34&lg=fr'</script>";
	}
?>
