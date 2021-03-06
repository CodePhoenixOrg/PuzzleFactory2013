<html lang="fr" debug="true" >
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<link rel="stylesheet" href="/css/default.css" type="text/css" />

	<title>Akadès</title>
<?php  

	header('P3P: PolicyRef="/w3c/p3p.xml" CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"');
?>
	<meta name="Generator" content="PHP Eclipse, Vi">
	<meta name="Description" content="iPuzzle.net Project">
	<meta name="Keywords" content="ipuzzle, puzzle, web, creation, programmation, development, new, technology, technologie, technologies, php, csharp, c sharp, c#, mysql, microsoft, dotnet, .net, open source, opensource, linux">
	<meta name="Identifier-URL" content="http://www.ipuzzle.net/">
	<meta name="Robot" content="index, follow">
	<meta name="Reply-to" content="dpjb@free.fr">
	<meta name="Category" content="Internet">
	<meta name="Copyright" content="(C)2004 David Blanchard">
<?php
	
	// include_once 'puzzle/ipz_style.php';
	session_start();
    include 'phink/phink_library.php';
	require 'puzzle/ipuzzle_library.php';

	include(PZ_DEFAULTS);

	use Phink\Log\TLog;

	// include_once 'puzzle/ipz_menus.php';
	// include_once 'puzzle/ipz_blocks.php';

	$_SESSION["javascript"]="";
	$_SESSION["ses_apply_skin"]="N";

	$lg = getArgument("lg", "fr");
	$id = getArgument("id", 1);
	$di = getArgument("di");

	$menus = new \Puzzle\Menus($lg, $db_prefix);
	
	$main_menu = $menus->createMainMenu($database, 1);
	$sub_menu = $menus->createSubMenu($database, 1, SUB_MENU_HORIZONTAL);

	$toplinks=$main_menu["menu"];
	$default_id=$main_menu["index"];

	if($di !== '') {
		$title_page = $menus->retrievePageByDictionaryId($database, $di, $lg);
		$id=$title_page["index"];
	} else {
		// $title_page = retrievePageByMenuId($database, $id, $lg);
		$title_page = $menus->retrievePageById($database, $id, $lg);
		$di=$title_page["index"];
	}
	
	TLog::create()->dump("TITLE PAGE", $title_page);

	$title = $title_page["title"];
	$page = $lg . "/" . $title_page["page"];
	TLog::create()->dump("TITLE PAGE", $page);

	
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

	global $img;
	$img="img";
	
?>
<body bgcolor="<?php echo $back_color?>" text="<?php echo $text_color?>" link="<?php echo $link_color?>" vlink="<?php echo $vlink_color?>" alink="<?php echo $alink_color?>" leftmargin="0" topmargin="0">
<center>
  <table id="my_table_shadow" border="0" cellspacing="0" cellpadding="0">
    <tr><td bgcolor="white" height="3" colspan="2"></td></tr>
    <tr>
      <td rowspan="2" colspan="2">
      <table border="1" cellpadding="0" cellspacing="0" height="760" width="760" valign="top"><tr><td>
      <table id="my_table" bgcolor="white" border="0" bordercolor="black" cellpadding="0" cellspacing="0" height="100%" width="100%"><tr>
      <td colspan="3"> 
      <table background="img/ipz_banner.png"  border="0" bordercolor="black" cellpadding="0" cellspacing="0" height="100%" width="100%"><tr>
      <td height="80">
<!--img style="height:80px;" id="logo" src="<?php echo $img?>/ipz_logo_banner.jpg"
				onMouseOut="PZ_IMG.src='<?php echo $img?>/ipz_logo_banner.jpg';"
				onMouseOver="PZ_IMG=document.getElementById('logo');PZ_IMG.src='<?php echo $img?>/ipz_logo_banner2.jpg';"
			  	onClick="document.location.href='<?php echo "."?>'"
			--></td><td style="font-size:30;text-align:right;text-valign:middle"><?php echo $title?>&nbsp;<!--img src="<?php echo $img?>/admin/<?php echo $di?>.png" valign="top" border="0"--></td>
</tr>
</table>
		</td>
	</tr>
	<tr>
		<td colspan="3" background="<?php echo $img?>/menu_tube.jpg" height="20" align="center" valign="top">
		<?php
			echo $toplinks;
			//echo "<br>".$sub_menu;
		?>
		</td>
	</tr>
	<!--tr>
		<td colspan="3" bgcolor="black" height="0" align="center" valign="top"></td>
	</tr-->
	<!--tr bgcolor="#EEEEEE"-->
	<!--tr bgcolor="#00afff"-->
	<tr bgcolor="#1680d9">
		<td colspan="1" align="left" valign="top" height="680">
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
		<font face="helvetica"><center><!--H2>
		<?php  
			echo $title."<br>";
		?>
	      </H2--></font></center>
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
      <td background="<?php echo $img?>/shadows/_top_right.png" style="font-size: 1; width:11; height:8;"></td>
    </tr>
    <tr>
      <td id="my_table_sh" background="<?php echo $img?>/shadows/_right.png" style="font-size: 1; width:11;"></td>
    </tr>
    <tr>
      <td background="<?php echo $img?>/shadows/_bottom_left.png" style="font-size: 1; width:8; height:11;"></td>
      <td id="my_table_sw" background="<?php echo $img?>/shadows/_bottom.png" style="font-size: 1; height: 11"></td>
      <td background="<?php echo $img?>/shadows/_bottom_right.png" style="font-size: 1; width:11; height:11;"></td>
    </tr>
  </table>
</center>
<?php
	if($mbr_login!="" && $mbr_pass!="") {
		$msg = $blocks->performMembersIdent($mbr_login, $mbr_pass, $mbr_valider);
		echo $msg;
	}
	if($nlr_email!="") {
		$js = $blocks->performNewsletterSubscription($nlr_email, $nlr_subscribe, $nlr_valider);
		echo $js;
	}
?>
<script type="text/JavaScript">
	pz_shadow("my_table");
	<?php echo $_SESSION["javascript"];?>
</script>
</body>
</html>
