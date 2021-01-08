<?php
    session_start();

    function jump_to_page($mode,$top,$bottom) {
        header('Location: ../rejestracja.php');
		$_SESSION['error'] = 'loadToast(\''.$mode.'\',\''.$top.'\',\''.$bottom.'\')';
        exit(0);
    }
	
	if(isset($_POST['nazwa_klubu']))
	{
		require_once 'connect.php';
		$connection = @new mysqli($host, $db_user, $db_password, $db_name);

		if ($connection->connect_errno == 0) 
		{
			//Zapytanie sql dodające klub o zadanej nazwie do bazy danych
			$nazwa_klubu = $_POST['nazwa_klubu'];
			$sql = "INSERT INTO `klub`(`nazwa`) VALUES ('$nazwa_klubu')";
			$result = @$connection->query($sql);
			if($result) 
			{
				jump_to_page('0','Pomyślnie dodano klub do bazy danych','');
			}
			else
			{
				jump_to_page('3','Błąd bazy danych', 'Niepowodzenie w wykonaniu zapytania sql<br/>Command: INSERT klub<br/>'.$new_index);
			}
		}
		else
		{
			jump_to_page('3','Błąd bazy danych','Niepowodzenie w połączeniu z bazą');
		}	
	}
	else
	{
		//Brak parametrów POST
		jump_to_page('3','Błąd logiczny','Nie podano wszystkich parametrów wymaganych do rejestracji');
	}
?>