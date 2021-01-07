<?php
$connect = mysqli_connect("localhost", "root", "", "rss");

include ("../Classes/PHPExcel/IOFactory.php");
require_once '../rozchodniaczki/connect.php';

$connection = @new mysqli($host, $db_user, $db_password, $db_name);

if ($connection->connect_errno == 0)
{
	echo("<table border='1'>");
	$objPHPExcel = PHPExcel_IOFactory::load('wzrost.xlsx');
	foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
	{
	  $highestRow = $worksheet->getHighestRow();
	  for($excel_row=2; $excel_row<=$highestRow; $excel_row++)
		{
			$id_klienta = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $excel_row)->getValue());
			$data = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $excel_row)->getValue());
			$wartosc = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $excel_row)->getValue());
			if($wartosc != null && $data != null && $id_klienta != null)
			{
				$sql = "SELECT COUNT(id_klienta) as ile FROM klient WHERE id_klienta = '$id_klienta'";
				$result = @$connection->query($sql);
				if($result)
				{
					$row = $result->fetch_assoc();
					if($row['ile'] == 1)
					{
						$sql = "SELECT COUNT(id_wzrostu) as powtorzenie FROM wzrost WHERE id_klienta = '$id_klienta' AND data = '$data' AND wartosc = '$wartosc'";
						$result = @$connection->query($sql);
						if($result)
						{
							$row = $result->fetch_assoc();
							if($row['powtorzenie'] == 0)
							{
								$query = "INSERT INTO wzrost(wartosc, data, id_klienta) VALUES ('".$wartosc."','".$data."', '".$id_klienta."')";
								mysqli_query($connect, $query);
								echo("<tr>");
								echo("<td>".$id_klienta."</td>");
								echo("<td>".$data."</td>");
								echo("<td>".$wartosc."</td>");
								echo('</tr>');
							}
							else
								echo "Badanie w linii: ".$excel_row." już istnieje w bazie danych.";
						}
					}
					else
						echo "Brak klienta o id: ".$id_klienta.". Excel linia: ".$excel_row.".";
				}
			}
			else if($wartosc == null && $data == null && $id_klienta == null)
				break;
			else 
				echo "Brak wszystkich danych w linii: ".$excel_row.".";
		}
	}
	echo("</table>");
	echo '<br />Data Inserted';
}