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
		echo '<td>Wzrost</td>';
		echo '<td>Wzrost tułowia</td>';
		echo '</tr>';
		
		foreach($_POST as $key => $name)
		{
			$id_badania = $key;
		}
		$sql = "SELECT * FROM wzrostomierz WHERE id_badania = '$id_badania'";
		if($result = @$connection->query($sql))
		{
			$row = $result->fetch_assoc();
			$data = $row['data'];
			$wzrost_tulowia = $row['wzrost_tulowia'];	
			$result->free_result();
		}
		$id_klienta = $_SESSION['id_klienta'];
		$sql = "SELECT wartosc FROM wzrost WHERE id_klienta = '$id_klienta AND data = '$data'";
		if($result = @$connection->query($sql))
		{
			$row = $result->fetch_assoc();
			$wzrost= $row['wartosc'];	
			$result->free_result();
		}
		echo '<tr><td>$wzrost</td><td>$wzrost_tulowia</td></tr></table>';
		
		$connection->close();
	}

?>