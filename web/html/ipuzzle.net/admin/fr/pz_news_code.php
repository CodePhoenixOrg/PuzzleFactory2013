<?php   
	$cs=connection(CONNECT,$database);
	$query = getVariable("query", "SELECT");
	$event = getVariable("event", "onLoad");
	$action = getVariable("action", "Ajouter");
	$id = getVariable("id");
	$di = getVariable("di");
	$nw_id = getVariable("nw_id");
	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(nw_id) from pz_news;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$nw_id=$rows[0]+1;
			$nw_title="";
			$nw_author="";
			$nw_text="";
			$nw_url="";
			$nw_picture="";
			$nw_time="";
			$nw_date="";
		break;
		case "Modifier":
			$sql="select * from pz_news where nw_id='$nw_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$nw_id=$rows["nw_id"];
			$nw_title=$rows["nw_title"];
			$nw_author=$rows["nw_author"];
			$nw_text=$rows["nw_text"];
			$nw_url=$rows["nw_url"];
			$nw_picture=$rows["nw_picture"];
			$nw_time=$rows["nw_time"];
			$nw_date=$rows["nw_date"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":
			$nw_id = $_POST["nw_id"];
			$nw_title = $_POST["nw_title"];
			$nw_author = $_POST["nw_author"];
			$nw_text = $_POST["nw_text"];
			$nw_url = $_POST["nw_url"];
			$nw_picture = $_POST["nw_picture"];
			$nw_time = $_POST["nw_time"];
			$nw_date = $_POST["nw_date"];
			$nw_title=escapeChars($nw_title);
			$nw_author=escapeChars($nw_author);
			$nw_url=escapeChars($nw_url);
			$nw_picture=escapeChars($nw_picture);
			$sql="insert into pz_news (".
				"nw_id, ".
				"nw_title, ".
				"nw_author, ".
				"nw_text, ".
				"nw_url, ".
				"nw_picture, ".
				"nw_time, ".
				"nw_date".
			") values (".
				"$nw_id, ".
				"'$nw_title', ".
				"'$nw_author', ".
				"'$nw_text', ".
				"'$nw_url', ".
				"'$nw_picture', ".
				"'$nw_time', ".
				"'$nw_date'".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$nw_id = $_POST["nw_id"];
			$nw_title = $_POST["nw_title"];
			$nw_author = $_POST["nw_author"];
			$nw_text = $_POST["nw_text"];
			$nw_url = $_POST["nw_url"];
			$nw_picture = $_POST["nw_picture"];
			$nw_time = $_POST["nw_time"];
			$nw_date = $_POST["nw_date"];
			$nw_title=escapeChars($nw_title);
			$nw_author=escapeChars($nw_author);
			$nw_url=escapeChars($nw_url);
			$nw_picture=escapeChars($nw_picture);
			$sql="update pz_news set ".
				"nw_id='$nw_id', ".
				"nw_title='$nw_title', ".
				"nw_author='$nw_author', ".
				"nw_text='$nw_text', ".
				"nw_url='$nw_url', ".
				"nw_picture='$nw_picture', ".
				"nw_time='$nw_time', ".
				"nw_date='$nw_date' ".
			"where nw_id='$nw_id'";
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
		echo "<script language='JavaScript'>window.location.href='page.php?id=211&lg=fr'</script>";
	}
?>
