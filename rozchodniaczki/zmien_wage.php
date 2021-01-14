<?php
	/*SECURED*/
	session_start();

	function jump_to_page($location,$mode,$top,$bottom){
        header('Location: ../'.$location);
		$_SESSION['error'] = 'loadToast(\''.$mode.'\',\''.$top.'\',\''.$bottom.'\')';
    }
	
    $incorrect_data = 'Brak takiego konta!';
	$incorrect_conection = 'Nie udało się zresetować hasła spróbuj ponownie!';

	//Parametry wymagane do przeprowadzenia algorytmu
	if(isset($_POST['waga'])){
		
		//Pobranie wartości z POST
		$waga = $_POST["waga"];
		$id_klienta = $_SESSION['id_klienta'];
		
		//Połączenie z bazą
		require_once 'connect.php';
		$connection = @new mysqli($host, $db_user, $db_password, $db_name);

		//Czy połącznie z bazą zostało nawiązane?
		if ($connection->connect_errno == 0) {
			
			$sql = "INSERT INTO waga(data, id_klienta, wartosc) VALUES (date("Y-m-d"),$id_klienta,$waga)";
			$result = @$connection->query($sql);
			jump_to_page('panel.php','0','Zmieniono wagę','Poprawnie zmieniono wagę');
		}
	}
	else{
		
		//Brak parametrów POST
		jump_to_page('panel.php','3','Błąd z podaną wagą','Nie podano parametrów do zmiany wagi');
	}
?>