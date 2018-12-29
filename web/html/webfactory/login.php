<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" dir="ltr">
<head>
<title>Puzzle WebFactory</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php     
	session_start();
	include_once 'puzzle/ipz_style.php';
	include_once 'puzzle/ipz_misc.php';
	include(PZ_DEFAULTS);
	include_once 'puzzle/ipz_menus.php';
	include_once 'puzzle/ipz_blocks.php';

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

//	if(!session_is_registered("javascript")) {
//		session_register("javascript");
//	}
	$_SESSION["javascript"]="";
//	if(!session_is_registered("ses_apps_login")) {
//		session_register("ses_apps_login");
//	}
	//$_SESSION["ses_apps_login"]=true;
        if($_POST['mbr_login'] != '') {
            $_SESSION["ses_login"] = $_POST['mbr_login'];
            $_SESSION["ses_pass"] = $_POST['mbr_pass'];
        }

	global $img;
	$img="images";
?>
</head>
<body bgcolor="<?php    echo $back_color?>" text="<?php    echo $text_color?>" link="<?php    echo $link_color?>" vlink="<?php    echo $vlink_color?>" alink="<?php    echo $alink_color?>" leftmargin="0" topmargin="0">
<center>
<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
<tr>
	<td style="height: 30" align="center" valign="middle">
		&nbsp;
	</td>
</tr>
	
	<?php    
                header('location: page.php?id=24&lg=fr');
                exit();
                $ses_login=$_SESSION["ses_login"];
		$status=$_SESSION["ses_status"];
		$authentication=get_authentication($ses_login);
		
		// if($authentication) {
		// 	$admin_url=get_admin_url($database);
		// 	$js="<script language='JavaScript'>window.location.href='page.php?lg=$lg'</script>";
		// } else {
		// 	if($status==MEMBER_LOGGED_IN) {
		// 		session_destroy();
		// 		$js="<script language='JavaScript'>window.location.href='login.php?lg=$lg';</script>";
		// 		echo $js;
			// } else {
	?>
<tr>
	<td align="center" valign="middle" height="88">
	  <img
		id="logo"
	  	src="<?php    echo $img?>/logo.png"
		onMouseOut="PZ_IMG.src='<?php    echo $img?>/logo.png';"
		onMouseOver="PZ_IMG=document.getElementById('logo');PZ_IMG.src='<?php    echo $img?>/logo_light.png';"
	  	onClick="document.location.href='<?php    echo "."?>'"
	  >
	</td>
</tr>
<tr>
	<td style="font-size: 20; color: red; height: 30;" align="center" valign="middle">
		<b><i>Module d'Administration</i></b><br>
	</td>
</tr>
<tr>
	<td align="center" valign="middle">
	<?php    
				$members_block=create_members_block($database, $logout, "members", $id, $lg, $panel_colors);
				echo $members_block."\n\n";
			
				$js=perform_members_ident($mbr_login, $mbr_pass, $mbr_valider);
	?>
	</td>
</tr>
	<?php    
			// }
		// }
		echo $js;
	?>

<tr>
	<td style="height: 150" align="center" valign="middle">
		&nbsp;
	</td>
</tr>
</table>

</center>
<script language="JavaScript">
<?php     
	//if(file_exists($filename)) include($filename);
	echo $_SESSION["javascript"];
?>
</script>

</body>
</html>