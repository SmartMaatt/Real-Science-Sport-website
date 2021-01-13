<?php

	/*SECURED*/
	if (session_status() == PHP_SESSION_NONE) {
		header('Location: ../../logowanie.php');
	}
	else{
		if(!isset($_SESSION['id_admina'])){
			header('Location: ../../logowanie.php');
		}
	}

	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	if ($connection->connect_errno == 0)
	{
		if(isset($_POST['id_klubu']))
		{
			$id_klubu = $_POST['id_klubu'];
			
		}
		else
		{
			if(isset($_SESSION['id_badania'])) // odnosi się do id_klubu i probnie nie jest resetowane 
			{
				$id_klubu = $_SESSION['id_badania'];
				//$_SESSION['id_badania'] = -1;
				
			}
			else
			{
				$id_klubu = 0;
				echo "Nie znaleziono klubu o podanym id";
			}
		}
		
		$sql = "SELECT COUNT(id_klienta) as ile FROM klient WHERE id_klubu LIKE '%$id_klubu%'";
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

		$sql = "SELECT * FROM klient WHERE id_klubu LIKE '%$id_klubu%' LIMIT $strona_p, $strona_k";

		echo'<div class="row">
				<div class="col-12">
				  <div class="card">
					<div class="card-header">
					  <h2 class="card-title" id="basic-layout-tooltip">Członkowie klubu</h2>
					  <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
					</div>
					<div class="card-content">
					  <div class="card-body table-responsive pt-0">';

		$result = @$connection->query($sql);
		if($result)
		{
			if($result->num_rows > 0){
				
				echo '<table class="table table-bordered table-admin table-admin-clubs bg-white">';
				echo '<thead class="thead-dark">';
				echo '<tr>';
				echo '<th>Id klienta</th>';
				echo '<th>Imie</th>';
				echo '<th>Nazwisko</th>';
				echo '<th>Mail</th>';
				echo '<th>Płeć</th>';
				echo '<th>Data Urodzenia</th>';
				echo '<th>Nazwa klubu</th>';
				echo '<th></th>';
				echo '</tr>';
				echo '</thred>';
				
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
					echo'
					<td>
					  <span class="dropdown">
						<button id="btnSearchDrop" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info dropdown-toggle dropdown-menu-right"><i class="ft-settings"></i></button>
						<span aria-labelledby="btnSearchDrop" class="dropdown-menu mt-1 dropdown-menu-right" x-placement="top-end" style="position: absolute; transform: translate3d(-138px, -119px, 0px); top: 0px; left: 0px; will-change: transform;">
						  <a href="rozchodniaczki/admin/podglad_admina.php?id_klienta='.$id_klienta.'&imie='.$imie.'&nazwisko='.$nazwisko.'" class="dropdown-item"><i class="ft-edit-2"></i> Szczegóły</a>
						  <a href="rozchodniaczki/daddy_im_shy.php?m=0&msg=Czy na pewno chcesz usunąć klienta?&p='.$id_klienta.'" class="dropdown-item"><i class="ft-trash-2"></i> Usuń</a>
						  <a href="rozchodniaczki/daddy_im_shy.php?m=2&msg=Wybierz klub, który chcesz przypisać zawodnikowi&p='.$id_klienta.'" class="dropdown-item"><i class="fas fa-shield-alt"></i> Zmień klub</a>
						</span>
					  </span>
					</td>';
					echo '</tr>';
				}
					
				echo '</table>';
			
				echo '<form class="admin-form" method="POST" action="panel_admina.php">';
				echo '<input type="hidden" name="strona" value="'.($strona-1).'" />';
				echo '<input type="hidden" name="id_klubu" value="'.$id_klubu.'" />';
				echo '<input value="Poprzednia strona" class="btn btn-info" type="submit" />';
				echo '</form>';
				
				echo '<form class="admin-form" method="POST" action="panel_admina.php">';
				echo '<input type="hidden" name="strona" value="'.($strona+1).'" />';
				echo '<input type="hidden" name="id_klubu" value="'.$id_klubu.'" />';
				echo '<input value="Następna strona" class="btn btn-info" type="submit" />';
				echo '</form>';
				
				//echo "Strona: ".($strona+1)." / ".($strona_max+1)."";
			}
			else {
				echo '<h1 class="no_data_msg">Brak zarejestrowanych danych klubów!</h1>';
			}
			$result->free_result();
		}
		$connection->close();
	}
	echo '</div></div></div></div></div>';
?>