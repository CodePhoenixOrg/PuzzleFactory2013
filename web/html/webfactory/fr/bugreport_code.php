<?php    
	include_once 'puzzle/ipz_mysqlconn.php';
	include_once 'puzzle/ipz_db_controls.php';
	$cs=connection(CONNECT,$database);
	$query = get_variable("query");
	$event = get_variable("event");
	$action = get_variable("action");
	$br_id = get_variable("br_id");
	if(empty($query)) $query="SELECT";
	if(empty($event)) $event="onLoad";
	if(empty($action)) $action="Ajouter";
	if(isset($pc)) $curl_pager="&pc=$pc";
	if(isset($sr)) $curl_pager.="&sr=$sr";
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
			$br_time="";
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
			$br_time=$rows["br_time"];
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
			$br_time = $_POST["br_time"];
			$mbr_id = $_POST["mbr_id"];
			$br_title=escapeChars($br_title);
			$br_text=escapeChars($br_text);
			$br_status=escapeChars($br_status);
                        $br_date = date_french_to_mysql($br_date);
			$sql="insert into bugreport (".
				"br_id, ".
				"br_title, ".
				"br_text, ".
				"br_importance, ".
				"br_status, ".
				"br_date, ".
				"br_time, ".
				"mbr_id".
			") values (".
				"$br_id, ".
				"'$br_title', ".
				"'$br_text', ".
				"$br_importance, ".
				"'$br_status', ".
				"'$br_date', ".
				"'$br_time', ".
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
			$br_time = $_POST["br_time"];
			$mbr_id = $_POST["mbr_id"];
			$br_title=escapeChars($br_title);
			$br_text=escapeChars($br_text);
			$br_status=escapeChars($br_status);
                        $br_date = date_french_to_mysql($br_date);
			$sql="update bugreport set ".
				"br_id=$br_id, ".
				"br_title='$br_title', ".
				"br_text='$br_text', ".
				"br_importance=$br_importance, ".
				"br_status='$br_status', ".
				"br_date='$br_date', ".
				"br_time='$br_time', ".
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
