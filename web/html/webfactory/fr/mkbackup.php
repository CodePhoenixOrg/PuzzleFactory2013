<center>
<?php   
	include_once 'puzzle/ipz_mkscripts.php';
	
	if(empty($userdb)) $userdb="webfactory";
	if(empty($query)) $query="MENU";
	$cs=connection(CONNECT, $userdb);
	$tmp_filename="tmp.php";
	$wwwroot=get_www_root();
	$filepath="$wwwroot/../$userdb/fr/$pa_filename";
	$filedir="$wwwroot/../$userdb/fr/";
	
	echo "<br>";
		
	$tab_ctrl_name="myTab";
	if($query=="SCRIPT" && $table=="0") {
		$query="MENU";
		//echo "<font color='red'><h3>Veuillez choisir une table d'abord.</h3></font>";
		//$js="var changeTab=document.getElementById(".$tab_ctrl_name."Captions[index]);";
		$js_error="PZ_CURRENT_TAB_NAME=document.myTabForm.pz_current_tab.value;\n";
		$js_error.="var changeTab=document.getElementById(PZ_CURRENT_TAB_NAME);\n";
		$js_error.="display_tab(changeTab, new Array(PZ_CURRENT_TAB_NAME));\n";
		$js_error.="alert(PZ_CURRENT_TAB_NAME);\n";
		$js_error.="alert(\"Veuillez choisir une table d'abord.\");\n";
	}
		
	if($query=="MENU") {
		if($pa_filename!="" && $save=="Oui") {
			copy($tmp_filename, $pa_filename);
		}
		$script="";
		if($basedir=="") $basedir="/$userdb/fr";

		$on_change="document.myTabForm.pz_current_tab.value=PZ_CURRENT_TAB_NAME;";
		$srvdir=create_server_directory_selector("srvdir", "myTabForm", $basedir, $on_change);
		$srvfiles=create_server_file_selector("srvfiles", "myTabForm", $basedir, "php", 5, "srvdir", $on_change);
		$database_list=create_options_from_query("show databases", 0, 0, array(), $userdb, false, $cs);
		$table_list=create_options_from_query("show tables", 0, 0, array(), $table, false, $cs);
		
		//Options de départ
		$rad_choice=(array) null;
		if(!isset($choice)) $choice=0;
		$rad_choice[$choice]=" checked"; 
		
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
		
		$on_click="var index=get_radio_value(\"myTabForm\", \"choice\")+1;";
		//$on_click.=js_array("mytabCaptions", $tab_captions);
		$on_click.="var changeTab=document.getElementById(".$tab_ctrl_name."Captions[index]);";
		$on_click.="display_tab(changeTab,".$tab_ctrl_name."Captions);";
		
		$tab_start="
		<div id='tab_Start' style='display:inline;visibility:visible;'>
		<fieldset>
		<legend>Créer un script, un menu, un bloc ...</legend>
		<table border='0' bordercolor='0' width='100%' valign='top' style='display:hidden;'>
		<tr><td>&nbsp;</td><td>
		<label><input type='radio'".$rad_choice[0]." name='choice' value='0'>Auto-générer un script à partir d'une table<label><br>
		<label><input type='radio'".$rad_choice[1]." name='choice' value='1'>Créer une nouvelle entrée de menu</label><br>
		<label><input type='radio'".$rad_choice[2]." name='choice' value='2'>Créer un nouveau bloc</label>&nbsp;
		</td><td>&nbsp;</td></tr>
		<tr><td colspan='2' align='center'>
		<br><input type='button' name='action' value='Suivant' onClick='$on_click'>
		</td></tr>
		</table>
		</fieldset>
		</div>
		";
		
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
		<tr><td colspan='2' align='center'>
		<br><input type='button' name='action' value='<< Précédent' onClick='".on_change_tab($tab_ctrl_name, 0)."'>
		&nbsp;<input type='submit' name='action' value='Suivant >>' onClick='document.myTabForm.query.value=\"SCRIPT\";document.myTabForm.basedir.value=\"$basedir\"'>
		</td></tr>
		</table>
		</fieldset>
		</div>
		";

		//Onglet 'Scripts'
		$tab_mk_script="
		<div id='tab_Scripts' style='display:inline;visibility:visible;'>
		<fieldset>
		<legend>Créer un script à partir d'une table</legend>
		<table border='0' bordercolor='0' width='100%' valign='top' style='display:hidden;'>
		<tr><td><b>Base de donnée</b></td><td><b>Table</b></td><td></td></tr>
		<tr><td>
		<select name='userdb' onChange='".$on_change."document.myTabForm.query.value=\"MENU\";document.myTabForm.submit();'>".
		$database_list["list"]."
		</select>
		</td><td>
		<select name='table'>".
		$table_list["list"]."
		</select>
		</td><td>
		</td></tr>
		<tr><td colspan='2'>
		<b>Index de menu :</b>
		</td></tr>
		<tr><td>
		<label><input type='radio'".$rad_menu2[0]." name='menu2' value='0'>Auto-incrémenté</label>
		</td><td>
		<label><input type='radio'".$rad_menu2[1]." name='menu2' value='1'>Choisi</label>&nbsp;
		<input type='text' name='me_id' value='$me_id' size=3>
		</td><td>&nbsp;
		</td></tr>
		<tr><td colspan='2'>
		<b>Propriétés du script :</b>
		</td></tr>
		<tr><td>
		<label><input type='radio'".$rad_props[0]." name='props' value='0'>DB Grid seul</label>
		</td><td>
		<label><input type='checkbox'$chk_filter name='filter' value='0'>+ Filtre</label>
		</td></tr>
		<tr><td>
		<label><input type='radio'".$rad_props[1]." name='props' value='1'>DB Grid + Fiche</label>
		</td><td>
		<label><input type='checkbox'$chk_filter name='filter' value='0'>+ Bouton ajouter</label>
		</td></tr>
		<tr><td colspan='3'>
		<b>Répertoire du script :</b>
		</td></tr>
		<tr><td colspan='3'>
		$srvdir
		</td></tr>
		<tr><td colspan='3' align='center'>
		<br><input type='button' name='action' value='<< Précédent' onClick='".on_change_tab($tab_ctrl_name, 0)."'>
		&nbsp;<input type='submit' name='action' value='Suivant >>' onClick='document.myTabForm.query.value=\"SCRIPT\";document.myTabForm.basedir.value=\"$basedir\"'>
		</td></tr>
		</table>
		</fieldset>
		</div>";
				
		$mytabs=$tab_start .$tab_mk_script .$tab_mk_menu;
		$tab_control=create_tab_control($tab_ctrl_name, $tab_captions, $mytabs, $hidden);
		
		$tab_ctrl=$tab_control["tab_ctrl"];

		echo $tab_ctrl;
	
		if($js_error!="") echo js_quote($js_error);


	} elseif($query=="SCRIPT") {
		echo "<form name='scriptForm' method='POST' action='page.php?id=10&lg=$lg'>\n";

		$dir="/var/www/html/$userdb/fr";
		//if(!file_exists($dir)) mkdir($dir);
		$siteroot=$filedir;
		$http_root=get_http_root();
	
		if($action="Créer") {
			$formname="fiche_$table";
			$sql="show fields from $table;";
	
			$L_sqlFields="";
			$A_sqlFields=Array();
			
			$stmt = $cs->query($sql);
			while($rows=$stmt->fetch()) {
				$L_sqlFields.=$rows[0].",";
			}
			$L_sqlFields=substr($L_sqlFields, 0, strlen($L_sqlFields)-1);
			$A_sqlFields=explode(",", $L_sqlFields);
			$indexfield=$A_sqlFields[0];
			$secondfield=$A_sqlFields[1];
			
			$catalog_pa_filename="$table.php";
			$catalog=get_menu_id($userdb, $catalog_pa_filename);
			
			echo "file='$basedir/$catalog_pa_filename'; catalog='$catalog';<br>";
			$script_exists=(file_exists("$basedir/$catalog_pa_filename")) && ($catalog!=0);

			if($script_exists) {
				echo "Le script $catalog_pa_filename existe déjà sous l'index de menu $catalog.'<br>";
			}
			
			$me_id="";
			$me_level="1";
			$new_pa_id="";
			//$pa_filename=$catalog_pa_filename;
			$di_name=$table;
			$di_fr_short=strtoupper(substr($table,0,1)).substr($table, 1, strlen($table)-1);
			$di_fr_long="Liste des $table";

			if($catalog==0 && $radio_autogen[0]==1) {
				$catalog=add_menu(
					$userdb,
					$me_id, $di_name, $me_level, $me_target,
					$pa_id, $new_pa_id, $catalog_pa_filename,
					$di_fr_short, $di_fr_long, $di_en_short, $di_en_long
				);
			}
			
			
			//$pa_filename="$siteroot/$catalog_pa_filename";
			$pa_filename="$basedir/$table.php";
			echo "file='$pa_filename';<br>";
			$script=make_script($userdb, $table, $pa_filename, $catalog, $indexfield, $secondfield, $A_sqlFields, $cs, NO_FRAME);
	
			$file=fopen($tmp_filename, "w");
			fwrite($file, $script);
			fclose($file);
		}

		//echo "<input type='hidden' name='script' value='$script'>\n";
		/*
		echo "<input type='hidden' name='userdb' value='$userdb'>\n";
		echo "<input type='hidden' name='catalog' value='$catalog'>\n";
		echo "<input type='hidden' name='indexfield' value='$indexfield'>\n";
		echo "<input type='hidden' name='secondfield' value='$secondfield'>\n";
		echo "<input type='hidden' name='A_sqlFields' value='$A_sqlFields'>\n";
		*/

		echo "<input type='hidden' name='table' value='$table'>\n";
		echo "<input type='hidden' name='basedir' value='$basedir'>\n";
		echo "<input type='hidden' name='query' value='$query'>\n";
		echo "<input type='hidden' name='pa_filename' value='$pa_filename'>\n";
		if($script=="") {
			$script_file = file($tmp_filename);
			$script = implode ("", $script_file);
			$script_file = null;
		}
		echo "<textarea cols='80' rows='20'>$script</textarea><br>\n";
		echo "Le fichier sera copié dans ce répertoire\n";
		if(!isset($basedir)) $basedir=$filedir;
		$onChange="document.scriptForm.query.value=\"SCRIPT\";";
		$dir_selector=create_server_directory_selector("srvdirs", "scriptForm",$basedir, $onChange);
		echo $dir_selector."<br>\n";

		echo "$pa_filename<br>";
		if(file_exists($pa_filename)) {
			echo "Attention ! Un fichier portant ce nom existe déjà !<br>";
			echo "Voulez-vous écraser le script actuel sachant que toutes les modifications effectuées seront perdues ?<br>\n";
		} else
			echo "Voulez-vous enregistrer le script ?<br>\n";
		echo "<input type='submit' name='save' value='Oui'>\n";
		echo "<input type='submit' name='save' value='Non' onClick='document.scriptForm.query.value=\"MENU\"'>\n";
		echo "</form>\n";
	}
?>
</center>
