<?php   
	$cs=connection(CONNECT,$database);
	$query = getArgument("query", "SELECT");
	$event = getArgument("event", "onLoad");
	$action = getArgument("action", "Ajouter");
	$id = getArgument("id");
	$di = getArgument("di");
	$bo_id = getArgument("bo_id");
	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(bo_id) from pz_books;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$bo_id=$rows[0]+1;
			$bo_title="";
			$bo_author="";
			$bo_publisher="";
			$bo_description="";
			$bo_isbn="";
			$bo_coverpath="";
		break;
		case "Modifier":
			$sql="select * from pz_books where bo_id='$bo_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$bo_id=$rows["bo_id"];
			$bo_title=$rows["bo_title"];
			$bo_author=$rows["bo_author"];
			$bo_publisher=$rows["bo_publisher"];
			$bo_description=$rows["bo_description"];
			$bo_isbn=$rows["bo_isbn"];
			$bo_coverpath=$rows["bo_coverpath"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":
			$bo_id = filterPOST("bo_id");
			$bo_title = filterPOST("bo_title");
			$bo_author = filterPOST("bo_author");
			$bo_publisher = filterPOST("bo_publisher");
			$bo_description = filterPOST("bo_description");
			$bo_isbn = filterPOST("bo_isbn");
			$bo_coverpath = filterPOST("bo_coverpath");
			$bo_title=escapeChars($bo_title);
			$bo_author=escapeChars($bo_author);
			$bo_publisher=escapeChars($bo_publisher);
			$bo_isbn=escapeChars($bo_isbn);
			$bo_coverpath=escapeChars($bo_coverpath);
			$sql="insert into pz_books (".
				"bo_id, ".
				"bo_title, ".
				"bo_author, ".
				"bo_publisher, ".
				"bo_description, ".
				"bo_isbn, ".
				"bo_coverpath".
			") values (".
				"$bo_id, ".
				"'$bo_title', ".
				"'$bo_author', ".
				"'$bo_publisher', ".
				"'$bo_description', ".
				"'$bo_isbn', ".
				"'$bo_coverpath'".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$bo_id = filterPOST("bo_id");
			$bo_title = filterPOST("bo_title");
			$bo_author = filterPOST("bo_author");
			$bo_publisher = filterPOST("bo_publisher");
			$bo_description = filterPOST("bo_description");
			$bo_isbn = filterPOST("bo_isbn");
			$bo_coverpath = filterPOST("bo_coverpath");
			$bo_title=escapeChars($bo_title);
			$bo_author=escapeChars($bo_author);
			$bo_publisher=escapeChars($bo_publisher);
			$bo_isbn=escapeChars($bo_isbn);
			$bo_coverpath=escapeChars($bo_coverpath);
			$sql="update pz_books set ".
				"bo_id='$bo_id', ".
				"bo_title='$bo_title', ".
				"bo_author='$bo_author', ".
				"bo_publisher='$bo_publisher', ".
				"bo_description='$bo_description', ".
				"bo_isbn='$bo_isbn', ".
				"bo_coverpath='$bo_coverpath' ".
			"where bo_id='$bo_id'";
			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from pz_books where bo_id='$bo_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection(DISCONNECT,$database);
		echo "<script language='JavaScript'>window.location.href='page.php?id=227&lg=fr'</script>";
	}
?>
