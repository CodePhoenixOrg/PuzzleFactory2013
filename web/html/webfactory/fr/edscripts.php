<?php   
	include_once 'puzzle/ipz_style.php';
	include_once 'puzzle/ipz_mysqlconn.php';
	include_once 'puzzle/ipz_misc.php';

	$cs=connection(CONNECT, $userdb);
	if(empty($lg)) $lg='fr';

	$wwwroot=get_www_root();
	$filepath="$wwwroot/../$userdb/fr/$pa_filename";
	echo "filepath=$filepath<br>";
		
if(empty($valider)) {
	switch($action) {
	case "Ajouter":
		$sql="select max(me_id) from menus";
		$stmt = $cs->query($sql);
		$rows=$stmt->fetch();
		$me_id=$rows[0]+1;

		$sql="select max(pa_id) from pages";
		$stmt = $cs->query($sql);
		$rows=$stmt->fetch();
		$new_pa_id=$rows[0]+1;
		
		$pa_id=0;
		$me_target="";
		$me_level="";
		$di_name="";
		$pa_filename="";
		$di_fr_short="";
		$di_fr_long="";
		$di_en_short="";
		$di_en_long="";
	break;
	case "Modifier":
		$sql="select * from v_menus where me_id=$me_id";
		$stmt = $cs->query($sql);
		$rows=$stmt->fetch();
		$me_id=$rows[0];
		$pa_id=$rows[1];
		$me_target=$rows[2];
		$me_level=$rows[3];
		$di_name=$rows[4];
		$pa_filename=$rows[5];
		$di_fr_short=$rows[6];
		$di_fr_long=$rows[7];
		$di_en_short=$rows[8];
		$di_en_long=$rows[9];
	break;	
	}
} else {
	switch($action) {
	case "Ajouter":
		$sql=   "insert into menus " .
			"values($me_id, '$di_name', '$me_level', '$me_target', $pa_id)" ;
		echo "$sql<br>";
		$stmt = $cs->query($sql);
		
		$sql=   "insert into pages " .
			"values($new_pa_id, '$di_name', '$pa_filename')" ;
		echo "$sql<br>";
		$stmt = $cs->query($sql);
		
		$sql=   "insert into dictionary " .
			"values('$di_name', '$di_fr_short', '$di_fr_long', '$di_en_short', '$di_en_long')" ;
		echo "$sql<br>";
		$stmt = $cs->query($sql);

		copy("includes/fichier_vide.php", "fr/$pa_filename");
		copy("includes/fichier_vide.php", "en/$pa_filename");
		
	break;
	case "Modifier":
		$sql=   "update menus set di_name='$di_name', me_level='$me_level', me_target='$me_target', pa_id=$pa_id ".
			"where me_id=$me_id";
		$stmt = $cs->query($sql);
		$sql=   "update pages set di_name='$di_name', pa_filename='$pa_filename'".
			"where pa_id=$pa_id";
		$stmt = $cs->query($sql);
		$sql=   "update menus set di_fr_short='$di_fr_short', di_fr_long='$di_fr_long', di_en_short='$di_en_short', di_en_long='$di_en_long'".
			"where di_name=$di_name";
		$stmt = $cs->query($sql);
	break;
	case "Supprimer":
		$sql="delete from menus where di_name='$di_name'";
		$stmt = $cs->query($sql);
		$sql="delete from pages where di_name='$di_name'";
		$stmt = $cs->query($sql);
		$sql="delete from dictionary where di_name='$di_name'";
		$stmt = $cs->query($sql);
		
		unlink($filepath);
	break;	
	}
	echo "<script language=Javascript>window.location.href='page.php&di=home'</script>";
}
?> 
<form method="post" action="<?php   echo $PHP_SELF?>">
<table>
<tr><td>Index de menu</td><td><?php    echo $me_id ?></td></tr>
  <input type="hidden" name="me_id" value="<?php   echo $me_id?>">
  <tr><td>Index de page</td><td><?php    echo $new_pa_id ?></td></tr>
  <input type="hidden" name="new_pa_id" value="<?php   echo $new_pa_id?>">
  <?php   
  	if(empty($pa_id)) $pa_id=$new_pa_id;
  ?>
  <tr><td>Référence à la page</td><td><input type="text" name="pa_id" value='<?php    echo $pa_id ?>'></td><td>
  Un index de référence différent de l'index de page permet de placer cette page en sous-menu.<br>Le sous-menu a généralement un niveau de menu à 2 ou 0 (invisible)
  </td></tr>
  <?php   
  	if(empty($me_target)) $me_target="page";
  ?>
  <tr><td>Cible dans la page</td><td><input type="text" name="me_target" value='<?php    echo $me_target ?>'></td><td>
  paramètre "page" par défaut
  </td></tr>
  <?php   
  	if(empty($me_level)) $me_level=0;
  ?>
  <tr><td>Niveau de menu </td><td><input type="text" name="me_level" value='<?php    echo $me_level ?>'></td><td>
  0=hors des menus, 1=menu en haut, 2=menu sur le côté
  </td></tr>
  <tr><td>Nom de la page</td><td><input type="text" name="pa_filename" value='<?php    echo $pa_filename ?>'></td><td>
  ne pas oublier l'extension de la page (ex: .php, .html)
  </td></tr>
  <tr><td>Index du dictionnaire</td><td><input type="text" name="di_name" value='<?php    echo $di_name ?>'></td><td>
  nom tres réduit servant d'index, 8 lettres maxi
  </td></tr>
  <tr><td>Libellé français court</td><td><input type="text" name="di_fr_short" value='<?php    echo $di_fr_short ?>'></td><td>Obligatoire. Donne un nom litéral à la page.<br>Il est prioritairement placé dans les menus.
  </td></tr>
  <tr><td>Libellé français long</td><td><input type="text" name="di_fr_long" value='<?php    echo $di_fr_long ?>'></td><td>Facultatif. Donne un nom explicite à la page situé entre le contenu de la page et le menu du haut<br>En l'absence de nom long, le nom court est utilisé.
  </td></tr>
  <tr><td>Libellé anglais court</td><td><input type="text" name="di_en_short" value='<?php    echo $di_en_short ?>'></td><td>Recommendé.
  </td></tr>
  <tr><td>Libellé anglais long</td><td><input type="text" name="di_en_long" value='<?php    echo $di_en_long ?>'></td><td>Facultatif.
  </td></tr>
  </table>
  <input type="hidden" name="valider" value="OK">
  <input type="hidden" name="database" value="<?php   echo $userdb?>">
  <input type="submit" name="action" value="<?php   echo $action?>">
  <input type="submit" name="action" value="Supprimer">
  <input type="submit" name="annuler" value="Annuler">
</form>







