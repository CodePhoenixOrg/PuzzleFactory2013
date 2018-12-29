<?php   
/*
iPuzzle.WebPieces
Copyright (C) 2004 David Blanchard

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*/

/*
 FONCTIONS DECLAREES DANS CE FICHIER


 mysqli_field_name($result, $i)
 mysqli_field_len($result, $i)
 mysqli_field_type($result, $i)
 est_assigne($valeur="")
 sans_espace($chaine="")
 enquote($valeur="")
 est_numerique($champ="", $valeur="", $debug=false)
 options($champ="", $table="", $like="", $orderby="", $defaut="", $defaut_seulement=false)
 options_concat($champ1="", $separe="", $champ2="", $champ, $table="", $like="", $orderby="", $defaut="", $defaut_seulement=false)
 options_select($champ_id, $valeur_id, $champ="", $index, $table="", $orderby="", $defaut="", $defaut_seulement=false
 options_sql($sql, $defaut="", $defaut_seulement=false)
 from_tables($tables="", $clause_from="")
 where_jointures($jointures="", $clause_where="")
 where_unique_arg($nom_arg="", $valeur="", $clause_where="")
 where_liste_args($nom_arg="", $liste="", $clause_where="")
 where_intervalle_args($nom_arg="", $val_basse="", $val_haute="", $clause_where="")
 OpenDialog($url, $hauteur, $largeur)
 tableau_sql($sql="", $page_lien="", $id=0, $index_fieldname="", $image_lien="", $compl_url="", $dialog, $largeurs_cols, $conn)
 fiche_sql($sql="", $page_lien="", $id=0, $index_fieldname="", $image_lien="", $compl_url="", $dialog, $titre, $largeurs_cols, $conn) 
*/
global $mysqli_types, $mysqli_html_types;

$mysqli_types[1] = "TINYINT";
$mysqli_types[2] = "SMALLINT";
$mysqli_types[3] = "INT";
$mysqli_types[4] = "FLOAT";
$mysqli_types[5] = "DOUBLE";
$mysqli_types[7] = "TIMESTAMP";
$mysqli_types[8] = "BIGINT";
$mysqli_types[9] = "MEDIUMINT";
$mysqli_types[10] = "DATE";
$mysqli_types[11] = "TIME";
$mysqli_types[12] = "DATETIME";
$mysqli_types[13] = "YEAR";
$mysqli_types[16] = "BIT";
$mysqli_types[246] = "DECIMAL";
$mysqli_types[252] = "BLOB";
$mysqli_types[253] = "VARCHAR";
$mysqli_types[254] = "CHAR";

$mysqli_php_types["TINYINT"] = "int";
$mysqli_php_types["SMALLINT"] = "int";
$mysqli_php_types["INT"] = "int";
$mysqli_php_types["FLOAT"] = "float";
$mysqli_php_types["DOUBLE"] = "float";
$mysqli_php_types["TIMESTAMP"] = "int";
$mysqli_php_types["BIGINT"] = "int";
$mysqli_php_types["MEDIUMINT"] = "int";
$mysqli_php_types["DATE"] = "date";
$mysqli_php_types["TIME"] = "time";
$mysqli_php_types["DATETIME"] = "datetime";
$mysqli_php_types["YEAR"] = "year";
$mysqli_php_types["BIT"] = "int";
$mysqli_php_types["DECIMAL"] = "float";
$mysqli_php_types["BLOB"] = "blob";
$mysqli_php_types["VARCHAR"] = "string";
$mysqli_php_types["CHAR"] = "char";

$mysqli_html_types[1] = "int";
$mysqli_html_types[2] = "int";
$mysqli_html_types[3] = "int";
$mysqli_html_types[4] = "float";
$mysqli_html_types[5] = "float";
$mysqli_html_types[7] = "int";
$mysqli_html_types[8] = "int";
$mysqli_html_types[9] = "int";
$mysqli_html_types[10] = "date";
$mysqli_html_types[11] = "time";
$mysqli_html_types[12] = "datetime";
$mysqli_html_types[13] = "year";
$mysqli_html_types[16] = "int";
$mysqli_html_types[246] = "float";
$mysqli_html_types[252] = "blob";
$mysqli_html_types[253] = "string";
$mysqli_html_types[254] = "char";


function mysqli_to_string($type) {
	global $mysqli_types;

	return $mysqli_types[$type];
}

function mysqli_to_php($type) {
	global $mysqli_php_types;

	return $mysqli_php_types[$type];
}

function mysqli_to_html($type) {
	global $mysqli_html_types;

	return $mysqli_html_types[$type];
}

function mysqli_field_name($result, $i) {
	$field_info = $stmt->fetch_field_direct($i);
	return $field_info->name;
}

function mysqli_field_len($result, $i) {
	$field_info = $stmt->fetch_field_direct($i);
	return $field_info->length;
}

function mysqli_field_type($result, $i) {
	$field_info = $stmt->fetch_field_direct($i);
	return $field_info->type;
}

function pdo_field_name($stmt, $i)
{
	return $stmt->getColumnMeta($i)['name'];
}

function pdo_field_type($stmt, $i)
{
	return $stmt->getColumnMeta($i)['pdo_type'];
}

function pdo_field_len($stmt, $i)
{
	return $stmt->getColumnMeta($i)['len'];
}


$my_max_file_size    = "102400";    // in bytes 
$image_max_width    = "300";    // in pixels 
$image_max_height    = "300";    // in pixels 
$the_path    = "../graphic/"; 

$registered_types = array("application/x-gzip-compressed" => ".tar.gz, .tgz", 
                   "application/x-zip-compressed"  => ".zip", 
                   "application/x-tar"           => ".tar", 
                   "text/plain"               => ".html, .php, .txt, .inc", 
                   "image/gif"                     => ".gif", 
                   "image/pjpeg"                   => ".jpg, .jpeg", 
                   "image/jpeg"                   => ".jpg, .jpeg", 
                   "image/bmp"                    => ".bmp", 
                   "application/octet-stream"      => ".exe"); 
$allowed_types = array("application/x-gzip-compressed", 
                "application/x-zip-compressed", 
                "text/plain", 
                "image/gif", 
                "image/pjpeg", 
                "image/jpeg",
		"image/bmp"); 

$champ_obligatoire = "<span face=verdana color=red size=4><b>*</b></span>";

/*
============================================= function est_assigne() ======================================================= 

Verifie si la variable passée en paramètre a une valeur différente de rien
*/

function est_assigne($valeur="") {
	if(is_array($valeur)) {
		$chaine=implode(" ", $valeur);
		$chaine=trim($chaine);
	} else 
		$chaine=trim($valeur);

	$res=$chaine!='';

	return $res;
}

/*
=================================================== function enquote() =====================================================

Place des guillemets (quotes) autour de la valeur si celle-ci est de type chaine de caractères ou dates
*/

function enquote($valeur="") {
	/*
	$numval=0;
	$numval=intval($valeur);

	$charpos=strpos($valeur, "0");
	
	if(($numval==0 && valeur!="") || strpos($valeur, "/")!="" || strpos($valeur, "-")!="")
		$valeur = "'" . $valeur . "'";
	*/
	$valeur=$valeur;
	if($valeur!="") $valeur="'$valeur'";
	
	return $valeur;
}

/*
=============================================== function sans_espace() =====================================================
*/

function sans_espace($chaine="") {
	$chaine=str_replace(" ","", $chaine);
	return $chaine;
}

/*
================================================= function est_numerique() =================================================

Teste si la valeur passée à $valeur du champ $champ est numérique. Si oui la fonction renvoie VRAI, si non elle renvoie FAUX en affichant éventuellement un message d'erreur si $debug est VRAI
*/

function est_numerique($champ="", $valeur="", $debug=false) {

	$res=false;
	if($valeur!="") {
		$res=1;
		$valeur=sans_espace($valeur);
		$lower=strtolower($valeur);
		$upper=strtoupper($valeur);

		if($valeur!=$lower || $valeur!=$upper) 
			$res=false;
		else {		
			$numeric=0;
			$numeric = intval($valeur);
			$res=$numeric>0;
		}
	}
	
	if($debug && !$res)
       		echo "<center><span face=verdana size=3><b>Le champ $champ ne doit contenir que des chiffres</b></span></center><br>";
	
	return $res;
}

