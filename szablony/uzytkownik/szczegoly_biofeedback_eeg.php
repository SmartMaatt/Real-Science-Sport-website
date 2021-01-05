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
		echo '<td>delta</td>';
		echo '<td>theta</td>';
		echo '<td>alpha</td>';
		echo '<td>smr</td>';
		echo '<td>beta 1</td>';
		echo '<td>beta 2</td>';
		echo '<td>hibeta</td>';
		echo '<td>gamma</td>';
		echo '</tr>';
		
		foreach($_POST as $key => $name)
		{
			$id_badania = $key;
		}
		$sql = "SELECT * FROM biofeedback_eeg WHERE id_badania = '$id_badania'";
		if($result = @$connection->query($sql))
		{
			for($i=0; $i < $result->num_rows; $i++)
			{
				$row = $result->fetch_assoc();
				$delta = $row['delta'];
				$theta = $row['theta'];
				$alpha = $row['alpha'];
				$smr = $row['smr'];
				$beta1 = $row['beta1'];
				$beta2 = $row['beta2'];
				$hibeta = $row['hibeta'];
				$gamma = $row['gamma'];
				echo "<tr><td>$delta</td></tr>";
				echo "<tr><td>$theta</td></tr>";
				echo "<tr><td>$alpha</td></tr>";
				echo "<tr><td>$smr</td></tr>";
				echo "<tr><td>$beta1</td></tr>";
				echo "<tr><td>$beta2</td></tr>";
				echo "<tr><td>$hibeta</td></tr>";
				echo "<tr><td>$gamma</td></tr>";
			}		
			$result->free_result();
		}
		echo '</table>';
		
		$connection->close();
	}

?>