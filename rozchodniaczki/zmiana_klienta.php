<?php
	/*SECURED*/
    session_start();
	
	 function jump_to_page($mode,$top,$bottom,$dest) {
		echo $mode.' '.$top.' '.$bottom;
		$_SESSION['error'] = 'loadToast(\''.$mode.'\',\''.$top.'\',\''.$bottom.'\')';
		header('Location: ../'.$dest.'.php');
    }

	if(isset($_GET['id_klienta']) && isset($_GET['imie']) && isset($_GET['nazwisko'])) {
		
		if(isset($_SESSION['id_admina'])){

			$_SESSION['id_klienta'] = $_GET['id_klienta'];
			$_SESSION['id_opcji'] = 1;
			$_SESSION['id_podopcji'] = 0;
			$_SESSION['id_badania'] = -1;
			jump_to_page('0','Przeglądasz teraz profil klienta: '.$_GET['imie'].' '.$_GET['nazwisko'], '', 'panel');
		}
		else{
			//Anti hackerman
			jump_to_page('3','Gotcha chuju!','Nie hackuj mnie kurwiu!','panel_admina');
		}
	}
	else {
		//Brak parametrów GET
		jump_to_page('3','Błąd logiczny','Nie podano wszystkich parametrów wymaganych do przeprowadzenia operacji!','panel_admina');
	}
?>