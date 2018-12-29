<html><head><meta http-equiv="content-type" content="text/html; charset=UTF-8"></head><body><pre>
<?php 
	define("CRLF", "\n");
	echo CRLF;
	include("./openconn.php");
	$cnx=dbconnection("connect");
	$ua=$_SERVER["HTTP_USER_AGENT"];
	//echo $ua."C'est bien lui que je recois.";
	if(isset($_GET["d"])) $d=$_GET["d"]; else $d="mysql";
	if(isset($_GET["q"])) $q=$_GET["q"];
	$cs->select_db($d, $cnx);
 	$sql=urldecode($q);
	$result=$cs->query($sql, $cnx);
	if($result) {
		$i=$result->num_fields();
		$k=0;

		// Get row count only if $rc is mentionned with walue 1
		$line="";
		if(isset($_GET["rc"])) {
			$p=strpos($sql, "limit");
			$sql2=$sql;
			if($p>0) $sql2=substr($sql,0,$p-1);
			$result2=$cs->query($sql2);
			$line=$result->num_rows(2);
		}
		echo $line . CRLF;
		
		// Get recordset field names
		$line="";
		for($j=0; $j<$i; $j++) {
			$fieldname=mysqli_field_name($result, $j);
			if (strpos($fieldname, " ")==0)
				$line=$line . $fieldname . ",";
			else
				$line=$line . "\"" . $fieldname . "\"" . ",";
		}
		$line=substr($line, 0, strlen($line)-1);
		echo $line . CRLF;

		// Get recordset field sizes
		$line="";
		for($j=0; $j<$i; $j++)
			$line=$line . mysqli_field_len($result, $j) . ",";
		$line=substr($line, 0, strlen($line)-1);
		echo $line . CRLF;

		// Get recordset field types
		$line="";
		for($j=0; $j<$i; $j++)
			$line=$line . mysqli_field_type($result, $j) . ",";
		$line=substr($line, 0, strlen($line)-1);
		echo $line . CRLF;

		// Get recordset data rows
		while($rows=$stmt->fetch()) {
			//echo $k . "=";
			$line="";
			for($j=0; $j<$i; $j++) {
				//$line=$line . "\"" . $rows[$j] . "\"" . ",";
				$line=$line . $rows[$j] . "|";
			}
			$line=substr($line, 0, strlen($line)-1);
			echo $line . CRLF;
			$k++;
		}
		$result->free_result();
	}
?>
</pre></body></html>
