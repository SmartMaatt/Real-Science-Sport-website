<?php
    session_start();

    function return_to_register_page($reason) {
        $_SESSION['error'] = '<span style="color:red">'.$reason.'</span>';
        header('Location: ../rejestracja.php');
        exit(0);
    }

	$imie = htmlentities($_POST['imie']);
    $nazwisko = htmlentities($_POST['nazwisko']);
    $mail = htmlentities($_POST['mail']);
    $haslo1 = $_POST['haslo1'];
    $haslo2 = $_POST['haslo2'];
	//bot or not?
	//$sekret = "6Lc9AgQaAAAAANEBN_3yAfuMdVN8t54FzWyfG5PS";
	//$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
	//$odpowiedz = json_decode($sprawdz);
	
	//if(!($odpowiedz->success)) {
        //return_to_register_page('Potwierdź, że nie jesteś robotem');
    //}
	
    if ($haslo1 != $haslo2) {
        return_to_register_page('Hasła się nie zgadzają!');
    }

	require_once 'connect.php';

	$connection = @new mysqli($host, $db_user, $db_password, $db_name);

	if ($connection->connect_errno == 0) {
		$sql = "SELECT * FROM klient where mail = '$mail'";
		$result = @$connection->query($sql);
		if($result) {
			$ile = $result->num_rows;
			if($ile >0)
				return_to_register_page('Konto o podanym mailu już istnieje');
		}

        $result = @$connection->query($sql);

        if ($result) {
            $pw_hash = password_hash($haslo1, PASSWORD_BCRYPT);

            $sql = sprintf("INSERT INTO klient (imie, nazwisko, mail, haslo) VALUES ('%s', '%s', '%s' , '%s')",
                mysqli_real_escape_string($connection, $imie),
				mysqli_real_escape_string($connection, $nazwisko),
				mysqli_real_escape_string($connection, $mail),
				$pw_hash
            );
			
            $result = @$connection->query($sql);

            if ($result) {
                header('Location: ../panel.php');
            } else {
                echo 'Error: '.$connection->connect_errno;
            }

            $result->free_result();
        } else {
            echo 'Error: '.$connection->connect_errno;
        }

        $result->free_result();
		$connection->close();
	} else {
		echo 'Error: '.$connection->connect_errno;
	}
?>