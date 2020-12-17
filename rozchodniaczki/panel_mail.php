<?php

	session_start();

	//Session exists	
	 if (isset($_SESSION['id_klienta'])){
		 
		//All data is set 
		if(isset($_POST['tematyka_maila']) && isset($_POST['tytul_maila']) && isset($_POST['tresc_maila'])){
			
			//Pull all post vars
			$tematyka = $_POST['tematyka_maila'];
			$tytul = $_POST['tytul_maila'];
			$tresc = $_POST['tresc_maila'];
			
			//Choose correct recevier
			$to = "";
			if($tematyka == "Pytanie do działu technicznego"){
				$to = 'mateuszplonka.tg@gmail.com';
			}
			else{
				$to = 'realsciencesport@gmail.com';
			}
			
			$subject = $_SESSION['imie'] . ' ' . $_SESSION['nazwisko'];
			$message = "Imie: " . $_SESSION['imie'] . "<br/>Nazwisko: " . $_SESSION['nazwisko'] . "<br/>E-mail: " . $_SESSION['mail'] . "<br/>Temat: <b>". $tematyka ."</b></br><br/>" . $tresc;
			$headers = 'RSS Panel: ' . $tytul . "\r\n" .'Content-type: text/html; charset=utf-8';

			/*echo "Tematyka: ".$tematyka."</br>";
			echo "Tytuł: ".$tytul."</br>";
			echo "Treść: ".$tresc."</br>";
			echo "To: ".$to."</br>";
			echo "Subject: ".$subject."</br>";
			echo "</br>Message: </br>".$message."</br>";
			echo "Headers:".$headers."</br>";*/
			
			if(!mail($to, $subject, $message, $headers)){
				header('Location: ../panel.php');
				$_SESSION['error'] = 'onload="loadToast(\'3\',\'Błąd formularza wiadomości!\',\'Próba wysłania maila nie powiodła się. Skontaktuj się z działem technicznym!\')"';
			}
			
			 header('Location: ../panel.php');
				$_SESSION['error'] = 'onload="loadToast(\'0\',\'Formularz wiadomości!\',\'Mail o temacie <b>'.$tematyka.'</b> został wysłany pomyślnie!\')"';
		}
		else{
			header('Location: ../panel.php');
			$_SESSION['error'] = 'onload="loadToast(\'3\',\'Błąd formularza wiadomości!\',\'Próba wysłania maila bez danych nie powiodła się.\')"';
		}  
	 }
	 else{
		 header('Location: ../logowanie.php');
		 $_SESSION['error'] = 'onload="loadToast(\'3\',\'Błąd logiczny!\',\'Próba przejścia na stronę bez logowania!\')"';
	 }


	
	 
?>