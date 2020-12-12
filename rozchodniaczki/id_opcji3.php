<?php 
	session_start();
	$_SESSION['id_opcji'] = 3;
	header('Location: ../rezerwacja.php');
?>