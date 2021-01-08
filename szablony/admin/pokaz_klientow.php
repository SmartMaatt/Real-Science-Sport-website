<?php
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	if ($connection->connect_errno == 0)
	{
		if(isset($_POST['imie']) && isset($_POST['nazwisko']))
		{
			$imie_post = $_POST['imie'];
			$nazwisko_post = $_POST['nazwisko'];
			if($imie_post != "" && $nazwisko_post != "")
				$sql = "SELECT COUNT(id_klienta) as ile FROM klient WHERE imie = '$imie_post' AND nazwisko = '$nazwisko_post'";
			elseif($imie_post != "")
				$sql = "SELECT COUNT(id_klienta) as ile FROM klient WHERE imie = '$imie_post'";
			elseif($nazwisko_post != "")
				$sql = "SELECT COUNT(id_klienta) as ile FROM klient WHERE nazwisko = '$nazwisko_post'";
		}
		else
		{
			$sql = "SELECT COUNT(id_klienta) as ile FROM klient";
		}
		$result = @$connection->query($sql);
		if($result)
		{
			$row = $result->fetch_assoc();
			$strona_max = (int)($row['ile']/10);
			if($row['ile']%10 == 0 && $strona_max != 0)
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
			if($imie_post != "" && $nazwisko_post != "")
				$sql = "SELECT * FROM klient WHERE imie = '$imie_post' AND nazwisko = '$nazwisko_post' LIMIT $strona_p, $strona_k";	
			elseif($imie_post != "")
				$sql = "SELECT * FROM klient WHERE imie = '$imie_post' LIMIT $strona_p, $strona_k";
			elseif($nazwisko_post != "")
				$sql = "SELECT * FROM klient WHERE nazwisko = '$nazwisko_post' LIMIT $strona_p, $strona_k";
		}
		else
		{
			$sql = "SELECT * FROM klient LIMIT $strona_p, $strona_k";	
		}
		
		echo'Znajdź klienta</br>
			<form method="POST" action="panel_admina.php">
			  imie <input type="text" name="imie"></br>
			  nazwisko <input type="text" name="nazwisko"></br>
			  <input type="submit" value="Znajdź" class="btn btn-rss">
			</form>';
		
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
		
		if(isset($_POST['imie']) && isset($_POST['nazwisko']))
		{
			echo '<form method="POST" action="panel_admina.php">
					<input type="hidden" name="imie" value="'.$imie_post.'" />
					<input type="hidden" name="nazwisko" value="'.$nazwisko_post.'" />
					<input type="hidden" name="strona" value="'.($strona-1).'" />
					<input value="Poprzednia strona" class="btn btn-rss" type="submit" />
				</form>';
			
			echo '<form method="POST" action="panel_admina.php">
					<input type="hidden" name="imie" value="'.$imie_post.'" />
					<input type="hidden" name="nazwisko" value="'.$nazwisko_post.'" />
					<input type="hidden" name="strona" value="'.($strona+1).'" />
					<input value="Następna strona" class="btn btn-rss" type="submit" />
				</form>';
		}
		else
		{
			echo '<form method="POST" action="panel_admina.php">
					<input type="hidden" name="strona" value="'.($strona-1).'" />
					<input value="Poprzednia strona" class="btn btn-rss" type="submit" />
				</form>';
			
			echo '<form method="POST" action="panel_admina.php">
					<input type="hidden" name="strona" value="'.($strona+1).'" />
					<input value="Następna strona" class="btn btn-rss" type="submit" />
				</form>';
		}
	}
?>