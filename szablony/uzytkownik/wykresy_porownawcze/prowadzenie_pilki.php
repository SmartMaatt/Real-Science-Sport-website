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
		$sql = "SELECT (pomiar1_1 + pomiar2_1 + pomiar3_1)/3 AS pomiar1, (pomiar1_2 + pomiar2_2 + pomiar3_2)/3 AS pomiar2, (pomiar1_3 + pomiar2_3 + pomiar3_3)/3 AS pomiar3, data FROM prowadzenie_pilki WHERE id_klienta = '$id_klienta' ORDER BY data";
		if($result = @$connection->query($sql))
		{
			$daty = array();
			
			class Dataset{}
			
			$pomiar1 = new Dataset();
			$pomiar1->label = "pomiar1";
			$pomiar1_dane = array();
			
			$pomiar2 = new Dataset();
			$pomiar2->label = "pomiar2";
			$pomiar2_dane = array();
			
			$pomiar3 = new Dataset();
			$pomiar3->label = "pomiar3";
			$pomiar3_dane = array();
			
			$suma_pomiar1 = 0;
			$suma_pomiar2 = 0;
			$suma_pomiar3 = 0;

			for($i = 0; $i < $result->num_rows; $i++)
			{
				//Odczytaj wartości z wiersza bazy
				$row = $result->fetch_assoc();
				
				array_push($daty, $row['data']);
				array_push($pomiar1_dane, $row['pomiar1']);
				array_push($pomiar2_dane, $row['pomiar2']);
				array_push($pomiar3_dane, $row['pomiar3']);
				
				$suma_pomiar1 += $row['pomiar1'];
				$suma_pomiar2 += $row['pomiar2'];
				$suma_pomiar3 += $row['pomiar3'];
			}
			$pomiar1->data = $pomiar1_dane;
			$pomiar2->data = $pomiar2_dane;
			$pomiar3->data = $pomiar3_dane;

			
			//JSON do wyświetlenia na wykresie
			$display_type = "wykres_porownawczy";
			$name = "Prowadzenie pilki";
			$date = $daty;
			$chart_type = "line";
			$data_sets = array($pomiar1, $pomiar2, $pomiar3);

			for($j = 0; $j < count($data_sets); $j++)
			{
				$data_sets[$j]->borderColor = 'rgba('.rand(0,255).','.rand(0,255).','.rand(0,255).', 0.7)';
				$data_sets[$j]->fill = false;
			}

			$dane_badania = array($display_type, $name, $date, $chart_type, $data_sets);

			$suma_pomiar1 = round ($suma_pomiar1 / $result->num_rows, 2 , PHP_ROUND_HALF_UP);
			$suma_pomiar2 = round ($suma_pomiar2 / $result->num_rows, 2 , PHP_ROUND_HALF_UP);
			$suma_pomiar3 = round ($suma_pomiar3 / $result->num_rows, 2 , PHP_ROUND_HALF_UP);
			
			$result->free_result();
		}
		include("wiek.php");
		
		//pobranie z bazy danych srednich dla danej grupy wiekowej
		$sql = "SELECT (AVG(b.pomiar1_1) + AVG(b.pomiar2_1) + AVG(b.pomiar3_1))/3 as pomiar1, (AVG(b.pomiar1_2) + AVG(b.pomiar2_2) + AVG(b.pomiar3_2))/3 as pomiar2, (AVG(b.pomiar1_3) + AVG(b.pomiar2_3) + AVG(b.pomiar3_3))/3 as pomiar3 FROM prowadzenie_pilki b, klient k WHERE b.id_klienta = k.id_klienta AND k.data_urodzenia BETWEEN '$between_down' AND '$between_up'";
		if($result = @$connection->query($sql))
		{
			$row = $result->fetch_assoc();
			$grupa_pomiar1 = round ($row['pomiar1'], 2, PHP_ROUND_HALF_UP);
			$grupa_pomiar2 = round ($row['pomiar2'], 2, PHP_ROUND_HALF_UP);
			$grupa_pomiar3 = round ($row['pomiar3'], 2, PHP_ROUND_HALF_UP);
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
				<th>Pomiar 1</th>
				<th>Pomiar 2</th>
				<th>Pomiar 3</th>
			</tr>
			</thead>
			<tr>
				<td>Wartości</td>
				<td>".$suma_pomiar1."</td>
				<td>".$suma_pomiar2."</td>
				<td>".$suma_pomiar3."</td>
			</tr>
			</table>";	
			
	echo '<hr><h3 class="card-title mt-2">Średnia w Twojej grupie wiekowej '.$wiadomosc.'</h3>';	
	echo "<table class='table table-bordered'>
			<thead class='thead-dark'>
			<tr>
				<th></th>
				<th>Pomiar 1</th>
				<th>Pomiar 2</th>
				<th>Pomiar 3</th>
			</tr>
			</thead>
			<tr>
				<td>Wartości</td>
				<td>".$grupa_pomiar1."</td>
				<td>".$grupa_pomiar2."</td>
				<td>".$grupa_pomiar3."</td>

			</tr>
			</table>";
	
	echo '</div></div></div></div>';
?>