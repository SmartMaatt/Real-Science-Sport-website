<?php

session_start();

if(isset($_SESSION['excel_plik']))
{
	$excel_plik = $_SESSION['excel_plik'];
	unset($_SESSION['excel_plik']);

	require_once '../rozchodniaczki/connect.php';
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	$connect = mysqli_connect($host, $db_user, $db_password, $db_name);

	include ("../Classes/PHPExcel/IOFactory.php");

	if ($connection->connect_errno == 0)
	{
		echo("<table border='1'>");
		$objPHPExcel = PHPExcel_IOFactory::load($excel_plik);
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
		{
		  $highestRow = $worksheet->getHighestRow();
		  for($excel_row=2; $excel_row<=$highestRow; $excel_row++)
			{
				$id_klienta = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $excel_row)->getValue());
				$data = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $excel_row)->getValue());
				$pomiar1 = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $excel_row)->getValue());
				$pomiar2 = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3, $excel_row)->getValue());
				$pomiar3 = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(4, $excel_row)->getValue());
				$pomiar4 = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(5, $excel_row)->getValue());
				$pomiar5 = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(6, $excel_row)->getValue());
				$pomiar6 = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(7, $excel_row)->getValue());
				$pomiar7 = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(8, $excel_row)->getValue());
				if($data != null && $id_klienta != null && $pomiar1 != null && $pomiar2 != null && $pomiar3 != null && $pomiar4 != null && $pomiar5 != null && $pomiar6 != null && $pomiar7 != null)
				{
					$sql = "SELECT COUNT(id_klienta) as ile FROM klient WHERE id_klienta = '$id_klienta'";
					$result = @$connection->query($sql);
					if($result)
					{
						$row = $result->fetch_assoc();
						if($row['ile'] == 1)
						{
							$sql = "SELECT COUNT(id_badania) as powtorzenie FROM rast_test WHERE id_klienta = '$id_klienta' AND data = '$data' AND pomiar1 = '$pomiar1' AND pomiar2 = '$pomiar2' AND pomiar3 = '$pomiar3' AND pomiar4 = '$pomiar4' AND pomiar5 = '$pomiar5' AND pomiar6 = '$pomiar6' AND pomiar7 = '$pomiar7'";
							$result = @$connection->query($sql);
							if($result)
							{
								$row = $result->fetch_assoc();
								if($row['powtorzenie'] == 0)
								{
									$query = "INSERT INTO rast_test(data, id_klienta, pomiar1, pomiar2, pomiar3, pomiar4, pomiar5, pomiar6, pomiar7) VALUES ('".$data."', '".$id_klienta."','".$pomiar1."','".$pomiar2."', '".$pomiar3."','".$pomiar4."','".$pomiar5."', '".$pomiar6."','".$pomiar7."')";
									mysqli_query($connect, $query);
									echo("<tr>");
									echo("<td>".$id_klienta."</td>");
									echo("<td>".$data."</td>");
									echo("<td>".$pomiar1."</td>");
									echo("<td>".$pomiar2."</td>");
									echo("<td>".$pomiar3."</td>");
									echo("<td>".$pomiar4."</td>");
									echo("<td>".$pomiar5."</td>");
									echo("<td>".$pomiar6."</td>");
									echo("<td>".$pomiar7."</td>");
									echo('</tr>');
									$sql = "UPDATE wszystkie_badania SET rast_test = 1 WHERE id_klienta = '$id_klienta'";
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
				else if($data == null && $id_klienta == null && $pomiar1 == null && $pomiar2 == null && $pomiar3 == null && $pomiar4 == null && $pomiar5 == null && $pomiar6 == null && $pomiar7 == null)
					break;
				else 
					echo "Brak wszystkich danych w linii: ".$excel_row.".";
			}
		}
		echo("</table>");
		echo '<br />Data Inserted';
	}
	
	//Usuwanie pliku
	if(unlink($excel_plik)){
		echo '</br>Plik excel/'.$excel_plik.' został usunięty!';
	}
	else{
		echo '</br>Nie udało się usunąć excel/'.$excel_plik.'!';
	}
	echo '</br></br><h1><a href="../panel_admina.php"><= Powrót</a></h1>';
	header('Location: ../panel_admina.php');

}
else
{
	$_SESSION['error'] = 'loadToast(\'3\',\'Nieupoważnione wejście do pliku excel_rast_test.php!\',\'\')';
	header('Location: ../panel_admina.php');
}

?>	