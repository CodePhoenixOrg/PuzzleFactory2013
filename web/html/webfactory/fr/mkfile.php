<center>
<?php   
	include_once 'puzzle/ipz_source.php';
    include_once 'puzzle/ipz_analyser.php';

	define('YES', 'Oui');
	define('NO', 'Non');

	$userdb = get_variable("userdb");
	$usertable = get_variable("usertable");
	$dbgrid = get_variable("dbgrid");
	$menu = get_variable("menu");
	$filter = get_variable("filter");
	$addoption = get_variable("addoption");
	$me_level = get_variable("me_level", "1");
	$bl_id = get_variable("bl_id");
	$pa_filename = get_variable("pa_filename");
	$extension = get_variable("extension");
	$basedir = get_variable("basedir");
	$save = get_variable("save");
	$autogen = get_variable("autogen");
	$catalog = get_variable("catalog", 0);
	$query = get_variable("query");
	$di_long = get_variable("di_long");
	$di_short = get_variable("di_short");
	$di_name = get_variable("di_name");
		
	$cs = connection(CONNECT, $userdb) or die("UserDb='$userdb'<br>");
	$tmp_filename = 'tmp_'.$pa_filename;
	$wwwroot = get_www_root();
        
    $relations = relations($userdb,$usertable,$cs);
	$A_fieldDefs = $relations["field_defs"];
	
	echo "<br>";
		
	$rel_page_filename = $pa_filename.$extension;

	$root_code_filename = $wwwroot.$basedir.DIRECTORY_SEPARATOR.$pa_filename.'_code'.$extension;
	$root_page_filename = $wwwroot.$basedir.DIRECTORY_SEPARATOR.$pa_filename.$extension;

	$script_exists = file_exists($rel_page_filename);
	$script_exists_tostring = $script_exists ? YES : NO;
	$http_root = get_http_root();

	if($save=="") {
 
		$formname = "fiche_$usertable";
		$sql = "show fields from $usertable;";

		$L_sqlFields = "";
		$A_sqlFields = [];
		
		$stmt = $cs->query($sql);
		while($rows = $stmt->fetch()) {
			$L_sqlFields .= $rows[0].",";
		}

		$L_sqlFields = substr($L_sqlFields, 0, strlen($L_sqlFields)-1);
		$A_sqlFields = explode(",", $L_sqlFields);
		$indexfield = $A_sqlFields[0];
		$secondfield = $A_sqlFields[1];
		
		list($me_id, $pa_id) = get_menu_and_page($userdb, $rel_page_filename);
		
		echo "Catalog file name: $rel_page_filename<br>";

		if($me_id !== 0) {
			echo "<p style='color:red'>Le script $rel_page_filename existe déjà sous l'id de menu $me_id.</p>";
		}
		if($pa_id !== 0) {
			echo "<p style='color:red'>Le script $rel_page_filename existe déjà sous l'id de page $pa_id.</p>";
		}
		
		if (($me_id == 0 || $pa_id == 0) && $autogen == 1) {
			list($me_id, $pa_id) = add_menu_and_page(
			$userdb,
			$di_name,
			$me_level,
			'page',
			$rel_page_filename,
			$di_short,
			$di_long);

			echo "<p style='color:red'>Le script $rel_page_filename a été ajouté au triplet dictionnaire-page-menu sous l'id de page $pa_id et l'id de menu $me_id.</p>";

		}

		//echo "$cur_pa_filename<br>";
		$message = "<p>Voulez-vous conserver le script ?</p>\n";
		if($script_exists) {
			$message = "<p style='color:red'>Attention ! Un fichier portant ce nom existe déjà.<br>" .
				"Voulez-vous écraser le script actuel sachant que toutes les modifications effectuées seront perdues ?</p>\n";
		}
		
		$script = make_code($userdb, $usertable, $pa_id, $indexfield, $secondfield, $A_fieldDefs, $cs, NO_FRAME);
		file_put_contents('tmp_code.php', $script);
		
		$script = make_page($userdb, $usertable, $pa_filename, $pa_id, $indexfield, $secondfield, $A_sqlFields, $cs, NO_FRAME);
		file_put_contents('tmp_page.php', $script);

//		$script=make_single_script($userdb, $usertable, $pa_filename, $catalog, $indexfield, $secondfield, $A_sqlFields, $cs, NO_FRAME);
//
//		$file=fopen('tmp_single.php', "w");
//		fwrite($file, $script);
//		fclose($file);
//		
//		$script=make_browse_script($userdb, $usertable, $pa_filename, $catalog, $indexfield, $secondfield, $A_sqlFields, $cs, NO_FRAME);
//
//		$file=fopen('tmp_browse.php', "w");
//		fwrite($file, $script);
//		fclose($file);
//		
//		$script=make_form_script($userdb, $usertable, $pa_filename, $catalog, $indexfield, $secondfield, $A_sqlFields, $cs, NO_FRAME);
//
//		$file=fopen('tmp_form.php', "w");
//		fwrite($file, $script);
//		fclose($file);
//		
//		$script=make_insert_script($userdb, $usertable, $pa_filename, $catalog, $indexfield, $secondfield, $A_sqlFields, $cs, NO_FRAME);
//
//		$file=fopen('tmp_insert.php', "w");
//		fwrite($file, $script);
//		fclose($file);
//		
//		$script=make_update_script($userdb, $usertable, $pa_filename, $catalog, $indexfield, $secondfield, $A_sqlFields, $cs, NO_FRAME);
//
//		$file=fopen('tmp_update.php', "w");
//		fwrite($file, $script);
//		fclose($file);
//		
//		$script=make_delete_script($userdb, $usertable, $pa_filename, $catalog, $indexfield, $secondfield, $A_sqlFields, $cs, NO_FRAME);
//
//		$file=fopen('tmp_delete.php', "w");
//		fwrite($file, $script);
//		fclose($file);
		
		$hidden="";
		$hidden.="<input type='hidden' name='userdb' value='$userdb'>\n";
		$hidden.="<input type='hidden' name='usertable' value='$usertable'>\n";
		$hidden.="<input type='hidden' name='dbgrid' value='$dbgrid'>\n";
		$hidden.="<input type='hidden' name='menu' value='$menu'>\n";
		$hidden.="<input type='hidden' name='autogen' value='$autogen'>\n";
		$hidden.="<input type='hidden' name='filter' value='$filter'>\n";
		$hidden.="<input type='hidden' name='addoption' value='$addoption'>\n";
		$hidden.="<input type='hidden' name='me_id' value='$me_id'>\n";
		$hidden.="<input type='hidden' name='pa_id' value='$pa_id'>\n";
		$hidden.="<input type='hidden' name='me_level' value='$me_level'>\n";
		$hidden.="<input type='hidden' name='bl_id' value='$bl_id'>\n";
		$hidden.="<input type='hidden' name='pa_filename' value='$pa_filename'>\n";
		$hidden.="<input type='hidden' name='extension' value='$extension'>\n";
		$hidden.="<input type='hidden' name='basedir' value='$basedir'>\n";
		$hidden.="<input type='hidden' name='query' value='$query'>\n";
		$hidden.="<input type='hidden' name='indexfield' value='$indexfield'>\n";
		$hidden.="<input type='hidden' name='secondfield' value='$secondfield'>\n";
		$hidden.="<input type='hidden' name='di_name' value='$di_name'>\n";
		$hidden.="<input type='hidden' name='di_long' value='$di_long'>\n";
		$hidden.="<input type='hidden' name='di_short' value='$di_short'>\n";
		//$hidden.="<input type='hidden' name='pz_current_tab' value=''>\n";
		
		echo "<table cellpadding='0' cellspacing='0' border='0'>\n";
		echo "<tr><td>\n";
		echo "Script du code\n";
		echo "</td><td>\n";
		echo "<input type='button' value='Voir' onClick='window.open(\"source.php?file=tmp_code.php\")'>\n";
		echo "</td></tr>\n";
		echo "<tr><td>\n";
		echo "Script de la page\n";
		echo "</td><td>\n";
		echo "<input type='button' value='Voir' onClick='window.open(\"source.php?file=tmp_page.php\")'>\n";
		echo "</td></tr>\n";
//		echo "<tr><td>\n";
//		echo "Script tout en un\n";
//		echo "</td><td>\n";
//		echo "<input type='button' value='Voir' onClick='window.open(\"source.php?file=tmp_single.php\")'>\n";
//		echo "</td></tr>\n";
//		echo "<tr><td>\n";
//		echo "Script de la grille\n";
//		echo "</td><td>\n";
//		echo "<input type='button' value='Voir' onClick='window.open(\"source.php?file=tmp_browse.php\")'>\n";
//		echo "</td></tr>\n";
//		echo "<tr><td>\n";
//		echo "Script du formulaire\n";
//		echo "</td><td>\n";
//		echo "<input type='button' value='Voir' onClick='window.open(\"source.php?file=tmp_form.php\")'>\n";
//		echo "</td></tr>\n";
//		echo "<tr><td>\n";
//		echo "<tr><td>Script d'ajout\n";
//		echo "</td><td>\n";
//		echo "<input type='button' value='Voir' onClick='window.open(\"source.php?file=tmp_insert.php\")'>\n";
//		echo "</td></tr>\n";
//		echo "<tr><td>\n";
//		echo "<tr><td>Script de mise à jour\n";
//		echo "</td><td>\n";
//		echo "<input type='button' value='Voir' onClick='window.open(\"source.php?file=tmp_update.php\")'>\n";
//		echo "</td></tr>\n";
//		echo "<tr><td>\n";
//		echo "<tr><td>Script de suppression\n";
//		echo "</td><td>\n";
//		echo "<input type='button' value='Voir' onClick='window.open(\"source.php?file=tmp_delete.php\")'>\n";
//		echo "</td></tr>\n";
		echo "</table>\n";
		//$source=highlight_php($script, true);
		//echo "<p><input type='button' value='Tester le script tout en un' onClick='window.open(\"/$userdb/page.php?id=$catalog&lg=fr\")'></p>\n";
		
		echo $message;
		
		echo "<form name='myForm' method='POST' action='page.php?id=33&lg=$lg'>\n";
		echo $hidden;
		//echo "<div style='text-align:left;width:680px;height:500px;background:white;overflow:scroll'>$source</div><br>\n";
		
		echo "<input type='button' name='previous' value='<< Précédent' onClick='document.myForm.action=\"page.php?id=32&lg=$lg\";document.myForm.submit();'>\n";
		echo "<input type='submit' name='save' value='" . YES . "'>\n";
		echo "<input type='submit' name='save' value='" . NO . "'>\n";
		echo "</form>\n";
	}
	
    if ($save!=="") {
		$indexfield = get_variable("indexfield");
		$secondfield = get_variable("secondfield");
		$pa_id = get_variable("pa_id");
		$me_id = get_variable("me_id");
	
        if ($dbgrid=="0") {
            $props="Grille";
        } else {
            $props="Grille + Fiche";
        }
        if ($filter=="1") {
            $props.=" + Filtre";
        }
        if ($addoption=="1") {
            $props.=" + Bouton Ajouter";
        }

        if ($me_id=="") {
            $mindex="Auto-incrémenté";
        } else {
            $mindex=$me_id;
        }
            
        if ($save=="Oui") {
            // if (($me_id == 0 || $pa_id == 0) && $autogen == 1) {
            //     list($me_id, $pa_id) = add_menu_and_page(
            //     $userdb,
            //     $di_name,
            //     $me_level,
            //     'page',
            //     $rel_page_filename,
            //     $di_short,
            //     $di_long);
            // }

            //$pa_filename.=$extension;
            // $pa_filename=$wwwroot.$basedir.'/'.$pa_filename;
    
            // copy('tmp_single.php', $pa_filename.$extension);
            // copy('tmp_page.php', $pa_filename.$extension);
            // copy('tmp_code.php', $pa_filename.'_code'.$extension);

            copy('tmp_code.php', $root_code_filename);
            copy('tmp_page.php', $root_page_filename);

            // copy('tmp_browse.php', $pa_filename.'_browse'.$extension);
            // copy('tmp_form.php', $pa_filename.'_form'.$extension);
            // copy('tmp_insert.php', $pa_filename.'_insert'.$extension);
            // copy('tmp_update.php', $pa_filename.'_update'.$extension);
            // copy('tmp_delete.php', $pa_filename.'_delete'.$extension);
            // if(!isset($me_level)) $me_level="1";
            // $di_name=$usertable;
            // $di_fr_short=strtoupper(substr($usertable,0,1)).substr($usertable, 1, strlen($usertable)-1);
            // $di_fr_long="Liste des $usertable";


            $sstatus="Page enregistré";

        } elseif ($save=="Non") {
			$sstatus="Page non-enregistré";
			delete_menu($userdb, $di_name);

			if(file_exists($root_code_filename)) {
				unlink($root_code_filename);
			}
			if(file_exists($root_page_filename)) {
				unlink($root_page_filename);
			}
        }
		unlink('tmp_code.php');
		unlink('tmp_page.php');

        $mk_file="
		<fieldset style='width:450px;'>\n
		<legend>Récapitulatif des opérations</legend>
		<table border='0' bordercolor='0' width='85%' valign='top' style='display:hidden;'>\n
		<tr><td>\n
		<table border='0' cellspacing='0' cellpadding='0'>\n
		<tr><td><b>Base de données : </b></td><td>$userdb</td></tr>\n
		<tr><td><b>Table : </b></td><td>$usertable</td></tr>\n
		<tr><td><b>Propriétés du script : </b></td><td>$props</td></tr>\n
		<tr><td><b>Répertoire : </b></td><td>$wwwroot$basedir</td></tr>\n
		<tr><td><b>Nom du fichier : </b></td><td>$rel_page_filename</td></tr>\n
		<tr><td><b>Index du menu : </b></td><td>$me_id</td></tr>\n
		<tr><td><b>Index de page : </b></td><td>$pa_id</td></tr>\n
		<tr><td><b>Niveau du menu : </b></td><td>$me_level</td></tr>\n
		<tr><td><b>Bloc du menu : </b></td><td>$bl_id</td></tr>\n
		<tr><td><b>Index de dictionaire : </b></td><td>$di_name</td></tr>\n
		<tr><td><b>Libellé court : </b></td><td>$di_short</td></tr>\n
		<tr><td><b>Libellé long : </b></td><td>$di_long</td></tr>\n
		<tr><td><b>Le script existait déjà : </b></td><td>$script_exists_tostring</td></tr>\n
		<tr><td><b>Etat du script : </b></td><td>$sstatus</td></tr>\n
		</table>\n
		</td></tr>\n
		<tr><td align='center'>\n
		<input type='submit' name='save' value='Terminer'>\n
		</td></tr>\n
		</table>\n
		</fieldset>\n
		";
        
        echo "<form name='myForm' method='POST' action='page.php?id=17&lg=$lg'>\n";
        echo $mk_file;
        echo "</form>\n";
    }
?>
</center>
