<?php
$connect = mysqli_connect("localhost", "root", "", "rss");

include ("../Classes/PHPExcel/IOFactory.php");
echo("<table border='1'>");
$objPHPExcel = PHPExcel_IOFactory::load('klub.xlsx');
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
{
  $highestRow = $worksheet->getHighestRow();
  for($row=2; $row<=$highestRow; $row++)
	{
		$nazwa = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
		if($nazwa != null)
		{
			echo("<tr>");
			$query = "INSERT INTO klub(nazwa) VALUES ('".$nazwa."')";
			mysqli_query($connect, $query);
			echo("<td>".$nazwa."</td>");
			echo('</tr>');
		}
	}
}
echo("</table>");
echo '<br />Data Inserted';