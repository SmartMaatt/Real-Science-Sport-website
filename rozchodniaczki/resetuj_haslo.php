<?php
    session_start();

    function return_to_login_page($reason) {
        $_SESSION['error'] = '<span style="color:red">'.$reason.'</span>';
        header('Location: ../logowanie.php');
        exit(0);
    }
	
	function randomPassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}
	
    $incorrect_data = 'Brak takiego konta!';
	$incorrect_conection = 'Nie udało się zresetować hasła spróbuj ponownie!';

    $imie = htmlentities($_POST['imie']);
    $nazwisko = htmlentities($_POST['nazwisko']);
	$mail = htmlentities($_POST['mail']);

	require_once 'connect.php';

	$connection = @new mysqli($host, $db_user, $db_password, $db_name);

	if ($connection->connect_errno == 0) {
        $sql = sprintf("SELECT * FROM klient WHERE imie = '%s' AND nazwisko = '%s' AND mail = '%s'",
                        mysqli_real_escape_string($connection, $imie),
						mysqli_real_escape_string($connection, $nazwisko),
						mysqli_real_escape_string($connection, $mail));
		$result = @$connection->query($sql);

		if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $haslo = randomPassword();
			$pw_hash = password_hash($haslo, PASSWORD_BCRYPT);
			$sql2 = "UPDATE klient SET haslo = '$pw_hash' WHERE mail = '$mail'";
			$result2 = @$connection->query($sql2);
			if($result2)
			{
				echo $haslo;
				//$result2->free_result();
			}
			else
				return_to_login_page($incorrect_data);
            
        } else {
			return_to_login_page($incorrect_data);
        }
		
        $result->free_result();
		//header('Location: ../panel.php');
		
		$connection->close();
	} else {
		echo 'Error: '.$connection->connect_errno;
	}
?>