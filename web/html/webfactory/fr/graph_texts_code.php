<?php   
	include_once("puzzle/ipz_mysqlconn.php");
	include_once("puzzle/ipz_db_controls.php");
	$cs=connection(CONNECT,$database);
	$query = get_variable("query");
	$event = get_variable("event");
	$action = get_variable("action");
	$gt_id = get_variable("gt_id");
	if(empty($query)) $query="SELECT";
	if(empty($event)) $event="onLoad";
	if(empty($action)) $action="Ajouter";
	if(isset($pc)) $curl_pager="&pc=$pc";
	if(isset($sr)) $curl_pager.="&sr=$sr";
	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(gt_id) from graph_texts;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$gt_id=$rows[0]+1;
			$gt_name="";
			$gt_text="";
			$si_id="";
		break;
		case "Modifier":
			$sql="select * from graph_texts where gt_id='$gt_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$gt_id=$rows["gt_id"];
			$gt_name=$rows["gt_name"];
			$gt_text=$rows["gt_text"];
			$si_id=$rows["si_id"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":
			$gt_id = $_POST["gt_id"];
			$gt_name = $_POST["gt_name"];
			$gt_text = $_POST["gt_text"];
			$si_id = $_POST["si_id"];
;
			$sql="insert into graph_texts (".
				"gt_id, ".
				"gt_name, ".
				"gt_text, ".
				"si_id".
			") values (".
				"$gt_id, ".
				"'$gt_name', ".
				"'$gt_text', ".
				"$si_id".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$gt_id = $_POST["gt_id"];
			$gt_name = $_POST["gt_name"];
			$gt_text = $_POST["gt_text"];
			$si_id = $_POST["si_id"];
;
			$sql="update graph_texts set ".
				"gt_id='$gt_id', ".
				"gt_name='$gt_name', ".
				"gt_text='$gt_text', ".
				"si_id='$si_id' ".
			"where gt_id='$gt_id'";
			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from graph_texts where gt_id='$gt_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection(DISCONNECT,$database);
		echo "<script language='JavaScript'>window.location.href='page.php?id=34&lg=fr'</script>";
	}
?>
