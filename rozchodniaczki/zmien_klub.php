<?php
	/*SECURED*/
	if (session_status() == PHP_SESSION_NONE) {
		header('Location: ../../logowanie.php');
	}
	else{
		if(!isset($_SESSION['id_admina'])){
			header('Location: ../../logowanie.php');
		}
	}
	
	if(isset($_GET['id_klubu']) && isset($_GET['id_klienta']))
	{
		require_once 'connect.php';
		$connection = @new mysqli($host, $db_user, $db_password, $db_name);

		if ($connection->connect_errno == 0) 
		{
			$id_klubu = $_GET['id_klubu'];
			$id_klienta = $_GET['id_klienta'];
			$sql = "UPDATE klient SET id_klubu='$id_klubu' WHERE id_klienta='$id_klienta'";
			$result = @$connection->query($sql);
			$connection->close();
		}
		else
		{
			jump_to_page('3','Błąd bazy danych','Niepowodzenie w połączeniu z bazą');
		}	
	}
	else
	{
		//Brak parametrów GET
		jump_to_page('3','Błąd logiczny','Nie podano wszystkich parametrów wymaganych do przypisania klubu');
	}
?>