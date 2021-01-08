<?php
    session_start();
	if (session_status() == PHP_SESSION_NONE) {
		header('Location: ../../logowanie.php');
	}

    $id_klienta = $_POST['id_klienta'];

	require_once 'connect.php';

	$connection = @new mysqli($host, $db_user, $db_password, $db_name);

	if ($connection->connect_errno == 0) {
        $sql = "DELETE FROM `klient` WHERE id_klienta = '$id_klienta'";

        $result = @$connection->query($sql);
	}
	header('Location: ../panel_admina.php');
?>