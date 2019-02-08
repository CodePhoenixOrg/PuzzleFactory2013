<center>
<?php   
	include("dictionary_code.php");
	use \Puzzle\Data\Controls as DataControls;
	$datacontrols = new DataControls($lg, $db_prefix);
	$pc = getArgument("pc");
	$sr = getArgument("sr");
	$curl_pager = "";
	$dialog = "";
	if(isset($pc)) $curl_pager="&pc=$pc";
	if(isset($sr)) $curl_pager.="&sr=$sr";
	if($query === "SELECT") {
		$sql=<<<SQL
		SELECT 
			di_id, di_name as 'Clé', di_fr_short as 'Libellé court', di_fr_long as 'Libellé long'
		FROM
			pz_dictionary
SQL;
		$dbgrid = $datacontrols->createPagerDbGrid("dictionary", $sql, $id, "page.php", "&query=ACTION$curl_pager", "", true, true, $dialog, [0, 70, 120, 250], 15, $grid_colors, $cs);
		//$dbgrid = tableShadow($tablename, $dbgrid);
		echo "<br>".$dbgrid;
	} elseif($query === "ACTION") {
?>
<form method="POST" name="pz_dictionaryForm" action="page.php?id=216&lg=fr">
	<input type="hidden" name="query" value="ACTION">
	<input type="hidden" name="event" value="onRun">
	<input type="hidden" name="pc" value="<?php echo $pc?>">
	<input type="hidden" name="sr" value="<?php echo $sr?>">
	<input type="hidden" name="di_id" value="<?php echo $di_id?>">
	<table border="1" bordercolor="<?php echo $panel_colors["border_color"]?>" cellpadding="0" cellspacing="0" witdh="100%" height="1">
		<tr>
			<td align="center" valign="top" bgcolor="<?php echo $panel_colors["back_color"]?>">
				<table>
				<tr>
					<td>di_id</td>
					<td>
						<?php echo $di_id?>
					</td>
				</tr>
					<td>di_name</td>
					<td>
						<input type="text" name="di_name" size="8" value="<?php echo $di_name?>">
					</td>
				</tr>
				<tr>
					<td>di_fr_short</td>
					<td>
						<textarea name="di_fr_short" cols="80" rows="4"><?php echo $di_fr_short?></textarea>
					</td>
				</tr>
				<tr>
					<td>di_fr_long</td>
					<td>
						<textarea name="di_fr_long" cols="80" rows="8"><?php echo $di_fr_long?></textarea>
					</td>
				</tr>
				<tr>
					<td>di_en_short</td>
					<td>
						<textarea name="di_en_short" cols="80" rows="4"><?php echo $di_en_short?></textarea>
					</td>
				</tr>
				<tr>
					<td>di_en_long</td>
					<td>
						<textarea name="di_en_long" cols="80" rows="8"><?php echo $di_en_long?></textarea>
					</td>
				</tr>
				<tr>
					<td>di_ru_short</td>
					<td>
						<textarea name="di_ru_short" cols="80" rows="4"><?php echo $di_ru_short?></textarea>
					</td>
				</tr>
				<tr>
					<td>di_ru_long</td>
					<td>
						<textarea name="di_ru_long" cols="80" rows="8"><?php echo $di_ru_long?></textarea>
					</td>
				</tr>
					<tr>
						<td align="center" colspan="2">
							<input type="submit" name="action" value="<?php echo $action?>">
							<?php   if($action!="Ajouter") { ?>
								<input type="submit" name="action" value="Supprimer">
							<?php   } ?>
							<input type="reset" name="action" value="Annuler">
							<input type="submit" name="action" value="Retour">
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
<?php   	} ?>
</center>
