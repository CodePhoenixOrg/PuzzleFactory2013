<?php   
	include_once("puzzle/ipz_mysqlconn.php");
	include_once("puzzle/ipz_db_controls.php");
	$cs=connection(CONNECT,$database);
	$query = get_variable("query", "SELECT");
	$event = get_variable("event", "onLoad");
	$action = get_variable("action", "Ajouter");
	$id = get_variable("id");
	$di = get_variable("di");
	$me_id = get_variable("me_id");
	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(me_id) from menus;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$me_id=$rows[0]+1;
			$me_level="";
			$me_target="";
			$pa_id="";
			$bl_id="";
			$me_charset="";
		break;
		case "Modifier":
			$sql="select * from menus where me_id='$me_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$me_id=$rows["me_id"];
			$me_level=$rows["me_level"];
			$me_target=$rows["me_target"];
			$pa_id=$rows["pa_id"];
			$bl_id=$rows["bl_id"];
			$me_charset=$rows["me_charset"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":
			$me_id = $_POST["me_id"];
			$me_level = $_POST["me_level"];
			$me_target = $_POST["me_target"];
			$pa_id = $_POST["pa_id"];
			$bl_id = $_POST["bl_id"];
			$me_charset = $_POST["me_charset"];
;
			$sql="insert into menus (".
				"me_id, ".
				"me_level, ".
				"me_target, ".
				"pa_id, ".
				"bl_id, ".
				"me_charset".
			") values (".
				"$me_id, ".
				"$me_level, ".
				"$me_target, ".
				"$pa_id, ".
				"$bl_id, ".
				"$me_charset".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$me_id = $_POST["me_id"];
			$me_level = $_POST["me_level"];
			$me_target = $_POST["me_target"];
			$pa_id = $_POST["pa_id"];
			$bl_id = $_POST["bl_id"];
			$me_charset = $_POST["me_charset"];
;
			$sql="update menus set ".
				"me_id='$me_id', ".
				"me_level='$me_level', ".
				"me_target='$me_target', ".
				"pa_id='$pa_id', ".
				"bl_id='$bl_id', ".
				"me_charset='$me_charset' ".
			"where me_id='$me_id'";
			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from menus where me_id='$me_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection(DISCONNECT,$database);
		echo "<script language='JavaScript'>window.location.href='page.php?id=59&lg=fr'</script>";
	}
?>
