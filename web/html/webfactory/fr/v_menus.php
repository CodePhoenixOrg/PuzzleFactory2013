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

			$sql="select max(me_id) from v_menus;";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch();
			$me_id=$rows[0]+1;
			$pa_id="";
			$me_target="";
			$me_level="";
			$di_name="";
			$pa_filename="";
			$di_fr_short="";
			$di_fr_long="";
			$di_en_short="";
			$di_en_long="";
		break;
		case "Modifier":
			$sql="select * from v_menus where me_id='$me_id';";
			$stmt = $cs->query($sql);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$me_id=$rows["me_id"];
			$pa_id=$rows["pa_id"];
			$me_target=$rows["me_target"];
			$me_level=$rows["me_level"];
			$di_name=$rows["di_name"];
			$pa_filename=$rows["pa_filename"];
			$di_fr_short=$rows["di_fr_short"];
			$di_fr_long=$rows["di_fr_long"];
			$di_en_short=$rows["di_en_short"];
			$di_en_long=$rows["di_en_long"];
		break;
		}
	} else if($event=="onRun" && $query=="ACTION") {
		switch ($action) {
		case "Ajouter":
			$sql="insert into v_menus (".
				"me_id, ".
				"pa_id, ".
				"me_target, ".
				"me_level, ".
				"di_name, ".
				"pa_filename, ".
				"di_fr_short, ".
				"di_fr_long, ".
				"di_en_short, ".
				"di_en_long".
			") values (".
				"'$me_id', ".
				"'$pa_id', ".
				"'$me_target', ".
				"'$me_level', ".
				"'$di_name', ".
				"'$pa_filename', ".
				"'$di_fr_short', ".
				"'$di_fr_long', ".
				"'$di_en_short', ".
				"'$di_en_long'".
			")";
			$stmt = $cs->query($sql);
		break;
		case "Modifier":
			$sql="update v_menus set ".
				"me_id='$me_id', ".
				"pa_id='$pa_id', ".
				"me_target='$me_target', ".
				"me_level='$me_level', ".
				"di_name='$di_name', ".
				"pa_filename='$pa_filename', ".
				"di_fr_short='$di_fr_short', ".
				"di_fr_long='$di_fr_long', ".
				"di_en_short='$di_en_short', ".
				"di_en_long='$di_en_long' ".
			"where me_id='$me_id'";
			$stmt = $cs->query($sql);
		break;
		case "Supprimer":
			$sql="delete from v_menus where me_id='$me_id'";
			$stmt = $cs->query($sql);
		break;
		}
		$query="SELECT";
	} else if($event=="onUnload" && $query=="ACTION") {
		$cs=connection("disconnect","webfactory");
		echo "<script language='JavaScript'>window.location.href='page.php?id=22&lg=fr'</script>";
	}
if($query=="SELECT") {
		$sql="select me_id, pa_id from v_menus order by me_id";
		$dbgrid=create_pager_db_grid("v_menus", $sql, $id, "page.php", "&query=ACTION", "", "pa_id", true, $dialog, array(0, 400), 15, $grid_colors, $cs);
		$dbgrid=table_shadow("v_menus", $dbgrid);
		echo "<br>".$dbgrid;
} elseif($query=="ACTION") {
?>
<form method='POST' name='v_menusForm' action='page.php?id=22&lg=fr'>
<input type='hidden' name='query' value='ACTION'>
<input type='hidden' name='event' value=''>
<input type='hidden' name='me_id' value='<?php    echo $me_id?>'>
<table witdh='100%' height='100%'><tr><td align='center' valign='middle'><table><tr><td>me_id</td>
<td><?php    echo $me_id?></td></tr>
<tr><td>pa_id</td>
<td><select name='pa_id'>
<?php    $options=options_concat("pa_id", " | ", "di_name", "pa_id", "v_menus", "", "pa_id", $pa_id, false);
echo $options;?></select></td></tr>
<tr><td>me_target</td>
<td><input type='text' name='me_target' value='<?php    echo $me_target?>'></td></tr>
<tr><td>me_level</td>
<td><input type='text' name='me_level' value='<?php    echo $me_level?>'></td></tr>
<tr><td>di_name</td>
<td><select name='di_name'>
<?php    $options=options_concat("di_name", " | ", "di_fr_short", "di_name", "v_menus", "", "di_name", $di_name, false);
echo $options;?></select></td></tr>
<tr><td>pa_filename</td>
<td><input type='text' name='pa_filename' value='<?php    echo $pa_filename?>'></td></tr>
<tr><td>di_fr_short</td>
<td><input type='text' name='di_fr_short' value='<?php    echo $di_fr_short?>'></td></tr>
<tr><td>di_fr_long</td>
<td><input type='text' name='di_fr_long' value='<?php    echo $di_fr_long?>'></td></tr>
<tr><td>di_en_short</td>
<td><input type='text' name='di_en_short' value='<?php    echo $di_en_short?>'></td></tr>
<tr><td>di_en_long</td>
<td><input type='text' name='di_en_long' value='<?php    echo $di_en_long?>'></td></tr>

<tr><td align='center' colspan='2'><input type='submit' name='action' value='<?php    echo $action?>' onClick='return runForm("v_menusForm");'>
<?php    	if($action!="Ajouter") { ?>
<input type='submit' name='action' value='Supprimer' onClick='return runForm("v_menusForm");'>
<?php    	} ?>
<input type='reset' name='action' value='Annuler'>
<input type='submit' name='action' value='Fermer' onClick='return unloadForm("v_menusForm");'>
</td></tr></table>
</td></tr></table>
</form>
<?php    } ?>
</center>
