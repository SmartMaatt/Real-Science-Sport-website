<?php 

	if(isset($_GET['m']) && isset($_GET['msg']) && isset($_GET['p']))
	{
		session_start();
		$_SESSION['askMe'] = 'infoCard(\''.$_GET['m'].'\',\''.$_GET['msg'].'\',\''.$_GET['p'].'\')';
		echo $_SESSION['askMe'];
	}
	
	header('Location: ../logowanie.php');
	
?>