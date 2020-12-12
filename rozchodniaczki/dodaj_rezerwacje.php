<?php

	require_once "connect.php";
	
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno;
	}
	else
	{
		session_start();
		$id_klubu = $_SESSION['id_klubu'];
		$oplacone = 0;
		$correct = 1;

		$id_o = $_SESSION['id_opcji'];
		$godz_pocz = $_POST['godz_pocz'];
		$godz_pom = strtotime($godz_pocz);
		$godz = date('H', $godz_pom);
		
		$godz_kon = $_POST['godz_kon'];
		$godz_pom = strtotime($godz_kon);
		$godz_kon = date('H', $godz_pom);
		$ile_godz = $godz_kon - $godz;
		$ile_stanowisk = $_POST['liczba_stanowisk'];
		$data = $_POST['data'];

		$sql = "SELECT liczba_torow AS ile_wolnych FROM kluby WHERE id_klubu = '$id_klubu'";
		if($result1 = @$connection->query($sql))
		{
			$row1 = $result1->fetch_assoc();
			$wolne = $row1['ile_wolnych'];
			$pom_godz = $godz;
			for($i = 0; $i < $ile_godz; $i++)
			{
				$sql = "SELECT COUNT(id_rezerwacji) AS ile_zajetych FROM `rezerwacje` WHERE id_opcji = '$id_o' AND id_klubu = '$id_klubu' AND godzina = '$pom_godz' AND data = '$data'";
				if($result2 = @$connection->query($sql))
				{
					$row2 = $result2->fetch_assoc();
					$wolne -= $row2['ile_zajetych'];
				}
				if($ile_stanowisk > $wolne)
				{
					$correct = 0;
					break;
				}
				$pom_godz++;
			}
		}
		if($correct)
		{
			$imie = $_POST['zamowienie_imie'];
			$nazwisko = $_POST['zamowienie_nazwisko'];
			$tel = $_POST['zamowienie_telefon'];
			$email = $_POST['zamowienie_email'];
			$sql4 = "SELECT id_klienta FROM klient WHERE imie = '$imie' AND nazwisko ='$nazwisko' AND telefon = '$tel' AND adres_email = '$email'";
			if($result4 = @$connection->query($sql4))
			{
				$row4 = $result4->fetch_assoc();
				if (!isset($row4['id_klienta'])) 
				{
					$sql6 = "SELECT id_klienta FROM klient ORDER BY id_klienta";
					if($result6 = @$connection->query($sql6))
					{
						$id_klienta = $result6->num_rows + 1;
						
						for ($i = 1; $i <= $result6->num_rows; $i++)
						{
							$row6 = $result6->fetch_assoc();
							if($i != $row6['id_klienta'])
							{
								$id_klienta = $i;
								break;
							}
						}
						$result6->free_result();
					}
					$sql5 = "INSERT INTO klient (id_klienta, imie, nazwisko, telefon, adres_email) VALUES ('$id_klienta', '$imie', '$nazwisko', '$tel', '$email')";
					@$connection->query($sql5);
				}
				else 
				{
					$id_klienta = $row4['id_klienta'];
				}
				$result4->free_result();
			}
			
			
			for($k = 0; $k < $ile_stanowisk; $k++)
			{
				$pom_godz = $godz;
				for($j = 0; $j < $ile_godz; $j++)
				{
					$sql = "SELECT id_rezerwacji FROM rezerwacje ORDER BY id_rezerwacji";
					if($result = @$connection->query($sql))
					{
						$id_r = $result->num_rows + 1;
						
						for ($i = 1; $i <= $result->num_rows; $i++)
						{
							$row = $result->fetch_assoc();
							if($i != $row['id_rezerwacji'])
							{
								$id_r = $i;
								break;
							}
						}
						$result->free_result();
					}
					
					$sql = "SELECT nr_porzadkowy FROM rezerwacje WHERE id_opcji = '$id_o' AND id_klubu = '$id_klubu' AND godzina = '$pom_godz' AND data = '$data' ORDER BY nr_porzadkowy";
					if($result = @$connection->query($sql))
					{
						$nr_porzadkowy = $result->num_rows + 1;
						
						for ($i = 1; $i <= $result->num_rows; $i++)
						{
							$row = $result->fetch_assoc();
							if($i != $row['nr_porzadkowy'])
							{
								$nr_porzadkowy = $i;
								break;
							}
						}
						$result->free_result();
					}	
					$sql = "INSERT INTO rezerwacje (id_rezerwacji, id_klienta, id_opcji, id_klubu, godzina, oplacone, data, nr_porzadkowy) VALUES ('$id_r', '$id_klienta', '$id_o', '$id_klubu', '$pom_godz', '0', '$data', '$nr_porzadkowy')";
					@$connection->query($sql);
					$pom_godz++;
				}
			}
			$_SESSION['correct_reservation'] = 1;
		}
		else
		{
			$_SESSION['correct_reservation'] = 0;
		}
		$connection->close();
		header('Location: ../rezerwacja.php');
	}
?>