/*
====================================================== function options() ==================================================

Crée dynamiquement une liste d'options pour la balise HTML <SELECT></SELECT> sur la base de données MySQL en cours de connexion. La liste est le résultat de la requête SQL : 
SELECT $champ FROM $table WHERE $champ LIKE '$like%' ORDER BY $orderby
Si $defaut est attribuée la valeur est sélectionnée avec le tag <OPTION SELECTED>$defaut</OPTION>.
*/
function sql_options($champ="", $table="", $like="", $orderby="", $defaut="", $defaut_seulement=false, $cs) {
	$liste="";
	$defaut=trim($defaut);
	//$defaut=strtoupper($defaut);
	$liste="";

	if (!empty($like)) $where_field_like=" where $champ like '$like%'";
	
	if (!empty($orderby))
		$order_by_field=" order by $orderby";
	else
		$order_by_field=" order by $champ";

	if(!$defaut_seulement) {
		/*
		if($defaut=="")	
			$liste="<OPTION SELECTED></OPTION>";
		else
			$liste="<OPTION></OPTION>";
		*/
		$sql="select $champ from $table$where_field_like$order_by_field";
		$stmt = $cs->query($sql);
		while ($lignes=$stmt->fetch()) {
			$option=$lignes[0];
			//$option=strtoupper($option);
			if($option==$defaut)
				$liste=$liste . "<OPTION SELECTED VALUE=\"$option\">" . $defaut . "</OPTION>";
			else
				$liste=$liste . "<OPTION VALUE=\"$option\">" . $option . "</OPTION>";
		}
	}
	else 
		if($defaut!="")	$liste="<OPTION SELECTED>". $defaut . "</OPTION>";
	
	return $liste;
}


function options($champ="", $table="", $like="", $orderby="", $defaut="", $defaut_seulement=false) {
	$liste="";
	$defaut=trim($defaut);
	//$defaut=strtoupper($defaut);
	$liste="";

	if (!empty($like)) $where_field_like=" where $champ like '$like%'";
	
	if (!empty($orderby))
		$order_by_field=" order by $orderby";
	else
		$order_by_field=" order by $champ";

	if(!$defaut_seulement) {
		/*
		if($defaut=="")	
			$liste="<OPTION SELECTED></OPTION>";
		else
			$liste="<OPTION></OPTION>";
		*/
		$sql="select $champ from $table$where_field_like$order_by_field";
		$stmt = $cs->query($sql);
		while ($lignes=$stmt->fetch()) {
			$option=$lignes[0];
			//$option=strtoupper($option);
			if($option==$defaut)
				$liste=$liste . "<OPTION SELECTED VALUE=\"$option\">" . $defaut . "</OPTION>";
			else
				$liste=$liste . "<OPTION VALUE=\"$option\">" . $option . "</OPTION>";
		}
	}
	else 
		if($defaut!="")	$liste="<OPTION SELECTED>". $defaut . "</OPTION>";
	
	return $liste;
}

/*
=============================================== function options_concat() ==================================================

Crée dynamiquement une liste d'options pour la balise HTML <SELECT></SELECT> sur la base de données MySQL en cours de connexion. La liste est le résultat de la requête SQL : 
SELECT CONCAT($champ1, "$separe", $champ2) as '$champ' FROM $table WHERE $champ LIKE '$like%' ORDER BY $orderby
Si $defaut est attribuée la valeur est sélectionnée avec le tag <OPTION SELECTED>$defaut</OPTION>.
*/

function sql_options_concat($champ1="", $separe="", $champ2="", $champ, $table="", $like="", $orderby="", $defaut="", $defaut_seulement=false, $cs) {
	$liste="";
	$defaut=trim($defaut);
	//$defaut=strtoupper($defaut);
	$liste="";

	if (!empty($like)) $where_field_like=" where $champ like '$like%'";
	
	if (!empty($orderby))
		$order_by_field=" order by $orderby";
	else
		$order_by_field=" order by $champ";

	if(!$defaut_seulement) {
		/*
		if($defaut=="")	
			$liste="<OPTION SELECTED></OPTION>";
		else
			$liste="<OPTION></OPTION>";
		*/
		//$separe=urldecode($separe);
		$sql="select $champ1, '$separe', $champ2 from $table$where_field_like$order_by_field";

		//echo "$sql<br>";

		$stmt = $cs->query($sql);
		while ($lignes=$stmt->fetch()) {
			$valeur1=$lignes[0];
			$separe=$lignes[1];
			$valeur2=$lignes[2];
			$concat=$valeur1.$separe.$valeur2;
			//$option=strtoupper($option);
			if($valeur1==$defaut)
				$liste=$liste . "<OPTION SELECTED VALUE=\"$valeur1\">" . $concat . "</OPTION>";
			else
				$liste=$liste . "<OPTION VALUE=\"$valeur1\">" . $concat . "</OPTION>";
		}
	}
	else 
		if($defaut!="")	$liste="<OPTION SELECTED>". $defaut . "</OPTION>";
	
	return $liste;
}

function options_concat($champ1="", $separe="", $champ2="", $champ, $table="", $like="", $orderby="", $defaut="", $defaut_seulement=false) {
	$liste="";
	$defaut=trim($defaut);
	//$defaut=strtoupper($defaut);
	$liste="";

	if (!empty($like)) $where_field_like=" where $champ like '$like%'";
	
	if (!empty($orderby))
		$order_by_field=" order by $orderby";
	else
		$order_by_field=" order by $champ";

	if(!$defaut_seulement) {
		/*
		if($defaut=="")	
			$liste="<OPTION SELECTED></OPTION>";
		else
			$liste="<OPTION></OPTION>";
		*/
		//$separe=urldecode($separe);
		$sql="select $champ1, '$separe', $champ2 from $table$where_field_like$order_by_field";

		//echo "$sql<br>";

		$stmt = $cs->query($sql);
		while ($lignes=$stmt->fetch()) {
			$valeur1=$lignes[0];
			$separe=$lignes[1];
			$valeur2=$lignes[2];
			$concat=$valeur1.$separe.$valeur2;
			//$option=strtoupper($option);
			if($valeur1==$defaut)
				$liste=$liste . "<OPTION SELECTED VALUE=\"$valeur1\">" . $concat . "</OPTION>";
			else
				$liste=$liste . "<OPTION VALUE=\"$valeur1\">" . $concat . "</OPTION>";
		}
	}
	else 
		if($defaut!="")	$liste="<OPTION SELECTED>". $defaut . "</OPTION>";
	
	return $liste;
}

/*
================================================= function options_select() ===============================================
Crée dynamiquement une liste d'options pour la balise HTML <SELECT></SELECT> sur la base de données MySQL en cours de connexion. La liste est le résultat de la requête SQL : 
SELECT $champ FROM $table WHERE $champ_id=$valeur_id AND $champ LIKE '$like%' ORDER BY $orderby
*/

function options_select($champ_id, $valeur_id, $champ="", $index, $table="", $orderby="", $defaut="", $defaut_seulement=false) {
	$liste="";
	$defaut=trim($defaut);
	//$defaut=strtoupper($defaut);
	$liste="";

	if (!empty($like)) $where_field_like=" $champ like '$like%'";
	
	if (!empty($orderby))
		$order_by_field=" order by $orderby";
	else
		$order_by_field=" order by $champ";

	if(!$defaut_seulement) {
		/*
		if($defaut=="")	
			$liste="<OPTION SELECTED></OPTION>";
		else
			$liste="<OPTION></OPTION>";
		*/
		$sql="select $champ from $table where $champ_id=$valeur_id$where_field_like$order_by_field";
		$stmt = $cs->query($sql);
		while ($lignes=$stmt->fetch()) {
			$option=$lignes[0];
			//$option=strtoupper($option);
			if($option==$defaut)
				$liste=$liste . "<OPTION SELECTED>" . $defaut . "</OPTION>";
			else
				$liste=$liste . "<OPTION>" . $option . "</OPTION>";
		}
	}
	else 
		if($defaut!="")	$liste="<OPTION SELECTED>". $defaut . "</OPTION>";
	
	return $liste;
}

/*
=============================================== function options_sql() ==================================================

Crée dynamiquement une liste d'options pour la balise HTML <SELECT></SELECT> sur la base de données MySQL en cours de connexion. La liste est le résultat de la requête SQL passée à $sql.
Si $defaut est attribuée la valeur est sélectionnée avec le tag <OPTION SELECTED>$defaut</OPTION>.
*/

function options_sql($sql, $defaut="", $defaut_seulement=false) {
	$liste="";
	$defaut=trim($defaut);
	//$defaut=strtoupper($defaut);
	$liste="";

	if(!$defaut_seulement) {
		/*
		if($defaut=="")	
			$liste="<OPTION SELECTED></OPTION>";
		else
			$liste="<OPTION></OPTION>";
		*/
		$stmt = $cs->query($sql);
		while ($lignes=$stmt->fetch()) {
			$option=$lignes[0];
			//$option=strtoupper($option);
			if($option==$defaut)
				$liste=$liste . "<OPTION SELECTED>" . $defaut . "</OPTION>";
			else
				$liste=$liste . "<OPTION>" . $option . "</OPTION>";
		}
	}
	else 
		if($defaut!="")	$liste="<OPTION SELECTED>". $defaut . "</OPTION>";
	
	return $liste;
}

/*
=============================================== function array_sql() ==================================================

Crée dynamiquement une variable tableau PHP (array), sur la base de données MySQL en cours de connexion.
La liste des valeurs est le résultat de la requête SQL passée à $sql.
*/

