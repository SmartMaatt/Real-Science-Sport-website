<?php
	require_once "connect.php";
	
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno;
	}
	else
	{
		foreach($_POST as $key => $name)
		{
			$id_z = $key;
		}
		$sql = "DELETE FROM zamowienia WHERE id_zamowienia = '$id_z'";
		echo "$sql";
		@$connection->query($sql);
		$connection->close();
		header('Location: ../gastro.php');
	}
?>