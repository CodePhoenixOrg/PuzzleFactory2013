<center>
<?php 
	include_once("puzzle/ipz_mysqlconn.php");
	include_once("puzzle/ipz_db_controls.php");
	$cs=connection(CONNECT,$database);
	if(empty($query)) $query="SELECT";
	if(empty($event)) $event="onLoad";
	if(empty($action)) $action="Ajouter";
	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(di_id) from dictionary;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$di_id=$rows[0]+1;
			$di_fr_short="";
			$di_fr_long="";
			$di_en_short="";
			$di_en_long="";
			$di_ru_short="";
			$di_ru_long="";
		break;
		case "Modifier":
			$sql="select * from dictionary where di_id='$di_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$di_id=$rows["di_id"];
			$di_fr_short=$rows["di_fr_short"];
			$di_fr_long=$rows["di_fr_long"];
			$di_en_short=$rows["di_en_short"];
			$di_en_long=$rows["di_en_long"];
			$di_ru_short=$rows["di_ru_short"];
			$di_ru_long=$rows["di_ru_long"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":
			$sql="insert into dictionary (".
				"di_id, ".
				"di_fr_short, ".
				"di_fr_long, ".
				"di_en_short, ".
				"di_en_long, ".
				"di_ru_short, ".
				"di_ru_long".
			") values (".
				"'$di_id', ".
				"'$di_fr_short', ".
				"'$di_fr_long', ".
				"'$di_en_short', ".
				"'$di_en_long', ".
				"'$di_ru_short', ".
				"'$di_ru_long'".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$sql="update dictionary set ".
				"di_id='$di_id', ".
				"di_fr_short='$di_fr_short', ".
				"di_fr_long='$di_fr_long', ".
				"di_en_short='$di_en_short', ".
				"di_en_long='$di_en_long', ".
				"di_ru_short='$di_ru_short', ".
				"di_ru_long='$di_ru_long' ".
			"where di_id='$di_id'";
			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from dictionary where di_id='$di_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection("disconnect","puzzle");
		echo "<script language='JavaScript'>window.location.href='page.php?id=&lg=fr'</script>";
	}
if($query=="SELECT") {
		$sql="select di_id, di_fr_short from dictionary order by di_id";
		$dbgrid=create_pager_db_grid("dictionary", $sql, $id, "page.php", "&query=ACTION", "", true, true, $dialog, array(0, 400), 15, $grid_colors, $cs);
		//$dbgrid=table_shadow("dictionary", $dbgrid);
		echo "<br>".$dbgrid;
} elseif($query=="ACTION") {
?>
<form method='POST' name='dictionaryForm' action='page.php?id=&lg=fr'>
<input type='hidden' name='query' value='ACTION'>
<input type='hidden' name='event' value=''>
<input type='hidden' name='pc' value='<?php echo $pc?>'>
<input type='hidden' name='sr' value='<?php echo $sr?>'>
<input type='hidden' name='di_id' value='<?php echo $di_id?>'>
<table border='1' bordercolor='<?php echo $panel_colors["border_color"]?>' cellpadding='0' cellspacing='0' witdh='100%' height='1'><tr><td align='center' valign='top' bgcolor='<?php echo $panel_colors["back_color"]?>'><table><tr><td>di_id</td>
<td><?php echo $di_id?></td></tr>
<tr><td>di_fr_short</td>
<td><input type='text' name='di_fr_short' value='<?php echo $di_fr_short?>'></td></tr>
<tr><td>di_fr_long</td>
<td><textarea name='di_fr_long' cols='80' rows='5'><?php echo $di_fr_long?></textarea></td></tr>
<tr><td>di_en_short</td>
<td><input type='text' name='di_en_short' value='<?php echo $di_en_short?>'></td></tr>
<tr><td>di_en_long</td>
<td><textarea name='di_en_long' cols='80' rows='5'><?php echo $di_en_long?></textarea></td></tr>
<tr><td>di_ru_short</td>
<td><input type='text' name='di_ru_short' value='<?php echo $di_ru_short?>'></td></tr>
<tr><td>di_ru_long</td>
<td><textarea name='di_ru_long' cols='80' rows='5'><?php echo $di_ru_long?></textarea></td></tr>

<tr><td align='center' colspan='2'>
<input type='submit' name='action' value='<?php echo $action?>'>
<?php 	if($action!="Ajouter") { ?>
<input type='submit' name='action' value='Supprimer'>
<?php 	} ?>
<input type='reset' name='action' value='Annuler'>
<input type='submit' name='action' value='Retour'>
</td></tr></table>
</td></tr></table>
</form>
<?php } ?>
</center>
