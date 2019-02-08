<?php   
	$cs = connection(CONNECT,$database);
	$query = getArgument("query", "SELECT");
	$event = getArgument("event", "onLoad");
	$action = getArgument("action", "Ajouter");
	$id = getArgument("id");
	$di = getArgument("di");
	$tablename = "pz_bugreport";
	$br_id = getArgument("br_id");
	if($event === "onLoad" && $query === "ACTION") {
		switch ($action) {
		case "Ajouter":

			$br_title="";
			$br_text="";
			$br_importance="";
			$br_status="";
			$br_date="";
			$br_time="";
			$mbr_id="";
		break;
		case "Modifier":
			$sql="select * from $tablename where br_id='$br_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$br_title = $rows["br_title"];
			$br_text = $rows["br_text"];
			$br_importance = $rows["br_importance"];
			$br_status = $rows["br_status"];
			$br_date = $rows["br_date"];
			$br_time = $rows["br_time"];
			$mbr_id = $rows["mbr_id"];
		break;
		}
	} else if($event === "onRun" && $query === "ACTION") {
		switch ($action) {
		case "Ajouter":
			$br_title = filterPOST("br_title");
			$br_text = filterPOST("br_text");
			$br_importance = filterPOST("br_importance");
			$br_status = filterPOST("br_status");
			$br_date = filterPOST("br_date");
			$br_time = filterPOST("br_time");
			$mbr_id = filterPOST("mbr_id");
			$sql = <<<SQL
			insert into $tablename (
				br_title, 
				br_text, 
				br_importance, 
				br_status, 
				br_date, 
				br_time, 
				mbr_id
			) values (
				:br_title, 
				:br_text, 
				:br_importance, 
				:br_status, 
				:br_date, 
				:br_time, 
				:mbr_id
			)
SQL;
			$stmt = $cs->prepare($sql);
			$stmt->execute([':br_title' => $br_title, ':br_text' => $br_text, ':br_importance' => $br_importance, ':br_status' => $br_status, ':br_date' => $br_date, ':br_time' => $br_time, ':mbr_id' => $mbr_id]);
		break;
		case "Modifier":
			$br_title = filterPOST("br_title");
			$br_text = filterPOST("br_text");
			$br_importance = filterPOST("br_importance");
			$br_status = filterPOST("br_status");
			$br_date = filterPOST("br_date");
			$br_time = filterPOST("br_time");
			$mbr_id = filterPOST("mbr_id");
			$sql=<<<SQL
			update $tablename set 
				br_title = :br_title, 
				br_text = :br_text, 
				br_importance = :br_importance, 
				br_status = :br_status, 
				br_date = :br_date, 
				br_time = :br_time, 
				mbr_id = :mbr_id
			where br_id = '$br_id';
SQL;
			$stmt = $cs->prepare($sql);
			$stmt->execute([':br_title' => $br_title, ':br_text' => $br_text, ':br_importance' => $br_importance, ':br_status' => $br_status, ':br_date' => $br_date, ':br_time' => $br_time, ':mbr_id' => $mbr_id, ':br_title' => $br_title, ':br_text' => $br_text, ':br_importance' => $br_importance, ':br_status' => $br_status, ':br_date' => $br_date, ':br_time' => $br_time, ':mbr_id' => $mbr_id]);
		break;
		case "Supprimer":
			$sql = "delete from $tablename where br_id='$br_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	}
