<?php
$connect = mysqli_connect("localhost", "root", "", "rss");

include ("../Classes/PHPExcel/IOFactory.php");
echo("<table border='1'>");
$objPHPExcel = PHPExcel_IOFactory::load('beep_test.xlsx');
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
{
  $highestRow = $worksheet->getHighestRow();
  for($row=2; $row<=$highestRow; $row++)
	{
		$data = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
		$id_klienta = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
		$level = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
		$hr_max = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
		if($data != null && $id_klienta != null && $level != null && $hr_max != null)
		{
			echo("<tr>");
			$query = "INSERT INTO beep_test(data, id_klienta, level, hr_max) VALUES ('".$data."', '".$id_klienta."','".$level."','".$hr_max."')";
			mysqli_query($connect, $query);
			echo("<td>".$data."</td>");
			echo("<td>".$id_klienta."</td>");
			echo("<td>".$level."</td>");
			echo("<td>".$hr_max."</td>");
			echo('</tr>');
		}
	}
}
echo("</table>");
echo '<br />Data Inserted';