function sql_array($sql, $conn) {
	$liste="";

	$result=$cs->query($sql, $conn);
	while($rows=$stmt->fetch()) {
		$liste.=$rows[0] . ",";
	}

	$liste=substr($liste,0,strlen($liste)-1);
	$tableau=explode(",", $liste);
	
	return $tableau;
}

/*
=============================================== function array_sql() ==================================================

Crée dynamiquement une chaine de valeurs séparées par des virugles, sur la base de données MySQL en cours de connexion.
La liste des valeurs est le résultat de la requête SQL passée à $sql.
*/

function sql_list($sql, $conn) {
	$liste="";

	$result=$cs->query($sql, $conn);
	while($rows=$stmt->fetch()) {
		$liste.=$rows[0] . ",";
	}

	$liste=substr($liste,0,strlen($liste)-1);
	
	return $liste;
}

/*
============================================ function select_champs() ======================================================

Construit la clause SELECT d'une requête SQL indépendemment de celle-ci en prenant soin d'éviter les doublons si les paramètres $champs et $clause_select ont des champs en commun. Le résultat du traitement s'ajoute à la clause SELECT $clause_select déjà construite et renvoie celle-ci en sortie
*/

function select_champs($champs="", $clause_select="") {

	$champs=strtolower($champs);
	$clause_select=strtolower($clause_select);
	$clause_select=" " . trim($clause_select);

	$liste=explode(",", $champs); 
	$count=count($liste);
	for($i=0; $i<$count; $i++) {
		$element=trim($liste[$i]);
		$pos=strpos($clause_select, $element);
		if($clause_select==" ")
			$clause_select=" " . $element;
		else
			if($pos=="") $clause_select=$clause_select . ", " . $element;
	}

	return $clause_select;
}

/*
================================================ function from_tables() ====================================================

Construit la clause FROM d'une requête SQL indépendemment de celle-ci en prenant soin d'éviter les doublons si les paramètres $tables et $clause_from ont des tables en commun. Le résultat du traitement s'ajoute à la clause FROM $clause_from déjà construite et renvoie celle-ci en sortie
*/

function from_tables($tables="", $clause_from="") {

	$tables=strtolower($tables);
	$clause_from=strtolower($clause_from);
	$clause_from=" " . trim($clause_from);

	$liste=explode(",", $tables); 
	$count=count($liste);
	for($i=0; $i<$count; $i++) {
		$element=trim($liste[$i]);
		$pos=strpos($clause_from, $element);
		if($clause_from==" ")
			$clause_from=" " . $element;
		else
			if($pos=="") $clause_from=$clause_from . ", " . $element;
	}

	return $clause_from;
}

/*
=============================================== function where_jointures() =================================================

Construit la partie jointures de la clause WHERE d'une requête SQL indépendemment de celle-ci en prenant soin d'éviter les doublons si les paramètres $jointures et $clause_where ont des jointures en commun. Le résultat du traitement s'ajoute à la clause WHERE $clause_where déjà construite et renvoie celle-ci en sortie
*/

function where_jointures($jointures="", $clause_where="") {

	$liste=strtolower($jointures);
	$clause_where=strtolower($clause_where);
	$clause_where=" " . trim($clause_where);
	
	$liste = explode(" and ", $liste); 
	$count=count($liste);

	for($i=0; $i<$count; $i++) {
		$element=trim($liste[$i]);
		$pos=strpos($clause_where, $element);
		if($clause_where==" ")
			$clause_where=" " . $element;
		else
			if($pos=="") $clause_where=$clause_where . " and " . $element;
	}

	return $clause_where;
}

/*
============================================ function where_unique_arg() ===================================================

Construit la partie d'évaluation de paramètres de la clause WHERE d'une requête SQL indépendemment de celle-ci avec un argument $nom_arg acceptant une valeur $valeur unique. Le résultat du traitement s'ajoute à la clause WHERE $clause_where déjà construite et renvoie celle-ci en sortie
*/

function where_unique_arg($nom_arg="", $valeur="", $clause_where="") {
	$valeur = enquote($valeur);
	
	$arg="";
	
	if($valeur!="''")
		$arg=$nom_arg . "=" . $valeur;

	$arg=trim($arg);
	if($arg!="") {
		if($clause_where!="")
			$clause_where = $clause_where . " and " . $arg;
		else
			$clause_where = $arg;
	}
	return $clause_where;
}

/*
=============================================== function where_liste_args() ================================================

Construit la partie d'évaluation de paramètres de la clause WHERE d'une requête SQL indépendemment de celle-ci avec un argument $nom_arg acceptant une liste de valeurs comprise dans $liste. Le résultat du traitement s'ajoute à la clause WHERE $clause_where déjà construite et renvoie celle-ci en sortie
*/

function where_liste_args($nom_arg="", $liste="", $clause_where="") {
	$count=count($liste);

	if($count==0)
		$arg="";
	else if($count==1) {
		if(trim($liste[0])!="")
			$arg = $nom_arg . "=" . enquote($liste[0]);
		else 
			$arg="";
	} else if($count>1) {
		for($i=0; $i<$count; $i++) {
			$element=trim($liste[$i]);
			$element=enquote($element);
			if($element!="''") {
				if(!isset($ensemble))
					$ensemble=$element;
				else
					$ensemble=$ensemble . ", " . $element;
			}
		}
		if(trim($ensemble!="''" && $ensemble!=""))
			$arg=$nom_arg . " in (" . $ensemble . ")";
	}

	$arg=trim($arg);
	if($arg!="") {
		if($clause_where!="")
			$clause_where = $clause_where . " and " . $arg;
		else
			$clause_where = $arg;
	}
	
	return $clause_where;
}

/* 
========================================= function where_intervalle_args() =================================================

Construit la partie d'évaluation de paramètres de la clause WHERE d'une requête SQL indépendemment de celle-ci avec un argument $nom_arg acceptant un intervalle de valeurs comprises entre la valeur basse $val_basse et la valeur haute $val_haute. Le résultat du traitement s'ajoute à la clause WHERE $clause_where déjà construite et renvoie celle-ci en sortie
*/

function where_intervalle_args($nom_arg="", $val_basse="", $val_haute="", $clause_where="") {
	$val_basse=enquote($val_basse);
	$val_haute=enquote($val_haute);
	
	if($val_basse=="") 
		$clause_where = "ERREUR ! La valeur basse du critère $nom_arg n'est pas renseignée !<br>" .
				"Vous pouvez omettre la valeur haute de l'intervalle mais pas la valeur basse.<br>";
	else {
		if($val_haute=="")
			$arg=$val_basse;
		else if($val_basse!="" && $val_haute!="")
			$arg="(" . $nom_arg . " between " . $val_basse . " and " . $val_haute . ")";

		$arg=trim($arg);
		if($arg!="") {
			if($clause_where!="")
				$clause_where = $clause_where . " and " . $arg;
			else
				$clause_where = $clause_where . $arg;
		}
	}
	
	return $clause_where;
}

/*
=================================================function OpenDialog()====================================================== 
*/
function OpenDialog($url, $hauteur, $largeur) {
	/*
	$dialog = 
		"window.showModelessDialog(".
			"'$url', ".
			"'', ".
			"'dialogWidth:". $largeur ."px; ".
			"dialogHeight:". $hauteur ."px; ".
			"status:no; ".
			"center:yes'".
		")";
	*/
	$dialog = 
		"window.open(".
			"'$url', ".
			"'', ".
			"'width=". $largeur .", ".
			"height=". $hauteur .", ".
			"menubar=no, ".
			"location=no, ".
			"resizable=no, ".
			"scrollbars=yes, ".
			"status=no, ".
			"toolbar=no'".
		")";
	return $dialog;
}

/*
================================================ function tableau_sql() ====================================================

Dessine un tableau dont les informations sont le resultat d'une requête SQL passée à $sql. Les parametres $page_lien et $image_lien sont utilisés pour la premiere colonne. Si $image_lien est vide, la valeur affichée est celle du champ d'index.
*/

