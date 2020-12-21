<?php
$connect = mysqli_connect("localhost", "root", "", "rss");

include ("../Classes/PHPExcel/IOFactory.php");
echo("<table border='1'>");
$objPHPExcel = PHPExcel_IOFactory::load('rast_test.xlsx');
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
{
  $highestRow = $worksheet->getHighestRow();
  for($row=2; $row<=$highestRow; $row++)
	{
		$data = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
		$id_klienta = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
		$pomiar1 = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
		$pomiar2 = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
		$pomiar3 = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(4, $row)->getValue());
		$pomiar4 = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(5, $row)->getValue());
		$pomiar5 = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(6, $row)->getValue());
		$pomiar6 = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(7, $row)->getValue());
		$pomiar7 = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(8, $row)->getValue());
		if($data != null && $id_klienta != null && $pomiar1 != null && $pomiar2 != null && $pomiar3 != null && $pomiar4 != null && $pomiar5 != null && $pomiar6 != null && $pomiar7 != null)
		{
			echo("<tr>");
			$query = "INSERT INTO rast_test(data, id_klienta, pomiar1, pomiar2, pomiar3, pomiar4, pomiar5, pomiar6, pomiar7) VALUES ('".$data."', '".$id_klienta."','".$pomiar1."','".$pomiar2."', '".$pomiar3."','".$pomiar4."','".$pomiar5."', '".$pomiar6."','".$pomiar7."')";
			mysqli_query($connect, $query);
			echo("<td>".$data."</td>");
			echo("<td>".$id_klienta."</td>");
			echo("<td>".$pomiar1."</td>");
			echo("<td>".$pomiar2."</td>");
			echo("<td>".$pomiar3."</td>");
			echo("<td>".$pomiar4."</td>");
			echo("<td>".$pomiar5."</td>");
			echo("<td>".$pomiar6."</td>");
			echo("<td>".$pomiar7."</td>");
			echo('</tr>');
		}
	}
}
echo("</table>");
echo '<br />Data Inserted';