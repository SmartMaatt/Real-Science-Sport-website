<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<title>bojowe zadanie</title>
</head>
<body>

<?php
	session_start();

	if (!isset($_SESSION['id_osoby'])) {
		header('Location: logowanie.php');
	}

	require_once "connect.php";
	
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno;
	}
	else
	{
		foreach($_POST as $key => $name)
		{
			$id_z = $key;
		}
		echo '<h2>szczegoly zamowienia</h2>';
		$sql = "SELECT * FROM adres_zamowienia WHERE id_zamowienia = '$id_z'";
		if($result = @$connection->query($sql))
		{
			$row = $result->fetch_assoc();
			$id_zamowienia = $row['id_zamowienia'];
			$adres = $row['kraj']." ".$row['miasto']." ".$row['ulica']." ".$row['nr_domu']."/".$row['nr_mieszkania']." ".$row['kod_pocztowy'];
			$telefon = $row['telefon'];
			echo '<table border="1" cellpadding="10" cellspacing="0">';
			echo '<tr>';
			echo "<td>id_zamowienia</td><td>adres</td><td>telefon</td>";
			echo '</tr>';
			echo '<tr>';
			echo "<td>$id_z</td><td>$adres</td><td>$telefon</td>";
			echo '</tr>';
			echo '</table>';			
			$result->free_result();
		}
		echo "</br>";
		$sql2 = "SELECT m.nazwa_uslugi, m.cena_uslugi FROM menu m, zamowienia_menu zm WHERE zm.id_uslugi = m.id_uslugi AND zm.id_zamowienia = '$id_z'";
		if($result2 = @$connection->query($sql2))
		{
			$suma = 0;
			echo '<table border="1" cellpadding="10" cellspacing="0">';
			echo '<tr>';
			echo "<td>nazwa</td><td>cena</td>";
			echo '</tr>';
			for($i=0; $i < $result2->num_rows; $i++)
			{
				$row2 = $result2->fetch_assoc();
				$nazwa = $row2['nazwa_uslugi'];
				$cena = $row2['cena_uslugi'];
				$suma += $cena;
				echo '<tr>';
				echo "<td>$nazwa</td><td>$cena</td>";
				echo '</tr>';
			}
			echo '<tr>';
			echo "<td>suma</td><td>$suma</td>";
			echo '</tr>';
			echo '</table>';
			$result2->free_result();
		}
		$connection->close();
	}

//SELECT m.nazwa_uslugi, m.cena_uslugi FROM zamowienia z, zamowienia_menu zm, menu m where z.id_zamowienia = zm.id_zamowienia and m.id_uslugi = zm.id_uslugi and z.id_zamowienia = 1
?>
</body>
</html>