function tableau_sql(
	$name="",
	$sql="", 
	$id=0, 
	$page_lien="", 
	$image_lien="", 
	$compl_url="", 
	$dialog, 
	$largeurs_cols, 
	$couleurs, 
	$conn
) {

	if(!empty($couleurs)) {
		$coul_entete=$couleurs[0];
		$coul_ligne_paire=$couleurs[1];
		$coul_ligne_impaire=$couleurs[2];
	} else {
		$coul_entete="#DDD7CF";
		$coul_ligne_paire="#CCDDE6";
		$coul_ligne_impaire="#DDEEF6";
	}

	$stmt = $cs->query($sql, $conn);
	$num=$cs->num_rows($stmt);
	//if($num) {
		$nb_largeurs=count($largeurs_cols);
		$i=$cs->num_fields($stmt);
		if($nb_largeurs<$i) {
			
			$j=$i-$nb_largeurs;
			$a=array_fill($nb_largeurs, $j, 0);
			$largeurs_cols=array_merge($largeurs_cols, $a);
		}
		
		echo "<table id='$name' border=0 cellpadding=2 cellspacing=1 bordercolor='#FFFFFF'>";
		echo "<tr bgcolor='$coul_entete'>";
		$index_fieldname=$cs->field_name($stmt, 0);
		for($j=0; $j<$i; $j++) {
			$fieldname=$cs->field_name($stmt, $j);
			$tag_width="";
			if($largeurs_cols[$j]!=0) $tag_width=" width='".$largeurs_cols[$j]."'";
			if($image_lien!="" && $j==0) $fieldname="";
			echo "<td align=center$tag_width'><span style='color:#000000'><b>$fieldname<b></span></td>";
		}
		echo "</tr>";
		$r=0;
		while($rows=$stmt->fetch()) {
			$r++;
			$r1=$r/2;
			$r2=round($r1);
			if($r1==$r2)
				echo "<tr bgcolor='$coul_ligne_paire'>";
			else
				echo "<tr bgcolor='$coul_ligne_impaire'>";
			for($j=0; $j<$i; $j++) {
				$field=$rows[$j];	
				$fieldtype=$cs->field_type($stmt, $j);
				$fieldlen=$cs->field_len($stmt, $j);
					
				$url="$page_lien?id=$id&$index_fieldname=" . $rows[0] . "&action=Modifier";
				if(!empty($compl_url)) $url.=$compl_url;
				$tag_width="";
				if($largeurs[$j]!=0) $tag_width=" width='".$largeurs[$j]."'";
				
				if($j==0) {
					if($image_lien!="") $field="<img border='0' src='$image_lien'>";
					$tag_align=" align='center'";
					if(!empty($dialog)) {
						$OnClick=OpenDialog($url, $dialog[0], $dialog[1]);
						echo "<td bgcolor='$coul_entete' align=center><input type='image' src='img/Editer.png' height='16' width='16' onClick=\"$OnClick\"></td>";
					} else 					
						echo "<td$tag_align$tag_width><a href='$url'>$field</a></td>";

				} else {
					if($fieldtype=="date") $field = preg_replace('^([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})$', '\3/\2/\1', $field);
					$tag_align=" align='left'";
					if($fieldtype=="int") $tag_align=" align='right'";
					if($fieldlen < 5) $tag_align=" align='center'";
					echo "<td$tag_align$tag_width>$field</td>";
				}
			}
			echo "</tr>";
		}
		echo "</table>";

		$cs->free_result($stmt);
	//}

	return $num;
}

/*
================================================ function tableau_sql() ====================================================

Dessine un tableau dont les informations sont le resultat d'une requête SQL passée à $sql. Les parametres $page_lien et $image_lien sont utilisés pour la premiere colonne. Si $image_lien est vide, la valeur affichée est celle du champ d'index.
*/

function tableau_sql_scroll(
	$name="",
	$sql="", 
	$id=0, 
	$page_lien="", 
	$image_lien="", 
	$compl_url="", 
	$dialog, 
	$largeurs_cols, 
	$couleurs, 
	$conn
) {

	if(!empty($couleurs)) {
		$coul_entete=$couleurs[0];
		$coul_ligne_paire=$couleurs[1];
		$coul_ligne_impaire=$couleurs[2];
	} else {
		$coul_entete="#DDD7CF";
		$coul_ligne_paire="#CCDDE6";
		$coul_ligne_impaire="#DDEEF6";
	}

	$stmt = $cs->query($sql, $conn);
	$num=$cs->num_rows($stmt);
	//if($num) {
		$nb_largeurs=count($largeurs_cols);
		$i=$cs->num_fields($stmt);
		if($nb_largeurs<$i) {
			
			$j=$i-$nb_largeurs;
			$a=array_fill($nb_largeurs, $j, 0);
			$largeurs_cols=array_merge($largeurs_cols, $a);
		}
		/*
		foreach($largeurs as $lar) {
			$l++;
			echo "largeur$l = $lar; ";
		}*/
		
		//echo "<div id='cnt_$name' style='Z-INDEX:1;BACKGROUND:black;VISIBILITY:hidden;CLIP:rect(0px 0px 0px 0px);POSITION:absolute'>";
		echo "<div id='cnt_$name' style='Z-INDEX:1;BACKGROUND:black;POSITION:absolute'>";
		echo "<form method='post' id='form_$name'>";
		echo "<table id='$name' border=0 cellpadding=2 cellspacing=1 bordercolor='#FFFFFF'>";
		echo "<tr bgcolor='$coul_entete'>";
		$index_fieldname=$cs->field_name($stmt, 0);
		for($j=0; $j<$i; $j++) {
			$fieldname=$cs->field_name($stmt, $j);
			$tag_width="";
			if($largeurs_cols[$j]!=0) $tag_width=" width='".$largeurs_cols[$j]."'";
			if($image_lien!="" && $j==0) $fieldname="";
			echo "<td align=center$tag_width'><span style='color:#000000'><b>$fieldname<b></span></td>";
		}
		echo "</tr>";
		$r=0;
		while($rows=$stmt->fetch()) {
			$r++;
			$r1=$r/2;
			$r2=round($r1);
			if($r1==$r2)
				echo "<tr bgcolor='$coul_ligne_paire'>";
			else
				echo "<tr bgcolor='$coul_ligne_impaire'>";
			for($j=0; $j<$i; $j++) {
				$field=$rows[$j];	
				$fieldtype=$cs->field_type($stmt, $j);
				$fieldlen=$cs->field_len($stmt, $j);
					
				$url="$page_lien?id=$id&$index_fieldname=" . $rows[0] . "&action=Modifier";
				if(!empty($compl_url)) $url.=$compl_url;
				$tag_width="";
				if($largeurs[$j]!=0) $tag_width=" width='".$largeurs[$j]."'";
				
				if($j==0) {
					if($image_lien!="") $field="<img border='0' src='$image_lien'>";
					$tag_align=" align='center'";
					if(!empty($dialog)) {
						$OnClick=OpenDialog($url, $dialog[0], $dialog[1]);
						echo "<td bgcolor='$coul_entete' align=center><input type='image' src='img/Editer.png' height='16' width='16' onClick=\"$OnClick\"></td>";
					} else 					
						echo "<td$tag_align$tag_width><a href='$url'>$field</a></td>";

				} else {
					if($fieldtype=="date") $field = preg_replace('^([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})$', '\3/\2/\1', $field);
					$tag_align=" align='left'";
					if($fieldtype=="int") $tag_align=" align='right'";
					if($fieldlen < 5) $tag_align=" align='center'";
					echo "<td$tag_align$tag_width>$field</td>";
				}
			}
			echo "</tr>";
		}
		echo "</table></form></div>";

		$cs->free_result($stmt);
	//}

	return $num;
}

/*
=========================================== function tableau_sql_supp() ====================================================

Dessine un tableau dont les informations sont le resultat d'une requête SQL passée à $sql. Les parametres $page_lien et $image_lien sont utilisés pour la premiere colonne. Si $image_lien est vide, la valeur affichée est celle du champ d'index.
*/

