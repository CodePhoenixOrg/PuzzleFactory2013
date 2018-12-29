<?php   
	include_once("puzzle/ipz_mysqlconn.php");
	include_once("puzzle/ipz_db_controls.php");
	$cs=connection(CONNECT,$database);
	$query = get_variable("query", "SELECT");
	$event = get_variable("event", "onLoad");
	$action = get_variable("action", "Ajouter");
	$id = get_variable("id");
	$di = get_variable("di");
	$im_id = get_variable("im_id");
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
			$im_id = $_POST["im_id"];
			$im_name = $_POST["im_name"];
			$im_dir = $_POST["im_dir"];
			$im_url = $_POST["im_url"];
			$im_site = $_POST["im_site"];
;
			$sql="insert into images (".
				"im_id, ".
				"im_name, ".
				"im_dir, ".
				"im_url, ".
				"im_site".
			") values (".
				"$im_id, ".
				"$im_name, ".
				"$im_dir, ".
				"$im_url, ".
				"$im_site".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$im_id = $_POST["im_id"];
			$im_name = $_POST["im_name"];
			$im_dir = $_POST["im_dir"];
			$im_url = $_POST["im_url"];
			$im_site = $_POST["im_site"];
;
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
