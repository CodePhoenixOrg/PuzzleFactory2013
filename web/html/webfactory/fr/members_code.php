<?php    
	include_once("puzzle/ipz_mysqlconn.php");
	include_once("puzzle/ipz_db_controls.php");
	$cs=connection(CONNECT,$database);
	$query = get_variable("query");
	$event = get_variable("event");
	$action = get_variable("action");
	$mbr_id = get_variable("mbr_id");
	if(empty($query)) $query="SELECT";
	if(empty($event)) $event="onLoad";
	if(empty($action)) $action="Ajouter";
	if(isset($pc)) $curl_pager="&pc=$pc";
	if(isset($sr)) $curl_pager.="&sr=$sr";
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
			$mbr_id = $_POST["mbr_id"];
			$mbr_nom = $_POST["mbr_nom"];
			$mbr_adr1 = $_POST["mbr_adr1"];
			$mbr_adr2 = $_POST["mbr_adr2"];
			$mbr_cp = $_POST["mbr_cp"];
			$mbr_email = $_POST["mbr_email"];
			$mbr_ident = $_POST["mbr_ident"];
			$mbr_mpasse = $_POST["mbr_mpasse"];
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
			$mbr_id = $_POST["mbr_id"];
			$mbr_nom = $_POST["mbr_nom"];
			$mbr_adr1 = $_POST["mbr_adr1"];
			$mbr_adr2 = $_POST["mbr_adr2"];
			$mbr_cp = $_POST["mbr_cp"];
			$mbr_email = $_POST["mbr_email"];
			$mbr_ident = $_POST["mbr_ident"];
			$mbr_mpasse = $_POST["mbr_mpasse"];
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
