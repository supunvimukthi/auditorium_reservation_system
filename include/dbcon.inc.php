<?php

	$Database = "db_auditorium";
	$Hostname = "localhost";
	$Username = "root";
	$Password = "";
	
	try
	{
		$conn = new PDO ("mysql:host=$Hostname;dbname=$Database",$Username,$Password);
		$conn -> setAttribute (PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e)
	{
		echo "Error Found</br>".$e->getMessage();
	}
?>