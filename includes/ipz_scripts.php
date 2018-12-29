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

include_once("ipz_menus.php");

define("FRAME", true);
define("NO_FRAME", false);

function make_catalog(
	$database, 
	$table="", 
	$pa_filename="", 
	$catalog=0, 
	$editor=0, 
	$indexfield="", 
	$secondfield="",
	$with_frames
) {
	$script="<?php   \n";
	$script.="\tinclude_once(\"pz_db.php\");\n";
	$script.="\tinclude_once(\"pz_mysqlconn.php\");\n";
	$script.="\t\$cs=connection(\"connect\",\"$database\");\n\n";
	$script.="\tif(empty(\$event)) \$event=\"onLoad\";\n";
	$script.="\tif(empty(\$action)) \$action=\"Ajouter\";\n";
	
	$catalog_page=get_page_filename($database, $catalog);
	$script.="?>\n";
	/*
	if($with_frames)
		$script.="\t<form method='POST' name='$formname' action='<?php echo \$lg?>/$catalog_page?id=$catalog&lg=fr'>\n";
	else if(!$with_frames)
		$script.="\t<form method='POST' name='$formname' action='page.php?id=$catalog&lg=fr'>\n";
	$script.="\t<table width='100%' height='100%'>\n";
	$script.="\t\t<tr><td align='center' valign='middle'>\n";
	$script.="\t\t\t<table><tr><td>\n";
	$script.="<?php   \n";
	$script.="\tif(\$event==\"onLoad\") {\n";
	*/
	$script.="\t\t\$sql=\"select $indexfield, $secondfield from $table;\";\n";
	$script.="\t\t\$colors=array();\n";
	$editor_page=get_page_filename($database, $editor);
	/*
	if($with_frames)
		$script.="\t\ttableau_sql('$table', \$sql, $editor, '$editor_page', '/$database/img/Editer.png', '', '', '', \$colors, \$cs);\n";
	else if(!$with_frames)
		$script.="\t\ttableau_sql('$table', \$sql, $editor, 'page.php', '/$database/img/Editer.png', '', '', '', \$colors, \$cs);\n";
	$script.="\t\tcontainer('$table', 150, 250, 350, 550, 16);\n";
	*/
	$script.="\t\tfiche_sql('$table', \$sql, '', $editor, 'page.php', '/$database/img/Editer.png', '', '', '', \$colors, \$cs);\n";
	/*
	$script.="\t} else if(\$event==\"onRun\") {\n";
	$script.="\t\t\$cs=connection(\"disconnect\",\"$database\");\n";

	if($with_frames) 
		$script.="\t\techo \"<script language='JavaScript'>window.location.href='<?php echo \$lg?>/$editor_page?id=$editor&action=Ajouter'</script>\";\n";
	else if(!$with_frames)
		$script.="\t\techo \"<script language='JavaScript'>window.location.href='page.php?id=$editor&action=Ajouter'</script>\";\n";
	$script.="\t} else if(\$event==\"onUnload\") {\n";
	$script.="\t\t\$cs=connection(\"disconnect\",\"$database\");\n";
	$script.="\t\techo \"<script language='JavaScript'>window.location.href='page.php?id=1&lg=fr'</script>\";\n";
	$script.="\t}\n";
	$script.="?>\n";
	$script.="\t\t\t</td></tr>\n<tr>\n\t\t\t\t<input type='hidden' name='event' value=''>\n";
	$script.="\t\t\t\t<td><input type='submit' name='action' value='<?php echo \$action?>' onClick='return runForm();'></td>\n";
	$script.="\t\t\t\t<td><input type='submit' name='action' value='Fermer' onClick='return unloadForm();'></td>\n";
	$script.="\t\t\t</tr></table>\n";
	$script.="\t\t</td></tr></table>\n";
	$script.="</form>\n";
	*/

	$file=fopen($pa_filename, "w");
	fwrite($file, $script);
	fclose($file);
}

