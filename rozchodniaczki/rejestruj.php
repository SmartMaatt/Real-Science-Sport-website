<?php
    session_start();

    function jump_to_page($mode,$top,$bottom) {
        header('Location: ../rejestracja.php');
		$_SESSION['error'] = 'loadToast(\''.$mode.'\',\''.$top.'\',\''.$bottom.'\')';
        exit(0);
    }

	//Wymagane jest istnienie wszystkich zmiennych w POST
	if(isset($_POST['imie']) && isset($_POST['nazwisko']) && isset($_POST['mail']) && isset($_POST['haslo1']) && isset($_POST['haslo2']) && isset($_POST['plec']) && isset($_POST['data']))
	{
		//Odczyt danych z formularza
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
			//jump_to_page('2','Potwierdź, że nie jesteś robotem', '');
		//}
		
		//Czy dwa podane hasła są takie same?
		if ($haslo1 != $haslo2) {
			jump_to_page('2','Hasła się nie zgadzają!','');
		}
		
		//Przynajmniej 6 znaków, jedna mała litera, jedna duża litera, jedna cyfra
		$uppercase = preg_match('@[A-Z]@', $haslo1);
		$lowercase = preg_match('@[a-z]@', $haslo1);
		$number    = preg_match('@[0-9]@', $haslo1);

		if(!$uppercase || !$lowercase || !$number || strlen($haslo1) < 6) {
			jump_to_page('2','Hasło nie spełnia kryteriów!','');
		}

		//Otwarcie połączenia z bazą danych
		require_once 'connect.php';
		$connection = @new mysqli($host, $db_user, $db_password, $db_name);

		if ($connection->connect_errno == 0) 
		{
			//Zapytanie sql o ilość klientów o podanym adresie e-mail
			$sql = "SELECT COUNT(id_klienta) as ile FROM klient where mail = '$mail'";
			$result = @$connection->query($sql);
			if($result) 
			{
				$row = $result->fetch_assoc();
				if($row['ile'] > 0)
				{
					//Użytkownik o podanym mailu już istnieje
					jump_to_page('2','Konto o podanym mailu już istnieje','');
					$connection->close();
				}
				else 
				{
					//Odczyt ilości klientów w bazie
					$sql2 = "SELECT COUNT(id_klienta) as ile FROM klient";
					$result2 = @$connection->query($sql2);
					$liczba_klientow = $result2->fetch_assoc();
					$result2->free_result();
					
					//Pobranie listy id
					$sql2 = "SELECT id_klienta as id_klienta FROM klient";
					$result2 = @$connection->query($sql2);
					
					if($result2)
					{	
						//Znalezienie najbliższego wolnego indeksu
						$new_index = '0';
						while($row2 = $result2->fetch_row()){
							if($new_index != $row2[0]){
								echo "dupa ".$new_index;
								break;
							}
							$new_index++;
						}
						$result2->free_result();
						
						//Pseudolosowanie klucza weryfikacyjnego
						$vkey = md5(time().$mail);
						$pw_hash = password_hash($haslo1, PASSWORD_BCRYPT);


						//Zapytanie sql złożone ze wszystkich odczytanych wartości
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


						//Wysyłanie maila weryfikacyjnego na podany adres e-mail
						if ($result3) 
						{
							$to = $mail;
							$subject = "Weryfikacja - Panel RSS";

							$message = "<a href='localhost/RSS/rozchodniaczki/weryfikuj.php?vkey=".$vkey."'>Click here!</a>";

							// Always set content-type when sending HTML email
							$headers = "MIME-Version: 1.0" . "\r\n";
							$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

							// More headers
							$headers .= 'From: RSS Panel' . "\r\n";

							mail($to,$subject,$message,$headers);
							
							//Pomyślna rejestracja!
							jump_to_page('0','Rejestracja przebiegła pomyślnie','Uwierzytelnij swoje konto mailem aktywacyjnym<br/>'.$mail);
							$connection->close();
						} 
						else 
						{
							jump_to_page('3','Błąd bazy danych', 'Niepowodzenie w wykonaniu zapytania sql<br/>Command: INSERT<br/>'.$new_index);
							$connection->close();
						}
						$result3->free_result();
					}
					else
					{
						jump_to_page('3','Błąd bazy danych', 'Niepowodzenie w wykonaniu zapytania sql<br/>Command: SELECT COUNT');
						$connection->close();
					}
				}
			}
			$result->free_result();
		} 
		else 
		{
			//Nie udało się połączyć z bazą
			jump_to_page('3','Błąd bazy danych','Niepowodzenie w połączeniu z bazą');
		}
	}
	else
	{
		//Brak parametrów POST
		jump_to_page('3','Błąd logiczny','Nie podano wszystkich parametrów wymaganych do rejestracji');
	}
?>