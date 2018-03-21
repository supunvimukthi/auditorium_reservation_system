<?php
	function create_combo($c_sql,$c_name,$c_value,$c_text)
	{
		include ("include/dbcon.inc.php");
		
		echo "<select class='input' name=\"$c_name\">";
						echo "<option value=\"\"></option>";
						
						$sql_query = $c_sql;//sql query
						$sql = $conn->prepare($sql_query);
						$sql->execute();
						
						$numRows = $sql->fetchAll();
						if(count($numRows)>0)
						{
							foreach($numRows as $row)
							{
								//$citysno = $row['citysno'];
								//$cityname = $row['cityname'];
								//echo "<option value=\"$citysno\">$cityname</option>";
											//OR
								echo "<option value=\"$row[$c_value]\">".$row[$c_text]."</option>";//With single Line
							}
						}
	}
?>