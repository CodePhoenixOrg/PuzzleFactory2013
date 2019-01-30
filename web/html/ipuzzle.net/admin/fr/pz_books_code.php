<?php   
	$cs = connection(CONNECT,$database);
	$query = getArgument("query", "SELECT");
	$event = getArgument("event", "onLoad");
	$action = getArgument("action", "Ajouter");
	$id = getArgument("id");
	$di = getArgument("di");
	$bo_id = getArgument("bo_id");
	if($event === "onLoad" && $query === "ACTION") {
		switch ($action) {
		case "Ajouter":

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
			$bo_title = filterValue($cs, $rows["bo_title"]);
			$bo_author = filterValue($cs, $rows["bo_author"]);
			$bo_publisher = filterValue($cs, $rows["bo_publisher"]);
			$bo_description = filterValue($cs, $rows["bo_description"]);
			$bo_isbn = filterValue($cs, $rows["bo_isbn"]);
			$bo_coverpath = filterValue($cs, $rows["bo_coverpath"]);
		break;
		}
	} else if($event === "onRun" && $query === "ACTION") {
		switch ($action) {
		case "Ajouter":
			$bo_title = filterPOST($cs, "bo_title");
			$bo_author = filterPOST($cs, "bo_author");
			$bo_publisher = filterPOST($cs, "bo_publisher");
			$bo_description = filterPOST($cs, "bo_description");
			$bo_isbn = filterPOST($cs, "bo_isbn");
			$bo_coverpath = filterPOST($cs, "bo_coverpath");
			$bo_title=filterValue($cs, $bo_title);
			$bo_author=filterValue($cs, $bo_author);
			$bo_publisher=filterValue($cs, $bo_publisher);
			$bo_isbn=filterValue($cs, $bo_isbn);
			$bo_coverpath=filterValue($cs, $bo_coverpath);
			$sql="insert into pz_books (".
				"bo_title, ".
				"bo_author, ".
				"bo_publisher, ".
				"bo_description, ".
				"bo_isbn, ".
				"bo_coverpath".
			") values (".
				"\"$bo_title\", ".
				"\"$bo_author\", ".
				"\"$bo_publisher\", ".
				"\"$bo_description\", ".
				"\"$bo_isbn\", ".
				"\"$bo_coverpath\"".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$bo_title = filterPOST($cs, "bo_title");
			$bo_author = filterPOST($cs, "bo_author");
			$bo_publisher = filterPOST($cs, "bo_publisher");
			$bo_description = filterPOST($cs, "bo_description");
			$bo_isbn = filterPOST($cs, "bo_isbn");
			$bo_coverpath = filterPOST($cs, "bo_coverpath");
			$bo_title=filterValue($cs, $bo_title);
			$bo_author=filterValue($cs, $bo_author);
			$bo_publisher=filterValue($cs, $bo_publisher);
			$bo_isbn=filterValue($cs, $bo_isbn);
			$bo_coverpath=filterValue($cs, $bo_coverpath);
			$sql="update pz_books set ".
				"bo_title=\"$bo_title\", ".
				"bo_author=\"$bo_author\", ".
				"bo_publisher=\"$bo_publisher\", ".
				"bo_description=\"$bo_description\", ".
				"bo_isbn=\"$bo_isbn\", ".
				"bo_coverpath=\"$bo_coverpath\" ".
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
