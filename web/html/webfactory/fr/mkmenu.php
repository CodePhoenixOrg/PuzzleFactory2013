<center>
<?php   
 	if(empty($userdb)) $userdb="webfactory";
	$cs=connection(CONNECT, $userdb);
	$tmp_filename="tmp.php";
	$wwwroot=get_www_root();
	$filepath="$wwwroot/../$userdb/fr/$pa_filename";
	$filedir="$wwwroot/../$userdb/fr/";
	
	echo "<br>";
		
	$tab_ctrl_name="myTab";
		
	$script="";
	if($basedir=="") $basedir="/$userdb/fr";

	$on_change="document.myForm.pz_current_tab.value=PZ_CURRENT_TAB_NAME;";
	$srvdir=create_server_directory_selector("srvdir", "myForm", $basedir, $on_change);
	$srvfiles=create_server_file_selector("srvfiles", "myForm", $basedir, "php", 5, "srvdir", $on_change);
	$database_list=create_options_from_query("show databases", 0, 0, array(), $userdb, false, $cs);
	$table_list=create_options_from_query("show tables", 0, 0, array(), $table, false, $cs);
	
	//Options de départ
	$rad_choice=(array) null;
	if(!isset($choice)) $choice=0;
	$rad_choice[$choice]=" checked"; 
	
	//Options de l'auto-génération
	$rad_autogen=(array) null;
	if(!isset($autogen)) $autogen=0;
	$rad_autogen[$autogen]=" checked"; 
	
	//Options de menu
	$rad_menu=(array) null;
	if(!isset($menu)) $menu=0;
	$rad_menu[$menu]=" checked"; 
	
	//Options de menu
	$rad_menu2=(array) null;
	if(!isset($menu2)) $menu2=0;
	$rad_menu2[$menu2]=" checked"; 
	
	//Options de script
	$rad_props=(array) null;
	if(!isset($props)) $props=0;
	$rad_props[$props]=" checked"; 
	
	//Options de filtre
	$chk_filter=""; 
	if(isset($filter)) $chk_filter=" checked"; 
	
	$hidden.="<input type='hidden' name='query' value=''>\n";
	$hidden.="<input type='hidden' name='basedir' value=''>\n";
	$hidden.="<input type='hidden' name='filename' value=''>\n";
	$hidden.="<input type='hidden' name='pz_current_tab' value=''>\n";
	
	$tab_captions=array("Start", "Scripts", "Menus");
	
	$on_click="var index=get_radio_value(\"myForm\", \"choice\")+1;";
	//$on_click.=js_array("mytabCaptions", $tab_captions);
	$on_click.="var changeTab=document.getElementById(".$tab_ctrl_name."Captions[index]);";
	$on_click.="display_tab(changeTab,".$tab_ctrl_name."Captions);";
	
	//Onglet 'Menus'
	$tab_mk_menu="
	<div id='tab_Menus' style='display:inline;visibility:visible;'>
	<fieldset>	
	<legend>Créer une entrée de menu à partir d'un script existant</legend>
	<table border='0' bordercolor='0' width='100%' valign='top' style='display:hidden;'>
	<tr><td>
	$srvdir<br>
	$srvfiles
	</td><td>
	<b>Index de menu :</b><br>
	<label><input type='radio'".$rad_menu[0]." name='menu' value='0'>Auto-incrémenté</label><br>
	<label><input type='radio'".$rad_menu[1]." name='menu' value='1'>Choisi</label>&nbsp;
	<input type='text' name='me_id' value='$me_id' size=3>
	</td></tr>
	<tr><td colspan='3' align='center'>
	<br><input type='button' name='previous' value='<< Précédent' onClick='document.myForm.action=\"page.php?id=10&lg=$lg\";document.myForm.submit();'>
	&nbsp;<input type='button' name='next' value='Suivant >>' onClick='document.myForm.action=\"page.php?id=35&lg=$lg\";document.myForm.submit();'>
	</td></tr>
	</table>
	</fieldset>
	</div>
	";

	echo "<form method='post' name='myForm' action=''>\n";
	echo $hidden;
	echo $tab_mk_menu;
	echo "</form>\n";
		
?>
</center>
