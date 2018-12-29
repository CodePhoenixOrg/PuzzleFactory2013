<center>
<?php   
	include("images_code.php");
	$pc = get_variable("pc");
	$sr = get_variable("sr");
	$curl_pager = "";
	$dialog = "";
	if(isset($pc)) $curl_pager="&pc=$pc";
	if(isset($sr)) $curl_pager.="&sr=$sr";
	if($query=="SELECT") {
			$sql="select im_id, im_name from images order by im_id";
			$dbgrid=create_pager_db_grid("images", $sql, $id, "page.php", "&query=ACTION$curl_pager", "", true, true, $dialog, array(0, 400), 15, $grid_colors, $cs);
			//$dbgrid=table_shadow("images", $dbgrid);
			echo "<br>".$dbgrid;
	} elseif($query=="ACTION") {
?>
<form method='POST' name='imagesForm' action='page.php?id=58&lg=fr'>
	<input type='hidden' name='query' value='ACTION'>
	<input type='hidden' name='event' value='onRun'>
	<input type='hidden' name='pc' value='<?php echo $pc?>'>
	<input type='hidden' name='sr' value='<?php echo $sr?>'>
	<input type='hidden' name='im_id' value='<?php echo $im_id?>'>
	<table border='1' bordercolor='<?php echo $panel_colors["border_color"]?>' cellpadding='0' cellspacing='0' witdh='100%' height='1'>
		<tr>
			<td align='center' valign='top' bgcolor='<?php echo $panel_colors["back_color"]?>'>
				<table>
				<tr>
					<td>im_id</td>
					<td>
						<?php echo $im_id?>
					</td>
				</tr>
					<td>im_name</td>
					<td>
						<input type='text' name='im_name' size='45' value='<?php echo $im_name?>'>
					</td>
				</tr>
					<td>im_dir</td>
					<td>
						<input type='text' name='im_dir' size='80' value='<?php echo $im_dir?>'>
					</td>
				</tr>
					<td>im_url</td>
					<td>
						<input type='text' name='im_url' size='80' value='<?php echo $im_url?>'>
					</td>
				</tr>
					<td>im_site</td>
					<td>
						<input type='text' name='im_site' size='11' value='<?php echo $im_site?>'>
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
