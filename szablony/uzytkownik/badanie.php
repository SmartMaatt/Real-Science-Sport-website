<?php
	/*SECURED*/
	if (session_status() == PHP_SESSION_NONE) {
		header('Location: ../../logowanie.php');
	}
	
	$badanie = "";
	$nazwa_badania = "";
	$ile_badan = 0;
	switch ($id_opcji)
	{
	case 1:
		$badanie = "biofeedback_eeg";
		$nazwa_badania = "Biofeedback EEG";
		break;
	case 2:
		$badanie= "analiza_skladu_ciala";
		$nazwa_badania = "Analiza składu ciała";
		break;
	case 3:
		if($_SESSION['id_podopcji'] == 1)
		{
			$badanie = "test_szybkosci"; 
			$nazwa_badania = "Test szybkości";
		}
		elseif($_SESSION['id_podopcji'] == 2)
		{
			$badanie = "rast_test"; 
			$nazwa_badania = "Rast test";
		}
		else
		{
			$badanie = "prowadzenie_pilki";
			$nazwa_badania = "Prowadzenie piłki";
		}
		break;
	case 4:
		$badanie = "analizator_kwasu_mlekowego";
		$nazwa_badania = "Analizator kwasu mlekowego";
		break;
	case 5:
		$badanie = "wzrostomierz";
		$nazwa_badania = "Wzrostomierz";
		break;
	case 6:
		$badanie = "beep_test";
		$nazwa_badania = "Beep test";
		break;
	case 7:
		$badanie = "opto_jump_next";
		$nazwa_badania = "Opto jump next";
		break;
	}
	
?>

<div class="row">
	<div class="col-12 col-md-4">
		<div class="card" >
			<div class="card-header">
			  <h2 class="card-title" id="basic-layout-tooltip">Informacje o badaniu: <?php echo $nazwa_badania;?></h2>
			   <div class="card-text">
					<p>
					
						<?php
						if(file_exists("app-assets/Opisy_badań/$nazwa_badania.txt")){
							$myfile = fopen("app-assets/Opisy_badań/$nazwa_badania.txt", "r");						
							echo nl2br(fread($myfile,filesize("app-assets/Opisy_badań/$nazwa_badania.txt")));
							fclose($myfile);
						}
						else{
							echo "Unable to open file: </br><b>$nazwa_badania.txt</b>";
						}
						?>
					
					</p>
				</div>
				<a href="index.php#Biofeedback" class="btn btn-rss">Dowiedz się więcej</a>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-8 badanie_box">
	  <div class="card">
		<div class="card-header">
		  <h4 class="card-title">Tabela badań</h4>
			<div class="card-text">
				<p>Poniższa tabela zawiera informacje o przeprowadzonych badaniach. Kliknij przycisk <b>Wyświetl szczegóły</b> by zapoznać się ze szczegółowymi danymi i wykresami.</p>
			</div>
		</div>
		<div style="padding-top:0;" class="card-body">
		  
		<?php
			require_once "rozchodniaczki/connect.php";
			
			$connection = @new mysqli($host, $db_user, $db_password, $db_name);
			
			if($connection->connect_errno!=0)
			{
				echo "Error: ".$connection->connect_errno;
			}
			else
			{
				$i = 0;
				$id_klienta = $_SESSION['id_klienta'];
				$sql = "SELECT id_badania, data FROM $badanie WHERE id_klienta = '$id_klienta'";
				if($result = @$connection->query($sql))
				{
					
					$ile_badan = $result->num_rows;
					echo '<table class="badanie_main"><tr><td>';
					echo '<table class="table bg-white">';
					echo '<thead class="thead-dark">';
					echo '<tr>';
					echo '<th scope="col">Data</th>';
					echo '<th scope="col">Szczegóły</th>';
					echo '</tr>';
					echo '</thead>';
					echo '</table>';
					
					
					
					echo '</td></tr><tr><td><div id="badanie_scroll_cont"><table class="table table-bordered bg-white">';
					
					
					$id_opcji = $_SESSION['id_opcji'];
					$id_podopcji = $_SESSION['id_podopcji'];
					for($i; $i < $result->num_rows; $i++)
					{
						$row = $result->fetch_assoc();
						$id_badania = $row['id_badania'];
						$data = $row['data'];
						echo '<tr>';
						echo "<td><p>$data</p></td>";
						echo '<td>
								<a href="rozchodniaczki/id_opcji.php?o='.$id_opcji.'&p='.$id_podopcji.'&b='.$id_badania.'" class="btn btn-rss">Wyświetl szczegóły</a>
							 </td>';
						echo '</tr>';
					}
					
					echo '</table></div></td></tr>';
					echo '</table>';
									
					$result->free_result();
				}
				
				if($i == 0){
					echo '<h1 class="no_data_msg">Brak zarejestrowanych badań</h1>';
				}
				
				$connection->close();
			}
			
		?>

		</div>
	  </div>
	</div>
</div>

<?php

if($ile_badan > 1){
	include("wykresy_porownawcze/".$badanie.".php");
}

?>