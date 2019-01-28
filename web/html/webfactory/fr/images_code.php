<?php   
	$cs=connection(CONNECT,$database);
	$query = getArgument("query", "SELECT");
	$event = getArgument("event", "onLoad");
	$action = getArgument("action", "Ajouter");
	$id = getArgument("id");
	$di = getArgument("di");
	$im_id = getArgument("im_id");
	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(im_id) from images;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$im_id=$rows[0]+1;
			$im_name="";
			$im_dir="";
			$im_url="";
			$im_site="";
		break;
		case "Modifier":
			$sql="select * from images where im_id='$im_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$im_id=$rows["im_id"];
			$im_name=$rows["im_name"];
			$im_dir=$rows["im_dir"];
			$im_url=$rows["im_url"];
			$im_site=$rows["im_site"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":
			$im_id = filterPOST("im_id");
			$im_name = filterPOST("im_name");
			$im_dir = filterPOST("im_dir");
			$im_url = filterPOST("im_url");
			$im_site = filterPOST("im_site");
			$im_name=escapeChars($im_name);
			$im_dir=escapeChars($im_dir);
			$im_url=escapeChars($im_url);
			$sql="insert into images (".
				"im_id, ".
				"im_name, ".
				"im_dir, ".
				"im_url, ".
				"im_site".
			") values (".
				"$im_id, ".
				"'$im_name', ".
				"'$im_dir', ".
				"'$im_url', ".
				"$im_site".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$im_id = filterPOST("im_id");
			$im_name = filterPOST("im_name");
			$im_dir = filterPOST("im_dir");
			$im_url = filterPOST("im_url");
			$im_site = filterPOST("im_site");
			$im_name=escapeChars($im_name);
			$im_dir=escapeChars($im_dir);
			$im_url=escapeChars($im_url);
			$sql="update images set ".
				"im_id='$im_id', ".
				"im_name='$im_name', ".
				"im_dir='$im_dir', ".
				"im_url='$im_url', ".
				"im_site='$im_site' ".
			"where im_id='$im_id'";
			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from images where im_id='$im_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection(DISCONNECT,$database);
		echo "<script language='JavaScript'>window.location.href='page.php?id=58&lg=fr'</script>";
	}
?>
