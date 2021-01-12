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

			for($i = 0; $i < $result->num_rows; $i++)
			{
				//Odczytaj wartości z wiersza bazy
				$row = $result->fetch_assoc();
				
				array_push($daty, $row['data']);
				array_push($level_dane, $row['level']);
				array_push($hr_max_dane, $row['hr_max']);				
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
				$data_sets[$j]->borderColor = 'rgba(247, 172, 37, 0.7)';
				$data_sets[$j]->fill = false;
			}

			$dane_badania = array($display_type, $name, $date, $chart_type, $data_sets);

			
			$result->free_result();
		}
		$connection->close();
	}
	
	//Canvas wykresu i przycisk powrotny
	echo "<canvas id='RSS_chart'></canvas>";
?>