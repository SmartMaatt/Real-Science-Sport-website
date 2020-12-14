<?php
    session_start();
    unset($_SESSION['id_klienta']);
    unset($_SESSION['imie']);
    unset($_SESSION['naziwsko']);
	unset($_SESSION['mail']);
    unset($_SESSION['data']);
	unset($_SESSION['io_opcji']);

    header('Location: ../logowanie.php');
?>