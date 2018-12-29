<center>
<?php   
	include("zipcode_code.php");
	$pc = get_variable("pc");
	$sr = get_variable("sr");
	$curl_pager = "";
	$dialog = "";
	if(isset($pc)) $curl_pager="&pc=$pc";
	if(isset($sr)) $curl_pager.="&sr=$sr";
	if($query=="SELECT") {
			$sql="select zc_id, zc_code from pz_zip_code order by zc_id";
			$dbgrid=create_pager_db_grid("pz_zip_code", $sql, $id, "page.php", "&query=ACTION$curl_pager", "", true, true, $dialog, array(0, 400), 15, $grid_colors, $cs);
			//$dbgrid=table_shadow("pz_zip_code", $dbgrid);
			echo "<br>".$dbgrid;
	} elseif($query=="ACTION") {
?>
<form method='POST' name='pz_zip_codeForm' action='page.php?id=0&lg=fr'>
	<input type='hidden' name='query' value='ACTION'>
	<input type='hidden' name='event' value='onRun'>
	<input type='hidden' name='pc' value='<?php echo $pc?>'>
	<input type='hidden' name='sr' value='<?php echo $sr?>'>
	<input type='hidden' name='zc_id' value='<?php echo $zc_id?>'>
	<table border='1' bordercolor='<?php echo $panel_colors["border_color"]?>' cellpadding='0' cellspacing='0' witdh='100%' height='1'>
		<tr>
			<td align='center' valign='top' bgcolor='<?php echo $panel_colors["back_color"]?>'>
				<table>
				<tr>
					<td>zc_id</td>
					<td>
						<?php echo $zc_id?>
					</td>
				</tr>
					<td>zc_code</td>
					<td>
						<input type='text' name='zc_code' size='15' value='<?php echo $zc_code?>'>
					</td>
				</tr>
				<tr>
					<td>zc_city</td>
					<td>
						<textarea name='zc_city' cols='80' rows='2'><?php echo $zc_city?></textarea>
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
