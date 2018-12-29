<center>
<?php   
	echo "<br>";
		
	$tab_ctrl_name="myTab";
	//Options de départ
	$rad_choice = ['', '', ''];
	$choice = get_variable('choice', 0);
	$rad_choice[$choice]=" checked"; 
	
	$tab_ides=get_tab_ides();
	
	$on_click="var index=get_radio_value(\"myTabForm\", \"choice\");";
	$on_click.=js_array("myTabCaptions", $tab_ides);
	$on_click.="location.href=\"page.php?id=\"+myTabCaptions[index]+\"&lg=$lg\";";
	
	$tab_start="
	<fieldset style='width:450px'>
	<legend>Créer un script, un menu, un bloc ...</legend>
	<table border='0' bordercolor='0' width='85%' valign='top' style='display:hidden;'>
	<tr><td>&nbsp;</td><td>
	<label><input type='radio'".$rad_choice[0]." name='choice' value='0'>Auto-générer un script à partir d'une table<label><br>
	<label><input type='radio'".$rad_choice[1]." name='choice' value='1'>Créer une nouvelle entrée de menu</label><br>
	<label><input type='radio'".$rad_choice[2]." name='choice' value='2'>Créer un nouveau bloc</label>&nbsp;
	</td><td>&nbsp;</td></tr>
	<tr><td colspan='2' align='center'>
	<br><input type='button' name='action' value='Suivant >>' onClick='$on_click'>
	</td></tr>
	</table>
	</fieldset>
	";
	

	echo "<form method='post' name='myTabForm'>\n";
	echo $tab_start;
	echo "</form>\n";
		
?>
</center>
