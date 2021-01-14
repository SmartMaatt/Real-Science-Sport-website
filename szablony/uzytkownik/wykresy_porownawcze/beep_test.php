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
		$sql = "SELECT * FROM beep_test WHERE id_klienta = '$id_klienta' ORDER BY data";
		if($result = @$connection->query($sql))
		{
			$daty = array();
			
			class Dataset{}
			
			$level = new Dataset();
			$level->label = "level";
			$level_dane = array();
			
			$hr_max = new Dataset();
			$hr_max->label = "hr_max";
			$hr_max_dane = array();
			
			$suma_level = 0;
			$suma_hr_max = 0;

			for($i = 0; $i < $result->num_rows; $i++)
			{
				//Odczytaj wartości z wiersza bazy
				$row = $result->fetch_assoc();
				
				array_push($daty, $row['data']);
				array_push($level_dane, $row['level']);
				array_push($hr_max_dane, $row['hr_max']);
				
				$suma_level += $row['level'];
				$suma_hr_max += $row['hr_max'];
			}
			$level->data = $level_dane;
			$hr_max->data = $hr_max_dane;
			
			//JSON do wyświetlenia na wykresie
			$display_type = "wykres_porownawczy";
			$name = "Beep test";
			$date = $daty;
			$chart_type = "line";
			$data_sets = array($level, $hr_max);

			for($j = 0; $j < count($data_sets); $j++)
			{
				$data_sets[$j]->borderColor = 'rgba('.rand(0,255).','.rand(0,255).','.rand(0,255).', 0.7)';
				$data_sets[$j]->fill = false;
			}

			$dane_badania = array($display_type, $name, $date, $chart_type, $data_sets);

			$suma_level = round ( $suma_level / $result->num_rows , 2 , PHP_ROUND_HALF_UP );
			$suma_hr_max = round ( $suma_hr_max / $result->num_rows , 2 , PHP_ROUND_HALF_UP );
			
			$result->free_result();
		}
		//stworzenie danych dla grupy wiekowej
		include("wiek.php");
		
		//pobranie z bazy danych srednich dla danej grupy wiekowej
		$sql = "SELECT AVG(b.level), AVG(b.hr_max) FROM beep_test b, klient k WHERE b.id_klienta = k.id_klienta AND k.data_urodzenia BETWEEN '$between_down' AND '$between_up'";
		if($result = @$connection->query($sql))
		{
			$row = $result->fetch_assoc();
			$grupa_level = round ($row['AVG(b.level)'], 2, PHP_ROUND_HALF_UP);
			$grupa_hr_max = round ($row['AVG(b.hr_max)'], 2, PHP_ROUND_HALF_UP);
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
				<th>Level</th>
				<th>Hr max</th>
			</tr>
			</thead>
			<tr>
				<td>Wartości</td>
				<td>".$suma_level."</td>
				<td>".$suma_hr_max."</td>
			</tr>
			</table>";	
			
	echo '<h3 class="card-title mt-2">Średnia w Twojej grupie wiekowej '.$wiadomosc.'</h3>';	
	echo "<table class='table table-bordered'>
			<thead class='thead-dark'>
			<tr>
				<th></th>
				<th>Level</th>
				<th>Hr max</th>
			</tr>
			</thead>
			<tr>
				<td>Wartości</td>
				<td>".$grupa_level."</td>
				<td>".$grupa_hr_max."</td>
			</tr>
			</table>";		
?>