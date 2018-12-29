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

			$sql="select max(br_id) from bugreport;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$br_id=$rows[0]+1;
			$br_title="";
			$br_text="";
			$br_importance="";
			$br_status="";
			$br_date=get_sql_date();
			$br_time=get_short_time();
			$mbr_id="";
		break;
		case "Modifier":
			$sql="select * from bugreport where br_id='$br_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$br_id=$rows["br_id"];
			$br_title=$rows["br_title"];
			$br_text=$rows["br_text"];
			$br_importance=$rows["br_importance"];
			$br_status=$rows["br_status"];
			$br_date=$rows["br_date"];
			$br_time=$rows["br_time"];
			$mbr_id=$rows["mbr_id"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		$br_date=get_sql_date();
		$br_time=get_sql_time();
		switch ($action) {
		case "Ajouter":
			$sql="insert into bugreport (".
				"br_id, ".
				"br_title, ".
				"br_text, ".
				"br_importance, ".
				"br_status, ".
				"br_date, ".
				"br_time, ".
				"mbr_id".
			") values (".
				"'$br_id', ".
				"'$br_title', ".
				"'$br_text', ".
				"'$br_importance', ".
				"'$br_status', ".
				"'$br_date', ".
				"'$br_time', ".
				"'$mbr_id'".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$sql="update bugreport set ".
				"br_id='$br_id', ".
				"br_title='$br_title', ".
				"br_text='$br_text', ".
				"br_importance='$br_importance', ".
				"br_status='$br_status', ".
				"br_date='$br_date', ".
				"br_time='$br_time', ".
				"mbr_id='$mbr_id' ".
			"where br_id='$br_id'";
			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from bugreport where br_id='$br_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection("disconnect","webfactory");
		echo "<script language='JavaScript'>window.location.href='page.php?id=19&lg=fr'</script>";
	}
if($query=="SELECT") {
		$sql="select br_id, concat('<b>', br_title, '</b><br>', br_text, '<br>') as `bugs trouvés`, br_importance as 'importance', br_status as 'etat' from bugreport order by br_status, br_importance desc";
		$dbgrid=create_pager_db_grid("bugreport", $sql, $id, "page.php", "&query=ACTION", "", false, true, $dialog, array(0, 400), 15, $grid_colors, $cs);
		//$dbgrid=table_shadow("bugreport", $dbgrid);
		echo "<br>".$dbgrid;
} elseif($query=="ACTION") {
	$importance=array(1,2,3);
	if(empty($br_importance)) $br_importance=1;
	$status=array("à fixer", "en test","fixé");
	if(empty($br_status)) $br_status="à fixer";
?>
<form method='POST' name='bugreportForm' action='page.php?id=19&lg=fr'>
<input type='hidden' name='query' value='ACTION'>
<input type='hidden' name='event' value=''>
<input type='hidden' name='br_id' value='<?php   echo $br_id?>'>
<table witdh='100%' height='100%'><tr><td align='center' valign='top'><table>
<tr><td>Bug n°</td>
<td><?php   echo $br_id?></td></tr>
<tr><td>Date</td>
<td><?php   echo date_mysqli_to_french($br_date)." ".$br_time ?></td></tr>
<tr><td>Rapporté par</td>
<td><select name='mbr_id'>
<?php   $options=options_concat("mbr_id", " | ", "mbr_nom", "mbr_id", "members", "", "mbr_id", $mbr_id, false);
echo $options;?></select></td></tr>
<tr><td>Intitulé</td>
<td><input type='text' name='br_title' value='<?php   echo $br_title?>' size='80'></td></tr>
<tr><td>Description*</td>
<td><textarea name='br_text' cols='80' rows='5'><?php   echo $br_text?></textarea><br>
* Les tags HTML peuvent être utilisés pour formater le texte.</td></tr>
<tr><td>Importance</td>
<td>
<select name='br_importance'>
	<?php   
		echo "<option selected value='$br_importance'>$br_importance</option>";
		foreach($importance as $level) {
			if($level<>$br_importance) echo "<option value='$level'>$level</option>";
		}
	?>
</select>&nbsp;&nbsp;Plus le chiffre est grand, plus le bug est important.
</td></tr>
<tr><td>Etat</td>
<td>
<select name='br_status'>
	<?php   
		echo "<option selected value='$br_status'>$br_status</option>";
		foreach($status as $astatus) {
			if($astatus<>$br_status) echo "<option value='$astatus'>$astatus</option>";
		}
	?>
</select>
</td></tr>
<tr><td align='center' colspan='2'><input type='submit' name='action' value='<?php   echo $action?>' onClick='return runForm("bugreportForm");'>
<?php   	if($action!="Ajouter") { ?>
<input type='submit' name='action' value='Supprimer' onClick='return runForm("bugreportForm");'>
<?php   	} ?>
<input type='reset' name='action' value='Annuler'>
<input type=button value="Retour" onClick="history.go(-1);">
</td></tr></table>
</td></tr></table>
</form>
<?php   } ?>
</center>
