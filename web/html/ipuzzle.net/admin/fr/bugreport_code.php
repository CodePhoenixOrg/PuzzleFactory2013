<?php    
	$cs=connection(CONNECT,$database);
	$query = getVariable("query", "SELECT");
	$event = getVariable("event", "onLoad");
	$action = getVariable("action", "Ajouter");
	$id = getVariable("id");
	$di = getVariable("di");
	$br_id = getVariable("br_id");

	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(br_id) from pz_bugreport;";
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
			$sql="select * from pz_bugreport where br_id='$br_id';";
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
			$br_id = $_POST["br_id"];
			$br_title = $_POST["br_title"];
			$br_text = $_POST["br_text"];
			$br_importance = $_POST["br_importance"];
			$br_status = $_POST["br_status"];
			$br_date = $_POST["br_date"];
			$mbr_id = $_POST["mbr_id"];
			$br_title=escapeChars($br_title);
			$br_text=escapeChars($br_text);
			$br_status=escapeChars($br_status);
                        $br_date = dateFrenchToMysql($br_date);
			$sql="insert into pz_bugreport (".
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
			$br_id = $_POST["br_id"];
			$br_title = $_POST["br_title"];
			$br_text = $_POST["br_text"];
			$br_importance = $_POST["br_importance"];
			$br_status = $_POST["br_status"];
			$br_date = $_POST["br_date"];
			$mbr_id = $_POST["mbr_id"];
			$br_title=escapeChars($br_title);
			$br_text=escapeChars($br_text);
			$br_status=escapeChars($br_status);
                        $br_date = dateFrenchToMysql($br_date);
			$sql="update pz_bugreport set ".
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
			$sql="delete from pz_bugreport where br_id='$br_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection(DISCONNECT,$database);
		echo "<script language='JavaScript'>window.location.href='page.php?id=26&lg=fr'</script>";
	}
?>
