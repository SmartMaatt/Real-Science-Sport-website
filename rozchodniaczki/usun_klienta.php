<?php
    session_start();
	
	 function jump_to_page($mode,$top,$bottom) {
        header('Location: ../panel_admina.php');
		$_SESSION['error'] = 'loadToast(\''.$mode.'\',\''.$top.'\',\''.$bottom.'\')';
    }

	if(isset($_GET['id_klienta'])) {
		$id_klienta = $_GET['id_klienta'];

		require_once 'connect.php';

		$connection = @new mysqli($host, $db_user, $db_password, $db_name);

		if ($connection->connect_errno == 0) {
			$sql = "DELETE FROM `klient` WHERE id_klienta = '$id_klienta'";

			$result = @$connection->query($sql);
			if($result){jump_to_page('0','Usunięcie klienta zakończone powodzeniem','');}
			else{jump_to_page('3','Błąd bazy danych', 'Niepowodzenie w wykonaniu zapytania sql<br/>Command: DELETE');}
		}
		$connection->close();
	}
	else {
		//Brak parametrów GET
		jump_to_page('3','Błąd logiczny','Nie podano wszystkich parametrów wymaganych do przeprowadzenia operacji!');
	}
?>