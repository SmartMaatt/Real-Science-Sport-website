<?php

	if (session_status() == PHP_SESSION_NONE) {
			header('Location: ../../logowanie.php');
		}

?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<title>Logowanie</title>
</head>

<body>
	<h1>Szczegóły Badania</h1>
	<?php
		session_start();
		if (!isset($_SESSION['id_klienta'])) {
			//header('Location: logowanie.php');
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
			echo '<td>x</td>';
			echo '<td>y</td>';
			echo '</tr>';
			
			foreach($_POST as $key => $name)
			{
				$id_badania = $key;
			}
			$sql = "SELECT * FROM badanie WHERE id_badania = '$id_badania'";
			if($result = @$connection->query($sql))
			{
				for($i=0; $i < $result->num_rows; $i++)
				{
					$row = $result->fetch_assoc();
					$x1 = $row['pomiar1x'];
					$y1 = $row['pomiar1y'];
					$x2 = $row['pomiar2x'];
					$y2 = $row['pomiar2y'];
					$x3 = $row['pomiar3x'];
					$y3 = $row['pomiar3y'];
					$x4 = $row['pomiar4x'];
					$y4 = $row['pomiar4y'];
					$x5 = $row['pomiar5x'];
					$y5 = $row['pomiar5y'];
					echo "<tr><td>$x1</td><td>$y1</td></tr>";
					echo "<tr><td>$x2</td><td>$y2</td></tr>";
					echo "<tr><td>$x3</td><td>$y3</td></tr>";
					echo "<tr><td>$x4</td><td>$y4</td></tr>";
					echo "<tr><td>$x5</td><td>$y5</td></tr>";
				}		
				$result->free_result();
			}
			echo '</table>';
			
			$connection->close();
		}

	?>
</body>
</html>