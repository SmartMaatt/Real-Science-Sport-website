<?php
	session_start();

	if (isset($_SESSION['id_klienta'])) {
		header('Location: clientPanelTemplate.php');
	}
	else
		header('Location: logowanie.php');
?>