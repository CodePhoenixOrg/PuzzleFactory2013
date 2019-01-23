<html lang="fr" debug="true" >
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<link rel="stylesheet" href="/css/default.css" type="text/css" />
	<title>Puzzle WebFactory</title>
<?php     
	session_start();
	//$include_path = ini_get("include_path");
	//ini_set("include_path","$default_include_path:/usr/share/php/ipuzzle.inc/");

	include 'puzzle/ipuzzle_library.php';
	include(PZ_DEFAULTS);
	
//	if(!session_is_registered("javascript")) {
//		session_register("javascript");
//	}
	$_SESSION["javascript"]="";
	
	$lg = getVariable("lg", "fr");
	$id = getVariable("id", 1);
	$di = getVariable("di");

	$menus = new Puzzle\Menus($lg, $db_prefix);
	$design = new Puzzle\Design();
	$scriptMaker = new Puzzle\ScriptsMaker();

	$admin_menu = $menus->createMainMenu($database, 3);
	$user_menu = $menus->createMainMenu($database, 1);
	$sub_menu = $menus->createSubMenu($database, 1, SUB_MENU_HORIZONTAL);
	$toplinks = $admin_menu["menu"];
	$userlinks = $user_menu["menu"];
	$default_id = $admin_menu["index"];

	if($di !== '') {
		$title_page = $menus->retrievePageByDictionaryId($database, $di, $lg);
		$id=$title_page["index"];
	} else {
		// $title_page = retrievePageByMenuId($database, $id, $lg);
		$title_page = $menus->retrievePageById($database, $id, $lg);
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

	$img="img";
	
	//$ses_login=$_SESSION["ses_login"];
	//$authentication=getAuthentication($ses_login);

	//if($authentication) {
        $border_color = "eeeeee";
?>

</head>

<body bgcolor="<?php    echo $back_color?>" text="<?php    echo $text_color?>" link="<?php    echo $link_color?>" vlink="<?php    echo $vlink_color?>" alink="<?php    echo $alink_color?>" leftmargin="0" topmargin="0">

<center>


<table id="my_tableShadow" border="0" cellspacing="0" cellpadding="0">
    <tr><td bgcolor="white" height="3" colspan="2"></td></tr>
    <tr>
      <td rowspan="2" colspan="2">
		<table border="1" cellpadding="0" cellspacing="0" height="760" width="760" valign="top"><tr><td>
		<table id="my_table" bgcolor="white" border="0" bordercolor="black" cellpadding="0" cellspacing="0" height="100%" width="100%"><tr>
		<td colspan="3"> 
		<table  border="0" bordercolor="black" cellpadding="0" cellspacing="0" height="100%" width="100%"><tr>
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
	</tr></tr>
</table>
		</td>
	</tr>
	<tr>
		<td colspan="3" bgcolor="black" height="8" align="center" valign="top">
		<?php    
			echo $toplinks;
		?>
		</td>
	</tr>
	<tr>
		<td colspan="3" background="<?php echo $img?>/menu_tube.jpg" height="20" align="center" valign="top">
		<?php    
			echo $userlinks;
		?>
		</td>
	</tr>	
	<tr>
		<td colspan="3" bgcolor="black" height="1" align="center" valign="top"></td>
	</tr>
	<!-- bgcolor="#a8eaff" 1680d9-->
	<tr bgcolor="#a8eaff">
		<td colspan="1" valign="top" width="100" height="100%">
		<?php  
			if(!isset($logout)) $logout=0;
			if(!isset($panel_colors)) $panel_colors=array();
			if(!isset($mbr_login)) $mbr_login="";
			if(!isset($mbr_pass)) $mbr_pass="";
			if(!isset($mbr_valider)) $mbr_valider="";
			
			$blocks = new \Puzzle\Blocks($lg, $db_prefix);
			$block_set= $blocks->createEnhancedBlockSet($database, BLOCK_LEFT_COLUMN, $id, $lg, $panel_colors);
			echo $block_set."\n\n";
		?>
	
	    </td>

		<td colspan="1" valign="top" width="600" bgcolor="#EEEEEE">
		<font face="helvetica"><center>
		<?php  
			echo $title."<br>";
		?>
	    </font></center>
		<?php  
 			include $page;
		?>
		</td>
		<td colspan="1" valign="top" width="100" height="100%">
		<?php 
			if(!isset($nlr_email)) $nlr_email="";
			if(!isset($nlr_subscribe)) $nlr_subscribe="";
			if(!isset($nlr_valider)) $nlr_valider="";
			if(!isset($date)) $date="";
			
			$block_set = $blocks->createEnhancedBlockSet($database, BLOCK_RIGHT_COLUMN, $id, $lg, $panel_colors);
			echo $block_set."\n\n";
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
