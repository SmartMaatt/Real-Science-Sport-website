<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<title>rejestrowanie</title>
</head>

<body>
<?php
    session_start();

    function return_to_register_page($reason) {
        $_SESSION['error'] = '<span style="color:red">'.$reason.'</span>';
        header('Location: rejestracja.php');
        exit(0);
    }

	$imie = htmlentities($_POST['imie']);
    $nazwisko = htmlentities($_POST['nazwisko']);
    $id_klubu = $_POST['id_klubu'];
    $login = htmlentities($_POST['login']);
    $haslo1 = $_POST['haslo1'];
    $haslo2 = $_POST['haslo2'];

    if ($haslo1 != $haslo2) {
        return_to_register_page('Hasła się nie zgadzają!');
    }

    if (!is_numeric($id_klubu)) {
        return_to_register_page('Nie podano prawidłowego nr. klubu!');
    }

	require_once 'connect.php';

	$connection = @new mysqli($host, $db_user, $db_password, $db_name);

	if ($connection->connect_errno == 0) {
        $sql = sprintf("INSERT INTO osoby (Imie, Nazwisko, id_klubu, stanowisko)
                        VALUES ('%s', '%s', '%s', '%s')",
                        mysqli_real_escape_string($connection, $imie),
                        mysqli_real_escape_string($connection, $nazwisko),
                        $id_klubu, 'pracownik');

        $result = @$connection->query($sql);

        if ($result) {
            $id_osoby = $connection->insert_id;
            $pw_hash = password_hash($haslo1, PASSWORD_BCRYPT);

            $sql = sprintf(
                "INSERT INTO konto (id_osoby, login, haslo) VALUES ('%s', '%s', '%s')",
                $id_osoby, mysqli_real_escape_string($connection, $login), $pw_hash
            );

            $result = @$connection->query($sql);

            if ($result) {
                $_SESSION['id_osoby'] = $id_osoby;
                $_SESSION['login'] = $login;
                header('Location: index.php');
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
</body>
</html>