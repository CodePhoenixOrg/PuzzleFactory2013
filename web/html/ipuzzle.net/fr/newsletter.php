<?php 
	include_once("puzzle/ipz_db.php");
	include_once("puzzle/ipz_mysqlconn.php");
	$cs=connection("connect","puzzle");

	if(empty($event)) $event="onLoad";
	if(empty($action)) $action="Ajouter";
?>
	<form method='POST' name='myForm' action='page.php?id=&lg=fr'>
	<table width='100%' height='100%'>
		<tr><td align='center' valign='middle'>
			<table><tr><td>
<?
	if($event=="onLoad") {
		$sql="select nlr_email,  from newsletter;";
		$colors=array();
		fiche_sql('newsletter', $sql, '', '', 'page.php', '/puzzle/img/Editer.png', '', '', '', $colors, $cs);
	} else if($event=="onRun") {
		$cs=connection("disconnect","puzzle");
		echo "<script language='JavaScript'>window.location.href='page.php?id=&action=Ajouter'</script>";
	} else if($event=="onUnload") {
		$cs=connection("disconnect","puzzle");
		echo "<script language='JavaScript'>window.location.href='page.php?id=1&lg=fr'</script>";
	}
?>
			</td></tr>
<tr>
				<input type='hidden' name='event' value=''>
				<td><input type='submit' name='action' value='<?php echo $action?>' onClick='return runForm();'></td>
				<td><input type='submit' name='action' value='Fermer' onClick='return unloadForm();'></td>
			</tr></table>
		</td></tr></table>
</form>
<script language='JavaScript'>
	function runForm() {
		document.myForm.event.value='onRun';
		document.myForm.submit();
	}

	function unloadForm() {
		document.myForm.event.value='onUnload';
		document.myForm.submit();
	}
</script>
