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
	if(isset($_GET['imie']) && isset($_GET['nazwisko']) && isset($_GET['mail']) && isset($_GET['token'])){
		
		//Odczyt parametrów
		$imie = htmlentities($_GET['imie']);
		$nazwisko = htmlentities($_GET['nazwisko']);
		$mail = htmlentities($_GET['mail']);
		$token_recaptcha = $_GET['token'];

		
		//RECAPTCHA
		$url_recaptcha = "https://www.google.com/recaptcha/api/siteverify";
		$data_recaptcha = [
			'secret' => "6LePmDAaAAAAABS8AtvLqF7YMYVzUtD_dbArn8tN",
			'response' => $token_recaptcha,
			// 'remoteip' => $_SERVER['REMOTE_ADDR']
		];

		$options_recaptcha = array(
		    'http' => array(
		      'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		      'method'  => 'POST',
		      'content' => http_build_query($data_recaptcha)
		    )
		  );

		$context_recaptcha  = stream_context_create($options_recaptcha);
  		$response_recaptcha = file_get_contents($url_recaptcha, false, $context_recaptcha);

		$res_recaptcha = json_decode($response_recaptcha, true);
		
		if($res_recaptcha['success'] == false) {
			jump_to_page('2','Nie jesteś człowiekiem!', 'Zabezpieczenie reCaptcha');
		}
		////////////////////////
		
		
		//Połączenie z bazą danych
		require_once 'connect.php';
		$connection = @new mysqli($host, $db_user, $db_password, $db_name);

		//Sprawdzenie poprawnego połączenia z bazą
		if ($connection->connect_errno == 0) {
			
			//Wyszukanie odpowiedniego klienta
			$sql = sprintf("SELECT * FROM klient WHERE imie = '%s' AND nazwisko = '%s' AND mail = '%s'",
							mysqli_real_escape_string($connection, $imie),
							mysqli_real_escape_string($connection, $nazwisko),
							mysqli_real_escape_string($connection, $mail));
			$result = @$connection->query($sql);
			
			//Sprawdzenie wykonania zapytania SQL
			if ($result && $result->num_rows > 0) {
				
				if(isset($_GET['mailAccept']) && $_GET['mailAccept'] == 'yep'){
					
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
					if($result2){
						
						//Pomyślnie wygenerowano hasło
						$to = $mail;
						$subject = "Nowe hasło - Panel RSS";
						$message = "<b><h1>Nowe hasło</h1></b>
								<p>".$imie.", twoje nowe hasło w panelu RSS to: <b>".$haslo."</b></p></br>
								<a href='realsciencesport.com/logowanie.php' targer='_blank'>Przejdź do strony</a></br>
								<img src=\"realsciencesport.com/app-assets/images/logoBlack.png\" width=\"250\"  />";

						$headers[] = 'MIME-Version: 1.0';
						$headers[] = 'Content-type: text/html; charset=iso-8859-1';

						// Additional headers
						$headers[] = 'To: '.$to;
						$headers[] = 'From: Rss Panel <realsciencesport@gmail.com>';

						if(!mail($to, $subject, $message, implode("\r\n", $headers))){
							header('Location: ../rejestracja.php');
							$_SESSION['error'] = 'loadToast(\'3\',\'Błąd formularza wiadomości!\',\'Próba wysłania maila nie powiodła się. Skontaktuj się z działem technicznym!\')';
						}

						jump_to_page('0','Hasło zostało wygenerowane pomyślnie!','');
						$result2->free_result();
						$connection->close();
					}
					else{
						
						//Brak takiego konta
						jump_to_page('3','Błąd bazy danych!','Niepowodzenie podczas wykonania polecenia SQL<br/>Command: UPDATE');
						$result2->free_result();
						$connection->close();
					}
				}
				else{
					
					$to = $mail;
					$subject = "Reset hasła - Panel RSS";
					$message = "<b><h1>Reset hasła</h1></b>
								<p>Aby potwierdzić procedurę resetowania hasła, kliknij w link poniżej.</p></br>
								<a href='realsciencesport.com/rozchodniaczki/resetuj_haslo.php?imie=".$imie."&nazwisko=".$nazwisko."&mail=".$mail."&mailAccept=yep'>Kliknij tutaj!</a>
								</br><p>Jeżeli nie inicjowałeś resetu, zignoruj tę wiadomość.</p>
								<img src=\"realsciencesport.com/app-assets/images/logoBlack.png\" width=\"250\"  />";

					$headers[] = 'MIME-Version: 1.0';
					$headers[] = 'Content-type: text/html; charset=iso-8859-1';

					// Additional headers
					$headers[] = 'To: '.$to;
					$headers[] = 'From: Rss Panel <realsciencesport@gmail.com>';

					if(!mail($to, $subject, $message, implode("\r\n", $headers))){
						header('Location: ../rejestracja.php');
						$_SESSION['error'] = 'loadToast(\'3\',\'Błąd formularza wiadomości!\',\'Próba wysłania maila nie powiodła się. Skontaktuj się z działem technicznym!\')';
					}
					jump_to_page('0','Wiadomość dotycząca zmiany hasła została wysłana!','Mail: '.$mail);
					$connection->close();
				}
			} 
			else {
				
				//Brak takiego konta
				jump_to_page('2','Brak konta o podanych parametrach!','');
				$connection->close();
			}
		} 
		else {
			
			//Niepowodzenie połącznie z bazą danych
			jump_to_page('3','Błąd bazy danych!','Nieudane połącznie z bazą danych!');
		}
	}
	else{
		
		//Brak parametrów POST
		jump_to_page('3','Błąd logiczny','Nie podano wszystkich parametrów wymaganych do rejestracji');
	}
?>