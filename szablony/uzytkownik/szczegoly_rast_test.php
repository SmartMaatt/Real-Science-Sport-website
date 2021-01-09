<?php

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
		$id_klienta = $_SESSION['id_klienta'];
		
		foreach($_POST as $key => $name)
		{
			$id_badania = $key;
		}
		$sql = "SELECT * FROM rast_test WHERE id_badania = '$id_badania'";
		if($result = @$connection->query($sql))
		{
			$row = $result->fetch_assoc();
			$pomiar1 = $row['pomiar1'];
			$pomiar2 = $row['pomiar2'];
			$pomiar3 = $row['pomiar3'];
			$pomiar4 = $row['pomiar4'];
			$pomiar5 = $row['pomiar5'];
			$pomiar6 = $row['pomiar6'];
			$pomiar7 = $row['pomiar7'];
			$srednia = ($pomiar1 + $pomiar2 + $pomiar3 + $pomiar4 + $pomiar5 + $pomiar6 + $pomiar7)/7;
			
			$name = "Rast test";
			$date = $row['data'];
			$chart_type = "bar";
			$labels = array('1','2','3','4','5','6','7','średnia');
			$data = array($pomiar1,$pomiar2,$pomiar3,$pomiar4,$pomiar5,$pomiar6,$pomiar7,$srednia);
				
			$dane_badania = array($name, $date, $chart_type, $labels, $data);	


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