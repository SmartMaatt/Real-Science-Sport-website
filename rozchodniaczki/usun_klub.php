<?php
    session_start();
	if (session_status() == PHP_SESSION_NONE) {
		header('Location: ../../logowanie.php');
	}

    $id_klubu = $_POST['id_klubu'];

	require_once 'connect.php';

	$connection = @new mysqli($host, $db_user, $db_password, $db_name);

	if ($connection->connect_errno == 0) {
        $sql = "DELETE FROM `klub` WHERE id_klubu = '$id_klubu'";

        $result = @$connection->query($sql);
	}
	header('Location: ../panel_admina.php');
?>