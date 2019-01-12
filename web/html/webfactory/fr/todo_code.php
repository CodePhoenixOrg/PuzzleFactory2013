<?php    
	include_once 'puzzle/ipz_mysqlconn.php';
	include_once 'puzzle/ipz_db_controls.php';
	$cs=connection(CONNECT,$database);
	$query = get_variable("query");
	$event = get_variable("event");
	$action = get_variable("action");
	$td_id = get_variable("td_id");
	if(empty($query)) $query="SELECT";
	if(empty($event)) $event="onLoad";
	if(empty($action)) $action="Ajouter";
	if(isset($pc)) $curl_pager="&pc=$pc";
	if(isset($sr)) $curl_pager.="&sr=$sr";
	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(td_id) from todo;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$td_id=$rows[0]+1;
			$td_title="";
			$td_text="";
			$td_priority="";
			$td_expiry="";
			$td_status="";
			$td_date="";
			$td_time="";
			$mbr_id="";
		break;
		case "Modifier":
			$sql="select * from todo where td_id='$td_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$td_id=$rows["td_id"];
			$td_title=$rows["td_title"];
			$td_text=$rows["td_text"];
			$td_priority=$rows["td_priority"];
			$td_expiry=$rows["td_expiry"];
			$td_status=$rows["td_status"];
			$td_date=$rows["td_date"];
			$td_time=$rows["td_time"];
			$mbr_id=$rows["mbr_id"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":
			$td_id = $_POST["td_id"];
			$td_title = $_POST["td_title"];
			$td_text = $_POST["td_text"];
			$td_priority = $_POST["td_priority"];
			$td_expiry = $_POST["td_expiry"];
			$td_status = $_POST["td_status"];
			$td_date = $_POST["td_date"];
			$td_time = $_POST["td_time"];
			$mbr_id = $_POST["mbr_id"];
			$td_title=escapeChars($td_title);
			$td_text=escapeChars($td_text);
			$td_status=escapeChars($td_status);
            $td_date = date_french_to_mysql($td_date);
			$sql="insert into todo (".
				"td_id, ".
				"td_title, ".
				"td_text, ".
				"td_priority, ".
				"td_expiry, ".
				"td_status, ".
				"td_date, ".
				"td_time, ".
				"mbr_id".
			") values (".
				"$td_id, ".
				"'$td_title', ".
				"'$td_text', ".
				"$td_priority, ".
				"'$td_expiry', ".
				"'$td_status', ".
				"'$td_date', ".
				"'$td_time', ".
				"$mbr_id".
			")";
                        
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$td_id = $_POST["td_id"];
			$td_title = $_POST["td_title"];
			$td_text = $_POST["td_text"];
			$td_priority = $_POST["td_priority"];
			$td_expiry = $_POST["td_expiry"];
			$td_status = $_POST["td_status"];
			$td_date = $_POST["td_date"];
			$td_time = $_POST["td_time"];
			$mbr_id = $_POST["mbr_id"];
			$td_title=escapeChars($td_title);
			$td_text=escapeChars($td_text);
			$td_status=escapeChars($td_status);
            $td_date = date_french_to_mysql($td_date);
			$sql="update todo set ".
				"td_id=$td_id, ".
				"td_title='$td_title', ".
				"td_text='$td_text', ".
				"td_priority=$td_priority, ".
				"td_expiry='$td_expiry', ".
				"td_status='$td_status', ".
				"td_date='$td_date', ".
				"td_time='$td_time', ".
				"mbr_id=$mbr_id ".
			"where td_id='$td_id'";
			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from todo where td_id='$td_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection(DISCONNECT,$database);
		echo "<script language='JavaScript'>window.location.href='page.php?id=25&lg=fr'</script>";
	}
?>
