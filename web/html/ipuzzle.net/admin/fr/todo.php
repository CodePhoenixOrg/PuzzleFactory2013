<center>
<?php
    include("todo_code.php");
    use \Puzzle\Data\Controls as DataControls;

	$datacontrols = new DataControls($lg, $db_prefix);
	
	$td_expiry = date('Y-m-d H:i:s');
	$td_expiry = date('Y-m-d H:i:s', strtotime($td_expiry . '+31 day'));
	
    $pc = getArgument("pc");
    $sr = getArgument("sr");
    $curl_pager = "";
    $dialog = "";
    if (isset($pc)) {
        $curl_pager="&pc=$pc";
    }
    if (isset($sr)) {
        $curl_pager.="&sr=$sr";
    }
    if ($query === "SELECT") {
        $sql="select td.td_id, concat('<b>', td.td_title, '</b><br>', td.td_text, '<br>') as `tâches`, mb.mbr_ident as 'r&eacute;al.', td.td_status as '&eacute;tat', td.td_priority as 'priorité', td.td_expiry as '&eacute;ch&eacute;ance' from pz_todo as td left outer join pz_members as mb on td.mbr_id2=mb.mbr_id order by td.td_status, td.td_expiry, td.td_priority desc";
        $dbgrid=$datacontrols->createPagerDbGrid("todo", $sql, $id, "page.php", "&query=ACTION$curl_pager", "", true, true, $dialog, [0, 140, 30, 30, 30, 30], 15, $grid_colors, $cs);
        //$dbgrid = tableShadow($tablename, $dbgrid);
        echo "<br>".$dbgrid;
    } elseif ($query === "ACTION") {
		$priority=array(1,2,3);
		if(empty($td_priority)) $td_priority=1;
		$status=array("à faire", "en cours", "fait");
		if(empty($td_status)) $td_status="à faire";
        ?>
<form method="POST" name="pz_todoForm" action="page.php?id=219&lg=fr">
	<input type="hidden" name="query" value="ACTION">
	<input type="hidden" name="event" value="onRun">
	<input type="hidden" name="pc" value="<?php echo $pc?>">
	<input type="hidden" name="sr" value="<?php echo $sr?>">
	<input type="hidden" name="td_id" value="<?php echo $td_id?>">
	<table border="1" bordercolor="<?php echo $panel_colors["border_color"]?>" cellpadding="0" cellspacing="0" witdh="100%" height="1">
		<tr>
			<td align="center" valign="top" bgcolor="<?php echo $panel_colors["back_color"]?>">
				<table>
				<tr>
					<td>td_id</td>
					<td>
						<?php echo $td_id?>
					</td>
				</tr>
				<tr>
					<td>td_title</td>
					<td>
						<textarea name="td_title" cols="80" rows="4"><?php echo $td_title?></textarea>
					</td>
				</tr>
				<tr>
					<td>td_text</td>
					<td>
						<textarea name="td_text" cols="80" rows="8"><?php echo $td_text?></textarea>
					</td>
				</tr>
					<td>td_priority</td>
					<td>
						<input type="text" name="td_priority" size="11" value="<?php echo $td_priority?>">
					</td>
				</tr>
				<tr>
					<td>td_expiry</td>
					<td>
						<input type="text" name="td_expiry" size="19" value="<?php echo (empty($td_expiry)) ? date("1970-01-01") : $td_expiry; ?>" >
					</td>
				</tr>
				<tr>
					<td>td_status</td>
					<td>
						<input type="text" name="td_status" size="8" value="<?php echo $td_status?>">
					</td>
				</tr>
				<tr>
					<td>td_date</td>
					<td>
						<input type="text" name="td_date" size="19" value="<?php echo (empty($td_date)) ? date("1970-01-01") : $td_date; ?>" >
					</td>
				</tr>
				<tr>
				<tr>
					<td>td_time</td>
					<td>
						<input type="text" name="td_time" size="19" value="<?php echo (empty($td_time)) ? date("1970-01-01") : $td_time; ?>" >
					</td>
				</tr>
				<tr>
				<tr>
					<td>mbr_id</td>
					<td>
						<select name="mbr_id">
						<?php   $sql="select mbr_id, mbr_nom from pz_members order by mbr_nom";
        $options = $datacontrols->createOptionsFromQuery($sql, 0, 1, [], $mbr_id, false, $cs);
        echo $options["list"]; ?>
						</select>
					</td>
				</tr>
					<tr>
						<td align="center" colspan="2">
							<input type="submit" name="action" value="<?php echo $action?>">
							<?php   if ($action!="Ajouter") {
            ?>
								<input type="submit" name="action" value="Supprimer">
							<?php
        } ?>
							<input type="reset" name="action" value="Annuler">
							<input type="submit" name="action" value="Retour">
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
<?php
    } ?>
</center>
