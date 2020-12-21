<?php
$connect = mysqli_connect("localhost", "root", "", "rss");

include ("../Classes/PHPExcel/IOFactory.php");
echo("<table border='1'>");
$objPHPExcel = PHPExcel_IOFactory::load('analizator_kwasu_mlekowego.xlsx');
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
{
  $highestRow = $worksheet->getHighestRow();
  for($row=2; $row<=$highestRow; $row++)
	{
		echo("<tr>");
		$data = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
		$id_klienta = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
		$stezenie = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
		if($data != null && $id_klienta != null && $stezenie != null)
		{
			$query = "INSERT INTO analizator_kwasu_mlekowego(data, id_klienta, stezenie) VALUES ('".$data."', '".$id_klienta."','".$stezenie."')";
			mysqli_query($connect, $query);
			echo("<td>".$data."</td>");
			echo("<td>".$id_klienta."</td>");
			echo("<td>".$stezenie."</td>");
			echo('</tr>');
		}
	}
}
echo("</table>");
echo '<br />Data Inserted';