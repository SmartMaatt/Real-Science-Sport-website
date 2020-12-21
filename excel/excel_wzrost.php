<?php
$connect = mysqli_connect("localhost", "root", "", "rss");

include ("../Classes/PHPExcel/IOFactory.php");
echo("<table border='1'>");
$objPHPExcel = PHPExcel_IOFactory::load('wzrost.xlsx');
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
{
  $highestRow = $worksheet->getHighestRow();
  for($row=2; $row<=$highestRow; $row++)
	{
		$wartosc = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
		$data = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
		$id_klienta = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
		if($wartosc != null && $data != null && $id_klienta != null)
		{
			echo("<tr>");
			$query = "INSERT INTO wzrost(wartosc, data, id_klienta) VALUES ('".$wartosc."','".$data."', '".$id_klienta."')";
			mysqli_query($connect, $query);
			echo("<td>".$wartosc."</td>");
			echo("<td>".$data."</td>");
			echo("<td>".$id_klienta."</td>");
			echo('</tr>');
		}
	}
}
echo("</table>");
echo '<br />Data Inserted';