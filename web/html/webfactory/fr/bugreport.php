<center>
<?php   
	include_once 'bugreport_code.php';
	if($query=="SELECT") {
		//$sql="select br_id, br_title from bugreport order by br_id";
		$sql="select br_id, concat('<b>', br_title, '</b><br>', br_text, '<br>') as `bugs trouvés`, br_importance as 'importance', br_status as 'etat' from bugreport order by br_status, br_importance desc";
		$dbgrid=create_pager_db_grid("bugreport", $sql, $id, "page.php", "&query=ACTION$curl_pager", "", true, true, $dialog, array(0, 400), 15, $grid_colors, $cs);
		//$dbgrid=table_shadow("bugreport", $dbgrid);
		echo "<br>".$dbgrid;
	} elseif($query=="ACTION") {
		$importance=array(1,2,3);
		if(empty($br_importance)) $br_importance=1;
		$status=array("à fixer", "en test","fixé");
		if(empty($br_status)) $br_status="à fixer";
?>
<form method='POST' name='bugreportForm' action='page.php?id=26&lg=fr'>
	<input type='hidden' name='query' value='ACTION'>
	<input type='hidden' name='event' value='onRun'>
	<input type='hidden' name='pc' value='<?php   echo $pc?>'>
	<input type='hidden' name='sr' value='<?php   echo $sr?>'>
	<input type='hidden' name='br_id' value='<?php   echo $br_id?>'>
	<table border='1' bordercolor='<?php   echo $panel_colors["border_color"]?>' cellpadding='0' cellspacing='0' witdh='100%' height='1'>
		<tr>
			<td align='center' valign='top' bgcolor='<?php   echo $panel_colors["back_color"]?>'>
				<table>
					<tr>
						<td>Bug n°</td>
						<td>
							<?php   echo $br_id?>
						</td>
					</tr>
					<tr>
						<td>Date</td>
						<td>
							<input type='text' name='br_date' value='<?php   echo date('d/m/Y');?>' size='19' readonly>
						</td>
					</tr>
					<tr>
						<td>Rapporté par</td>
						<td>
							<select name='mbr_id'>
							<?php   $sql='select mbr_id, mbr_nom from members order by mbr_nom';
							$options=create_options_from_query($sql, 0, 1, array(), $mbr_id, false, $cs);
							echo $options["list"];?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Intitulé</td>
						<td>
							<input type='text' name='br_title' value='<?php   echo $br_title?>'>
						</td>
					</tr>
					<tr>
						<td>Description</td>
						<td>
							<textarea name='br_text' cols='80' rows='5'><?php   echo $br_text?></textarea><br>
							* Les tags HTML peuvent être utilisés pour formater le texte.
						</td>
					</tr>
					<tr>
						<td>Importance</td>
						<td>
							<select name='br_importance'>
							<?php   
								echo "<option selected value='$br_importance'>$br_importance</option>";
								foreach($importance as $level) {
									if($level<>$br_importance) echo "<option value='$level'>$level</option>";
								}
							?>
							</select>
							&nbsp;&nbsp;Plus le chiffre est grand, plus le bug est important.
						</td>
					</tr>
					<tr>
						<td>Etat</td>
						<td>
							<select name='br_status'>
							<?php   
								echo "<option selected value='$br_status'>$br_status</option>";
								foreach($status as $astatus) {
									if($astatus!=$br_status) echo "<option value='$astatus'>$astatus</option>";
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