function tableau_sql_supp(
	$name="", 
	$sql="", 
	$id=0, 
	$page_lien="", 
	$image_lien="", 
	$compl_url="",  
	$page_supp="", 
	$image_supp="", 
	$compl_url_supp="", 
	$dialog,
	$largeurs_cols, 
	$couleurs,
	$conn
) {

	if(!empty($couleurs)) {
		$coul_entete=$couleurs[0];
		$coul_ligne_paire=$couleurs[1];
		$coul_ligne_impaire=$couleurs[2];
	} else {
		$coul_entete="#DDD7CF";
		$coul_ligne_paire="#CCDDE6";
		$coul_ligne_impaire="#DDEEF6";
	}

	
	$stmt = $cs->query($sql, $conn);
	$num=$cs->num_rows($stmt);
	if($num) {
		$nb_largeurs=count($largeurs_cols);
		$i=$cs->num_fields($stmt);
		if($nb_largeurs<$i) {
			
			$j=$i-$nb_largeurs;
			$a=array_fill($nb_largeurs, $j, 0);
			$largeurs_cols=array_merge($largeurs_cols, $a);
		}
		/*
		foreach($largeurs as $lar) {
			$l++;
			echo "largeur$l = $lar; ";
		}*/
		
		echo "<table id='$name' border=0 cellpadding=2 cellspacing=1 bordercolor='#FFFFFF'>";
		echo "<tr bgcolor='$coul_entete'>";
		echo "<td>&nbsp;</td>";
		$index_fieldname=$cs->field_name($stmt, 0);
		for($j=0; $j<$i; $j++) {
			$fieldname=$cs->field_name($stmt, $j);

			$tag_width="";
			if($largeurs_cols[$j]!=0) $tag_width=" width='".$largeurs_cols[$j]."'";
			if($image_lien!="" && $j==0) $fieldname="";
			echo "<td align=center$tag_width'><span style='color:#000000'><b>$fieldname<b></span></td>";
		}
		echo "</tr>";
		$r=0;

		while($rows=$stmt->fetch()) {
			$r++;
			$r1=$r/2;
			$r2=round($r1);
			if($r1==$r2)
				echo "<tr bgcolor='$coul_ligne_paire'>";
			else
				echo "<tr bgcolor='$coul_ligne_impaire'>";
			for($j=0; $j<$i; $j++) {
				$field=$rows[$j];	
				$fieldtype=$cs->field_type($stmt, $j);
				$fieldlen=$cs->field_len($stmt, $j);
					
				$url="$page_lien?id=$id&$index_fieldname=" . $rows[0] . "&action=Modifier";
				if(!empty($compl_url)) $url.=$compl_url;
				$tag_width="";
				if($largeurs[$j]!=0) $tag_width=" width='".$largeurs[$j]."'";
				
				if($j==0) {
					if($image_lien!="") $field="<img border='0' src='$image_lien'>";
					$tag_align=" align='center'";
					if(!empty($dialog)) {
						$OnClick=OpenDialog($url, $dialog[0], $dialog[1]);
						if($image_lien=="") $image_lien="img/Editer.png";
						echo "<td bgcolor='$coul_entete' align=center><input type='image' src='$image_lien' height='16' width='16' onClick=\"$OnClick\"></td>";
					} else 					
						echo "<td$tag_align$tag_width><a href='$url'>$field</a></td>";

					$tag_align=" align='center'";
					$url="$page_supp?$index_fieldname=" . $rows[0] . $compl_url_supp;
					$OnClick=OpenDialog($url, 300, 300);
					if($image_supp=="") $image_supp="img/Supprimer.gif";
					echo "<td bgcolor='$coul_entete' align=center><input type='image' src='$image_supp' height='16' width='16' onClick=\"$OnClick\"></td>";
				} else {
					if($fieldtype=="date") $field = preg_replace('^([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})$', '\3/\2/\1', $field);
					$tag_align=" align='left'";
					if($fieldtype=="int") $tag_align=" align='right'";
					if($fieldlen < 5) $tag_align=" align='center'";
					echo "<td$tag_align$tag_width>$field</td>";
				}
			}
			echo "</tr>";
		}
		echo "</table>";
		$cs->free_result($stmt);
	}

	return $num;
}

/*
=========================================== function tableau_sql_vue() ====================================================

Dessine un tableau dont les informations sont le resultat d'une requête SQL passée à $sql. Les parametres $page_lien et $image_lien sont utilisés pour la premiere colonne. Si $image_lien est vide, la valeur affichée est celle du champ d'index.
*/

function tableau_sql_vue(
	$name="", 
	$sql="", 
	$page_lien="", 
	$id=0, 
	$image_lien="", 
	$compl_url="",  
	$page_vue="", 
	$compl_url_vue="", 
	$dialog, 
	$largeurs_cols, 
	$couleurs,
	$conn
) {

	if(!empty($couleurs)) {
		$coul_entete=$couleurs[0];
		$coul_ligne_paire=$couleurs[1];
		$coul_ligne_impaire=$couleurs[2];
	} else {
		$coul_entete="#DDD7CF";
		$coul_ligne_paire="#CCDDE6";
		$coul_ligne_impaire="#DDEEF6";
	}

	$stmt = $cs->query($sql, $conn);
	$num=$cs->num_rows($stmt);
	//if($num) {
		$nb_largeurs=count($largeurs_cols);
		$i=$cs->num_fields($stmt);
		if($nb_largeurs<$i) {
			
			$j=$i-$nb_largeurs;
			$a=array_fill($nb_largeurs, $j, 0);
			$largeurs_cols=array_merge($largeurs_cols, $a);
		}
		/*
		foreach($largeurs as $lar) {
			$l++;
			echo "largeur$l = $lar; ";
		}*/
		
		echo "<table id='$name' border=0 cellpadding=2 cellspacing=1 bordercolor='#FFFFFF'>";
		echo "<tr bgcolor='$coul_entete'>";
		echo "<td>&nbsp;</td>";
		$index_fieldname=$cs->field_name($stmt, 0);
		for($j=0; $j<$i; $j++) {
			$fieldname=$cs->field_name($stmt, $j);

			$tag_width="";
			if($largeurs_cols[$j]!=0) $tag_width=" width='".$largeurs_cols[$j]."'";
			if($image_lien!="" && $j==0) $fieldname="";
			echo "<td align=center$tag_width'><span style='color:#000000'><b>$fieldname<b></span></td>";
		}
		echo "</tr>";
		$r=0;

		while($rows=$stmt->fetch()) {
			$r++;
			$r1=$r/2;
			$r2=round($r1);
			if($r1==$r2)
				echo "<tr bgcolor='$coul_ligne_paire'>";
			else
				echo "<tr bgcolor='$coul_ligne_impaire'>";
			for($j=0; $j<$i; $j++) {
				$field=$rows[$j];	
				$fieldtype=$cs->field_type($stmt, $j);
				$fieldlen=$cs->field_len($stmt, $j);
					
				$url="$page_lien?id=$id&$index_fieldname=" . $rows[0] . "&action=Modifier";
				if(!empty($compl_url)) $url.=$compl_url;
				$tag_width="";
				if($largeurs[$j]!=0) $tag_width=" width='".$largeurs[$j]."'";
				
				if($j==0) {
					if($image_lien!="") $field="<img border='0' src='$image_lien'>";
					$tag_align=" align='center'";
					if(!empty($dialog)) {
						$OnClick=OpenDialog($url, $dialog[0], $dialog[1]);
						if($image_lien=="") $image_supp="img/Editer.png";
						echo "<td bgcolor='$coul_entete' align=center><input type='image' src='$image_lien' height='16' width='16' onClick=\"$OnClick\"></td>";
					} else 					
						echo "<td$tag_align$tag_width><a href='$url'>$field</a></td>";

					$tag_align=" align='center'";
					$url="$page_vue?$index_fieldname=" . $rows[0] . $compl_url_vue;
					$OnClick=OpenDialog($url, 300, 300);
					if($image_vue=="") $image_supp="img/Loupe.gif";
					echo "<td bgcolor='$coul_entete' align=center><input type='image' src='$image_vue' height='16' width='16' onClick=\"$OnClick\"></td>";
				} else {
					if($fieldtype=="date") $field = preg_replace('^([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})$', '\3/\2/\1', $field);
					$tag_align=" align='left'";
					if($fieldtype=="int") $tag_align=" align='right'";
					if($fieldlen < 5) $tag_align=" align='center'";
					echo "<td$tag_align$tag_width>$field</td>";
				}
			}
			echo "</tr>";
		}
		echo "</table>";
		$cs->free_result($stmt);
	//}

	return $num;
}

