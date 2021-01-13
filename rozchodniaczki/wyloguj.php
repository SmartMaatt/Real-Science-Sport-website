<?php
	/*SECURED*/
    session_start();
	
	//Czy sesja istnieje, jeśli nie do logowania
	if (isset($_SESSION['id_klienta']))
	{
		unset($_SESSION['id_klienta']);
		unset($_SESSION['imie']);
		unset($_SESSION['naziwsko']);
		unset($_SESSION['mail']);
		unset($_SESSION['plec']);
		unset($_SESSION['data']);
		unset($_SESSION['data_urodzenia']);
		unset($_SESSION['id_opcji']);
		unset($_SESSION['id_podopcji']);
		unset($_SESSION['id_badania']);
		
		if(isset($_SESSION['id_admina']))
		{
			unset($_SESSION['id_admina']);
			unset($_SESSION['excel_plik']);
		}
		
		unset($_SESSION['error']);
		unset($_SESSION['askMe']);
		
		unset($_SESSION['imie_klienta']);
		unset($_SESSION['naziwsko_klienta']);
		
		session_destroy();
	}
	
    header('Location: ../logowanie.php');
?>