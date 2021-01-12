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
		$sql = "SELECT wzrostomierz.data, wzrost.wartosc, wzrostomierz.wzrost_tulowia FROM wzrostomierz INNER JOIN wzrost ON wzrostomierz.data=wzrost.data ORDER BY wzrostomierz.data";
		if($result = @$connection->query($sql))
		{
			$daty = array();
			
			class Dataset{}
			
			$wzrost = new Dataset();
			$wzrost->label = "wzrost";
			$wzrost_dane = array();
			
			$wzrost_tulowia = new Dataset();
			$wzrost_tulowia->label = "wzrost_tulowia";
			$wzrost_tulowia_dane = array();
			
			for($i = 0; $i < $result->num_rows; $i++)
			{
				//Odczytaj wartości z wiersza bazy
				$row = $result->fetch_assoc();
				
				array_push($daty, $row['data']);
				array_push($wzrost_dane, $row['wartosc']);	
				array_push($wzrost_tulowia_dane, $row['wzrost_tulowia']);				
			}
			$wzrost->data = $wzrost_dane;
			$wzrost_tulowia->data = $wzrost_tulowia_dane;
			
			//JSON do wyświetlenia na wykresie
			$display_type = "wykres_porownawczy";
			$name = "Wzrostomierz";
			$date = $daty;
			$chart_type = "line";
			$data_sets = array($wzrost);
			$data_sets = array($wzrost_tulowia);

			for($j = 0; $j < count($data_sets); $j++){
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