/*
============================================== function tableau_sql_check() ================================================

Dessine un tableau dont les informations sont le resultat d'une requête SQL passée à $sql. 
Les parametres $page_lien et $image_lien sont utilisés pour la premiere colonne.
Si $image_lien est vide, la valeur affichée est celle du champ d'index.

tableau_sql_check_2( $name="", $sql="", $checks, $id=0, $page_lien="", $image_lien="", $compl_url="", $dialog, $largeurs_cols, $couleurs,
*/
function tableau_sql_check($name="", $sql="", $page_lien="", $id=0, $champ_lien="", $image_lien="", $compl_url="", $dialog, $largeurs_cols, $checks, $conn) {

	$js="";
	$js_selected_check="";
	if(!empty($checks)) {
		$chklist=implode("', '", $checks);
		$chklist="'$chklist'";
		$js = "<script language=\"JavaScript\">\n";
		$js.= "	function CheckSelected(myForm){\n";
		$js.= "		checks=Array($chklist);\n";
		$js.= "		for(i=0; i<checks.length; i++) {\n";
		$js.= "			myCheck=document.getElementById(checks[i]);\n";
		$js.= "			if(myCheck) myCheck.checked=true;\n";
		$js.= "		}\n";
		$js.= "	}\n\n";
		$js.= "	CheckSelected(document.$name)\n;";
		$js.= "</script>\n";
		$js_selected_check=$js;
	}

	if(!isset($champ_lien) || $champ_lien=="") $champ_lien="";

	/*
	$coul_entete="#DDD7CF";
	$coul_ligne_paire="#CCDDE6";
	$coul_ligne_impaire="#DDEEF6";
	*/
	
	$coul_entete="#DDD7CF";
	$coul_ligne_paire="#BBB7CC";
	$coul_ligne_impaire="#C6C3D3";
	
	$stmt = $cs->query($sql, $conn);
	$num=$cs->num_rows($stmt);
	//if($num) {
		$nb_largeurs=count($largeurs_cols);
		$i=$cs->num_fields($stmt);
		if($nb_largeurs<$i) {
			
			$j=$i-$nb_largeurs;
			$a=array_fill($nb_largeurs, $j, 0);
			$largeurs_cols=array_merge($largeurs_cols, $a);
		}
		/*
		foreach($largeurs as $lar) {
			$l++;
			echo "largeur$l = $lar; ";
		}*/
		if(empty($name)) $name="checktable";
		//echo "<form method='post' name='$name'>";
		echo "<table border=0 cellpadding=2 cellspacing=1 bordercolor='#FFFFFF'>";
		echo "<tr bgcolor='$coul_entete'>";
		for($j=0; $j<$i; $j++) {
			$fieldname=$cs->field_name($stmt, $j);

			$tag_width="";
			if($largeurs_cols[$j]!=0) $tag_width=" width='".$largeurs_cols[$j]."'";
			if($image_lien!="" && $j==0) $fieldname="";
			echo "<td align=center$tag_width'><span style='color:#000000'><b>$fieldname<b></span></td>";
		}
		echo "<td><input type=checkbox name=checkall value=top onClick='return CheckAll(document.$name);'></td>";
		echo "</tr>";
		$r=0;
		while($rows=$stmt->fetch()) {
			$r++;
			$r1=$r/2;
			$r2=round($r1);
			if($r1==$r2)
				echo "<tr bgcolor='$coul_ligne_paire'>";
			else
				echo "<tr bgcolor='$coul_ligne_impaire'>";
			for($j=0; $j<$i; $j++) {
				$field=$rows[$j];	
				$fieldtype=$cs->field_type($stmt, $j);
				$fieldlen=$cs->field_len($stmt, $j);
					
				$url="$page_lien?id=$id&$champ_lien=" . $rows[0] . "&action=Modifier";
				if(!empty($compl_url)) $url.=$compl_url;
				$tag_width="";
				if($largeurs[$j]!=0) $tag_width=" width='".$largeurs[$j]."'";
				
				if($j==0) {
					$index_field=$field;
					if($image_lien!="") $field="<img border='0' src='$image_lien'>";
					$tag_align=" align='center'";
					if(!empty($dialog)) {
						$OnClick=OpenDialog($url, $dialog[0], $dialog[1]);
						echo "<td bgcolor='$coul_entete' align=center><input type='image' src='img/Editer.png' height='16' width='16' onClick=\"$OnClick\"></td>";
					} else 					
						echo "<td$tag_align$tag_width><a href='$url'>$field</a></td>";

				} else {
					if($fieldtype=="date") $field = preg_replace('^([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})$', '\3/\2/\1', $field);
					$tag_align=" align='left'";
					if($fieldtype=="int") $tag_align=" align='right'";
					if($fieldlen < 5) $tag_align=" align='center'";
					echo "<td$tag_align$tag_width>$field</td>";
				}
			}
			echo "<td><input type=\"checkbox\" id=\"$index_field\" name=\"check[]\" value=\"$index_field\"></td>";
				echo "</tr>";
		}
		echo "</table>";
		//echo "</form>";
		$cs->free_result($stmt);
	//}
	
	$js= "<script language=\"JavaScript\">\n";
	$js.= "	function CheckAll(myForm){\n";
	$js.= "		for(i=0; i<myForm.elements.length; i++) {\n";
	$js.= "			if(myForm.elements[i].type=='checkbox' && myForm.elements[i].name!='checkall')\n";
	$js.= "				myForm.elements[i].checked=myForm.elements('checkall').checked;\n";
	$js.= "		}\n";
	$js.= "	}\n";
	$js.= "</script>\n";
	echo $js;
	if($js_selected_check!="") echo $js_selected_check;


	return $num;
}

function tableau_sql_check_2(
	$name="", 
	$sql="", 
	$checks,
	$id=0, 
	$page_lien="", 
	$image_lien="", 
	$compl_url="", 
	$dialog, 
	$largeurs_cols, 
	$couleurs,
	$conn) {

	$js="";
	$js_selected_check="";
	if(!empty($checks)) {
		$chklist=implode("', '", $checks);
		$chklist="'$chklist'";
		$js = "<script language=\"JavaScript\">\n";
		$js.= "	function CheckSelected(myForm){\n";
		$js.= "		checkindex=0\n";
		$js.= "		checks=Array($chklist)\n";
		$js.= "		for(i=0; i<myForm.elements.length; i++) {\n";
		$js.= "			if(myForm.elements[i].type=='checkbox' && myForm.elements[i].name!='checkall')\n";
		$js.= "				if(myForm.elements[i].value==checks[checkindex]) {\n";
		$js.= "					myForm.elements[i].checked=true;\n";
		$js.= "					checkindex++;\n";
		$js.= "				}\n";
		$js.= "		}\n";
		$js.= "	}\n\n";
		$js.= "	CheckSelected(document.$name)\n;";
		$js.= "</script>\n";
		$js_selected_check=$js;
	}

	if(!empty($couleurs)) {
		$coul_entete=$couleurs[0];
		$coul_ligne_paire=$couleurs[1];
		$coul_ligne_impaire=$couleurs[2];
	} else {
		$coul_entete="#DDD7CF";
		$coul_ligne_paire="#CCDDE6";
		$coul_ligne_impaire="#DDEEF6";
	}

	$stmt = $cs->query($sql, $conn);
	$num=$cs->num_rows($stmt);
	//if($num) {
		$nb_largeurs=count($largeurs_cols);
		$i=$cs->num_fields($stmt);
		if($nb_largeurs<$i) {
			
			$j=$i-$nb_largeurs;
			$a=array_fill($nb_largeurs, $j, 0);
			$largeurs_cols=array_merge($largeurs_cols, $a);
		}
		/*
		foreach($largeurs as $lar) {
			$l++;
			echo "largeur$l = $lar; ";
		}*/
		if(empty($name)) $name="checktable";
		//echo "<form method='post' name='$name'>";
		echo "<table id='$name' border=0 cellpadding=2 cellspacing=1 bordercolor='#FFFFFF'>";
		echo "<tr bgcolor='$coul_entete'>";
		$index_fieldname=$cs->field_name($stmt, 0);
		for($j=0; $j<$i; $j++) {
			$fieldname=$cs->field_name($stmt, $j);

			$tag_width="";
			if($largeurs_cols[$j]!=0) $tag_width=" width='".$largeurs_cols[$j]."'";
			if($image_lien!="" && $j==0) $fieldname="";
			echo "<td align=center$tag_width'><span style='color:#000000'><b>$fieldname<b></span></td>";
		}
		echo "<td><input type=checkbox name=checkall value=top onClick='return CheckAll(document.$name);'></td>";
		echo "</tr>";
		$r=0;
		while($rows=$stmt->fetch()) {
			$r++;
			$r1=$r/2;
			$r2=round($r1);
			if($r1==$r2)
				echo "<tr bgcolor='$coul_ligne_paire'>";
			else
				echo "<tr bgcolor='$coul_ligne_impaire'>";
			for($j=0; $j<$i; $j++) {
				$field=$rows[$j];	
				$fieldtype=$cs->field_type($stmt, $j);
				$fieldlen=$cs->field_len($stmt, $j);
					
				$url="$page_lien?id=$id&$index_fieldname=" . $rows[0] . "&action=Modifier";
				if(!empty($compl_url)) $url.=$compl_url;
				$tag_width="";
				if($largeurs[$j]!=0) $tag_width=" width='".$largeurs[$j]."'";
				
				if($j==0) {
					$index_field=$field;
					if($image_lien!="") $field="<img border='0' src='$image_lien'>";
					$tag_align=" align='center'";
					if(!empty($dialog)) {
						$OnClick=OpenDialog($url, $dialog[0], $dialog[1]);
						echo "<td bgcolor='$coul_entete' align=center><input type='image' src='img/Editer.png' height='16' width='16' onClick=\"$OnClick\"></td>";
					} else 					
						echo "<td$tag_align$tag_width><a href='$url'>$field</a></td>";

				} else {
					if($fieldtype=="date") $field = preg_replace('^([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})$', '\3/\2/\1', $field);
					$tag_align=" align='left'";
					if($fieldtype=="int") $tag_align=" align='right'";
					if($fieldlen < 5) $tag_align=" align='center'";
					echo "<td$tag_align$tag_width>$field</td>";
				}
			}
			echo "<td><input type=\"checkbox\" name=\"check[]\" value=$index_field></td>";
				echo "</tr>";
		}
		echo "</table>";
		//echo "</form>";
		$cs->free_result($stmt);
	//}
	
	$js= "<script language=\"JavaScript\">\n";
	$js.= "	function CheckAll(myForm){\n";
	$js.= "		for(i=0; i<myForm.elements.length; i++) {\n";
	$js.= "			if(myForm.elements[i].type=='checkbox' && myForm.elements[i].name!='checkall')\n";
	$js.= "				myForm.elements[i].checked=myForm.elements('checkall').checked;\n";
	$js.= "		}\n";
	$js.= "	}\n";
	$js.= "</script>\n";
	echo $js;
	if($js_selected_check!="") echo $js_selected_check;


	return $num;
}

