<?php
    session_start();
	
	//Czy sesja istnieje, jeśli nie do logowania
	 if (isset($_SESSION['id_klienta'])){
		unset($_SESSION['id_klienta']);
		unset($_SESSION['imie']);
		unset($_SESSION['naziwsko']);
		unset($_SESSION['mail']);
		unset($_SESSION['data']);
		unset($_SESSION['id_opcji']);
		unset($_SESSION['id_podopcji']); 
		unset($_SESSION['id_admina']);

		session_destroy();
	 }

    header('Location: ../logowanie.php');
?>