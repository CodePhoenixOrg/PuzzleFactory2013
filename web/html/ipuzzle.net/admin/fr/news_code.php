<?php   
	$cs=connection(CONNECT,$database);
	$query = getArgument("query", "SELECT");
	$event = getArgument("event", "onLoad");
	$action = getArgument("action", "Ajouter");
	$id = getArgument("id");
	$di = getArgument("di");
	$nw_id = getArgument("nw_id");
	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(nw_id) from pz_news;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$nw_title="";
			$nw_author="";
			$nw_text="";
			$nw_url="";
			$nw_picture="";
			$nw_date="";
		break;
		case "Modifier":
			$sql="select * from pz_news where nw_id='$nw_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$nw_title=$rows["nw_title"];
			$nw_author=$rows["nw_author"];
			$nw_text=$rows["nw_text"];
			$nw_url=$rows["nw_url"];
			$nw_picture=$rows["nw_picture"];
			$nw_date=$rows["nw_date"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":
			$nw_title = filterPOST("nw_title");
			$nw_author = filterPOST("nw_author");
			$nw_text = filterPOST("nw_text");
			$nw_url = filterPOST("nw_url");
			$nw_picture = filterPOST("nw_picture");
			$nw_date = filterPOST("nw_date");
			$nw_title=escapeChars($nw_title);
			$nw_author=escapeChars($nw_author);
			$nw_url=escapeChars($nw_url);
			$nw_picture=escapeChars($nw_picture);
			$sql="insert into pz_news (".
				"nw_title, ".
				"nw_author, ".
				"nw_text, ".
				"nw_url, ".
				"nw_picture, ".
				"nw_date".
			") values (".
				"'$nw_title', ".
				"'$nw_author', ".
				"'$nw_text', ".
				"'$nw_url', ".
				"'$nw_picture', ".
				"'$nw_date'".
			")";
			debugLog(__FILE__ . ':' . __LINE__ . ':SQL:' . $sql);
			
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$nw_title = filterPOST("nw_title");
			$nw_author = filterPOST("nw_author");
			$nw_text = filterPOST("nw_text");
			$nw_url = filterPOST("nw_url");
			$nw_picture = filterPOST("nw_picture");
			$nw_date = filterPOST("nw_date");
			$nw_title=escapeChars($nw_title);
			$nw_author=escapeChars($nw_author);
			$nw_url=escapeChars($nw_url);
			$nw_picture=escapeChars($nw_picture);
			$sql="update pz_news set ".
				"nw_title='$nw_title', ".
				"nw_author='$nw_author', ".
				"nw_text='$nw_text', ".
				"nw_url='$nw_url', ".
				"nw_picture='$nw_picture', ".
				"nw_date='$nw_date' ".
			"where nw_id='$nw_id'";

			debugLog(__FILE__ . ':' . __LINE__ . ':SQL:' . $sql);

			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from pz_news where nw_id='$nw_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection(DISCONNECT,$database);
		echo "<script language='JavaScript'>window.location.href='page.php?id=1&lg=fr'</script>";
	}
?>
