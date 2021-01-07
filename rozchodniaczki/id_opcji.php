<?php 

	if(isset($_GET['o']) && isset($_GET['p']) && isset($_GET['b'])){
		session_start();
		$_SESSION['id_opcji'] = $_GET['o'];
		$_SESSION['id_podopcji'] = $_GET['p'];
		$_SESSION['id_badania'] = $_GET['b'];
	}
	
	header('Location: ../panel.php');
?>