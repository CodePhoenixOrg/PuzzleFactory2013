<?php    
	$cs=connection(CONNECT,$database);
	$query = getVariable("query", "SELECT");
	$event = getVariable("event", "onLoad");
	$action = getVariable("action", "Ajouter");
	$id = getVariable("id");
	$di = getVariable("di");
	$pa_id = getVariable("pa_id");
	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(pa_id) from pages;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$pa_id=$rows[0]+1;
			$di_name="";
			$pa_filename="";
		break;
		case "Modifier":
			$sql="select * from pages where pa_id='$pa_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$pa_id=$rows["pa_id"];
			$di_name=$rows["di_name"];
			$pa_filename=$rows["pa_filename"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":
			$sql="insert into pages (".
				"pa_id, ".
				"di_name, ".
				"pa_filename".
			") values (".
				"'$pa_id', ".
				"'$di_name', ".
				"'$pa_filename'".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$pa_id = $_POST["pa_id"];
			$di_name = $_POST["di_name"];
			$pa_filename = $_POST["pa_filename"];
			$sql="update pages set ".
				"pa_id='$pa_id', ".
				"di_name='$di_name', ".
				"pa_filename='$pa_filename' ".
			"where pa_id='$pa_id'";
			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from pages where pa_id='$pa_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection(DISCONNECT,$database);
		echo "<script language='JavaScript'>window.location.href='page.php?id=19&lg=fr'</script>";
	}
?>
