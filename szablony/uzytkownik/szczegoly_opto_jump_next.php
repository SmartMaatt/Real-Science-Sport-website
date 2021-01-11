<?php
	/*SECURED*/
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
	
		require_once "rozchodniaczki/connect.php";
	
		$connection = @new mysqli($host, $db_user, $db_password, $db_name);
		
		if($connection->connect_errno!=0)
		{
			echo "Error: ".$connection->connect_errno;
		}
		else
		{	
			//Pobierz potrzebne badanie
			$sql = "SELECT * FROM opto_jump_next WHERE id_badania = '$id_badania'";
			if($result = @$connection->query($sql))
			{
				//Odczytaj wartości z wiersza bazy
				$row = $result->fetch_assoc();
				$data = $row['data'];
				$sciezka = $row['sciezka'];
				echo 'Badanie z dnia '.$data.'</br>';
				echo '<img src="app-assets/badania/opto_jump_next/'.$sciezka.'.jpg" />';
				$result->free_result();
			}
		}

	?>
</body>
</html>