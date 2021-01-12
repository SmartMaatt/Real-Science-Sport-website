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
			$pomiar4->data = $pomiar4_dane;
			$pomiar5->data = $pomiar5_dane;
			$pomiar6->data = $pomiar6_dane;
			$pomiar7->data = $pomiar7_dane;
			$srednia->data = $srednia_dane;
			
			//JSON do wyświetlenia na wykresie
			$display_type = "wykres_porownawczy";
			$name = "Rast test";
			$date = $daty;
			$chart_type = "line";
			$data_sets = array($pomiar1, $pomiar2, $pomiar3, $pomiar4, $pomiar5, $pomiar6, $pomiar7, $srednia);

			for($j = 0; $j < count($data_sets); $j++)
			{
				$data_sets[$j]->borderColor = 'rgba(247, 172, 37, 0.7)';
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
		$connection->close();
	}
	
	//Canvas wykresu i przycisk powrotny
	echo "<canvas id='RSS_chart'></canvas>";
	echo "Średnia pomiaru 1 : ".$suma_pomiar1."</br>"; 
	echo "Średnia pomiaru 2: ".$suma_pomiar2."</br>"; 
	echo "Średnia pomiaru 3: ".$suma_pomiar3."</br>"; 
	echo "Średnia pomiaru 4: ".$suma_pomiar4."</br>"; 
	echo "Średnia pomiaru 5: ".$suma_pomiar5."</br>"; 
	echo "Średnia pomiaru 6: ".$suma_pomiar6."</br>"; 
	echo "Średnia pomiaru 6: ".$suma_pomiar7."</br>"; 
	echo "Średnia średnich: ".$suma_srednia;  
?>