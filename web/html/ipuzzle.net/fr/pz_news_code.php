<?php   
	include_once("puzzle/ipz_mysqlconn.php");
	include_once("puzzle/ipz_db_controls.php");
	$cs=connection(CONNECT,$database);
	$query = get_variable("query");
	$event = get_variable("event");
	$action = get_variable("action");
	$nw_id = get_variable("nw_id");
	if(empty($query)) $query="SELECT";
	if(empty($event)) $event="onLoad";
	if(empty($action)) $action="Ajouter";
	if(isset($pc)) $curl_pager="&pc=$pc";
	if(isset($sr)) $curl_pager.="&sr=$sr";
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
;
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
				"'$nw_id', ".
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
;
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
		echo "<script language='JavaScript'>window.location.href='page.php?id=&lg=fr'</script>";
	}
?>
