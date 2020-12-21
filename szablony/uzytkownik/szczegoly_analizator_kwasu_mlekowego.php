<?php
	require_once "rozchodniaczki/connect.php";
	
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno;
	}
	else
	{
		$id_klienta = $_SESSION['id_klienta'];

		echo '<table>';
		echo '<tr>';
		echo '<td>stezenie</td>';
		echo '</tr>';
		
		foreach($_POST as $key => $name)
		{
			$id_badania = $key;
		}
		$sql = "SELECT * FROM analizator_kwasu_mlekowego WHERE id_badania = '$id_badania'";
		if($result = @$connection->query($sql))
		{
			for($i=0; $i < $result->num_rows; $i++)
			{
				$row = $result->fetch_assoc();
				$stezenie = $row['stezenie'];
				echo "<tr><td>$stezenie</td></tr>";
			}		
			$result->free_result();
		}
		echo '</table>';
		
		$connection->close();
	}

?>