<?php
	/*SECURED*/
	session_start();

	//Sesja istnieje	
	if (isset($_SESSION['id_klienta'])){
		 
		//Wszystkie dane są podane
		if(isset($_POST['tematyka_maila']) && isset($_POST['tytul_maila']) && isset($_POST['tresc_maila'])){
			
			$tematyka = $_POST['tematyka_maila'];
			$tytul = $_POST['tytul_maila'];
			$tresc = $_POST['tresc_maila'];
			
			//Dane do wysładania
			$to = "";
			if($tematyka == "Pytanie do działu technicznego"){
				$to = 'mateuszplonka.tg@gmail.com';
			}
			else{
				$to = 'realsciencesport@gmail.com';
			}
			$subject = $_SESSION['imie'].' '.$_SESSION['nazwisko'].' - zapytanie';
			$message = "Adresat: " . $_SESSION['imie'] . " " . $_SESSION['nazwisko'] . "<br/>E-mail: " . $_SESSION['mail'] . "<br/>Zagadnienie: <b>". $tematyka ."</b><br/><br/>" . $tresc;

			$headers[] = 'MIME-Version: 1.0';
			$headers[] = 'Content-type: text/html; charset=iso-8859-1';

			// Additional headers
			$headers[] = 'To: '.$to;
			$headers[] = 'From: Rss Panel <'.$_SESSION['mail'].'>';

			if(!mail($to, $subject, $message, implode("\r\n", $headers))){
				header('Location: ../panel.php');
				$_SESSION['error'] = 'loadToast(\'3\',\'Błąd formularza wiadomości!\',\'Próba wysłania maila nie powiodła się. Skontaktuj się z działem technicznym!\')';
			}
			
			header('Location: ../panel.php');
			$_SESSION['error'] = 'loadToast(\'0\',\'Formularz wiadomości!\',\'Mail o temacie <b>'.$tematyka.'</b> został wysłany pomyślnie!\')';
		}
		else{
			//Brak parametrów POST
			header('Location: ../panel.php');
			$_SESSION['error'] = 'loadToast(\'3\',\'Błąd formularza wiadomości!\',\'Próba wysłania maila bez danych nie powiodła się.\')';
		}  
	 }
	 else{
		 header('Location: ../logowanie.php');
		 $_SESSION['error'] = 'loadToast(\'3\',\'Błąd logiczny!\',\'Próba przejścia na stronę bez logowania!\')';
	 } 
?>