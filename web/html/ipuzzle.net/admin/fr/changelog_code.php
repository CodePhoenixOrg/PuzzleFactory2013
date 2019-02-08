<?php   
	$cs = connection(CONNECT,$database);
	$query = getArgument("query", "SELECT");
	$event = getArgument("event", "onLoad");
	$action = getArgument("action", "Ajouter");
	$id = getArgument("id");
	$di = getArgument("di");
	$tablename = "pz_changelog";
	$cl_id = getArgument("cl_id");
	if($event === "onLoad" && $query === "ACTION") {
		switch ($action) {
		case "Ajouter":

			$cl_title="";
			$cl_text="";
			$cl_date="";
			$cl_time="";
			$fr_id="";
			$mbr_id="";
		break;
		case "Modifier":
			$sql="select * from $tablename where cl_id='$cl_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$cl_title = $rows["cl_title"];
			$cl_text = $rows["cl_text"];
			$cl_date = $rows["cl_date"];
			$cl_time = $rows["cl_time"];
			$fr_id = $rows["fr_id"];
			$mbr_id = $rows["mbr_id"];
		break;
		}
	} else if($event === "onRun" && $query === "ACTION") {
		switch ($action) {
		case "Ajouter":
			$cl_title = filterPOST("cl_title");
			$cl_text = filterPOST("cl_text");
			$cl_date = filterPOST("cl_date");
			$cl_time = filterPOST("cl_time");
			$fr_id = filterPOST("fr_id");
			$mbr_id = filterPOST("mbr_id");
			$sql = <<<SQL
			insert into $tablename (
				cl_title, 
				cl_text, 
				cl_date, 
				cl_time, 
				fr_id, 
				mbr_id
			) values (
				:cl_title, 
				:cl_text, 
				:cl_date, 
				:cl_time, 
				:fr_id, 
				:mbr_id
			)
SQL;
			$stmt = $cs->prepare($sql);
			$stmt->execute([':cl_title' => $cl_title, ':cl_text' => $cl_text, ':cl_date' => $cl_date, ':cl_time' => $cl_time, ':fr_id' => $fr_id, ':mbr_id' => $mbr_id]);
		break;
		case "Modifier":
			$cl_title = filterPOST("cl_title");
			$cl_text = filterPOST("cl_text");
			$cl_date = filterPOST("cl_date");
			$cl_time = filterPOST("cl_time");
			$fr_id = filterPOST("fr_id");
			$mbr_id = filterPOST("mbr_id");
			$sql=<<<SQL
			update $tablename set 
				cl_title = :cl_title, 
				cl_text = :cl_text, 
				cl_date = :cl_date, 
				cl_time = :cl_time, 
				fr_id = :fr_id, 
				mbr_id = :mbr_id
			where cl_id = '$cl_id';
SQL;
			$stmt = $cs->prepare($sql);
			$stmt->execute([':cl_title' => $cl_title, ':cl_text' => $cl_text, ':cl_date' => $cl_date, ':cl_time' => $cl_time, ':fr_id' => $fr_id, ':mbr_id' => $mbr_id, ':cl_title' => $cl_title, ':cl_text' => $cl_text, ':cl_date' => $cl_date, ':cl_time' => $cl_time, ':fr_id' => $fr_id, ':mbr_id' => $mbr_id]);
		break;
		case "Supprimer":
			$sql = "delete from $tablename where cl_id='$cl_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	}
