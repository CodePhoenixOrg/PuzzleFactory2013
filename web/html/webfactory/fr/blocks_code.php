<?php    
	include_once 'puzzle/ipz_mysqlconn.php';
	include_once 'puzzle/ipz_db_controls.php';
	$cs=connection(CONNECT,$database);
	$query = get_variable("query");
	$event = get_variable("event");
	$action = get_variable("action");
	$bl_id = get_variable("bl_id");
	if(empty($query)) $query="SELECT";
	if(empty($event)) $event="onLoad";
	if(empty($action)) $action="Ajouter";
	if(isset($pc)) $curl_pager="&pc=$pc";
	if(isset($sr)) $curl_pager.="&sr=$sr";
	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(bl_id) from blocks;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$bl_id=$rows[0]+1;
			$bl_column="";
			$bl_type="";
			$di_name="";
		break;
		case "Modifier":
			$sql="select * from blocks where bl_id='$bl_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$bl_id=$rows["bl_id"];
			$bl_column=$rows["bl_column"];
			$bl_type=$rows["bl_type"];
			$di_name=$rows["di_name"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":
			$sql="insert into blocks (".
				"bl_id, ".
				"bl_column, ".
				"bl_type, ".
				"di_name".
			") values (".
				"'$bl_id', ".
				"'$bl_column', ".
				"'$bl_type', ".
				"'$di_name'".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$bl_id = $_POST["bl_id"];
			$bl_column = $_POST["bl_column"];
			$bl_type = $_POST["bl_type"];
			$di_name = $_POST["di_name"];
			$sql="update blocks set ".
				"bl_id='$bl_id', ".
				"bl_column='$bl_column', ".
				"bl_type='$bl_type', ".
				"di_name='$di_name' ".
			"where bl_id='$bl_id'";
			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from blocks where bl_id='$bl_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection(DISCONNECT,$database);
		echo "<script language='JavaScript'>window.location.href='page.php?id=20&lg=fr'</script>";
	}
?>
