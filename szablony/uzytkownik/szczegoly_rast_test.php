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

		echo '<table>
			<tr>
			<td>Pomiar 1</td>
			<td>Pomiar 2</td>
			<td>Pomiar 3</td>
			<td>Pomiar 4</td>
			<td>Pomiar 5</td>
			<td>Pomiar 6</td>
			<td>Pomiar 7</td>
			<td>Średnia</td>
			</tr>';
		
		foreach($_POST as $key => $name)
		{
			$id_badania = $key;
		}
		$sql = "SELECT * FROM rast_test WHERE id_badania = '$id_badania'";
		if($result = @$connection->query($sql))
		{
			for($i=0; $i < $result->num_rows; $i++)
			{
				$row = $result->fetch_assoc();
				$pomiar1 = $row['pomiar1'];
				$pomiar2 = $row['pomiar2'];
				$pomiar3 = $row['pomiar3'];
				$pomiar4 = $row['pomiar4'];
				$pomiar5 = $row['pomiar5'];
				$pomiar6 = $row['pomiar6'];
				$pomiar7 = $row['pomiar7'];
				$srednia = ($pomiar1 + $pomiar2 + $pomiar3 + $pomiar4 + $pomiar5 + $pomiar6 + $pomiar7)/7
				echo "<tr><td>$pomiar1</td>
					<td>$pomiar2</td>
					<td>$pomiar3</td>
					<td>$pomiar4</td>
					<td>$pomiar5</td>
					<td>$pomiar6</td>
					<td>$pomiar7</td>
					<td>$srednia</td></tr>";
			}		
			$result->free_result();
		}
		echo '</table>';
		
		$connection->close();
	}

?>