<?php
	/*SECURED*/
	if (session_status() == PHP_SESSION_NONE) {
		header('Location: ../../logowanie.php');
	}
			
	require_once "rozchodniaczki/connect.php";
	
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno;
	}
	else
	{	
		//Pobierz potrzebne badanie
		$sql = "SELECT * FROM waga WHERE id_klienta = '$id_klienta' ORDER BY data";
		if($result = @$connection->query($sql))
		{
			$daty = array();
			
			class Dataset{}
			
			$wartosc = new Dataset();
			$wartosc->label = "wartosc";
			$wartosc_dane = array();
			
			$suma_wartosc = 0;
			
			for($i = 0; $i < $result->num_rows; $i++)
			{
				//Odczytaj wartości z wiersza bazy
				$row = $result->fetch_assoc();
				
				array_push($daty, $row['data']);
				array_push($wartosc_dane, $row['wartosc']);	
				
				$suma_wartosc += $row['wartosc'];			
			}
			$wartosc->data = $wartosc_dane;
			
			//JSON do wyświetlenia na wykresie
			$display_type = "wykres_porownawczy";
			$name = "Waga";
			$date = $daty;
			$chart_type = "line";
			$data_sets = array($wartosc);

			for($j = 0; $j < count($data_sets); $j++){
				$data_sets[$j]->borderColor = 'rgba('.rand(0,255).','.rand(0,255).','.rand(0,255).', 0.7)';
				$data_sets[$j]->fill = false;
			}

			$dane_badania = array($display_type, $name, $date, $chart_type, $data_sets);
			
			$suma_wartosc = round($suma_wartosc / $result->num_rows, 2, PHP_ROUND_HALF_UP);
			
			$result->free_result();
		}
		$connection->close();
	}
	
	//Canvas wykresu i przycisk powrotny
	echo '<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h2 class="card-title">Historia wagi</h2>
						<div class="card-text">
							<p>Poniżej znajdziesz historię zmiany twojej wagi na podstawie wprowadzonych rekordów oraz inne przydatne informacje</p>
						</div>
					</div>
					<div class="card-body" style="padding-top:0;">';
					
	echo "<canvas id='RSS_chart'></canvas>";
	echo '<a href="rozchodniaczki/id_opcji.php?o='.$_SESSION['id_opcji'].'&p=11&b=-1" class="btn btn-rss float-right mt-2">Powrót</a>';	
	echo "</div></div></div>";
	
	
	
	echo '<div class="col-lg-6 col-12">
				<div class="card">
					<div class="card-header">
						<h2 class="card-title">Informacje dodatkowe</h2>
					</div>
					<div class="card-body" style="padding-top:0;">';
					
	echo "<table class='table table-bordered'>
			<thead class='thead-dark'>
			<tr>
				<th>Średnia</th>
				<th>Waga</th>
			</tr>
			</thead>
			<tr>
				<td>Wartości</td>
				<td>".$suma_wartosc."</td>
			</tr>
			</table>";	
	echo "</div></div></div>";
	
	echo '<div class="col-lg-6 col-12">
				<div class="card">
					<div class="card-header">
						<h2 class="card-title">Aktualizuj wagę</h2>
					</div>
					<div class="card-body" style="padding-top:0;">';
					
	echo '<form id="waga_form" class="form" method="post" action="rozchodniaczki/zmien_wage.php">
			<div class="form-body">
				<div class="form-group">
					<label for="issueinput2">Wprowadź nową wage [kg]</label></br>
					<input type="number" name="waga" max="170" pattern="[0-9.]+" required />
				</div>
			</div>
		  </form>
		  <a href="#" class="btn btn-rss" onclick="document.getElementById(\'waga_form\').submit()">Zmień wagę</a>';
	echo "</div></div></div></div>";
?>