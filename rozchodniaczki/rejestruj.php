<?php
    session_start();

    function return_to_register_page($reason) {
        header('Location: ../rejestracja.php');
		$_SESSION['error'] = 'loadToast(\'2\',\''.$reason.'\',\'\')';
        exit(0);
    }

	$imie = htmlentities($_POST['imie']);
    $nazwisko = htmlentities($_POST['nazwisko']);
    $mail = htmlentities($_POST['mail']);
    $haslo1 = $_POST['haslo1'];
    $haslo2 = $_POST['haslo2'];
	$plec = htmlentities($_POST['plec']);
	$data = htmlentities($_POST['data']);
	
	/*PRAWDOPODOBNIE CAPTCHA*/
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

	if ($connection->connect_errno == 0) 
	{
		$sql = "SELECT COUNT(id_klienta) as ile FROM klient where mail = '$mail'";
		$result = @$connection->query($sql);
		if($result) 
		{
			$row = $result->fetch_assoc();
			if($row['ile'] > 0)
			{
				return_to_register_page('Konto o podanym mailu już istnieje');
			}
			else 
			{
				//Inkrementacja klucza głównego
				$sql2 = "SELECT COUNT(id_klienta) as ile FROM klient";
				$result2 = @$connection->query($sql2);
				$liczba_klientow = $result2->fetch_assoc();
				$result2->free_result();
				
				$sql2 = "SELECT id_klienta FROM klient";
				$result2 = @$connection->query($sql2);
				
				if(result2)
				{
					$row2 = $result2->fetch_assoc();
					
					$new_index = '0';
					for($x = 0; $x < $liczba_klientow['ile']; $x++){
						$new_index = $x + 1;
						if($x != row2['id_klienta']){
							$new_index = $x;
							break;
						}
					}
					$result2->free_result();
					
					$vkey = md5(time().$mail);
					$pw_hash = password_hash($haslo1, PASSWORD_BCRYPT);

					$sql3 = sprintf("INSERT INTO klient (id_klienta, imie, nazwisko, mail, haslo, plec, data_urodzenia, vkey) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
						$new_index,
						mysqli_real_escape_string($connection, $imie),
						mysqli_real_escape_string($connection, $nazwisko),
						mysqli_real_escape_string($connection, $mail),
						$pw_hash,
						mysqli_real_escape_string($connection, $plec),
						mysqli_real_escape_string($connection, $data),
						$vkey
					);
					//echo $sql;
					
					$result3 = @$connection->query($sql3);

					if ($result3) 
					{
						$to = $mail;
						$subject = "Weryfikacja - Panel RSS";

						$message = "<a href='localhost/RSS/rozchodniaczki/weryfikuj.php?vkey=".$vkey."'>Click here!</a>";

						// Always set content-type when sending HTML email
						$headers = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

						// More headers
						$headers .= 'From: <lorem ipsum>' . "\r\n";

						mail($to,$subject,$message,$headers);
						
						//Pomyślna rejestracja!
						header('Location: ../rejestracja.php');
						$_SESSION['error'] = 'loadToast(\'0\',\'Rejestracja przebiegła pomyślnie\',\'Uwierzytelnij swoje konto mailem aktywacyjnym<br/>'.$mail.'\')';
					} 
					else 
					{
						header('Location: ../rejestracja.php');
						$_SESSION['error'] = 'loadToast(\'3\',\'Błąd bazy danych\',\'Error '.$new_index.'\')';
					}
					$result3->free_result();
				}
				else
				{
					header('Location: ../rejestracja.php');
					$_SESSION['error'] = 'loadToast(\'3\',\'Błąd bazy danych\',\'Error '.$connection->connect_errno.'\')';
				}
			}
		}
		$result->free_result();
		$connection->close();
	} 
	else 
	{
		header('Location: ../rejestracja.php');
		$_SESSION['error'] = 'loadToast(\'3\',\'Błąd bazy danych\',\'Error '.$connection->connect_errno.'\')';
	}
?>