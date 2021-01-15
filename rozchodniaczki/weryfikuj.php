<?php
	/*SECURED*/
	session_start();
	
	 function jump_to_page($mode,$top,$bottom) {
        header('Location: ../logowanie.php');
		$_SESSION['error'] = 'loadToast(\''.$mode.'\',\''.$top.'\',\''.$bottom.'\')';
		exit(0);
    }

	//Czy istnieje parametr
	if(isset($_GET['vkey'])){
		
		//Klucz aktywacyjny
		$vkey = $_GET['vkey'];
		
		//Połączenie z bazą
		require_once 'connect.php';
		$connection = @new mysqli($host, $db_user, $db_password, $db_name);
		
		//Czy połączenie się udało
		if ($connection->connect_errno == 0){
			
			//Wyszukaj klientów o podanym kodzie i braku weryfikacji
			$sql = "SELECT potwierdzone,vkey FROM klient WHERE potwierdzone = 0 AND vkey = '$vkey' LIMIT 1";
			$result = @$connection->query($sql);
			
			//Czy zapytanie się powiodło
			if($result){
				
				//Czy jest jeden taki rekord
				if($result->num_rows == 1){
					
					$result->free_result();
					$sql = "UPDATE klient SET potwierdzone = 1 WHERE vkey = '$vkey' LIMIT 1";
					$result = @$connection->query($sql);
					
					//Udało się zweryfikować konto
					if($result){
						
						jump_to_page('0','Weryfikacja przebiegła pomyślnie!','');
						$connection->close();
					}
					else{
						
						//Błąd bazy
						jump_to_page('3','Błąd bazy danych!','Niepowodzenie wykonania zapytania sql!');
						$connection->close();
					}
				}
				else{
					
					//Liczba rekordów != 1
					jump_to_page('2','Błąd logiczny!','Konto nie istnieje lub jest już zweryfikowane!');
					$connection->close();
				}
			}
			else{
				
				//Niepowodzenie wykonania zapytania sql
				jump_to_page('3','Błąd bazy danych!','Niepowodzenie wykonania zapytania sql!');
				$connection->close();
			}
		}
		else{
			
			//Niepowodzenie połącznie z bazą danych
			jump_to_page('3','Błąd bazy danych!','Nieudane połącznie z bazą danych!');
		}
	}
	else{
		
		//Brak parametrów get'a
		jump_to_page('2','Błąd dostępu do podanej strony!','');
	}
?>