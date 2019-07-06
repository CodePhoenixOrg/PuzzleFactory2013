<?php   
	$cs = connection(CONNECT,$database);
	$query = getArgument("query", "SELECT");
	$event = getArgument("event", "onLoad");
	$action = getArgument("action", "Ajouter");
	$id = getArgument("id");
	$di = getArgument("di");
	$tablename = "servers";
	$se_id = getArgument("se_id");
	if($event === "onLoad" && $query === "ACTION") {
		switch ($action) {
		case "Ajouter":

			$se_type="";
			$se_host="";
			$se_site="";
		break;
		case "Modifier":
			$sql="select * from $tablename where se_id='$se_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$se_type = $rows["se_type"];
			$se_host = $rows["se_host"];
			$se_site = $rows["se_site"];
		break;
		}
	} else if($event === "onRun" && $query === "ACTION") {
		switch ($action) {
		case "Ajouter":
			$se_type = filterPOST("se_type");
			$se_host = filterPOST("se_host");
			$se_site = filterPOST("se_site");
			$sql = <<<SQL
			insert into $tablename (
				se_type, 
				se_host, 
				se_site
			) values (
				:se_type, 
				:se_host, 
				:se_site
			)
SQL;
			$stmt = $cs->prepare($sql);
			$stmt->execute([':se_type' => $se_type, ':se_host' => $se_host, ':se_site' => $se_site]);
		break;
		case "Modifier":
			$se_type = filterPOST("se_type");
			$se_host = filterPOST("se_host");
			$se_site = filterPOST("se_site");
			$sql=<<<SQL
			update $tablename set 
				se_type = :se_type, 
				se_host = :se_host, 
				se_site = :se_site
			where se_id = '$se_id';
SQL;
			$stmt = $cs->prepare($sql);
			$stmt->execute([':se_type' => $se_type, ':se_host' => $se_host, ':se_site' => $se_site, ':se_type' => $se_type, ':se_host' => $se_host, ':se_site' => $se_site]);
		break;
		case "Supprimer":
			$sql = "delete from $tablename where se_id='$se_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	}
