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
include_once("ipz_analyser.php");

define("FRAME", true);
define("NO_FRAME", false);

function make_code(
	$database, 
	$table="", 
	$page_id=0, 
	$indexfield=0, 
	$secondfield="",
	$A_sqlFields, 
	$cs,
	$with_frames
) {
    $script="\n";
    //$script.="<script language=\"JavaScript\" src=\"js/pz_form_events.js\"></script>\n";
    $script="<?php   \n";
    $script.="\tinclude_once(\"puzzle/ipz_mysqlconn.php\");\n";
    $script.="\tinclude_once(\"puzzle/ipz_db_controls.php\");\n";
    $script.="\t\$cs=connection(CONNECT,\$database);\n";
    $script.="\t\$query = get_variable(\"query\", \"SELECT\");\n";
    $script.="\t\$event = get_variable(\"event\", \"onLoad\");\n";
    $script.="\t\$action = get_variable(\"action\", \"Ajouter\");\n";
    $script.="\t\$id = get_variable(\"id\");\n";
    $script.="\t\$di = get_variable(\"di\");\n";
    $defs=explode(',', $A_sqlFields[0]);
    $fieldname=$defs[0];
    $script.="\t$$fieldname = get_variable(\"$fieldname\");\n";
    $script.="\tif(\$event==\"onLoad\" && \$query==\"ACTION\") {\n";
    $script.="\t\tswitch (\$action) {\n";
    $script.="\t\tcase \"Ajouter\":\n\n";
    //echo "$L_formFields<br>";
    for ($i=0;$i<sizeof($A_sqlFields);$i++) {
        $defs=explode(',', $A_sqlFields[$i]);
        $fieldname=$defs[0];
        if ($i==0) {
            $indexfield=$fieldname;
            $script.="\t\t\t\$sql=\"select max($fieldname) from $table;\";\n";
            $script.="\t\t\t\$stmt = \$cs->query(\$sql);\n";
            $script.="\t\t\t\$rows = \$stmt->fetch();\n";
            $script.="\t\t\t\$$fieldname=\$rows[0]+1;\n";
        } else {
            $script.="\t\t\t\$$fieldname=\"\";\n";
        }
    }
    $script.="\t\tbreak;\n";
    $script.="\t\tcase \"Modifier\":\n";
    for ($i=0;$i<sizeof($A_sqlFields);$i++) {
        $defs=explode(',', $A_sqlFields[$i]);
        $fieldname=$defs[0];
        if ($i==0) {
            $script.="\t\t\t\$sql=\"select * from $table where $fieldname='$$fieldname';\";\n";
            $script.="\t\t\t\$stmt = \$cs->query(\$sql);\n";
            $script.="\t\t\t\$rows = \$stmt->fetch(PDO::FETCH_ASSOC);\n";
            $script.="\t\t\t\$$fieldname=\$rows[\"$fieldname\"];\n";
        } else {
            $script.="\t\t\t\$$fieldname=\$rows[\"$fieldname\"];\n";
        }
    }
    $script.="\t\tbreak;\n";
    $script.="\t\t}\n";
    $script.="\t} else if(\$event==\"onRun\" && \$query==\"ACTION\") {\n";
    $script.="\t\tswitch (\$action) {\n";
    $script.="\t\tcase \"Ajouter\":\n";
    for ($i=0;$i<sizeof($A_sqlFields);$i++) {
        $defs=explode(',', $A_sqlFields[$i]);
        $fieldname=$defs[0];
        $script.="\t\t\t\$$fieldname = \$_POST[\"$fieldname\"];\n";
    }
    $replaces=array();
    $insertFields=array();
    for ($i=0;$i<sizeof($A_sqlFields);$i++) {
        $defs=explode(',', $A_sqlFields[$i]);
        $fieldname=$defs[0];
		$fieldtype=mysqli_to_php($defs[2]);
        $insertFields[$i]="\t\t\t\t\"$fieldname";
        if ($fieldtype=='string') {
            $replaces[]="\t\t\t\$$fieldname=escapeChars(\$$fieldname)";
        }
    }
    $script.=implode($replaces, ";\n") . ";\n";
    $script.="\t\t\t\$sql=\"insert into $table (\".\n";
    $script.=implode($insertFields, ", \".\n") . "\".";
    $script.="\n\t\t\t\") values (\".\n";
    $insertValues=array();
    for ($i=0;$i<sizeof($A_sqlFields);$i++) {
        $defs=explode(',', $A_sqlFields[$i]);
        $fieldname=$defs[0];
		$fieldtype=mysqli_to_php($defs[2]);
        if ($fieldtype=='string') {
            $replaces[]="\t\t\t\$$fieldname=escapeChars(\$$fieldname)";
            $insertValues[$i]="\t\t\t\t\"'\$$fieldname'";
        } elseif ($fieldtype=='int') {
            $insertValues[$i]="\t\t\t\t\"\$$fieldname";
        } elseif ($fieldtype=='float') {
            $insertValues[$i]="\t\t\t\t\"\$$fieldname";
        } else {
            $insertValues[$i]="\t\t\t\t\"'\$$fieldname'";
        }
    }
    $script.=implode($insertValues, ", \".\n") . "\".\n";
    $script.="\t\t\t\")\";\n";
    $script.="\t\t\t\$stmt = \$cs->query(\$sql);\n";
    $script.="\t\tbreak;\n";
    $script.="\t\tcase \"Modifier\":\n";
    for ($i=0;$i<sizeof($A_sqlFields);$i++) {
        $defs=explode(',', $A_sqlFields[$i]);
        $fieldname=$defs[0];
        $script.="\t\t\t\$$fieldname = \$_POST[\"$fieldname\"];\n";
    }
    $replaces=array();
    $update=array();
    for ($i=0;$i<sizeof($A_sqlFields);$i++) {
        $defs=explode(',', $A_sqlFields[$i]);
        $fieldname=$defs[0];
		$fieldtype=mysqli_to_php($defs[2]);
		
        if ($fieldtype=='string') {
            $replaces[]="\t\t\t\$$fieldname=escapeChars(\$$fieldname)";
            $update[$i]="\t\t\t\t\"$fieldname='\$$fieldname'";
        } elseif ($fieldtype==11) {
            $update[$i]="\t\t\t\t\"$fieldname=\$$fieldname";
        } elseif ($fieldtype=='float') {
            $update[$i]="\t\t\t\t\"$fieldname=\$$fieldname";
        } else {
            $update[$i]="\t\t\t\t\"$fieldname='\$$fieldname'";
        }
    }
    $script.=implode($replaces, ";\n") . ";\n";
    $script.="\t\t\t\$sql=\"update $table set \".\n";
    $script.=implode($update, ", \".\n") . " \".\n";
    $script.="\t\t\t\"where $indexfield='\$$indexfield'\";\n";
    $script.="\t\t\t\$stmt = \$cs->query(\$sql);\n";
    $script.="\t\tbreak;\n";
    $script.="\t\tcase \"Supprimer\":\n";
    $script.="\t\t\t\$sql=\"delete from $table where $indexfield='\$$indexfield'\";\n";
    $script.="\t\t\t\$stmt = \$cs->query(\$sql);\n";
    $script.="\t\tbreak;\n";
    $script.="\t\t}\n";
    if ($with_frames) {
        $script.="\t\techo \"<script language='JavaScript'>window.location.href='<?php echo \$lg?>/$page_id_page?id=$page_id&lg=fr'</script>\";\n";
    } elseif (!$with_frames) {
        $script.="\t\t\$query=\"SELECT\";\n";
    }
    //$script.="\t\techo \"<script language='JavaScript'>window.location.href='page.php?id=$page_id&lg=fr'</script>\";\n";
    $script.="\t} else if(\$event==\"onUnload\" && \$query==\"ACTION\") {\n";
    $script.="\t\t\$cs=connection(DISCONNECT,\$database);\n";
    $script.="\t\techo \"<script language='JavaScript'>window.location.href='page.php?id=$page_id&lg=fr'</script>\";\n";
    $script.="\t}\n";
    $script.="?>\n";

    return $script;
}

