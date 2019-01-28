<?php    
	$cs=connection(CONNECT,$database);
	$query = getArgument("query", "SELECT");
	$event = getArgument("event", "onLoad");
	$action = getArgument("action", "Ajouter");
	$id = getArgument("id");
	$di = getArgument("di");
	$di_name = getArgument("di_name");

	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(di_name) from pz_dictionary;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$di_name=$rows[0]+1;
			$di_fr_short="";
			$di_fr_long="";
			$di_en_short="";
			$di_en_long="";
			$di_ru_short="";
			$di_ru_long="";
		break;
		case "Modifier":
			$sql="select * from pz_dictionary where di_name='$di_name';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$di_name=$rows["di_name"];
			$di_fr_short=$rows["di_fr_short"];
			$di_fr_long=$rows["di_fr_long"];
			$di_en_short=$rows["di_en_short"];
			$di_en_long=$rows["di_en_long"];
			$di_ru_short=$rows["di_ru_short"];
			$di_ru_long=$rows["di_ru_long"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":
			$sql="insert into pz_dictionary (".
				"di_name, ".
				"di_fr_short, ".
				"di_fr_long, ".
				"di_en_short, ".
				"di_en_long, ".
				"di_ru_short, ".
				"di_ru_long".
			") values (".
				"'$di_name', ".
				"'$di_fr_short', ".
				"'$di_fr_long', ".
				"'$di_en_short', ".
				"'$di_en_long', ".
				"'$di_ru_short', ".
				"'$di_ru_long'".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$di_name = filterPOST("di_name");
			$di_fr_short = filterPOST("di_fr_short");
			$di_fr_long = filterPOST("di_fr_long");
			$di_en_short = filterPOST("di_en_short");
			$di_en_long = filterPOST("di_en_long");
			$di_ru_short = filterPOST("di_ru_short");
			$di_ru_long = filterPOST("di_ru_long");
			$sql="update pz_dictionary set ".
				"di_name='$di_name', ".
				"di_fr_short='$di_fr_short', ".
				"di_fr_long='$di_fr_long', ".
				"di_en_short='$di_en_short', ".
				"di_en_long='$di_en_long', ".
				"di_ru_short='$di_ru_short', ".
				"di_ru_long='$di_ru_long' ".
			"where di_name='$di_name'";
			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from pz_dictionary where di_name='$di_name'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection(DISCONNECT,$database);
		echo "<script language='JavaScript'>window.location.href='page.php?id=21&lg=fr'</script>";
	}
?>