function make_editor(
	$database, 
	$table="", 
	$pa_filename="", 
	$catalog=0, 
	$editor=0, 
	$indexfield=0, 
	$A_sqlFields, 
	$cs,
	$with_frames
) {
	$script="<?php   \n";
	$script.="\tinclude_once(\"pz_mysqlconn.php\");\n";
	$script.="\t\$cs=connection(\"connect\",\"$database\");\n";
	$script.="\tif(empty(\$event)) \$event=\"onLoad\";\n";
	$script.="\tif(\$event==\"onLoad\") {\n";
	$script.="\t\tswitch (\$action) {\n";
	$script.="\t\tcase \"Ajouter\":\n\n";
	$A_formFields=relations($database,$table,$cs);
	echo "$L_formFields<br>";
	for($i=0;$i<sizeof($A_sqlFields);$i++) {
		$fieldname=$A_sqlFields[$i];
		if ($i==0) {
			$indexfield=$fieldname;
			$script.="\t\t\t\$sql=\"select max($fieldname) from $table;\";\n";
			$script.="\t\t\t\$stmt = \$cs->query(\$sql);\n";
			$script.="\t\t\t\$rows = \$stmt->fetch(PDO::FETCH_ASSOC);\n";
			$script.="\t\t\t\$$fieldname=\$rows[0]+1;\n";
		} else
			$script.="\t\t\t\$$fieldname=\"\";\n";
	}
	$script.="\t\tbreak;\n";
	$script.="\t\tcase \"Modifier\":\n";
	for($i=0;$i<sizeof($A_sqlFields);$i++) {
		$fieldname=$A_sqlFields[$i];
		if ($i==0) {
			$script.="\t\t\t\$sql=\"select * from $table where $fieldname=$$fieldname;\";\n";
			$script.="\t\t\t\$stmt = \$cs->query(\$sql);\n";
			$script.="\t\t\t\$rows = \$stmt->fetch(PDO::FETCH_ASSOC);\n";
			$script.="\t\t\t\$$fieldname=\$rows[\"$fieldname\"];\n";
		} else
			$script.="\t\t\t\$$fieldname=\$rows[\"$fieldname\"];\n";
	}
	$script.="\t\tbreak;\n";
	$script.="\t\t}\n";
	$script.="\t} else if(\$event==\"onRun\") {\n";
	$script.="\t\tswitch (\$action) {\n";
	$script.="\t\tcase \"Ajouter\":\n";
	$script.="\t\t\t\$sql=\"insert into $table (\".\n";
	$insert="";
	for($i=0;$i<sizeof($A_sqlFields);$i++) {
		$fieldname=$A_sqlFields[$i];
		$insert[$i]="\t\t\t\t\"$fieldname";
	}
	$script.=implode($insert, ", \".\n") . "\".";
	$script.="\n\t\t\t\") values (\".\n";
	$insert="";
	for($i=0;$i<sizeof($A_sqlFields);$i++) {
		$fieldname=$A_sqlFields[$i];
		$insert[$i]="\t\t\t\t\"'\$$fieldname'";
	}
	$script.=implode($insert, ", \".\n") . "\".\n";
	$script.="\t\t\t\")\";\n";
	$script.="\t\t\t\$stmt = \$cs->query(\$sql);\n";
	$script.="\t\tbreak;\n";
	$script.="\t\tcase \"Modifier\":\n";
	$script.="\t\t\t\$sql=\"update $table set \".\n";
	$update="";
	for($i=0;$i<sizeof($A_sqlFields);$i++) {
		$fieldname=$A_sqlFields[$i];
		$update[$i]="\t\t\t\t\"$fieldname='\$$fieldname'";
	}
	$script.=implode($update, ", \".\n") . " \".\n";
	$script.="\t\t\t\"where $indexfield='\$$indexfield'\";\n";
	$script.="\t\t\t\$stmt = \$cs->query(\$sql);\n";
	$script.="\t\tbreak;\n";
	$script.="\t\tcase \"Supprimer\":\n";
	$script.="\t\t\t\$sql=\"delete from $table where $indexfield='\$$indexfield'\";\n";
	$script.="\t\t\t\$stmt = \$cs->query(\$sql);\n";
	$script.="\t\tbreak;\n";
	$script.="\t\t}\n";
	if($with_frames)
		$script.="\t\techo \"<script language='JavaScript'>window.location.href='<?php echo \$lg?>/$catalog_page?id=$catalog&lg=fr'</script>\";\n";
	else if(!$with_frames)
		$script.="\t\techo \"<script language='JavaScript'>window.location.href='page.php?id=$catalog&lg=fr'</script>\";\n";
	$script.="\t} else if(\$event==\"onUnload\") {\n";
	$script.="\t\t\$cs=connection(\"disconnect\",\"$database\");\n";
	$script.="\t\techo \"<script language='JavaScript'>window.location.href='page.php?id=$catalog&lg=fr'</script>\";\n";
	$script.="\t}\n";
	$script.="?>\n";
	$editor_page=get_page_filename($database, $editor);
	if($with_frames)
		$script.="<form method='POST' name='$formname' action='<?php echo \$lg?>/$editor_page?id=$editor&lg=fr'>\n";
	else if(!$with_frames)
		$script.="<form method='POST' name='$formname' action='page.php?id=$editor&lg=fr'>\n";
	$script.="<input type='hidden' name='event' value=''>\n";
	$script.="<input type='hidden' name='$indexfield' value='<?php echo $$indexfield?>'>\n";
	$script.="<table witdh='100%' height='100%'><tr><td align='center' valign='middle'>";
	$script.="<table>";
	$inputs="";
	for($i=0;$i<sizeof($A_formFields);$i++) {
		$fieldname=$A_formFields[$i];
		$top=20+(24*$i)."px";
		if($fieldname==$indexfield)
			$inputs.="<tr><td>$fieldname</td>\n<td><?php echo $$fieldname?></td></tr>\n";
		else
			$inputs.="<tr><td>$fieldname</td>\n<td><input type='text' name='$fieldname' value='<?php echo $$fieldname?>'></td></tr>\n";
	}
	$top=20+(24*($i+2))."px";
	$script.="$inputs\n";
	$script.="<tr><td align='center' colspan='2'><input type='submit' name='action' value='<?php echo \$action?>' onClick='return runForm();'>\n";
	$script.="<input type='submit' name='action' value='Supprimer' onClick='return runForm($formname);'>\n";
	$script.="<input type='reset' name='action' value='Annuler'>\n";
	$script.="<input type='submit' name='action' value='Fermer' onClick='return unloadForm($formname);'>\n";
	$script.="</td></tr></table>\n";
	$script.="</td></tr></table>\n";
	$script.="</form>\n";

	$file=fopen($pa_filename, "w");
	fwrite($file, $script);
	fclose($file);
}
?>	
