<?php

		
	// Pokaz kluby
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	if ($connection->connect_errno == 0)
	{
		$sql = "SELECT COUNT(id_klubu) as ile FROM klub";
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
		if(isset($_POST['nazwa']))
		{
			$nazwa = $_POST['nazwa'];
			$sql = "SELECT * FROM klub WHERE nazwa = '$nazwa' LIMIT $strona_p, $strona_k";	
		}
		else
		{
			$sql = "SELECT * FROM klub LIMIT $strona_p, $strona_k";	
		}
		echo '<table class="table table-bordered">';
		echo '<tr>';
		echo '<td>Id klubu</td>';
		echo '<td>Nazwa</td>';
		echo '<td></td>';
		echo '</tr>';
		
		$result = @$connection->query($sql);
		if($result)
		{
			for($i=0; $i < $result->num_rows; $i++)
			{
				$row = $result->fetch_assoc();
				$id_klubu = $row['id_klubu'];
				$nazwa = $row['nazwa'];
				
				echo '<tr>';
				echo "<td>$id_klubu</td>";
				echo "<td>$nazwa</td>";
				echo '<td>
						<a href="rozchodniaczki/id_opcji.php?o=102&p=1&b='.$id_klubu.'" class="btn btn-rss">Wyświetl szczegóły</a>
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
	
	
		//Dodaj klub
		echo'Dodaj klub</br>
			<form action="rozchodniaczki/dodaj_klub.php" method="post">
			  Nazwa klubu</br>
			  <input type="text" name="nazwa_klubu"></br>
			  <input type="submit" value="Dodaj" class="btn btn-rss">
			</form>';
		
		
?>