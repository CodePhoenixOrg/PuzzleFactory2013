<center>
<?php   
	include("pz_books_code.php");
	use \Puzzle\Data\Controls as DataControls;
	$datacontrols = new DataControls($lg, $db_prefix);
	$pc = getArgument("pc");
	$sr = getArgument("sr");
	$curl_pager = "";
	$dialog = "";
	if(isset($pc)) $curl_pager="&pc=$pc";
	if(isset($sr)) $curl_pager.="&sr=$sr";
	if($query === "SELECT") {
			$sql = "select bo_id, bo_title from pz_books order by bo_id";
			$dbgrid = $datacontrols->createPagerDbGrid("pz_books", $sql, $id, "page.php", "&query=ACTION$curl_pager", "", true, true, $dialog, array(0, 400), 15, $grid_colors, $cs);
			//$dbgrid = tableShadow("pz_books", $dbgrid);
			echo "<br>".$dbgrid;
	} elseif($query === "ACTION") {
?>
<form method="POST" name="pz_booksForm" action="page.php?id=227&lg=fr">
	<input type="hidden" name="query" value="ACTION">
	<input type="hidden" name="event" value="onRun">
	<input type="hidden" name="pc" value="<?php echo $pc?>">
	<input type="hidden" name="sr" value="<?php echo $sr?>">
	<input type="hidden" name="bo_id" value="<?php echo $bo_id?>">
	<table border="1" bordercolor="<?php echo $panel_colors["border_color"]?>" cellpadding="0" cellspacing="0" witdh="100%" height="1">
		<tr>
			<td align="center" valign="top" bgcolor="<?php echo $panel_colors["back_color"]?>">
				<table>
				<tr>
					<td>bo_id</td>
					<td>
						<?php echo $bo_id?>
					</td>
				</tr>
				<tr>
					<td>bo_title</td>
					<td>
						<textarea name="bo_title" cols="80" rows="4"><?php echo $bo_title?></textarea>
					</td>
				</tr>
				<tr>
					<td>bo_author</td>
					<td>
						<textarea name="bo_author" cols="80" rows="4"><?php echo $bo_author?></textarea>
					</td>
				</tr>
					<td>bo_publisher</td>
					<td>
						<input type="text" name="bo_publisher" size="25" value="<?php echo $bo_publisher?>">
					</td>
				</tr>
				<tr>
					<td>bo_description</td>
					<td>
						<textarea name="bo_description" cols="80" rows="8"><?php echo $bo_description?></textarea>
					</td>
				</tr>
					<td>bo_isbn</td>
					<td>
						<input type="text" name="bo_isbn" size="15" value="<?php echo $bo_isbn?>">
					</td>
				</tr>
				<tr>
					<td>bo_coverpath</td>
					<td>
						<textarea name="bo_coverpath" cols="80" rows="4"><?php echo $bo_coverpath?></textarea>
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
