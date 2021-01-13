<?php 

	session_start();
	if(isset($_GET['m']) && isset($_GET['msg']) && isset($_GET['p'])){
		
		if($_GET['m'] == '2'){
			
			require_once 'connect.php';
			$connection = @new mysqli($host, $db_user, $db_password, $db_name);

			if ($connection->connect_errno == 0) {
				
				$sql = "SELECT * FROM klub";
				$result = @$connection->query($sql);
				if ($result) {
					
					$moja_tablica_xd = ',\''.$_GET['p'].'\'';
					while($row = $result->fetch_assoc()){
						$moja_tablica_xd = $moja_tablica_xd.',\''.$row['id_klubu'].'\',\''.$row['nazwa'].'\'';
					}
					
					$_SESSION['askMe'] = 'infoCard(\''.$_GET['m'].'\',\''.$_GET['msg'].'\''.$moja_tablica_xd.')';
					echo $_SESSION['askMe'];
					
				}
				else {
					//Niepowodzenie wykonania zapytania SQL
					header('Location: ../panel_admina.php');
					$_SESSION['error'] = 'loadToast(\'3\',\'Błąd wykonania polecenia SQL!\',\'Command: SELECT * FROM klub\')';
				}
				$connection->close();
			}
			else{
				//Niepowodzenie połączenia z bazą danych
				header('Location: ../panel_admina.php');
				$_SESSION['error'] = 'loadToast(\'3\',\'Błąd bazy danych\',\'Error '.$connection->connect_errno.'\')';
			}
					
		}
		else{
			//Wyświetlenie zapytania innego niż [2]
			$_SESSION['askMe'] = 'infoCard(\''.$_GET['m'].'\',\''.$_GET['msg'].'\',\''.$_GET['p'].'\')';
			echo $_SESSION['askMe'];
		}
	}
	
	header('Location: ../panel_admina.php');
?>