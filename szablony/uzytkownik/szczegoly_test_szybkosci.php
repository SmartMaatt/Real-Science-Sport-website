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
		
		foreach($_POST as $key => $name)
		{
			$id_badania = $key;
		}
		$sql = "SELECT * FROM test_szybkosci WHERE id_badania = '$id_badania'";
		if($result = @$connection->query($sql))
		{			
			//Odczytaj wartości z wiersza bazy
			$row = $result->fetch_assoc();
			$pomiar1_1 = $row['pomiar1_1'];
			$pomiar1_2 = $row['pomiar1_2'];
			$pomiar1_3 = $row['pomiar1_3'];
			$pomiar2_1 = $row['pomiar2_1'];
			$pomiar2_2 = $row['pomiar2_2'];
			$pomiar2_3 = $row['pomiar2_3'];
			$pomiar3_1 = $row['pomiar3_1'];
			$pomiar3_2 = $row['pomiar3_2'];
			$pomiar3_3 = $row['pomiar3_3'];
			$srednia1 = round ( ($pomiar1_1 + $pomiar2_1 + $pomiar3_1)/3 , 2 , PHP_ROUND_HALF_UP );
			$srednia2 = round ( ($pomiar1_2 + $pomiar2_2 + $pomiar3_2)/3 , 2 , PHP_ROUND_HALF_UP );
			$srednia3 = round ( ($pomiar1_3 + $pomiar2_3 + $pomiar3_3)/3 , 2 , PHP_ROUND_HALF_UP );
			$data_badania = $row['data'];
			
			class Dataset{}
			
			$proba1 = new Dataset();
			$proba1->label = "proba1";
			$proba1_dane = array($pomiar1_1, $pomiar1_2, $pomiar1_3);
			$proba1->data = $proba1_dane;
			
			$proba2 = new Dataset();
			$proba2->label = "proba2";
			$proba2_dane = array($pomiar2_1, $pomiar2_2, $pomiar2_3);
			$proba2->data = $proba2_dane;
			
			$proba3 = new Dataset();
			$proba3->label = "proba3";
			$proba3_dane = array($pomiar3_1, $pomiar3_2, $pomiar3_3);
			$proba3->data = $proba3_dane;
			
			$srednia = new Dataset();
			$srednia->label = "srednia";
			$srednia_dane = array($srednia1, $srednia2, $srednia3);
			$srednia->data = $srednia_dane;
			
			$odleglosci = array($row['odleglosc1'], $row['odleglosc2'], $row['odleglosc3']);
			
			//JSON do wyświetlenia na wykresie
			$display_type = "wykres_porownawczy";
			$name = "Test szybkości";
			$date = $odleglosci;
			$chart_type = "line";
			$data_sets = array($proba1, $proba2, $proba3, $srednia);
			for($j = 0; $j < count($data_sets); $j++)
			{
				$data_sets[$j]->borderColor = 'rgba('.rand(0,255).','.rand(0,255).','.rand(0,255).', 0.7)';
				$data_sets[$j]->fill = false;
			}
			
			$dane_badania = array($display_type, $name, $date, $chart_type, $data_sets);	
			$result->free_result();
		}
		
		$connection->close();
	}

?>

<div class="row">
		<div class="col-12">
			<div class="card" >
				<div class="card-header">
				  <h2 class="card-title" id="basic-layout-tooltip"><?php echo $name." - badanie ".$data_badania;?></h2>
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