<?php    
	$cs=connection(CONNECT,$database);
	$query = getVariable("query", "SELECT");
	$event = getVariable("event", "onLoad");
	$action = getVariable("action", "Ajouter");
	$id = getVariable("id");
	$di = getVariable("di");
	$app_id = getVariable("app_id");

	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(app_id) from applications;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$app_id=$rows[0]+1;
			$app_link="";
			$di_name="";
		break;
		case "Modifier":
			$sql="select * from applications where app_id='$app_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$app_id=$rows["app_id"];
			$app_link=$rows["app_link"];
			$di_name=$rows["di_name"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":
			$sql="insert into applications (".
				"app_id, ".
				"app_link, ".
				"di_name".
			") values (".
				"'$app_id', ".
				"'$app_link', ".
				"'$di_name'".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$app_id = $_POST["app_id"];
			$app_link = $_POST["app_link"];
			$di_name = $_POST["di_name"];
			$sql="update applications set ".
				"app_id='$app_id', ".
				"app_link='$app_link', ".
				"di_name='$di_name' ".
			"where app_id='$app_id'";
			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from applications where app_id='$app_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection(DISCONNECT,$database);
		echo "<script language='JavaScript'>window.location.href='page.php?id=22&lg=fr'</script>";
	}
?>
