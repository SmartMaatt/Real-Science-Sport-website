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
	
	echo '<div class="row">
            <div class="col-lg-3 col-md-12">
              <div class="card">
                <div class="card-header">
                  <h2 class="card-title" id="basic-layout-tooltip">Wyszukaj klub</h2>
                  <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                </div>
                <div class="card-content">
                  <div class="card-body pt-0">
				';

		
	// Pokaz kluby
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	if ($connection->connect_errno == 0)
	{
		if(isset($_POST['nazwa']))
		{
			$nazwa_post = $_POST['nazwa'];
			$sql = "SELECT COUNT(id_klubu) as ile FROM klub WHERE nazwa LIKE '%$nazwa_post%'";
		}
		else
		{
			$nazwa_post = "";
			$sql = "SELECT COUNT(id_klubu) as ile FROM klub";
		}

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
			$sql = "SELECT * FROM klub WHERE nazwa LIKE '%$nazwa_post%' LIMIT $strona_p, $strona_k";	
		}
		else
		{
			$sql = "SELECT * FROM klub LIMIT $strona_p, $strona_k";	
		}
			
		echo'
			<form class="form" method="POST" action="panel_admina.php">
					<div class="form-body form-admin">
						<div class="form-group">
						  <label for="issueinput1">Nazwa klubu bądź jej fragment</label>
						  <input type="text" class="form-control" placeholder="Nazwa klubu" name="nazwa" value="'.$nazwa_post.'">
						</div>
						<input type="submit" value="Znajdź" class="btn btn-info">
					</div>
				</form>
				</div></div>';
		
		echo'<hr class="mt-0 mb-0"/>
				<div class="card-header">
                  <h2 class="card-title" id="basic-layout-tooltip">Dodaj klub</h2>
                  <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                </div>
                <div class="card-content">
                  <div class="card-body pt-0">';

		
		echo'
			<form class="form" method="POST" action="rozchodniaczki/admin/dodaj_klub.php">
				<div class="form-body form-admin">
					<div class="form-group">
					  <label for="issueinput1">Nazwa klubu</label>
					  <input type="text" class="form-control" placeholder="Nazwa klubu" name="nazwa_klubu">
					</div>
					<input type="submit" value="Dodaj" class="btn btn-info">
				</div>
			</form>
			</div></div></div></div>';	

		echo '<div class="col-lg-9 col-md-12">';
		echo '<div class="card">';
		echo '<div class="card-content">';
		echo '<div class="card-body table-responsive">';
			
		$result = @$connection->query($sql);
		if($result)
		{
			if($result->num_rows > 0){
				echo '<table class="table table-bordered table-admin table-admin-clubs bg-white">';
				echo '<thead class="thead-dark">';
				echo '<tr>';
				echo '<th>#</th>';
				echo '<th>Nazwa</th>';
				echo '<th></th>';
				echo '</tr>';
				echo '</thred>';
				
				//Pętla wyliczeniowa rzędów tabeli klubów
				for($i = 0; $i < $result->num_rows; $i++)
				{
					$row = $result->fetch_assoc();
					$id_klubu = $row['id_klubu'];
					$nazwa = $row['nazwa'];
					
					echo '<tr>';
					echo "<td>$id_klubu</td>";
					echo "<td>$nazwa</td>";
					echo'
					<td>
					  <span class="dropdown">
						<button id="btnSearchDrop" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info dropdown-toggle dropdown-menu-right"><i class="ft-settings"></i></button>
						<span aria-labelledby="btnSearchDrop" class="dropdown-menu mt-1 dropdown-menu-right" x-placement="top-end" style="position: absolute; transform: translate3d(-138px, -119px, 0px); top: 0px; left: 0px; will-change: transform;">
						  <a href="rozchodniaczki/id_opcji.php?o=102&p=1&b='.$id_klubu.'" class="dropdown-item"><i class="ft-edit-2"></i> Szczegóły</a>
						  <a href="rozchodniaczki/daddy_im_shy.php?m=1&msg=Czy na pewno chcesz usunąć klub?&p='.$id_klubu.'" class="dropdown-item"><i class="ft-trash-2"></i> Usuń</a>
						</span>
					  </span>
					</td>';
					echo '</tr>';
					
				}
				echo '</table>';
			}
			else {
				echo '<h1 class="no_data_msg">Brak zarejestrowanych danych klubów!</h1>';
			}
			$result->free_result();
		}
		
		if(isset($_POST['nazwa']))
		{
			echo '<form class="admin-form" method="POST" action="panel_admina.php">
					<input type="hidden" name="nazwa" value="'.$nazwa_post.'" />
					<input type="hidden" name="strona" value="'.($strona-1).'" />
					<input value="Poprzednia strona" class="btn btn-info" type="submit" />
				</form>';
		
			echo '<form class="admin-form" method="POST" action="panel_admina.php">
					<input type="hidden" name="nazwa" value="'.$nazwa_post.'" />
					<input type="hidden" name="strona" value="'.($strona+1).'" />
					<input value="Następna strona" class="btn btn-info" type="submit" />
				</form>';
		}
		else
		{
			echo '<form class="admin-form" method="POST" action="panel_admina.php">
					<input type="hidden" name="strona" value="'.($strona-1).'" />
					<input value="Poprzednia strona" class="btn btn-info" type="submit" />
				</form>';
			
			echo '<form class="admin-form" method="POST" action="panel_admina.php">
					<input type="hidden" name="strona" value="'.($strona+1).'" />
					<input value="Następna strona" class="btn btn-info" type="submit" />
				</form>';
		}
		$connection->close();
	}

		echo '</div></div></div></div></div>';
?>