function make_page(
	$database, 
	$table="", 
	$pa_filename="", 
	$page_id=0, 
	$indexfield=0, 
	$secondfield="",
	$A_sqlFields, 
	$cs,
	$with_frames
) {
	$formname=$table."Form";
	
	$relations=relations($database,$table,$cs);
	$A_formFields=$relations["form_fields"];

	$script="\n";
	$script="<center>\n";
	$script.="<?php   \n";
	$script.="\tinclude(\"".$pa_filename."_code.php\");\n";
    $script.="\t\$pc = get_variable(\"pc\");\n";
    $script.="\t\$sr = get_variable(\"sr\");\n";
    $script.="\t\$curl_pager = \"\";\n";
    $script.="\t\$dialog = \"\";\n";
    $script.="\tif(isset(\$pc)) \$curl_pager=\"&pc=\$pc\";\n";
    $script.="\tif(isset(\$sr)) \$curl_pager.=\"&sr=\$sr\";\n";
	$script.="\tif(\$query==\"SELECT\") {\n";
	$script.="\t\t\t\$sql=\"select $indexfield, $secondfield from $table order by $indexfield\";\n";
	$script.="\t\t\t\$dbgrid=create_pager_db_grid(\"$table\", \$sql, \$id, \"page.php\", \"&query=ACTION\$curl_pager\", \"\", true, true, \$dialog, array(0, 400), 15, \$grid_colors, \$cs);\n";
	$script.="\t\t\t//\$dbgrid=table_shadow(\"$table\", \$dbgrid);\n";
	$script.="\t\t\techo \"<br>\".\$dbgrid;\n";
	$script.="\t} elseif(\$query==\"ACTION\") {\n";
	$script.="?>\n";
	//$page_filename=get_page_filename($database, $page_id);
	$page_filename="page.php";
	if($with_frames)
		$script.="<form method='POST' name='$formname' action='<?php echo \$lg?>/$page_filename?id=$page_id&lg=fr'>\n";
	else if(!$with_frames)
		$script.="<form method='POST' name='$formname' action='page.php?id=$page_id&lg=fr'>\n";
	$script.="\t<input type='hidden' name='query' value='ACTION'>\n";
	$script.="\t<input type='hidden' name='event' value='onRun'>\n";
	$script.="\t<input type='hidden' name='pc' value='<?php echo \$pc?>'>\n";
	$script.="\t<input type='hidden' name='sr' value='<?php echo \$sr?>'>\n";
	$script.="\t<input type='hidden' name='$indexfield' value='<?php echo $$indexfield?>'>\n";
	$script.="\t<table border='1' bordercolor='<?php echo \$panel_colors[\"border_color\"]?>' cellpadding='0' cellspacing='0' witdh='100%' height='1'>\n";
	$script.="\t\t<tr>\n";
	$script.="\t\t\t<td align='center' valign='top' bgcolor='<?php echo \$panel_colors[\"back_color\"]?>'>\n";
	$script.="\t\t\t\t<table>\n";
	$inputs="";
	for($i=0;$i<sizeof($A_formFields);$i++) {
		$inputs.= $A_formFields[$i] . "\n";
	}
	$script.= $inputs;
	//$script.="<tr><td align='center' colspan='2'><input type='submit' name='action' value='<?php echo \$action>' onClick='return runForm(\"$formname\");'>\n";
	
	$script.="\t\t\t\t\t<tr>\n";
	$script.="\t\t\t\t\t\t<td align='center' colspan='2'>\n";
	$script.="\t\t\t\t\t\t\t<input type='submit' name='action' value='<?php echo \$action?>'>\n";
	$script.="\t\t\t\t\t\t\t<?php   if(\$action!=\"Ajouter\") { ?>\n";
	//$script.="<input type='submit' name='action' value='Supprimer' onClick='return runForm(\"$formname\");'>\n";
	$script.="\t\t\t\t\t\t\t\t<input type='submit' name='action' value='Supprimer'>\n";
	$script.="\t\t\t\t\t\t\t<?php   } ?>\n";
	$script.="\t\t\t\t\t\t\t<input type='reset' name='action' value='Annuler'>\n";
	//$script.="<input type='submit' name='action' value='Retour' onClick='return runForm(\"$formname\");'>\n";
	$script.="\t\t\t\t\t\t\t<input type='submit' name='action' value='Retour'>\n";
	$script.="\t\t\t\t\t\t</td>\n";
	$script.="\t\t\t\t\t</tr>\n";
	$script.="\t\t\t\t</table>\n";
	$script.="\t\t\t</td>\n";
	$script.="\t\t</tr>\n";
	$script.="\t</table>\n";
	$script.="</form>\n";
	//$script.="<table><tr><td valign=\"middle\"><a href=\"javascript: history.go(-1);\"><img src=\"../images/scroll/left_0.gif\" border=\"0\">Retour</a></td></tr></table>\n";
	$script.="<?php   \t} ?>\n";
	$script.="</center>\n";

	return $script;
}

