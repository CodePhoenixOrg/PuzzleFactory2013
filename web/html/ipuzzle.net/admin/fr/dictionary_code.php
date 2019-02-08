<?php   
	$cs = connection(CONNECT,$database);
	$query = getArgument("query", "SELECT");
	$event = getArgument("event", "onLoad");
	$action = getArgument("action", "Ajouter");
	$id = getArgument("id");
	$di = getArgument("di");
	$tablename = "pz_dictionary";
	$di_id = getArgument("di_id");
	if($event === "onLoad" && $query === "ACTION") {
		switch ($action) {
		case "Ajouter":

			$di_name="";
			$di_fr_short="";
			$di_fr_long="";
			$di_en_short="";
			$di_en_long="";
			$di_ru_short="";
			$di_ru_long="";
		break;
		case "Modifier":
			$sql="select * from $tablename where di_id='$di_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$di_name = $rows["di_name"];
			$di_fr_short = $rows["di_fr_short"];
			$di_fr_long = $rows["di_fr_long"];
			$di_en_short = $rows["di_en_short"];
			$di_en_long = $rows["di_en_long"];
			$di_ru_short = $rows["di_ru_short"];
			$di_ru_long = $rows["di_ru_long"];
		break;
		}
	} else if($event === "onRun" && $query === "ACTION") {
		switch ($action) {
		case "Ajouter":
			$di_name = filterPOST("di_name");
			$di_fr_short = filterPOST("di_fr_short");
			$di_fr_long = filterPOST("di_fr_long");
			$di_en_short = filterPOST("di_en_short");
			$di_en_long = filterPOST("di_en_long");
			$di_ru_short = filterPOST("di_ru_short");
			$di_ru_long = filterPOST("di_ru_long");
			$sql = <<<SQL
			insert into $tablename (
				di_name, 
				di_fr_short, 
				di_fr_long, 
				di_en_short, 
				di_en_long, 
				di_ru_short, 
				di_ru_long
			) values (
				:di_name, 
				:di_fr_short, 
				:di_fr_long, 
				:di_en_short, 
				:di_en_long, 
				:di_ru_short, 
				:di_ru_long
			)
SQL;
			$stmt = $cs->prepare($sql);
			$stmt->execute([':di_name' => $di_name, ':di_fr_short' => $di_fr_short, ':di_fr_long' => $di_fr_long, ':di_en_short' => $di_en_short, ':di_en_long' => $di_en_long, ':di_ru_short' => $di_ru_short, ':di_ru_long' => $di_ru_long]);
		break;
		case "Modifier":
			$di_name = filterPOST("di_name");
			$di_fr_short = filterPOST("di_fr_short");
			$di_fr_long = filterPOST("di_fr_long");
			$di_en_short = filterPOST("di_en_short");
			$di_en_long = filterPOST("di_en_long");
			$di_ru_short = filterPOST("di_ru_short");
			$di_ru_long = filterPOST("di_ru_long");
			$sql=<<<SQL
			update $tablename set 
				di_name = :di_name, 
				di_fr_short = :di_fr_short, 
				di_fr_long = :di_fr_long, 
				di_en_short = :di_en_short, 
				di_en_long = :di_en_long, 
				di_ru_short = :di_ru_short, 
				di_ru_long = :di_ru_long
			where di_id = '$di_id';
SQL;
			$stmt = $cs->prepare($sql);
			$stmt->execute([':di_name' => $di_name, ':di_fr_short' => $di_fr_short, ':di_fr_long' => $di_fr_long, ':di_en_short' => $di_en_short, ':di_en_long' => $di_en_long, ':di_ru_short' => $di_ru_short, ':di_ru_long' => $di_ru_long, ':di_name' => $di_name, ':di_fr_short' => $di_fr_short, ':di_fr_long' => $di_fr_long, ':di_en_short' => $di_en_short, ':di_en_long' => $di_en_long, ':di_ru_short' => $di_ru_short, ':di_ru_long' => $di_ru_long]);
		break;
		case "Supprimer":
			$sql = "delete from $tablename where di_id='$di_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	}
