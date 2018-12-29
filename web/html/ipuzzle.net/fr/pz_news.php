<center>
<?php   
	include("pz_news_code.php");
	if($query=="SELECT") {
			$sql="select nw_id, nw_title from pz_news order by nw_id";
			$dbgrid=create_pager_db_grid("pz_news", $sql, $id, "page.php", "&query=ACTION$curl_pager", "", true, true, $dialog, array(0, 400), 15, $grid_colors, $cs);
			//$dbgrid=table_shadow("pz_news", $dbgrid);
			echo "<br>".$dbgrid;
	} elseif($query=="ACTION") {
?>
<form method='POST' name='pz_newsForm' action='page.php?id=&lg=fr'>
	<input type='hidden' name='query' value='ACTION'>
	<input type='hidden' name='event' value='onRun'>
	<input type='hidden' name='pc' value='<?php echo $pc?>'>
	<input type='hidden' name='sr' value='<?php echo $sr?>'>
	<input type='hidden' name='nw_id' value='<?php echo $nw_id?>'>
	<table border='1' bordercolor='<?php echo $panel_colors["border_color"]?>' cellpadding='0' cellspacing='0' witdh='100%' height='1'>
		<tr>
			<td align='center' valign='top' bgcolor='<?php echo $panel_colors["back_color"]?>'>
				<table>
				<tr>
					<td>nw_id</td>
					<td>
						<?php echo $nw_id?>
					</td>
				</tr>
				<tr>
					<td>nw_title</td>
					<td>
						<textarea name='nw_title' cols='80' rows='4'><?php echo $nw_title?></textarea>
					</td>
				</tr>
				<tr>
					<td>nw_author</td>
					<td>
						<textarea name='nw_author' cols='80' rows='4'><?php echo $nw_author?></textarea>
					</td>
				</tr>
				<tr>
					<td>nw_text</td>
					<td>
						<textarea name='nw_text' cols='80' rows='8'><?php echo $nw_text?></textarea>
					</td>
				</tr>
				<tr>
					<td>nw_url</td>
					<td>
						<textarea name='nw_url' cols='80' rows='4'><?php echo $nw_url?></textarea>
					</td>
				</tr>
				<tr>
					<td>nw_picture</td>
					<td>
						<textarea name='nw_picture' cols='80' rows='4'><?php echo $nw_picture?></textarea>
					</td>
				</tr>
				<tr>
					<td>nw_time</td>
					<td>
						<input type='text' name='nw_time' size='10' value='<?php echo (empty($nw_time)) ? date('1970-01-01') : $nw_time; ?>' >
					</td>
				</tr>
				<tr>
				<tr>
					<td>nw_date</td>
					<td>
						<input type='text' name='nw_date' size='10' value='<?php echo (empty($nw_date)) ? date('1970-01-01') : $nw_date; ?>' >
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
