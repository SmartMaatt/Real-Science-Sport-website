<?php
    session_start();

    function return_to_login_page($reason) {
        $_SESSION['error'] = '<span style="color:red">'.$reason.'</span>';
        header('Location: ../index.php');
        exit(0);
    }
    $incorrect_login_or_password = 'Nieprawidłowy login lub hasło!';

    $login = $_POST['login'];
    $pass  = $_POST['haslo'];

	require_once 'connect.php';

	$connection = @new mysqli($host, $db_user, $db_password, $db_name);

	if ($connection->connect_errno == 0) {
        $sql = sprintf("SELECT * FROM konto WHERE login = '%s'",
                        mysqli_real_escape_string($connection, $login));

        $result = @$connection->query($sql);

		if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $db_pass  = $row['haslo'];

            if (password_verify($pass, $db_pass)) {
                $_SESSION['id_osoby']   = $row['id_osoby'];
                $_SESSION['login']      = $row['login'];
				
				$id_os = $row['id_osoby'];
				$sql2 = "SELECT * FROM osoby WHERE id_osoby = '$id_os'";
				if($result2 = @$connection->query($sql2))
				{
					$row2 = $result2->fetch_assoc();
					$_SESSION['Imie'] 		= $row2['Imie'];
					$_SESSION['Nazwisko'] 	= $row2['Nazwisko'];
					$_SESSION['id_klubu'] 	= $row2['id_klubu'];	
				}
				$_SESSION['data'] 		= date("Y-m-d");
				$_SESSION['id_opcji'] 	= 1;
                unset($_SESSION['error']);

                header('Location: ../clientPanelTemplate.php');
            } else {
                return_to_login_page($incorrect_login_or_password);
            }
        } else {
            return_to_login_page($incorrect_login_or_password);
        }
		
		$data = $_SESSION['data'];
		$sql3 = "DELETE FROM rezerwacje WHERE data < '$data'";
		@$connection->query($sql3);
		
        $result->free_result();
		
		$connection->close();
	} else {
		echo 'Error: '.$connection->connect_errno;
	}
?>