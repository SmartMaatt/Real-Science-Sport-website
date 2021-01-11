<?php

session_start();

if(isset($_SESSION['excel_plik']))
{
	$excel_plik = $_SESSION['excel_plik'];
	unset($_SESSION['excel_plik']);
	
	$connect = mysqli_connect("localhost", "root", "", "rss");

	include ("../Classes/PHPExcel/IOFactory.php");
	require_once '../rozchodniaczki/connect.php';

	$connection = @new mysqli($host, $db_user, $db_password, $db_name);

	if ($connection->connect_errno == 0)
	{
		echo("<table border='1'>");
		$objPHPExcel = PHPExcel_IOFactory::load($excel_plik);
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
		{
		  $highestRow = $worksheet->getHighestRow();
		  for($excel_row=2; $excel_row<=$highestRow; $excel_row++)
			{
				$nazwa = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $excel_row)->getValue());
				if($nazwa != null)
				{
					$sql = "SELECT COUNT(id_klubu) as powtorzenie FROM klub WHERE nazwa = '$nazwa'";
					$result = @$connection->query($sql);
					if($result)
					{
						$row = $result->fetch_assoc();
						if($row['powtorzenie'] == 0)
						{
							$query = "INSERT INTO klub(nazwa) VALUES ('".$nazwa."')";
							mysqli_query($connect, $query);
							echo("<tr>");
							echo("<td>".$nazwa."</td>");
							echo('</tr>');
						}
						else
							echo "Badanie w linii: ".$excel_row." już istnieje w bazie danych.";
					}
				}
				else if($nazwa == null)
					break;
			}
		}
		echo("</table>");
		echo '<br />Data Inserted';
	}
	
	//Usuwanie pliku
	if(unlink($excel_plik)){
		echo '</br>Plik excel/'.$excel_plik.' został usunięty!';
	}
	else{
		echo '</br>Nie udało się usunąć excel/'.$excel_plik.'!';
	}
	echo '</br></br><h1><a href="../panel_admina.php"><= Powrót</a></h1>';

}
else
{
	$_SESSION['error'] = 'loadToast(\'3\',\'Nieupoważnione wejście do pliku excel_klub.php!\',\'\')';
	header('Location: ../panel_admina.php');
}

?>	