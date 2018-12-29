<center>
<?php   
	include("forums_code.php");
	$pc = get_variable("pc");
	$sr = get_variable("sr");
	$curl_pager = "";
	$dialog = "";
	if(isset($pc)) $curl_pager="&pc=$pc";
	if(isset($sr)) $curl_pager.="&sr=$sr";
	if($query=="SELECT") {
			$sql="select fr_id, fr_title from forums order by fr_id";
			$dbgrid=create_pager_db_grid("forums", $sql, $id, "page.php", "&query=ACTION$curl_pager", "", true, true, $dialog, array(0, 400), 15, $grid_colors, $cs);
			//$dbgrid=table_shadow("forums", $dbgrid);
			echo "<br>".$dbgrid;
	} elseif($query=="ACTION") {
?>
<form method='POST' name='forumsForm' action='page.php?id=23&lg=fr'>
	<input type='hidden' name='query' value='ACTION'>
	<input type='hidden' name='event' value='onRun'>
	<input type='hidden' name='pc' value='<?php echo $pc?>'>
	<input type='hidden' name='sr' value='<?php echo $sr?>'>
	<input type='hidden' name='fr_id' value='<?php echo $fr_id?>'>
	<table border='1' bordercolor='<?php echo $panel_colors["border_color"]?>' cellpadding='0' cellspacing='0' witdh='100%' height='1'>
		<tr>
			<td align='center' valign='top' bgcolor='<?php echo $panel_colors["back_color"]?>'>
				<table>
				<tr>
					<td>fr_id</td>
					<td>
						<?php echo $fr_id?>
					</td>
				</tr>
					<td>fr_title</td>
					<td>
						<input type='text' name='fr_title' size='80' value='<?php echo $fr_title?>'>
					</td>
				</tr>
					<td>fr_description</td>
					<td>
						<input type='text' name='fr_description' size='80' value='<?php echo $fr_description?>'>
					</td>
				</tr>
					<td>fr_date</td>
					<td>
						<input type='text' name='fr_date' size='19' value='<?php echo $fr_date?>'>
					</td>
				</tr>
					<td>fr_table_name</td>
					<td>
						<input type='text' name='fr_table_name' size='80' value='<?php echo $fr_table_name?>'>
					</td>
				</tr>
				<tr>
					<td>me_id</td>
					<td>
						<select name='me_id'>
						<?php   $sql='select me_id, me_level from menus order by me_level';
						$options=create_options_from_query($sql, 0, 1, [], $me_id, false, $cs);
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
