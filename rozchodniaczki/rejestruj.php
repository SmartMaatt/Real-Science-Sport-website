<?php
	/*SECURED*/
    session_start();

    function jump_to_page($mode,$top,$bottom) {
        header('Location: ../rejestracja.php');
		$_SESSION['error'] = 'loadToast(\''.$mode.'\',\''.$top.'\',\''.$bottom.'\')';
		exit(0);
    }

	//Wymagane jest istnienie wszystkich zmiennych w POST
	if(isset($_POST['imie']) && isset($_POST['nazwisko']) && isset($_POST['mail']) && isset($_POST['haslo1']) && isset($_POST['haslo2']) && isset($_POST['plec']) && isset($_POST['data'])){
		
		//Odczyt danych z formularza
		$imie = htmlentities($_POST['imie']);
		$nazwisko = htmlentities($_POST['nazwisko']);
		$mail = htmlentities($_POST['mail']);
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		$plec = htmlentities($_POST['plec']);
		$data = htmlentities($_POST['data']);
		$id_klubu = htmlentities($_POST['id_klubu']);
		
		/*PRAWDOPODOBNIE CAPTCHA*/
		//bot or not?
		//$sekret = "6Lc9AgQaAAAAANEBN_3yAfuMdVN8t54FzWyfG5PS";
		//$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		//$odpowiedz = json_decode($sprawdz);
		
		//if(!($odpowiedz->success)) {
			jump_to_page('2','Potwierdź, że nie jesteś robotem', '');
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

		if ($connection->connect_errno == 0) {
			
			//Zapytanie sql o ilość klientów o podanym adresie e-mail
			$sql = "SELECT COUNT(id_klienta) as ile FROM klient where mail = '$mail'";
			$result = @$connection->query($sql);
			if($result) {
				
				$row = $result->fetch_assoc();
				if($row['ile'] > 0){
					
					//Użytkownik o podanym mailu już istnieje
					jump_to_page('2','Konto o podanym mailu już istnieje','');
					$connection->close();
				}
				else {
					//Pobranie listy id
					$sql2 = "SELECT id_klienta FROM klient ORDER BY id_klienta";
					$result2 = @$connection->query($sql2);
					
					if($result2){	
					
						//Pseudolosowanie klucza weryfikacyjnego
						$vkey = md5(time().$mail);
						$pw_hash = password_hash($haslo1, PASSWORD_BCRYPT);

						//Zapytanie sql złożone ze wszystkich odczytanych wartości
						if($id_klubu == "-1"){
							
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
						}
						else{

							$sql3 = sprintf("INSERT INTO klient (id_klienta, imie, nazwisko, mail, haslo, plec, data_urodzenia, id_klubu, vkey) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
								$new_index,
								mysqli_real_escape_string($connection, $imie),
								mysqli_real_escape_string($connection, $nazwisko),
								mysqli_real_escape_string($connection, $mail),
								$pw_hash,
								mysqli_real_escape_string($connection, $plec),
								mysqli_real_escape_string($connection, $data),
								mysqli_real_escape_string($connection, $id_klubu),
								$vkey
							);
						}
						$result3 = @$connection->query($sql3);

						//Wysyłanie maila weryfikacyjnego na podany adres e-mail
						if ($result3){
							
							$to = $mail;
							$subject = "Weryfikacja - Panel RSS";
							$message = "<a href='realsciencesport.com/rozchodniaczki/weryfikuj.php?vkey=".$vkey."'>Click here!</a>";

							$headers[] = 'MIME-Version: 1.0';
							$headers[] = 'Content-type: text/html; charset=iso-8859-1';

							// Additional headers
							$headers[] = 'To: '.$to;
							$headers[] = 'From: Rss Panel <realsciencesport@gmail.com>';

							if(!mail($to, $subject, $message, implode("\r\n", $headers))){
								header('Location: ../rejestracja.php');
								$_SESSION['error'] = 'loadToast(\'3\',\'Błąd formularza wiadomości!\',\'Próba wysłania maila nie powiodła się. Skontaktuj się z działem technicznym!\')';
							}
							
							$sql4 = "SELECT id_klienta AS nowy_index FROM klient ORDER BY id_klienta DESC LIMIT 1";
							$result4 = @$connection->query($sql4);
							if($result4)
							{
								$row4 = $result4->fetch_assoc();
								$index = $row4['nowy_index'];
								$sql5 = "INSERT INTO wszystkie_badania (id_klienta) VALUES ('$index')";
								$result5 = @$connection->query($sql5);
							}								

							//Pomyślna rejestracja!
							jump_to_page('0','Rejestracja przebiegła pomyślnie','Uwierzytelnij swoje konto mailem aktywacyjnym<br/>'.$mail);
							$connection->close();
							
						} 
						else {
							jump_to_page('3','Błąd bazy danych', 'Niepowodzenie w wykonaniu zapytania sql<br/>Command: INSERT klient<br/>'.$new_index);
							$connection->close();
						}
					}
					else {
						//Błąd wykonania zapytania SQL
						jump_to_page('3','Błąd bazy danych', 'Niepowodzenie w wykonaniu zapytania sql<br/>Command: SELECT COUNT');
						$connection->close();
					}
				}
			}
		} 
		else {
			//Nie udało się połączyć z bazą
			jump_to_page('3','Błąd bazy danych','Niepowodzenie w połączeniu z bazą');
		}
	}
	else {
		//Brak parametrów POST
		jump_to_page('3','Błąd logiczny','Nie podano wszystkich parametrów wymaganych do rejestracji');
	}
?>