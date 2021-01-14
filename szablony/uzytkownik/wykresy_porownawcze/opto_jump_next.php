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
		$sql = "SELECT * FROM opto_jump_next WHERE id_klienta = '$id_klienta' ORDER BY data";
		if($result = @$connection->query($sql))
		{
			$daty = array();
			
			class Dataset{}
			
			$minimum = new Dataset();
			$minimum->label = "minimum";
			$minimum_dane = array();
			
			$maksimum = new Dataset();
			$maksimum->label = "maksimum";
			$maksimum_dane = array();
				
			$srednio = new Dataset();
			$srednio->label = "srednio";
			$srednio_dane = array();
			
			$suma_minimum = 0;
			$suma_maksimum = 0;
			$suma_srednio = 0;

			for($i = 0; $i < $result->num_rows; $i++)
			{
				//Odczytaj wartości z wiersza bazy
				$row = $result->fetch_assoc();
				
				array_push($daty, $row['data']);
				array_push($minimum_dane, $row['minimum']);
				array_push($maksimum_dane, $row['maksimum']);
				array_push($srednio_dane, $row['srednio']);
				
				$suma_minimum += $row['minimum'];
				$suma_maksimum += $row['maksimum'];
				$suma_srednio += $row['srednio'];			
			}
			$minimum->data = $minimum_dane;
			$maksimum->data = $maksimum_dane;
			$srednio->data = $srednio_dane;
			
			//JSON do wyświetlenia na wykresie
			$display_type = "wykres_porownawczy";
			$name = "Biofeedback EEG";
			$date = $daty;
			$chart_type = "line";
			$data_sets = array($minimum, $maksimum, $srednio);

			for($j = 0; $j < count($data_sets); $j++)
			{
				$data_sets[$j]->borderColor = 'rgba('.rand(0,255).','.rand(0,255).','.rand(0,255).', 0.7)';
				$data_sets[$j]->fill = false;
			}

			$dane_badania = array($display_type, $name, $date, $chart_type, $data_sets);

			$suma_minimum = round ( $suma_minimum / $result->num_rows , 2 , PHP_ROUND_HALF_UP );
			$suma_maksimum = round ( $suma_maksimum / $result->num_rows , 2 , PHP_ROUND_HALF_UP );
			$suma_srednio = round ( $suma_srednio / $result->num_rows , 2 , PHP_ROUND_HALF_UP );
			
			$result->free_result();
		}
		//stworzenie danych dla grupy wiekowej
		include("wiek.php");
		
		//pobranie z bazy danych srednich dla danej grupy wiekowej
		$sql = "SELECT AVG(b.minimum), AVG(b.maksimum), AVG(b.srednio) FROM opto_jump_next b, klient k WHERE b.id_klienta = k.id_klienta AND k.data_urodzenia BETWEEN '$between_down' AND '$between_up'";

		if($result = @$connection->query($sql))
		{
			$row = $result->fetch_assoc();
			$grupa_minimum = round ($row['AVG(b.minimum)'], 2, PHP_ROUND_HALF_UP);
			$grupa_maksimum = round ($row['AVG(b.maksimum)'], 2, PHP_ROUND_HALF_UP);
			$grupa_srednio = round ($row['AVG(b.srednio)'], 2, PHP_ROUND_HALF_UP);
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
				<th>Minimum</th>
				<th>Maksimum</th>
				<th>Średnio</th>
			</tr>
			</thead>
			<tr>
				<td>Wartości</td>
				<td>".$suma_minimum."</td>
				<td>".$suma_maksimum."</td>
				<td>".$suma_srednio."</td>
			</tr>
			</table>";

	echo '<h3 class="card-title mt-2">Średnia w Twojej grupie wiekowej '.$wiadomosc.'</h3>';	
	echo "<table class='table table-bordered'>
			<thead class='thead-dark'>
			<tr>
				<th></th>
				<th>Minimum</th>
				<th>Maksimum</th>
				<th>Średnio</th>
			</tr>
			</thead>
			<tr>
				<td>Wartości</td>
				<td>".$grupa_minimum."</td>
				<td>".$grupa_maksimum."</td>
				<td>".$grupa_srednio."</td>
			</tr>
			</table>";
?>