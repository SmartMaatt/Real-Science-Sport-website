<?php
	/*SECURED*/
    session_start();

    function return_to_login_page($reason) {
        header('Location: ../logowanie.php');
		$_SESSION['error'] = 'loadToast(\'2\',\''.$reason.'\',\'\')';
		exit(0);
    }
	
	if(isset($_POST['mail']) && isset($_POST['haslo']) && isset($_POST['token'])){	
	
		$mail = $_POST['mail'];
		$pass  = $_POST['haslo'];
		$token_recaptcha = $_POST['token'];
		$incorrect_login_or_password = 'Nieprawidłowy mail lub hasło!';
		
		
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
			return_to_login_page('Nie jesteś człowiekiem! </br>Zabezpieczenie reCaptcha');
		}
		////////////////////////
		
		
		require_once 'connect.php';
		
		$connection = @new mysqli($host, $db_user, $db_password, $db_name);

		if ($connection->connect_errno == 0) {
			
			$sql = sprintf("SELECT * FROM klient WHERE mail = '%s'", mysqli_real_escape_string($connection, $mail));
			$result = @$connection->query($sql);
			
			//Logowanie dla klienta
			if ($result && $result->num_rows > 0) {
				
				$row = $result->fetch_assoc();
				if($row['potwierdzone']){
					
					$db_pass = $row['haslo'];
					if (password_verify($pass, $db_pass)) {
						
						$_SESSION['id_klienta'] = $row['id_klienta'];
						$_SESSION['imie'] 		= $row['imie'];
						$_SESSION['nazwisko'] 	= $row['nazwisko'];
						$_SESSION['mail']       = $row['mail'];
						$_SESSION['plec']       = $row['plec'];
						$_SESSION['data_urodzenia']       = $row['data_urodzenia'];
						$_SESSION['data'] 		= date("Y-m-d");
						$_SESSION['id_opcji'] 	= 1;
						$_SESSION['id_podopcji'] = 0;
						$_SESSION['id_badania'] = -1;
						unset($_SESSION['error']);
						header('Location: ../panel.php');
					} 
					else {
						return_to_login_page($incorrect_login_or_password);
					}
				} 
				else
				{
					$vkey = $row['vkey'];
					$to = $mail;
					$subject = "Weryfikacja - Panel RSS";
					$message = "<b><h1>Dziękujemy za rejestrację!</h1></b>
									<p>Aby potwierdzić swoje konto, kliknij w link poniżej.</p></br>
									<a href='realsciencesport.com/rozchodniaczki/weryfikuj.php?vkey=".$vkey."'>Kliknij tutaj!</a>
									</br><p>Jeżeli nie rejestrowałeś się na naszej stronie, zignoruj tę wiadomość.</p>
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
					
					return_to_login_page("Proszę potwierdzić konto na mailu");
				}
			} 
			//Logowanie dla admina
			else {
				
				$sql = sprintf("SELECT * FROM admin WHERE mail = '%s'", mysqli_real_escape_string($connection, $mail));
				$result = @$connection->query($sql);
				
				if ($result && $result->num_rows > 0){
					
					$row = $result->fetch_assoc();
					if($row['potwierdzone']){
						
						$db_pass = $row['haslo'];
						if (password_verify($pass, $db_pass)) {
							
							$_SESSION['id_admina'] = $row['id_admina'];
							$_SESSION['imie'] 		= $row['imie'];
							$_SESSION['nazwisko'] 	= $row['nazwisko'];
							$_SESSION['mail']       = $row['mail'];
							$_SESSION['plec']       = $row['plec'];
							$_SESSION['data_urodzenia']       = $row['data_urodzenia'];
							$_SESSION['data'] 		= date("Y-m-d");
							$_SESSION['id_klienta'] = -1;
							$_SESSION['id_opcji'] 	= 1;
							$_SESSION['id_podopcji'] = 0;
							$_SESSION['id_badania'] = -1;
							unset($_SESSION['error']);
							header('Location: ../panel_admina.php');
						} 
						else {
							return_to_login_page($incorrect_login_or_password);
						}
					} 
					else {
						return_to_login_page("Proszę potwierdzić konto na mailu");
					}
				} 
				else {
					return_to_login_page($incorrect_login_or_password);
				}
				$result->free_result();
				$connection->close();
			} 
		}
		else {
			//Nieudane połączenie z bazą danych
			header('Location: ../logowanie.php');
			$_SESSION['error'] = 'loadToast(\'3\',\'Błąd bazy danych\',\'Error '.$connection->connect_errno.'\')';
		}
	}
	else {
		//Brak parametrów POST
		jump_to_page('3','Błąd logiczny','Nie podano wszystkich parametrów wymaganych do logowania');
	}
?>