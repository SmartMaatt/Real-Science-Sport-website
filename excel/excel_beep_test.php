<?php
$connect = mysqli_connect("localhost", "root", "", "rss");

include ("../Classes/PHPExcel/IOFactory.php");
require_once '../rozchodniaczki/connect.php';

$connection = @new mysqli($host, $db_user, $db_password, $db_name);

if ($connection->connect_errno == 0)
{
	echo("<table border='1'>");
	$objPHPExcel = PHPExcel_IOFactory::load('beep_test.xlsx');
	foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
	{
	  $highestRow = $worksheet->getHighestRow();
	  for($excel_row=2; $excel_row<=$highestRow; $excel_row++)
		{
			$id_klienta = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $excel_row)->getValue());
			$data = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $excel_row)->getValue());
			$level = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $excel_row)->getValue());
			$hr_max = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3, $excel_row)->getValue());
			if($data != null && $id_klienta != null && $level != null && $hr_max != null)
			{
				$sql = "SELECT COUNT(id_klienta) as ile FROM klient WHERE id_klienta = '$id_klienta'";
				$result = @$connection->query($sql);
				if($result)
				{
					$row = $result->fetch_assoc();
					if($row['ile'] == 1)
					{
						$sql = "SELECT COUNT(id_badania) as powtorzenie FROM beep_test WHERE id_klienta = '$id_klienta' AND data = '$data' AND level = '$level' AND hr_max = '$hr_max'";
						$result = @$connection->query($sql);
						if($result)
						{
							$row = $result->fetch_assoc();
							if($row['powtorzenie'] == 0)
							{
								$sql = "SELECT COUNT(id_badania) as powtorzenie FROM beep_test WHERE id_klienta = '$id_klienta' AND data = '$data' AND level = '$level' AND hr_max = '$hr_max'";
								$result = @$connection->query($sql);
								if($result)
								
								$query = "INSERT INTO beep_test(data, id_klienta, level, hr_max) VALUES ('".$data."', '".$id_klienta."','".$level."','".$hr_max."')";
								mysqli_query($connect, $query);
								echo("<tr>");
								echo("<td>".$id_klienta."</td>");
								echo("<td>".$data."</td>");
								echo("<td>".$level."</td>");
								echo("<td>".$hr_max."</td>");
								echo('</tr>');
								$sql = "UPDATE wszystkie_badania SET beep_test = 1 WHERE id_klienta = '$id_klienta'";
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
			else if($data == null && $id_klienta == null && $level == null && $hr_max == null)
				break;
			else 
				echo "Brak wszystkich danych w linii: ".$excel_row.".";
		}
	}
	echo("</table>");
	echo '<br />Data Inserted';	
}
