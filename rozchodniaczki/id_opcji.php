<?php 

	if(isset($_POST['nowe_id_opcji']) && isset($_POST['nowe_id_podopcji'])){
		session_start();
		$_SESSION['id_opcji'] = $_POST['nowe_id_opcji'];
		$_SESSION['id_podopcji'] = $_POST['nowe_id_podopcji'];
	}
	header('Location: ../panel.php');
?>