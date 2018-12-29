<center>
<?php    
	include_once 'groups_code.php';
	if($query=="SELECT") {
			$sql="select grp_group, grp_members_priv from groups order by grp_group";
			$dbgrid=create_pager_db_grid("groups", $sql, $id, "page.php", "&query=ACTION$curl_pager", "", true, true, $dialog, array(0, 400), 15, $grid_colors, $cs);
			//$dbgrid=table_shadow("groups", $dbgrid);
			echo "<br>".$dbgrid;
	} elseif($query=="ACTION") {
?>
<form method='POST' name='groupsForm' action='page.php?id=27&lg=fr'>
	<input type='hidden' name='query' value='ACTION'>
	<input type='hidden' name='event' value='onRun'>
	<input type='hidden' name='pc' value='<?php    echo $pc?>'>
	<input type='hidden' name='sr' value='<?php    echo $sr?>'>
	<input type='hidden' name='grp_group' value='<?php    echo $grp_group?>'>
	<table border='1' bordercolor='<?php    echo $panel_colors["border_color"]?>' cellpadding='0' cellspacing='0' witdh='100%' height='1'>
		<tr>
			<td align='center' valign='top' bgcolor='<?php    echo $panel_colors["back_color"]?>'>
				<table>
				<tr>
					<td>grp_group</td>
					<td>
						<?php    echo $grp_group?>
					</td>
				</tr>
				<tr>
					<td>grp_members_priv</td>
					<td>
						<input type='text' name='grp_members_priv' value='<?php    echo $grp_members_priv?>'>
					</td>
				</tr>
				<tr>
					<td>grp_menu_priv</td>
					<td>
						<input type='text' name='grp_menu_priv' value='<?php    echo $grp_menu_priv?>'>
					</td>
				</tr>
				<tr>
					<td>grp_page_priv</td>
					<td>
						<input type='text' name='grp_page_priv' value='<?php    echo $grp_page_priv?>'>
					</td>
				</tr>
				<tr>
					<td>grp_news_priv</td>
					<td>
						<input type='text' name='grp_news_priv' value='<?php    echo $grp_news_priv?>'>
					</td>
				</tr>
				<tr>
					<td>grp_items_priv</td>
					<td>
						<input type='text' name='grp_items_priv' value='<?php    echo $grp_items_priv?>'>
					</td>
				</tr>
				<tr>
					<td>grp_customers_priv</td>
					<td>
						<input type='text' name='grp_customers_priv' value='<?php    echo $grp_customers_priv?>'>
					</td>
				</tr>
				<tr>
					<td>grp_products_priv</td>
					<td>
						<input type='text' name='grp_products_priv' value='<?php    echo $grp_products_priv?>'>
					</td>
				</tr>
				<tr>
					<td>grp_calendar_priv</td>
					<td>
						<input type='text' name='grp_calendar_priv' value='<?php    echo $grp_calendar_priv?>'>
					</td>
				</tr>
				<tr>
					<td>grp_newsletter_priv</td>
					<td>
						<input type='text' name='grp_newsletter_priv' value='<?php    echo $grp_newsletter_priv?>'>
					</td>
				</tr>
				<tr>
					<td>grp_forum_priv</td>
					<td>
						<input type='text' name='grp_forum_priv' value='<?php    echo $grp_forum_priv?>'>
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