/*
================================================ function fiche_sql() ====================================================

Dessine une fiche dont les informations sont le resultat d'une requête SQL passée à $sql. Les parametres $page_lien et $image_lien sont utilisés pour la premiere colonne. Si $image_lien est vide, la valeur affichée est celle du champ d'index.
*/

function fiche_sql(
	$name="",
	$sql="", 
	$titre="", 
	$id=0, 
	$page_lien="", 
	$image_lien="", 
	$compl_url="", 
	$dialog, 
	$largeurs_cols,
	$couleurs,
	$conn
) {

	if(!empty($couleurs)) {
		$coul_entete=$couleurs[0];
		$coul_ligne_paire=$couleurs[1];
		$coul_ligne_impaire=$couleurs[2];
	} else {
		$coul_entete="#DDD7CF";
		$coul_ligne_paire="#CCDDE6";
		$coul_ligne_impaire="#DDEEF6";
	}

	$stmt = $cs->query($sql, $conn);
	$num=$cs->num_rows($stmt);
	if($num) {
		//$nb_largeurs=count($largeurs_cols);
		$i=$cs->num_fields($stmt);
		/*if($nb_largeurs<$i) {
			
			$j=$i-$nb_largeurs;
			$a=array_fill($nb_largeurs, $j, 0);
			$largeurs_cols=array_merge($largeurs_cols, $a);
		}*/
		
		echo "<table border=0 cellpadding=2 cellspacing=1 bordercolor='#FFFFFF'>";
		echo "<tr bgcolor='$coul_entete'>";
		echo "</tr>";
		$r=0;
		$tag_width="";
		if($largeurs_cols[1]!=0) $tag_width=" width='".$largeurs_cols[1]."'";
		$index_fieldname=$cs->field_name($stmt, 0);
		while($rows=$stmt->fetch()) {
			for($j=0; $j<$i; $j++) {
			
				$r++;
				$r1=$r/2;
				$r2=round($r1);
				
				if($r1==$r2)
					$tag_bgcolor=" bgcolor='$coul_ligne_paire'";
				else
					$tag_bgcolor=" bgcolor='$coul_ligne_impaire'";
				
				$fieldname=$cs->field_name($stmt, $j);

				if($image_lien!="" && $j==0) $fieldname="<img border='0' src='$image_lien'>";
				
				$field=$rows[$j];	
				$fieldtype=$cs->field_type($stmt, $j);
				$fieldlen=$cs->field_len($stmt, $j);
					
				$url="$page_lien?id=$id&$index_fieldname=" . $rows[0] . "&action=Modifier";
				if(!empty($compl_url)) $url.=$compl_url;
				
				if($j==0) {
					if($image_lien!="") $field="<img border='0' src='$image_lien'>";
					$tag_align=" align='center'";
					if(!empty($dialog)) {
						$OnClick=OpenDialog($url, $dialog[0], $dialog[1]);
						echo "<tr><td align=center bgcolor='$coul_entete'><input type='image' src='img/Editer.png' height='16' width='16' onClick=\"$OnClick\"></td><td align='center' bgcolor='$coul_entete'><b>$titre<b></td></tr>";
					} else 					
						echo "<tr><td$tag_align$tag_width><a href='$url'>$field</a></td><td>$titre</td></tr>";

				} else {
					if($fieldtype=="date") $field = preg_replace('^([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})$', '\3/\2/\1', $field);
					$tag_align=" align='left'";
					if($fieldtype=="int") $tag_align=" align='right'";
					if($fieldlen < 5) $tag_align=" align='center'";
					echo "<tr><td align='left' bgcolor='$coul_entete'>$fieldname</td><td$tag_bgcolor$tag_align$tag_width>$field</td></tr>";
				}
			}
			echo "</tr>";
		}
		echo "</table>";
		$cs->free_result($stmt);
	}

	return $num;
}

/* ============variable et fonction pour l'image========================

TEST LA VALIDITE DE L'IMAGE
chemin ou sont stoqué les images
taille max de l'image
*/

function validate_upload($the_file) { 
	global $my_max_file_size, $image_max_width, $image_max_height,$allowed_types,$the_file_type,$registered_types; 

	$start_error = "\nERREUR :\n<br>"; 
	if ($the_file == "none") { 
		$error .= "\n<li>Vous n'avez rien téléchargé !</li>"; 
	} else { 
		if (!in_array($the_file_type,$allowed_types)) { 
 			$error .= "<li>L'image n'est pas de type : \".gif, .jpg, .bmp\"</li>"; 
		} 
		if (ereg("image",$the_file_type) && (in_array($the_file_type,$allowed_types))) { 
			$size = GetImageSize($the_file); 
			list($foo,$width,$bar,$height) = explode("\"",$size[3]); 
			if ($width > $image_max_width) { 
				$error .= "\n<li>largeur d'image supérieure à " . $image_max_width . " pixels</li>"; 
			} 
			if ($height > $image_max_height) { 
				$error .= "\n<li>hauteur d'image supérieure à " . $image_max_height . " pixels</li>"; 
			} 
		} 
		if ($error) { 
			$error = $start_error . $error . "\n</ul>"; 
			return $error; 
		} else { 
			return false; 
		} 
	} 
} 

function list_files() { 
	global $the_path; 

 	$handle = dir($the_path); 
 	print "\n<b>Fichiers téléchargés:</b><br>"; 
  	while($file = $handle->read()) { 
   		if (($file != ".") && ($file != "..")) { 
    			print "\n" . $file . "<br>"; 
		} 
  	} 
 	print "<hr>"; 
 } 

function upload_file($the_file) { 
	global $the_path,$the_file_name; 

	$error = validate_upload($the_file); 
	if (!$error) { 
		if (!@copy($the_file, $the_path . "/" . $the_file_name)) { 
			$error="ERREUR : Copie du fichier impossible!";
		} else { 
			$error=$the_file_name;
		} 
	} 
	return $error;
} 
function date_mysql($date_saisie){

    //division de la date par rapport au / ou -
    list ($jour , $mois , $an) = split("[-./]",$date_saisie);
    //inverse la date
    return($an."-".$mois."-".$jour);
}

