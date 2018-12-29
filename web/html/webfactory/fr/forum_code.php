<?php   
	include_once("ipz_mysqlconn.php");
	include_once("ipz_db_controls.php");
	$cs=connection(CONNECT,$database);
	$query = get_variable("query");
	$event = get_variable("event");
	$action = get_variable("action");
	$fr_id = get_variable("fr_id");
	if(empty($query)) $query="SELECT";
	if(empty($event)) $event="onLoad";
	if(empty($action)) $action="Ajouter";
	if(isset($pc)) $curl_pager="&pc=$pc";
	if(isset($sr)) $curl_pager.="&sr=$sr";
	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(fr_id) from forums;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$fr_id=$rows[0]+1;
			$fr_title="";
			$fr_description="";
			$fr_date="";
			$fr_table_name="";
			$me_id="";
		break;
		case "Modifier":
			$sql="select * from forums where fr_id='$fr_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$fr_id=$rows["fr_id"];
			$fr_title=$rows["fr_title"];
			$fr_description=$rows["fr_description"];
			$fr_date=$rows["fr_date"];
			$fr_table_name=$rows["fr_table_name"];
			$me_id=$rows["me_id"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":
			$fr_id = $_POST["fr_id"];
			$fr_title = $_POST["fr_title"];
			$fr_description = $_POST["fr_description"];
			$fr_date = $_POST["fr_date"];
			$fr_table_name = $_POST["fr_table_name"];
			$me_id = $_POST["me_id"];
			$fr_title=escapeChars($fr_title);
			$fr_table_name=escapeChars($fr_table_name);
			$sql="insert into forums (".
				"fr_id, ".
				"fr_title, ".
				"fr_description, ".
				"fr_date, ".
				"fr_table_name, ".
				"me_id".
			") values (".
				"$fr_id, ".
				"'$fr_title', ".
				"'$fr_description', ".
				"'$fr_date', ".
				"'$fr_table_name', ".
				"$me_id".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$fr_id = $_POST["fr_id"];
			$fr_title = $_POST["fr_title"];
			$fr_description = $_POST["fr_description"];
			$fr_date = $_POST["fr_date"];
			$fr_table_name = $_POST["fr_table_name"];
			$me_id = $_POST["me_id"];
			$fr_title=escapeChars($fr_title);
			$fr_table_name=escapeChars($fr_table_name);
			$sql="update forums set ".
				"fr_id=$fr_id, ".
				"fr_title='$fr_title', ".
				"fr_description='$fr_description', ".
				"fr_date='$fr_date', ".
				"fr_table_name='$fr_table_name', ".
				"me_id=$me_id ".
			"where fr_id='$fr_id'";
			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from forums where fr_id='$fr_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection(DISCONNECT,$database);
		echo "<script language='JavaScript'>window.location.href='page.php?id=34&lg=fr'</script>";
	}
?>
