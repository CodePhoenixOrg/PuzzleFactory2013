<script language="javascript">
function checkValues() {
	if(document.myForm.usertable.value=="") {
		alert("Vous devez choisir une table.");
		return false;
	} else {
		document.myForm.action="page.php?id=32&lg=<?php   echo $lg?>";
	}
	
	return true;
}
</script>
<center>
<?php   
	include_once 'puzzle/ipz_controls.php';
	$userdb = get_variable('userdb', 'webfactory');
	$basedir = get_variable('srvdir');
	$usertable = get_variable('usertable');
	$pa_filename = get_variable('pa_filename', $usertable);
	$query = get_variable('query', 'MENU');
	$bl_id = get_variable('bl_id', 0);

	$cs=connection(CONNECT, $userdb);
	$tmp_filename="tmp.php";
	//$wwwroot=get_www_root();
	$wwwroot=get_current_http_root();
	//$filepath="$wwwroot/$userdb/fr/$pa_filename";
	//$filedir="$wwwroot/$userdb/fr/";
	$filepath="$wwwroot/$lg/$pa_filename";
	$filedir="$wwwroot/$lg/";
	
	echo "<br>";
		
	$tab_ides=get_tab_ides();
	
	if($basedir=="") $basedir= get_current_dir() . "/fr";

	$on_change="";
	$on_change_table="";
	$srvdir=create_server_directory_selector("srvdir", "myForm", $basedir, $on_change);
	$srvfiles=create_server_file_selector("srvfiles", "myForm", $basedir, "php", 5, "srvdir", $on_change);
	$database_list=create_options_from_query("show databases", 0, 0, array(), $userdb, false, $cs);
	$table_list=create_options_from_query("show tables from $userdb", 0, 0, array(), $usertable, false, $cs);
	$sql='select b.bl_id, d.di_fr_short from blocks b, dictionary d where b.di_name=d.di_name order by d.di_fr_short';
	$block_list=create_options_from_query($sql, 0, 1, array(), $bl_id, false, $cs);
	
	//Options de menu
	$rad_menu = ['', ''];
	$menu = get_variable('menu', 0);
	$rad_menu[$menu]=" checked"; 
	
	//Options de script
	$rad_dbgrid = ['', ''];
	$dbgrid = get_variable('dbgrid', 0);
	$rad_dbgrid[$dbgrid]=" checked"; 
	
	//Option de filtre
	$chk_filter = '';
	$filter = get_variable('filter');
	if($filter=="1") $chk_filter=" checked"; 
	
	//Option d'ajout
	$chk_addoption = '';
	$addoption = get_variable('addoption');
	if($addoption=="1") $chk_addoption=" checked";

	$me_id = get_variable('me_id');

	
	$hidden="<input type='hidden' name='query' value=''>\n";
	$hidden.="<input type='hidden' name='basedir' value='$basedir'>\n";
	//$hidden.="<input type='hidden' name='userdb' value='$userdb'>\n";
	$hidden.="<input type='hidden' name='filename' value=''>\n";
	$hidden.="<input type='hidden' name='pz_current_tab' value=''>\n";
	
	$di_name = (strlen($usertable)>8) ? substr($usertable, 0, 8): $usertable;
	$di_short = $usertable;
	$di_long = "Liste des ".$usertable;
	
	//Onglet 'Scripts'
	$tab_mk_script="
	<fieldset style='width:450px;'>
	<legend>Créer un script à partir d'une table</legend>
	<table border='0' bordercolor='0' width='85%' valign='top' style='display:hidden;'>
	<tr><td width='50%'><b>Base de donnée</b></td><td width='50%'><b>Table</b></td><td></td></tr>
	<tr><td>
	<select name='userdb' onChange='".$on_change.";document.myForm.submit();'>".
	$database_list["list"]."
	</select>
	</td><td>
	<select name='usertable' onChange='".$on_change_table.";document.myForm.submit();'>".
	$table_list["list"]."
	</select>
	</td><td>
	</td></tr>
	<tr><td colspan='2'><hr></td></tr>
	<tr><td colspan='2'>
	<b>Propriétés du script :</b>
	</td></tr>
	<tr><td>
	<label><input type='radio'".$rad_dbgrid[0]." name='dbgrid' value='0'>DB Grid seul</label>
	</td><td>
	<label><input type='checkbox'$chk_filter name='filter' value='1'>+ Filtre</label>
	</td></tr>
	<tr><td>
	<label><input type='radio'".$rad_dbgrid[1]." name='dbgrid' value='1'>DB Grid + Fiche</label>
	</td><td>
	<label><input type='checkbox'$chk_addoption name='addoption' value='1'>+ Bouton ajouter</label>
	</td></tr>
	<tr><td colspan='2'><hr></td></tr>
	<tr><td colspan='2'>
	<b>Propriétés du menu :</b>
	</td></tr>
	<tr><td>
	<label><input type='radio'".$rad_menu[0]." name='menu' value='0'>Index auto-incrémenté</label>
	</td><td>
	Niveau
	<select name='me_level'>
	<option value='0'>Invisible</option>
	<option value='1'>Menu principal</option>
	<option selected value='2'>Sous-menu</option>
	</select>
	</td></tr>
	<tr><td>
	<label><input type='checkbox' name='autogen' checked='checked' value='1'>Entrée auto-générée</label>&nbsp;
	</td><td>Bloc 
	<select name='bl_id'>".
	$block_list["list"].
	"</select>
	</td></tr>
	<tr><td colspan='2'><hr></td></tr>
	<tr><td colspan='2'>
	<b>Propriétés du dictionaire :</b>
	</td></tr>
	<tr><td>
	<label>Index <input type='text' name='di_name' value='$di_name' size='8' maxlength='8'></label>
	</td><td>
	<label>Libellé court <input type='text' name='di_short' value='$di_short' size='16'></label>
	</td></tr>
	<tr><td colspan='2'>
	<label>Libellé long <br><input type='text' name='di_long' value='$di_long' size='70'></label>
	</td></tr>
	<tr><td colspan='2'><hr></td></tr>
	<tr><td colspan='3'>
	<b>Chemin du script :</b>
	</td></tr>
	<tr><td>Rép. $srvdir
	</td><td>Nom 
	<input type='text' name='pa_filename' value='$pa_filename' style='width:70px'>
	<select name='extension'>
	<option>.php</option>
	<option>.php4</option>
	<option>.php5</option>
	<option>.inc</option>
	<option>.old</option>
	<option>.bak</option>
	</select>
	</td></tr>
	<tr><td colspan='3' align='center'>
	<br><input type='button' name='previous' value='<< Précédent' onClick='document.myForm.action=\"page.php?id=17&lg=$lg\";document.myForm.submit()'>
	&nbsp;<input type='button' name='next' value='Suivant >>' onClick='if(checkValues()) document.myForm.submit();'>
	</td></tr>
	</table>
	</fieldset>";

	echo "<form method='post' name='myForm' action=''>\n";
	echo $hidden;
	echo $tab_mk_script;
	echo "</form>\n";
?>
</center>
