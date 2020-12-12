<?php
    session_start();
    unset($_SESSION['id_osoby']);
    unset($_SESSION['login']);
    unset($_SESSION['error']);
	unset($_SESSION['Imie']);
    unset($_SESSION['Nazwisko']);
	unset($_SESSION['id_klubu']);
    unset($_SESSION['data']);

    header('Location: ../index.php');
?>