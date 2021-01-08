<?php
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	if ($connection->connect_errno == 0)
	{
		$sql = "SELECT COUNT(id_klienta) as ile FROM klient";
		$result = @$connection->query($sql);
		if($result)
		{
			$row = $result->fetch_assoc();
			$strona_max = (int)($row['ile']/10);
			if($row['ile']%10 == 0)
			{
				$strona_max --;
			}
		}
		
		if(isset($_POST['strona']))
		{
			$strona = $_POST['strona'];
			if($strona <= 0)
			{
				$strona = 0;
			}
			elseif($strona >= $strona_max)
			{
				$strona = $strona_max;
			}
		}
		else
		{
			$strona = 0;
		}
		$strona_p = $strona*10;
		$strona_k = $strona*10+10;
		if(isset($_POST['imie']) && isset($_POST['nazwisko']))
		{
			$imie = $_POST['imie'];
			$nazwisko = $_POST['nazwisko'];
			$sql = "SELECT * FROM klient WHERE imie = '$imie' AND nazwisko = '$nazwisko' LIMIT '$strona_p', '$strona_k'";	
		}
		elseif(isset($_POST['imie']) && !isset($_POST['nazwisko']))
		{
			$imie = $_POST['imie'];
			$sql = "SELECT * FROM klient WHERE imie = '$imie' LIMIT '$strona_p', '$strona_k'";	
		}
		elseif(!isset($_POST['imie']) && isset($_POST['nazwisko']))
		{
			$nazwisko = $_POST['nazwisko'];
			$sql = "SELECT * FROM klient WHERE imie = '$nazwisko' LIMIT '$strona_p', '$strona_k'";	
		}
		else
		{
			$sql = "SELECT * FROM klient LIMIT $strona_p, $strona_k";	
		}
		echo '<table class="table table-bordered">';
		echo '<tr>';
		echo '<td>Id klienta</td>';
		echo '<td>Imie</td>';
		echo '<td>Nazwisko</td>';
		echo '<td>Mail</td>';
		echo '<td>Płeć</td>';
		echo '<td>Data Urodzenia</td>';
		echo '<td>Klub</td>';
		echo '<td></td>';
		echo '</tr>';
		
		$result = @$connection->query($sql);
		if($result)
		{
			for($i=0; $i < $result->num_rows; $i++)
			{
				$row = $result->fetch_assoc();
				$id_klienta = $row['id_klienta'];
				$imie = $row['imie'];
				$nazwisko = $row['nazwisko'];
				$mail = $row['mail'];
				$plec = $row['plec'];
				$data_urodzenia = $row['data_urodzenia'];
				if(isset($row['id_klubu']))
				{
					$id_klubu = $row['id_klubu'];
					$sql = "SELECT nazwa FROM klub WHERE id_klubu = '$id_klubu'";
					$result2 = @$connection->query($sql);
					if($result2)
					{
						$row2 = $result2->fetch_assoc();
						$klub = $row2['nazwa'];
					}
					else
					{
						$klub = 'błąd';
					}
				}
				else
				{
					$klub = "";
				}
				echo '<tr>';
				echo "<td>$id_klienta</td>";
				echo "<td>$imie</td>";
				echo "<td>$nazwisko</td>";
				echo "<td>$mail</td>";
				echo "<td>$plec</td>";
				echo "<td>$data_urodzenia</td>";
				echo "<td>$klub</td>";
				echo '<td>
						<a href="rozchodniaczki/id_opcji.php?o='.$id_opcji.'&p='.$id_podopcji.'&b='.$id_badania.'" class="btn btn-rss">Wyświetl szczegóły</a>
					 </td>';
				
				echo '</tr>';
			}		
			$result->free_result();
		}
		
		echo '</table>';
		
		echo '<form method="POST" action="panel_admina.php">';
		echo '<input type="hidden" name="strona" value="'.($strona-1).'" />';
		echo '<input value="Poprzednia strona" class="btn btn-rss" type="submit" />';
		echo '</form>';
		
		echo '<form method="POST" action="panel_admina.php">';
		echo '<input type="hidden" name="strona" value="'.($strona+1).'" />';
		echo '<input value="Następna strona" class="btn btn-rss" type="submit" />';
		echo '</form>';
	}
?>