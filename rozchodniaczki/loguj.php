<?php
    session_start();

    function return_to_login_page($reason) {
        $_SESSION['error'] = '<span style="color:red">'.$reason.'</span>';
        header('Location: ../logowanie.php');
        exit(0);
    }
    $incorrect_login_or_password = 'Nieprawidłowy mail lub hasło!';

    $mail = $_POST['mail'];
    $pass  = $_POST['haslo'];

	require_once 'connect.php';

	$connection = @new mysqli($host, $db_user, $db_password, $db_name);

	if ($connection->connect_errno == 0) {
        $sql = sprintf("SELECT * FROM klient WHERE mail = '%s'",
                        mysqli_real_escape_string($connection, $mail));

        $result = @$connection->query($sql);

		if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $db_pass = $row['haslo'];

            if (password_verify($pass, $db_pass)) {
                $_SESSION['id_klienta'] = $row['id_klienta'];
				$_SESSION['imie'] 		= $row['imie'];
				$_SESSION['nazwisko'] 	= $row['nazwisko'];
				$_SESSION['mail']       = $row['mail'];
				$_SESSION['data'] 		= date("Y-m-d");
				$_SESSION['id_opcji'] 	= 1;
				$_SESSION['id_podopcji'] = 0;
                unset($_SESSION['error']);
                header('Location: ../panel.php');
            } else {
                //return_to_login_page($incorrect_login_or_password);
            }
        } else {
			//return_to_login_page($incorrect_login_or_password);
        }
        $result->free_result();
		
		$connection->close();
	} else {
		echo 'Error: '.$connection->connect_errno;
	}
?>