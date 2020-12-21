<?php
    session_start();

    function return_to_register_page($reason) {
        header('Location: ../rejestracja.php');
		$_SESSION['error'] = 'onload="loadToast(\'2\',\''.$reason.'\',\'\')"';
        exit(0);
    }

	$imie = htmlentities($_POST['imie']);
    $nazwisko = htmlentities($_POST['nazwisko']);
    $mail = htmlentities($_POST['mail']);
    $haslo1 = $_POST['haslo1'];
    $haslo2 = $_POST['haslo2'];
	$plec = htmlentities($_POST['plec']);
	$data = htmlentities($_POST['data']);
	//bot or not?
	//$sekret = "6Lc9AgQaAAAAANEBN_3yAfuMdVN8t54FzWyfG5PS";
	//$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
	//$odpowiedz = json_decode($sprawdz);
	
	//if(!($odpowiedz->success)) {
        //return_to_register_page('Potwierdź, że nie jesteś robotem');
    //}
	
    if ($haslo1 != $haslo2) {
        return_to_register_page('Hasła się nie zgadzają!');
    }

	require_once 'connect.php';

	$connection = @new mysqli($host, $db_user, $db_password, $db_name);

	if ($connection->connect_errno == 0) {
		$sql = "SELECT COUNT(id_klienta) as ile FROM klient where mail = '$mail'";
		$result = @$connection->query($sql);
		if($result) {
			$row = $result->fetch_assoc();
			if($row['ile'] > 0)
				return_to_register_page('Konto o podanym mailu już istnieje');
			else {
				$pw_hash = password_hash($haslo1, PASSWORD_BCRYPT);

				$sql = sprintf("INSERT INTO klient (imie, nazwisko, mail, haslo, plec, data_urodzenia) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')",
					mysqli_real_escape_string($connection, $imie),
					mysqli_real_escape_string($connection, $nazwisko),
					mysqli_real_escape_string($connection, $mail),
					$pw_hash,
					mysqli_real_escape_string($connection, $plec),
					mysqli_real_escape_string($connection, $data)
				);
				echo $sql;
				//$result->free_result();
				$result = @$connection->query($sql);

				if ($result) {
					header('Location: ../panel.php');
				} else {
					//header('Location: ../rejestracja.php');
					$_SESSION['error'] = 'onload="loadToast(\'3\',\'Błąd bazy danych\',\'Error '.$connection->connect_errno.'\')"';
				}
			}
		}
		//$result->free_result();
		$connection->close();
	} else {
		//header('Location: ../rejestracja.php');
		$_SESSION['error'] = 'onload="loadToast(\'3\',\'Błąd bazy danych\',\'Error '.$connection->connect_errno.'\')"';
	}
?>