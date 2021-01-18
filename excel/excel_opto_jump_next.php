<?php

session_start();

//Style "konsoli"
echo '<link rel="stylesheet" href="../app-assets/console.css">';
echo '<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@300;400;600&display=swap" rel="stylesheet">';

echo '<script>

document.addEventListener(\'DOMContentLoaded\', function() {
    setInterval(zmienKolorKreski, 500);
}, false);


function zmienKolorKreski() {
  var elem = document.getElementById("kryska");
  if (elem.style.opacity == \'0\') {
    elem.style.opacity = \'100\';
  } else {
    elem.style.opacity = \'0\';
  }
}
</script>';

if(isset($_SESSION['excel_plik']))
{
	$excel_plik = $_SESSION['excel_plik'];
	unset($_SESSION['excel_plik']);

	require_once '../rozchodniaczki/connect.php';
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	$connect = mysqli_connect($host, $db_user, $db_password, $db_name);

	include ("../Classes/PHPExcel/IOFactory.php");
	echo '<p class="orange">Rss console</p>';

	if ($connection->connect_errno == 0)
	{
		echo 'Plik excel/'.$excel_plik.' odebrany pomyslnie!</br></br>';
		echo '<p style="color:red;">Bledy przeslanego pliku:</p>';
		echo("<table border='1'>");
		$objPHPExcel = PHPExcel_IOFactory::load($excel_plik);
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
		{
		  $highestRow = $worksheet->getHighestRow();
		  for($excel_row=2; $excel_row<=$highestRow; $excel_row++)
			{
				$id_klienta = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $excel_row)->getValue());
				$data = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $excel_row)->getValue());
				$excel_row++;
				$minimum = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $excel_row)->getValue());
				$excel_row++;
				$maksimum = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $excel_row)->getValue());
				$excel_row++;
				$srednio = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $excel_row)->getValue());
				$excel_row++;
				
				if($data != null && $id_klienta != null && $minimum != null && $maksimum != null && $srednio != null)
				{
					$sql = "SELECT COUNT(id_klienta) as ile FROM klient WHERE id_klienta = '$id_klienta'";
					$result = @$connection->query($sql);
					if($result)
					{
						$row = $result->fetch_assoc();
						if($row['ile'] == 1)
						{
							$sql = "SELECT COUNT(id_badania) as powtorzenie FROM opto_jump_next WHERE id_klienta = '$id_klienta' AND data = '$data' AND minimum = '$minimum' AND maksimum = '$maksimum' AND srednio = '$srednio'";
							$result = @$connection->query($sql);
							if($result)
							{
								$row = $result->fetch_assoc();
								if($row['powtorzenie'] == 0)
								{
									$query = "INSERT INTO opto_jump_next(data, id_klienta, minimum, maksimum, srednio) VALUES ('".$data."', '".$id_klienta."','".$minimum."','".$maksimum."','".$srednio."')";
									mysqli_query($connect, $query);
									echo("<tr>");
									echo("<td>".$id_klienta."</td>");
									echo("<td>".$data."</td>");
									echo("<td>".$minimum."</td>");
									echo("<td>".$maksimum."</td>");
									echo("<td>".$srednio."</td>");
									echo('</tr>');
									$sql = "UPDATE wszystkie_badania SET opto_jump_next = 1 WHERE id_klienta = '$id_klienta'";
									$result = @$connection->query($sql);
								}
								else
									echo "Badanie w linii: ".$excel_row." już istnieje w bazie danych.";
							}
						}
						else
							echo "Brak klienta o id: ".$id_klienta.". Excel linia: ".$excel_row.".";
					}
				}
				else if($data == null && $id_klienta == null && $minimum == null && $maksimum == null && $srednio == null)
					break;
				else 
					echo "Brak wszystkich danych w linii: ".$excel_row.".";
			}
		}
		echo("</table>");
		echo '<br/>------------------------------------------------------------------------</br>Dane wprowadzone do bazy</br>';
	}
	
	//Usuwanie pliku
	if(unlink($excel_plik)){
		echo '</br>Plik excel/'.$excel_plik.' został usunięty!';
	}
	else{
		echo '</br>Nie udało się usunąć excel/'.$excel_plik.'!';
	}
	echo '<p id="kryska">|</p>';
	echo '<a class="ret" href="../panel_admina.php"><= Powrot</a>';
	//header('Location: ../panel_admina.php');

}
else
{
	$_SESSION['error'] = 'loadToast(\'3\',\'Nieupoważnione wejście do pliku excel_opto_jump_next.php!\',\'\')';
	header('Location: ../panel_admina.php');
}

?>	