<html lang="en" debug="true" >
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>Puzzle WebFactory</title>
</head>
<body text="#000000" link="#888888" vlink="#880000" alink="#FF0000" leftmargin="0" topmargin="0" style="text-align:center;background-color:#FFFFFF;">
<?php
    session_start();
    
    include 'phink/phink_library.php';
    include 'puzzle/ipuzzle_library.php';
    include(PZ_DEFAULTS);

    //$default_include_path = ini_get("include_path");
    //ini_set("include_path","$default_include_path:/usr/share/php/ipuzzle.inc/");

    $menus = new Puzzle\Menus($lg, $db_prefix);
    $index = $menus->getPageId($database, "mkmain.php");

    $version = file_get_contents("VERSION");

    $img="img";
?>
	<div style="position:absolute;z-index:1;margin-top:150;margin-left:150">
		<table border="0" cellpadding="0" cellspacing="0"><tr><td>
		<img
			id="logo"
			src="<?php    echo $img?>/big_logo.png"
			height="202" width="724"
			onMouseOut="PZ_IMG.src='<?php    echo $img?>/big_logo.png';"
			onMouseOver="PZ_IMG=document.getElementById('logo'); PZ_IMG.src='<?php    echo $img?>/big_logo_light.png';"
			onClick="document.location.href='page.php?id=<?php    echo $index?>&lg=fr';"
		>
		</td></tr>
		<tr><td align="center">
			Puzzle webfactory version <?php    echo $version?> (C) 2003-2004 DPJB
		</td></tr>
		</table>
	</div>
</body>
</html>
