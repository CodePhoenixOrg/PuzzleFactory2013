<?php   
	$cs = connection(CONNECT,$database);
	$query = getArgument("query", "SELECT");
	$event = getArgument("event", "onLoad");
	$action = getArgument("action", "Ajouter");
	$id = getArgument("id");
	$di = getArgument("di");
	$tablename = "pz_todo";
	$td_id = getArgument("td_id");
	if($event === "onLoad" && $query === "ACTION") {
		switch ($action) {
		case "Ajouter":

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
			$sql="select * from $tablename where td_id='$td_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$td_title = $rows["td_title"];
			$td_text = $rows["td_text"];
			$td_priority = $rows["td_priority"];
			$td_expiry = $rows["td_expiry"];
			$td_status = $rows["td_status"];
			$td_date = $rows["td_date"];
			$td_time = $rows["td_time"];
			$mbr_id = $rows["mbr_id"];
		break;
		}
	} else if($event === "onRun" && $query === "ACTION") {
		switch ($action) {
		case "Ajouter":
			$td_title = filterPOST("td_title");
			$td_text = filterPOST("td_text");
			$td_priority = filterPOST("td_priority");
			$td_expiry = filterPOST("td_expiry");
			$td_status = filterPOST("td_status");
			$td_date = filterPOST("td_date");
			$td_time = filterPOST("td_time");
			$mbr_id = filterPOST("mbr_id");
			$sql = <<<SQL
			insert into $tablename (
				td_title, 
				td_text, 
				td_priority, 
				td_expiry, 
				td_status, 
				td_date, 
				td_time, 
				mbr_id
			) values (
				:td_title, 
				:td_text, 
				:td_priority, 
				:td_expiry, 
				:td_status, 
				:td_date, 
				:td_time, 
				:mbr_id
			)
SQL;
			$stmt = $cs->prepare($sql);
			$stmt->execute([':td_title' => $td_title, ':td_text' => $td_text, ':td_priority' => $td_priority, ':td_expiry' => $td_expiry, ':td_status' => $td_status, ':td_date' => $td_date, ':td_time' => $td_time, ':mbr_id' => $mbr_id]);
		break;
		case "Modifier":
			$td_title = filterPOST("td_title");
			$td_text = filterPOST("td_text");
			$td_priority = filterPOST("td_priority");
			$td_expiry = filterPOST("td_expiry");
			$td_status = filterPOST("td_status");
			$td_date = filterPOST("td_date");
			$td_time = filterPOST("td_time");
			$mbr_id = filterPOST("mbr_id");
			$sql=<<<SQL
			update $tablename set 
				td_title = :td_title, 
				td_text = :td_text, 
				td_priority = :td_priority, 
				td_expiry = :td_expiry, 
				td_status = :td_status, 
				td_date = :td_date, 
				td_time = :td_time, 
				mbr_id = :mbr_id
			where td_id = '$td_id';
SQL;
			$stmt = $cs->prepare($sql);
			$stmt->execute([':td_title' => $td_title, ':td_text' => $td_text, ':td_priority' => $td_priority, ':td_expiry' => $td_expiry, ':td_status' => $td_status, ':td_date' => $td_date, ':td_time' => $td_time, ':mbr_id' => $mbr_id, ':td_title' => $td_title, ':td_text' => $td_text, ':td_priority' => $td_priority, ':td_expiry' => $td_expiry, ':td_status' => $td_status, ':td_date' => $td_date, ':td_time' => $td_time, ':mbr_id' => $mbr_id]);
		break;
		case "Supprimer":
			$sql = "delete from $tablename where td_id='$td_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	}
