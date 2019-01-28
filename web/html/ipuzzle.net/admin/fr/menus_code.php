<?php   
	$cs=connection(CONNECT,$database);
	$query = getArgument("query", "SELECT");
	$event = getArgument("event", "onLoad");
	$action = getArgument("action", "Ajouter");
	$id = getArgument("id");
	$di = getArgument("di");
	$me_id = getArgument("me_id");
	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(me_id) from pz_menus;";
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
			$sql="select * from pz_menus where me_id='$me_id';";
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
			$me_id = filterPOST("me_id");
			$me_level = filterPOST("me_level");
			$me_target = filterPOST("me_target");
			$pa_id = filterPOST("pa_id");
			$bl_id = filterPOST("bl_id");
			$me_charset = filterPOST("me_charset");
;
			$sql="insert into pz_menus (".
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
			$me_id = filterPOST("me_id");
			$me_level = filterPOST("me_level");
			$me_target = filterPOST("me_target");
			$pa_id = filterPOST("pa_id");
			$bl_id = filterPOST("bl_id");
			$me_charset = filterPOST("me_charset");
;
			$sql="update pz_menus set ".
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
			$sql="delete from pz_menus where me_id='$me_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection(DISCONNECT,$database);
		echo "<script language='JavaScript'>window.location.href='page.php?id=59&lg=fr'</script>";
	}
?>
