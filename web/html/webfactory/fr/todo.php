<center>
<?php   
	include_once 'todo_code.php';
	$td_expiry = date('Y-m-d H:i:s');
	$td_expiry = date('Y-m-d H:i:s', strtotime($td_expiry . '+31 day'));

	if($query=="SELECT") {
		//$sql="select td_id, td_title from todo order by td_id";
		$sql="select td.td_id, concat('<b>', td.td_title, '</b><br>', td.td_text, '<br>') as `tâches`, mb.mbr_ident as 'r&eacute;al.', td.td_status as '&eacute;tat', td.td_priority as 'priorité', td.td_expiry as '&eacute;ch&eacute;ance' from todo as td left outer join members as mb on td.mbr_id2=mb.mbr_id order by td.td_status, td.td_expiry, td.td_priority desc";
		$dbgrid=create_pager_db_grid("todo", $sql, $id, "page.php", "&query=ACTION$curl_pager", "", true, true, $dialog, array(0, 450), 15, $grid_colors, $cs);
		//$dbgrid=table_shadow("todo", $dbgrid);
		echo "<br>".$dbgrid;
	} elseif($query=="ACTION") {
		$priority=array(1,2,3);
		if(empty($td_priority)) $td_priority=1;
		$status=array("à faire", "en cours", "fait");
		if(empty($td_status)) $td_status="à faire";
?>
<form method='POST' name='todoForm' action='page.php?id=25&lg=fr'>
	<input type='hidden' name='query' value='ACTION'>
	<input type='hidden' name='event' value='onRun'>
	<input type='hidden' name='pc' value='<?php   echo $pc?>'>
	<input type='hidden' name='sr' value='<?php   echo $sr?>'>
	<input type='hidden' name='td_id' value='<?php   echo $td_id?>'>
	<table border='1' bordercolor='<?php   echo $panel_colors["border_color"]?>' cellpadding='0' cellspacing='0' witdh='100%' height='1'>
		<tr>
			<td align='center' valign='top' bgcolor='<?php   echo $panel_colors["back_color"]?>'>
				<table>
					<tr>
						<td>Tâche n°</td>
						<td>
							<?php   echo $td_id?>
						</td>
					</tr>
					<tr>
						<td>Date</td>
						<td>
							<input type='text' name='td_date' value='<?php   echo date('Y-m-d');?>' size='19' readonly>
						</td>
					</tr>
					<tr>
						<td>Demandée par</td>
						<td>
							<select name='mbr_id'>
							<?php   $sql='select mbr_id, mbr_nom from members order by mbr_nom';
							$options=create_options_from_query($sql, 0, 1, array(), $mbr_id, false, $cs);
							echo $options["list"];?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Réalisée par</td>
						<td>
							<select name='mbr_id2'>
							<?php   $sql='select mbr_id, mbr_nom from members order by mbr_nom';
							$options=create_options_from_query($sql, 0, 1, array(), $mbr_id2, false, $cs);
							echo $options["list"];?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Intitulé</td>
						<td>
							<input type='text' name='td_title' value='<?php   echo $td_title?>'>
						</td>
					</tr>
					<tr>
						<td>Description</td>
						<td>
							<textarea name='td_text' cols='80' rows='5'><?php   echo $td_text?></textarea><br>
							* Les tags HTML peuvent être utilisés pour formater le texte.
						</td>
					</tr>
					<tr>
						<td>Priorité</td>
						<td>
							<select name='td_priority'>
							<?php   
								echo "<option selected value='$td_priority'>$td_priority</option>";
								foreach($priority as $level) {
									if($level<>$td_priority) echo "<option value='$level'>$level</option>";
								}
							?>
							</select>&nbsp;&nbsp;Plus le chiffre est grand, plus la priorité est haute.
						</td>
					</tr>
					<tr>
						<td>Echéance *</td>
						<td>
							<input type='text' name='td_expiry' value='<?php   echo $td_expiry?>'><br>
							* Date au format AAAA-MM-JJ.
						</td>
					</tr>
					<tr>
						<td>Etat</td>
						<td>
							<select name='td_status'>
							<?php   
								echo "<option selected value='$td_status'>$td_status</option>";
								foreach($status as $astatus) {
									if($astatus<>$td_status) echo "<option value='$astatus'>$astatus</option>";
								}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td align='center' colspan='2'>
							<input type='submit' name='action' value='<?php   echo $action?>'>
							<?php   if($action!="Ajouter") { ?>
								<input type='submit' name='action' value='Supprimer'>
							<?php   } ?>
							<input type='reset' name='action' value='Annuler'>
							<input type='submit' name='action' value='Retour'>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
<?php   	} ?>
</center>
