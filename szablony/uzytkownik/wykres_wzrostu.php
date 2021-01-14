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
		$sql = "SELECT * FROM wzrost WHERE id_klienta = '$id_klienta' ORDER BY data";
		if($result = @$connection->query($sql))
		{
			$daty = array();
			
			class Dataset{}
			
			$wartosc = new Dataset();
			$wartosc->label = "wartosc";
			$wartosc_dane = array();
			
			$suma_wzrost = 0;
			
			for($i = 0; $i < $result->num_rows; $i++)
			{
				//Odczytaj wartości z wiersza bazy
				$row = $result->fetch_assoc();
				
				array_push($daty, $row['data']);
				array_push($wartosc_dane, $row['wartosc']);	
				
				$suma_wartosc += $row['wartosc'];			
			}
			$wartosc->data = $wzrost_dane;
			
			//JSON do wyświetlenia na wykresie
			$display_type = "wykres_porownawczy";
			$name = "Wzrost";
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
	echo "<canvas id='RSS_chart'></canvas>";
	
	echo "<table class='table table-bordered mt-3'>
			<thead class='thead-dark'>
			<tr>
				<th>Średnia</th>
				<th>Wzrostu</th>
			</tr>
			</thead>
			<tr>
				<td>Wartości</td>
				<td>".$wartosc."</td>
			</tr>
			</table>";	
?>