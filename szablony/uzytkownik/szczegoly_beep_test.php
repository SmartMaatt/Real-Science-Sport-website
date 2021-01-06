<?php

	if (session_status() == PHP_SESSION_NONE) {
		header('Location: ../../logowanie.php');
	}

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
		echo '<td>level</td>';
		echo '<td>hr_max</td>';
		echo '</tr>';
		
		foreach($_POST as $key => $name)
		{
			$id_badania = $key;
		}
		$sql = "SELECT * FROM beep_test WHERE id_badania = '$id_badania'";
		if($result = @$connection->query($sql))
		{
			for($i=0; $i < $result->num_rows; $i++)
			{
				$row = $result->fetch_assoc();
				$level = $row['level'];
				$hr_max = $row['hr_max'];
				echo "<tr><td>$level</td><td>$hr_max</td></tr>";
			}		
			$result->free_result();
		}
		echo '</table>';
		echo '<a href="rozchodniaczki/id_opcji.php?o='.$_SESSION['id_opcji'].'&p='.$_SESSION['id_podopcji'].'&b=-1" class="btn btn-danger">Wróć</a>';
		
		$connection->close();
	}
?>