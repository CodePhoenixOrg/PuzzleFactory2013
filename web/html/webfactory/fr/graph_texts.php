<center>
<?php   
	include("graph_texts_code.php");
	if($query=="SELECT") {
			$sql="select gt_id, gt_name from graph_texts order by gt_id";
			$dbgrid=create_pager_db_grid("graph_texts", $sql, $id, "page.php", "&query=ACTION$curl_pager", "", true, true, $dialog, array(0, 400), 15, $grid_colors, $cs);
			//$dbgrid=table_shadow("graph_texts", $dbgrid);
			echo "<br>".$dbgrid;
	} elseif($query=="ACTION") {
?>
<form method='POST' name='graph_textsForm' action='page.php?id=34&lg=fr'>
	<input type='hidden' name='query' value='ACTION'>
	<input type='hidden' name='event' value='onRun'>
	<input type='hidden' name='pc' value='<?php echo $pc?>'>
	<input type='hidden' name='sr' value='<?php echo $sr?>'>
	<input type='hidden' name='gt_id' value='<?php echo $gt_id?>'>
	<table border='1' bordercolor='<?php echo $panel_colors["border_color"]?>' cellpadding='0' cellspacing='0' witdh='100%' height='1'>
		<tr>
			<td align='center' valign='top' bgcolor='<?php echo $panel_colors["back_color"]?>'>
				<table>
				<tr>
					<td>gt_id</td>
					<td>
						<?php echo $gt_id?>
					</td>
				</tr>
					<td>gt_name</td>
					<td>
						<input type='text' name='gt_name' size='45' value='<?php echo $gt_name?>'>
					</td>
				</tr>
					<td>gt_text</td>
					<td>
						<input type='text' name='gt_text' size='80' value='<?php echo $gt_text?>'>
					</td>
				</tr>
				<tr>
					<td>si_id</td>
					<td>
						<select name='si_id'>
						<?php   $sql='select si_id, si_server_name from sites order by si_server_name';
						$options=create_options_from_query($sql, 0, 1, array(), $si_id, false, $cs);
						echo $options["list"];?>
						</select>
					</td>
				</tr>
					<tr>
						<td align='center' colspan='2'>
							<input type='submit' name='action' value='<?php echo $action?>'>
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
