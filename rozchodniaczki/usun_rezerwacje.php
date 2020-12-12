<?php
	require_once "connect.php";
	
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno;
	}
	else
	{
		session_start();
		$data = $_SESSION['data'];
		$godz = $_POST['godzina'];
		$nr_porzadkowy = $_POST['nr_porzadkowy'];
		$id_opcji = $_SESSION['id_opcji'];
		
		
		$sql = "DELETE FROM rezerwacje WHERE data = '$data' AND godzina = '$godz' AND nr_porzadkowy = '$nr_porzadkowy' AND id_opcji ='$id_opcji'";
		echo "$sql";
		@$connection->query($sql);
		$connection->close();
		header('Location: ../rezerwacja.php');
	}
?>