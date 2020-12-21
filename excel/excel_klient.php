<?php
$connect = mysqli_connect("localhost", "root", "", "rss");

include ("../Classes/PHPExcel/IOFactory.php");
echo("<table border='1'>");
$objPHPExcel = PHPExcel_IOFactory::load('klient.xlsx');
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
{
  $highestRow = $worksheet->getHighestRow();
  for($row=2; $row<=$highestRow; $row++)
	{
		$imie = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
		$nazwisko = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
		$mail = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
		$haslo = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
		$plec = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(4, $row)->getValue());
		$data_urodzenia = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(5, $row)->getValue());
		$id_klubu = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(6, $row)->getValue());
		$potwierdzone = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(7, $row)->getValue());
		if($imie != null && $nazwisko != null && $mail != null && $haslo != null && $plec != null && $data_urodzenia != null && $potwierdzone)
		{
			echo("<tr>");
			$query = "INSERT INTO klient(imie, nazwisko, mail, haslo, plec, data_urodzenia, id_klubu, potwierdzone) VALUES ('".$imie."', '".$nazwisko."','".$mail."','".$haslo."', '".$plec."','".$data_urodzenia."','".$id_klubu."', '".$potwierdzone."')";
			mysqli_query($connect, $query);
			echo("<td>".$imie."</td>");
			echo("<td>".$nazwisko."</td>");
			echo("<td>".$mail."</td>");
			echo("<td>".$haslo."</td>");
			echo("<td>".$plec."</td>");
			echo("<td>".$data_urodzenia."</td>");
			echo("<td>".$id_klubu."</td>");
			echo("<td>".$potwierdzone."</td>");
			echo('</tr>');
		}
	}
}
echo("</table>");
echo '<br />Data Inserted';