<center>
<?php   
	include("members2_code.php");
	if($query=="SELECT") {
			$sql="select mbr_id, mbr_nom from members order by mbr_id";
			$dbgrid=create_pager_db_grid("members", $sql, $id, "page.php", "&query=ACTION$curl_pager", "", true, true, $dialog, array(0, 400), 15, $grid_colors, $cs);
			//$dbgrid=table_shadow("members", $dbgrid);
			echo "<br>".$dbgrid;
	} elseif($query=="ACTION") {
?>
<form method='POST' name='membersForm' action='page.php?id=34&lg=fr'>
	<input type='hidden' name='query' value='ACTION'>
	<input type='hidden' name='event' value='onRun'>
	<input type='hidden' name='pc' value='<?php   echo $pc?>'>
	<input type='hidden' name='sr' value='<?php   echo $sr?>'>
	<input type='hidden' name='mbr_id' value='<?php   echo $mbr_id?>'>
	<table border='1' bordercolor='<?php   echo $panel_colors["border_color"]?>' cellpadding='0' cellspacing='0' witdh='100%' height='1'>
		<tr>
			<td align='center' valign='top' bgcolor='<?php   echo $panel_colors["back_color"]?>'>
				<table>
				<tr>
					<td>mbr_id</td>
					<td>
						<?php   echo $mbr_id?>
					</td>
				</tr>
				<tr>
					<td>mbr_nom</td>
					<td>
						<input type='text' name='mbr_nom' value='<?php   echo $mbr_nom?>'>
					</td>
				</tr>
				<tr>
					<td>mbr_adr1</td>
					<td>
						<input type='text' name='mbr_adr1' value='<?php   echo $mbr_adr1?>'>
					</td>
				</tr>
				<tr>
					<td>mbr_adr2</td>
					<td>
						<input type='text' name='mbr_adr2' value='<?php   echo $mbr_adr2?>'>
					</td>
				</tr>
				<tr>
					<td>mbr_cp</td>
					<td>
						<input type='text' name='mbr_cp' value='<?php   echo $mbr_cp?>'>
					</td>
				</tr>
				<tr>
					<td>mbr_email</td>
					<td>
						<input type='text' name='mbr_email' value='<?php   echo $mbr_email?>'>
					</td>
				</tr>
				<tr>
					<td>mbr_ident</td>
					<td>
						<input type='text' name='mbr_ident' value='<?php   echo $mbr_ident?>'>
					</td>
				</tr>
				<tr>
					<td>mbr_mpasse</td>
					<td>
						<input type='text' name='mbr_mpasse' value='<?php   echo $mbr_mpasse?>'>
					</td>
				</tr>
					<tr>
						<td align='center' colspan='2'>
							<input type='submit' name='action' value='<?php   echo $action?>'>
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
