<?php

	/*SECURED*/
	
    session_start();

     function jump_to_page($mode,$top,$bottom) {
        header('Location: ../reset_hasla.php');
		$_SESSION['error'] = 'loadToast(\''.$mode.'\',\''.$top.'\',\''.$bottom.'\')';
        exit(0);
    }
	
	//Losowanie hasła zgodnie z kryteriami występowania znaków
	function randomPassword() {
		$alphabet1 = 'abcdefghijklmnopqrstuvwxyz';
		$alphabet2 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$alphabet3 = '1234567890';
		
		$alpha1Length = strlen($alphabet1) - 1;
		$alpha2Length = strlen($alphabet2) - 1;
		$alpha3Length = strlen($alphabet3) - 1;
		
		$pass = array(); //remember to declare $pass as an array
		
		//3 = 9, 4 = 12, 5 = 15
		$passLenght = array(0 => 3,1 => 4,2 => 5);
		$selectedLenght = $passLenght[rand(0,2)];
		
		for ($i = 0; $i < $selectedLenght; $i++) {
			
			$n = rand(0, $alpha1Length);
			$pass[] = $alphabet1[$n];
			
			$n = rand(0, $alpha2Length);
			$pass[] = $alphabet2[$n];
			
			$n = rand(0, $alpha3Length);
			$pass[] = $alphabet3[$n];
			
		}
		return implode($pass); //turn the array into a string
	}
	
	//Czy zostały podane parametry GET
	if(isset($_GET['imie']) && isset($_GET['nazwisko']) && isset($_GET['mail']))
	{
		//Odczyt parametrów
		$imie = htmlentities($_GET['imie']);
		$nazwisko = htmlentities($_GET['nazwisko']);
		$mail = htmlentities($_GET['mail']);

		//Połączenie z bazą danych
		require_once 'connect.php';
		$connection = @new mysqli($host, $db_user, $db_password, $db_name);

		//Sprawdzenie poprawnego połączenia z bazą
		if ($connection->connect_errno == 0) 
		{
			//Wyszukanie odpowiedniego klienta
			$sql = sprintf("SELECT * FROM klient WHERE imie = '%s' AND nazwisko = '%s' AND mail = '%s'",
							mysqli_real_escape_string($connection, $imie),
							mysqli_real_escape_string($connection, $nazwisko),
							mysqli_real_escape_string($connection, $mail));
			$result = @$connection->query($sql);
			
			//Sprawdzenie wykonania zapytania SQL
			if ($result && $result->num_rows > 0) 
			{
				
				if(isset($_GET['mailAccept']) && $_GET['mailAccept'] == 'yep')
				{
					//Pobieranie klienta
					$row = $result->fetch_assoc();
					$result->free_result();
					//Losowanie nowego hasła
					$haslo = randomPassword();
					//Szyfrowanie hasła
					$pw_hash = password_hash($haslo, PASSWORD_BCRYPT);
					//Wykonanie zapytania sql
					$sql2 = "UPDATE klient SET haslo = '$pw_hash' WHERE mail = '$mail'";
					$result2 = @$connection->query($sql2);
					
					//Sprawdzenie czy zapytanie sql zostało wykonane poprawnie
					if($result2)
					{
						//Pomyślnie wygenerowano hasło
						$to = $mail;
						$subject = "Nowe hasło - Panel RSS";
						$message = "<p>Twoje nowe hasło ".$imie." to:<br/><b>".$haslo."</b></p>";

						// Always set content-type when sending HTML email
						$headers = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						$headers .= 'From: RSS Panel' . "\r\n";

						mail($to,$subject,$message,$headers);
						
						jump_to_page('0','Hasło zostało wygenerowane pomyślnie!','');
						$result2->free_result();
						$connection->close();
					}
					else
					{
						//Brak takiego konta
						jump_to_page('3','Błąd bazy danych!','Niepowodzenie podczas wykonania polecenia SQL<br/>Command: UPDATE');
						$result2->free_result();
						$connection->close();
					}
				}
				else
				{
					$to = $mail;
					$subject = "Reset hasła - Panel RSS";
					$message = "<p>Kliknij jeśli chcesz zmienić hasło.</p><a href='localhost/RSS/rozchodniaczki/resetuj_haslo.php?imie=".$imie."&nazwisko=".$nazwisko."&mail=".$mail."&mailAccept=yep'>Click me ^^</a>";

					// Always set content-type when sending HTML email
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					$headers .= 'From: RSS Panel' . "\r\n";

					mail($to,$subject,$message,$headers);
					jump_to_page('0','Wiadomość dotycząca zmiany hasła została wysłana!','Mail: '.$mail);
					$connection->close();
				}
			} 
			else 
			{	
				//Brak takiego konta
				jump_to_page('2','Brak konta o podanych parametrach!','');
				$connection->close();
			}
		} 
		else 
		{
			//Niepowodzenie połącznie z bazą danych
			jump_to_page('3','Błąd bazy danych!','Nieudane połącznie z bazą danych!');
		}
	}
	else
	{
		//Brak parametrów POST
		jump_to_page('3','Błąd logiczny','Nie podano wszystkich parametrów wymaganych do rejestracji');
	}
?>