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
		$sql = "SELECT * FROM rast_test WHERE id_klienta = '$id_klienta' ORDER BY data";
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
			
			$pomiar4 = new Dataset();
			$pomiar4->label = "pomiar4";
			$pomiar4_dane = array();
			
			$pomiar5 = new Dataset();
			$pomiar5->label = "pomiar5";
			$pomiar5_dane = array();
			
			$pomiar6 = new Dataset();
			$pomiar6->label = "pomiar6";
			$pomiar6_dane = array();
			
			$pomiar7 = new Dataset();
			$pomiar7->label = "pomiar7";
			$pomiar7_dane = array();
			
			$srednia = new Dataset();
			$srednia->label = "srednia";
			$srednia_dane = array();
			
			$suma_pomiar1 = 0;
			$suma_pomiar2 = 0;
			$suma_pomiar3 = 0;
			$suma_pomiar4 = 0;
			$suma_pomiar5 = 0;
			$suma_pomiar6 = 0;
			$suma_pomiar7 = 0;
			$suma_srednia = 0;

			for($i = 0; $i < $result->num_rows; $i++)
			{
				//Odczytaj wartości z wiersza bazy
				$row = $result->fetch_assoc();
				
				array_push($daty, $row['data']);
				array_push($pomiar1_dane, $row['pomiar1']);
				array_push($pomiar2_dane, $row['pomiar2']);
				array_push($pomiar3_dane, $row['pomiar3']);
				array_push($pomiar4_dane, $row['pomiar4']);
				array_push($pomiar5_dane, $row['pomiar5']);
				array_push($pomiar6_dane, $row['pomiar6']);
				array_push($pomiar7_dane, $row['pomiar7']);
				$srednia_pom = ($row['pomiar1'] + $row['pomiar2'] + $row['pomiar3'] + $row['pomiar4'] + $row['pomiar5'] + $row['pomiar6'] + $row['pomiar7'])/7;
				array_push($srednia_dane, $srednia_pom);
				
				$suma_pomiar1 += $row['pomiar1'];
				$suma_pomiar2 += $row['pomiar2'];
				$suma_pomiar3 += $row['pomiar3'];
				$suma_pomiar4 += $row['pomiar4'];
				$suma_pomiar5 += $row['pomiar5'];
				$suma_pomiar6 += $row['pomiar6'];
				$suma_pomiar7 += $row['pomiar7'];
				$suma_srednia += $srednia_pom;
			}
			$pomiar1->data = $pomiar1_dane;
			$pomiar2->data = $pomiar2_dane;
			$pomiar3->data = $pomiar3_dane;
			
			//JSON do wyświetlenia na wykresie
			$display_type = "wykres_porownawczy";
			$name = "Rast test";
			$date = $daty;
			$chart_type = "line";
			$data_sets = array($pomiar1, $pomiar2, $pomiar3, $pomiar4, $pomiar5, $pomiar6, $pomiar7, $srednia);

			for($j = 0; $j < count($data_sets); $j++)
			{
				$data_sets[$j]->borderColor = 'rgba('.rand(0,255).','.rand(0,255).','.rand(0,255).', 0.7)';
				$data_sets[$j]->fill = false;
			}

			$dane_badania = array($display_type, $name, $date, $chart_type, $data_sets);

			$suma_pomiar1 = round ( $suma_pomiar1 / $result->num_rows , 2 , PHP_ROUND_HALF_UP );
			$suma_pomiar2 = round ( $suma_pomiar2 / $result->num_rows , 2 , PHP_ROUND_HALF_UP );
			$suma_pomiar3 = round ( $suma_pomiar3 / $result->num_rows , 2 , PHP_ROUND_HALF_UP );
			$suma_pomiar4 = round ( $suma_pomiar4 / $result->num_rows , 2 , PHP_ROUND_HALF_UP );
			$suma_pomiar5 = round ( $suma_pomiar5 / $result->num_rows , 2 , PHP_ROUND_HALF_UP );
			$suma_pomiar6 = round ( $suma_pomiar6 / $result->num_rows , 2 , PHP_ROUND_HALF_UP );
			$suma_pomiar7 = round ( $suma_pomiar7 / $result->num_rows , 2 , PHP_ROUND_HALF_UP );
			$suma_srednia = round ( $suma_srednia / $result->num_rows , 2 , PHP_ROUND_HALF_UP );
			
			$result->free_result();
		}
		include("wiek.php");
		
		//pobranie z bazy danych srednich dla danej grupy wiekowej
		$sql = "SELECT AVG(b.pomiar1), AVG(b.pomiar2), AVG(b.pomiar3), AVG(b.pomiar4), AVG(b.pomiar5), AVG(b.pomiar6), AVG(b.pomiar7) FROM rast_test b, klient k WHERE b.id_klienta = k.id_klienta AND k.data_urodzenia BETWEEN '$between_down' AND '$between_up'";

		if($result = @$connection->query($sql))
		{
			$row = $result->fetch_assoc();
			$grupa_pomiar1 = round ($row['AVG(b.pomiar1)'], 2, PHP_ROUND_HALF_UP);
			$grupa_pomiar2 = round ($row['AVG(b.pomiar2)'], 2, PHP_ROUND_HALF_UP);
			$grupa_pomiar3 = round ($row['AVG(b.pomiar3)'], 2, PHP_ROUND_HALF_UP);
			$grupa_pomiar4 = round ($row['AVG(b.pomiar4)'], 2, PHP_ROUND_HALF_UP);
			$grupa_pomiar5 = round ($row['AVG(b.pomiar5)'], 2, PHP_ROUND_HALF_UP);
			$grupa_pomiar6 = round ($row['AVG(b.pomiar6)'], 2, PHP_ROUND_HALF_UP);
			$grupa_pomiar7 = round ($row['AVG(b.pomiar7)'], 2, PHP_ROUND_HALF_UP);
			$grupa_srednia = round (($grupa_pomiar1 + $grupa_pomiar2 + $grupa_pomiar3 + $grupa_pomiar4 + $grupa_pomiar5 + $grupa_pomiar6 + $grupa_pomiar7)/7, 2, PHP_ROUND_HALF_UP);
		}
		$connection->close();
	}
	
	//Canvas wykresu i przycisk powrotny
	echo "<canvas id='RSS_chart'></canvas>";
	
	echo '<h3 class="card-title mt-2">Średnia Twoich badań</h3>';	
	echo "<table class='table table-bordered'>
			<thead class='thead-dark'>
			<tr>
				<th></th>
				<th>Pomiar 1</th>
				<th>Pomiar 2</th>
				<th>Pomiar 3</th>
				<th>Pomiar 4</th>
				<th>Pomiar 5</th>
				<th>Pomiar 6</th>
				<th>Pomiar 7</th>
				<th>Średnia</th>
			</tr>
			</thead>
			<tr>
				<td>Wartości</td>
				<td>".$suma_pomiar1."</td>
				<td>".$suma_pomiar2."</td>
				<td>".$suma_pomiar3."</td>
				<td>".$suma_pomiar4."</td>
				<td>".$suma_pomiar5."</td>
				<td>".$suma_pomiar6."</td>
				<td>".$suma_pomiar7."</td>
				<td>".$suma_srednia."</td>
			</tr>
			</table>";	
			
	echo '<h3 class="card-title mt-2">Średnia w Twojej grupie wiekowej '.$wiadomosc.'</h3>';	
	echo "<table class='table table-bordered'>
			<thead class='thead-dark'>
			<tr>
				<th></th>
				<th>Pomiar 1</th>
				<th>Pomiar 2</th>
				<th>Pomiar 3</th>
				<th>Pomiar 4</th>
				<th>Pomiar 5</th>
				<th>Pomiar 6</th>
				<th>Pomiar 7</th>
				<th>Średnia</th>
			</tr>
			</thead>
			<tr>
				<td>Wartości</td>
				<td>".$grupa_pomiar1."</td>
				<td>".$grupa_pomiar2."</td>
				<td>".$grupa_pomiar3."</td>
				<td>".$grupa_pomiar4."</td>
				<td>".$grupa_pomiar5."</td>
				<td>".$grupa_pomiar6."</td>
				<td>".$grupa_pomiar7."</td>
				<td>".$grupa_srednia."</td>
			</tr>
			</table>";	
?>