function make_single_script(
	$database, 
	$table="", 
	$pa_filename="", 
	$page_id=0, 
	$indexfield=0, 
	$secondfield="",
	$A_sqlFields, 
	$cs,
	$with_frames
) {
    $formname=$table."Form";
    
    $relations=relations($database, $table, $cs);
    $A_formFields=$relations["form_fields"];
    
    $script="\n";
    $script="<center>\n";
    //$script.="<script language=\"JavaScript\" src=\"js/pz_form_events.js\"></script>\n";
    $script.="<?php   \n";
    $script.="\tinclude_once(\"puzzle/ipz_mysqlconn.php\");\n";
    $script.="\tinclude_once(\"puzzle/ipz_db_controls.php\");\n";
    $script.="\t\$cs=connection(CONNECT,\$database);\n";
    $script.="\t\$query = get_variable(\"query\");\n";
    $script.="\t\$event = get_variable(\"event\");\n";
    $script.="\t\$action = get_variable(\"action\");\n";
    $fieldname=$A_sqlFields[0];
    $script.="\t$$fieldname = get_variable(\"$fieldname\");\n";
    $script.="\tif(empty(\$query)) \$query=\"SELECT\";\n";
    $script.="\tif(empty(\$event)) \$event=\"onLoad\";\n";
    $script.="\tif(empty(\$action)) \$action=\"Ajouter\";\n";
    $script.="\tif(isset(\$pc)) \$curl_pager=\"&pc=\$pc\";\n";
    $script.="\tif(isset(\$sr)) \$curl_pager.=\"&sr=\$sr\";\n";
    $script.="\tif(\$event==\"onLoad\" && \$query==\"ACTION\") {\n";
    $script.="\t\tswitch (\$action) {\n";
    $script.="\t\tcase \"Ajouter\":\n\n";
    //echo "$L_formFields<br>";
    for ($i=0;$i<sizeof($A_sqlFields);$i++) {
        $fieldname=$A_sqlFields[$i];
        if ($i==0) {
            $indexfield=$fieldname;
            $script.="\t\t\t\$sql=\"select max($fieldname) from $table;\";\n";
            $script.="\t\t\t\$stmt = \$cs->query(\$sql);\n";
            $script.="\t\t\t\$rows = \$stmt->fetch(PDO::FETCH_ASSOC);\n";
            $script.="\t\t\t\$$fieldname=\$rows[0]+1;\n";
        } else {
            $script.="\t\t\t\$$fieldname=\"\";\n";
        }
    }
    $script.="\t\tbreak;\n";
    $script.="\t\tcase \"Modifier\":\n";
    for ($i=0;$i<sizeof($A_sqlFields);$i++) {
        $fieldname=$A_sqlFields[$i];
        if ($i==0) {
            $script.="\t\t\t\$sql=\"select * from $table where $fieldname='$$fieldname';\";\n";
            $script.="\t\t\t\$stmt = \$cs->query(\$sql);\n";
            $script.="\t\t\t\$rows = \$stmt->fetch(PDO::FETCH_ASSOC);\n";
            $script.="\t\t\t\$$fieldname=\$rows[\"$fieldname\"];\n";
        } else {
            $script.="\t\t\t\$$fieldname=\$rows[\"$fieldname\"];\n";
        }
    }
    $script.="\t\tbreak;\n";
    $script.="\t\t}\n";
    $script.="\t} else if(\$event==\"onRun\" && \$query==\"ACTION\") {\n";
    $script.="\t\tswitch (\$action) {\n";
    $script.="\t\tcase \"Ajouter\":\n";
    $script.="\t\t\t\$sql=\"insert into $table (\".\n";
    $insert="";
    for ($i=0;$i<sizeof($A_sqlFields);$i++) {
        $fieldname=$A_sqlFields[$i];
        $insert[$i]="\t\t\t\t\"$fieldname";
    }
    $script.=implode($insert, ", \".\n") . "\".";
    $script.="\n\t\t\t\") values (\".\n";
    $insert="";
    for ($i=0;$i<sizeof($A_sqlFields);$i++) {
        $fieldname=$A_sqlFields[$i];
        $insert[$i]="\t\t\t\t\"'\$$fieldname'";
    }
    $script.=implode($insert, ", \".\n") . "\".\n";
    $script.="\t\t\t\")\";\n";
    $script.="\t\t\t\$stmt = \$cs->query(\$sql);\n";
    $script.="\t\tbreak;\n";
    $script.="\t\tcase \"Modifier\":\n";
    for ($i=0;$i<sizeof($A_sqlFields);$i++) {
        $fieldname=$A_sqlFields[$i];
        $script.="\t\t\t\$$fieldname = \$_POST[\"$fieldname\"];\n";
    }
    $script.="\t\t\t\$sql=\"update $table set \".\n";
    $update="";
    for ($i=0;$i<sizeof($A_sqlFields);$i++) {
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
    if ($with_frames) {
        $script.="\t\techo \"<script language='JavaScript'>window.location.href='<?php echo \$lg?>/$page_id_page?id=$page_id&lg=fr'</script>\";\n";
    } elseif (!$with_frames) {
        $script.="\t\t\$query=\"SELECT\";\n";
    }
    //$script.="\t\techo \"<script language='JavaScript'>window.location.href='page.php?id=$page_id&lg=fr'</script>\";\n";
    $script.="\t} else if(\$event==\"onUnload\" && \$query==\"ACTION\") {\n";
    $script.="\t\t\$cs=connection(\"disconnect\",\"$database\");\n";
    $script.="\t\techo \"<script language='JavaScript'>window.location.href='page.php?id=$page_id&lg=fr'</script>\";\n";
    $script.="\t}\n";

    $script.="if(\$query==\"SELECT\") {\n";
    $script.="\t\t\$sql=\"select $indexfield, $secondfield from $table order by $indexfield\";\n";

    $script.="\t\t\$dbgrid=create_pager_db_grid(\"$table\", \$sql, \$id, \"page.php\", \"&query=ACTION\$curl_pager\", \"\", true, true, \$dialog, array(0, 400), 15, \$grid_colors, \$cs);\n";
  
    $script.="\t\t//\$dbgrid=table_shadow(\"$table\", \$dbgrid);\n";
    $script.="\t\techo \"<br>\".\$dbgrid;\n";
    $script.="} elseif(\$query==\"ACTION\") {\n";
    $script.="?>\n";
    //$page_filename=get_page_filename($database, $page_id);
    $page_filename="page.php";
    if ($with_frames) {
        $script.="<form method='POST' name='$formname' action='<?php echo \$lg?>/$page_filename?id=$page_id&lg=fr'>\n";
    } elseif (!$with_frames) {
        $script.="<form method='POST' name='$formname' action='page.php?id=$page_id&lg=fr'>\n";
    }
    $script.="\t<input type='hidden' name='query' value='ACTION'>\n";
    $script.="\t<input type='hidden' name='event' value='onRun'>\n";
    $script.="\t<input type='hidden' name='pc' value='<?php echo \$pc?>'>\n";
    $script.="\t<input type='hidden' name='sr' value='<?php echo \$sr?>'>\n";
    $script.="\t<input type='hidden' name='$indexfield' value='<?php echo $$indexfield?>'>\n";
    $script.="\t<table border='1' bordercolor='<?php echo \$panel_colors[\"border_color\"]?>' cellpadding='0' cellspacing='0' witdh='100%' height='1'>\n";
    $script.="\t\t<tr>\n";
    $script.="\t\t\t<td align='center' valign='top' bgcolor='<?php echo \$panel_colors[\"back_color\"]?>'>\n";
    $script.="\t\t\t\t<table>\n";
    $inputs="";
    for ($i=0;$i<sizeof($A_formFields);$i++) {
        $inputs.= $A_formFields[$i] . "\n";
    }
    $script.= $inputs;
    //$script.="<tr><td align='center' colspan='2'><input type='submit' name='action' value='<?php echo \$action>' onClick='return runForm(\"$formname\");'>\n";
    
    $script.="\t\t\t\t\t<tr>\n";
    $script.="\t\t\t\t\t\t<td align='center' colspan='2'>\n";
    $script.="\t\t\t\t\t\t\t<input type='submit' name='action' value='<?php echo \$action?>'>\n";
    $script.="<?php   \t\t\t\t\t\t\tif(\$action!=\"Ajouter\") { ?>\n";
    //$script.="<input type='submit' name='action' value='Supprimer' onClick='return runForm(\"$formname\");'>\n";
    $script.="\t\t\t\t\t\t\t\t<input type='submit' name='action' value='Supprimer'>\n";
    $script.="<?php   \t\t\t\t\t\t\t} ?>\n";
    $script.="\t\t\t\t\t\t\t<input type='reset' name='action' value='Annuler'>\n";
    //$script.="<input type='submit' name='action' value='Retour' onClick='return runForm(\"$formname\");'>\n";
    $script.="\t\t\t\t\t\t\t<input type='submit' name='action' value='Retour'>\n";
    $script.="\t\t\t\t\t\t</td>\n";
    $script.="\t\t\t\t\t</tr>\n";
    $script.="\t\t\t\t</table>\n";
    $script.="\t\t\t</td>\n";
    $script.="\t\t</tr>\n";
    $script.="\t</table>\n";
    $script.="</form>\n";
    //$script.="<table><tr><td valign=\"middle\"><a href=\"javascript: history.go(-1);\"><img src=\"../images/scroll/left_0.gif\" border=\"0\">Retour</a></td></tr></table>\n";
    $script.="<?php   } ?>\n";
    $script.="</center>\n";

    return $script;
}

function script_header($database) {
	$script="";
	$script.="<?php   \n";
	$script.="\tglobal \$img;\n";
	$script.="\t\$img=\"/images\";\n";
	$script.="\tinclude_once(\"puzzle/ipz_style.php\");\n";
	$script.="\tinclude_once(\"puzzle/ipz_misc.php\");\n";
	$script.="\tinclude_once(PZ_DEFAULTS);\n";
	$script.="\tinclude_once(\"puzzle/ipz_mysqlconn.php\");\n";
	$script.="\tinclude_once(\"puzzle/ipz_db_controls.php\");\n\n";
	$script.="\tif(!session_is_registered(\"javascript\")) {\n";
	$script.="\t\tsession_register(\"javascript\");\n";
	$script.="\t}\n";
	$script.="\t\$_SESSION[\"javascript\"]=\"\";\n\n";
	$script.="\t\$cs=connection(CONNECT,\$database, \$cs);\n\n";
	$script.="?>\n";
	
	return $script;
}

function script_footer() {
	$script="";
	$script.="<script language=\"JavaScript\">\n";
	//$script.="\tpz_shadow(\"my_table\");\n";
	$script.="<?php   \n";
	$script.="\techo \$_SESSION[\"javascript\"];\n";
	$script.="?>\n";
	$script.="</script>\n";
	
	return $script;
}

function script_browse(
	$database,
	$table="", 
	$pa_filename="", 
	$page_id=0, 
	$indexfield=0, 
	$secondfield="",
	$A_sqlFields, 
	$cs,
	$with_frames
) {
	$script="";
	$script.="<?php   \n";
	$script.="\tif(empty(\$query)) \$query=\"SELECT\";\n";
	$script.="\tif(empty(\$event)) \$event=\"onLoad\";\n";
	$script.="\tif(empty(\$action)) \$action=\"Ajouter\";\n";
	$script.="\tif(isset(\$pc)) \$curl_pager=\"&pc=\$pc\";\n";
	$script.="\tif(isset(\$sr)) \$curl_pager.=\"&sr=\$sr\";\n";
	$script.="\t\$sql=\"select $indexfield, $secondfield from $table order by $indexfield\";\n";

	$script.="\t\$dbgrid=create_pager_db_grid(\"$table\", \$sql, \$id, \"".$pa_filename."_browse.php\", \"&query=ACTION\$curl_pager\", \"\", true, true, \$dialog, array(0, 400), 15, \$grid_colors, \$cs);\n";
  
	$script.="\t//\$dbgrid=table_shadow(\"$table\", \$dbgrid);\n";
	$script.="\techo \"<br>\".\$dbgrid;\n";
	$script.="?>\n";
	
	return $script;
}

function script_form(
	$database, 
	$table="", 
	$pa_filename="", 
	$page_id=0, 
	$indexfield=0, 
	$secondfield="",
	$A_sqlFields, 
	$cs,
	$with_frames
) {
	$relations=relations($database,$table,$cs);
	$A_formFields=$relations["form_fields"];
	$script="";
	$script.="<?php   \n";
	$script.="\tif(empty(\$event)) \$event=\"onLoad\";\n";
	$script.="\tif(empty(\$action)) \$action=\"Ajouter\";\n";
	$script.="\tif(isset(\$pc)) \$curl_pager=\"&pc=\$pc\";\n";
	$script.="\tif(isset(\$sr)) \$curl_pager.=\"&sr=\$sr\";\n";
	$script.="?>\n";
	//$page_filename=get_page_filename($database, $page_id);
	$page_filename=$pa_filename;
	//if($with_frames)
		$script.="\t<form method='POST' name='$formname' action='<?php echo \$lg?>/$page_filename?id=$page_id&lg=fr'>\n";
	//else if(!$with_frames)
		//$script.="<form method='POST' name='$formname' action='page.php?id=$page_id&lg=fr'>\n";
	$script.="\t\t<input type='hidden' name='query' value='ACTION'>\n";
	$script.="\t\t<input type='hidden' name='event' value='onRun'>\n";
	$script.="\t\t<input type='hidden' name='pc' value='<?php echo \$pc?>'>\n";
	$script.="\t\t<input type='hidden' name='sr' value='<?php echo \$sr?>'>\n";
	$script.="\t\t<input type='hidden' name='$indexfield' value='<?php echo $$indexfield?>'>\n";
	$script.="\t\t<table border='1' bordercolor='<?php echo \$panel_colors[\"border_color\"]?>' cellpadding='0' cellspacing='0' witdh='100%' height='1'>";
	$script.="\t\t\t<tr>\n";
	$script.="\t\t\t\t<td align='center' valign='top' bgcolor='<?php echo \$panel_colors[\"back_color\"]?>'>\n";
	$script.="\t\t\t\t\t<table>\n";
	$inputs="";
	for($i=0;$i<sizeof($A_formFields);$i++) {
		$inputs.=$A_formFields[$i];
	}
	$script.="$inputs\n";
	
	$script.="<tr><td align='center' colspan='2'>\n<input type='submit' name='action' value='<?php echo \$action?>'>\n";
	$script.="<?php   \tif(\$action!=\"Ajouter\") { ?>\n";
	$script.="<input type='submit' name='action' value='Supprimer'>\n";
	$script.="<?php   \t} ?>\n";
	$script.="<input type='reset' name='action' value='Annuler'>\n";
	$script.="<input type='submit' name='action' value='Retour'>\n";
	$script.="</td></tr></table>\n";
	$script.="</td></tr></table>\n";
	$script.="</form>\n";

	return $script;
}

function make_browse_script(
	$database, 
	$table="", 
	$pa_filename="", 
	$page_id=0, 
	$indexfield=0, 
	$secondfield="",
	$A_sqlFields, 
	$cs,
	$with_frames
) {
	
	$formname=$table."Form";
	
	//$script.="<script language=\"JavaScript\" src=\"js/pz_form_events.js\"></script>\n";
	$script="";
	$script.=script_header($database);
	$script.="<center>\n";
	$script.=script_browse($database, $table, $pa_filename, $page_id, $indexfield, $secondfield, $A_sqlFields, $cs, $with_frames);
	$script.="</center>\n";
	$script.=script_footer();

	return $script;
}

function make_form_script(
	$database, 
	$table="", 
	$pa_filename="", 
	$page_id=0, 
	$indexfield=0, 
	$secondfield="",
	$A_sqlFields, 
	$cs,
	$with_frames
) {
	
	$formname=$table."Form";
	
	$relations=relations($database,$table,$cs);
	$A_formFields=$relations["form_fields"];
	
	//$script.="<script language=\"JavaScript\" src=\"js/pz_form_events.js\"></script>\n";
	$script="";
	$script.=script_header($database);
	$script.="<center>\n";
	$script.=script_form($database, $table, $pa_filename, $page_id, $indexfield, $secondfield, $A_sqlFields, $cs, $with_frames);
	$script.="</center>\n";
	$script.=script_footer();

	return $script;
}

function make_insert_script(
	$database, 
	$table="", 
	$pa_filename="", 
	$page_id=0, 
	$indexfield=0, 
	$secondfield="",
	$A_sqlFields, 
	$cs,
	$with_frames
) {
    $extension=substr($pa_filename, strlen($pa_filename) - 4, 4);
    $formname=$table."Form";
    
    $script="";
    $script.=script_header($database);
    $script.="<?php   \n";
    $script.="\t\$cs=connection(CONNECT,\$database);\n";
    $script.="\tif(empty(\$event)) \$event=\"onLoad\";\n";
    $script.="\tif(\$event==\"onLoad\") {\n";
    //$relations=relations($database,$table,$cs);
    //$A_formFields=$relations["form_fields"];
    echo "$L_formFields<br>";
    for ($i=0;$i<sizeof($A_sqlFields);$i++) {
        $fieldname=$A_sqlFields[$i];
        if ($i==0) {
            $indexfield=$fieldname;
            $script.="\t\t\$sql=\"select max($fieldname) from $table;\";\n";
            $script.="\t\t\$stmt = \$cs->query(\$sql);\n";
            $script.="\t\t\$rows = \$stmt->fetch();\n";
            $script.="\t\t\$$fieldname=\$rows[0]+1;\n";
        } else {
            $script.="\t\t\$$fieldname=\"\";\n";
        }
    }
    $script.="\t\tinclude('".$pa_filename."_form".$extension."')\n";
    $script.="\t} else if(\$event==\"onRun\") {\n";
    $script.="\t\t\$sql=\"insert into $table (\".\n";
    $insert="";
    for ($i=0;$i<sizeof($A_sqlFields);$i++) {
        $fieldname=$A_sqlFields[$i];
        $insert[$i]="\t\t\t\"$fieldname";
    }
    $script.=implode($insert, ", \".\n") . "\".";
    $script.="\n\t\t\") values (\".\n";
    $insert="";
    for ($i=0;$i<sizeof($A_sqlFields);$i++) {
        $fieldname=$A_sqlFields[$i];
        $insert[$i]="\t\t\t\"'\$$fieldname'";
    }
    $script.=implode($insert, ", \".\n") . "\".\n";
    $script.="\t\t\")\";\n";
    $script.="\t\t\$stmt = \$cs->query(\$sql);\n";
    $script.="\t\tinclude('".$pa_filename."_browse".$extension."')\n";
    $script.="\t}\n";
    $script.="?>\n";
    $script.=script_browse($database, $table, $pa_filename, $page_id, $indexfield, $secondfield, $A_sqlFields, $cs, $with_frames);
    $script.=script_footer();

    return $script;
}

function make_update_script(
	$database, 
	$table="", 
	$pa_filename="", 
	$page_id=0, 
	$indexfield=0, 
	$secondfield="",
	$A_sqlFields, 
	$cs,
	$with_frames
) {
	$extension=substr($pa_filename, strlen($pa_filename) - 4, 4);
	$formname=$table."Form";
	
	$script="";
	$script.=script_header($database);
	$script.="<?php   \n";
	$script.="\t\$cs=connection(CONNECT,\$database);\n";
	$script.="\tif(empty(\$event)) \$event=\"onLoad\";\n";
	$script.="\tif(\$event==\"onLoad\") {\n";
	for($i=0;$i<sizeof($A_sqlFields);$i++) {
		$fieldname=$A_sqlFields[$i];
		if ($i==0) {
			$script.="\t\t\$sql=\"select * from $table where $fieldname='$$fieldname';\";\n";
			$script.="\t\t\$stmt = \$cs->query(\$sql);\n";
			$script.="\t\t\$rows = \$stmt->fetch(PDO::FETCH_ASSOC);\n";
			$script.="\t\t\$$fieldname=\$rows[\"$fieldname\"];\n";
		} else
			$script.="\t\t\$$fieldname=\$rows[\"$fieldname\"];\n";
	}
	$script.="\t\tinclude('".$pa_filename."_form".$extension."')\n";
	$script.="\t} else if(\$event==\"onRun\") {\n";
	$script.="\t\t\$sql=\"update $table set \".\n";
	$update="";
	for($i=0;$i<sizeof($A_sqlFields);$i++) {
		$fieldname=$A_sqlFields[$i];
		$update[$i]="\t\t\t\"$fieldname='\$$fieldname'";
	}
	$script.=implode($update, ", \".\n") . " \".\n";
	$script.="\t\t\t\"where $indexfield='\$$indexfield'\";\n";
	$script.="\t\t\$stmt = \$cs->query(\$sql);\n";
	$script.="\t\tinclude('".$pa_filename."_browse".$extension."')\n";
	$script.="\t}\n";
	$script.="?>\n";
	$script.=script_browse($database, $table, $pa_filename, $page_id, $indexfield, $secondfield, $A_sqlFields, $cs, $with_frames);
	$script.=script_footer();

	return $script;
}

function make_delete_script(
	$database, 
	$table="", 
	$pa_filename="", 
	$page_id=0, 
	$indexfield=0, 
	$secondfield="",
	$A_sqlFields, 
	$cs,
	$with_frames
) {
	$extension=substr($pa_filename, strlen($pa_filename) - 4, 4);
	$formname=$table."Form";
	
	$script="";
	$script.=script_header($database);
	$script.="<?php   \n";
	$script.="\t\$cs=connection(CONNECT,\$database);\n";
	$script.="\tif(empty(\$event)) \$event=\"onLoad\";\n";
	$script.="\tif(\$event==\"onRun\") {\n";
	$script.="\t\t\$sql=\"delete from $table where $indexfield='\$$indexfield'\";\n";
	$script.="\t\t\$stmt = \$cs->query(\$sql);\n";
	$script.="\t\tinclude('".$pa_filename."_browse".$extension."')\n";
	$script.="\t}\n";
	$script.="?>\n";
	$script.=script_browse($database, $table, $pa_filename, $page_id, $indexfield, $secondfield, $A_sqlFields, $cs, $with_frames);
	$script.=script_footer();

	return $script;
}

function get_tab_ides() {
	global $database;
	
	$sql="select m.me_id ";
	$sql.="from menus m, dictionary d ";
	$sql.="where m.di_name=d.di_name ";
	$sql.="and d.di_name like 'mk%' ";
	$sql.="order by m.me_id";
	
	$cs=connection(CONNECT, $database); 
	
	$stmt = $cs->query($sql);
	$tab_ides=(array) null;
	$i=0;
	while($rows=$stmt->fetch()) {
		$tab_ides[$i]=$rows[0];
		$i++;
	}
	
	return $tab_ides;
}




