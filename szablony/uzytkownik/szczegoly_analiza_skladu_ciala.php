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
		$id_klienta = $_SESSION['id_klienta'];

		echo '<table>';
		echo '<tr>';
		echo '<td>x</td>';
		echo '<td>y</td>';
		echo '</tr>';
		
		foreach($_POST as $key => $name)
		{
			$id_badania = $key;
		}
		$sql = "SELECT * FROM analiza_skladu_ciala WHERE id_badania = '$id_badania'";
		if($result = @$connection->query($sql))
		{
			for($i=0; $i < $result->num_rows; $i++)
			{
				$row = $result->fetch_assoc();
				$x1 = $row['pomiar1x'];
				$y1 = $row['pomiar1y'];
				$x2 = $row['pomiar2x'];
				$y2 = $row['pomiar2y'];
				$x3 = $row['pomiar3x'];
				$y3 = $row['pomiar3y'];
				$x4 = $row['pomiar4x'];
				$y4 = $row['pomiar4y'];
				$x5 = $row['pomiar5x'];
				$y5 = $row['pomiar5y'];
				echo "<tr><td>$x1</td><td>$y1</td></tr>";
				echo "<tr><td>$x2</td><td>$y2</td></tr>";
				echo "<tr><td>$x3</td><td>$y3</td></tr>";
				echo "<tr><td>$x4</td><td>$y4</td></tr>";
				echo "<tr><td>$x5</td><td>$y5</td></tr>";
				
				//JSON do wyświetlenia na wykresie
				$display_type = "wykres_szczegolowy";
				$name = "Analiza składu ciała";
				$date = $row['data'];
				$chart_type = "bar";
				$labels = array('delta','theta','alpha','smr','beta1','beta2','hibeta','gamma');
				$data = array($row['pomiar1x'],$row['pomiar1y'],$row['pomiar2x'],$row['pomiar2y'],$row['pomiar3x'],$row['pomiar3y'],$row['pomiar4x'],$row['pomiar4y'],$row['pomiar4x'],$row['pomiar4y']);
					
				$dane_badania = array($display_type, $name, $date, $chart_type, $labels, $data);		
				$result->free_result();
			}		
			$result->free_result();
		}
		echo '</table>';
		
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