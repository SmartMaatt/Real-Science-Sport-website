<?php
	/*SECURED*/
	/*Zmiana podglądu klienta z konta administratora*/
	
    session_start();
	
	function jump_to_page($mode,$top,$bottom,$dest){
		echo $mode.' '.$top.' '.$bottom;
		$_SESSION['error'] = 'loadToast(\''.$mode.'\',\''.$top.'\',\''.$bottom.'\')';
		header('Location: ../../'.$dest.'.php');
    }

	//Wejście od strony admina
	if(isset($_GET['id_klienta']) && isset($_GET['imie']) && isset($_GET['nazwisko'])){
		
		if(isset($_SESSION['id_admina'])){

			$_SESSION['id_klienta'] = $_GET['id_klienta'];
			$_SESSION['id_opcji'] = 1;
			$_SESSION['id_podopcji'] = 0;
			$_SESSION['id_badania'] = -1;
			
			$_SESSION['imie_klienta'] = $_GET['imie'];
			$_SESSION['nazwisko_klienta'] = $_GET['nazwisko'];
			jump_to_page('0','Przeglądasz teraz profil klienta: '.$_GET['imie'].' '.$_GET['nazwisko'], '', 'panel');
		}
		else {
			
			//Anti hackerman
			jump_to_page('3','Gotcha chuju!','Nie hackuj mnie kurwiu!','panel_admina');
		}
	}
	//Wyjście z podglądu
	elseif(isset($_GET['wyjscie'])){
		
		$_SESSION['id_opcji'] = 101;
		$_SESSION['id_podopcji'] = 0;
		$_SESSION['id_badania'] = -1;
		
		unset($_SESSION['imie_klienta']);
		unset($_SESSION['nazwisko_klienta']);
		
		jump_to_page('0','Witaj ponownie na panelu admina','','panel_admina');
	}
	else {
		
		//Brak parametrów GET
		jump_to_page('3','Błąd logiczny','Nie podano wszystkich parametrów wymaganych do przeprowadzenia operacji!','panel_admina');
	}
?>