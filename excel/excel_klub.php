<?php

session_start();

//Style "konsoli"
echo '<link rel="stylesheet" href="../app-assets/console.css">';
echo '<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@300;400;600&display=swap" rel="stylesheet">';

echo '<script>

document.addEventListener(\'DOMContentLoaded\', function() {
    setInterval(zmienKolorKreski, 500);
}, false);


function zmienKolorKreski() {
  var elem = document.getElementById("kryska");
  if (elem.style.opacity == \'0\') {
    elem.style.opacity = \'100\';
  } else {
    elem.style.opacity = \'0\';
  }
}
</script>';

if(isset($_SESSION['excel_plik']))
{
	$excel_plik = $_SESSION['excel_plik'];
	unset($_SESSION['excel_plik']);
	
	require_once '../rozchodniaczki/connect.php';
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	$connect = mysqli_connect($host, $db_user, $db_password, $db_name);

	include ("../Classes/PHPExcel/IOFactory.php");
	echo '<p class="orange">Rss console</p>';

	if ($connection->connect_errno == 0)
	{
		echo 'Plik excel/'.$excel_plik.' odebrany pomyslnie!</br></br>';
		echo '<p style="color:red;">Bledy przeslanego pliku:</p>';
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
		echo '<br/>------------------------------------------------------------------------</br>Dane wprowadzone do bazy</br>';
	}
	
	//Usuwanie pliku
	if(unlink($excel_plik)){
		echo '</br>Plik excel/'.$excel_plik.' został usunięty!';
	}
	else{
		echo '</br>Nie udało się usunąć excel/'.$excel_plik.'!';
	}
	echo '<p id="kryska">|</p>';
	echo '<a class="ret" href="../panel_admina.php"><= Powrot</a>';
	//header('Location: ../panel_admina.php');

}
else
{
	$_SESSION['error'] = 'loadToast(\'3\',\'Nieupoważnione wejście do pliku excel_klub.php!\',\'\')';
	header('Location: ../panel_admina.php');
}

?>	