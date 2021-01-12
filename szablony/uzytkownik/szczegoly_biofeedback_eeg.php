<?php

	/*
	JSON template
	{
		"Nazwa",
		"Data",
		"Typ wykresu",
		{"labels","tutaj"},
		{8,5,4,3,2}
	}	
	*/

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
		$sql = "SELECT * FROM biofeedback_eeg WHERE id_badania = '$id_badania'";
		if($result = @$connection->query($sql))
		{
			//Odczytaj wartości z wiersza bazy
			$row = $result->fetch_assoc();
			
			//JSON do wyświetlenia na wykresie
			$display_type = "wykres_szczegolowy";
			$name = "Biofeedback EEG";
			$date = $row['data'];
			$chart_type = "bar";
			$labels = array('delta','theta','alpha','smr','beta1','beta2','hibeta','gamma');
			$data = array($row['delta'],$row['theta'],$row['theta'],$row['smr'],$row['beta1'],$row['beta2'],$row['hibeta'],$row['gamma']);

			$dane_badania = array($display_type, $name, $date, $chart_type, $labels, $data);	
				
			$result->free_result();
		}
		$connection->close();
	}
?>

	<div class="row">
		<div class="col-12">
			<div class="card" >
				<div class="card-header">
				  <h2 class="card-title" id="basic-layout-tooltip"><?php echo $name." - badanie ".$date;?></h2>
					<div class="card-text">
						<p>Brak dodatkowych informacji na temat badania.</p>
					</div>
				</div>
				<div style="padding-top:0;" class="card-body">
					<?php
						//Canvas wykresu i przycisk powrotny
						echo "<canvas id='RSS_chart'></canvas>";
						echo '<a href="rozchodniaczki/id_opcji.php?o='.$_SESSION['id_opcji'].'&p='.$_SESSION['id_podopcji'].'&b=-1" class="btn btn-rss">Wróć</a>';
					?>
				</div>
			</div>
		</div>
	</div>
