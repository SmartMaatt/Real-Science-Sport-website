<?php
	/*SECURED*/
	session_start();

	function jump_to_page($location,$mode,$top,$bottom)
	{
        header('Location: ../'.$location);
		$_SESSION['error'] = 'loadToast(\''.$mode.'\',\''.$top.'\',\''.$bottom.'\')';
    }
	
    $incorrect_data = 'Brak takiego konta!';
	$incorrect_conection = 'Nie udało się zresetować hasła spróbuj ponownie!';

	//Parametry wymagane do przeprowadzenia algorytmu
	if(isset($_POST['stare_haslo']) && isset($_POST['nowe_haslo1']) && isset($_POST['nowe_haslo2']))
	{	
		//Pobranie wartości z POST
		$stare_haslo = htmlentities($_POST['stare_haslo']);
		$nowe_haslo1 = htmlentities($_POST['nowe_haslo1']);
		$nowe_haslo2 = htmlentities($_POST['nowe_haslo2']);
		$id_klienta = $_SESSION['id_klienta'];
		
		//Hasła się nie zgadzają
		if ($nowe_haslo1 != $nowe_haslo2) {
			jump_to_page('panel.php','2','Hasła się nie zgadzają!','');
		}
		
		//Przynajmniej 6 znaków, jedna mała litera, jedna duża litera, jedna cyfra
		$uppercase = preg_match('@[A-Z]@', $nowe_haslo1);
		$lowercase = preg_match('@[a-z]@', $nowe_haslo1);
		$number    = preg_match('@[0-9]@', $nowe_haslo1);

		if(!$uppercase || !$lowercase || !$number || strlen($nowe_haslo1) < 6) {
			jump_to_page('panel.php','2','Hasło nie spełnia kryteriów!','');
		}
		
		//Stare hasło jest takie samo jako podane nowe
		if($nowe_haslo1 == $stare_haslo){
			jump_to_page('panel.php', '2', 'Nowe hasło nie różni się od starego!', '');
		}
		
		//Połączenie z bazą
		require_once 'connect.php';
		$connection = @new mysqli($host, $db_user, $db_password, $db_name);

		//Czy połącznie z bazą zostało nawiązane?
		if ($connection->connect_errno == 0) {
			
			$sql = "SELECT haslo FROM klient WHERE id_klienta = '$id_klienta'";
			$result = @$connection->query($sql);

			//Sprawdzenie wykonania powyższego zapytania sql
			if ($result && $result->num_rows > 0) 
			{
				$row = $result->fetch_assoc();
				$db_pass = $row['haslo'];
				$old_pw_hash = password_hash($stare_haslo, PASSWORD_BCRYPT);
				
				//Sprawdź czy podane stare hasło jest poprawne
				if(password_verify($stare_haslo, $db_pass))
				{
					$pw_hash = password_hash($nowe_haslo1, PASSWORD_BCRYPT);
					$sql2 = "UPDATE klient SET haslo = '$pw_hash' WHERE id_klienta = '$id_klienta'";
					$result2 = @$connection->query($sql2);
					
					//Sprawdź czy poprawnie zmieniono hasło
					if($result2)
					{
						//Pomyślnie wygenerowano hasło
						$to = $_SESSION['mail'];
						$subject = "Nowe hasło - Panel RSS";
						$message = "<p>Twoje nowe hasło ".$_SESSION['imie']." to:<br/><b>".$nowe_haslo1."</b></p>";

						// Always set content-type when sending HTML email
						$headers = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						$headers .= 'From: RSS Panel' . "\r\n";

						mail($to,$subject,$message,$headers);
						
						//Poprawna aktualizacja
						jump_to_page('panel.php','0','Hasło zostało zmienione poprawnie','');
						$connection->close();
					}
					else
					{
						//Niepowodzenie wykonania zapytania sql
						jump_to_page('panel.php','3','Błąd bazy danych!','Niepowodzenie wykonania zapytania sql!<br/>Command: UPDATE');
						$connection->close();
					}
				}
				else 
				{
					//Podane stare hasło jest niepoprawne
					jump_to_page('panel.php','2','Błąd logiczny!','Stare hasło jest niepoprawne!');
					$connection->close();
				}
			} 
			else 
			{
				//Niepowodzenie wykonania zapytania sql
				jump_to_page('panel.php','3','Błąd bazy danych!','Niepowodzenie wykonania zapytania sql!<br/>Command: SELECT');
				$connection->close();
			}
			$result->free_result();
		} 
		else 
		{
			//Nieudane połącznie z bazą danych
			jump_to_page('panel.php', '3', 'Błąd bazy danych', 'Nieudane połączenie z bazą danych!');
		}
	}
	else
	{
		//Brak parametrów POST
		jump_to_page('logowanie.php','3','Błąd logiczny','Nie podano wszystkich parametrów wymaganych do rejestracji');
	}
?>