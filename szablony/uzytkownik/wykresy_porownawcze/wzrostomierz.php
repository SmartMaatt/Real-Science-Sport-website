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
		$sql = "SELECT wrz.data, wrz.wzrost_tulowia, wrz.stopien_dojrzalosci, wrz.PHV, wt.wartosc AS wzrost, wa.wartosc AS waga FROM wzrostomierz wrz, wzrost wt, waga wa WHERE wrz.id_klienta = '$id_klienta' AND wt.id_klienta = '$id_klienta' AND wa.id_klienta = '$id_klienta' AND wrz.data = wt.data AND wrz.data = wa.data ORDER BY wrz.data";
		if($result = @$connection->query($sql))
		{
			$daty = array();
			
			class Dataset{}
			
			$wzrost = new Dataset();
			$wzrost->label = "wzrost";
			$wzrost_dane = array();
			
			$waga = new Dataset();
			$waga->label = "waga";
			$waga_dane = array();
			
			$wzrost_tulowia = new Dataset();
			$wzrost_tulowia->label = "wzrost_tulowia";
			$wzrost_tulowia_dane = array();
			
			$stopien_dojrzalosci = new Dataset();
			$stopien_dojrzalosci->label = "stopien_dojrzalosci";
			$stopien_dojrzalosci_dane = array();
			
			$PHV = new Dataset();
			$PHV->label = "PHV";
			$PHV_dane = array();
			
			$suma_wzrost = 0;
			$suma_waga = 0;
			$suma_wzrost_tulowia = 0;
			$suma_stopien_dojrzalosci = 0;
			$suma_PHV = 0;
			
			for($i = 0; $i < $result->num_rows; $i++)
			{
				//Odczytaj wartości z wiersza bazy
				$row = $result->fetch_assoc();
				
				array_push($daty, $row['data']);
				array_push($wzrost_dane, $row['wzrost']);
				array_push($wzrost_dane, $row['waga']);				
				array_push($wzrost_tulowia_dane, $row['wzrost_tulowia']);
				array_push($stopien_dojrzalosci_dane, $row['stopien_dojrzalosci']);	
				array_push($PHV_dane, $row['PHV']);
				
				$suma_wzrost += $row['wzrost'];
				$suma_waga += $row['waga'];
				$suma_wzrost_tulowia += $row['wzrost_tulowia'];
				$suma_stopien_dojrzalosci += $row['stopien_dojrzalosci'];
				$suma_PHV +=$row['PHV'];				
			}
			$wzrost->data = $wzrost_dane;
			$waga->data = $waga_dane;
			$wzrost_tulowia->data = $wzrost_tulowia_dane;
			$stopien_dojrzalosci->data = $stopien_dojrzalosci_dane;
			$PHV->data = $PHV_dane;
			
			//JSON do wyświetlenia na wykresie
			$display_type = "wykres_porownawczy";
			$name = "Wzrostomierz";
			$date = $daty;
			$chart_type = "line";
			$data_sets = array($wzrost, $waga, $wzrost_tulowia, $stopien_dojrzalosci, $PHV);

			for($j = 0; $j < count($data_sets); $j++){
				$data_sets[$j]->borderColor = 'rgba('.rand(0,255).','.rand(0,255).','.rand(0,255).', 0.7)';
				$data_sets[$j]->fill = false;
			}

			$dane_badania = array($display_type, $name, $date, $chart_type, $data_sets);
			
			$suma_wzrost = round ( $suma_wzrost / $result->num_rows , 2 , PHP_ROUND_HALF_UP );
			$suma_waga = round ( $suma_waga / $result->num_rows , 2 , PHP_ROUND_HALF_UP );
			$suma_wzrost_tulowia = round ( $suma_wzrost_tulowia / $result->num_rows , 2 , PHP_ROUND_HALF_UP );
			$suma_stopien_dojrzalosci = round ( $suma_stopien_dojrzalosci / $result->num_rows , 2 , PHP_ROUND_HALF_UP );
			$suma_PHV = round ( $suma_PHV / $result->num_rows , 2 , PHP_ROUND_HALF_UP );
			
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
				<th>Wzrost</th>
				<th>Waga</th>
				<th>Wzrostu tułowia</th>
				<th>Stopień dojrzałości</th>
				<th>PHV</th>
			</tr>
			</thead>
			<tr>
				<td>Wartości</td>
				<td>".$suma_wzrost."</td>
				<td>".$suma_waga."</td>
				<td>".$suma_wzrost_tulowia."</td>
				<td>".$suma_stopien_dojrzalosci."</td>
				<td>".$suma_PHV."</td>
			</tr>
			</table>";	
?>