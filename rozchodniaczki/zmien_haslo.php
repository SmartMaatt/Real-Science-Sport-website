<?php
    session_start();

    function return_to_login_page($reason) {
        header('Location: ../panel.php');
		$_SESSION['error'] = 'onload="loadToast(\'3\',\'Hasło nie zostało zmienione\',\''.$reason.'\')"';
        exit(0);
    }
	
    $incorrect_data = 'Brak takiego konta!';
	$incorrect_conection = 'Nie udało się zresetować hasła spróbuj ponownie!';

	$stare_haslo = htmlentities($_POST['stare_haslo']);
    $nowe_haslo1 = htmlentities($_POST['nowe_haslo1']);
    $nowe_haslo2 = htmlentities($_POST['nowe_haslo2']);
	$id_klienta = $_SESSION['id_klienta'];
	
	if ($nowe_haslo1 != $nowe_haslo2) {
        return_to_login_page('Hasła się nie zgadzają!');
    }
	
	require_once 'connect.php';

	$connection = @new mysqli($host, $db_user, $db_password, $db_name);

	if ($connection->connect_errno == 0) {
        $sql = "SELECT haslo FROM klient WHERE id_klienta = '$id_klienta'";

		$result = @$connection->query($sql);

		if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
			$db_pass = $row['haslo'];
			$old_pw_hash = password_hash($stare_haslo, PASSWORD_BCRYPT);
			if(password_verify($stare_haslo, $db_pass))
			{
				$pw_hash = password_hash($nowe_haslo1, PASSWORD_BCRYPT);
				$sql2 = "UPDATE klient SET haslo = '$pw_hash' WHERE id_klienta = '$id_klienta'";
				$result2 = @$connection->query($sql2);
				if($result2)
				{
					//$result2->free_result();
					header('Location: ../panel.php');
					$_SESSION['error'] = 'onload="loadToast(\'0\',\'Hasło zostało zmienione pomyślnie\',\'\')"';
				}
				else
					return_to_login_page($incorrect_data);
			}
			else {
				echo $id_klienta."\n";
				echo $db_pass."\n";
				echo $old_pw_hash."\n";
				return_to_login_page('Hasła się nie zgadzają!');
			}
            
        } else {
            return_to_login_page($incorrect_data);
        }
		
        $result->free_result();
		
		$connection->close();
	} else {
		echo 'Error: '.$connection->connect_errno;
	}
?>