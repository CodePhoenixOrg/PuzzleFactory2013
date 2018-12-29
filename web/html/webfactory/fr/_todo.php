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

			$sql="select max(td_id) from todo;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$td_id=$rows[0]+1;
			$td_title="";
			$td_text="";
			$td_priority="";
			$td_expiry="";
			$td_status="";
			$td_date=get_sql_date();
			$td_time=get_short_time();
			$mbr_id="";
			$mbr_id2="";
		break;
		case "Modifier":
			$sql="select * from todo where td_id='$td_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$td_id=$rows["td_id"];
			$td_title=$rows["td_title"];
			$td_text=$rows["td_text"];
			$td_priority=$rows["td_priority"];
			$td_expiry=$rows["td_expiry"];
			$td_status=$rows["td_status"];
			$td_date=$rows["td_date"];
			$td_time=$rows["td_time"];
			$mbr_id=$rows["mbr_id"];
			$mbr_id2=$rows["mbr_id2"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		$td_date=get_sql_date();
		$td_time=get_sql_time();
		switch ($action) {
		case "Ajouter":
			$sql="insert into todo (".
				"td_id, ".
				"td_title, ".
				"td_text, ".
				"td_priority, ".
				"td_expiry, ".
				"td_status, ".
				"td_date, ".
				"td_time, ".
				"mbr_id, ".
				"mbr_id2".
			") values (".
				"'$td_id', ".
				"'$td_title', ".
				"'$td_text', ".
				"'$td_priority', ".
				"'$td_expiry', ".
				"'$td_status', ".
				"'$td_date', ".
				"'$td_time', ".
				"'$mbr_id', ".
				"'$mbr_id'".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$sql="update todo set ".
				"td_id='$td_id', ".
				"td_title='$td_title', ".
				"td_text='$td_text', ".
				"td_priority='$td_priority', ".
				"td_expiry='$td_expiry', ".
				"td_status='$td_status', ".
				"td_date='$td_date', ".
				"td_time='$td_time', ".
				"mbr_id='$mbr_id', ".
				"mbr_id2='$mbr_id2' ".
			"where td_id='$td_id'";
			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from todo where td_id='$td_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection("disconnect","webfactory");
		echo "<script language='JavaScript'>window.location.href='page.php?id=18&lg=fr'</script>";
	}
if($query=="SELECT") {
		$sql="select td.td_id, concat('<b>', td.td_title, '</b><br>', td.td_text, '<br>') as `tâches`, mb.mbr_ident as 'r&eacute;al.', td.td_status as '&eacute;tat', td.td_priority as 'priorité', td.td_expiry as '&eacute;ch&eacute;ance' from todo as td, members as mb where td.mbr_id2=mb.mbr_id order by td.td_status, td.td_expiry, td.td_priority desc";
		$dbgrid=create_pager_db_grid("tâches", $sql, $id, "page.php", "&query=ACTION", "", false, true, $dialog, array(0, 450), 15, $grid_colors, $cs);
		//$dbgrid=table_shadow("todo", $dbgrid);
		echo "<br>".$dbgrid."<br>";
} elseif($query=="ACTION") {
	$priority=array(1,2,3);
	if(empty($td_priority)) $td_priority=1;
	$status=array("à faire", "en cours","fait");
	if(empty($td_status)) $td_status="à faire";
?>
<form method='POST' name='todoForm' action='page.php?id=18&lg=fr'>
<input type='hidden' name='query' value='ACTION'>
<input type='hidden' name='event' value=''>
<input type='hidden' name='td_id' value='<?php   echo $td_id?>'>
<table witdh='100%' height='100%'><tr><td align='center' valign='top'><table>
<tr><td>Tâche n°</td>
<td><?php   echo $td_id?></td></tr>
<tr><td>Date</td>
<td><?php   echo date_mysqli_to_french($td_date)." ".$td_time ?></td></tr>
<tr><td>Demandée par</td>
<td><select name='mbr_id'>
<?php   $options=options_concat("mbr_id", " | ", "mbr_nom", "mbr_id", "members", "", "mbr_id", $mbr_id, false);
echo $options;?></select></td></tr>
<tr><td>Réalisée par</td>
<td><select name='mbr_id2'>
<?php   $options=options_concat("mbr_id", " | ", "mbr_nom", "mbr_id", "members", "", "mbr_id", $mbr_id2, false);
echo $options;?></select></td></tr>
<tr><td>Intitulé</td>
<td><input type='text' name='td_title' value='<?php   echo $td_title?>' size='80'></td></tr>
<tr><td>Description *</td>
<td><textarea name='td_text' cols='80' rows='5'><?php   echo $td_text?></textarea><br>
* Les tags HTML peuvent être utilisés pour formater le texte.</td></tr>
<tr><td>Priorité</td>
<td>
<select name='td_priority'>
	<?php   
		echo "<option selected value='$td_priority'>$td_priority</option>";
		foreach($priority as $level) {
			if($level<>$td_priority) echo "<option value='$level'>$level</option>";
		}
	?>
</select>&nbsp;&nbsp;Plus le chiffre est grand, plus la priorité est haute.
</td></tr>
<tr><td>Echéance *</td>
<td><input type='text' name='td_expiry' value='<?php   echo $td_expiry?>'><br>
* Date au format AAAA-MM-JJ.
</td></tr>
<tr><td>Etat</td>
<td>
<select name='td_status'>
	<?php   
		echo "<option selected value='$td_status'>$td_status</option>";
		foreach($status as $astatus) {
			if($astatus<>$td_status) echo "<option value='$astatus'>$astatus</option>";
		}
	?>
</select>
</td></tr>
<tr><td align='center' colspan='2'><input type='submit' name='action' value='<?php   echo $action?>' onClick='return runForm("todoForm");'>
<?php   	if($action!="Ajouter") { ?>
<input type='submit' name='action' value='Supprimer' onClick='return runForm("todoForm");'>
<?php   	} ?>
<input type='reset' name='action' value='Annuler'>
<input type=button value="Retour" onClick="history.go(-1);">
</td></tr></table>
</td></tr></table>
</form>
<?php   } ?>
</center>
