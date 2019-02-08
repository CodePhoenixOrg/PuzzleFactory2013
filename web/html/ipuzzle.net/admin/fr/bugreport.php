<center>
<?php   
	include("bugreport_code.php");
	use \Puzzle\Data\Controls as DataControls;
	$datacontrols = new DataControls($lg, $db_prefix);
	$pc = getArgument("pc");
	$sr = getArgument("sr");
	$curl_pager = "";
	$dialog = "";
	if(isset($pc)) $curl_pager="&pc=$pc";
	if(isset($sr)) $curl_pager.="&sr=$sr";
	if($query === "SELECT") {
			$sql = "select br_id, br_title from $tablename order by br_id";
			$dbgrid = $datacontrols->createPagerDbGrid($tablename, $sql, $id, "page.php", "&query=ACTION$curl_pager", "", true, true, $dialog, array(0, 400), 15, $grid_colors, $cs);
			//$dbgrid = tableShadow($tablename, $dbgrid);
			echo "<br>".$dbgrid;
	} elseif($query === "ACTION") {
?>
<form method="POST" name="pz_bugreportForm" action="page.php?id=220&lg=fr">
	<input type="hidden" name="query" value="ACTION">
	<input type="hidden" name="event" value="onRun">
	<input type="hidden" name="pc" value="<?php echo $pc?>">
	<input type="hidden" name="sr" value="<?php echo $sr?>">
	<input type="hidden" name="br_id" value="<?php echo $br_id?>">
	<table border="1" bordercolor="<?php echo $panel_colors["border_color"]?>" cellpadding="0" cellspacing="0" witdh="100%" height="1">
		<tr>
			<td align="center" valign="top" bgcolor="<?php echo $panel_colors["back_color"]?>">
				<table>
				<tr>
					<td>br_id</td>
					<td>
						<?php echo $br_id?>
					</td>
				</tr>
				<tr>
					<td>br_title</td>
					<td>
						<textarea name="br_title" cols="80" rows="4"><?php echo $br_title?></textarea>
					</td>
				</tr>
				<tr>
					<td>br_text</td>
					<td>
						<textarea name="br_text" cols="80" rows="8"><?php echo $br_text?></textarea>
					</td>
				</tr>
					<td>br_importance</td>
					<td>
						<input type="text" name="br_importance" size="11" value="<?php echo $br_importance?>">
					</td>
				</tr>
					<td>br_status</td>
					<td>
						<input type="text" name="br_status" size="8" value="<?php echo $br_status?>">
					</td>
				</tr>
				<tr>
					<td>br_date</td>
					<td>
						<input type="text" name="br_date" size="19" value="<?php echo (empty($br_date)) ? date("1970-01-01") : $br_date; ?>" >
					</td>
				</tr>
				<tr>
				<tr>
					<td>br_time</td>
					<td>
						<input type="text" name="br_time" size="19" value="<?php echo (empty($br_time)) ? date("1970-01-01") : $br_time; ?>" >
					</td>
				</tr>
				<tr>
				<tr>
					<td>mbr_id</td>
					<td>
						<select name="mbr_id">
						<?php   $sql="select mbr_id, mbr_nom from pz_members order by mbr_nom";
						$options = $datacontrols->createOptionsFromQuery($sql, 0, 1, [], $mbr_id, false, $cs);
						echo $options["list"];?>
						</select>
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
