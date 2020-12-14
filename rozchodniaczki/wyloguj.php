<?php
    session_start();
    unset($_SESSION['id_klienta']);
    unset($_SESSION['imie']);
    unset($_SESSION['naziwsko']);
	unset($_SESSION['mail']);
    unset($_SESSION['data']);
	unset($_SESSION['id_opcji']);
	unset($_SESSION['id_podopcji']);

    header('Location: ../logowanie.php');
?>