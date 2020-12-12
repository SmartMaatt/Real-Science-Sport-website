<?php 
	session_start();
	$_SESSION['id_opcji'] = 2;
	header('Location: ../rezerwacja.php');
?>