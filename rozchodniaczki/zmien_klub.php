<?php
	/*SECURED*/
	
	session_start();
	
	if(!isset($_SESSION['id_admina'])){
		header('Location: ../logowanie.php');
	}
	
	
    function jump_to_page($mode,$top,$bottom) {
        header('Location: ../panel_admina.php');
		$_SESSION['error'] = 'loadToast(\''.$mode.'\',\''.$top.'\',\''.$bottom.'\')';
    }
	
	if(isset($_POST['id_klubu']) && isset($_POST['id_klienta']))
	{
		require_once 'connect.php';
		$connection = @new mysqli($host, $db_user, $db_password, $db_name);

		if ($connection->connect_errno == 0) 
		{
			$id_klubu = $_POST['id_klubu'];
			$id_klienta = $_POST['id_klienta'];
			$sql = "UPDATE klient SET id_klubu='$id_klubu' WHERE id_klienta='$id_klienta'";
			$result = @$connection->query($sql);
			$connection->close();
			jump_to_page('0','Poprawnie zmieniono klub!','');
		}
		else
		{
			jump_to_page('3','Błąd bazy danych','Niepowodzenie w połączeniu z bazą');
		}	
	}
	else
	{
		//Brak parametrów POST
		jump_to_page('3','Błąd logiczny','Nie podano wszystkich parametrów wymaganych do przypisania klubu');
	}
?>