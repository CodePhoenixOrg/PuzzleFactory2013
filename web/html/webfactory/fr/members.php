<center>
<script language="JavaScript" src="js/pz_form_events.js"></script>
<?php    
	include_once 'puzzle/ipz_mysqlconn.php';
	include_once 'puzzle/ipz_db_controls.php';
	$cs=connection("connect","webfactory");
	if(empty($query)) $query="SELECT";
	if(empty($event)) $event="onLoad";
	if(empty($action)) $action="Ajouter";
	if($event=="onLoad" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":

			$sql="select max(mbr_id) from members;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$mbr_id=$rows[0]+1;
			$mbr_nom="";
			$mbr_adr1="";
			$mbr_adr2="";
			$mbr_cp="";
			$mbr_email="";
			$mbr_ident="";
			$mbr_mpasse="";
			$grp_group="";
		break;
		case "Modifier":
			$sql="select * from members where mbr_id='$mbr_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$mbr_id=$rows["mbr_id"];
			$mbr_nom=$rows["mbr_nom"];
			$mbr_adr1=$rows["mbr_adr1"];
			$mbr_adr2=$rows["mbr_adr2"];
			$mbr_cp=$rows["mbr_cp"];
			$mbr_email=$rows["mbr_email"];
			$mbr_ident=$rows["mbr_ident"];
			$mbr_mpasse=$rows["mbr_mpasse"];
			$grp_group=$rows["grp_group"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":
			$sql="insert into members (".
				"mbr_id, ".
				"mbr_nom, ".
				"mbr_adr1, ".
				"mbr_adr2, ".
				"mbr_cp, ".
				"mbr_email, ".
				"mbr_ident, ".
				"mbr_mpasse, ".
				"grp_group".
			") values (".
				"'$mbr_id', ".
				"'$mbr_nom', ".
				"'$mbr_adr1', ".
				"'$mbr_adr2', ".
				"'$mbr_cp', ".
				"'$mbr_email', ".
				"'$mbr_ident', ".
				"'$mbr_mpasse', ".
				"'$grp_group'".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$sql="update members set ".
				"mbr_id='$mbr_id', ".
				"mbr_nom='$mbr_nom', ".
				"mbr_adr1='$mbr_adr1', ".
				"mbr_adr2='$mbr_adr2', ".
				"mbr_cp='$mbr_cp', ".
				"mbr_email='$mbr_email', ".
				"mbr_ident='$mbr_ident', ".
				"mbr_mpasse='$mbr_mpasse', ".
				"grp_group='$grp_group' ".
			"where mbr_id='$mbr_id'";
			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from members where mbr_id='$mbr_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection("disconnect","webfactory");
		echo "<script language='JavaScript'>window.location.href='page.php?id=18&lg=fr'</script>";
	}
if($query=="SELECT") {
		$sql="select mbr_id, mbr_nom from members order by mbr_id";
		$dbgrid=create_pager_db_grid("members", $sql, $id, "page.php", "&query=ACTION", "", "mbr_nom", true, $dialog, array(0, 400), 15, $grid_colors, $cs);
		$dbgrid=table_shadow("members", $dbgrid);
		echo "<br>".$dbgrid;
} elseif($query=="ACTION") {
?>
<form method='POST' name='membersForm' action='page.php?id=18&lg=fr'>
<input type='hidden' name='query' value='ACTION'>
<input type='hidden' name='event' value=''>
<input type='hidden' name='mbr_id' value='<?php    echo $mbr_id?>'>
<table witdh='100%' height='100%'><tr><td align='center' valign='middle'><table><tr><td>mbr_id</td>
<td><?php    echo $mbr_id?></td></tr>
<tr><td>mbr_nom</td>
<td><input type='text' name='mbr_nom' value='<?php    echo $mbr_nom?>'></td></tr>
<tr><td>mbr_adr1</td>
<td><input type='text' name='mbr_adr1' value='<?php    echo $mbr_adr1?>'></td></tr>
<tr><td>mbr_adr2</td>
<td><input type='text' name='mbr_adr2' value='<?php    echo $mbr_adr2?>'></td></tr>
<tr><td>mbr_cp</td>
<td><input type='text' name='mbr_cp' value='<?php    echo $mbr_cp?>'></td></tr>
<tr><td>mbr_email</td>
<td><input type='text' name='mbr_email' value='<?php    echo $mbr_email?>'></td></tr>
<tr><td>mbr_ident</td>
<td><input type='text' name='mbr_ident' value='<?php    echo $mbr_ident?>'></td></tr>
<tr><td>mbr_mpasse</td>
<td><input type='text' name='mbr_mpasse' value='<?php    echo $mbr_mpasse?>'></td></tr>
<tr><td>grp_group</td>
<td><input type='text' name='grp_group' value='<?php    echo $grp_group?>'></td></tr>

<tr><td align='center' colspan='2'><input type='submit' name='action' value='<?php    echo $action?>' onClick='return runForm("membersForm");'>
<?php    	if($action!="Ajouter") { ?>
<input type='submit' name='action' value='Supprimer' onClick='return runForm("membersForm");'>
<?php    	} ?>
<input type='reset' name='action' value='Annuler'>
<input type=button value="Retour" onClick="history.go(-1);">
</td></tr></table>
</td></tr></table>
</form>
<?php    } ?>
</center>
