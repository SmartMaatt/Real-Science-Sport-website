<?php
$connect = mysqli_connect("localhost", "root", "", "rss");

include ("../Classes/PHPExcel/IOFactory.php");
echo("<table border='1'>");
$objPHPExcel = PHPExcel_IOFactory::load('wzrostomierz.xlsx');
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
{
  $highestRow = $worksheet->getHighestRow();
  for($row=2; $row<=$highestRow; $row++)
	{
		$data = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
		$id_klienta = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
		$wzrost_tulowia = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
		if($data != null && $id_klienta != null && $wzrost_tulowia != null)
		{
			echo("<tr>");
			$query = "INSERT INTO wzrostomierz(data, id_klienta, wzrost_tulowia) VALUES ('".$data."', '".$id_klienta."','".$wzrost_tulowia."')";
			mysqli_query($connect, $query);
			echo("<td>".$data."</td>");
			echo("<td>".$id_klienta."</td>");
			echo("<td>".$wzrost_tulowia."</td>");
			echo('</tr>');
		}
	}
}
echo("</table>");
echo '<br />Data Inserted';