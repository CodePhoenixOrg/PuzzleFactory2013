<html lang="fr" debug="true" >
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">

<title>Puzzle WebFactory</title>
<?php     
	session_start();
	//$include_path = ini_get("include_path");
	//ini_set("include_path","$default_include_path:/usr/share/php/ipuzzle.inc/");
	include_once 'puzzle/ipz_style.php';
	include_once 'puzzle/ipz_misc.php';
	include(PZ_DEFAULTS);

	include_once 'puzzle/ipz_menus.php';
	include_once 'puzzle/ipz_blocks.php';
	include_once 'puzzle/ipz_controls.php';
	include_once 'puzzle/ipz_db_controls.php';
	include_once 'puzzle/ipz_mkscripts.php';
	
//	if(!session_is_registered("javascript")) {
//		session_register("javascript");
//	}
	$_SESSION["javascript"]="";
	
	$lg = get_variable("lg", "fr");
	$id = get_variable("id", 1);
	$di = get_variable("di");

	$menus = new Menus($lg, $db_prefix);
	
	$main_menu = $menus->create_main_menu($database, 1);
	$sub_menu = $menus->create_sub_menu($database, 1, SUB_MENU_HORIZONTAL);
	$toplinks=$main_menu["menu"];
	$default_id=$main_menu["index"];

	if($di !== '') {
		$title_page = $menus->retrieve_page_by_dictionary_id($database, $di, $lg);
		$id=$title_page["index"];
	} else {
		// $title_page = retrieve_page_by_menu_id($database, $id, $lg);
		$title_page = $menus->retrieve_page_by_id($database, $id, $lg);
		$di=$title_page["index"];
	}

	$title = $title_page["title"];
	$page = $lg . "/" . $title_page["page"];

	
	if(!empty($page_colors)) {
		$back_color=$page_colors["back_color"];
		$text_color=$page_colors["text_color"];
		$link_color=$page_colors["link_color"];
		$vlink_color=$page_colors["vlink_color"];
		$alink_color=$page_colors["alink_color"];
	} else {
		$back_color="white";
		$text_color="black";
		$link_color="black";
		$vlink_color="black";
		$alink_color="black";
	}

	$img="images";
	
	//$ses_login=$_SESSION["ses_login"];
	//$authentication=get_authentication($ses_login);

	//if($authentication) {
        $border_color = "eeeeee";
?>

</head>

<body bgcolor="<?php    echo $back_color?>" text="<?php    echo $text_color?>" link="<?php    echo $link_color?>" vlink="<?php    echo $vlink_color?>" alink="<?php    echo $alink_color?>" leftmargin="0" topmargin="0">

<center>
  <table id="my_table_shadow" border="0" cellspacing="0" cellpadding="0">
    <tr><td bgcolor="white" height="3" colspan="2"></td></tr>
    <tr>
      <td rowspan="2" colspan="2">

<table border="1" cellpadding="0" cellspacing="0" height="760" width="760" valign="top"><tr><td>
<table id="my_table" bgcolor="white" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
	<tr height="80">
		<td width="250" height="80" align="left" valign="top" style="font-size: 14;">
			<img id="logo"
	  			src="<?php    echo $img?>/small_logo.png"
				onMouseOut="PZ_IMG.src='<?php    echo $img?>/small_logo.png';"
				onMouseOver="PZ_IMG=document.getElementById('logo');
						PZ_IMG.src='<?php    echo $img?>/small_logo_light.png';"
			  	onClick="document.location.href='<?php    echo "."?>'"
	  		>
		</td>
		<td style="font-size: 30" width="510" height="80" align="right" valign="middle">
			<!--img src="<?php    echo $img?>/admin/<?php    echo $di?>.png" valign="top" border="0"-->
			<?php    echo $title?>
			&nbsp;
		</td>
	</tr>
	<tr>
		<td colspan="2" bgcolor="black" height="8" align="center" valign="top">
		<?php    
			echo $toplinks;
			//echo "<br>".$sub_menu;
		?>
		</td>
	</tr>
	<tr>
		<td colspan="2" bgcolor="black" height="1" align="center" valign="top"></td>
	</tr>
	<tr bgcolor="#a8eaff">
		<td colspan="2" align="left" valign="top" height="680">
		<?php    
			include($page);
		?>
		</td>
	</tr>
</table>
</td></tr></table>

      </td>
      <td background="<?php    echo $img?>/shadows/<?php   echo $border_color?>_top_right.png" style="font-size: 1; width:11; height:8;"></td>
    </tr>
    <tr>
      <td id="my_table_sh" background="<?php    echo $img?>/shadows/<?php   echo $border_color?>_right.png" style="font-size: 1; width:11;"></td>
    </tr>
    <tr>
      <td background="<?php    echo $img?>/shadows/<?php   echo $border_color?>_bottom_left.png" style="font-size: 1; width:8; height:11;"></td>
      <td id="my_table_sw" background="<?php    echo $img?>/shadows/<?php   echo $border_color?>_bottom.png" style="font-size: 1; height: 11"></td>
      <td background="<?php    echo $img?>/shadows/<?php   echo $border_color?>_bottom_right.png" style="font-size: 1; width:11; height:11;"></td>
    </tr>
  </table>
</center>
<script language="JavaScript">
	pz_shadow("my_table");

<?php     
	echo $_SESSION["javascript"];
?>
</script>
</body>
<?php    
	/*} else {
		echo "<script language='JavaScript'>window.location.href='login.php?lg=$lg';</script>";
	}*/
?>
</html>