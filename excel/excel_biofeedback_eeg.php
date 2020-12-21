<?php
$connect = mysqli_connect("localhost", "root", "", "rss");

include ("../Classes/PHPExcel/IOFactory.php");
echo("<table border='1'>");
$objPHPExcel = PHPExcel_IOFactory::load('biofeedback_eeg.xlsx');
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
{
  $highestRow = $worksheet->getHighestRow();
  for($row=2; $row<=$highestRow; $row++)
	{
		$data = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
		$id_klienta = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
		$delta = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
		$theta = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
		$alpha = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(4, $row)->getValue());
		$smr = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(5, $row)->getValue());
		$beta1 = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(6, $row)->getValue());
		$beta2 = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(7, $row)->getValue());
		$hibeta = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(8, $row)->getValue());
		$gamma = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(9, $row)->getValue());
		if($data != null && $id_klienta != null && $delta != null && $theta != null && $alpha != null && $smr != null && $beta1 != null && $beta2 != null && $hibeta != null && $gamma != null)
		{
			echo("<tr>");
			$query = "INSERT INTO biofeedback_eeg(data, id_klienta, delta, theta, alpha, smr, beta1, beta2, hibeta, gamma) VALUES ('".$data."', '".$id_klienta."','".$delta."','".$theta."', '".$alpha."','".$smr."','".$beta1."', '".$beta2."','".$hibeta."','".$gamma."')";
			mysqli_query($connect, $query);
			echo("<td>".$data."</td>");
			echo("<td>".$id_klienta."</td>");
			echo("<td>".$delta."</td>");
			echo("<td>".$theta."</td>");
			echo("<td>".$alpha."</td>");
			echo("<td>".$smr."</td>");
			echo("<td>".$beta1."</td>");
			echo("<td>".$beta2."</td>");
			echo("<td>".$hibeta."</td>");
			echo("<td>".$gamma."</td>");
			echo('</tr>');
		}
	}
}
echo("</table>");
echo '<br />Data Inserted';