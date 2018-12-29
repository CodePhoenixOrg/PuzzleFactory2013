<center>
<script language="JavaScript" src="js/pz_form_events.js"></script>
<?php    
	include_once 'puzzle/ipz_mysqlconn.php';
	include_once 'puzzle/ipz_db_controls.php';
	$cs=connection("connect","webfactory");
	if(empty($query)) $query="SELECT";
	if(empty($event)) $event="onLoad";
	if(empty($action)) $action="Ajouter";
	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(nl_id) from newsletter;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$nl_id=$rows[0]+1;
			$nl_title="";
			$nl_author="";
			$nl_header="";
			$nl_image="";
			$nl_comment="";
			$nl_body="";
			$nl_links="";
			$nl_footer="";
			$nl_file="";
			$nl_date="";
		break;
		case "Modifier":
			$sql="select * from newsletter where nl_id='$nl_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$nl_id=$rows["nl_id"];
			$nl_title=$rows["nl_title"];
			$nl_author=$rows["nl_author"];
			$nl_header=$rows["nl_header"];
			$nl_image=$rows["nl_image"];
			$nl_comment=$rows["nl_comment"];
			$nl_body=$rows["nl_body"];
			$nl_links=$rows["nl_links"];
			$nl_footer=$rows["nl_footer"];
			$nl_file=$rows["nl_file"];
			$nl_date=$rows["nl_date"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":
			$sql="insert into newsletter (".
				"nl_id, ".
				"nl_title, ".
				"nl_author, ".
				"nl_header, ".
				"nl_image, ".
				"nl_comment, ".
				"nl_body, ".
				"nl_links, ".
				"nl_footer, ".
				"nl_file, ".
				"nl_date".
			") values (".
				"'$nl_id', ".
				"'$nl_title', ".
				"'$nl_author', ".
				"'$nl_header', ".
				"'$nl_image', ".
				"'$nl_comment', ".
				"'$nl_body', ".
				"'$nl_links', ".
				"'$nl_footer', ".
				"'$nl_file', ".
				"'$nl_date'".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$sql="update newsletter set ".
				"nl_id='$nl_id', ".
				"nl_title='$nl_title', ".
				"nl_author='$nl_author', ".
				"nl_header='$nl_header', ".
				"nl_image='$nl_image', ".
				"nl_comment='$nl_comment', ".
				"nl_body='$nl_body', ".
				"nl_links='$nl_links', ".
				"nl_footer='$nl_footer', ".
				"nl_file='$nl_file', ".
				"nl_date='$nl_date' ".
			"where nl_id='$nl_id'";
			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from newsletter where nl_id='$nl_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection("disconnect","webfactory");
		echo "<script language='JavaScript'>window.location.href='page.php?id=20&lg=fr'</script>";
	}
if($query=="SELECT") {
		$sql="select nl_id, nl_title from newsletter order by nl_id";
		$dbgrid=create_pager_db_grid("newsletter", $sql, $id, "page.php", "&query=ACTION", "", "nl_title", true, $dialog, array(0, 400), 15, $grid_colors, $cs);
		$dbgrid=table_shadow("newsletter", $dbgrid);
		echo "<br>".$dbgrid;
} elseif($query=="ACTION") {
?>
<form method='POST' name='newsletterForm' action='page.php?id=20&lg=fr'>
<input type='hidden' name='query' value='ACTION'>
<input type='hidden' name='event' value=''>
<input type='hidden' name='nl_id' value='<?php    echo $nl_id?>'>
<table witdh='100%' height='100%'><tr><td align='center' valign='middle'><table><tr><td>nl_id</td>
<td><?php    echo $nl_id?></td></tr>
<tr><td>nl_title</td>
<td><input type='text' name='nl_title' value='<?php    echo $nl_title?>'></td></tr>
<tr><td>nl_author</td>
<td><input type='text' name='nl_author' value='<?php    echo $nl_author?>'></td></tr>
<tr><td>nl_header</td>
<td><input type='text' name='nl_header' value='<?php    echo $nl_header?>'></td></tr>
<tr><td>nl_image</td>
<td><input type='text' name='nl_image' value='<?php    echo $nl_image?>'></td></tr>
<tr><td>nl_comment</td>
<td><input type='text' name='nl_comment' value='<?php    echo $nl_comment?>'></td></tr>
<tr><td>nl_body</td>
<td><input type='text' name='nl_body' value='<?php    echo $nl_body?>'></td></tr>
<tr><td>nl_links</td>
<td><input type='text' name='nl_links' value='<?php    echo $nl_links?>'></td></tr>
<tr><td>nl_footer</td>
<td><input type='text' name='nl_footer' value='<?php    echo $nl_footer?>'></td></tr>
<tr><td>nl_file</td>
<td><input type='text' name='nl_file' value='<?php    echo $nl_file?>'></td></tr>
<tr><td>nl_date</td>
<td><input type='text' name='nl_date' value='<?php    echo $nl_date?>'></td></tr>

<tr><td align='center' colspan='2'><input type='submit' name='action' value='<?php    echo $action?>' onClick='return runForm("newsletterForm");'>
<?php    	if($action!="Ajouter") { ?>
<input type='submit' name='action' value='Supprimer' onClick='return runForm("newsletterForm");'>
<?php    	} ?>
<input type='reset' name='action' value='Annuler'>
<input type=button value="Retour" onClick="history.go(-1);">
</td></tr></table>
</td></tr></table>
</form>
<?php    } ?>
</center>
