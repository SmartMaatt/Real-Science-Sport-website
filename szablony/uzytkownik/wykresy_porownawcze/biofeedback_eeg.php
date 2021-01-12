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
		$sql = "SELECT * FROM biofeedback_eeg WHERE id_klienta = '$id_klienta'";
		if($result = @$connection->query($sql))
		{
			$daty = array();
			
			class Dataset{}
			
			$delta = new Dataset();
			$delta->label = "delta";
			$delta_dane = array();
			
			$theta = new Dataset();
			$theta->label = "theta";
			$theta_dane = array();
				
			$alpha = new Dataset();
			$alpha->label = "alpha";
			$alpha_dane = array();
			
			$smr = new Dataset();
			$smr->label = "smr";
			$smr_dane = array();
			
			$beta1 = new Dataset();
			$beta1->label = "beta1";
			$beta1_dane = array();
			
			$beta2 = new Dataset();
			$beta2->label = "beta2";
			$beta2_dane = array();
			
			$hibeta = new Dataset();
			$hibeta->label = "hibeta";
			$hibeta_dane = array();
			
			$gamma = new Dataset();
			$gamma->label = "gamma";
			$gamma_dane = array();

			for($i = 0; $i < $result->num_rows; $i++)
			{
				//Odczytaj wartości z wiersza bazy
				$row = $result->fetch_assoc();
				
				array_push($daty, $row['data']);
				array_push($delta_dane, $row['delta']);
				array_push($theta_dane, $row['theta']);
				array_push($alpha_dane, $row['alpha']);
				array_push($smr_dane, $row['smr']);
				array_push($beta1_dane, $row['beta1']);
				array_push($beta2_dane, $row['beta2']);
				array_push($hibeta_dane, $row['hibeta']);
				array_push($gamma_dane, $row['gamma']);
				
			}
			$delta->data = $delta_dane;
			$theta->data = $theta_dane;
			$alpha->data = $alpha_dane;
			$smr->data = $smr_dane;
			$beta1->data = $beta1_dane;
			$beta2->data = $beta2_dane;
			$hibeta->data = $hibeta_dane;
			$gamma->data = $gamma_dane;
			
			//JSON do wyświetlenia na wykresie
			$display_type = "wykres_porownawczy";
			$name = "Biofeedback EEG";
			$date = $daty;
			$chart_type = "line";
			$data_sets = array($delta, $theta, $alpha, $smr, $beta1, $beta2, $hibeta, $gamma);

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