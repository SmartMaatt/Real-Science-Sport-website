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
		$sql = "SELECT * FROM analizator_kwasu_mlekowego WHERE id_klienta = '$id_klienta' ORDER BY data";
		if($result = @$connection->query($sql))
		{
			$daty = array();
			
			class Dataset{}
			
			$stezenie = new Dataset();
			$stezenie->label = "stezenie";
			$stezenie_dane = array();
			
			$suma_stezenie = 0;
			
			for($i = 0; $i < $result->num_rows; $i++)
			{
				//Odczytaj wartości z wiersza bazy
				$row = $result->fetch_assoc();
				
				array_push($daty, $row['data']);
				array_push($stezenie_dane, $row['stezenie']);
				
				$suma_stezenie += $row['stezenie'];
				
			}
			$stezenie->data = $stezenie_dane;
			
			//JSON do wyświetlenia na wykresie
			$display_type = "wykres_porownawczy";
			$name = "Analizator kwasu mlekowego";
			$date = $daty;
			$chart_type = "line";
			$data_sets = array($stezenie);

			for($j = 0; $j < count($data_sets); $j++){
				$data_sets[$j]->borderColor = 'rgba('.rand(0,255).','.rand(0,255).','.rand(0,255).', 0.7)';
				$data_sets[$j]->fill = false;
			}

			$dane_badania = array($display_type, $name, $date, $chart_type, $data_sets);

			$suma_stezenie = round ( $suma_stezenie / $result->num_rows , 2 , PHP_ROUND_HALF_UP );
			
			
			$result->free_result();
		}
		//stworzenie danych dla grupy wiekowej
		include("wiek.php");
		
		//pobranie z bazy danych srednich dla danej grupy wiekowej
		$sql = "SELECT AVG(b.stezenie) FROM analizator_kwasu_mlekowego b, klient k WHERE b.id_klienta = k.id_klienta AND k.data_urodzenia BETWEEN '$between_down' AND '$between_up'";

		if($result = @$connection->query($sql))
		{
			$row = $result->fetch_assoc();
			$grupa_stezenie = round ($row['AVG(b.stezenie)'], 2, PHP_ROUND_HALF_UP);
		}
		$connection->close();
	}
	
	//Canvas wykresu i przycisk powrotny
	echo '<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
					<h4 class="card-title">Porównanie badań</h4>
						<div class="card-text">
							<p>Wykres zawiera zmianę wartości wyników badań przedstawionych w powyższej tabeli.</p>
						</div>
					</div>
					<div style="padding-top:0;" class="card-body">';
	echo "<canvas id='RSS_chart'></canvas>";
	echo '</div></div></div>';
	
	
	echo '<div class="col-12">
				<div class="card">
					<div class="card-header">
					<h4 class="card-title">Informacje dodatkowe</h4>
					</div>
					<div style="padding-top:0;" class="card-body">';
	
	echo '<hr><h3 class="card-title mt-2">Średnia Twoich badań</h3>';	
	echo "<table class='table table-bordered'>
			<thead class='thead-dark'>
			<tr>
				<th></th>
				<th>Stężenie</th>
			</tr>
			</thead>
			<tr>
				<td>Wartości</td>
				<td>".$suma_stezenie."</td>
			</tr>
			</table>";
			
	echo '<hr><h3 class="card-title mt-2">Średnia w Twojej grupie wiekowej '.$wiadomosc.'</h3>';	
	echo "<table class='table table-bordered'>
			<thead class='thead-dark'>
			<tr>
				<th></th>
				<th>Stężenie</th>
			</tr>
			</thead>
			<tr>
				<td>Wartości</td>
				<td>".$suma_stezenie."</td>
			</tr>
			</table>";
	echo '					
				</div>
			</div>
		</div>
	</div>';
?>