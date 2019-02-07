<?php   
	$cs = connection(CONNECT,$database);
	$query = getArgument("query", "SELECT");
	$event = getArgument("event", "onLoad");
	$action = getArgument("action", "Ajouter");
	$id = getArgument("id");
	$di = getArgument("di");
	$tablename = "pz_menus";
	$me_id = getArgument("me_id");
	if($event === "onLoad" && $query === "ACTION") {
		switch ($action) {
		case "Ajouter":

			$me_level="";
			$me_target="";
			$me_charset="";
			$pa_id="";
			$bl_id="";
		break;
		case "Modifier":
			$sql="select * from $tablename where me_id='$me_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$me_level = $rows["me_level"];
			$me_target = $rows["me_target"];
			$me_charset = $rows["me_charset"];
			$pa_id = $rows["pa_id"];
			$bl_id = $rows["bl_id"];
		break;
		}
	} else if($event === "onRun" && $query === "ACTION") {
		switch ($action) {
		case "Ajouter":
			$me_level = filterPOST("me_level");
			$me_target = filterPOST("me_target");
			$me_charset = filterPOST("me_charset");
			$pa_id = filterPOST("pa_id");
			$bl_id = filterPOST("bl_id");
			$sql = <<<SQL
			insert into $tablename (
				me_level, 
				me_target, 
				me_charset, 
				pa_id, 
				bl_id
			) values (
				:me_level, 
				:me_target, 
				:me_charset, 
				:pa_id, 
				:bl_id
			)
SQL;
			$stmt = $cs->prepare($sql);
			$stmt->execute([':me_level' => $me_level, ':me_target' => $me_target, ':me_charset' => $me_charset, ':pa_id' => $pa_id, ':bl_id' => $bl_id]);
		break;
		case "Modifier":
			$me_level = filterPOST("me_level");
			$me_target = filterPOST("me_target");
			$me_charset = filterPOST("me_charset");
			$pa_id = filterPOST("pa_id");
			$bl_id = filterPOST("bl_id");
			$sql=<<<SQL
			update $tablename set 
				me_level = :me_level, 
				me_target = :me_target, 
				me_charset = :me_charset, 
				pa_id = :pa_id, 
				bl_id = :bl_id
			where me_id = '$me_id';
SQL;
			$stmt = $cs->prepare($sql);
			$stmt->execute([':me_level' => $me_level, ':me_target' => $me_target, ':me_charset' => $me_charset, ':pa_id' => $pa_id, ':bl_id' => $bl_id, ':me_level' => $me_level, ':me_target' => $me_target, ':me_charset' => $me_charset, ':pa_id' => $pa_id, ':bl_id' => $bl_id]);
		break;
		case "Supprimer":
			$sql = "delete from $tablename where me_id='$me_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	}
