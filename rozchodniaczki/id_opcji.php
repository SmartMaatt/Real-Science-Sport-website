<?php 
	/*SECURED*/
	if (session_status() == PHP_SESSION_NONE) {
		header('Location: ../../logowanie.php');
	}

	if(isset($_GET['o']) && isset($_GET['p']) && isset($_GET['b']))
	{
		session_start();
		$_SESSION['id_opcji'] = $_GET['o'];
		$_SESSION['id_podopcji'] = $_GET['p'];
		$_SESSION['id_badania'] = $_GET['b'];
	}
	
	if(isset($_SESSION['id_admina']))
	{
		header('Location: ../panel_admina.php');
	}
	else
	{
		header('Location: ../panel.php');
	}
?>