function retour_date($date_saisie)
{
list ($an,$mois,$jour ) = split("[-./]",$date_saisie);
    //$date=substr($timestamp,8,2)."/".substr($timestamp,5,2)."/".substr($timestamp,0,4);
    return($jour."-".$mois."-".$an);
}
function transfert_excel($sql,$filename,$cs){
//$sql="select cli_id as Id,cli_nom_societe as Société from clients ";


// ------------------------------------------------------------------------- //
// Génération d'un fichier SYLK à partir de données MySQL en vue d'une       //
// récupération sous Excel.                                                  //
// L'avantange du format SYLK par rapport au format CSV est qu'il permet de  //
// définir des attributs de mise en forme pour les données : alignement,     //
// gras, itallique, formats de données, ...                                  //
// ------------------------------------------------------------------------- //
define("FORMAT_REEL",   1); // #",##0.00
define("FORMAT_ENTIER", 2); // #",##0
define("FORMAT_TEXTE",  3); // @
$cfg_formats[FORMAT_ENTIER] = "FF0";
$cfg_formats[FORMAT_REEL]   = "FF2";
$cfg_formats[FORMAT_TEXTE]  = "FG0";
// ----------------------------------------------------------------------------
//	include("dataconn.php");
//	$cs=dataconnection("connect");

   // construction de la requête
	    // ------------------------------------------------------------------------
	// définition des différentes colonnes de données
    // ------------------------------------------------------------------------
    //        champ, en-tête, format, alignement, largeur
	
	
	
	
	
	
	//$champs = Array( 
//		Array( 'jrn_id','ID ',FORMAT_ENTIER,'C',10),
//		Array( 'jrn_nom_prenom','Journaliste ',FORMAT_TEXTE,'C',25),
//		Array( 'jrn_email','E-mail ',FORMAT_TEXTE,'C',25),
//	);
 
	$stmt = $cs->query($sql);
	$num = $cs->num_rows($stmt);
	$nbcol = $cs->num_fields($stmt);
	
	
	if ($num > 0)
    {
       	// en-tête HTTP
        // --------------------------------------------------------------------
    
	    header('Content-disposition: filename='.$filename);
        header('Content-type: application/octetstream');
        header('Pragma: no-cache');
        header('Expires: 0');
        // en-tête du fichier
        // --------------------------------------------------------------------
        echo "ID;PASTUCES-phpInfo.net\n"; // ID;Pappli
        echo "\n";
        // formats
        echo "P;PGeneral\n";
        echo "P;P#,##0.00\n";       // P;Pformat_1 (reels)
        echo "P;P#,##0\n";          // P;Pformat_2 (entiers)
        echo "P;P@\n";              // P;Pformat_3 (textes)
        echo "\n";
        // polices
        echo "P;EArial;M200\n";
        echo "P;EArial;M200\n";
        echo "P;EArial;M200\n";
        echo "P;FArial;M200;SB\n";
        echo "\n";
        // nb lignes * nb colonnes
        echo "B;Y".($num +1);
        echo ";X".($nbcol)."\n"; // B;Yligmax;Xcolmax
        echo "\n";
  //      // récupération des infos de formatage
  //      // --------------------------------------------------------------------
  //      for ($cpt = 0; $cpt < $nbcol; $cpt++)
   //     {
   //         $num_format[$cpt] = $champs[$cpt][2];
//	    $format[$cpt]     = $cfg_formats[ $num_format[$cpt] ] . $champs[$cpt][3];
//        }
        // largeurs des colonnes
        // --------------------------------------------------------------------
     //      for ($cpt = 1; $cpt <= $nbcol; $cpt++)
    //       {
      //         // F;Wcoldeb colfin largeur
      //         echo "F;W".$cpt." ".$cpt." ".$champs[$cpt-1][4]."\n";
      //     }
       //    echo "F;W".$cpt." 256 8\n"; // F;Wcoldeb colfin largeur
      //     echo "\n";
      //     // en-tête des colonnes (en gras --> SDM4)
     //      // --------------------------------------------------------------------
    //       for ($cpt = 1; $cpt <= $nbcol; $cpt++)
    //       {
    //           echo "F;SDM4;FG0C;".($cpt == 1 ? "Y1;" : "")."X".$cpt."\n";
    //           echo "C;N;K\"".$champs[$cpt-1][1]."\"\n";
    //       }
    //       echo "\n";
        
		
		
		        // récupération des infos de formatage
        // --------------------------------------------------------------------
       
	 
	   
	   
	    for ($cpt = 0; $cpt < $nbcol; $cpt++)
        {
            $num_format[$cpt] = FORMAT_TEXTE;
	    $format[$cpt]     = $cfg_formats[ $num_format[$cpt] ] . 'C';
        }
        // largeurs des colonnes
        // --------------------------------------------------------------------
        for ($cpt = 1; $cpt <= $nbcol; $cpt++)
        {
            // F;Wcoldeb colfin largeur
            echo "F;W".$cpt." ".$cpt." ".'25'."\n";
        }
        echo "F;W".$cpt." 256 8\n"; // F;Wcoldeb colfin largeur
        echo "\n";
        // en-tête des colonnes (en gras --> SDM4)
        // --------------------------------------------------------------------
        for ($cpt = 1; $cpt <= $nbcol; $cpt++)
        {
            echo "F;SDM4;FG0C;".($cpt == 1 ? "Y1;" : "")."X".$cpt."\n";
            echo "C;N;K\"".$cs->field_name($stmt,$cpt-1)."\"\n";
        }
        echo "\n";

		
		
		
		// données
        // --------------------------------------------------------------------
        $ligne = 2;
        while ($enr = $stmt->fetch())
        {
            // parcours des champs
            for ($cpt = 0; $cpt < $nbcol; $cpt++)
            {
                // format
                echo "F;P".$num_format[$cpt].";".$format[$cpt];
                echo ($cpt == 0 ? ";Y".$ligne : "").";X".($cpt+1)."\n";
                // valeur
                if ($num_format[$cpt] == FORMAT_TEXTE)
                    echo "C;N;K\"".str_replace(';', ';', $enr[$cpt])."\"\n"; // ajout des ""
                else
                    echo "C;N;K".$enr[$cpt]."\n";
            }
            echo "\n";
            $ligne++;
        }
        // fin du fichier
        // --------------------------------------------------------------------
        echo "E\n";
    }
}

function transfert_txt($sql,$filename,$cs){

header("Content-type: text/x-csv");

header('Content-disposition: filename='.$filename); 
$message="";


 
	$stmt = $cs->query($sql);
	$num = $cs->num_rows($stmt);
	$nbcol = $cs->num_fields($stmt);
	
	
	if ($num > 0)
    {
 	
         // --------------------------------------------------------------------
        for ($cpt = 1; $cpt <= $nbcol; $cpt++)
        {
         
    	$message=$message.$cs->field_name($stmt,$cpt-1).";";
        }
       	$liste="$message\r\n";


		echo $liste; 

		
		
		
		// données
        // --------------------------------------------------------------------
        $ligne = 2;
        while ($enr = $stmt->fetch())
        {
            // parcours des champs
			$message="";
            for ($cpt = 0; $cpt < $nbcol; $cpt++)
            {

                   $message=$message.$enr[$cpt].";"; // ajout des ""
          
            }
             $liste="$message\r\n";
			echo $liste;
            $ligne++;
        }
        // fin du fichier
        // --------------------------------------------------------------------
      
    }
}


function tableau_sql_cases($sql="", $cases, $valide_cases, $champ_case, $champ_ref, $table, $page_lien="", $id=0, $champ_lien="", $image_lien="", $compl_url="", $dialog, $largeurs_cols, $conn) {

	if(!isset($champ_lien) || $champ_lien=="") $champ_lien="";
	
	if(isset($cases)) {
		$chklist=implode("', '", $cases);
		$chklist="'$chklist'";

		// ***** LIGNE A ENLEVER OU A METTRE EN COMMENTAIRE, NE SERT QU'A LISTER LES CASES COCHEES POUR VERIFICATION *****
	//	echo "Vous avez coch&eacute; les cases $chklist.<br>";
	}

	if($valide_cases=="OK") {
		$sql2="update $table set $champ_case=0";
		$cs->query($sql2, $conn);
		
		$sql2="update $table set $champ_case=1 where $champ_ref in ($chklist)";
		$cs->query($sql2, $conn);
	}
	
	$coul_entete="#DDD7CF";
	$coul_ligne_paire="#BBB7CC";
	$coul_ligne_impaire="#C6C3D3";
	
	echo "<form method='post' name='myForm' action='$PHP_SELF'>";
		
	$stmt = $cs->query($sql, $conn);
	$num=$cs->num_rows($stmt);
	//if($num) {
		$nb_largeurs=count($largeurs_cols);
		$i=$cs->num_fields($stmt);
		if($nb_largeurs<$i) {
			
			$j=$i-$nb_largeurs;
			$a=array_fill($nb_largeurs, $j, 0);
			$largeurs_cols=array_merge($largeurs_cols, $a);
		}
		
		echo "<table border=0 cellpadding=2 cellspacing=1 bordercolor='#FFFFFF'>";
		echo "<tr bgcolor='$coul_entete'>";
		for($j=0; $j<$i; $j++) {
			$fieldname=$cs->field_name($stmt, $j);

			$tag_width="";
			if($largeurs_cols[$j]!=0) $tag_width=" width='".$largeurs_cols[$j]."'";
			if($image_lien!="" && $j==0) $fieldname="";
			echo "<td align=center$tag_width'><span style='color:#000000'><b>$fieldname<b></span></td>";
		}
		echo "</tr>";
		$r=0;
		while($rows=$stmt->fetch()) {
			$r++;
			$r1=$r/2;
			$r2=round($r1);
			if($r1==$r2)
				echo "<tr bgcolor='$coul_ligne_paire'>";
			else
				echo "<tr bgcolor='$coul_ligne_impaire'>";
			for($j=0; $j<$i; $j++) {
				$field=$rows[$j];	
				$fieldtype=$cs->field_type($stmt, $j);
				$fieldlen=$cs->field_len($stmt, $j);
					
				$url="$page_lien?id=$id&$champ_lien=" . $rows[0] . "&action=Modifier";
				if(!empty($compl_url)) $url.=$compl_url;
				$tag_width="";
				if($largeurs[$j]!=0) $tag_width=" width='".$largeurs[$j]."'";
				
				if($j==0) {
					if($image_lien!="") $field="<img border='0' src='$image_lien'>";
					$tag_align=" align='center'";
					if(!empty($dialog)) {
						$OnClick=OpenDialog($url, $dialog[0], $dialog[1]);
						echo "<td bgcolor='$coul_entete' align=center><input type='image' src='img/Editer.png' height='16' width='16' onClick=\"$OnClick\"></td>";
					} else 					
						echo "<td$tag_align$tag_width><a href='$url'>$field</a></td>";

				} else {
					if($cs->field_name($stmt, $j)==$champ_case) {
						if($rows[$j]==1)
							$field="<input type='checkbox' value='".$rows[$champ_ref]."' name='cases[]' checked><br>";
						else
							$field="<input type='checkbox' value='".$rows[$champ_ref]."' name='cases[]'><br>";
						$tag_align=" align='center'";
					} else {
						if($fieldtype=="date") $field = preg_replace('^([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})$', '\3/\2/\1', $field);
						$tag_align=" align='left'";
						if($fieldtype=="int") $tag_align=" align='right'";
						if($fieldlen < 5) $tag_align=" align='center'";
					}
					echo "<td$tag_align$tag_width>$field</td>";
				}
			}
			echo "</tr>";
		}
		echo "</table>";
		$cs->free_result($stmt);
	//}
	echo "<input type='submit' name='valide_cases' value='OK'>";
	echo "</form>";

	return $num;
}





?>
