<html><body><pre>
<?php 
	require "openconn.php";
	dbconnection("connect");
	$cs->select_db($d);
 	$sql=urldecode($q);
	$stmt = $cs->query($sql);
	if($result) {
		$i=$result->num_fields();
		$k=0;

		// Get recordset field names
		$line="";
		for($j=0; $j<$i; $j++)
		{
			$fieldname=mysqli_field_name($result, $j);
			if (strpos($fieldname, " ")==0)
				$line=$line . $fieldname . ",";
			else
				$line=$line . "\"" . $fieldname . "\"" . ",";
		}
		$line=substr($line, 0, strlen($line)-1);
		echo $line . "\n";

		// Get recordset field types
		$line="";
		for($j=0; $j<$i; $j++)
			$line=$line . mysqli_field_type($result, $j) . ",";
		$line=substr($line, 0, strlen($line)-1);
		echo $line . "\n";

		// Get recordset data rows
		while($rows=$stmt->fetch())
		{
			echo $k . "=";
			$line="";
			for($j=0; $j<$i; $j++)
			{
				if (strpos($rows[$j], " ")==0)
					$line=$line . $rows[$j] . ",";
				else
					$line=$line . "\"" . $rows[$j] . "\"" . ",";
			}
			$line=substr($line, 0, strlen($line)-1);
			echo $line . "\n";
			$k++;
		}
		$result->free_result();
	}
?>
</pre></body></html>
