<center>
<?php    
	include_once 'blocks_code.php';
	if($query=="SELECT") {
			$sql="select bl_id, bl_column from blocks order by bl_id";
			$dbgrid=create_pager_db_grid("blocks", $sql, $id, "page.php", "&query=ACTION$curl_pager", "", true, true, $dialog, array(0, 400), 15, $grid_colors, $cs);
			//$dbgrid=table_shadow("blocks", $dbgrid);
			echo "<br>".$dbgrid;
	} elseif($query=="ACTION") {
?>
<form method='POST' name='blocksForm' action='page.php?id=20&lg=fr'>
	<input type='hidden' name='query' value='ACTION'>
	<input type='hidden' name='event' value='onRun'>
	<input type='hidden' name='pc' value='<?php    echo $pc?>'>
	<input type='hidden' name='sr' value='<?php    echo $sr?>'>
	<input type='hidden' name='bl_id' value='<?php    echo $bl_id?>'>
	<table border='1' bordercolor='<?php    echo $panel_colors["border_color"]?>' cellpadding='0' cellspacing='0' witdh='100%' height='1'>
		<tr>
			<td align='center' valign='top' bgcolor='<?php    echo $panel_colors["back_color"]?>'>
				<table>
				<tr>
					<td>bl_id</td>
					<td>
						<?php    echo $bl_id?>
					</td>
				</tr>
				<tr>
					<td>bl_column</td>
					<td>
						<input type='text' name='bl_column' value='<?php    echo $bl_column?>'>
					</td>
				</tr>
				<tr>
					<td>bl_type</td>
					<td>
						<input type='text' name='bl_type' value='<?php    echo $bl_type?>'>
					</td>
				</tr>
				<tr>
					<td>di_name</td>
					<td>
						<select name='di_name'>
						<?php    $sql='select di_name, di_fr_short from dictionary order by di_fr_short';
						$options=create_options_from_query($sql, 0, 1, array(), $di_name, false, $cs);
						echo $options["list"];?>
						</select>
					</td>
				</tr>
					<tr>
						<td align='center' colspan='2'>
							<input type='submit' name='action' value='<?php    echo $action?>'>
							<?php    if($action!="Ajouter") { ?>
								<input type='submit' name='action' value='Supprimer'>
							<?php    } ?>
							<input type='reset' name='action' value='Annuler'>
							<input type='submit' name='action' value='Retour'>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
<?php    	} ?>
</center>
