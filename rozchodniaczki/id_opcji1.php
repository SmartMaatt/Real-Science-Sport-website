<?php 
	session_start();
	$_SESSION['id_opcji'] = 1;
	header('Location: ../rezerwacja.php');
?>